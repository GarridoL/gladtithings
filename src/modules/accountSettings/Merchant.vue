<template>
  <div class="merchant-holder" v-if="data !== null">
    <h3 class="header">Security</h3>
    <div class="content row" style="width: 100%;">
      <div class="column" style="width: 60%; margin-right: 10%;">
        <span class="error text-danger" v-if="errorMessage !== null">
        <b>Oops!</b> {{errorMessage}}
      </span>
      <span class="error text-success" v-if="successMessage !== null">
        {{successMessage}}
      </span>
      <div class="form-group">
        <label for="address"><b>Business name </b><label class="text-danger">*</label></label>
        <input type="text" class="form-control generic-input" placeholder="Business Name" v-model="data.name" :disabled="parseInt(data.account_id) !== parseInt(user.userID)">
      </div>

      <div class="form-group" style="margin-top: 25px;" v-if="allowed.indexOf('email') > -1">
        <label for="address"><b>Business email address</b><label class="text-danger">*</label></label>
        <input type="text" class="form-control generic-input" placeholder="Business email address" v-model="data.email" :disabled="parseInt(data.account_id) !== parseInt(user.userID)">
      </div>

      <div class="form-group" style="margin-top: 25px;" v-if="allowed.indexOf('code') > -1">
        <label for="address"><b>ABN</b><label class="text-danger">*</label></label>
        <input type="text" class="form-control generic-input" placeholder="Business code" v-model="data.business_code" :disabled="parseInt(data.account_id) !== parseInt(user.userID)">
      </div>

      <div class="form-group" style="margin-top: 25px;" v-if="allowed.indexOf('address') > -1">
        <label for="address"><b>Business address </b><label class="text-danger">*</label></label>
        <input type="text" class="form-control generic-input" placeholder="Business Address" v-model="data.address" :disabled="parseInt(data.account_id) !== parseInt(user.userID)">
      </div>

      <div class="form-group" style="margin-top: 25px;" v-if="allowed.indexOf('prefix') > -1">
        <label for="address"><b>Prefix</b></label>
        <input type="text" class="form-control generic-input" placeholder="Invoice Prefix eq. IDF" v-model="data.prefix" :disabled="parseInt(data.account_id) !== parseInt(user.userID)">
      </div>

      <div class="form-group" style="margin-top: 25px;" v-if="allowed.indexOf('website') > -1">
        <label for="address"><b>Website</b></label>
        <input type="text" class="form-control generic-input" placeholder="Company website url" v-model="data.website" :disabled="parseInt(data.account_id) !== parseInt(user.userID)">
      </div>
      
      <button class="btn sort-button" style="margin-bottom: 25px;" @click="update()" v-if="parseInt(data.account_id) === parseInt(user.userID)">Update</button>
      </div>
      <div class="column" style="width: 20%; text-align: center;">
        <span class="image" v-if="data.logo !== null" >
          <img :src="config.BACKEND_URL + data.logo" style="background-size: cover; border-radius: 100px;"  height="160px" width="160px" >
        </span>
        <div class="no-image" v-else>
        </div>
        <p style="cursor: pointer; margin-top: 10px;" @click="showImages()">Click to edit profile</p>
      </div>
    </div>
    <browse-images-modal :object="photoObject"></browse-images-modal>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import axios from 'axios'
import CONFIG from 'src/config.js'
export default {
  mounted(){
    $('#loading').css({display: 'block'})
    this.retrieve()
    this.temp = {
      name: this.data.name,
      email: this.data.email,
      business_code: this.data.business_code,
      address: this.data.address,
      prefix: this.data.prefix,
      website: this.data.website,
      logo: this.data.logo
    }
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      config: CONFIG,
      data: null,
      errorMessage: null,
      successMessage: null,
      newData: {
        account_id: AUTH.user.userID,
        prefix: null,
        logo: null,
        email: null,
        address: null,
        name: null,
        website: null
      },
      createFlag: false,
      photoObject: {
        url: null
      },
      temp: {
        name: null,
        email: null,
        business_code: null,
        address: null,
        prefix: null,
        website: null
      }
    }
  },
  props: ['title', 'allowed'],
  components: {
    'browse-images-modal': require('components/increment/generic/image/BrowseModal.vue')
  },
  methods: {
    retrieve(){
      if(AUTH.user.subAccount !== null && AUTH.user.subAccount.merchant !== null){
        $('#loading').css({display: 'none'})
        this.data = AUTH.user.subAccount.merchant
        return
      }
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      this.APIRequest('merchants/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data[0]
          this.createFlag = false
        }else{
          this.createFlag = true
          this.data = this.newData
        }
      })
    },
    update(url){
      // if(this.data.email !== null && AUTH.validateEmail(this.data.email) === false){
      //   this.errorMessage = 'Invalid email address.'
      //   return
      // }
      if(url) {
        this.data.logo = url
      }
      if(this.createFlag === false){
        if(this.data.name !== this.temp.name || this.data.email !== this.temp.email || this.data.business_code !== this.temp.business_code || this.data.prefix !== this.temp.prefix || this.data.website !== this.temp.website || this.data.logo !== this.temp.logo) {
          $('#loading').css({display: 'block'})
          this.APIRequest('merchants/update', this.data).then(response => {
            if(response.data === true){
              this.retrieve()
              this.successMessage = 'Successfully Updated!'
              this.errorMessage = null
            }else{
              this.successMessage = null
              this.errorMessage = 'Unable to Update! Please contact the administrator.'
            }
          })
        } else {
          this.successMessage = 'You did not change anything!'
        }
      }else{
        this.create(url)
      }
    },
    create(url){
      this.data.logo = url
      if(this.data.email !== null && AUTH.validateEmail(this.data.email) === false){
        this.errorMessage = 'Invalid email address.'
        return
      }
      this.APIRequest('merchants/create', this.data).then(response => {
        if(response.data > 0){
          this.retrieve()
          this.successMessage = 'Successfully Updated!'
          this.errorMessage = null
          AUTH.checkAuthentication(null, true)
        }else{
          this.successMessage = null
          this.errorMessage = 'Unable to Update! Please contact the administrator.'
        }
      })
    },
    updatePhoto(object){
      this.data.logo = object.url
      this.update()
      this.hideImages()
    },
    createPhoto(object){
      this.data.logo = object.url
      this.update()
      this.hideImages()
    },
    showImages(){
      $('#browseImagesModal').modal('show')
    },
    manageImageUrl(url){
      this.update(url)
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.no-image{
  background-color: $primary;
  height: 160px;
  width: 160px;
  border-radius: 100px;
  margin-bottom: 10px;
  margin-top: 10px;
}
.merchant-holder{
  width: 95%;
  margin-left: 5%;
  margin-bottom: 200px;
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
.generic-input{
  height: 40px;
  width: 100%;
  border-radius: 20px;
  border: .5px solid rgb(204, 204, 204);
  outline: none;
  padding: 10px;
  margin-bottom: 20px;
}
.header{
  width: 100%;
  height: 50px;
  line-height: 50px;
  font-size: 24px;
  border-bottom: solid 1px #ddd;
  float: left;
}
.content{
  width: 100%;
  min-height: 50px;
  float: left;
  overflow-y: hidden;
}
.content .error{
  width: 100%;
  float: left;
  height: 40px;
  line-height: 40px;
}
.sidebar{
  width: 30%;
  min-height: 50px;
  overflow-y: hidden;
  text-align: center;
}
.sidebar-header{
  height: 40px;
  line-height: 40px;
  width: 100%;
  float: left;
}
.sidebar .image{
  width: 100%;
  float: left;
  min-height: 200px;
  overflow-y: hidden;
  text-align: center;
}
.image i{
  font-size: 150px;
  line-height: 200px;
  text-align: center;
}
.image img{
  border-radius: 5px;
}
.custom-block{
  width: 100%;
  float: left;
}
.custom-block input{
  display: none;
}
.row{
  margin: 0px !important;
}
.row .left{
  padding-left: 0px !important;
}
.row .right{
  padding-right: 0px !important;
}
@media screen and (max-width: 992px){
  .holder{
    width: 96%;
    margin-left: 2%;
    margin-right: 2%;
  }
  .sidebar{
    width: 100%;
    margin-right: 0%;
    margin-left: 0%;
  }
  .row .form-group{
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
}
</style>
