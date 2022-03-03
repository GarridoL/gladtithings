<template>
  <div class="container">
    <div>
      <basic-filter 
        v-bind:category="category" 
        :activeCategoryIndex="0"
        :activeSortingIndex="0"
        @changeSortEvent="retrieve($event.sort, $event.filter)"
        @changeStyle="manageGrid($event)"
        :grid="['list', 'th-large']">
      </basic-filter>
    </div>
    <empty v-if="data === null" :title="'No accounts available!'" :action="'Keep growing.'"></empty>
    <div class="table-container" v-else>
      <table class="table table-bordered table-responsive" v-if="data !== null">
      <thead>
        <tr>
          <td class="header"><b>Date</b></td>
          <td class="header"><b>Username</b></td>
          <td class="header"><b>Email Address</b></td>
          <td class="header"><b>Account Type</b></td>
          <td class="header"><b>Status</b></td>
          <td class="header"><b>Actions</b></td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <td class="header">{{item.created_at}}</td>
          <td class="header">
            <label class="action-link text-primary">{{item.username}}</label>
          </td>
          <td class="header email">{{item.email}}</td>
          <td class="header">
            <label v-if="editTypeIndex !== index">{{item.account_type}}</label>
            <!-- <i class="fa fa-pencil text-primary" style="margin-left: 10px;" @click="setEditTypeIndex(index, item)" v-if="editTypeIndex !== index"></i> -->
            <span v-if="editTypeIndex === index">
              <select class="form-control" v-model="newAccountType" style="float: left; width: 70%;">
                <option v-for="(typeItem, typeIndex) in ['USER', 'ADMIN', 'CHURCH']" :key="typeIndex">{{typeItem}}</option>
              </select>
              <i class="fa fa-check text-primary" style="margin-left: 5px; float: left;" @click="updateType(item, index)"></i>
              <i class="fa fa-times text-danger" style="margin-left: 5px; float: left;" @click="setEditTypeIndex(index, item)"></i>
            </span>
          </td>
          <td class="header">{{item.status}}</td>
          <td class="header" style="width: 15%;">
            <span>
              <i class="fas fa-edit" style="margin-left: 1px; color: #56C596"></i>
              <i class="fas fa-eye icon-eye" style="margin-left: 1px; color: black;"></i>
              <i class="fas fa-qrcode" style="margin-left: 1px; color: black;"></i>
              <i class="fas fa-list-alt" style="margin-left: 1px; color: grey;"></i>
              <i class="fas fa-trash-alt icon-trash" style="margin-left: 1px; color: red;"></i>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
    <Pager
      :pages="numPages"
      :active="activePage"
      :limit="limit"
      v-if="data !== null"
    />
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.header {
  text-align: center;
}
.table{
  background-color: white;
}
.ledger-summary-container{
  width: 70%;
  float: left;
  height: auto;
  margin-bottom: 100px;
  margin-top: 25px;
  margin-left: 15%;
}
.table-container{
  background-color: white;
  margin-bottom: 10px;
}
.container{
  width: 62%;
  margin-bottom: 100px;
  margin-top: 25px;
}
td i {
  padding-right: 0px !important;
  padding-left: 0px !important;
}


@media (max-width: 992px){
  .ledger-summary-container, .container{
    width: 100%;
  }
}
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
export default{
  mounted(){
    this.retrieve({created_at: 'desc'}, {column: 'created_at', value: ''})
  },
  data(){
    return {
      user: AUTH.user,
      data: null,
      auth: AUTH,
      selecteditem: null,
      config: CONFIG,
      category: [{
        title: 'Sort by',
        sorting: [{
          title: 'Username ascending',
          payload: 'username',
          payload_value: 'asc'
        }, {
          title: 'Username descending',
          payload: 'username',
          payload_value: 'desc'
        }, {
          title: 'Email ascending',
          payload: 'email',
          payload_value: 'asc'
        }, {
          title: 'Email descending',
          payload: 'email',
          payload_value: 'desc'
        }, {
          title: 'Type ascending',
          payload: 'status',
          payload_value: 'asc'
        }, {
          title: 'Type descending',
          payload: 'status',
          payload_value: 'desc'
        }, {
          title: 'Created ascending',
          payload: 'created_at',
          payload_value: 'asc'
        }, {
          title: 'Created descending',
          payload: 'created_at',
          payload_value: 'desc'
        }]
      }],
      filter: null,
      sort: null,
      editTypeIndex: null,
      newAccountType: null,
      selectedAccount: null,
      limit: 5,
      numPages: null,
      activePage: 1
    }
  },
  components: {
    'empty': require('components/increment/generic/empty/Empty.vue'),
    'basic-filter': require('modules/generic/Basic.vue'),
    'increment-modal': require('components/increment/generic/modal/Modal.vue'),
    Pager
  },
  methods: {
    setEditTypeIndex(index, item){
      if(index === this.editTypeIndex){
        this.editTypeIndex = null
        this.newAccountType = null
      }else{
        this.selectedAccount = item
        this.editTypeIndex = index
        this.newAccountType = item.account_type
      }
    },
    updateType(item, index){
      if(this.newAccountType === null || this.newAccountType === item.account_type){
        this.setEditTypeIndex(index, item)
        return
      }
      let parameter = {
        id: item.id,
        account_type: this.newAccountType
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('accounts/update_verification', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.setEditTypeIndex(index, item)
        this.retrieve(null, null)
      })
    },
    redirect(params){
      ROUTER.push(params)
    },
    retrieve(sort, filter){
      if(sort !== null){
        this.sort = sort
      }
      if(filter !== null){
        this.filter = filter
      }
      if(sort === null && this.sort !== null){
        sort = this.sort
      }
      if(filter === null && this.filter !== null){
        filter = this.filter
      }
      let parameter = {
        condition: [{
          value: filter.value + '%',
          column: filter.column,
          clause: 'like'
        }, {
          value: this.user.userID,
          column: 'id',
          clause: '!='
        }],
        sort: sort,
        limit: this.limit,
        offset: (this.activePage > 0) ? ((this.activePage - 1) * this.limit) : this.activePage
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('accounts/retrieve_accounts_admin', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data
          this.numPages = parseInt(response.size / this.limit) + (response.size % this.limit ? 1 : 0)
        }else{
          this.data = null
          this.numPages = null
        }
      })
    },
    deleteLocation(id){
      let parameter = {
        id: id
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('investor_locations/delete', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.retrieve(null, null)
      })
    }
  }
}
</script>
