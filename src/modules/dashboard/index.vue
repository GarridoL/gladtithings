<template>
  <div class="container">
    <div class="row" style="width: 100%;">
      <div class="column" style="width: 80%;">
        <h3>Welcome to your Dashboard!</h3>
        <p style="margin-top: 5px;">Here are the latest update of activities as of today in GladTithings</p>
      </div>
      <div class="column" style="width: 20%;">
        <div style="float: right; cursor: pointer;" @click="showQr()">
          <span style="margin-right: 10px;">Click to show</span>
          <span><i class="fas fa-qrcode" style="font-size: 25px;"></i></span>
        </div>
      </div>
    </div>
    <div class="row" style="width: 100%; margin-top: 40px;">
      <div class="column first">
        <p class="title">Available Balance</p>
        <p style="color: white; margin: 0; font-size: 17px;" v-if="ledger && ledger.length > 0 || ledger"><b>{{ledger.currency}} {{ledger.available_balance ? ledger.available_balance.toLocaleString() : '0.0'}}</b></p>
        <p style="color: white; margin: 0; font-size: 17px;" v-else><b>0.0</b></p>
      </div>
      <div class="column second">
        <p class="title">Sent Last 30 Days</p>
        <p style="color: white; margin: 0; font-size: 17px;"><b>{{ledger.currency}} {{sent ? sent.toLocaleString() : '0.0'}}</b></p>
      </div>
      <div class="column third">
        <p class="title">Received Last 30 Days</p>
        <p style="color: white; margin: 0; font-size: 17px;"><b>{{ledger.currency}} {{receive ? receive.toLocaleString() : '0.0'}}</b></p>
      </div>
    </div>
    <div class="row" style="width: 100%; margin-top: 40px;">
      <div class="column" style="width: 80%;">
        <p><b>Summary</b></p>
        <p style="margin-top: 5px;">Here are the summary over the last 30 days</p>
      </div>
    </div>
    <div class="graph">
      <GraphHeader />
      <BarGraph :data="data" v-if="data.labels.length > 0"/>
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
import BarGraph from 'src/modules/generic/BarGraph.vue'
import GraphHeader from 'src/modules/generic/HeaderGraph.vue'
import VueQrcode from 'qrcode.vue'
export default{
  mounted(){
    this.retrieveBalance()
    this.retrieveGraphData()
  },
  data(){
    return {
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
    GraphHeader
  },
  methods: {
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
      this.APIRequest('ledger/dashboard', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data) {
          this.ledger = response.data.ledger[0]
        }
      })
    },
    retrieveGraphData(){
      let parameter = {
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('ledger/retrieve_dashboard', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data) {
          this.data.labels = response.data.dates
          this.data.datasets[0].data = response.data.total_amounts
          this.receive = response.data.received
          this.sent = Math.abs(response.data.sends)
        }
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container{
  width: 50%;
  margin-bottom: 50px;
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
.second{
  height: 100px;
  width: 32%;
  background-color: $danger;
  margin-right: 2%;
  padding-top: 25px;
  text-align: center;
  border-radius: 5px;
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
  .container{
    width: 60%;
  }
}
</style>
