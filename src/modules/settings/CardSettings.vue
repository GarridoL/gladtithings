<template>
  <div class="containers row" @click="redirect(route)" v-if="version === 3">
    <div class="column first" style="width: 7%;">
      <i :class="description === 'Direct Transfer' ? 'fas fa-church' : 'fas fa-credit-card'" style="font-size: 30px; line-height: inherit;"></i>
    </div>
    <div class="column second" style="width: 60%;">
      <p><b>{{title}}</b></p>
      <p>{{dates}}</p>
    </div>
    <div class="column third" style="width: 32%;">
      <p class="amount" :style="styles"><b>{{amount}}</b></p>
    </div>
  </div>
  <div class="containers row" @click="redirect(route)" v-else>
    <div class="column" style="width: 50%;">
      <p><b>{{title}}</b></p>
      <p>{{description}}</p>
    </div>
    <div class="column" style="width: 50%;">
      <i class="fas fa-chevron-right icon" v-if="version === 1"></i>
      <i class="fas fa-toggle-on icon" @click="clickToggle(!toggle)" v-if="version === 2 && toggle === true"></i>
      <i class="fas fa-toggle-off icon-off" @click="clickToggle(!toggle)" v-if="version === 2 && toggle === false"></i>
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
export default{
  props: [
    'title',
    'description',
    'route',
    'version',
    'toggle',
    'amount',
    'dates',
    'payload',
    'styles'
  ],
  mounted(){},
  data(){
    return {
      user: AUTH.user
    }
  },
  methods: {
    redirect(route) {
      ROUTER.push(route)
    },
    clickToggle(value) {
      this.$emit('click_toggle', value, this.payload)
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
p {
  margin: 1px;
}
.first{
  text-align: center;
  vertical-align: middle;
}
.amount{
  color: $primary;
  float: right;
  margin-top: 5%;
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
  width: 100%;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 20px;
  cursor: pointer;
}
@media (max-width: 992px){
  .container{
    width: 100%;
  }
}
</style>
