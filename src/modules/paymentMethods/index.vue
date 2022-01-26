<template>
  <div class="container">
    <h3 style="margin-left: -15px;">Payment Methods</h3>
    <div class="row mt-4" style="width: 100%;">
      <div class="column" style="width: 50%;">
        <p><b>Payment Methods</b></p>
      </div>
      <div class="column" style="width: 50%;">
        <p class="add" :style="addPayment ? 'color: red' : 'color: #56C596'" @click="addPayment = !addPayment"><b>{{!addPayment ? 'Add' : 'Close'}}</b></p>
      </div>
    </div>
    <div class="row card-container" v-for="(item, index) in list" :key="index" v-if="!addPayment">
      <div class="column" style="width: 50%;">
        <p style="margin-bottom: 10px;"><b>{{item.name}}</b></p>
        <i class="fab fa-cc-paypal" style>&nbsp;&nbsp;</i>{{item.payload}}<br>
        <button class="remove-button" @click="showRemove(item)">Remove</button>
      </div>
      <div class="column" style="width: 50%; float: right;">
        <p style="color: gray; float: right;">{{item.status.charAt(0).toUpperCase() + item.status.slice(1).toLowerCase()}}</p>
      </div>
    </div>
    <Pager
      :pages="numPages"
      :active="activePage"
      :limit="limit"
      v-if="list.length > 0 && !addPayment"
    />
    <div class="row add-card" v-if="addPayment">
       <stripe-cc ref="stripe" />
      <button class="text-center authorize-button" @click="authorize()">Authorize</button>
    </div>
    <Confirmation
    ref="confirm"
    :title="'Confirmation'"
    :message="'Are you sure you want to delete this payment method?'"
    @onConfirm="remove($event)"
    />
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
import Cards from 'src/modules/settings/CardSettings.vue'
import Confirmation from 'src/components/increment/generic/modal/Confirmation.vue'
export default{
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      addPayment: false,
      list: [],
      limit: 5,
      numPages: 1,
      activePage: 1
    }
  },
  components: {
    Cards,
    'stripe-cc': require('modules/paymentMethods/Stripe.vue'),
    Pager,
    Confirmation
  },
  methods: {
    authorize(){
      console.log('refs', this.$refs.stripe)
      this.$refs.stripe.createCustomer()
    },
    retrieve(){
      let parameter = {
        account_id: this.user.userID,
        limit: this.limit,
        offset: (this.activePage > 0) ? ((this.activePage - 1) * this.limit) : this.activePage
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('payment_methods/retrieve_methods', parameter, response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0) {
          this.list = response.data
          this.addPayment = false
          this.numPages = parseInt(response.size / this.limit) + (response.size % this.limit ? 1 : 0)
        } else {
          this.numPages = null
          this.list = []
        }
      })
    },
    showRemove(item) {
      this.$refs.confirm.show(item.id)
    },
    remove(event){
      let parameter = {
        id: event.id
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('payment_methods/delete', parameter, response => {
        $('#loading').css({display: 'none'})
        if(response.data > 0) {
          this.retrieve()
        }
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.add{
  cursor: pointer;
}
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
  margin-top: 10px;
  width: 100%;
}
.container{
  width: 60%;
  margin-top: 15px;
  margin-bottom: 50px;
}
.add{
  color: $primary;
  float: right;
}
.card-container{
  width: 100%;
  margin-bottom: 10px;
  margin-top: 10px;
  padding: 15px;
  background-color: white;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
