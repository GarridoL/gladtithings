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
      @click_toggle="update"
      :payload="item.payload"
    />
   </div>
  </div>
</template>
<script>
import AUTH from 'src/services/auth'
import Cards from 'src/modules/settings/CardSettings.vue'
export default{
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      list: [
        {
          title: 'Email Login',
          description: 'Receives email address every time theres a login of the account',
          toggle: false,
          route: '',
          payload: 'email_login'
        },
        {
          title: 'Email OTP',
          description: 'OTP will be sent to your email address',
          toggle: false,
          route: '',
          payload: 'email_otp'
        },
        {
          title: 'SMS OTP',
          description: 'OTP will be sent to you via SMS using your registered mobile number',
          toggle: false,
          route: '',
          payload: 'sms_otp'
        },
        {
          title: 'Subscribe to get our latest udpates',
          description: 'Receives events, and many more to your registered email address',
          toggle: false,
          route: '',
          payload: 'sms_login'
        }
      ],
      id: null
    }
  },
  components: {
    Cards
  },
  methods: {
    update(index, payload){
      let parameter = {
        id: this.id
      }
      parameter[payload] = index ? 1 : 0
      $('#loading').css({display: 'block'})
      this.APIRequest('notification_settings/update', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.retrieve()
      })
    },
    create() {
      let parameter = {
        email_login: 0,
        email_otp: 0,
        sms_otp: 0,
        sms_login: 0,
        code: 0,
        account_id: this.user.userID,
        email_pin: 0,
        devices: 0
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('notification_settings/create', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.retrieve()
      })
    },
    retrieve() {
      let parameter = {
        condition: [
          {
            clause: '=',
            column: 'account_id',
            value: this.user.userID
          }
        ]
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('notification_settings/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0) {
          let data = response.data[0]
          this.list[0].toggle = data.email_login > 0
          this.list[1].toggle = data.email_otp > 0
          this.list[2].toggle = data.sms_otp > 0
          this.list[3].toggle = data.sms_login > 0
          this.id = data.id
        } else {
          this.create()
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
