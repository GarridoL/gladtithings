<template>
  <div class="container">
   <div class="create-post row" style="margin-left: 0px; width: 100%;">
    <span>
      <img :src="require('src/assets/img/test.jpg')" width="50px" height="50px" style="border-radius: 25px; margin-right: 10px;">
      </span>
    <span style="width: 90%;">
      <input type="text" placeholder="Do you have something good to share?">
    </span>
    </div>
   <div v-for="(item, index) in list" :key="index">
    <Posts
      :data="item"
    />
   </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Posts from 'src/modules/generic/Posts.vue'
export default{
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
      ]
    }
  },
  components: {
    Posts
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container{
  width: 50%;
  margin-bottom: 50px;
  align-items: center;
  background-color: white;
  padding: 20px;
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
