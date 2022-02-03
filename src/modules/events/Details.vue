<template>
  <div class="container">
    <i class="fas fa-chevron-left mr-2" style="font-size: 22px; cursor: pointer;" @click="redirect('/events')"></i>
    <span style="font-size: 22px;"><b>Event Details</b></span>
    <p style="margin-top: 10px;">Here are the lates update of this event as of today.</p>
    <div class="top-container row" v-if="details">
      <div class="column image-container" style="width: 68%;">
        <div class="row">
          <div class="column image">
            <img :src="config.BACKEND_URL + details.image[0].category" width="85%" height="100%" v-if="details && details.image.length > 0">
            <i class="far fa-image" style="font-size: 80px; color: gray;" v-else></i>
          </div>
          <div class="column" style="width: 65%;">
            <p style="margin: 0;"><b>{{details.name}}</b></p>
            <span class="mr-4 gray"><i class="fas fa-calendar-alt mr-1 gray"></i>{{details.start_date}}</span>
            <span class="gray"><i class="fas fa-calendar-alt mr-1 gray"></i>{{details.end_date}}</span>
            <p class="gray" style="margin: 0;"><i class="fas fa-map-marker-alt mr-1 mt-2 gray"></i>{{details.location}}</p>
            <p class="long-text">{{details.description}}</p>
          </div>
        </div>
      </div>
      <div class="column" style="width: 29%;">
        <div class="black">
          <p class="title">Total Amount of Donations</p>
          <p style="color: white; margin: 0;"><b>{{donations * -1}}</b></p>
        </div>
        <div class="red">
          <p class="title">Total Number of Sponsors</p>
          <p style="color: white; margin: 0;"><b>{{sponsors}}</b></p>
        </div>
      </div>
    </div>
    <div>
      <p style="font-size: 16px;"><b>Donation History</b></p>
      <p style="margin-top: 10px;">The following data shows the transaction history of sponsor's donation for this event.</p>
      <basic-filter 
        v-bind:category="category" 
        :activeCategoryIndex="0"
        :activeSortingIndex="0"
        @changeSortEvent="retrieveEvent($event.sort, $event.filter)"
        @changeStyle="manageGrid($event)"
        :grid="['list', 'th-large']">
      </basic-filter>
    </div>
    <empty v-if="data === null" :title="'No data available!'" :action="'Keep growing.'"></empty>
    <div class="table-container" v-else>
      <table class="table table-bordered table-responsive" v-if="data.length > 0">
        <thead>
          <tr>
            <td class="header"><b>Date</b></td>
            <td class="header"><b>Sponsor Name</b></td>
            <td class="header"><b>Donations</b></td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="header">{{item.created_at}}</td>
            <td class="header">{{item.account.username}}</td>
            <td class="header">{{item.amount * -1}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div>
      <p style="font-size: 16px; margin-top: 20px;"><b>Event Attendees</b></p>
      <p style="margin-top: 10px;">The following data shows the attendees for this event.</p>
    </div>
    <empty v-if="attendees.length === 0" :title="'No data available!'" :action="'Keep growing.'"></empty>
    <div class="table-container" v-else>
      <table class="table table-bordered table-responsive" v-if="attendees.length > 0">
        <thead>
          <tr>
            <td class="header"><b>Date</b></td>
            <td class="header"><b>Attendee Name</b></td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in attendees" :key="index">
            <td class="header">{{item.created_at}}</td>
            <td class="header">{{item.account.username}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pager
      :pages="numPages"
      :active="activePage"
      :limit="limit"
      v-if="data !== null"
    />
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
export default{
  mounted(){
    this.retrieve(this.$route.params.id)
    this.retrieveAttendees(this.$route.params.id)
  },
  data(){
    return {
      user: AUTH.user,
      data: [],
      auth: AUTH,
      config: CONFIG,
      category: [{
        title: 'Sort by',
        sorting: [{
          title: 'Created Ascending',
          payload: 'created_at',
          payload_value: 'asc'
        }, {
          title: 'Created Descending',
          payload: 'created_at',
          payload_value: 'desc'
        }, {
          title: 'Amount Ascending',
          payload: 'amount',
          payload_value: 'asc'
        }, {
          title: 'Amount Descending',
          payload: 'amount',
          payload_value: 'desc'
        }]
      }],
      filter: null,
      sort: null,
      limit: 5,
      numPages: null,
      activePage: 1,
      details: null,
      sponsors: 0,
      donations: 0,
      attendees: [],
      attendeeLimit: 5
    }
  },
  components: {
    'empty': require('components/increment/generic/empty/Empty.vue'),
    'basic-filter': require('modules/generic/Basic.vue'),
    'increment-modal': require('components/increment/generic/modal/Modal.vue'),
    Pager
  },
  methods: {
    redirect(route){
      ROUTER.push(route)
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
          this.details = response.data[0]
          this.retrieveEventSponsors(this.details.id)
        }
      })
    },
    retrieveEvent(sort, filter){
      let parameter = {
        condition: [{
          value: '%' + filter.value + '%',
          column: filter.column,
          clause: 'like'
        }, {
          value: this.details.id,
          column: 'details',
          clause: '='
        }],
        sort: sort,
        limit: this.limit,
        offset: 0
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('ledger/retrieve_with_condition', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data
        }
      })
    },
    retrieveEventSponsors(id){
      let parameter = {
        condition: [{
          value: id,
          column: 'details',
          clause: '='
        }],
        sort: {created_at: 'asc'},
        limit: this.limit,
        offset: 0
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('ledger/retrieve_with_condition', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data
          this.sponsors = response.sponsors
          this.donations = response.donations
        }
      })
    },
    retrieveAttendees(id){
      let parameter = {
        condition: [{
          value: id,
          column: 'event_id',
          clause: '='
        }],
        sort: {created_at: 'asc'},
        limit: this.attendeeLimit,
        offset: 0
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('event_attendees/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.attendees = response.data
        }
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
.title{
  color: rgb(202, 200, 200);
  margin: 0;
}
.image{
  width: 35%;
  text-align: center;
}
.black{
  height: 48.5%;
  background-color: $secondary;
  border-radius: 5px;
  padding: 12.5% 0;
  text-align: center;
}
.red{
  margin-top: 3%;
  height: 48.5%;
  background-color: $danger;
  border-radius: 5px;
  padding: 12.5% 0;
  text-align: center;
}
.long-text{
  font-size: 13px;
  margin-top: 20px;
  width: 97%;
}
.gray{
  color: gray;
  font-size: 12px;
}
.image-container{
  background-color: white;
  padding: 10px;
  margin-right: 10px;
}
.table{
  background-color: white;
}
.table-container{
  height: 50vh;
  background-color: white;
  margin-bottom: 10px;
  margin-top: 10px;
}
.top-container{
  margin-left: 0px;
  width: 100%;
  margin-bottom: 20px;
}
.container{
  width: 60%;
  margin-bottom: 100px;
  margin-top: 25px;
}
td i {
  padding-right: 0px !important;
  padding-left: 0px !important;
}

@media (max-width: 992px){
  .container, .table{
    width: 100%;
  }
  .top-container{
    margin-bottom: 10%;
  }
}
</style>
