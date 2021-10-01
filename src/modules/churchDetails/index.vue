<template>
  <div class="container">
    <h3 style="margin-left: -13px;">Church Details</h3>
    <div class="row" style="width: 100%; margin-top: 10px;">
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
        <label><b>Address&nbsp;</b><span style="color: red;">*</span></label><br>
        <input placeholder="Address" class="generic-input" v-model="address">
      </div>
      <div class="column" style="width: 20%; text-align: center;">
        <div class="no-image" v-if="logo === null" >
        </div>
        <span class="image" v-else>
          <img :src="config.BACKEND_URL + logo" style="background-size: cover; border-radius: 100px;"  height="160px" width="160px" >
        </span>
        <p style="cursor: pointer; margin-top: 10px;" @click="showImages()">Click to edit profile</p>
      </div>
      <button class="text-center sort-button" @click="update()">Update</button>
    </div>
    <div>
      <h3 style="margin-bottom: 15px;">Mass Schedules</h3>
      <br>
      <div v-for="(item, index) in days" :key="index">
        <Cards
          :data="item.schedule"
          :title="item.title"
        />
      </div>
    </div>
    <button class="text-center sort-button">Update</button>
    <browse-images-modal :object="user.profile" v-if="user.profile !== null"></browse-images-modal>

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
            <div class="row time-row">
              <div class="column time">
                <label><b>Start Time&nbsp;</b><span style="color: red;">*</span></label><br>
                <input placeholder="Start Time" class="generic-input" type="time" v-model="schedStartTime">
              </div>
               <div class="column time">
                <label><b>End Time&nbsp;</b><span style="color: red;">*</span></label><br>
                <input placeholder="Start Time" class="generic-input" type="time" v-model="schedEndTime">
              </div>
            </div>
            <label><b>Name&nbsp;</b><span style="color: red;">*</span></label><br>
            <input placeholder="Name" class="generic-input" v-model="schedName">
            <label><b>Language&nbsp;</b><span style="color: red;">*</span></label><br>
            <input placeholder="Language" class="generic-input" v-model="schedLanguage">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="addToSchedulePerDay()">Add</button>
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
  },
  data(){
    return {
      user: AUTH.user,
      name: null,
      address: null,
      successMessage: null,
      errorMessage: null,
      modalErrorMessage: null,
      church: null,
      logo: null,
      config: CONFIG,
      schedule: [],
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
        {title: 'Friday', schedule: []},
        {title: 'Saturday', schedule: []}
      ]
    }
  },
  components: {
    Cards,
    Input,
    'browse-images-modal': require('components/increment/generic/image/BrowseModal.vue')
  },
  methods: {
    addSchedModal() {
      this.modalErrorMessage = null
      $('#addSched').modal('show')
    },
    addToSchedulePerDay() {
      if(this.schedName === '' || this.schedName === null || this.schedStartTime === null || this.schedStartTime === '' || this.schedEndTime === null || this.schedEndTime === '' || this.schedLanguage === null || this.schedLanguage === '') {
        this.modalErrorMessage = 'All fields are required.'
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
        if(response.data.length > 0){
          this.name = response.data[0].name
          this.address = response.data[0].address
          this.church = response.data[0]
          this.logo = response.data[0].logo
          if(response.data[0].schedule) {
            this.schedule = JSON.parse(response.data[0].schedule)
          } else {
            this.schedule = []
          }
          console.log(this.schedule)
        }
      })
    },
    update() {
      if(this.name === null || this.address === null || this.name === '' || this.address === '') {
        this.successMessage = null
        this.errorMessage = 'All fields are required.'
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
    showImages() {
      $('#browseImagesModal').modal('show')
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
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
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
