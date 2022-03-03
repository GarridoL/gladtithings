<template>
  <div class="mx-auto holder row" style="justify-content: center; align-items: center;">
    <div class="login-wrapper column">
      <div style="padding: 60px;text-align: center;">
        <p style="font-size: 25px; color: white;">Glad Tithings Tagline here</p>
        <p style="color: white; text-align: justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
      </div>
    </div>
    <div class="login-wrapper column">
      <div class="tag-line">
        <span style="width:100%;float:left;text-align:center;font-size:17px;margin-bottom:20px;">
          <b>Login to {{common.APP_NAME}}</b>
        </span>
        <div class="login-message-holder login-spacer text-center" v-if="errorMessage != null">
          <span class="text-danger text-center"><b>Oops!</b> {{errorMessage}}</span>
        </div>
        <div>
          <div class="input-group login-spacer">
            <div class="input-group">
              <input type="text" class="form-control form-control-login" placeholder="Username or Email Adress" aria-describedby="addon-1" v-model="username">
            </div>
          </div>
          <div class="input-group login-spacer">
            <div class="input-group">
              <input class="form-control form-control-login" type="password" placeholder="Password" v-model="password" @keyup.enter="logIn()">
            </div>
          </div>
          <div class="row" style="width: 100%; margin: 0 auto;">
            <div class="column" style="width: 50%; margin: 0;margin-top: 20px; margin-top: 25px;">
              <p class="login-spacer forgot" v-on:click="redirect('/request_reset_password')"><b>Forgot your Password?</b></p>
            </div>
            <div class="column" style="width: 50%;margin-top: 10px;">
              <button class="btn btn-secondary login-spacer login-button" v-on:click="logIn()">Login</button>
            </div>
          </div>
          <br>
          <div style="width: 100%;text-align: center;">
            <p class="account">Don't have an account?</p>
          </div>
          <hr>
          <button class="btn btn-primary login-spacer register-button" v-on:click="redirect('/signup')">Register</button>
        </div>
      </div>
    </div>
    <authenticate-otp ref="authenticateOTP"></authenticate-otp>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.holder{
  min-height: 88.9vh;
}

.account {
  color: $primary;
}

.login-button {
  border-radius: 30px;
  float: right;
  width: 100px;
}

.register-button {
  border-radius: 30px;
  float: right;
  width: 100px;
}

.bg-primary{
  background: $primary !important; 
}

.login-wrapper{
  width: 50%;
}

.tag-line{
  width: 50%;
  background-color: rgb(255, 255, 255);
	border-radius: 15px;
  padding: 60px;
  float: right;
  margin-right: 10%;
}

.login-header{
  height: 100px;
  color: #006600;
  width: 100%;
  float: left;
  text-align: center;
}

.login-header img{
  height: 100px !important;
  width: auto !important;
}

.login-header img:hover, .forgot{
  cursor: pointer;
}

.login-message-holder{
  min-height: 30px;
  font-size: 12px;
  float: left;
  overflow: hidden;
}

.login-spacer{
  margin-bottom: 10px;
}/*-- login-spacer --*/

.forgot-password a{
  color: #006600 !important;
}
.forgot-password a:hover{
  cursor: pointer !important;
  text-decoration: underline !important;
  color: #009900 !important;
}

.btn{
  height: 40px !important;
}

.input-group-addon{
  width: 15% !important;
  text-align: center !important;
  padding: 0px !important;
  display: block !important;
  line-height: 43px !important;
}

.form-control-login{
  height: 45px !important;
  border-radius: 30px;
  border: 1px solid rgb(219, 218, 218);
  border-width: .5px;
  margin-bottom: 5px;
}

/*    Line with text on top  */
.separator>*{
  display: inline-block;
  vertical-align: middle;
}

.separator {
    text-align: center;
    border: 0;
    white-space: nowrap;
    display: block;
    overflow: hidden;
    padding: 0;
    margin: 0;
}

.separator:before, .separator:after {
    content: "";
    height: 1px;
    width: 50%;
    background-color: #ccc;
    margin: 0 5px 0 5px;
    display: inline-block;
    vertical-align: middle;
}

.separator:before {
    margin-left: -100%;
}

.separator:after {
    margin-right: -100%;
}

@media (max-width: 992px){
  .login-wrapper{
    width: 96%;
    margin: 0 2% 0 2%;
  }
  .tag-line{
    width: 100%;
    background-color: rgb(255, 255, 255);
    border-radius: 15px;
    padding: 60px;
    margin-right: 0%;
  }
}
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import COMMON from 'src/common.js'
export default {
  mounted(){
  },
  data(){
    return {
      username: null,
      password: null,
      errorMessage: null,
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      otpCode: null,
      otpErrorCode: null,
      common: COMMON,
      visibility: 'password'
    }
  },
  components: {
    'authenticate-otp': require('components/increment/generic/otp/Otp.vue')
  },
  methods: {
    showPassword() {
      this.visibility = 'text'
    },
    hidePassword() {
      this.visibility = 'password'
    },
    logIn(){
      if(this.username !== null && this.username !== '' && this.password !== null && this.password !== ''){
        $('#loading').css({'display': 'block'})
        AUTH.authenticate(this.username, this.password, (response) => {
          this.errorMessage = null
          $('#loading').css({'display': 'none'})
          AUTH.tokenData.loading = true
        }, (response, status) => {
          $('#loading').css({'display': 'none'})
          if(status === 401){
            this.errorMessage = 'Username and Password did not match.'
          }else if(status === 402){
            this.errorMessage = response.error
          }else{
            this.errorMessage = 'Cannot log in? Contact us through email: ' + this.common.APP_EMAIL
          }
        })
      }else{
        $('#loading').css({'display': 'none'})
        this.errorMessage = 'Please fill up all the required fields.'
      }
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    request(parameter){
      this.APIRequest(parameter, {}).then(response => {
      })
    },
    cancelOTP(){
      AUTH.deaunthenticate()
      $('#authenticateOTP').modal('hide')
    },
    successOTP(){
      AUTH.proceedToLogin()
      $('#authenticateOTP').modal({
        backdrop: 'static',
        keyboard: false,
        show: false
      })
    }
  }
}
</script>
