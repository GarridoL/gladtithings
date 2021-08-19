<template>
  <div class="container">
   <h3 style="margin-left: -10px;">Notification Settings</h3>
   <div v-for="(item, index) in list" :key="index">
    <Cards
      :title="item.title"
      :description="item.description"
      :route="item.route"
      :version="2"
      :toggle="item.toggle"
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
          title: 'Email Login',
          description: 'Receives email address every time theres a login of the account',
          toggle: false
        },
        {
          title: 'Email OTP',
          description: 'OTP will be sent to your email address',
          toggle: true
        },
        {
          title: 'SMS OTP',
          description: 'OTP will be sent to you via SMS using your registered mobile number',
          toggle: true
        },
        {
          title: 'Subscribe to get our latest udpates',
          description: 'Receives events, and many more to your registered email address',
          toggle: false
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
