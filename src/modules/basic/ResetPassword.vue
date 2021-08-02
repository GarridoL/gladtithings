<template>
  <div class="row holder" style="justify-content: center; align-items: center;">
    <div class="tag-line">
      <span style="width:100%;float:left;text-align:center;font-size:20px;margin-bottom:20px;">
        <b>Reset Password</b>
      </span>
      <div class="input-holder">
        <div class="login-message-holder login-spacer" v-if="errorMessage != '' && updateFlag === false">
            <span class="text-danger text-center" v-if="errorMessage !== null"><b>Oops!</b> {{errorMessage}}</span>
        </div>
        <div class="login-message-holder login-spacer" v-if="updateFlag === true">
            <span class="text-center">Your password was successully updated! To login click the button below.</span>
        </div>
        <div class="input-group form-spacer" v-if="updateFlag === false">
          <input :type="visibility" class="form-control form-control-login" placeholder="New Password" aria-describedby="addon-2" v-model="password">
        </div>
        <div class="input-group form-spacer" v-if="updateFlag === false">
          <input :type="visibilityC" class="form-control form-control-login" placeholder="Confirm New Password" aria-describedby="addon-2" v-model="cPassword">
        </div>
        <br>
        <button class="btn btn-secondary continue-button login-spacer" v-on:click="reset()" v-if="updateFlag === false">Continue</button>
        <br><br><br><br>
        <div style="width: 100%;text-align: center;">
          <p class="account">Cancel?</p>
        </div>
        <hr> 
        <button class="btn btn-primary back-button login-spacer" @click="redirect('/login')">Back to login</button>
     </div>
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.form-control-login {
  margin-top: 10px;
  height: 45px !important;
  border-radius: 30px;
  border: 1px solid rgb(219, 218, 218);
  border-width: .5px;
  margin-bottom: 5px;
}

.back-button {
  border-radius: 30px;
  float: right;
  width: 120px;
}

.account {
  color: $primary;
}

.tag-line{
  width: 35%;
  background-color: rgb(255, 255, 255);
  border-radius: 15px;
  padding: 30px;
}

.continue-button {
  border-radius: 30px;
  float: right;
  width: 120px;
  margin-bottom: 20px;
}

.holder{
  margin-top: 25px;
  height: 85vh;
}

.custom-holder{
  margin-top: 100px;
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
  margin-left: 5%;
}
.site-title .app-name{
  float: left;
}
.recover-addon{
  width: 170px;
}
.form-spacer{
  margin-top: 10px;
}

.input-group label{
  width: 100%;
  float: left;
  line-height: 50px;
  text-align: center;
}

.input-group label b:hover{
  cursor: pointer;
}

.input-group-addon{
  width: 15% !important;
  text-align: center !important;
  padding: 0px !important;
  display: block !important;
  line-height: 43px !important;
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
  name: '',
  mounted(){
    this.code = this.$route.params.code
    this.username = this.$route.params.username
  },
  data(){
    return{
      email: null,
      flag: false,
      errorMessage: null,
      password: null,
      cPassword: null,
      code: this.$route.params.code,
      username: this.$route.params.username,
      updateFlag: false,
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
    reset(){
      this.validate()
      if(this.flag === true){
        let parameter = {
          'username': this.username,
          'code': this.code,
          'password': this.password
        }
        $('#loading').css({display: 'block'})
        this.APIRequest('accounts/update', parameter).then(response => {
          $('#loading').css({display: 'none'})
          if(response.data === true){
            this.updateFlag = true
          }else{
            this.updateFlag = false
          }
        })
      }
    },
    validate(){
      if(this.password === null || this.password === '' || this.cPassword === null || this.cPassword === ''){
        this.flag = false
        this.errorMessage = 'Please fill in all required fields.'
      }else if(this.password !== this.cPassword){
        this.flag = false
        this.errorMessage = 'Please confirm your new password.'
      }else if(this.password.length < 8){
        this.flag = false
        this.errorMessage = 'Password length must be greater than 8 digit characters.'
      }else if(/^[a-zA-Z0-9]+$/.test(this.password)){
        this.flag = false
        this.errorMessage = 'Password must be alphanumeric characters. It should contain 1 number, 1 special character and letters.'
      }else{
        this.flag = true
        this.errorMessage = null
      }
    },
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
