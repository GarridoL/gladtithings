<template>
  <div class="containers">
    <div class="row" style="width: 103%; margin-left: 0px;">
      <div class="column" style="margin-right: 10px;">
        <img :src="config.BACKEND_URL + data.account.profile.url" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px;">
      </div>
      <div class="column" style=" width: 84%; margin-top: 4px; line-height: 15px;"> 
        <b>{{data.account.information.first_name ? data.account.information.first_name + ' ' + data.account.information.last_name : data.account.username}}</b>
        <p style="font-size: 12px;">{{data.created_at_human}}</p>
      </div>
      <div class="column" style="padding-right: 8px;">
      <span class="right-menu-icons">
      <div class="dropdown" >
        <span class="nav-item"  data-toggle="dropdown" v-on:click="makeActive('dropdown')" >
        <i class="fas fa-ellipsis-h"></i>
        <Dropdown/>
        </span>
      </div>
      </span>
    </div>
    </div>
    <div style="padding: 10px;">
      <p>{{data.text}}</p>
      <PostImage :images="data.images"/>
      <i :class="data.amen.includes(user.userID) ? 'fas fa-praying-hands praying-hands-true' : 'fas fa-praying-hands praying-hands'" @click="react('amen')"></i>
      <span style=" margin-right: 50px; vertical-align: 2px;" @click="react('amen')">{{data.amen.length}}</span>
      <i :class="data.love.includes(user.userID) ? 'fas fa-heart love-true' : 'fas fa-heart love'" @click="react('love')"></i>
      <span style=" margin-right: 50px; vertical-align: 3px;" @click="react('love')">{{data.love.length}}</span>
      <i class="fas fa-share share"></i>
      <span style=" margin-right: 50px; vertical-align: 3px;">Share</span>
    </div>
    <div style="width: 100%; margin-left: 0px; margin: 10px;" v-if="data.comment_replies && data.comment_replies.length > 0">
      <div class="row" style="margin-left: 15px;" v-for="(item, index) in data.comment_replies" :key="index">
        <div class="column" style="margin-right: 10px;">
          <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px;">
        </div>
        <div class="column" style="width: 82%; margin-top: 4px; line-height: 15px;">
          <b>{{item.account.information.first_name ? item.account.information.first_name + ' ' + item.account.information.last_name : item.account.username}}</b>
          <p style="font-size: 12px;">{{item.created_at}}</p>
        </div>
        <div class="column" style="width: 5%;">
          <span class="right-menu-icons">
          <div class="dropdown">
            <span class="nav-item" data-toggle="dropdown" v-on:click="makeActive('dropdown')" v-bind:onkeypress="makeActive('')">
            <i class="fas fa-ellipsis-h"></i>
            <Dropdown/>
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
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Dropdown from 'src/modules/generic/Dropdown'
import PostImage from 'src/modules/generic/PostImage'
export default{
  props: ['data'],
  data(){
    return {
      user: AUTH.user,
      dropdown: 'dropdown-menu',
      config: CONFIG
    }
  },
  components: {
    Dropdown,
    PostImage
  },
  methods: {
    makeActive(icon){
      if(icon === 'dropdown-menu'){
        this.settingFlag = true
        this.menuFlag = true
        this.notifFlag = false
      }
    },
    react(react) {
      let list = []
      if(react === 'amen') {
        list = this.data.amen
      } else {
        list = this.data.love
      }
      if(list.includes(this.user.userID) === false) {
        let parameter = {
          reaction: react,
          comment_id: this.data.id,
          account_id: this.user.userID
        }
        $('#loading').css({display: 'block'})
        this.APIRequest('reactions/create', parameter).then(response => {
          $('#loading').css({display: 'none'})
          if(response.data > 0) {
            if(react === 'amen') {
              this.data.amen.push(this.user.userID)
            } else {
              this.data.love.push(this.user.userID)
            }
          }
        })
      } else {
        this.removeReaction(react)
      }
    },
    removeReaction(react) {
      let parameter = {
        account_id: this.user.userID,
        comment_id: this.data.id,
        reaction: react
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('reactions/remove_reaction', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(react === 'amen') {
          let i = this.data.amen.indexOf(this.user.userID)
          this.data.amen.splice(i, 1)
        } else {
          let i = this.data.love.indexOf(this.user.userID)
          this.data.love.splice(i, 1)
        }
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.inputs{
  border-radius: 20px;
  height: 40px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 5px;
  outline: none;
  width: 95%;
  padding: 15px;
}
.love, .share, .praying-hands{
  font-size: 20px;
  color: $secondary;
}

.love-true, .praying-hands-true{
  font-size: 20px;
  color: $primary;
}
.containers{
  width: 100%;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  cursor: pointer;
}
</style>
