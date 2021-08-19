<template>
  <div class="container">
    <h3 style="margin-left: -13px;">Church Details</h3>
    <div class="row" style="width: 100%; margin-top: 10px;">
      <div class="column" style="width: 60%; margin-right: 10%;">
      <label><b>Name&nbsp;</b><span style="color: red;">*</span></label><br>
      <input placeholder="Name" class="generic-input">
      <label><b>Address&nbsp;</b><span style="color: red;">*</span></label><br>
      <input placeholder="Address" class="generic-input">
      </div>
      <div class="column" style="width: 20%; text-align: center;">
        <div class="no-image">
        </div>
        <p>Click to edit profile</p>
        <!-- <p>Click to edit profile</p> -->
      </div>
    </div>
    <button class="text-center sort-button">Update</button>
    <div>
      <h3 style="margin-bottom: 15px;">Mass Schedules</h3>
      <input type="checkbox">&nbsp;&nbsp;Monday
      <Cards
        :data="list"
      />
      <input type="checkbox">&nbsp;&nbsp;Monday
      <Cards
        :data="list1"
      />
   </div>
   <button class="text-center sort-button">Update</button>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Cards from 'src/modules/generic/ScheduleCard.vue'
import Input from 'src/modules/generic/InputField.vue'
export default{
  mounted(){},
  data(){
    return {
      user: AUTH.user,
      list: [
        {
          time: '1:30-2:00 PM',
          name: 'Fr. Arnold Jansen',
          language: 'English'
        },
        {
          time: '1:30-2:00 PM',
          name: 'Fr. Arnold Jansen',
          language: 'English'
        },
        {
          time: '1:30-2:00 PM',
          name: 'Fr. Arnold Jansen',
          language: 'English'
        },
        {
          time: '1:30-2:00 PM',
          name: 'Fr. Arnold Jansen',
          language: 'English'
        },
        {
          time: '1:30-2:00 PM',
          name: 'Fr. Arnold Jansen',
          language: 'English'
        }
      ],
      list1: [
        {
          time: '1:30-2:00 PM',
          name: 'Fr. Arnold Jansen',
          language: 'English'
        },
        {
          time: '1:30-2:00 PM',
          name: 'Fr. Arnold Jansen',
          language: 'English'
        },
        {
          time: '1:30-2:00 PM',
          name: 'Fr. Arnold Jansen',
          language: 'English'
        }
      ]
    }
  },
  components: {
    Cards,
    Input
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.sort-button{
  border-radius: 25px;
  width: 150px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $secondary;
  margin-bottom: 50px;
}
button:focus{
  outline: none;
}
label{
  margin-top: 5px;
}
.generic-input{
  height: 40px;
  width: 100%;
  border-radius: 20px;
  border: .5px solid rgb(204, 204, 204);
  outline: none;
  padding: 10px;
  margin-bottom: 20px;
}
.container{
  width: 60%;
  margin-top: 15px;
  margin-bottom: 50px;
  align-items: center;
}
.no-image{
  background-color: $primary;
  height: 200px;
  width: 200px;
  float: right;
  border-radius: 100px;
  margin-bottom: 10px;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
  .no-image{
    background-color: $primary;
    height: 100px;
    width: 100px;
    float: right;
    border-radius: 100px;
    margin-bottom: 10px;
  }
}
</style>
