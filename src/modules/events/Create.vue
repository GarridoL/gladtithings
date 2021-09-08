<template>
  <div class="container">
    <i class="fas fa-chevron-left mr-2" style="font-size: 22px; cursor: pointer;" @click="back()"></i>
    <span style="font-size: 22px;"><b>{{status === 'create' ? 'Create Event' : 'Update Event'}}</b></span>
    <p style="margin-top: 10px;">Fill out the details below to create an event</p>
    <div style="margin-top: 30px;">
      <p><b>Basic Info</b></p>
      <p>Name your event and tell people why they should come. Add details to let attendees know what the event is all about.</p>
      <div class="default-image">
        <center>
        <i class="far fa-image" style="font-size: 80px; color: gray;"></i>
        <p style="font-size: 12px;">Click to add featured image</p>
        </center>
      </div>
      <div class="inputs">
        <span>First name: <span style="color: red;">*</span></span>
        <input type="text" placeholder="Be precise and descriptive">
      </div>
      <div class="inputs">
        <span>Type: <span style="color: red;">*</span></span>
        <select style="color: gray;">
          <option value="" disabled selected>Select type</option>
          <option value="test">Test</option>
        </select>
      </div>
      <div class="inputs">
        <span>Category: <span style="color: red;">*</span></span>
        <select style="color: gray;">
          <option value="" disabled selected>Select category</option>
          <option value="test">Test</option>
        </select>
      </div>
      <div class="inputs">
        <span>Event name: <span style="color: red;">*</span></span>
        <textarea class="boxsizingBorder" placeholder="Add short description about the event" rows="4"></textarea>
      </div>
    </div>
    <div style="margin-top: 50px;">
      <p><b>Basic Info</b></p>
      <p>Help people in the area discover your event and let attendees know where to show up.</p>
      <div class="inputs">
        <span>Venue Location: <span style="color: red;">*</span></span>
        <input type="text" placeholder="Enter or search venue location">
      </div>
    </div>
    <div style="margin-top: 30px; margin-bottom: 100px;">
      <p><b>Date and Time</b></p>
      <p>Tell people when you event starts and ends so they can make plans to attend.</p>
      <div class="inputs">
        <span>Event Starts: <span style="color: red;">*</span></span>
        <input type="date">
      </div>
      <div class="inputs">
        <span>Start time: <span style="color: red;">*</span></span>
        <input type="time">
      </div>
      <div class="inputs">
        <span>Event Ends: <span style="color: red;">*</span></span>
        <input type="date">
      </div>
      <div class="inputs">
        <span>End time: <span style="color: red;">*</span></span>
        <input type="time">
      </div>
      <div class="inputs">
        <span>Time Zone: <span style="color: red;">*</span></span>
        <select style="color: gray;">
          <option value="" disabled selected>Select time zone</option>
          <option value="test">Test</option>
        </select>
      </div>
      <button class="text-center sort-button">Publish</button>
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
export default{
  mounted(){
    this.status = this.$route.params.status
  },
  data(){
    return {
      user: AUTH.user,
      status: 'create'
    }
  },
  methods: {
    back() {
      ROUTER.push('/events')
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
  margin-top: 50px;
  border-radius: 25px;
  width: 120px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $primary;
  float: right;
}
input, textarea, select {
  border-style: hidden;
  width: 100%;
  outline: none;
}
.boxsizingBorder {
  width: 100%;
}
.inputs{
  border-top: .5px solid rgb(204, 204, 204);
  border-right: .5px solid rgb(204, 204, 204);
  width: 100%;
  margin-bottom: 10px;
  padding: 5px;
}
.container{
  width: 60%;
  background-color: white;
  padding: 30px;
}
.default-image{
  border: 1px solid rgb(204, 204, 204);
  width: 130px;
  padding: 15px;
  cursor: pointer;
  margin-bottom: 10px;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
