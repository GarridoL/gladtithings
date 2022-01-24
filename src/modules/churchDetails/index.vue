<template>
  <div class="container" v-if="afterLoad">
    <h3>Church Details</h3>
    <div class="row top">
      <div class="column" style="width: 60%; margin-right: 10%;">
        <span class="error text-danger" v-if="errorMessage">
          <b>Oops!</b> {{errorMessage}}
        </span>
        <span class="success" v-if="successMessage">
          {{successMessage}}
        </span>
        <br>
        <label><b>Name&nbsp;</b><span style="color: red;">*</span></label><br>
        <input placeholder="Name" class="generic-input" v-model="name">
        <!-- <label><b>Address&nbsp;</b><span style="color: red;">*</span></label><br>
        <input placeholder="Address" class="generic-input" v-model="address"> -->
        <label><b>Address&nbsp;</b><span style="color: red;">*</span></label><br>
        <location-merchant @onFinish="getResult($event)" :property="property"></location-merchant><br>
      </div>
      <div class="column" style="width: 20%; text-align: center;">
        <div class="no-image" v-if="logo === null" >
        </div>
        <span class="image" v-else>
          <img :src="config.BACKEND_URL + logo" style="background-size: cover; border-radius: 100px;"  height="160px" width="160px" >
        </span>
        <p style="cursor: pointer; margin-top: 10px;" @click="showImages()">Click to edit profile</p>
      </div>
    </div>
    <button class="text-center sort-button" @click="update()">Update</button>
    <featured-images-modal ref="featured" :object="photoObject"></featured-images-modal>
    <div>
      <h3 style="margin-bottom: 15px;">Mass Schedules</h3>
      <span class="error text-danger" v-if="errorMessage1">
          <b>Oops!</b> {{errorMessage1}}
        </span>
        <span class="success" v-if="successMessage1">
          {{successMessage1}}
        </span>
        <br>
      <br>
      <div v-for="(item, index) in days" :key="index">
        <Cards
          :data="item.schedule"
          :title="item.title"
        />
      </div>
    </div>
    <button class="text-center sort-button" @click="updateSchedule()">Update</button>
    <browse-images-modal :object="user.profile"></browse-images-modal>

<!-- Modal -->
    <div class="modal fade" id="addSched">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Schedule</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span class="error text-danger" v-if="modalErrorMessage">
              <b>Oops!</b> {{modalErrorMessage}}
            </span>
            <br>
            <span class="error text-danger" v-if="dateErrorMessage">
              <b>Oops!</b> {{dateErrorMessage}}
            </span>
            <div class="row time-row">
              <div class="column time">
                <label><b>Start Time&nbsp;</b><span style="color: red;">*</span></label><br>
                <input placeholder="Start Time" class="generic-input" type="time" v-model="item.startTime" v-if="item" @change="checkTime(item.startTime, item.endTime)">
                <input placeholder="Start Time" class="generic-input" type="time" v-model="schedStartTime" v-else @change="checkTime(schedStartTime, schedEndTime)">
              </div>
               <div class="column time">
                <label><b>End Time&nbsp;</b><span style="color: red;">*</span></label><br>
                <input placeholder="End Time" class="generic-input" type="time" v-model="item.endTime" v-if="item" @change="checkTime(item.startTime, item.endTime)">
                <input placeholder="End Time" class="generic-input" type="time" v-model="schedEndTime" v-else @change="checkTime(schedStartTime, schedEndTime)">
              </div>
            </div>
            <label><b>Presider&nbsp;</b><span style="color: red;">*</span></label><br>
            <input placeholder="Presider" class="generic-input" v-model="item.name" v-if="item">
            <input placeholder="Presider" class="generic-input" v-model="schedName" v-else>
            <label><b>Language&nbsp;</b><span style="color: red;">*</span></label><br>
            <input placeholder="Language" class="generic-input" v-model="item.language" v-if="item">
            <input placeholder="Language" class="generic-input" v-model="schedLanguage" v-else>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="addToSchedulePerDay(item ? 'update' : 'add')">{{item ? 'Update' : 'Add'}}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Cards from 'src/modules/generic/ScheduleCard.vue'
import Input from 'src/modules/generic/InputField.vue'
export default{
  mounted(){
    this.retrieve()
    this.retrieveFeaturedPhotos()
  },
  data(){
    return {
      user: AUTH.user,
      name: null,
      address: null,
      successMessage: null,
      errorMessage: null,
      modalErrorMessage: null,
      errorMessage1: null,
      successMessage1: null,
      church: null,
      logo: null,
      config: CONFIG,
      schedName: null,
      schedLanguage: null,
      schedStartTime: null,
      schedEndTime: null,
      selectedDay: null,
      days: [
        {title: 'Sunday', schedule: []},
        {title: 'Monday', schedule: []},
        {title: 'Tuesday', schedule: []},
        {title: 'Wednesday', schedule: []},
        {title: 'Thursday', schedule: []},
        {title: 'Friday', schedule: []},
        {title: 'Saturday', schedule: []}
      ],
      item: null,
      images: [],
      photoObject: {
        url: null
      },
      dateErrorMessage: null,
      status: 'create',
      property: {
        value: null,
        style: {
          height: '40px !important',
          'border-radius': '50px'
        },
        GOOGLE_API_KEY: CONFIG.GOOGLE.API_KEY,
        results: {
          style: {
          }
        },
        placeholder: null
      },
      afterLoad: false
    }
  },
  components: {
    Cards,
    Input,
    'featured-images-modal': require('modules/churchDetails/FeaturedPhotos.vue'),
    'browse-images-modal': require('components/increment/generic/image/BrowseModal.vue'),
    'location-merchant': require('components/increment/settings/MerchantLocation.vue')
  },
  methods: {
    getResult($event) {
      if($event !== null) {
        let address = {
          name: $event.formatted_address,
          latitude: $event.latitude,
          longitude: $event.longitude
        }
        this.address = JSON.stringify(address)
      } else {
        // this.data.address = null
      }
    },
    checkTime(startTime, endTime) {
      let a = null
      let b = null
      if(startTime) {
        a = new Date(`01-01-2021 ${startTime}:00`)
      }
      if(endTime) {
        b = new Date(`01-01-2021 ${endTime}:00`)
      }
      if((a && a.getTime()) === (b && b.getTime())) {
        this.dateErrorMessage = 'Start time and End time should not be equal.'
      } else if((a && a.getTime()) > (b && b.getTime())) {
        this.dateErrorMessage = 'Start time should be less than the end time.'
      } else {
        this.dateErrorMessage = null
      }
    },
    updateSchedule(){
      let status = false
      this.days.forEach(element => {
        if(element.schedule.length > 0) {
          status = true
        }
      })
      let parameter = {
        id: this.church.id,
        schedule: status === false ? null : JSON.stringify(this.days)
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('account_merchants/update', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data) {
          this.errorMessage1 = null
          this.successMessage1 = 'Successfully updated.'
        }
      })
    },
    remove(index) {
      let i = this.days.map(e => e.title).indexOf(this.selectedDay)
      this.days[i].schedule.splice(index, 1)
    },
    addSchedModal(item, index) {
      if(item !== null && index !== null) {
        item['index'] = index
        this.item = item
      }
      this.modalErrorMessage = null
      this.dateErrorMessage = null
      $('#addSched').modal('show')
    },
    addToSchedulePerDay(option) {
      if(option === 'add') {
        if(this.schedName === '' || this.schedName === null || this.schedStartTime === null || this.schedStartTime === '' || this.schedEndTime === null || this.schedEndTime === '' || this.schedLanguage === null || this.schedLanguage === '') {
          this.modalErrorMessage = 'All fields are required.'
          return
        } else {
          this.modalErrorMessage = null
        }
        if(this.dateErrorMessage !== null) {
          return
        }
        let index = this.days.map(e => e.title).indexOf(this.selectedDay)
        this.days[index].schedule.push(
          {
            startTime: this.schedStartTime,
            endTime: this.schedEndTime,
            name: this.schedName,
            language: this.schedLanguage
          }
        )
        this.schedLanguage = null
        this.schedStartTime = null
        this.schedEndTime = null
        this.schedName = null
        $('#addSched').modal('hide')
      } else {
        if(this.item.name === '' || this.item.name === null || this.item.startTime === null || this.item.startTime === '' || this.item.endTime === null || this.item.endTime === '' || this.item.language === null || this.item.language === '') {
          this.modalErrorMessage = 'All fields are required.'
          return
        }
        if(this.dateErrorMessage !== null) {
          return
        }
        let index = this.days.map(e => e.title).indexOf(this.selectedDay)
        this.days[index].schedule[this.item.index] = this.item
        $('#addSched').modal('hide')
      }
      this.item = null
    },
    retrieve() {
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('account_merchants/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.afterLoad = true
        if(response.data.length > 0){
          this.status = 'udpate'
          this.name = response.data[0].name
          try{
            this.address = JSON.parse(response.data[0].address).name
            let val = {
              ...this.property.value,
              name: this.address
            }
            this.property['value'] = JSON.stringify(val)
          } catch (e) {
            console.log(e)
          }
          this.church = response.data[0]
          this.logo = response.data[0].logo
          if(response.data[0].schedule) {
            this.days = JSON.parse(response.data[0].schedule)
          }
        } else {
          this.status = 'create'
        }
      })
    },
    update() {
      if(this.status === 'udpate') {
        if(this.name === null || this.address === null || this.name === '' || this.address === '') {
          this.successMessage = null
          this.errorMessage = 'All fields are required.'
          this.errorMessage1 = null
          this.$refs.featured.errorMessage = null
          return
        }
        let parameter = {
          id: this.church.id,
          name: this.name,
          address: this.address
        }
        $('#loading').css({display: 'block'})
        this.APIRequest('account_merchants/update', parameter).then(response => {
          $('#loading').css({display: 'none'})
          if(response.data) {
            this.errorMessage = null
            this.successMessage = 'Successfully updated.'
          }
        })
      } else {
        this.create()
      }
    },
    create() {
      if(this.name === null || this.address === null || this.name === '' || this.address === '') {
        this.successMessage = null
        this.errorMessage1 = null
        this.errorMessage = 'All fields are required.'
        this.$refs.featured.errorMessage = null
        return
      }
      let parameter = {
        account_id: this.user.userID,
        name: this.name,
        address: this.address
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('account_merchants/create', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data) {
          this.retrieve()
          this.status = 'udpate'
          this.errorMessage = null
          this.errorMessage1 = null
          this.successMessage = 'Successfully updated.'
        }
      })
    },
    updatePhoto(object){
      $('#loading').css({'display': 'block'})
      this.APIRequest('account_merchants/update', object).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data === true){
          this.hideImages()
        }
      })
    },
    manageImageUrl(url){
      let c = {
        id: this.church.id,
        logo: url
      }
      this.logo = url
      this.updatePhoto(c)
    },
    clear() {
      this.$refs.featured.errorMessage = null
    },
    showImages() {
      if(this.church === null) {
        this.errorMessage = 'No existing church. Please update your church details.'
        this.errorMessage1 = null
        this.$refs.featured.errorMessage = null
        return
      } else {
        console.log(this.church)
        $('#browseImagesModal').modal('show')
        this.errorMessage = null
      }
    },
    hideImages(){
      $('#browseImagesModal').modal('hide')
    },
    removeImage(id){
      let parameter = {
        id: id
      }
      this.APIRequest('images/delete', parameter).then(response => {
        this.church.logo = null
      })
    },
    retrieveFeaturedPhotos(){
      const parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }, {
          value: 'featured-photo',
          column: 'category',
          clause: '='
        }],
        sort: {
          created_at: 'desc'
        }
      }
      $('#loading').css({display: 'none'})
      this.APIRequest('images/retrieve', parameter).done(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.images = response.data
        }
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.top{
  margin-left: 0px;
}
.success{
  color: $primary;
}
.time-row{
  justify-content: center;
  padding-left: 15px;
  padding-right: 15px;
}
.time{
  width: 49%;
  margin-right: 1%;
}
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
  height: 160px;
  width: 160px;
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
