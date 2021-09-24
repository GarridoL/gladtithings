<template>
  <div class="containers">
    <div class="row" style="width: 103%; margin-left: 0px;">
      <div class="column" style="margin-right: 10px; width: 9%;">
        <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 5px;">
      </div>
      <div class="column" style="margin-top: 7px; width: 82%; line-height: 10px;"> 
        <b style="font-size:18px;">{{data.name}}</b>
        <p>{{data.date}}</p>
      </div>
      <div class="column" style="width: 5%;">
      <span class="right-menu-icons">
      <div class="dropdown">
        <span class="nav-item" v-bind:class="{'active-menu': settingFlag === true}" data-toggle="dropdown" id="settings" aria-haspopup="true" aria-expanded="false" v-on:click="makeActive('dropdown')" v-bind:onkeypress="makeActive('')">
        <i class="fas fa-ellipsis-h icon"></i>
        <span class="dropdown-menu dropdown-menu-right" aria-labelledby="settings">
            <span class="dropdown-item dropdown-item-menu-title">
              <i class="fas fa-cog post"></i>
              <label>Post Actions</label>
              <span class="dropdown-item">
                <i class="fas fa-pencil-alt pencil"></i>
                <label>Edit</label>
              </span>
              <span class="dropdown-item">
                <i class="fas fa-file-alt file"></i>
                <label>Report</label>
              </span>
              <span class="dropdown-item">
                 <i class="fas fa-eye-slash eye-slash"></i>
                <label>Hide</label>
              </span>
              <span class="dropdown-item trash">
                <i class="fas fa-trash-alt trash"></i>
                <label>Delete</label>
              </span>
            </span>
           </span>
        </span>
      </div>
      </span>
    </div>
    </div>
    <div style="padding: 10px;">
      <p style="margin-bottom: 10px;">{{data.text}}</p>
      <div>
      <img :src="require('src/assets/img/test.jpg')" width="100%" height="300px">
      </div>
      <i class="fas fa-praying-hands praying-hands"></i>
      <span style="margin-left: 5px; margin-right: 50px; vertical-align: 2px;">Amen</span>
      <i class="fas fa-heart love"></i>
      <span style="margin-left: 5px; margin-right: 50px; vertical-align: 3px;">Love</span>
      <i class="fas fa-share share"></i>
      <span style="margin-left: 5px; margin-right: 50px; vertical-align: 3px;">Share</span>
    </div>
    <div style="width: 100%; margin-left: 0px; margin: 10px;" v-if="data.replies.length > 0">
      <div class="row" style="margin-left: 3px;" v-for="(item, index) in data.replies" :key="index">
        <div class="column" style="margin-right: 10px; width: 9%;">
          <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px;">
        </div>
        <div class="column" style="width: 80%; margin-top: 6px; line-height: 10px;">
          <b style="font-size:18px;">{{item.name}}</b>
          <p>{{item.date}}</p>
        </div>
        <div class="column" style="width: 5%;">
          <span class="right-menu-icons">
          <div class="dropdown">
            <span class="nav-item" v-bind:class="{'active-menu': settingFlag === true}" data-toggle="dropdown" id="settings" aria-haspopup="true" aria-expanded="false" v-on:click="makeActive('dropdown')" v-bind:onkeypress="makeActive('')">
            <i class="fas fa-ellipsis-h icon"></i>
            <span class="dropdown-menu dropdown-menu-right" aria-labelledby="settings">
                <span class="dropdown-item dropdown-item-menu-title">
                  <i class="fas fa-cog post"></i>
                  <label>Comment Actions</label>
                  <span class="dropdown-item pencil">
                    <i class="fas fa-pencil-alt pencil"></i>
                    <label>Edit</label>
                  </span>
                  <span class="dropdown-item eye-slash">
                    <i class="fas fa-eye-slash eye-slash"></i>
                    <label>Hide</label>
                  </span>
                  <span class="dropdown-item trash">
                    <i class="fas fa-trash-alt trash"></i>
                    <label>Delete</label>
                  </span>
                  </span>
                </span>
              </span>
            </div>
          </span>
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
    'data',
    'message'
  ],
  mounted(){},
  data(){
    return {
      user: AUTH.user
    }
  },
  methods: {
    makeActive(icon){
      if(icon === 'dropdown'){
        this.settingFlag = true
        this.menuFlag = true
        this.notifFlag = false
      }
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
p {
  margin: 0px;
}
.comment{
  font-size: 25px;
  margin-top: 20px;
  color: black;
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
  color: black;
}
.praying-hands{
  font-size: 20px;
  margin-top: 20px;
  color: black;
}
.love{
  font-size: 20px;
  margin-top: 20px;
  color: black;
}
.share{
  font-size: 20px;
  margin-top: 20px;
  color: black;
}
.containers{
  width: 100%;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  // margin-top: 10px;
  cursor: pointer;
}
@media (max-width: 992px){
  .container{
    width: 100%;
  }
}
// dropdown
.dropdown-menu{
  width: 250px;
  min-height: 250px;
  border-radius: 0px !important;
  padding-bottom: 0px !important;
}
.dropdown-menu-notification{
  padding-top: 0px !important;
  width: 350px !important;
  height: 400px !important;
  overflow-y: auto;
}
.dropdown-item{
  cursor: pointer;
  width: 100% !important;
  height: 40px !important;
  float: left !important;
  background: #fff !important;
  padding-top: 0px !important;
}
.dropdown-item .trash{
  color: red;
}
.dropdown-item:hover{
  background: #ddd !important;
}
.dropdown-item i{
  font-size: 14px !important;
  padding-right: 10px !important;
  color: black;
}

.dropdown-item label{
  font-size: 14px !important;
}
.dropdown-item label:hover, .dropdown-item i:hover{
  cursor: pointer;
}
.dropdown-header{
  padding: 5px 0 10px 0;
  width: 100%;
  text-align: center;
  border-bottom: solid 1px #ccc;
}
.dropdown-item-menu-title label{
  line-height: 40px;
  font-weight: 550;
}
.dropdown-item-menu-title:hover, .dropdown-item-menu-title label:hover{
  cursor: default;
  background: #fff !important;
}
</style>
