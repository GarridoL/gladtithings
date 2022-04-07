<template>
  <div>
    <div class="row main-container">
      <div v-for="(item, index) in images" :key="index" :class="images && images.length > 1 ? 'image-holder' : 'image-holder1'" v-if="index < 4 && images.length !== 3">
        <img :src="config.BACKEND_URL + item.category" class="display-image" v-if="item.category.includes('/storage/image/')">
        <video :src="config.BACKEND_URL + item.category" controls v-else class="video">
          Your browser does not support the video tag.
        </video>
      </div>
      <div v-for="(item, index) in images" :key="index" :class="index === 2 ? 'image-holder1' : 'image-holder'" v-if="index < 4 && images.length === 3">
        <img :src="config.BACKEND_URL + item.category" class="display-image" v-if="item.category.includes('/storage/image/')">
        <video :src="config.BACKEND_URL + item.category" controls v-else class="video">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
      <div>
        <span><b>Upload Photo</b></span>
        <input type="file" ref="file" id="Image" :accept="'image/*'" @change="setUpFileUpload($event)">
        <p></p>
        <span><b>Upload Video</b></span>
        <input type="file" ref="file" id="Image" :accept="'video/*'" @change="setUpFileUploadVideo($event)">
        <p v-if="vid">{{this.vid.name}}</p>
      </div>
  </div>
</template>
<script>
import CONFIG from 'src/config.js'
import AUTH from 'src/services/auth'
import axios from 'axios'
export default{
  props: ['images'],
  data() {
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
    removeImage(index){
      this.pictures.splice(index, 1)
    },
    setUpFileUploadVideo(event){
      if(this.vid !== null) {
        this.errorMessage = 'You can only upload 1 video.'
        return
      } else {
        this.errorMessage = null
      }
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
      formData.append('file', this.vid)
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
.image-holder{
  flex-wrap: 'wrap';
  width: calc(50% - 5px);
  margin: 2px;
}
.image-holder1{
  flex-wrap: 'wrap';
  width: calc(100% - 5px);
}
.main-container{
  margin-bottom: 10px;
  margin-top: 10px;
  justify-content: center;
}
.display-image{
  height: 200px;
  width: 100%;
}
.video{
  height: 200px;
  width: 100%;
}
</style>
