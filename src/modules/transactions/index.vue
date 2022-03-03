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
      <button class="text-center sort-button" @click="exportCSV()">Export to CSV</button>
      <br><br>
    </div>
    <empty v-if="data.length === 0" :title="'No transactions available!'" :action="'Keep growing.'"></empty>
    <div v-for="(item, index) in data" :key="index" v-if="data.length > 0" class="cards-container">
    <Cards
      :title="item.receiver ? item.receiver.email : item.description"
      :dates="item.created_at_human"
      :version="3"
      :description="item.description"
      :amount="item.currency.toUpperCase() + ' ' + (item.amount !== null ? item.amount.toLocaleString() : item.amount)"
      :route="'transaction/details/' + item.id"
      :styles="item.amount > 0 ? 'color: #56C596;' : 'color: red;'"
    />
    </div>
     <basic-pager :pages="numPages" :active="activePage" :limit="limit" v-if="data.length > 0"></basic-pager>
  </div>
</template>
<script>
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import { ExportToCsv } from 'export-to-csv'
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
          payload_value: 'asc',
          input_type: 'date'
        }, {
          title: 'Created Descending',
          payload: 'created_at',
          payload_value: 'desc',
          input_type: 'date'
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
    exportCSV() {
      let data = this.data
      let options = {
        fieldSeparator: ',',
        quoteStrings: '"',
        decimalSeparator: '.',
        showLabels: true,
        showTitle: false,
        title: 'Transaction Report',
        useTextFile: false,
        useBom: true,
        filename: 'Transaction Report as of_' + new Date(),
        headers: ['DATE', 'AMOUNT', 'CURRENCY', 'DESCRIPTION', 'PROCESSED BY']
      }
      var exportData = []
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
        sort: {created_at: 'desc'},
        limit: this.limit,
        offset: (this.activePage > 0) ? ((this.activePage - 1) * this.limit) : this.activePage
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('ledger/transaction_history', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0) {
          response.data.map(el => {
            var object = {
              date: el.created_at_human,
              amount: el.amount,
              currency: el.currency,
              description: el.description,
              processedBy: el.owner.email
            }
            exportData.push(object)
          })
          if(exportData.length > 0){
            var csvExporter = new ExportToCsv(options)
            csvExporter.generateCsv(exportData)
          }
        }
      })
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
          column: 'account_id',
          value: this.user.userID,
          clause: '='
        }, {
          value: '%' + filter.value + '%',
          column: filter.column,
          clause: 'like'
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
          this.numPages = parseInt(response.size / this.limit) + (response.size % this.limit ? 1 : 0)
        } else {
          this.data = []
          this.numPages = null
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
  .container, .cards-container{
    width: 100%;
    margin: 10px;
  }
}
</style>
