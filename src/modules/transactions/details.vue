<template>
  <div class="container">
    <div class="row">
      <i class="fas fa-chevron-left icon-back" @click="back()"></i>
      <span style="font-size: 20px;"><b>Transaction Details</b></span>
    </div>
    <div class="row">
      <p class="title">Here are the further details about this transactions.</p>
    </div>
    <div class="row" v-if="data">
      <div class="column data-col">
        <p class="title"><b>Date</b></p>
        <p>{{data.created_at_human}}</p>
        <p class="title"><b>Trasaction Type</b></p>
        <p>{{data.description}}</p>
        <p class="title"><b>{{data.other_details ? data.other_details.type === 'receive' ? 'Sender' : 'Receiver' : 'Sender'}}</b></p>
        <p>{{data.other_details ? data.other_details.account.id : 'Own transaction'}}</p>
      </div>
      <div class="column data-col">
        <p class="title"><b>Amount</b></p>
        <p>{{data.currency}} {{data.amount}}</p>
        <p class="title"><b>Trasaction Reference</b></p>
        <p>{{data.code.substring(4)}}</p>
        <p class="title"><b>Sender Address</b></p>
        <p>address</p>
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
.icon-back{
  font-size: 20px;
  cursor: pointer;
  margin-right: 10px;
  margin-top: 4px;
  color: gray
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
