<template>
    <div class="container">
      <div class="row" style="width: 100%;">
        <div class="column" style="width: 80%;">
        <h3>Subscriptions Management</h3>
        <p style="margin-top: 5px;">Here are the latest update of subscriptions as of the moment.</p>
      </div>
      </div>
      <!-- <div class="row" style="width: 100%; margin-top: 40px;">
        <div class="column first">
          <p class="title">Total Number of Subscribers</p>
          <p style="color: white; margin: 0; font-size: 17px;"><b>500</b></p>
        </div>
        <div class="column second">
          <p class="title">Subscribers this Month</p>
          <p style="color: white; margin: 0; font-size: 17px;"><b>30</b></p>
        </div>
        <div class="column third">
          <p class="title">Subscribers Last 24 Hours</p>
          <p style="color: white; margin: 0; font-size: 17px;"><b>15</b></p>
        </div>
      </div> -->
      <div class="mt-4">
        <p style="color: black; margin: 0; font-size: 17px; margin-top: 30px"><b>List of Subscribers</b></p>
        <p style="margin-top: 5px;">The following data shows the list of subscribers.</p>
      </div>
        <br>
        <div class="mt-4">
            <basic-filter 
                v-bind:category="category" 
                :activeCategoryIndex="0"
                :activeSortingIndex="0"
                @changeSortEvent="retrieve($event.sort, $event.filter)"
                @changeStyle="manageGrid($event)"
                :grid="['list', 'th-large']">
            </basic-filter>
        </div>
        <div class="table-container">
          <table class="table table-bordered table-responsive" v-if="data.length > 0">
            <thead>
              <tr>
                  <td class="header"><b>Username</b></td>
                  <td class="header"><b>Full Name</b></td>
                  <td class="header"><b>Address</b></td>
                  <td class="header"><b>Total Donations</b></td>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(item, index) in data" :key="index">
                <td class="header">{{item.username}}</td>
                <td class="header">{{item.first_name}} {{item.last_name}}</td>
                <td class="header">{{item.address}}</td>
                <td class="header">{{item.total_amount}}</td>
              </tr>
            </tbody>
          </table>
          <empty v-if="data.length === 0" :title="'No Subscriptions available!'" :action="'Keep growing.'"></empty>
        </div>
      <Pager
      :pages="numPages"
      :active="activePage"
      :limit="limit"
      v-if="data.length > 0"
    />
    <div class="mt-5 pt-5">
      <p style="color: black; margin: 0; font-size: 17px;"><b>Subscribers Graph</b></p>
      <p style="margin-top: 5px;">The following data shows status of subscribers.</p>
    </div>
    <div class="graph">
      <GraphHeader @select="graph"/>
      <BarGraph :data="graphSubscribe"/>
    </div>
    <div class="mt-4">
      <p style="color: black; margin: 0; font-size: 17px;"><b>Donations Graph</b></p>
      <p style="margin-top: 5px;">The following data shows status of donations.</p>
    </div>
    <div class="graph">
      <GraphHeader />
      <BarGraph :data="graphDonations"/>
    </div>
    </div>
</template>

<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
import BarGraph from 'src/modules/generic/BarGraph.vue'
import GraphHeader from 'src/modules/generic/HeaderGraph.vue'
export default{
  mounted(){
    this.retrieve({'T1.username': 'desc'}, {column: 'username', value: ''})
    this.graph()
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
          title: 'Username Ascending',
          payload: 'T1.username',
          payload_value: 'asc'
        }, {
          title: 'Username Descending',
          payload: 'T1.username',
          payload_value: 'desc'
        }, {
          title: 'Full Name Ascending',
          payload: 'name',
          payload_value: 'asc'
        }, {
          title: 'Full Name Descending',
          payload: 'name',
          payload_value: 'desc'
        }, {
          title: 'Address Ascending',
          payload: 'T2.address',
          payload_value: 'asc'
        }, {
          title: 'Address Descending',
          payload: 'T2.address',
          payload_value: 'desc'
        }]
      }],
      filter: null,
      sort: null,
      limit: 5,
      numPages: null,
      activePage: 1,
      graphSubscribe: {
        labels: ['2015', '2016', '2017', '2018', '2019', '2020', '2021'],
        datasets: [
          {
            fill: false,
            borderColor: '#f87979',
            backgroundColor: '#56C596',
            label: 'SUBSCRIBERS',
            data: [0, 100, 200, 300, 400, 500]
          }
        ]
      },
      graphDonations: {
        labels: ['2015', '2016', '2017', '2018', '2019', '2020', '2021'],
        datasets: [
          {
            fill: false,
            borderColor: '#f87979',
            backgroundColor: '#56C596',
            label: 'AMOUNT OF DONATIONS',
            data: [0, 10000, 20000, 30000, 40000, 50000]
          }
        ]
      }
    }
  },
  components: {
    'empty': require('components/increment/generic/empty/Empty.vue'),
    'basic-filter': require('modules/generic/Basic.vue'),
    'increment-modal': require('components/increment/generic/modal/Modal.vue'),
    Pager,
    BarGraph,
    GraphHeader
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
          value: '%' + this.filter.value + '%',
          column: this.filter.column,
          clause: 'like'
        }],
        merchant: this.user.merchant.id,
        sort: sort,
        limit: this.limit,
        offset: (this.activePage > 0) ? ((this.activePage - 1) * this.limit) : this.activePage
      }
      this.APIRequest('subscriptions/retrieve_by_merchant', parameter).then(response => {
        console.log('[subscriptions]', response)
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = []
        }
      })
    },
    graph(e){
      console.log('[eeee]', e)
      let parameter = {
        account_id: this.user.userID,
        date: e === undefined ? 'yearly' : e
      }
      this.APIRequest('ledger/retrieve_graph', parameter).then(response => {
        console.log('[response]', response)
      })
    }
  }
}
</script>

<style scoped lang="scss">
@import "~assets/style/colors.scss";
.graph{
  margin-top: 3%;
  background-color: white;
  width: 100%;
  height: 500px;
  border-radius: 7px;
  padding: 30px 30px 30px 30px;
  margin-bottom: 50px;
}
.icon-eye{
  color: $secondary;
  margin: 2px;
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
  margin-top: 20px;
}
.title{
  color: rgb(202, 200, 200);
  margin: 0;
}
.container{
  width: 65%;
  margin-bottom: 100px;
  margin-top: 25px;
}

.first{
  height: 100px;
  width: 32%;
  background-color: $primary;
  margin-right: 2%;
  padding-top: 25px;
  text-align: center;
  border-radius: 5px;
}
.second{
  height: 100px;
  width: 32%;
  background-color: $danger;
  margin-right: 2%;
  padding-top: 25px;
  text-align: center;
  border-radius: 5px;
}
.third{
  height: 100px;
  width: 32%;
  background-color: $secondary;
  padding-top: 25px;
  text-align: center;
  border-radius: 5px;
}

@media (max-width: 992px){
  .container, .table{
    width: 100%;
  }
}
</style>
