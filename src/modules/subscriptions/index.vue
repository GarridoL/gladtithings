<template>
  <div class="container">
   <h3 style="margin-left: -10px;">Subscription Settings</h3>
   <div>
    <p style="color: red;" v-if="errorMessage">{{errorMessage}}</p>
   </div>
    <Cards
      :title="title"
      :description="description"
      :route="''"
      :version="2"
      :toggle="toggle"
      @click_toggle="update"
      :payload="''"
    />
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Cards from 'src/modules/settings/CardSettings.vue'
export default{
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      title: 'Subscription',
      description: 'Manage your subscription here.',
      toggle: false,
      errorMessage: null
    }
  },
  components: {
    Cards
  },
  methods: {
    update() {
      if(this.user.merchant === null) {
        this.errorMessage = 'Please setup your church account first.'
        return
      } else {
        this.errorMessage = null
      }
      let parameter = {
        id: this.user.merchant.id,
        addition_informations: !this.toggle ? 'subscription-enabled' : 'subscription-disabled'
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('account_merchants/update', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data) {
          this.toggle = !this.toggle
        }
      })
    },
    retrieve() {
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('account_merchants/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.toggle = response.data[0].addition_informations === 'subscription-enabled'
        }
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container{
  width: 60%;
  margin-top: 15px;
  margin-bottom: 50px;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
