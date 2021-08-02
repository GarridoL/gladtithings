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
          <b>Register to  {{common.APP_NAME}}</b>
        </span>
        <div class="signup-holder">
          <div class="login-message-holder login-spacer text-center" v-if="errorMessage !== null">
            <span class="text-danger text-center"><b>Oops!</b> {{errorMessage}}</span>
          </div>
          <div class="login-message-holder login-spacer text-center" v-if="errorMessage2 !== null">
            <span class="text-danger text-center"><b>Oops!</b> {{errorMessage2}}</span>
          </div>
          <div class="login-message-holder login-spacer text-center" v-if="errorMessage3 !== null">
            <span class="text-danger text-center"><b>Oops!</b> {{errorMessage3}}</span>
          </div>
          <div class="login-message-holder login-spacer text-center" v-if="errorMessage4 !== null">
            <span class="text-danger text-center"><b>Oops!</b> {{errorMessage4}}</span>
          </div>
          <div class="login-message-holder login-spacer text-center" v-if="errorMessage5 !== null">
            <span class="text-danger text-center"><b>Oops!</b> {{errorMessage5}}</span>
          </div>
          <div class="login-message-holder login-spacer text-center" v-if="errorMessage6 !== null">
            <span class="text-danger text-center"><b>Oops!</b> {{errorMessage6}}</span>
          </div>
          <div class="login-message-holder login-spacer text-center" v-if="errorMessage7 !== null">
            <span class="text-danger text-center"><b>Oops!</b> {{errorMessage7}}</span>
          </div>
          <div class="login-message-holder login-spacer text-center" v-if="successMessage !== null">
            <span class="text-success text-center"><b>Wow!</b> {{successMessage}}</span>
          </div>
          <div>
            <div class="input-group login-spacer">
              <input v-on:keyup="validate('username')" type="text" class="form-control form-control-login" placeholder="Username" aria-describedby="addon-1" v-model="username">
            </div>
            <div class="input-group login-spacer">
              <input v-on:keyup="validate('email')" type="text" class="form-control form-control-login" placeholder="Email" aria-describedby="addon-1" v-model="email">
            </div>
            <div class="input-group">
                <input v-on:keyup="validate('password')" class="form-control form-control-login" type="password" placeholder="Password" aria-describedby="addon-2" v-model="password">
            </div>
            <div class="input-group login-spacer">
                <input v-on:keyup="validate('cpassword')" class="form-control form-control-login" type="password" placeholder="Confirm Password" aria-describedby="addon-2" v-model="cpassword">
            </div>
            <button class="btn btn-secondary login-spacer register-button" v-on:click="signUp()">Signup</button>
            <br><br><br><br>
            <div style="width: 100%;text-align: center;">
              <p class="account">Have an account?</p>
            </div>
            <hr>
            <button class="btn btn-primary login-spacer register-button" v-on:click="redirect('/login')">Login</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.signup-container, .holder{
  margin-top: 25px;
  min-height: 85vh;
}

.account {
  color: $primary;
}


.form-control-login{
  height: 45px !important;
  border-radius: 30px;
  border: 1px solid rgb(219, 218, 218);
  border-width: .5px;
  margin-bottom: 5px;
}

.register-button {
  border-radius: 30px;
  float: right;
  width: 100px;
}

.login-wrapper{
  width: 50%;
}

.tag-line{
  width: 70%;
  background-color: rgb(255, 255, 255);
	border-radius: 15px;
  padding: 60px;
  float: right;
  margin-right: 10%;
}

.signup-header{
  height: 100px;
  color: #006600;
  width: 100%;
  float: left;
  text-align: center;
}
.signup-header img{
  height: 100px !important;
  width: auto !important;
}

.signup-header img:hover{
  cursor: pointer;
}

.header-title{
  width: 90%;
  margin:  25px 5% 0 5%;
  font-size: 24px;
  font-weight: 700px;
}

.signup-holder{
  width: 90%;
  margin: 0 5% 0 5%;
  float: left;
}

.input-holder{
  width: 90%;
  margin:  0 5% 0 5%;
}

.form-control{
  height: 45px !important;
}
.btn{
  height: 50px !important;
}
.input-group{
  margin-top: 5px;
  margin-bottom: 5px;
}
.site-title{
  margin-top: 25px;
  width: 100%;
  float: left;
}
.site-title img{
  width: 50px;
  width: 50px;
  float: left;
  margin-right: 10px;
}
.site-title .app-name{
  float: left;
}

.account-type{
  width: 120px !important;
}

.options{
  width: 90%;
  margin:  0 5% 0 5%;
  float: left;
}
.options button{
  width: 49% !important;
  float: left !important;
  height: 60px !important;
}
.input-group label{
  width: 100%;
  float: left;
  line-height: 50px;
  text-align: center;
}

.input-group-addon{
  width: 15% !important;
  text-align: center !important;
  padding: 0px !important;
  display: block !important;
  line-height: 43px !important;
}

.input-group label b:hover{
  cursor: pointer;
}
/*-------------- Extra Small Screen for Mobile Phones --------------*/
@media (max-width: 991px){
  .custom-holder{
    box-shadow: 0 0 0 0 #fff !important;
    margin-top: 50px !important;
  }
}
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import COMMON from 'src/common.js'
export default {
  mounted(){
    // this.getSchools()
  },
  data(){
    return {
      username: '',
      email: '',
      password: '',
      cpassword: '',
      type: 'USER',
      errorMessage: null,
      errorMessage2: null,
      errorMessage3: null,
      errorMessage4: null,
      errorMessage5: null,
      errorMessage6: null,
      errorMessage7: null,
      successMessage: null,
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      schools: null,
      schoolIndex: null,
      config: CONFIG,
      common: COMMON,
      visibility: 'password',
      visibilityC: 'password'
    }
  },
  methods: {
    showPassword(pass) {
      if(pass === 'password'){
        this.visibility = 'text'
      } else {
        this.visibilityC = 'text'
      }
    },
    hidePassword(pass) {
      if(pass === 'cpassword'){
        this.visibilityC = 'password'
      } else {
        this.visibility = 'password'
      }
    },
    signUp(){
      this.validate('email')
      this.validate('username')
      this.validate('password')
      this.validate('cpassword')
      let parameter = {
        username: this.username,
        email: this.email,
        password: this.password,
        config: CONFIG,
        account_type: this.type,
        referral_code: null,
        status: 'ADMIN'
      }
      if(this.errorMessage === null && this.errorMessage2 === null && this.errorMessage3 === null && this.errorMessage4 === null && this.errorMessage5 === null && this.errorMessage6 === null && this.errorMessage7 === null){
        $('#loading').css({'display': 'block'})
        this.APIRequest('accounts/create', parameter).then(response => {
          $('#loading').css({'display': 'none'})
          if(response.error !== null){
            if(response.error.status === 100){
              let message = response.error.message
              if(typeof message.username !== undefined && typeof message.username !== 'undefined'){
                this.errorMessage = message.username[0]
              }else if(typeof message.email !== undefined && typeof message.email !== 'undefined'){
                this.errorMessage = message.email[0]
              }
            }else if(response.data !== null){
              if(response.data > 0){
                this.login()
              }
            }
          }
        })
      }
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    strong(){
      this.successMessage = 'Strong password.'
    },
    validate(input){
      this.successMessage = null
      let reqWhiteSpace = /\s/
      if(input === 'username') {
        this.errorMessage = null
        if(reqWhiteSpace.test(this.username)){
          this.errorMessage = 'Username should not contain a space.'
        } else if(this.username.length < 6){
          this.errorMessage2 = 'Username must be atleast 6 characters.'
        } else {
          this.errorMessage = null
          this.errorMessage2 = null
        }
      } else if(input === 'email') {
        this.errorMessage3 = null
        if(AUTH.validateEmail(this.email) === false){
          this.errorMessage3 = 'You have entered an invalid email address.'
        } else {
          this.errorMessage3 = null
        }
      } else if(input === 'password') {
        this.errorMessage4 = null
        if(this.password.length < COMMON.passwordLimit){
          this.errorMessage4 = 'Password must be atleast ' + COMMON.passwordLimit + ' characters.'
        }else if(/^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/.test(this.password)){
          this.strong()
          this.errorMessage4 = null
          this.errorMessage5 = null
        } else {
          this.errorMessage5 = 'Password must be alphanumeric characters. It should contain 1 number, 1 special character and 1 capital letter.'
        }
      } else if(input === 'cpassword') {
        this.errorMessage6 = null
        this.successMessage = null
        if(this.password.localeCompare(this.cpassword) !== 0){
          this.errorMessage6 = 'Password did not match.'
        } else {
          this.errorMessage6 = null
        }
      } else if(this.username.length >= 6 && this.email !== null && this.password !== null && this.password.length >= 6 && this.password.localeCompare(this.cpassword) === 0 && this.type !== null && AUTH.validateEmail(this.email) === true){
        this.errorMessage = null
      }else{
        this.errorMessage7 = 'Please fill in all required fields.'
        this.errorMessage7 = null
      }
    },
    login(){
      AUTH.authenticate(this.username, this.password, (response) => {
        ROUTER.push('dashboard')
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
    },
    openModal(id){
      $(id).modal('show')
    }
  }
}
</script>
