<template>
  <div class="container">
    <h3 style="margin-left: -15px;">Payment Methods</h3>
    <div class="row mt-4" style="width: 60%;">
      <div class="column" style="width: 50%;">
        <p><b>Payment Methods</b></p>
      </div>
      <div class="column" style="width: 50%;">
        <p class="add"><b>Add</b></p>
      </div>
    </div>
    <div class="row card-container" v-for="(item, index) in list" :key="index">
      <div class="column" style="width: 50%;">
        <p style="margin-bottom: 10px;"><b>{{item.title}}</b></p>
        <i class="fab fa-cc-paypal" style>&nbsp;&nbsp;</i>{{item.method}}<br>
        <button class="remove-button">Remove</button>
      </div>
      <div class="column" style="width: 50%; float: right;">
        <p style="color: gray; float: right;">Authorized</p>
      </div>
    </div>
    <div class="row add-card">
      <p><b>Card Number: </b><span style="color: red;">*</span></p>
      <div class="card-number">
        <p>4242-4242-4242-4242</p>
      </div>
        <div class="column" style="width: 25%;">
          <p><b>Expiry: </b><span style="color: red;">*</span></p>
        </div>
        <div class="column" style="width: 25%;">
         <p><b>CVC: </b><span style="color: red;">*</span></p>
        </div>
        <div class="column" style="width: 50%;">
        </div>
      <div class="column" style="width: 48%;">
        <div class="card-number">
          <p>08/22</p>
        </div>
      </div>
      <div class="column" style="width: 48%; margin-left: 4%;">
        <div class="card-number">
          <p>1111</p>
        </div>
      </div>
      <button class="text-center authorize-button">Authorize</button>
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
          title: 'Nickname',
          method: 'Paypal'
        },
        {
          title: 'Lalaine',
          method: 'Paypal'
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
button:focus{
  outline: none;
}
.authorize-button{
  border-radius: 25px;
  width: 150px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $secondary;
  margin-top: 10px;
}
.remove-button{
  margin-top: 10px;
  border-radius: 20px;
  width: 100px;
  color: white;
  border: 0px;
  height: 30px;
  background-color: $danger;
}
.card-number{
  width: 100%;
  padding: 10px;
  text-align: center;
  border: .5px solid rgb(235, 235, 235);
  background-color: white;
  border-radius: 50px;
  margin-top: 15px;
  margin-bottom: 15px;
}
p{
  margin: 0
}
.add-card{
  margin-top: 50px;
  width: 60%;
}
.container{
  width: 70%;
  margin-top: 15px;
  margin-bottom: 50px;
}
.add{
  color: $primary;
  float: right;
}
.card-container{
  width: 60%;
  margin-top: 10px;
  padding: 15px;
  background-color: white;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
}
@media (max-width: 992px){
  .container{
    width: 70%;
  }
}
</style>
