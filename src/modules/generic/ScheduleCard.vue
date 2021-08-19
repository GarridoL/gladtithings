<template>
  <div class="container">
    <div class="containers row" v-for="(item, index) in data" :key="index">
      <div class="column" style="width: 75%;">
        <p><b>{{item.time}}</b></p>
        <p>By: {{item.name}}</p>
        <p>Language: {{item.language}}</p>
      </div>
      <div class="column" style="width: 25%;">
        <span>
          <i class="fas fa-times-circle delete"></i>
          <i class="fas fa-pencil-alt icons mr-1"></i>
        </span>
      </div>
    </div>
    <div class="container-add">
      <i class="fas fa-plus-circle" style="font-size: 40px;"></i>
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
    'data'
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
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
p {
  margin: 1px;
}
.delete{
  color: $danger;
  float: right;
  font-size: 13px;
  margin-top: 7px;
  cursor: pointer;
}
.icons{
  float: right;
  font-size: 12px;
  color: $primary;
  margin-top: 7px;
  cursor: pointer;
}
.container{
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  margin-top: 0px;
  margin-bottom: 30px;
}
.container-add{
  width: 10%;
  background-color: white;
  color: $primary;
  padding-top: 22px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 20px;
  text-align: center;
  cursor: pointer;
  height: 84px;
  margin-left: -15px;
}
.containers{
  width: 25%;
  margin-right: 20px;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 20px;
}
@media (max-width: 992px){
  .container{
    width: 100%;
    display: flex;
  }
}
</style>
