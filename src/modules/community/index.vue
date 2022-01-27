<template>
  <div class="container">
    <div class="create-post row">
      <div class="image">
        <img :src="user.profile && user.profile.url ? config.BACKEND_URL + user.profile.url : require('src/assets/img/test.jpg')" width="100%" height="100%" class="image-post">
      </div>
        <textarea wrap="off" cols="50" rows="5" class="input-post" v-on:keyup.enter="createPost()" v-model="input" placeholder="Do you have something good to share?"></textarea>
        <i class="fas fa-paper-plane send-post" @click="createPost()"></i>
        <i class="fas fa-images add-image" @click="showModalCreate()"></i>
    </div>
    <br>
    <div class="tabs" style="margin-bottom: 30px;">
      <button :class="secondClass" @click="communityClick()">Communities</button>
      <button :class="firstClass" @click="messageClick()">Pope's Messages</button>
    </div>
    <br>
    <br>
    <div v-for="(item, index) in posts" :key="index" v-if="defaults">
      <Posts
        :data="item"
      />
    <br>
    </div>
    <div v-if="message" v-for="(item, index) in tweet" :key="index">
       <Twitter
        :name="item.name"
        :date="item.date"
        :text="item.text"
      />
    </div>
    <div v-if="recommendation">
      <div class="tabTitle">
        <p style="margin: 0px;"><b>Communities You Might Interested In</b></p>
      </div>
      <div v-for="(item, index) in comm" :key="index">
        <CommunityCard
          :name="item.name"
          :date="item.date"
          :text="item.text"
          :icon="'fas fa-users'"
          :iconText="'Follow and Join'"
        />
      </div>
    </div>
    <div v-if="community">
      <div class="tabTitle" >
        <p style="margin: 0px;"><b>Communities You Manage</b></p>
        <p class="plus-text" style="cursor: pointer;" @click="redirect('community/create')">Create</p>
        <button class="fas fa-plus plus" @click="redirect('community/create')"></button>
      </div>
      <div v-for="(item, index) in comm" :key="index">
        <CommunityCard
          :name="item.name"
          :date="item.date"
          :text="item.text"
          :icon="'fas fa-bell'"
          :iconText="'Notification'"
        />
      </div>
    </div>
    <br>
    <div v-if="community">
      <div class="tabTitle">
        <p style="margin: 0px;"><b>Communities You Followed & Joined</b></p>
        <button @click="recommendationClick()" class="recommendation"><p>View Recommendation</p></button>
      </div>
      <div v-for="(item, index) in comm" :key="index">
        <CommunityCard
          :name="item.name"
          :date="item.date"
          :text="item.text"
          :icon="'fas fa-ban'"
          :iconText="'Unfollow'"
        />
      </div>
    </div>
    <CreatePost ref="createPost"/>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import Posts from 'src/modules/generic/Posts.vue'
import Twitter from 'src/modules/community/TwitterCard'
import CommunityCard from 'src/modules/community/CommunityCard'
import CreatePost from 'src/modules/community/CreatePost'
import CONFIG from 'src/config.js'
export default{
  mounted(){
    this.retrieve()
    console.log(this.user)
  },
  data(){
    return {
      user: AUTH.user,
      posts: [],
      config: CONFIG,
      tweet: [
        {
          name: 'Pope Francis',
          date: 'Just Now',
          text: 'Witnesses do not lose themselves in words, but rather they bear fruit. They do not complain about others and the world, but start with themselves. They remind us that God is not to be proven, but shown; not announced with proclamations but witnessed by example.'
        },
        {
          name: 'Pope Francis',
          date: 'June 13, 2013',
          text: 'The Eucharist is here to remind us who God is. It does not do so just in words, but in a concrete way, showing us God as bread broken, as love crucified and bestowed. #EucharisticCongress #Budapest'
        },
        {
          name: 'Pope Francis',
          date: 'April 20, 1999',
          text: 'A little bit of mercy makes the world less cold and more just.'
        }
      ],
      comm: [
        {
          name: 'Kennette Canales',
          date: 'Non Profit-20k Followers - 10k Joined'
        }
      ],
      defaults: true,
      message: false,
      community: false,
      recommendation: false,
      firstClass: 'text-center sort-button1 mr-2',
      secondClass: 'text-center sort-button1 mr-2',
      input: null
    }
  },
  components: {
    Posts,
    Twitter,
    CommunityCard,
    CreatePost
  },
  methods: {
    showModalCreate() {
      $('#createPost').modal('show')
    },
    createPost() {
      if(this.input === null || this.input === '') {
        return
      }
      let parameter = {
        account_id: this.user.userID,
        payload: 'account_id',
        payload_value: this.user.userID,
        text: this.input || ' ',
        to: this.user.id,
        from: this.user.id,
        route: 'statusStack'
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('comments/create', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data > 0) {
          this.input = null
          this.$refs.createPost.upload(response.data)
        }
      })
    },
    retrieve(){
      let parameter = {
        limit: 5,
        offset: 0,
        sort: {
          created_at: 'desc'
        }
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('comments/retrieve_comments_with_images', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0) {
          this.posts = response.data
        }
      })
    },
    removePost(id) {
      this.retrieve()
    },
    messageClick(){
      if(!this.message) {
        this.firstClass = this.firstClass + ' active'
        let classes = this.secondClass.split(' ')
        classes.splice(classes.length - 1, 1)
        this.secondClass = classes.join(' ')
        this.message = true
        this.defaults = false
        this.community = false
        this.recommendation = false
      }
    },
    communityClick(){
      if(!this.community) {
        this.secondClass = this.secondClass + ' active'
        let classes = this.firstClass.split(' ')
        classes.splice(classes.length - 1, 1)
        this.firstClass = classes.join(' ')
        this.message = false
        this.defaults = false
        this.community = true
        this.recommendation = false
      }
    },
    recommendationClick(){
      this.recommendation = true
      this.message = false
      this.community = false
    },
    redirect(route){
      ROUTER.push(route)
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.input-post{
  outline: none;
  overflow:hidden;
  border-radius: 20px;
  height: 40px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 5px;
  padding-top: 10px;
  padding-left: 5px;
  outline: none;
  width: calc(100% - 140px);
  margin-right: 10px;
  margin-left: 10px;
}
.image-post {
  border-radius: 25px;
  margin-right: 10px;
}
button:focus{
  outline: none;
}
.add-image{
  font-size: 2em;
  width: 33px;
  cursor: pointer;
}
.send-post{
  font-size: 1.8em;
  width: 33px;
  color: $primary;
  cursor: pointer;
}
.plus-text{
  float: right;
  padding: 5px;
  font-size: 13px;
}
.plus{
  padding: 5px;
  background-color: $white;
  border: none;
  font-size: 18px; 
  float: right;
}
.container{
  width: 50%;
  margin-bottom: 50px;
  align-items: center;
  background-color: $white;
  padding: 20px;
}
.sort-button1{
  border-radius: 25px;
  width: 200px;
  height: 50px;
  color: $secondary;
  border: 1px solid rgb(235, 235, 235);
  background-color: $white;
  margin-right: 10px;
  margin-bottom: 10px;
  float: left;
}
.active{
  border-radius: 25px;
  width: 200px;
  height: 50px;
  color: $white;
  border: 0px;
  background-color: $secondary;
  margin-bottom: 10px;
  margin-right: 13px;
  float: left;
}
.recommendation{
  padding: 0px;
  border: none;
  background-color: $white;
  font-size: 10px; 
  margin-top: 5px;
  float: right;
  line-height: 12px;
}
.tabTitle p{
  display: inline-block;
}
.create-post{
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-left: 0px;
  width: 100%;
  align-items: center;
}
input{
  border-radius: 20px;
  height: 40px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 5px;
  outline: none;
  width: calc(100% - 110px);
  margin-right: 10px;
  margin-left: 10px;
}
.image{
  width: 50px;
  height: 50px;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
