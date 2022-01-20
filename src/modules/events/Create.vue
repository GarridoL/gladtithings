<template>
  <div class="container">
    <i class="fas fa-chevron-left mr-2" style="font-size: 22px; cursor: pointer;" @click="back()"></i>
    <span style="font-size: 22px;"><b>{{status === 'create' ? 'Create Event' : 'Update Event'}}</b></span>
    <p style="margin-top: 10px;">Fill out the details below to create an event</p>
    <p style="margin-top: 10px; color: red;">{{errorMessage}}</p>
    <div style="margin-top: 30px;">
      <p style="font-size: 18px;"><b>Basic Info</b></p>
      <p>Name your event and tell people why they should come. Add details to let attendees know what the event is all about.</p>
      <div class="default-image">
        <input type="file" ref="file" id="EventImage" :accept="'image/*'" @change="setUpFileUpload($event)" style="display: none">
        <center>
        <i class="fas fa-times-circle remove-event-photo" @click="base64 = null" v-if="base64 !== null"></i>
        <i class="far fa-image" style="font-size: 80px; color: gray;" v-if="base64 === null" @click="$refs.file.click()"></i>
        <p style="font-size: 12px;" v-if="base64 === null" @click="$refs.file.click()">Click to add featured image</p>
        <img :src="base64" width="100px" height="110px" v-if="base64 !== null" @click="$refs.file.click()"/>
        </center>
      </div>
      <div class="inputs">
        <span><b>Event Name </b><span style="color: red;">*</span></span>
        <input type="text" placeholder="Be precise and descriptive" v-model="name">
      </div>
      <div class="inputs">
        <span><b>Type </b><span style="color: red;">*</span></span>
        <select style="color: gray;" v-model="type">
          <option disabled selected>Select type</option>
          <option :value="item" v-for="(item, index) in types" :key="index">{{item}}</option>
        </select>
      </div>
      <div class="inputs">
        <span><b>Category </b><span style="color: red;">*</span></span>
        <select style="color: gray;" v-model="category">
          <option disabled selected>Select category</option>
          <option :value="item" v-for="(item, index) in categories" :key="index">{{item}}</option>
        </select>
      </div>
      <div class="inputs">
        <span><b>Event Description </b><span style="color: red;">*</span></span>
        <textarea v-model="description" class="boxsizingBorder" placeholder="Add short description about the event" rows="4"></textarea>
      </div>
    </div>
    <div style="margin-top: 30px;">
      <p style="font-size: 18px"><b>Location</b></p>
      <p>Help people in the area discover your event and let attendees know where to show up.</p>
      <div class="inputs">
        <span><b>Venue Location </b><span style="color: red;">*</span></span>
        <input v-model="location" type="text" placeholder="Enter or search venue location">
      </div>
    </div>
    <div style="margin-top: 30px; margin-bottom: 100px;">
      <p style="font-size: 18px;"><b>Date and Time</b></p>
      <p>Tell people when you event starts and ends so they can make plans to attend.</p>
      <div class="inputs">
        <span><b>Event Starts </b><span style="color: red;">*</span></span>
        <input type="date" v-model="startDate" @change="startDate > endDate ? endDate = null : startDate = startDate">
      </div>
      <div class="inputs">
        <span><b>Start time </b><span style="color: red;">*</span></span>
        <input type="time" v-model="startDateTime">
      </div>
      <div class="inputs">
        <span><b>Event Ends </b><span style="color: red;">*</span></span>
        <input type="date" v-model="endDate" :min="new Date(startDate).toISOString().split('T')[0]">
      </div>
      <div class="inputs">
        <span><b>End time </b><span style="color: red;">*</span></span>
        <input type="time" v-model="endDateTime">
      </div>
      <div class="inputs">
        <span><b>Time Zone </b><span style="color: red;">*</span></span>
        <select style="color: gray;" v-model="timeZone">
          <option disabled selected>Select time zone</option>
          <option :value="item" v-for="(item, index) in timeZones" :key="index">{{item}}</option>
        </select>
      </div>
      <button class="text-center sort-button" @click="status === 'create' ? create() : update()">{{status === 'create' ? 'Publish' : 'Update'}}</button>
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import axios from 'axios'
import CONFIG from 'src/config.js'
export default{
  mounted(){
    this.status = this.$route.params.status
    if(this.status === 'update') {
      this.retrieve(this.$route.params.id)
    }
  },
  data(){
    return {
      user: AUTH.user,
      status: 'create',
      name: null,
      description: null,
      type: null,
      category: null,
      location: null,
      startDate: null,
      startDateTime: null,
      endDate: null,
      endDateTime: null,
      timeZone: null,
      errorMessage: null,
      config: CONFIG,
      types: [
        'Appearance or Signing',
        'Attraction',
        'Camp, Trip, or Retreat',
        'Class, Training, or Workshop',
        'Concert or Performance',
        'Conference',
        'Convention',
        'Dinner or Gala',
        'Festival or Fair',
        'Game or Competition',
        'Meeting or Networking Event',
        'Other',
        'Party or Social Gathering',
        'Race or Endurance Event',
        'Rally',
        'Screening',
        'Seminar or Talk',
        'Tour',
        'Tournament',
        'Tradeshow, Consumer Show, or Expo'
      ],
      categories: [
        'Auto, Boat & Air',
        'Business & Professional',
        'Charity & Causes',
        'Community & Culture',
        'Family & Education',
        'Fashion & Beauty',
        'Film, Media & Entertainment',
        'Food & Drink',
        'Government & Policies',
        'Health & Wellness',
        'Hobbies & Special Interest',
        'Home & Lifestyle',
        'Music',
        'Other',
        'Performing & Visual Arts',
        'Religion & Spirituality',
        'School Activities',
        'Science & Technology',
        'Seasonal & Holiday',
        'Sports & Fitness',
        'Travel & Outdoor'
      ],
      timeZones: [
        'KST', 'PHT'
      ],
      base64: null,
      id: null,
      details: null
    }
  },
  methods: {
    back() {
      ROUTER.push('/events')
    },
    retrieve(id){
      let parameter = {
        condition: [{
          value: id,
          column: 'id',
          clause: '='
        }],
        sort: {created_at: 'asc'},
        limit: 1,
        offset: 0
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('events/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.name = response.data[0].name
          this.description = response.data[0].description
          this.type = response.data[0].type
          this.category = response.data[0].category
          this.location = response.data[0].location
          this.startDate = response.data[0].start_date.split(' ')[0]
          this.startDateTime = response.data[0].start_date.split(' ')[1]
          this.endDate = response.data[0].end_date.split(' ')[0]
          this.endDateTime = response.data[0].end_date.split(' ')[1]
          this.timeZone = response.data[0].time_zone
          this.base64 = response.data[0].image.length > 0 ? this.config.BACKEND_URL + response.data[0].image[0].category : null
          this.id = response.data[0].id
          this.details = response.data[0]
        }
      })
    },
    setUpFileUpload(event){
      let files = event.target.files || event.dataTransfer.files
      if(!files.length){
        return false
      }else{
        this.file = files[0]
        let filename = this.file.name.toLowerCase()
        if(filename.substring(filename.lastIndexOf('.')) === '.png' || filename.substring(filename.lastIndexOf('.')) === '.jpg' || filename.substring(filename.lastIndexOf('.')) === '.jpeg' || filename.substring(filename.lastIndexOf('.')) === '.gif' || filename.substring(filename.lastIndexOf('.')) === '.tif' || filename.substring(filename.lastIndexOf('.')) === '.bmp'){
          this.createFile(files[0])
        }else{
          this.errorMessage = 'Upload images only!'
          this.file = null
        }
      }
    },
    createFile(file){
      let fileReader = new FileReader()
      fileReader.readAsDataURL(file)
      fileReader.addEventListener('load', () => {
        this.base64 = fileReader.result
      }, false)
    },
    upload(eventId){
      console.log('upload function')
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('file_url', this.file.name.replace(' ', '_'))
      formData.append('account_id', this.user.userID)
      formData.append('category', 'event-profile')
      $('#loading').css({display: 'block'})
      axios.post(this.config.BACKEND_URL + '/images/upload?token=' + AUTH.tokenData.token, formData).then(response => {
        $('#loading').css({display: 'none'})
        let parameter = {
          account_id: this.user.userID,
          payload: 'event_id',
          category: response.data.data,
          payload_value: eventId
        }
        if(response.data) {
          $('#loading').css({display: 'block'})
          this.APIRequest('payloads/create', parameter).then(response => {
            $('#loading').css({display: 'none'})
            if(response.data) {
              this.back()
            }
          })
        }
      })
    },
    validate(array) {
      let result = false
      array.forEach(element => {
        if(element === null || element === '') {
          result = true
          return
        }
      })
      return result
    },
    create() {
      if(this.validate([this.name, this.description, this.type, this.category, this.location, this.startDate, this.startDateTime, this.endDate, this.endDateTime, this.timeZone])) {
        this.errorMessage = 'All fields are required.'
        return
      } else {
        this.errorMessage = null
      }
      let parameter = {
        account_id: this.user.userID,
        name: this.name,
        description: this.description,
        type: this.type,
        category: this.category,
        location: this.location,
        start_date: this.startDate + ' ' + this.startDateTime,
        end_date: this.endDate + ' ' + this.endDateTime,
        time_zone: this.timeZone
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('events/create', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data > 0){
          if(this.base64) {
            this.upload(response.data)
          } else {
            this.back()
          }
        }
      })
    },
    update() {
      if(this.validate([this.name, this.description, this.type, this.category, this.location, this.startDate, this.startDateTime, this.endDate, this.endDateTime, this.timeZone])) {
        this.errorMessage = 'All fields are required.'
        return
      } else {
        this.errorMessage = null
      }
      let parameter = {
        id: this.id,
        name: this.name,
        description: this.description,
        type: this.type,
        category: this.category,
        location: this.location,
        start_date: this.startDate + ' ' + this.startDateTime,
        end_date: this.endDate + ' ' + this.endDateTime,
        time_zone: this.timeZone
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('events/update', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data > 0){
          if(this.base64) {
            this.upload(this.id)
            this.removePreviousImage()
            this.back()
          } else {
            this.back()
          }
        }
      })
    },
    removePreviousImage() {
      let parameter = {
        id: this.details.image[0].id
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('payloads/delete', parameter).then(response => {
        $('#loading').css({display: 'none'})
      })
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
  border: .5px solid rgb(204, 204, 204);
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
.remove-event-photo{
  float: right;
  color: red;
  margin-top: -10px;
  margin-right: -12px;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
