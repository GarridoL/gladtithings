<template>
  <div class="containers">
    <div class="row con" v-if="data.shared !== null">
      <div class="column" style="margin-right: 10px;">
        <img :src="data.shared.account.profile !== null ? config.BACKEND_URL + data.shared.account.profile.url : require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px;">
      </div>
      <div class="column con-username"> 
        <b>{{data.shared.account.username}}</b>
        <p style="font-size: 12px;">{{data.shared.created_at_human}}</p>
      </div>
      <div class="column con-icon">
        <span class="right-menu-icons">
        <div class="dropdown">
          <span class="nav-item"  data-toggle="dropdown" v-on:click="makeActive('dropdown')" >
          <i class="fas fa-ellipsis-h"></i>
          <Dropdown ref="dropdown" :account_id="data.shared.account_id" :id="data.id" :text="data.text" :images="data.images"/>
          </span>
        </div>
        </span>
      </div>
    </div>
    <p class="shared-text" v-if="data.shared !== null">{{data.shared.text}}</p>
    <div class="row comment-con">
      <div class="column comment-con-image">
        <img :src="data.account.profile && data.account.profile.url ? config.BACKEND_URL + data.account.profile.url : require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px;">
      </div>
      <div class="column comment-username"> 
        <b>{{data.account.username}}</b>
        <p style="font-size: 12px;">{{data.created_at_human}}</p>
      </div>
      <div class="column on-icon">
        <span class="right-menu-icons">
        <div class="dropdown" v-if="data.shared === null">
          <span class="nav-item"  data-toggle="dropdown" v-on:click="makeActive('dropdown')" >
          <i class="fas fa-ellipsis-h"></i>
          <Dropdown ref="dropdown" :account_id="data.account_id" :id="data.id" :text="data.text" :images="data.images"/>
          </span>
        </div>
        </span>
      </div>
    </div>
    <div class="body-comment">
      <p style="word-wrap: break-word;">{{data.text}}</p>
      <PostImage :images="data.images"/>
      <i :class="data.amen.includes(user.userID) ? 'fas fa-praying-hands praying-hands-true' : 'fas fa-praying-hands praying-hands'" @click="react('amen')"></i>
      <span class="amen-span" @click="react('amen')">{{data.amen.length}}</span>
      <i :class="data.love.includes(user.userID) ? 'fas fa-heart love-true' : 'fas fa-heart love'" @click="react('love')"></i>
      <span class="amen-span" @click="react('love')">{{data.love.length}}</span>
      <i class="fas fa-share share" @click="shareModalShow()" ></i>
    </div>
    <div class="comment-replies" v-if="data.comment_replies && data.comment_replies.length > 0">
      <div style="margin-left: 15px;" v-for="(item, index) in data.comment_replies" :key="index">
        <div class="row">
          <div class="column" style="margin-right: 10px;">
            <img :src="item.account.profile && item.account.profile.url ? config.BACKEND_URL + item.account.profile.url : require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px;">
          </div>
          <div class="column" style="username-column">
            <b>{{item.account.username}}</b>
            <p style="font-size: 12px;">{{item.created_at}}</p>
          </div>
        </div>
        <p style="margin: 10px; margin-top: 10px; word-wrap: break-word;">{{item.text}}</p>
      </div>
    </div>
    <div style="width: 100%; margin-left: 0px; margin: 10px;">
      <input type="text" class="inputs" placeholder="Type here" v-on:keyup.enter="reply()" v-model="replyHere">
    </div>
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Share this post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" @click="closeModal()">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="text" class="inputs-share" placeholder="Say something about this post." v-model="status" v-on:keyup.enter="sharePost">
          </div>
        </div>
      </div>
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
      config: CONFIG,
      replyHere: null,
      status: null
    }
  },
  components: {
    Dropdown,
    PostImage
  },
  methods: {
    makeActive(icon){
      this.$refs.dropdown.forEdit = this.data
    },
    shareModalShow() {
      this.status = null
      $('#shareModal').modal('show')
    },
    closeModal() {
      $('#shareModal').modal('hide')
    },
    sharePost() {
      if(this.status === null || this.status === '') {
        return
      }
      let parameter = {
        account_id: this.user.userID,
        text: this.status,
        comment_id: this.data.id
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('share_posts/create', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data > 0) {
          $('#shareModal').modal('hide')
        }
        let par = {
          account_id: this.data.account_id,
          payload: 'share_post_id',
          payload_value: response.data,
          text: this.data.text,
          to: this.user.userID,
          from: this.user.userID,
          route: 'statusStack'
        }
        $('#loading').css({display: 'block'})
        this.APIRequest('comments/create', par).then(res => {
          $('#loading').css({display: 'none'})
        })
      })
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
    },
    removePost(id) {
      this.$parent.removePost(id)
    },
    updateText(text) {
      this.data.text = text
    },
    reply() {
      let parameter = {
        text: this.replyHere,
        comment_id: this.data.id,
        account_id: this.user.userID
      }
      let newReply = {
        account: {
          information: this.user.information,
          profile: this.user.profile,
          ...this.user
        },
        ...parameter
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('comment_replies/create', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data) {
          this.replyHere = null
          if(this.data.comment_replies === null) {
            this.data.comment_replies = []
            this.data.comment_replies[0] = newReply
          } else {
            this.data.comment_replies.push(newReply)
          }
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
.shared-text{
  word-wrap: break-word;
  border-bottom: .5px solid rgb(235, 235, 235);
  padding: 10px;
}
.comment-con{
  width: 103%;
  margin-left: 0px;
}
.con-username{
   width: 84%;
   margin-top: 4px;
   line-height: 15px;
}
.comment-username{
  width: 84%;
  margin-top: 4px;
  line-height: 15px;
}
.con-icon{
  padding-right: 8px;
}
.comment-replies{
  width: 100%;
  margin-left: 0px;
  margin: 10px;
}
.amen-span{
  margin-right: 50px;
  vertical-align: 2px;
}
.comment-con-image{
  margin-right: 10px;
}
.inputs-share{
  border-top-style: hidden;
  border-right-style: hidden;
  border-left-style: hidden;
  border-bottom-style: hidden;
  margin-bottom: 20px;
  width: 460px;
  height: 40px;
  margin-left: -10px;
}
input:focus, textarea:focus, select:focus{
  outline: none;
}
.con{
  width: 103%;
  margin-left: 0px;
}
.username-column{
  width: 82%;
  margin-top: 4px;
  line-height: 15px;
}
.body-comment {
  border-bottom: .5px solid rgb(245, 244, 244);
  padding: 10px;
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
