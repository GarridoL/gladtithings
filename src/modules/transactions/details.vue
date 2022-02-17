<template>
  <div class="container">
    <div class="row">
      <i class="fas fa-chevron-left icon-back" @click="back()"></i>
      <span style="font-size: 20px;"><b>Transaction Details</b></span>
    </div>

    <div v-if="data">
      <p :class="data && data.amount > 0 ? 'amount' : 'less-amount'">{{data.amount}}</p>
      <p class="title"><b>{{data.currency}}</b></p>
      <p class="title">{{data.created_at_human}}</p>
      <p class="title" style="font-style: italic;"><b>"{{data.description}}"</b></p>
    </div>

    <div class="row" v-if="data">
      <div class="column data-col">
        <p class="title with-border"><b>More Details</b></p>
        <p class="title">Trasaction #:</p>
        <p class="title">Trasaction Type:</p>
        <p class="title with-border" v-if="data.other_details && data.other_details.account"><b>{{data.other_details ? data.other_details.type === 'receive' ? 'From' : 'To' : 'From'}}</b></p>
        <p class="title" v-if="data.other_details && data.other_details.account">Account Code:</p>
      </div>
      <div class="column data-col">
        <p class="title with-border"><b>&nbsp;</b></p>
        <p class="title" v-if="data && data.code">****{{data.code.substring(data.code.length - 4, data.code.length)}}</p>
        <p class="title">{{data.description.toUpperCase()}}</p>
        <p class="title with-border" v-if="data.other_details && data.other_details.account"><b>&nbsp;</b></p>
        <p class="title" v-if="data.other_details && data.other_details.account">****{{data.other_details.account.code.substring(data.other_details.account.code.length - 4, data.other_details.account.code.length)}}</p>
      </div>
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'

import AUTH from 'src/services/auth'
export default{
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      data: null
    }
  },
  methods: {
    back() {
      ROUTER.push('/transactions')
    },
    retrieve(){
      console.log(this.$route.params)
      if(this.$route.params){
        let parameter = {
          condition: [{
            column: 'id',
            value: this.$route.params.id,
            clause: '='
          }, {
            column: 'account_id',
            value: this.user.userID,
            clause: '='
          }],
          sort: {created_at: 'asc'},
          limit: 1,
          offset: 0
        }
        $('#loading').css({display: 'block'})
        this.APIRequest('ledger/transaction_history', parameter).then(response => {
          $('#loading').css({display: 'none'})
          console.log(response)
          if(response.data.length > 0) {
            try{
              response.data[0]['other_details'] = JSON.parse(response.data[0].details)
            } catch(e) {
              console.log(e)
            }
            this.data = response.data[0]
            console.log(this.data)
          }
        })
      }
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container{
  width: 60%;
  margin-top: 30px;
  margin-bottom: 50px;
  align-items: center;
  text-align: center;
}
.amount{
  font-size: 40px;
  color: $primary;
}
.less-amount{
  font-size: 40px;
  color: $danger;
}
.data-col{
  width: 50%;
}
.title{
  margin-top: 20px;
}
p{
  margin: 0;
}
.with-border {
  border-bottom: rgb(230, 230, 230) 1px solid;
  padding-bottom: 10px;
}
.icon-back{
  font-size: 20px;
  cursor: pointer;
  margin-right: 10px;
  margin-top: 4px;
  color: gray
}
@media (max-width: 992px){
  .container{
    width: 100%;
  }
}
</style>
