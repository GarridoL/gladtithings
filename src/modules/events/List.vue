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
            <td class="header"><b>Donations Gathered</b></td>
            <td class="header"><b>Status</b></td>
            <td class="header"><b>Actions</b></td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in data" :key="index">
            <td class="header">{{item.created_at}}</td>
            <td class="header">{{item.name}}</td>
            <td class="header">{{item.start_date}}</td>
            <td class="header">0</td>
            <td class="header">UPCOMING</td>
            <td class="header">
              <span>
                <i class="fas fa-eye icon-eye" @click="redirect('events/details/' + item.id)"></i>
                <i class="fas fa-edit icon-edit" @click="redirect('events/update')"></i>
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
  mounted(){
    this.retrieve({created_at: 'asc'}, {column: 'created_at', value: ''})
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
    },
    retrieve(sort, filter){
      if(sort !== null){
        this.sort = sort
      }
      if(filter !== null){
        this.filter = filter
      }
      if(sort === null && this.sort !== null){
        sort = this.sort
      }
      if(filter === null && this.filter !== null){
        filter = this.filter
      }
      let parameter = {
        condition: [{
          value: '%' + filter.value + '%',
          column: filter.column,
          clause: 'like'
        }],
        sort: sort,
        limit: this.limit,
        offset: 0
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('events/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
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
