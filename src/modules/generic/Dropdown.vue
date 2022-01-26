<template>
  <div>
    <span class="dropdown-menu dropdown-menu-right" aria-labelledby="settings" style="font-weight: 400;">
      <span class="dropdown-item dropdown-item-menu-title">
        <i class="fas fa-cog post"></i>
        <label>Post Actions</label>
        <span class="dropdown-item" v-if="account_id === user.userID" @click="showModal()">
          <i class="fas fa-pencil-alt pencil"></i>
          <label style="cursor: pointer;">Edit</label>
        </span>
        <span class="dropdown-item" v-if="account_id !== user.userID" @click="report()">
          <i class="fas fa-file-alt file"></i>
          <label style="cursor: pointer;">Report</label>
        </span>
        <span class="dropdown-item" v-if="account_id === user.userID">
          <i class="fas fa-trash-alt trash"></i>
          <label style="color: red; cursor: pointer;">Delete</label>
        </span>
      </span>
    </span>
    <div class="modal fade" id="editPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <textarea wrap="off" rows="5" class="input-post"  v-model="text" :placeholder="text"></textarea>
            <button class="text-center sort-button" @click="edit()">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import AUTH from 'src/services/auth'
export default{
  props: ['id', 'account_id', 'text'],
  methods: {
    report() {
      let parameter = {
        payload: 'comment_id',
        payload_value: this.id,
        status: 'ongoing',
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('reports/create', parameter).then(response => {
        $('#loading').css({display: 'none'})
      })
    },
    edit() {
      if(this.text === null || this.text === '') {
        return
      }
      let parameter = {
        id: this.id,
        text: this.text
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('comments/update', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data > 0) {
          this.$parent.updateText(this.text)
          $('#editPost').modal('hide')
          this.text = null
        }
      })
    },
    showModal() {
      $('#editPost').modal('show')
    }
  },
  data(){
    return {
      user: AUTH.user
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.dropdown-menu.show{
  position: absolute;
  margin: 10px -25px;
  
}
.sort-button{
  margin-top: 10px;
  border-radius: 25px;
  width: 120px;
  color: white;
  border: 0px;
  height: 40px;
  background-color: $primary;
  float: right;
}
.input-post{
  outline: none;
  overflow:hidden;
  border-radius: 20px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 10px;
  outline: none;
  padding: 10px;
  width: 100%;
}
.dropdown-menu{
  margin-top: 40px;
  width: 240px;
  min-height: 125px;
  padding-bottom: 0px !important;
}
.dropdown-item .trash{
  color: red;
}
.dropdown-item{
  width: 100% !important;
  height: 40px !important;
  float: left !important;
  background: #fff !important;
  padding-top: 0px !important;
  cursor: pointer !important;
}
.dropdown-item i{
  padding-right: 10px !important;
}
.dropdown-item-menu-title label{
  margin-bottom: 0px;
  line-height: 40px;
  font-weight: 550;
}
.dropdown-item-menu-title:hover, .dropdown-item-menu-title label:hover{
  cursor: default;
  background: #fff !important;
}

</style>
