<template>
  <div>
    <span class="settings">
      <p v-if="errorMessage !== null" class="text-danger" style="margin-top: 10px;">
        <b>Opps!</b> {{errorMessage}}
      </p>
      <span v-if="data !== null">
        <span v-bind:class="{'active-image': item.active === true }" class="image-holder" v-for="(item, index) in data" v-bind:key="index" @click="select(index)">
          <img style="width: 100%;height: 100%;display: block;" :src="config.BACKEND_URL + item.url"/>
          <button type="button" class="btn btn-danger" id="deleteBtn" data-toggle="modal" data-target="#featured-confirm-delete" v-if="item.active" @click="selectDeleteImage(item.id)">
            <i class="fa fa-times"></i>
          </button>
        </span>
      </span>
      <span v-if="data.length === 0" class="image-holder" style="text-align: center;" @click="addImage()">
        <i class="fa fa-plus" style="font-size: 60px; line-height: 120px;"></i>
        <input type="file" id="FeaturedImage" :accept="type ? type : 'image/*'" @change="setUpFileUpload($event)">
      </span>
      <span v-if="data.length <= 1" class="image-holder" style="text-align: center;" @click="addImage()">
        <i class="fa fa-plus" style="font-size: 60px; line-height: 120px;"></i>
        <input type="file" id="FeaturedImage" :accept="type ? type : 'image/*'" @change="setUpFileUpload($event)">
      </span>
      <span v-if="data.length <= 2" class="image-holder" style="text-align: center;" @click="addImage()">
        <i class="fa fa-plus" style="font-size: 60px; line-height: 120px;"></i>
        <input type="file" id="FeaturedImage" :accept="type ? type : 'image/*'" @change="setUpFileUpload($event)">
      </span>
    </span>
     <div class="modal fade right" id="featured-confirm-delete" tabindex="1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
      <div class="modal-dialog modal-side modal-notify modal-primary " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Are you sure?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
            </button>
          </div>
          <div class="modal-body p-4" >
            <p>Do you really want to delete this photo?</p>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" @click="cancel()">Cancel</button>
              <button class="btn btn-danger btn-ok" data-dismiss="modal" @click="deleteImage()" >Delete</button>
            </div>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import axios from 'axios'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      idImage: null,
      user: AUTH.user,
      config: CONFIG,
      searchValue: null,
      data: [],
      prevIndex: null,
      loadingFlag: false,
      errorMessage: null,
      file: null,
      category: null
    }
  },
  props: ['customId', 'type', 'modalTitle'],
  methods: {
    getFileType(url){
      let url1 = url.toLowerCase()
      console.log(url.substring(url.lastIndexOf('.')))
      return url1.substring(url1.lastIndexOf('.')) === '.webm' || url1.substring(url1.lastIndexOf('.')) === '.mp4' ? 'vid' : 'img'
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    addImage(){
      $('#FeaturedImage')[0].click()
    },
    setUpFileUpload(event){
      let files = event.target.files || event.dataTransfer.files
      if(!files.length){
        return false
      }else{
        this.file = files[0]
        let filename = this.file.name.toLowerCase()
        if(filename.substring(filename.lastIndexOf('.')) === '.png' || filename.substring(filename.lastIndexOf('.')) === '.jpg' || filename.substring(filename.lastIndexOf('.')) === '.jpeg' || filename.substring(filename.lastIndexOf('.')) === '.gif' || filename.substring(filename.lastIndexOf('.')) === '.tif' || filename.substring(filename.lastIndexOf('.')) === '.bmp'){
          this.createFile(files[0])
        }else{
          this.errorMessage = 'Upload images only!'
          this.file = null
        }
      }
    },
    createFile(file){
      let fileReader = new FileReader()
      fileReader.readAsDataURL(event.target.files[0])
      this.upload()
    },
    upload(){
      if(parseInt(this.file.size / 1024) > 1024){
        this.errorMessage = 'Allowed size is up to 1 MB only'
        this.file = null
        return
      }
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('file_url', this.file.name.replace(' ', '_'))
      formData.append('account_id', this.user.userID)
      formData.append('category', 'featured-photo')
      $('#loading').css({'display': 'block'})
      axios.post(this.config.BACKEND_URL + '/images/upload?token=' + AUTH.tokenData.token, formData).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data.data !== null){
          this.retrieve()
        }
      })
      this.prevIndex = null
    },
    filterImage() {
      if (this.data === null || this.filteredData === null) return
      const _data = [...this.data]
      this.filteredData = _data.filter(image => image.url.toLowerCase().indexOf(this.searchValue) > -1)
    },
    retrieve(){
      const parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }, {
          value: 'featured-photo',
          column: 'category',
          clause: '='
        }],
        sort: {
          created_at: 'desc'
        }
      }
      this.loadingFlag = true
      this.APIRequest('images/retrieve', parameter).done(response => {
        this.loadingFlag = false
        if(response.data.length > 0){
          this.data = response.data
        } else{
          this.data = []
        }
      })
    },
    select(index){
      if(this.prevIndex === null){
        this.data[index].active = true
        this.prevIndex = index
      }else{
        if(this.prevIndex !== index){
          this.data[this.prevIndex].active = false
          this.data[index].active = true
          this.prevIndex = index
        }
      }
    },
    cancel() {
      $('#featured-confirm-delete').modal('hide')
      $('#featuredImagesModal').modal('show')
    },
    close(){
      if(!this.data){
        $('#featuredImagesModal').modal('hide')
      }else{
        this.prevIndex = null
        $('#featuredImagesModal').modal('hide')
      }
      this.data[this.prevIndex].active = false
      this.prevIndex = null
      $('#featuredImagesModal').modal('hide')
    },
    selectDeleteImage(id){
      this.idImage = id
      $('#featuredImagesModal').modal('hide')
    },
    deleteImage(){
      let params = {
        id: this.idImage
      }
      axios.post(this.config.BACKEND_URL + '/images/delete?token=' + AUTH.tokenData.token, params).then(response => {
        this.retrieve()
      })
      this.prevIndex = null
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.bg-primary{
  background: $primary !important; 
}
#deleteBtn{
  position: absolute;
  top: 8px;
  right: 10px;
  border-radius: 20px;
}
.item{
  width: 100%;
  float: left;
}
.header, .search{
  width: 100%;
  float: left;
  height: 50px;
  text-align: center;
  line-height: 50px;
  text-align: center;
}
.header .fa-close{
  padding-right: 5px;
}
.settings{
  min-height: 145px;
  float: left;
  width: 100%;
  overflow-y: hidden;
}
.search .form-control-custom{
  width: 100%;
  float: left;
  height: 45px !important;
  margin-top: 2px;
  padding-top: 3px !important;
}
.search i{
  float: right;
  padding-right: 7px;
  margin-top: -50px;
  font-size: 14px !important;
}
.search i:hover{
  cursor: pointer;
}
.image-holder{
  position: relative;
  width: 15%;
  float: left;
  height: 120px;
  margin-bottom: 5px;
  border: solid 1px #ddd;
  border-radius: 2px;
}
.image-holder img{
  max-height: 200px;
  max-width: 100%;
  float: left;
}
.image-holder input{
  display: none;
  height: 200px;
  width: 200px;
}
.bottom-action{
  width: 100%;
  float: left;
  height: 40px;
  font-size: 10px;
}
.bottom-action .btn{
  float: left;
  height: 30px !important;
  padding-top: 5px !important; 
  margin-top: 5px;
  font-size: 10px !important;
  margin-left: 5px;
}
.image-holder:hover{
  cursor: pointer;
  background: #ffaa81;
}
.active-image{
  background: #ffaa81;
  border: solid 1px #ffaa81;
}
.active-image1{
  background: blue;
  border: solid 1px blue;
}
.settings .error{
  height: 50px;
  font-size: 10px;
  text-align: center;
  width: 100%;
  float: left;
  line-height: 50px;
}
</style>
