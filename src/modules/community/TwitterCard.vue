<template>
  <div class="message">
    <div class="row" style="margin-left: 0px;">
      <div class="column" style="padding-right: 8px;">
        <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px;">
      </div>
      <div class="column"> 
        <div >
          <b>{{name}}</b>
          <p style="font-size: 12px;">{{date}}</p>
        </div>
      </div>
      <p class="text">{{text}}</p>
    </div>
  </div>
</template>
<script>
export default{
  props: ['name', 'date', 'text']
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.message {
  text-align: justify;
  width: 100%;
  background-color: $white;
  padding: 15px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  cursor: pointer;
  margin-bottom: 20px;
}
.message p{
  padding-right: 15px;
}
.text{
  width: 100%;
  padding-top: 20px;
}
</style>
