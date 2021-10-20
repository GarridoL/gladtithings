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
    <div class="tabs" style="margin-bottom: 30px;">
      <button :class="secondClass" @click="communityClick()">Communities</button>
      <button :class="firstClass" @click="messageClick()">Pope's Messages</button>
    </div>
    <br>
    <br>
    <div v-for="(item, index) in list" :key="index" v-if="defaults">
      <Posts
        :data="item"
      />
    <br>
    </div>
    <!-- tweets -->
    <div v-if="message" v-for="(item, index) in tweet" :key="index">
      <div class="message">
        <div class="row" style="width: 103%; margin-left: 0px;">
          <div class="column" style="padding-right: 8px;">
            <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px; ">
          </div>
          <div class="column" style="width: 82%; margin-top: 4px; line-height: 15px;"> 
            <div >
              <b style="font-size: 14px;">{{item.name}}</b>
              <p style="font-size: 12px;">{{item.date}}</p>
            </div>
          </div>
          <br>
          <br>
          <br>
          <p style="margin-left: 15px; padding-right: 30px;">{{item.text}}</p>
          </div>
        </div>
        <br>
    </div>
        <!-- recommendation -->
    <div v-if="recommendation">
      <div class="tabTitle">
        <b>Communities You Might Interested In</b>
      </div>
      <div v-for="(item, index) in commFollow" :key="index">
        <div class="community">
          <div class="row" style="width: 103%; margin-left: 0px;">
            <div class="column" style="padding-right: 8px;">
              <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px;">
            </div>
            <div  class="column" style=" margin-top: 4px; line-height: 15px;"> 
              <div>
                <b style="font-size: 14px;">{{item.name}}</b>
                <p style="font-size: 12px;">{{item.date}}</p>
              </div>
            </div>
          </div>
          <div style="margin-left: 15px;margin-top: 10px;">
            <i class="fas fa-users" style="margin-bottom: 10px; "></i>
            <p style="display: inline; font-size: 11px; vertical-align: 1px;">&nbsp;&nbsp;Follow and Join</p>
          </div>
        </div>
      </div>
    </div>
    <!-- create community -->
    <div v-if="community">
      <div class="tabTitle" >
        <p style="margin-bottom: 5px; font-weight: 700;">Communities You Manage</p>
        <button class="fas fa-plus plus" @click="redirect('community/create')">&nbsp;&nbsp;<p>Create</p></button>
      </div>
      <div v-for="(item, index) in comm" :key="index">
        <div class="community">
          <div class="row" style="width: 103%; margin-left: 0px;">
            <div class="column" style="padding-right: 8px;">
              <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px;">
            </div>
            <div class="column"  style=" margin-top: 4px; line-height: 15px;"> 
              <div>
                <b style="font-size: 14px;">{{item.name}}</b>
                <p style="font-size: 12px;">{{item.date}}</p>
              </div>
            </div>
          </div>
          <div style="margin-left: 15px;margin-top: 10px;">
            <i class="fas fa-bell bell" style="margin-bottom: 10px;"></i>
            <p  style="font-weight: normal; display: inline; font-size: 10px; vertical-align: 1px;">&nbsp;&nbsp;Notifications</p>
          </div>
        </div>
      </div>
    </div>
    <br>
    <!-- manage -->
    <div v-if="community">
      <div class="tabTitle">
        <b>Communities You Followed & Joined</b>
        <button @click="recommendationClick()" class="recommendation"><p>View Recommendation</p></button>
      </div>
      <div v-for="(item, index) in commFollow" :key="index">
        <div class="community">
          <div class="row" style="width: 103%; margin-left: 0px;">
            <div class="column" style="padding-right: 8px;">
              <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px; margin-left: 2px;">
            </div>
            <div  class="column" style="margin-top: 4px; line-height: 15px;"> 
              <div>
                <b style="font-size: 14px;">{{item.name}}</b>
                <p style="font-size: 12px;">{{item.date}}</p>
              </div>
            </div>
          </div>
          <div style="margin-left: 15px;margin-top: 10px;">
            <i class="fas fa-ban ban" style="margin-bottom: 10px; text-align: right;"></i>
            <p style="font-weight: normal; display: inline; font-size: 10px; vertical-align: 1px;">&nbsp;&nbsp;Unfollow</p>
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
      recommendation: false,
      firstClass: 'text-center sort-button1 mr-2',
      secondClass: 'text-center sort-button1 mr-2'
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
      this.recommendation = false
    },
    communityClick(){
      this.secondClass = this.secondClass + ' active'
      let classes = this.firstClass.split(' ')
      classes.splice(classes.length - 1, 1)
      this.firstClass = classes.join(' ')
      this.message = false
      this.defaults = false
      this.community = true
      this.recommendation = false
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
button:focus{
  outline: none;
}
.sort-button{
  margin-top: 15px;
  width: 150px;
  border: none;
  height: 40px;
  background-color: $white;
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
  padding: 0px;
  width: 70px;
  border: none;
  background-color: $white;
  font-size: 18px; 
  margin-top: 5px;
  float: right;
}
.plus p{
  font-family: Poppins;
  font-weight: normal;
  font-size: 10px;
  vertical-align: 3px;
  
}
.container{
  width: 50%;
  margin-bottom: 50px;
  align-items: center;
  background-color: $white;
  padding: 20px;
}
.tabs-container .tabs{ 
  margin-top: 20px;
  padding: 10px;
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
.message {
  text-align: justify;
  width: 100%;
  background-color: $white;
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
  background-color: $white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 10px;
  cursor: pointer;
}
.community p{
  padding-right: 15px;
}
.tabTitle p{
  display: inline-block;
  color: #000000;
  font-weight: normal;
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
