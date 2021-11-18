<template>
  <div class="modal fade" id="createPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Photos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <span class="image-container" v-for="(item, index) in pictures" :key="index" v-if="pictures.length > 0" @click="activeIndex !== null ? activeIndex = null : activeIndex = index">
            <img :class="activeIndex === index ? 'image-with-opacity' : 'image'" :src="item.result"/>
              <i class="fas fa-trash-alt delete-image" v-if="activeIndex === index" @click="removeImage(index)"></i>
          </span>
          <div class="upload-icon">
            <i class="fas fa-upload upload" @click="$refs.file.click()"></i>
            <input type="file" ref="file" id="Image" :accept="'image/*'" @change="setUpFileUpload($event)" style="display: none">
            <p>Upload</p>
          </div>
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
      activeIndex: null
    }
  },
  methods: {
    back() {
      ROUTER.push('/community')
    },
    removeImage(index){
      this.pictures.splice(index, 1)
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
      fileReader.readAsDataURL(file)
      this.pictures.push(fileReader)
      console.log(fileReader, file)
    }
    // upload(){
    //   if(parseInt(this.file.size / 1024) > 1024){
    //     this.errorMessage = 'Allowed size is up to 1 MB only'
    //     this.file = null
    //     return
    //   }
    //   let formData = new FormData()
    //   formData.append('file', this.file)
    //   formData.append('file_url', this.file.name.replace(' ', '_'))
    //   formData.append('account_id', this.user.userID)
    //   formData.append('category', 'profile')
    //   $('#loading').css({'display': 'block'})
    //   console.log('imageRoute', formData)
    //   axios.post(this.config.BACKEND_URL + '/images/upload?token=' + AUTH.tokenData.token, formData).then(response => {
    //     $('#loading').css({'display': 'none'})
    //     if(response.data.data !== null){
    //       this.retrieve()
    //     }
    //   })
    // }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.upload{
  font-size: 3rem;
}
.upload-icon{
  text-align: center;
  width: 100%;
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
