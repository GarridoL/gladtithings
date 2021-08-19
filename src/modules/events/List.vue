<template>
  <div class="container">
    <div>
      <basic-filter 
        v-bind:category="category" 
        :activeCategoryIndex="0"
        :activeSortingIndex="0"
        @changeSortEvent="retrieve($event.sort, $event.filter)"
        @changeStyle="manageGrid($event)"
        :grid="['list', 'th-large']">
      </basic-filter>
      <button class="text-center sort-button" @click="redirect('events/create')">Add Event</button>
    </div>
    <empty v-if="data === null" :title="'No accounts available!'" :action="'Keep growing.'"></empty>
    <div class="table-container" v-else>
      <table class="table table-bordered table-responsive" v-if="data !== null">
        <thead>
          <tr>
            <td class="header"><b>Published Date</b></td>
            <td class="header"><b>Event Name</b></td>
            <td class="header"><b>Event Date</b></td>
            <td class="header"><b>Attendees</b></td>
            <td class="header"><b>Donations Gathered</b></td>
            <td class="header"><b>Status</b></td>
            <td class="header"><b>Actions</b></td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="header">{{item.published_date}}</td>
            <td class="header">{{item.event_name}}</td>
            <td class="header">{{item.event_date}}</td>
            <td class="header">{{item.attendees}}</td>
            <td class="header">{{item.donations_gathered}}</td>
            <td class="header">{{item.status}}</td>
            <td class="header">
              <span>
                <i class="fas fa-eye icon-eye" @click="redirect('events/details')"></i>
                <i class="fas fa-edit icon-edit" @click="redirect('events/create')"></i>
                <i class="fas fa-trash-alt icon-trash"></i>
              </span>
            </td>
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
  mounted(){},
  data(){
    return {
      user: AUTH.user,
      data: [
        {
          published_date: '2021-06-22 03:42:56',
          event_name: 'Recollection',
          event_date: 'January 5, 2021 | 1:00 PM',
          attendees: 152,
          donations_gathered: '$123,456,789',
          status: 'UPCOMING'
        },
        {
          published_date: '2021-06-22 03:42:56',
          event_name: 'Recollection',
          event_date: 'January 5, 2021 | 1:00 PM',
          attendees: 152,
          donations_gathered: '$123,456,789',
          status: 'UPCOMING'
        }
      ],
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
          title: 'Event Name Ascending',
          payload: 'event_name',
          payload_value: 'asc'
        }, {
          title: 'Event Name Descending',
          payload: 'event_name',
          payload_value: 'desc'
        }]
      }],
      filter: null,
      sort: null,
      limit: 5,
      numPages: null,
      activePage: 1
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
  border-radius: 25px;
  width: 150px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $secondary;
  margin-bottom: 10px;
  float: right;
}
.icon-eye{
  color: $secondary;
  margin: 2px;
}
.icon-edit{
  color: $primary;
  margin:2px;
}
.icon-trash{
  color: red;
  margin: 2px;
}
.header {
  text-align: center;
}
.table{
  background-color: white;
}
.table-container{
  height: 50vh;
  background-color: white;
  margin-bottom: 10px;
  margin-top: 50px;
}
.container{
  width: 65%;
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
}
</style>
