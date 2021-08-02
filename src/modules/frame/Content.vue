<template>
  <div class="content-holder">
    <transition >
      <router-view ></router-view>
    </transition>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
  .content-holder{
    width: 100%;
    height: 100%;
    float: left;
    overflow: hidden;
    background-color: $primary;
  }/*-- content-holder --*/
</style>
