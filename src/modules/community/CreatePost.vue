<template>
  <div class="modal fade" id="createPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Photos<span v-if="errorMessage" class="error-message">&nbsp;&nbsp;{{errorMessage}}</span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <span class="image-container" v-for="(item, index) in pictures" :key="index" v-if="pictures.length > 0" @click="activeIndex !== null ? activeIndex = null : activeIndex = index">
            <img :class="activeIndex === index ? 'image-with-opacity' : 'image'" :src="item.file_base64"/>
              <i class="fas fa-trash-alt delete-image" v-if="activeIndex === index" @click="removeImage(index)"></i>
          </span>
          <div class="upload-icon">
            <i class="fas fa-upload upload" @click="$refs.file.click()"></i>
            <input type="file" ref="file" id="Image" :accept="'image/*'" @change="setUpFileUpload($event)" style="display: none">
            <span>Upload Photo</span>
          </div>
          <div class="upload-icon">
            <i class="fas fa-upload upload" @click="$refs.file.click()"></i>
            <input type="file" ref="file" id="Image" :accept="'video/*'" @change="setUpFileUploadVideo($event)" style="display: none">
            <span>Upload Video</span>
          </div>
          <!-- <div class="upload-icon">
            <i class="fas fa-upload upload" @click="$refs.file.click()"></i>
            <input type="file" ref="file" id="Video" :accept="'video/*'" @change="setUpFileUploadVideo($event)" style="display: none">
            <p>Upload Video</p>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
export default{
  mounted(){},
  data(){
    return {
      user: AUTH.user,
      file: null,
      errorMessage: null,
      config: CONFIG,
      pictures: [],
      activeIndex: null,
      base64: null,
      vid: null
    }
  },
  methods: {
    back() {
      ROUTER.push('/community')
    },
    removeImage(index){
      this.pictures.splice(index, 1)
    },
    setUpFileUploadVideo(event){
      let files = event.target.files || event.dataTransfer.files
      if(!files.length){
        return false
      }else{
        this.vid = files[0]
        let filename = this.vid.name.toLowerCase()
        if(filename.substring(filename.lastIndexOf('.')) === '.mp4'){
        }else{
          this.errorMessage = 'Upload video only!'
          this.vid = null
        }
      }
    },
    setUpFileUpload(event){
      if(this.pictures.length === 4) {
        this.errorMessage = 'You can only upload atleast 4 images.'
        return
      } else {
        this.errorMessage = null
      }
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
      fileReader.readAsDataURL(file)
      fileReader.addEventListener('load', () => {
        this.base64 = fileReader.result
        let image = {
          file_base64: this.base64,
          file_url: file.name
        }
        console.log(image)
        this.pictures.push(image)
      }, false)
    },
    upload(commentId){
      let parameter = {
        images: this.pictures,
        account_id: this.user.userID,
        payload: 'comment_id',
        payload_value: commentId
      }
      $('#loading').css({'display': 'block'})
      axios.post(this.config.BACKEND_URL + '/images/upload_image64_array?token=' + AUTH.tokenData.token, parameter).then(response => {
        $('#loading').css({'display': 'none'})
        console.log(response, 'response')
        this.$parent.retrieve()
      })
    },
    uploadVid(commentId){
      if(this.vid === null) {
        return
      }
      let formData = new FormData()
      formData.append('file', {
        name: this.vid.name,
        type: this.vid.type,
        uri: 'file:///data/user/0/com.gladtithings/cache/react-native-image-crop-picker/' + this.vid.name
      })
      formData.append('file_url', this.vid.name)
      formData.append('account_id', this.user.userID)
      formData.append('category', 'video-from-comment')
      $('#loading').css({'display': 'block'})
      this.uploadByFetch(this.config.BACKEND_URL + '/files/upload_file', formData, response => {
        $('#loading').css({'display': 'none'})
        if(response.data) {
          let par = {
            account_id: this.user.userID,
            payload: 'comment_id',
            payload_value: commentId,
            category: response.data
          }
          this.APIRequest('payloads/create', par, res => {
            if(res.data) {
              this.$parent.retrieve()
              this.vid = null
            }
          }, error => {
            console.log(error, 'payloads')
          })
        }
      }, error => {
        console.log(error)
        $('#loading').css({'display': 'none'})
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.upload{
  font-size: 1rem;
}
.error-message{
  color: $danger;
  font-size: 12px;
}
.upload-icon{
  cursor: pointer;
  margin-top: 20px;
  margin-bottom: 20px;
}
.image-container{
  flex-wrap: wrap;
  cursor: pointer;
}
.image{
  width: 100px;
  height: 100px;
}
.image-with-opacity{
  opacity: 0.7;
  width: 100px;
  height: 100px;
}
.delete-image{
  position: relative;
  left: -60px;
  color: red;
  font-size: 1.2rem;
}
</style>
