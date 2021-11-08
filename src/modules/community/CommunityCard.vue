<template>
  <div class="community">
    <div class="row" style="margin-left: 0px;">
      <div class="column" style="padding-right: 8px;">
        <img :src="require('src/assets/img/test.jpg')" width="40px" height="40px" style="border-radius: 25px;">
      </div>
      <div  class="column"> 
        <div>
          <b>{{name}}</b>
          <p style="font-size: 12px;">{{date}}</p>
        </div>
      </div>
    </div>
    <div style="margin-top: 10px;">
      <i :class="icon"></i>
      <p class="icon-text">&nbsp;&nbsp;{{iconText}}</p>
    </div>
  </div>
</template>
<script>
export default{
  props: ['name', 'date', 'text', 'icon', 'iconText']
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.community {
  text-align: justify;
  width: 100%;
  background-color: $white;
  padding: 15px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 10px;
  cursor: pointer;
}
.icon-text{
  display: inline;
  font-size: 10px;
  vertical-align: 1px;
}
</style>
