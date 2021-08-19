<template>
  <div class="container" :style="fromProfile === true ? 'width: 90%;' : 'width: 60%;'">
   <h3>Account Settings</h3>
    <div class="row" style="width: 100%; margin-top: 10px;">
      <div class="column" style="width: 70%; margin-right: 10%;">
      <Input
        :title="'Name'"
        :placeholder="'Name'"
        :label="true"
        :optional="false"
      />
      <Input
        :title="'Address'"
        :placeholder="'Address'"
        :label="true"
        :optional="false"
      />
      </div>
      <div class="column" style="width: 20%; text-align: center;">
        <div class="no-image">
        </div>
        <p>Click to edit profile</p>
      </div>
   </div>
   <button class="text-center sort-button">Update</button>
   <h3>Account Information</h3>
   <div class="row" style="width: 100%; margin-top: 10px;">
      <div class="column" style="width: 33%;">
      <Input
        :title="'First Name'"
        :placeholder="'First Name'"
        :label="true"
        :optional="false"
      />
      </div>
      <div class="column" style="width: 33%; text-align: center;">
       <Input
        :title="'Middle Name'"
        :placeholder="'Middle Name'"
        :label="true"
        :optional="true"
      />
      </div>
      <div class="column" style="width: 33%; text-align: center;">
       <Input
        :title="'Last Name'"
        :placeholder="'Last Name'"
        :label="true"
        :optional="false"
      />
      </div>
   </div>
   <button class="text-center sort-button">Update</button>
   <h3>Security</h3>
    <div class="row" style="width: 70%; margin-top: 10px;">
      <Input
        :title="'Old Password'"
        :placeholder="'Old Password'"
        :label="true"
        :optional="false"
      />
      <Input
        :title="'New Password'"
        :placeholder="'New Password'"
        :label="true"
        :optional="false"
      />
   </div>
   <button class="text-center sort-button">Update</button>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Input from 'src/modules/generic/InputField.vue'
export default{
  props: ['fromProfile'],
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
    Input
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
</style>
