<template>
  <div class="container">
    <div class="row">
      <div class="column welcome-div">
        <h3>Welcome to your Dashboard!</h3>
        <p style="margin-top: 5px;">Here are the latest update of activities as of today in GladTithings</p>
      </div>
      <div class="column qr-div">
        <div class="qr" @click="showQr()">
          <span class="qr-text">Click to show</span>
          <span><i class="fas fa-qrcode" style="font-size: 25px;"></i></span>
        </div>
      </div>
    </div>
    <div class="row balances">
      <div class="column first">
        <p class="title">Available Balance</p>
        <p class="balances-text" v-if="ledger && ledger.length > 0 || ledger"><b>{{ledger.currency && ledger.currency.toUpperCase()}} {{ledger.available_balance ? ledger.available_balance.toLocaleString() : '0.0'}}</b></p>
        <p class="balances-text" v-else><b>0.0</b></p>
      </div>
      <div class="column second">
        <p class="title">Sent Last 30 Days</p>
        <p class="balances-text"><b>{{ ledger && ledger.currency && ledger.currency.toUpperCase()}} {{sent ? sent.toLocaleString() : '0.0'}}</b></p>
      </div>
      <div class="column third">
        <p class="title">Received Donations</p>
        <p class="balances-text"><b>{{ledger && ledger.currency && ledger.currency.toUpperCase()}} {{receive ? receive.toLocaleString() : '0.0'}}</b></p>
      </div>
    </div>
    <div class="row summary-column">
      <div class="column" style="width: 80%;">
        <p><b>Summary</b></p>
        <p style="margin-top: 5px;">Here are the summary over the year.</p>
      </div>
    </div>
    <div class="graph" v-if="data.labels.length > 0">
      <GraphHeader @temp="headSub" :data="data" :name="'Summary'"/>
      <BarGraph :data="data" :options="{responsive: true, maintainAspectRatio: false}" ref="subscription"/>
    </div>
    <div v-else>
      <empty v-if="data.length === 0" :title="'Last summary is not available!'" :action="'Keep growing.'"></empty>
    </div>
    <div class="modal fade" id="qrcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Present this QR code for scanning...</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="text-align: center;">
            <VueQrcode
              :value="user.code"
              :size="200"
            />
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import AUTH from 'src/services/auth'
import Posts from 'src/modules/generic/Posts.vue'
import BarGraph from 'src/modules/generic/BarGraphDashboard.vue'
import GraphHeader from 'src/modules/generic/HeaderGraphDashboard.vue'
import VueQrcode from 'qrcode.vue'
export default{
  mounted(){
    this.retrieveBalance()
    this.retrieveGraphData()
  },
  data(){
    return {
      selected: null,
      user: AUTH.user,
      data: {
        labels: [],
        datasets: [
          {
            fill: false,
            borderColor: '#f87979',
            backgroundColor: '#56C596',
            label: 'TITHINGS',
            data: []
          }
        ]
      },
      ledger: {
        available_balance: null,
        balance: null,
        currency: null,
        current_balance: null
      },
      receive: 0,
      sent: 0
    }
  },
  components: {
    Posts,
    VueQrcode,
    BarGraph,
    GraphHeader,
    'empty': require('components/increment/generic/empty/Empty.vue')
  },
  methods: {
    headSub(e){
      this.selected = e
      this.retrieveGraphData()
    },
    summary(){
      if(this.$refs.subscription && this.$refs.subscription.retrieve !== undefined){
        this.$refs.subscription.retrieve(this.data, {responsive: true, maintainAspectRatio: false})
      }
    },
    showQr(){
      $('#qrcode').modal('show')
    },
    retrieveBalance(){
      let parameter = {
        condition: [
          {
            clause: '=',
            column: 'account_id',
            value: this.user.userID
          }
        ],
        account_code: this.user.code,
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('subscriptions/dashboard', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data) {
          this.ledger = response.data.ledger[0]
        }
      })
    },
    retrieveGraphData(){
      let parameter = {
        account_id: this.user.userID,
        date: this.selected === null ? 'yearly' : this.selected
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('subscriptions/retrieve_dashboard', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data) {
          this.data.labels = response.data.dates
          this.data.datasets[0].data = response.data.total_amount_received
          this.receive = response.data.received
          this.sent = Math.abs(response.data.sends)
          this.summary()
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
  margin-top: 10px;
  align-items: center;
  padding: 20px;
}
.title{
  color: rgb(202, 200, 200);
  margin: 0;
}
.graph{
  margin-top: 10px;
  background-color: white;
  width: 100%;
  margin-left: -13px;
  padding: 10px 30px 20px 30px;
}
p{
  margin: 0;
}
.first{
  height: 100px;
  width: 32%;
  background-color: $primary;
  margin-right: 2%;
  padding-top: 25px;
  text-align: center;
  border-radius: 5px;
}
.welcome-div{
  width: 80%;
}
.qr-div{
  width: 20%;
}
.qr-text{
  margin-right: 10px;
}
.balances-text{
  color: white;
  margin: 0;
  font-size: 17px;
}
.balances{
  width: 100%;
  margin-top: 40px;
}
.second{
  height: 100px;
  width: 32%;
  background-color: $danger;
  margin-right: 2%;
  padding-top: 25px;
  text-align: center;
  border-radius: 5px;
}
.summary-column{
  width: 100%;
  margin-top: 40px;
}
.qr{
  float: right;
  cursor: pointer;
}
.third{
  height: 100px;
  width: 32%;
  background-color: $secondary;
  padding-top: 25px;
  text-align: center;
  border-radius: 5px;
}
@media (max-width: 992px){
  .container, .first, .second, .third{
    width: 100%;
    text-align: center;
    margin: 10px;
  }
}
</style>
