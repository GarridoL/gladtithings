<template>
  <div class="container">
    <div class="row">
      <i class="fas fa-chevron-left icon-back" @click="back()"></i>
      <span style="font-size: 20px;"><b>Announcements</b></span>
    </div>
    <p>Create announcements to let people know your events</p>
    <div class="row" style="float: right;">
      <button class="text-center sort-button" v-if="!add" @click="add = true">Add Announcement</button>
      <button class="text-center cancel-button" v-if="add" @click="add = false; errorMessage = null">Cancel</button>
      <button class="text-center sort-button" v-if="add" @click="create()">Save Announcement</button>
    </div>
    <div v-if="add" class="add-announcemnent">
      <p style="margin-top: 10px; color: red;">{{errorMessage}}</p>
      <div class="inputs">
        <span><b>Title </b><span style="color: red;">*</span></span>
         <input type="text" placeholder="Title" v-model="title">
      </div>
      <div class="inputs">
        <span><b>Description </b><span style="color: red;">*</span></span>
         <input type="text" placeholder="Description" v-model="description">
      </div>
    </div>
    <div>
      <div v-for="(item, index) in data" :key="index" v-if="!add" style="margin-bottom: 10px;">
        <Cards
          :title="item.title"
          :description="item.description"
          :route="item.id"
          :version="4"
        />
      </div>
      <Pager
          :pages="numPages"
          :active="activePage"
          :limit="limit"
        />
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import Cards from 'src/modules/settings/CardSettings.vue'
import AUTH from 'src/services/auth'
import Pager from 'src/modules/generic/Pager.vue'
export default{
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      limit: 5,
      offset: 0,
      data: [],
      add: false,
      title: null,
      description: null,
      errorMessage: null,
      numPages: null,
      activePage: 1
    }
  },
  components: {
    Cards,
    Pager
  },
  methods: {
    back() {
      ROUTER.push('/transactions')
    },
    create(){
      if(this.user.merchant === null) {
        this.errorMessage = 'Set up your church details first.'
        return
      }
      if(this.title === '' || this.title === null || this.description === null || this.description === '') {
        this.errorMessage = 'All fields are required.'
        return
      } else {
        this.errorMessage = null
      }
      let parameter = {
        title: this.title,
        description: this.description,
        merchant_id: this.user.merchant.id
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('announcements/create', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.add = false
        this.title = null
        this.description = null
        this.retrieve()
      })
    },
    retrieve(){
      if(this.user.merchant === null) {
        return
      }
      let parameter = {
        condition: [{
          column: 'merchant_id',
          value: this.user.merchant.id,
          clause: '='
        }],
        sort: {created_at: 'desc'},
        limit: this.limit,
        offset: this.offset
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('announcements/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0) {
          this.data = response.data
          this.numPages = parseInt(response.size / this.limit) + (response.size % this.limit ? 1 : 0)
        } else {
          this.numPages = null
        }
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container{
  width: 60%;
  margin-top: 30px;
  margin-bottom: 50px;
}
.sort-button{
  border-radius: 25px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $secondary;
  margin-bottom: 10px;
  float: right;
}
.cancel-button{
  border-radius: 25px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $danger;
  margin-bottom: 10px;
  float: right;
  margin-right: 5px;
}
.add-announcemnent{
  margin-top: 80px;
}
.icon-back{
  font-size: 20px;
  cursor: pointer;
  margin-right: 10px;
  margin-top: 4px;
  color: gray
}
.inputs{
  border: .5px solid rgb(204, 204, 204);
  width: 100%;
  margin-bottom: 10px;
  padding: 5px;
}
input {
  border-style: hidden;
  width: 100%;
  outline: none;
  height: 40px;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
