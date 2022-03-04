<template>
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
</template>
<script>
import CONFIG from 'src/config.js'
export default{
  props: ['images'],
  methods: {},
  data() {
    return {
      config: CONFIG
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
  height: 300px;
  width: 100%;
}
.video{
  height: 300px;
  width: 100%;
}
</style>
