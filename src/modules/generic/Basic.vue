<template>
  <div class="filter">
    <div class="input-group">
    <!--  <button class="text-center sort-button">Sort by</button> -->
      <select class="btn sort-button-dropdown select-btn dropdown" v-model="sortValue" @change="changeSort" v-if="activeSort !== null">
        <option class="dropdown-title" v-for="(item, index) in activeSort" :value="index" :key="index">
          {{item.title}}
        </option>
      </select>
      <input :type="(activeSort !== null && (typeof activeSort[sortValue].input_type !== undefined && activeSort[sortValue].input_type !== 'undefined')) ? activeSort[sortValue].input_type : 'text'" class="form-control" v-model="searchValue" @keypress="keypressHandler" :placeholder="'Search ' + '...'">
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
button:focus{
  outline: none;
}
.sort-button{
  border-top-left-radius: 25px;
  border-bottom-left-radius: 25px;
  width: 150px;
  color: white;
  border: 0px;
  background-color: $secondary;
}
.sort-button-dropdown{
  background-color: white;
  border: 0.5px solid rgb(228, 228, 228);
  border-top-left-radius: 25px;
  border-bottom-left-radius: 25px;
  
}
.filter{
  width: 100%;
  height: 50px;
}
.form-control{
  height: 40px !important;
  border: 0.5px solid rgb(228, 228, 228);
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
}
.btn{
  border-radius: 0px !important;
  height: 40px !important;
}
.select-btn{
  border-top-left-radius: 30px !important;
  border-bottom-left-radius: 30px !important;
  border-top-right-radius: 0px !important;
  border-bottom-right-radius: 0px !important;
}
.dropdown {
  z-index: 0 !important;
}
@media (max-width: 650px){
  .dropdown {
      width: 20%;
  }
  .dropdown-title {
    font-size: 10px;
  }
}
@media (max-width: 992px){
  .view-option{
    display: none;
  }

  .input-group{
    width: 100% !important;
    min-height: 50px !important;
  }

  .btn, .form-control{
    float: left;
    width: 100% !important;
  }
}
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import axios from 'axios'
export default {
  mounted(){
    this.activeCategoryIndex = this.activeCategoryIndex !== null ? this.activeCategoryIndex : 0
    this.activeSortingIndex = this.activeSortingIndex !== null ? this.activeSortingIndex : 0
    this.activeCategory = this.category[this.activeCategoryIndex]
    this.activeSort = this.category[this.activeCategoryIndex].sorting
    this.filterValue = this.activeCategoryIndex
    this.sortValue = this.activeSortingIndex
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      searchValue: '',
      filterValue: null,
      sortValue: null,
      title: '',
      payload: '',
      payloadValue: '',
      SortOrder: '',
      sortData: {
        'title': 'asc'
      },
      activeCategory: null,
      activeSort: null,
      itemTemp: {
        'payload': 'title',
        'payload_value': 'asc',
        'title': 'Title ascending'
      },
      toggleStyle: 0,
      toggleFlag: false
    }
  },
  props: ['category', 'activeCategoryIndex', 'activeSortingIndex', 'grid'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      //
    },
    changeView(){
      if(this.toggleStyle < this.grid.length - 1 && this.toggleFlag === false){
        this.toggleStyle++
        if(this.toggleStyle === this.grid.length - 1){
          this.toggleFlag = true
        }
      }else if(this.toggleStyle > 0 && this.toggleFlag === true){
        this.toggleStyle--
        if(this.toggleStyle === 0){
          this.toggleFlag = false
        }
      }
      this.$emit('changeStyle', this.grid[this.toggleStyle])
    },
    selectCategory(){
      this.activeSort = this.category[this.filterValue].sorting
      this.activeCategory = this.category[this.filterValue]
      this.sortValue = this.filterValue
    },
    changeSort(){
      console.log('hi')
      let object = {}
      let filter = {
        column: this.activeSort[this.sortValue].payload,
        value: this.searchValue
      }
      object[this.activeSort[this.sortValue].payload] = this.activeSort[this.sortValue].payload_value
      let parameter = {
        sort: object,
        filter: filter
      }
      this.$emit('changeSortEvent', parameter)
    },
    keypressHandler(event){
      if(event.charCode === 13){
       // console.log(this.itemTemp)
        let item = this.itemTemp
        let object = {}
        let filter = {
          column: this.activeSort[this.sortValue].payload,
          value: this.searchValue
        }
        object[this.activeSort[this.sortValue].payload] = this.activeSort[this.sortValue].payload_value
        let parameter = {
          sort: object,
          filter: filter
        }
        this.$emit('changeSortEvent', parameter)
      }
    }
  }
}
</script>
