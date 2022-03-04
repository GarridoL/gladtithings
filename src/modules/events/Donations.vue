<template>
  <div>
    <div>
      <p style="font-size: 16px;"><b>Donation History</b></p>
      <p style="margin-top: 10px;">The following data shows the transaction history of sponsor's donation for this event.</p>
      <basic-filter 
        v-bind:category="category" 
        :activeCategoryIndex="0"
        :activeSortingIndex="0"
        @changeSortEvent="retrieve($event.sort, $event.filter)"
        @changeStyle="manageGrid($event)"
        :grid="['list', 'th-large']">
      </basic-filter>
    </div>
    <empty v-if="data.length === 0" :title="'No data available!'" :action="'Keep growing.'"></empty>
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
    <Pager
      :pages="numPages"
      :active="activePage"
      :limit="limit"
      v-if="data.length > 0"
    />
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
export default{
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
          payload_value: 'asc',
          input_type: 'date'
        }, {
          title: 'Created Descending',
          payload: 'created_at',
          payload_value: 'desc',
          input_type: 'date'
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
      details: null
    }
  },
  components: {
    'empty': require('components/increment/generic/empty/Empty.vue'),
    'basic-filter': require('modules/generic/Basic.vue'),
    Pager
  },
  methods: {
    setDetails(details) {
      this.details = details
      console.log('details')
      this.retrieve({created_at: 'desc'}, {column: 'created_at', value: ''})
    },
    retrieve(sort, filter){
      if(this.details === null) {
        return
      }
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
        }, {
          value: this.details.id,
          column: 'details',
          clause: '='
        }],
        sort: sort,
        limit: this.limit,
        offset: (this.activePage > 0) ? ((this.activePage - 1) * this.limit) : this.activePage
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('ledger/retrieve_with_condition', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data
          this.$parent.donations = response.donations
          this.$parent.sponsors = response.sponsors
          this.numPages = parseInt(response.size / this.limit) + (response.size % this.limit ? 1 : 0)
        } else {
          this.numPages = null
          this.data = []
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
.text-container{
  width: 65%;
}
.image-container{
  background-color: white;
  padding: 10px;
  margin-right: 10px;
  width: 68%
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
  .container, .table, .column, .text-container, .image-container{
    width: 100%;
  }
  .text-container{
    text-align: center;
  }
  .image-container{
    margin-bottom: 15px;
  }
  .top-container{
    margin-bottom: 10%;
  }
}
</style>
