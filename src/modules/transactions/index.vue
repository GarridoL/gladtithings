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
    <empty v-if="data === null" :title="'No accounts available!'" :action="'Keep growing.'"></empty>
  <!-- <h3 style="margin-left: -10px;">Transactions</h3> -->
   <div v-for="(item, index) in list" :key="index">
    <Cards
      :title="item.title"
      :dates="item.dates"
      :version="3"
      :amount="item.amount"
    />
   </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Cards from 'src/modules/settings/CardSettings.vue'
export default{
  mounted(){},
  data(){
    return {
      user: AUTH.user,
      list: [
        {
          title: 'Church 1',
          dates: 'July 8, 2021',
          amount: 'USD 10.00'
        },
        {
          title: 'Church 2',
          dates: 'November 30, 2020',
          amount: 'USD 10.00'
        },
        {
          title: 'Church 3',
          dates: 'August 17, 2021',
          amount: 'USD 10.00'
        },
        {
          title: 'Church 4',
          dates: 'June 13, 2013',
          amount: 'USD 10.00'
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
      }]
    }
  },
  components: {
    'basic-filter': require('modules/generic/Basic.vue'),
    Cards
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
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
