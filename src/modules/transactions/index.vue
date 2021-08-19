<template>
  <div class="container">
   <h3 style="margin-left: -10px;">Transactions</h3>
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
      ]
    }
  },
  components: {
    Cards
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
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
