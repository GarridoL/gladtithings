<template>
  <div class="container">
   <h3 style="margin-left: -10px;">Settings</h3>
   <div v-for="(item, index) in list" :key="index">
    <Cards
      :title="item.title"
      :description="item.description"
      :route="item.route"
      :version="1"
    />
   </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Cards from 'src/modules/settings/CardSettings.vue'
export default{
  mounted(){},
  data(){
    return {
      user: AUTH.user,
      list: [
        {
          title: 'Account Settings',
          description: 'Receives email address every time theres a login of the account',
          route: '/account_settings'
        },
        {
          title: 'Church Details',
          description: 'OTP will be sent to your email address',
          route: '/church_details'
        },
        {
          title: 'Subscriptions',
          description: 'OTP will be sent to your email address',
          route: '/subscriptions'
        },
        {
          title: 'Notification Settings',
          description: 'OTP will be sent to you via SMS using your registered mobile number',
          route: '/notification_settings'
        },
        {
          title: 'Payment Methods',
          description: 'Receives events and many more to your registered email address',
          route: '/payment_methods'
        }
      ]
    }
  },
  components: {
    Cards
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container{
  width: 70%;
  margin-top: 15px;
  margin-bottom: 50px;
}
@media (max-width: 992px){
  .container{
    width: 70%;
  }
}
</style>
