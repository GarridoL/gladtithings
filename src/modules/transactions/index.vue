<template>
  <div class="container">
    <div style="position: relative; right: 16px;">
      <basic-filter
        v-bind:category="category" 
        :activeCategoryIndex="0"
        :activeSortingIndex="0"
        @changeSortEvent="retrieve($event.sort, $event.filter)"
        @changeStyle="manageGrid($event)"
        :grid="['list', 'th-large']">
      </basic-filter>
      <button class="text-center sort-button" @click="redirect('events/create')">Export to CSV</button>
      <br><br>
    </div>
    <empty v-if="data.length === 0" :title="'No accounts available!'" :action="'Keep growing.'"></empty>
    <!-- <h3 style="margin-left: -10px;">Transactions</h3> -->
    <div v-for="(item, index) in data" :key="index" v-if="data.length > 0" class="cards-container">
    <Cards
      :title="item.receiver ? item.receiver.email : item.description"
      :dates="item.created_at_human"
      :version="3"
      :description="item.description"
      :amount="item.currency + ' ' + (item.amount !== null ? item.amount.toLocaleString() : item.amount)"
    />
    </div>
     <basic-pager :pages="numPages" :active="activePage" :limit="limit" v-if="data.length > 0"></basic-pager>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Cards from 'src/modules/settings/CardSettings.vue'
import Empty from 'components/increment/generic/empty/Empty.vue'
export default{
  mounted(){
    this.retrieve({created_at: 'desc'}, {column: 'created_at', value: ''})
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
          title: 'Description Ascending',
          payload: 'description',
          payload_value: 'asc'
        }, {
          title: 'Description Descending',
          payload: 'description',
          payload_value: 'desc'
        }]
      }],
      filter: null,
      sort: null,
      limit: 5,
      numPages: null,
      activePage: 1,
      offset: 0
    }
  },
  components: {
    'empty': Empty,
    'basic-filter': require('modules/generic/Basic.vue'),
    'basic-pager': require('modules/generic/Pager.vue'),
    Cards
  },
  methods: {
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
          column: 'account_id',
          value: this.user.userID,
          clause: '='
        }, {
          column: 'account_id',
          value: this.user.userID,
          clause: 'or'
        }],
        sort: sort,
        limit: this.limit,
        offset: (this.activePage > 0) ? ((this.activePage - 1) * this.limit) : this.activePage
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('ledger/transaction_history', parameter).then(response => {
        $('#loading').css({display: 'none'})
        console.log(response)
        if(response.data.length > 0) {
          this.data = response.data
        }
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.cards-container {
  margin-bottom: 25px;
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
.container{
  width: 60%;
  margin-top: 15px;
  margin-bottom: 50px;
  align-items: center;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
