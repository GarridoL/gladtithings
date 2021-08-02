<template>
  <div class="modal fade" id="guideModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">{{common.APP_NAME}} User Guide</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="guide-holder">
                <ul class="first-ul">

                  <li><strong>Hi {{user.username}}! Welcome to {{common.APP_NAME}} by {{common.COMPANY}}!</strong></li>

                  <li>
                    Welcome to the {{common.APP_NAME}} User Guide. Here we will take you step by step from account creation to posting your first payment request on the {{common.APP_NAME}} platform. 
                  </li>
                   
                  <li><strong>What is {{common.APP_NAME}} by {{common.COMPANY}}?</strong></li>
                  <li>{{common.APP_NAME}} by {{common.COMPANY}} is an online marketplace for users who want to send cash online and will be fulfilled with our partners. 
                  </li><br>
                  <li><strong>Types of accounts</strong></li>
                  <li><strong>Regular Account</strong></li>
                  <li>A regular account allows you to send money. It provides the users an account profile to upload their necessary information and documents for monetary transactions performed on the platform.
                  </li>
                  <li><strong>Investor Account</strong></li>
                  <li>An investor account is our partner type of account which is the one who will fulfil your request in a nearby location.
                  </li>
                  <li><strong>Get Started</strong></li>
                  <li>Fill up the information needed on your {{common.APP_NAME}} profile such as Personal Information, and an optional for Educational Background and Work Experience. These are important so the service can verify and identify you as a legitimate verified account. Go to or click My Profile, under the settings icon on the right side of the header.
                  </li>
                  <li><strong>Requests</strong></li>
                  <li>Click <strong>Requests</strong> found in the left sidebar. Regular users can view all of the list of requests but don’t have a privilege to connect. Regular and Investor accounts can create or post a request. Fill up all of the required information, once the request is created it will be viewable to the investors in specified location. Investors can send a request to connect to the requests with the charges specified. Creator of the request will receive notification and view the list of investors sending requests. Lastly, the creator can accept the request and start a thread of fulfilment.
                   </li>
                  <li><strong>Dashboard</strong></li>
                  <li>Click <strong>Dashboard</strong> found in the left sidebar. In this section, you will find your current account balance, current requested amount and summary of ledger. 
                   </li>
                  <li><strong>Deposits(Direct)</strong></li>
                  <li>On <strong>Dashboard</strong>, Click the deposit button and fill up all of the required information. {{common.APP_NAME}} will send you a link of your request and an instruction to your registered email address to complete the deposit transaction. Once the payment is confirmed, you will receive notifications from both registered email and your account.
                  </li>
                  <li>Direct deposits will have zero charges from {{common.COMPANY}} but charges from the banks are beyond our capacity.
                  </li>
                  <li><strong>Withdrawals(Direct)</strong></li>
                  <li>On <strong>Dashboard</strong>, Click the withdrawal button and fill up all of the required information. You will receive notifications from email and your account once the transaction is completed.
                  </li>
                  <li>Direct withdrawals will have zero charges from {{common.COMPANY}} but charges from the banks are beyond our capacity.
                   </li>
                  <li><strong>Login Notifications</strong></li>
                  <li>For added security measures, you can set Login Notifications to be sent to your email. This function can only be enabled once your email is verified. Please wait a few minutes for the automatically generated to be sent to your inbox.
                   </li>
                  <li><strong>OTP (One Time Password)</strong></li>
                  <li>Additionally, OTP (One Time Password) can be configured on your account for added security. The OTP Code will be sent to your email upon every login once the feature has been enabled on your account.
                   </li>
                  <li>On transfer funds from your account to another, the OTP is required. Once you click the transfer button in the messenger thread, an email with OTP Code will be sent to the registered email address. Take note, carefully type your OTP code as it will be blocked for 30 Minutes once OTP is incorrect.
                  </li>

                </ul>
             </div>
            </div>
          
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#guideModal">Close</button>
          </div>
        </div>
      </div>
    </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.bg-primary{
  background-color: $primary !important;
}
.guide-holder{
  margin-top:22px;
  width:90%;
  float: left;
  margin-left:5%;
  margin-right:5%;
}

.jumbotron{
  padding-top: 0rem !important;
  padding-bottom: 0rem !important;
  background: #fff;
}

.alert{
  text-align: justify !important;
}
.alert-info{
  background: #fff !important;
  border: 0px !important;
  color: #212529;
}
.first-ul{
  padding: 0px;
  list-style: none;
}
ul li{
  text-align: justify;
  font-size: 15px;
  color: grey;
  padding-top: 10px;
}
.bg-danger{
  color: #fff !important;
}
</style>
<script>
  import ROUTER from 'src/router'
  import Vue from 'vue'
  import AUTH from 'src/services/auth'
  import COMMON from 'src/common.js'
  export default{
    data(){
      return {
        user: AUTH.user,
        common: COMMON
      }
    },
    props: {
    },
    methods: {
      redirect(parameter){
        ROUTER.push(parameter)
      }
    }
  }
</script>
