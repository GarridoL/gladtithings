<template>
  <div class="container" :style="fromProfile === true ? 'width: 90%;' : 'width: 60%;'">
   <h3>Account Settings</h3 >
  <span class="content">
    <span class="error text-danger" v-if="errorMessage !== null">
      <b>Oops!</b> {{errorMessage}}
    </span>
    <span class="error text-success" v-if="successMessage !== null">
      {{successMessage}}
    </span>
    <div class="row" style="width: 100%; margin-top: 10px;">
      <div class="column" style="width: 70%; margin-right: 10%;" >
         <div class="container" style="margin-top: 25px;">
            <label for="username"><b>Username </b><label class="text-danger">*</label></label>
            <input type="text" class="form-control generic-input" placeholder="Username" v-model="accounts.username" disabled>
            <label for="email"><b>Email</b><label class="text-danger">*</label></label>
            <input type="text" class="form-control generic-input" placeholder="Email" v-model="accounts.email">
          </div>
      <!-- <Input 
        :name="'username'"
        :title="'Username'"
        :placeholder="'Username'"
        :value="accounts.username"
        :label="true"
      />
      <Input
        :name="'email'"
        :title="'Email'"
        :placeholder="'Email Address'"
        :value="accounts.email"
        :label="true"
        :optional="false"
      /> -->
      </div>
      <div class="column" style="width: 20%; text-align: center;">
        <div class="no-image">
        </div>
        <p>Click to edit profile</p>
      </div>
   </div>
   </span>
   <button class="text-center sort-button" @click="updateAccounts()" >Update</button>
   <h3>Account Information</h3>
   <span class="content">
      <span class="error text-danger" v-if="errorMessage !== null">
        <b>Oops!</b> {{errorMessage}}
      </span>
      <span class="error text-success" v-if="successMessage !== null">
        {{successMessage}}
      </span>
   <div class="row" style="width: 100%; margin-top: 20px; margin-left: 2px;">
      <div class="column" style="width: 25%;">
        <label for="firtName"><b>First Name</b><label class="text-danger">*</label></label>
        <input type="text" class="form-control generic-input" placeholder="First Name" v-model="accountInformation.firstName">
      <!-- <Input 
        :title="'First Name'"
        :placeholder="'First Name'"
        :label="true"
        :optional="false"
        :value="accountInformation.firstName"
      /> -->
      </div>
      <div class="column" style="margin-left: 20px; width: 25%; text-align: center;" >
        <label for="middleName"><b>Middle Name</b><label class="text-danger">*</label></label>
        <input type="text" class="form-control generic-input" placeholder="Middle Name" v-model="accountInformation.middleName">
       <!-- <Input 
        :title="'Middle Name'"
        :placeholder="'Middle Name'"
        :value="accountInformation.middleName"
        :label="true"
        :optional="true"
      /> -->
      </div>
      <div class="column" style="margin-left: 20px; width: 25%; text-align: center;" >
        <label for="lastName"><b>Last Name</b><label class="text-danger">*</label></label>
        <input type="text" class="form-control generic-input" placeholder="Last Name" v-model="accountInformation.lastName">
       <!-- <Input
        :title="'Last Name'"
        :placeholder="'Last Name'"
        :value="accountInformation.lastName"
        :label="true"
        :optional="false"
      /> -->
      </div>
   </div>
   </span>
   <button class="text-center sort-button" @click="updateAccountInformation()" >Update</button>
   <h3>Security</h3>
    <div class="row" style="width: 70%; margin-top: 10px;">
      <Input
        :name="'password'"
        :title="'Old Password'"
        :placeholder="'Old Password'"
        :value="accounts.oldpassword"
        :label="true"
        :optional="false"
      />
      <Input
        :name="'cPassword'"
        :title="'New Password'"
        :placeholder="'New Password'"
        :label="true"
        :optional="false"
      />
   </div>
   <button class="text-center sort-button" v-on:click="reset()">Update</button>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Input from 'src/modules/generic/InputField.vue'
export default{
  props: ['fromProfile'],
  mounted(){
    this.retrieveAccounts()
    // this.temp = {
    //   username: this.accounts.username,
    //   email: this.accounts.username,
    //   firstName: this.accountInformation.firstName,
    //   middleName: this.accountInformation.middleName,
    //   lastName: this.accountInformation.lastName
    // }
    this.retrieveAccountInformation()
  },
  data(){
    return {
      user: AUTH.user,
      data: null,
      tokenData: AUTH.tokenData,
      config: CONFIG,
      errorMessage: null,
      successMessage: null,
      newData: {
        account_id: AUTH.user,
        username: null,
        email: null,
        firstName: null,
        middleName: null,
        lastName: null,
        password: null,
        cPassword: null
      },
      createFlag: false,
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
      accounts: {
        email: null,
        username: null,
        oldpassword: null,
        cPassword: null
      },
      accountInformation: {
        firstName: null,
        middleName: null,
        lastName: null

      },
      temp: {
        username: null,
        email: null,
        firstName: null,
        middleName: null,
        lastName: null,
        password: null,
        cPassword: null
      }
    }
  },
  components: {
    Input
  },
  methods: {

    // retrieveAccounts(){
    //   let parameter = {
    //     condition: [{
    //       value: this.user.userID,
    //       column: 'id',
    //       clause: '='
    //     }]
    //   }
    //   this.APIRequest('accounts/retrieve', parameter).then(response => {
    //     $('#loading').css({display: 'none'})
    //     if(response.data.length > 0){
    //       this.accounts.username = response.data[0].username
    //       this.accounts.email = response.data[0].email
    //       this.accounts.oldpassword = response.data[0].password
    //       this.accounts['id'] = response.data[0].id
    //       this.createFlag = false
    //     }else{
    //       this.createFlag = true
    //       this.data = this.newData
    //     }
    //   })
    // },
    // updateAccounts(url){
    //   if(this.createFlag === false){
    //     if(this.accounts.email !== this.temp.email) {
    //       $('#loading').css({display: 'block'})
    //       this.APIRequest('accounts/update', this.accounts['id']).then(response => {
    //         if(response.data === true){
    //           this.retrieveAccounts()
    //           this.successMessage = 'Successfully Updated!'
    //           this.errorMessage = null
    //         }else{
    //           this.successMessage = null
    //           this.errorMessage = 'Unable to Update! Please contact the administrator.'
    //         }
    //       })
    //     } else {
    //       this.successMessage = 'You did not change anything!'
    //     }
    //   }
    // },
    // createAccounts(url){
    //   this.APIRequest('account_informations/create', this.accounts).then(response => {
    //     if(response.data > 0){
    //       this.retrieveAccounts()
    //       this.successMessage = 'Successfully Updated!'
    //       this.errorMessage = null
    //       AUTH.checkAuthentication(null, true)
    //     }else{
    //       this.successMessage = null
    //       this.errorMessage = 'Unable to Update! Please contact the administrator.'
    //     }
    //   })
    // },
    // retrieveAccountInformation(){
    //   let parameter = {
    //     condition: [{
    //       value: this.user.userID,
    //       column: 'account_id',
    //       clause: '='
    //     }]
    //   }
    //   this.APIRequest('account_informations/retrieve', parameter).then(response => {
    //     $('#loading').css({display: 'none'})
    //     if(response.data.length > 0){
    //       this.accountInformation.firstName = response.data[0].first_name
    //       this.accountInformation.middleName = response.data[0].middle_name
    //       this.accountInformation.lastName = response.data[0].last_name
    //       this.accountInformation['account_id'] = response.data[0].id
    //       this.data = response.data[0]
    //       this.createFlag = false
    //     }else{
    //       this.createFlag = true
    //       this.data = this.newData
    //     }
    //   })
    // },
    // updateAccountInformation(url){
    //   if(this.createFlag === false){
    //     if(this.accountInformation.firstName !== this.temp.firstName || this.accountInformation.middleName !== this.temp.middleName || this.accountInformation.lastName !== this.temp.lastName) {
    //       $('#loading').css({display: 'block'})
    //       this.APIRequest('account_informations/update', this.data).then(response => {
    //         if(response.data === true){
    //           this.retrieveAccountInformation()
    //           this.successMessage = 'Successfully Updated!'
    //           this.errorMessage = null
    //         }else{
    //           this.successMessage = null
    //           this.errorMessage = 'Unable to Update! Please contact the administrator.'
    //         }
    //       })
    //     } else {
    //       this.successMessage = 'You did not change anything!'
    //     }
    //   }else{
    //     this.createAccountInformation(url)
    //   }
    // },
    // createAccountInformation(url){
    //   this.APIRequest('account_informations/create', this.accountInformation).then(response => {
    //     if(response.data > 0){
    //       this.retrieveAccountInformation()
    //       this.successMessage = 'Successfully Updated!'
    //       this.errorMessage = null
    //       AUTH.checkAuthentication(null, true)
    //     }else{
    //       this.successMessage = null
    //       this.errorMessage = 'Unable to Update! Please contact the administrator.'
    //     }
    //   })
    // }
    // reset(){
    //   this.validate()
    //   if(this.flag === true){
    //     let parameter = {
    //       'password': this.password
    //     }
    //     $('#loading').css({display: 'block'})
    //     this.APIRequest('accounts/update', parameter).then(response => {
    //       $('#loading').css({display: 'none'})
    //       if(response.data === true){
    //         this.updateFlag = true
    //       }else{
    //         this.updateFlag = false
    //       }
    //     })
    //   }
    // }
    // validate(){
    //   if(this.password === null || this.password === '' || this.cPassword === null || this.cPassword === ''){
    //     this.flag = false
    //     this.errorMessage = 'Please fill in all required fields.'
    //   }else if(this.password !== this.cPassword){
    //     this.flag = false
    //     this.errorMessage = 'Please confirm your new password.'
    //   }else if(this.password.length < 8){
    //     this.flag = false
    //     this.errorMessage = 'Password length must be greater than 8 digit characters.'
    //   }else if(/^[a-zA-Z0-9]+$/.test(this.password)){
    //     this.flag = false
    //     this.errorMessage = 'Password must be alphanumeric characters. It should contain 1 number, 1 special character and letters.'
    //   }else{
    //     this.flag = true
    //     this.errorMessage = null
    //   }
    // },
    // redirect(parameter){
    //   ROUTER.push(parameter)
    // }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
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
.container{
  width: 100%;
  margin: 0px;
}
label{
  margin-top: 0px;
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
</style>
