<template>
  <div>
    <span class="title-faq-pricing">
      <h1>FAQ</h1>
      <span class="details">Find answers to the questions we’re frequently asked about</span>
    </span>
    <div class="holder">
      <span class="faq-item" v-for="(item, index) in common.faq">
        <span class="faq-title" @click="toggle(index)">
          <span class="text"><b>{{item.title}}</b></span>
          <span class="icon pull-right"><i class="fa " :class="{'fa-chevron-down': activeIndex !== index, 'fa-chevron-up': activeIndex === index}"></i></span>
        </span>
        <span class="faq-content" v-html="item.description" v-if="activeIndex === index"></span>
      </span>
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.title-faq-pricing{
  width: 100%;
  float: left;
  padding-bottom: 30px;
  padding-top: 30px;
  color: $primary;
  text-align: center;
}
.holder{
  width: 60%;
  margin-right: 20%;
  margin-left: 20%;
  float: left;
  margin-top: 25px;
  margin-bottom: 100px;
}
.faq-item{
  width: 100%;
  float: left;
  min-height: 10px;
  overflow-y: hidden;
  border-bottom: 1px solid $textBlue;
  border-bottom-left-radius: 5px;
  border-bottom-right-radius: 5px;
}

.faq-item .faq-title{
  width: 100%;
  float: left;
  min-height: 10px;
  overflow-y: hidden;
  font-weight: 450;
  padding: 15px;
  color: $primary;
}

.faq-item .faq-title:hover{
  cursor: pointer;
}
.faq-item .faq-content{
  width: 90%;
  float: left;
  margin-left: 5%;
  margin-right: 5%;
  min-height: 10px;
  overflow-y: hidden;
  text-align: justify;
  color: #555;
  padding-bottom: 10px;
}
.hide-on-mobile{
  display: block;
}

.show-on-mobile{
  display: none;
}

@media screen and (max-width: 992px){
  .holder{
    width: 96%;
    margin-right: 2%;
    margin-left: 2%;
  }

  .hide-on-mobile{
    display: none;
  }
  
  .show-on-mobile{
    display: block;
  }
  
  .header-title-mobile{
    width: 100%;
    float: left;
    height: 200px;
  }

  .header-title-mobile label{
    color: #fff;
    margin-top: -140px;
    font-size: 42px;
    float: left;
    width: 90%;
    margin-left: 5%;
    margin-right: 5%;
  }
}
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import COMMON from 'src/common.js'
export default {
  mounted(){
  },
  data(){
    return {
      common: COMMON,
      activeIndex: null
    }
  },
  methods: {
    toggle(index){
      if(this.activeIndex !== index){
        this.activeIndex = index
      }else{
        this.activeIndex = null
      }
    }
  }
}
</script>
