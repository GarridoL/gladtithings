<template>
  <div class="containers">
    <div class="row" style="width: 103%; margin-left: 0px;">
      <div class="column" style="margin-right: 10px;">
        <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px;">
      </div>
      <div class="column" style=" width: 84%; margin-top: 4px; line-height: 15px;"> 
        <b>{{data.name}}</b>
        <p>{{data.date}}</p>
      </div>
      
      <div class="column" style="padding-right: 8px;">
      <span class="right-menu-icons">
      <div class="dropdown" >
        <span class="nav-item"  data-toggle="dropdown" v-on:click="makeActive('dropdown')" >
        <i class="icon">...</i>
        <span class="dropdown-menu dropdown-menu-right" aria-labelledby="settings" style="font-weight: 400;">
            <span class="dropdown-item dropdown-item-menu-title">
              <i class="fas fa-cog post"></i>
              <label>Post Actions</label>
              <span class="dropdown-item">
                <i class="fas fa-pencil-alt pencil"></i>
                <label style="cursor: pointer;">Edit</label>
              </span>
              <span class="dropdown-item">
                <i class="fas fa-file-alt file"></i>
                <label style="cursor: pointer;">Report</label>
              </span>
              <span class="dropdown-item">
                 <i class="fas fa-eye-slash eye-slash"></i>
                 <label style="cursor: pointer;">Hide</label>
              </span>
              <span class="dropdown-item">
                <i class="fas fa-trash-alt trash"></i>
                <label style="color: red; cursor: pointer;">Delete</label>
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
            <span class="nav-item" data-toggle="dropdown" v-on:click="makeActive('dropdown')" v-bind:onkeypress="makeActive('')">
            <i class="icon">...</i>
            <span class="dropdown-menu dropdown-menu-right" aria-labelledby="settings">
                <span class="dropdown-item dropdown-item-menu-title">
                  <i class="fas fa-cog post"></i>
                  <label>Comment Actions</label>
                  <span class="dropdown-item">
                      <i class="fas fa-pencil-alt pencil"></i>
                      <label style="cursor: pointer;">Edit</label>
                    </span>
                    <span class="dropdown-item">
                      <i class="fas fa-eye-slash eye-slash"></i>
                      <label style="cursor: pointer;">Hide</label>
                    </span>
                    <span class="dropdown-item trash">
                      <i class="fas fa-trash-alt trash"></i>
                      <label style="color: red; cursor: pointer;">Delete</label>
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
      user: AUTH.user,
      dropdown: 'dropdown-menu'
    }
  },
  methods: {
    makeActive(icon){
      if(icon === 'dropdown-menu'){
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
  font-size: 24px;
  float: right;
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
  cursor: pointer;
}
@media (max-width: 992px){
  .container{
    width: 100%;
  }
}

.dropdown-menu.show{
  position: absolute;
  margin: 40px -25px;
  
}
.dropdown-menu{
  margin-top: 40px;
  width: 240px;
  min-height: 230px;
  padding-bottom: 0px !important;

  
}
.dropdown-item .trash{
  color: red;
}
.dropdown-item{
  width: 100% !important;
  height: 40px !important;
  float: left !important;
  background: #fff !important;
  padding-top: 0px !important;
  cursor: pointer !important;
}
.dropdown-item i{
  font-size: 14px !important;
  padding-right: 10px !important;
  color: black ;
  cursor: pointer !important;
}
.dropdown-item label{
  font-size: 14px !important;
  cursor: pointer;
}
.dropdown-header{
  padding: 5px 0 10px 0;
  width: 100%;
  text-align: center;
  border-bottom: solid 1px #ccc;
}
.dropdown-item-menu-title label{
  margin-bottom: 0px;
  line-height: 40px;
  font-weight: 550;
}
.dropdown-item-menu-title:hover, .dropdown-item-menu-title label:hover{
  cursor: default;
  background: #fff !important;
}

</style>
