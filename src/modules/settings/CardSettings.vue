<template>
  <div class="containers row" @click="redirect(route)">
    <div class="column" style="width: 50%;">
      <p><b>{{title}}</b></p>
      <p>{{description}}</p>
    </div>
    <div class="column" style="width: 50%;">
      <i class="fas fa-chevron-right icon" v-if="version === 1"></i>
      <i class="fas fa-toggle-on icon" v-if="version === 2 && toggle === true"></i>
      <i class="fas fa-toggle-off icon-off" v-if="version === 2 && toggle === false"></i>
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
export default{
  props: ['title', 'description', 'route', 'version', 'toggle'],
  mounted(){},
  data(){
    return {
      user: AUTH.user
    }
  },
  methods: {
    redirect(route) {
      ROUTER.push(route)
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
p {
  margin: 1px;
}
.icon{
  float: right;
  font-size: 20px;
  color: $primary;
  margin-top: 7px;
}
.icon-off{
  float: right;
  font-size: 20px;
  color: $danger;
  margin-top: 7px;
}
.containers{
  width: 60%;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 20px;
  cursor: pointer;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
