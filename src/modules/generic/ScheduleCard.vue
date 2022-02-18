<template>
  <div>
    <div style="width: 100%;">
    <input type="checkbox" :checked="data && data.length > 0">&nbsp;&nbsp;{{title}}
    </div>
  <div class="container">
    <div class="containers row" v-for="(item, index) in data" :key="index">
      <div class="column" style="width: 75%;">
        <p><b>{{item.startTime + ' - ' + item.endTime}}</b></p>
        <p>By {{item.name}}</p>
        <p>Language: {{item.language}}</p>
      </div>
      <div class="column" style="width: 25%;">
        <span>
          <i class="fas fa-times-circle delete" @click="remove(item, index)"></i>
          <i class="fas fa-pencil-alt icons mr-1" @click="addSched(item, index)"></i>
        </span>
      </div>
    </div>
    <div class="container-add" @click="addSched(null, null)">
      <i class="fas fa-plus-circle" style="font-size: 40px;"></i>
    </div>
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
    'data',
    'title'
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
    addSched(item, index) {
      if(this.$parent.church === null) {
        this.$parent.clear()
        this.$parent.errorMessage = null
        this.$parent.errorMessage1 = 'No existing church. Please update your church details.'
        return
      }
      this.$parent.addSchedModal(item, index)
      if(item === null) {
        this.$parent.schedName = null
        this.$parent.schedStartTime = null
        this.$parent.schedEndTime = null
        this.$parent.schedLanguage = null
      }
      this.$parent.selectedDay = this.title
    },
    remove(index) {
      this.$parent.selectedDay = this.title
      this.$parent.remove(index)
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
  .containers, .container-add{
    width: 100%;
    margin: 10px;
  }
}
</style>
