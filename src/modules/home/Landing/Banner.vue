<template>
  <div class="incre-row">
    <div class="cw-banner bg-primary">
      <div class="text text-white">
        <span class="title">
          <h1>Send cash in a new and convenient way!</h1>
        </span>
        <span class="description">
          <h4>
            In Payhiram, we have partners to fulfill your cash needed in any locations you want. Start sending today!
          </h4>
        </span>
          <div class="row">
              <img width="200" class="mt-4 mr-2 app" :src="require('assets/img/logo.png')" @click="externalLink('https://play.google.com/store/apps/details?id=com.payhiram')"/>
              <img width="200" class="mt-4 mr-2 app" :src="require('assets/img/logo.png')" @click="externalLink('appstore.test')"/>
          </div>
          <!-- <span style="width: 100%; float: left;" >
            <button class="btn custom-btn bg-black" @click="externalLink('https://play.google.com/store/apps/details?id=com.payhiram')">
              <i class="fab fa-google-play"></i>
              Get on Play Store Now!
            </button>
          </span> -->
      </div>
      <img :src="require('assets/img/logo.png')" class="image">
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.app{
  cursor: pointer;
}
.custom-btn{
  height: 50px !important;
  border-radius: 5px !important;
  width: 200px !important;
  margin-top: 25px;
}

.bg-primary{
  background: $primary !important;
}

.bg-black{
  background-color: #000;
  margin-top: 10px !important;
}

.cw-banner{
  width: 100%;
  float: left;
  height: 100vh;
}
.text{
  width: 45%;
  float: left;
  margin-left: 5%;
  margin-top: 100px;
  position: relative;
  z-index: 1000;
}
.text .title{
  width: 100%;
  float: left;
}
.title h1{
  font-size: 50px;
}
.text .description{
  margin-top: 25px;
  width: 100%;
  float: left;
  text-align: justify;
}
.image{
  max-width: 100%;
  max-height: 100%;
  position: absolute;
  right: 0;
  z-index: 0;
}

@media screen and (max-width: 992px){
  .text{
    width: 90%;
    margin-left: 5%;
    margin-right: 5%;
    margin-top: 50px;
  }
  .title{
    text-align: center;
  }

  .title h1{
    font-size: 300%;
  }

  .description h4{
    font-size: 120%;
    font-weight: 300;
    margin-top: 25px;
    margin-bottom: 25px;
  }

  .image{
    position: relative;
    max-height: 100%;
    width: inherit;
    margin-top: 50px;
  }

  .custom-btn{
    width: 100% !important;
    margin-top: 10px !important;
  }
}
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import SETTINGS from 'src/modules/home/settings.js'
export default {
  mounted(){
  },
  data(){
    return {
      settings: SETTINGS
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    externalLink(url){
      window.open(url, '_blank')
    }
  }
}
</script>
