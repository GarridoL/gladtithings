<template>
  <div class="container">
    <div class="create-post row" style="margin-left: 0px; width: 100%;">
      <span>
        <img :src="require('src/assets/img/test.jpg')" width="50px" height="50px" style="border-radius: 25px; margin-right: 10px;">
      </span>
      <span style="width: 87%;">
        <input type="text" placeholder="Do you have something good to share?">
      </span>
    </div>
    <br>
    <div class="tabs" style="margin-bottom: 20px;">
      <button :class="firstClass" @click="messageClick()">Pope's Twitter Message</button>
      <button :class="secondClass" @click="communityClick()">Communities</button>
    </div>
    <br>
    <br>
    <div v-for="(item, index) in list" :key="index" v-if="defaults">
      <Posts
        :data="item"
      />
    <br>
    </div>
    <div v-if="message" v-for="(item, index) in tweet" :key="index">
      <div class="message">
        <div class="row" style="width: 103%; margin-left: 0px;">
          <div class="column" style="margin-right: 10px; width: 9%;">
            <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 5px; ">
          </div>
          <div class="column" style="margin-top: 6px; line-height: 10px;"> 
            <div>
              <b style="font-size:18px;">{{item.name}}</b>
              <p>{{item.date}}</p>
            </div>
          </div>
          <p style="margin-top: 10px;">{{item.text}}</p>
          </div>
        </div>
        <br>
    </div>
    <div v-if="community">
      <div class="tabTitle" >
        <p style="margin-bottom: 5px;">Communities You Manage</p>
        <i class="fas fa-plus plus"><p style="font-weight: normal; font-size: 15px; vertical-align: 4px;">&nbsp;&nbsp;&nbsp;Create</p></i>
      </div>
      <div v-for="(item, index) in comm" :key="index">
        <div class="community">
          <div class="row" style="width: 103%; margin-left: 0px;">
            <div class="column" style="margin-right: 10px; width: 9%;">
              <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 5px;">
            </div>
            <div class="column"  style="margin-top: 6px; line-height: 10px;" > 
              <div>
                <b style="font-size:18px;">{{item.name}}</b>
                <p>{{item.date}}</p>
              </div>
            </div>
          </div>
          <div style="margin-left: 15px;margin-top: 10px;">
            <i class="fas fa-bell bell" style="margin-bottom: 10px;"></i>
            <p style="font-weight: normal; display: inline; font-size: 11px; vertical-align: 1px;">&nbsp;&nbsp;&nbsp;Notifications</p>
          </div>
        </div>
      </div>
    </div>
    <br>
    <!-- manage -->
    <div v-if="community">
      <div class="tabTitle">
        <p style="margin-right: 95px;">Communities You Followed & Joined</p>
        <p style="font-weight: normal; font-size: 12px; cursor: pointer;">View Recommendation</p>
      </div>
      <div v-for="(item, index) in commFollow" :key="index">
        <div class="community">
          <div class="row" style="width: 103%; margin-left: 0px;">
            <div class="column" style="margin-right: 10px; width: 9%;">
              <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 5px;">
            </div>
            <div class="column" style="margin-top: 6px; line-height: 10px;"> 
              <div>
                <b style="font-size:18px;">{{item.name}}</b>
                <p>{{item.date}}</p>
              </div>
            </div>
          </div>
          <div style="margin-left: 15px;margin-top: 10px;">
            <i class="fas fa-ban ban" style="margin-bottom: 10px; text-align: right;"></i>
            <p style="font-weight: normal; display: inline; font-size: 11px; vertical-align: 1px;">&nbsp;&nbsp;&nbsp;Unfollow</p>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Posts from 'src/modules/generic/Posts.vue'
export default{
  props: [
    'data'
  ],
  mounted(){},
  data(){
    return {
      user: AUTH.user,
      list: [
        {
          name: 'Lalaine Garrido',
          date: 'July 8, 2021',
          text: 'We would like to thank everyone who donated to our campaigns. Heres the documentation.',
          replies: []
        },
        {
          name: 'Sim Jake',
          date: 'November 30, 2020',
          text: 'We would like to thank everyone who donated to our campaigns. Heres the documentation.',
          replies: [
            {
              name: 'Nishimura Riki',
              date: 'July 8, 2021',
              text: 'Amazing!'
            }
          ]
        },
        {
          name: 'Jay',
          date: 'August 17, 2021',
          text: 'We would like to thank everyone who donated to our campaigns. Heres the documentation.',
          replies: []
        },
        {
          name: 'Jung One',
          date: 'June 13, 2013',
          text: 'We would like to thank everyone who donated to our campaigns. Heres the documentation.',
          replies: []
        }
      ],
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
        },
        {
          name: 'Kennette Canales',
          date: 'Non Profit-20k Followers - 10k Joined'
        }
      ],
      commFollow: [
        {
          name: 'Kennette Canales',
          date: 'Non Profit-20k Followers - 10k Joined'
        },
        {
          name: 'Kennette Canales',
          date: 'Non Profit-20k Followers - 10k Joined'
        }
      ],
      defaults: true,
      message: false,
      community: false,
      firstClass: 'text-center sort-button1 mr-2',
      secondClass: 'text-center sort-button1 mr-2',
      isHidden: false
    }
  },
  components: {
    Posts
  },
  methods: {
    messageClick(){
      this.firstClass = this.firstClass + ' active'
      let classes = this.secondClass.split(' ')
      classes.splice(classes.length - 1, 1)
      this.secondClass = classes.join(' ')
      this.message = true
      this.defaults = false
      this.community = false
    },
    communityClick(){
      this.secondClass = this.secondClass + ' active'
      let classes = this.firstClass.split(' ')
      classes.splice(classes.length - 1, 1)
      this.firstClass = classes.join(' ')
      this.message = false
      this.defaults = false
      this.community = true
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
button:focus{
  outline: none;
}
.sort-button{
  margin-top: 15px;
  width: 150px;
  border: none;
  height: 40px;
  background-color: white;
  margin-left: 15px;
  float: right;
}
.bell{
  font-size: 18px;
}
.ban{
  font-size: 18px;
}
.plus{
  cursor: pointer;
  font-size: 25px;
  color: black;
  margin-left: 218px;
}
.sort-button1{
  border-radius: 25px;
  width: 200px;
  color: black;
  border: 1px solid rgb(235, 235, 235);
  height: 40px;
  background-color: white;
  margin-bottom: 10px;
  float: left;
}
.active{
  border-radius: 25px;
  width: 200px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $secondary;
  margin-bottom: 10px;
  float: left;
}
.sort-button2{
  border-radius: 25px;
  width: 200px;
  color: black;
  border: 1px solid rgb(235, 235, 235);
  height: 40px;
  background-color: white;
  margin-bottom: 10px;
  float: left;
}
.container{
  width: 50%;
  margin-bottom: 50px;
  align-items: center;
  background-color: white;
  padding: 20px;
}
.tabs-container .tabs{ 
  margin-top: 20px;
  padding: 10px;
}
.sort-button1{
  border-radius: 25px;
  width: 200px;
  color: black;
  border: 1px solid rgb(235, 235, 235);
  height: 40px;
  background-color: white;
  margin-bottom: 10px;
  float: left;
}
.active{
  border-radius: 25px;
  width: 200px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $secondary;
  margin-bottom: 10px;
  float: left;
}
.sort-button2{
  border-radius: 25px;
  width: 200px;
  color: black;
  border: 1px solid rgb(235, 235, 235);
  height: 40px;
  background-color: white;
  margin-bottom: 10px;
  float: left;
}
.message {
  text-align: justify;
  width: 100%;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  cursor: pointer;
}
.message p{
  padding-right: 15px;
}
.community {
  text-align: justify;
  width: 100%;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 10px;
  cursor: pointer;
}
.community p{
  padding-right: 15px;
}
.tabTitle{
  font-size: 16px;
  font-weight: bold;
}
.tabTitle p{
  display: inline-block;
}
.create-post{
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
}
input{
  border-radius: 20px;
  height: 40px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 5px;
  outline: none;
  width: 100%;
  padding: 15px;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
