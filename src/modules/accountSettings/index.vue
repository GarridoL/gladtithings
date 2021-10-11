<template>
  <div class="container" :style="fromProfile === true ? 'width: 90%;' : 'width: 60%;'">
   <h3>Account Settings</h3>
    <span class="error text-danger" v-if="errorMessage1 !== null">
      <b>Oops!</b> {{errorMessage1}}
    </span>
    <span class="error text-danger" v-if="errorMessage2 !== null">
      <b>Oops!</b> {{errorMessage2}}
    </span>
    <span class="error text-success" v-if="successMessage1 !== null">
      {{successMessage1}}
    </span>
    <div class="row" style="width: 100%; margin-top: 10px;">
      <div class="column" style="width: 70%; margin-right: 10%;">
        <div class="input-container">
          <label><b>Username&nbsp;</b><span style="color: red;">*</span></label><br>
          <input placeholder="Username" class="generic-input" v-model="username" disabled>
        </div>
        <div class="input-container">
          <label><b>Email&nbsp;</b><span style="color: red;">*</span></label><br>
          <input placeholder="Email" class="generic-input" v-model="email">
        </div>
        <h3 style="margin-left: 2%;">Security</h3>
        <div class="input-container">
          <label><b>Password&nbsp;</b><span style="color: red;">*</span></label><br>
          <input type="password" placeholder="Password" class="generic-input" v-model="password" v-on:key-up="validate()">
        </div>
        <div class="input-container">
          <label><b>Confirm Password&nbsp;</b><span style="color: red;">*</span></label><br>
          <input type="password" placeholder="Confirm Password" class="generic-input" v-model="confirm_password" :disabled="!validate()">
        </div>
      </div>
      <div class="column" style="width: 20%; text-align: center;">
        <span class="image" v-if="user.profile !== null" >
          <img :src="config.BACKEND_URL + user.profile.url" style="background-size: cover; border-radius: 100px;"  height="160px" width="160px" >
        </span>
        <div class="no-image" v-else>
        </div>
        <p style="cursor: pointer; margin-top: 10px;" @click="showImages()">Click to edit profile</p>
      </div>
   </div>
   <button class="text-center sort-button" @click="updateAccount()">Update</button>
   <h3>Account Information</h3>
    <span class="error text-danger" v-if="errorMessage !== null">
      <b>Oops!</b> {{errorMessage}}
    </span>
    <span class="error text-success" v-if="successMessage !== null">
      {{successMessage}}
    </span>
   <div class="row" style="width: 100%; margin-top: 10px;">
      <div class="column" style="width: 33%;">
      <div class="input-containers">
        <label><b>First Name&nbsp;</b><span style="color: red;">*</span></label><br>
        <input placeholder="First Name" class="generic-input" v-model="first_name">
      </div>
      </div>
      <div class="column" style="width: 33%; text-align: center;">
      <div class="input-containers">
        <label><b>Middle Name&nbsp;</b></label><br>
        <input placeholder="Middle Name" class="generic-input" v-model="middle_name">
      </div>
      </div>
      <div class="column" style="width: 33%; text-align: center;">
       <div class="input-containers">
        <label><b>Last Name&nbsp;</b><span style="color: red;">*</span></label><br>
        <input placeholder="Last Name" class="generic-input" v-model="last_name">
      </div>
      </div>
   </div>
   <button class="text-center sort-button" @click="updateAccountInformation()">Update</button>
   <browse-images-modal :object="user.profile" v-if="user.profile !== null"></browse-images-modal>
  <browse-images-modal :object="newProfile" v-if="user.profile === null"></browse-images-modal>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import COMMON from 'src/common.js'
export default{
  props: ['fromProfile'],
  mounted(){
    this.retrieveAccount()
    this.retrieveAccountInformation()
  },
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
      ],
      username: null,
      email: null,
      first_name: null,
      middle_name: null,
      last_name: null,
      password: null,
      confirm_password: null,
      account_information_id: null,
      errorMessage: null,
      errorMessage2: null,
      successMessage: null,
      errorMessage1: null,
      successMessage1: null,
      newProfile: {
        account_id: null,
        url: null
      },
      config: CONFIG
    }
  },
  components: {
    'browse-images-modal': require('components/increment/generic/image/BrowseModal.vue')
  },
  methods: {
    validate(){
      if(this.password !== null && this.password !== '') {
        if(/^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/.test(this.password) || this.password.length >= COMMON.passwordLimit) {
          this.errorMessage1 = null
          return true
        } else {
          this.errorMessage1 = `Password must be atleast ${COMMON.passwordLimit} characters and must contain at least one (1) uppercase character, one (1) number and one (1) special character.`
          this.successMessage1 = null
          this.successMessage = null
          return false
        }
      } else {
        return false
      }
    },
    updatePhoto(object){
      $('#loading').css({'display': 'block'})
      this.APIRequest('account_profiles/update', object).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data === true){
          this.hideImages()
          this.retrieve()
          AUTH.checkAuthentication()
        }
      })
    },
    createPhoto(object){
      this.APIRequest('account_profiles/create', object).then(response => {
        if(response.data > 0){
          this.hideImages()
          AUTH.checkAuthentication()
        }
      })
    },
    manageImageUrl(url){
      if(this.user.profile !== null){
        this.user.profile.url = url
        this.updatePhoto(this.user.profile)
      }else{
        this.newProfile.account_id = this.user.userID
        this.newProfile.url = url
        this.createPhoto(this.newProfile)
      }
    },
    retrieveAccount(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'id',
          clause: '='
        }]
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('accounts/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.email = response.data[0].email
          this.username = response.data[0].username
        }
      })
    },
    retrieveAccountInformation(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('account_informations/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.first_name = response.data[0].first_name
          this.middle_name = response.data[0].middle_name === 'NULL' ? '' : response.data[0].middle_name
          this.last_name = response.data[0].last_name
          this.account_information_id = response.data[0].id
        }
      })
    },
    updateAccountInformation(){
      if(this.first_name === '' || this.first_name === null || this.last_name === null || this.last_name === '') {
        this.errorMessage = 'First Name and Last Name are required.'
        this.successMessage = null
        this.successMessage1 = null
        return
      }
      let parameter = {
        id: this.account_information_id,
        account_id: this.user.userID,
        first_name: this.first_name,
        middle_name: this.middle_name,
        last_name: this.last_name
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('account_informations/update', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data === true){
          this.successMessage = 'Updated successfully.'
          this.errorMessage2 = null
          this.errorMessage = null
          this.errorMessage1 = null
        }
      })
    },
    updateAccount(){
      if(this.email === '' || this.email === null || this.password === null || this.password === '' || this.confirm_password === null || this.confirm_password === '') {
        this.errorMessage1 = 'Email and Password are required.'
        this.successMessage = null
        this.successMessage1 = null
        return
      }
      if(this.password !== this.confirm_password) {
        this.errorMessage2 = 'Please confirm your password.'
        this.successMessage = null
        this.successMessage1 = null
        return
      } else {
        this.errorMessage2 = null
      }
      let parameter = {
        id: this.user.userID,
        email: this.email,
        code: this.user.code,
        username: this.username,
        password: this.password
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('accounts/update', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data === true){
          this.successMessage1 = 'Updated successfully.'
          this.errorMessage2 = null
          this.errorMessage = null
          this.errorMessage1 = null
        }
      })
    },
    showImages() {
      $('#browseImagesModal').modal('show')
    },
    hideImages(){
      $('#browseImagesModal').modal('hide')
    },
    removeImage(id){
      let parameter = {
        id: id
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('account_profiles/delete', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        AUTH.checkAuthentication()
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.input-container{
  width: 100%;
  margin: 0px;
  margin-left: 2%;
}
.input-containers{
  width: 95%;
  margin: 0px;
  margin-left: 5%;
}
label{
  margin-top: 5px;
}
.generic-input{
  height: 40px;
  width: 100%;
  border-radius: 20px;
  border: .5px solid rgb(204, 204, 204);
  outline: none;
  padding: 10px;
  margin-bottom: 20px;
}
.container{
  margin-top: 15px;
  margin-bottom: 50px;
}
button:focus{
  outline: none;
}
.sort-button{
  border-radius: 25px;
  width: 150px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $secondary;
  margin-bottom: 50px;
}
.no-image{
  background-color: $primary;
  height: 160px;
  width: 160px;
  float: right;
  border-radius: 100px;
  margin-bottom: 10px;
}
@media (max-width: 992px){
  .container{
    width: 100%;
  }
}
</style>
