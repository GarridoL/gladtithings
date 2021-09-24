<template>
  <div class="containers">
    <div class="row" style="width: 103%; margin-left: 0px;">
      <div class="column" style="margin-right: 10px; width: 9%;">
        <img :src="require('src/assets/img/test.jpg')" width="50px" height="50px" style="border-radius: 25px; margin-left: 5px;">
      </div>
      <div class="column" style="width: 82%;">
        <b>{{data.name}}</b>
        <p>{{data.date}}</p>
      </div>
      <div class="column" style="width: 5%;">
        <i class="fas fa-ellipsis-h icon"></i>
      </div>
    </div>
    <div style="padding: 10px;">
      <p style="margin-bottom: 10px;">{{data.text}}</p>
      <div>
      <img :src="require('src/assets/img/test.jpg')" width="100%" height="300px">
      </div>
      <i class="fas fa-praying-hands praying-hands"></i>
      <span style="color: gray; margin-right: 50px;">Amen</span>
      <i class="fas fa-comment-alt comment"></i>
      <span>Comment</span>
    </div>
    <div style="width: 100%; margin-left: 0px; margin: 10px;" v-if="data.replies.length > 0">
      <div class="row" style="margin-left: 3px;" v-for="(item, index) in data.replies" :key="index">
        <div class="column" style="margin-right: 10px; width: 9%;">
          <img :src="require('src/assets/img/test.jpg')" width="50px" height="50px" style="border-radius: 25px;">
        </div>
        <div class="column" style="width: 80%;">
          <b>{{item.name}}</b>
          <p>{{item.date}}</p>
        </div>
        <div class="column" style="width: 5%;">
          <i class="fas fa-ellipsis-h icon"></i>
        </div>
        <p style="margin: 10px; margin-top: 10px;">{{item.text}}</p>
      </div>
    </div>
    <div style="width: 100%; margin-left: 0px; margin: 10px;">
      <input type="text" class="inputs" placeholder="Type here">
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
export default{
  props: [
    'data'
  ],
  mounted(){},
  data(){
    return {
      user: AUTH.user
    }
  },
  methods: {}
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
p {
  margin: 1px;
}
.comment{
  font-size: 25px;
  margin-top: 20px;
}
.inputs{
  border-radius: 20px;
  height: 40px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 5px;
  outline: none;
  width: 95%;
  padding: 15px;
}
.icon{
  font-size: 20px;
  margin-top: 7px;
  position: relative;
  right: 0px;
}
.praying-hands{
  font-size: 25px;
  margin-top: 20px;
  color: gray;
}
.containers{
  width: 100%;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 20px;
  cursor: pointer;
}
@media (max-width: 992px){
  .container{
    width: 100%;
  }
}
</style>
