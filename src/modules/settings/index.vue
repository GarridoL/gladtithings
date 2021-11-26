<template>
  <div class="container">
   <h3 style="margin-left: -10px;">Settings</h3>
   <div v-for="(item, index) in list" :key="index">
    <Cards
      :title="item.title"
      :description="item.description"
      :route="item.route"
      :version="1"
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
          title: 'Account Settings',
          description: 'Edit account settings',
          route: '/account_settings'
        },
        {
          title: 'Church Details',
          description: 'Edit church details and schedules',
          route: '/church_details'
        },
        {
          title: 'Subscriptions',
          description: 'Enable or disable subscription to your church',
          route: '/subscriptions'
        },
        {
          title: 'Notification Settings',
          description: 'Edit your notification settings',
          route: '/notification_settings'
        },
        {
          title: 'Payment Methods',
          description: 'Add or edit payment methods',
          route: '/payment_methods'
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
