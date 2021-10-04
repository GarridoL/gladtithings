<template>
  <div class="containers">
    <div class="row" style="width: 103%; margin-left: 0px;">
      <div class="column" style="margin-right: 10px;">
        <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px;">
      </div>
      <div class="column" style=" width: 82%; margin-top: 4px; line-height: 15px;"> 
        <b>{{data.name}}</b>
        <p>{{data.date}}</p>
      </div>
      <div class="column" style="padding-right: 8px;">
      <span class="right-menu-icons">
      <div class="dropdown">
        <span class="nav-item" v-bind:class="{'active-menu': settingFlag === true}" data-toggle="dropdown" id="settings" aria-haspopup="true" aria-expanded="false" v-on:click="makeActive('dropdown')" v-bind:onkeypress="makeActive('')">
        <i class="fas fa-ellipsis-h icon"></i>
        <span class="dropdown-menu dropdown-menu-right" aria-labelledby="settings" style="font-weight: normal;">
            <span class="dropdown-item dropdown-item-menu-title">
              <i class="fas fa-cog post"></i>
              <label>Post Actions</label>
              <span class="dropdown-item">
                <i class="fas fa-pencil-alt pencil">&nbsp;&nbsp;&nbsp;Edit</i>
              </span>
              <span class="dropdown-item">
                <i class="fas fa-file-alt file">&nbsp;&nbsp;&nbsp;&nbsp;Report</i>
              </span>
              <span class="dropdown-item">
                 <i class="fas fa-eye-slash eye-slash">&nbsp;&nbsp;&nbsp;Hide</i>
              </span>
              <span class="dropdown-item trash">
                <i class="fas fa-trash-alt trash">&nbsp;&nbsp;&nbsp;&nbsp;Delete</i>
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
      <span style=" margin-right: 50px; vertical-align: 2px;">Amen</span>
      <i class="fas fa-heart love"></i>
      <span style=" margin-right: 50px; vertical-align: 3px;">Love</span>
      <i class="fas fa-share share"></i>
      <span style=" margin-right: 50px; vertical-align: 3px;">Share</span>
    </div>
    <div style="width: 100%; margin-left: 0px; margin: 10px;" v-if="data.replies.length > 0">
      <div class="row" style="margin-left: 3px;" v-for="(item, index) in data.replies" :key="index">
        <div class="column" style="margin-right: 10px;">
          <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px;">
        </div>
        <div class="column" style="width: 82%; margin-top: 4px; line-height: 15px;">
          <b>{{data.name}}</b>
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
                  <label>Comment Actions</label>
                 <span class="dropdown-item">
                    <i class="fas fa-pencil-alt pencil">&nbsp;&nbsp;&nbsp;Edit</i>
                  </span>
                  <span class="dropdown-item">
                    <i class="fas fa-eye-slash eye-slash">&nbsp;&nbsp;&nbsp;Hide</i>
                  </span>
                  <span class="dropdown-item trash">
                    <i class="fas fa-trash-alt trash">&nbsp;&nbsp;&nbsp;&nbsp;Delete</i>
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
  color: $secondary;
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
  float: left;
  color: $secondary;
}
.praying-hands{
  font-size: 20px;
  margin-top: 20px;
  color: $secondary;
}
.love{
  font-size: 20px;
  margin-top: 20px;
  color: $secondary;
}
.share{
  font-size: 20px;
  margin-top: 20px;
  color: $secondary;
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
  border-radius: 0px;
  padding-bottom: 0px;
}
.dropdown-item{
  cursor: pointer;
  width: 100%;
  height: 40px;
  float: left;
  background: #fff;
  padding-top: 0px;
  font-weight: normal;
}
.dropdown-item .trash{
  color: red;
}
.dropdown-item:hover{
  background: #ddd;
}
.dropdown-item i{
  font-size: 14px;
  padding-right: 10px;
  color: $secondary;
}
.dropdown-item label{
  font-size: 14px;
}
.dropdown-item label:hover, .dropdown-item i:hover{
  cursor: pointer;
}
.dropdown-header{
  padding: 5px 0 10px 0;
  text-align: center;
  border-bottom: solid 1px #ccc;
}
.dropdown-item-menu-title label{
  line-height: 40px;
  font-weight: 550;
}
.dropdown-item-menu-title:hover, .dropdown-item-menu-title label:hover{
  cursor: default;
  background: #fff 
}
</style>
