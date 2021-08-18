<template>
  <div class="pull-right">
    <ul class="pagination">
      <li>
        <select v-if="includesDropDown !== false" class="btn btn-default" v-model="localLimit"  @change="changeLimit">
          <option class="dropdown-title" v-for="item in 5" :value="(item * 5)" :key="item">
            {{parseInt(item * 5)}}
          </option>
        </select>
      </li>
      <li class="page-item" v-if="active > 1"><span class="page-link" @click="onPrevious()">Previous</span></li>
      <li class="page-item" v-if="active >= 2"><span class="page-link" @click="onSelectedPage(active - 1)">{{active - 1}}</span></li>
      <li class="page-item"><span class="page-link bg-primary" @click="onSelectedPage(active)">{{active}}</span></li>
      <li class="page-item" v-if="active < pages"><span class="page-link" @click="onSelectedPage(active + 1)">{{active + 1}}</span></li>
      <li class="page-item" v-if="active < pages"><span class="page-link" @click="onNext()">Next</span></li>
    </ul>
  </div>
</template>
<style scoped lang="scss">

@import "~assets/style/colors.scss";
.holder{
  width: 100%;
  float: left;
  height: 50px;
}

.btn-default{
  height: 40px !important;
  border: solid 1px $primary !important;
  margin-right: 5px;
}

.page-link{
  line-height: 40px !important;
  padding-top: 0px !important;
  padding-bottom: 0px !important;
  padding-left: 20px !important;
  padding-right: 20px !important;
}

.bg-primary{
  color: #ffffff !important;
  background: $primary !important;
}
@media (max-width: 992px){
}
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      localLimit: this.limit
    }
  },
  props: ['pages', 'active', 'limit', 'includesDropDown'],
  methods: {
    onNext(){
      if(this.active < this.pages){
        this.$parent.activePage++
        this.$parent.retrieve(null, null)
      }
    },
    onSelectedPage(page){
      this.$parent.activePage = page
      this.$parent.retrieve(null, null)
    },
    changeLimit(){
      this.$parent.limit = this.localLimit
      this.$parent.activePage = 1
      this.$parent.retrieve(null, null)
    },
    onPrevious(){
      if(this.active > 0){
        this.$parent.activePage--
        this.$parent.retrieve(null, null)
      }
    }
  }
}
</script>
