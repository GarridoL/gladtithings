<template>
	<div class="body">
		<landing-banner></landing-banner>
    <span class="return-to-top" @click="scrollTo()">
<!--        <font-awesome-icon icon="chevron-up" style="font-size: 24px;" class="icon"></font-awesome-icon> -->
       <i class="fas fa-angle-up" style="font-size: 35px;"></i>
    </span>
	</div>
</template>

<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.body{
  margin: 0px;
}
.return-to-top{
  position: fixed;
  bottom: 10px;
  right: 10px;
  background: $white;
  color: primary;
  height: 50px;
  width: 50px;
  border-radius: 5px;
  line-height: 62px;
  text-align: center;
}
.return-to-top:hover{
  cursor: pointer;
  color: $primary
}
</style>

<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import Jquery from 'jquery'
export default {
  components: {
    'landing-banner': require('modules/home/Landing/Banner.vue')
  },
  mounted(){
  },
  data(){
    return {
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    scrollTo () {
      Jquery('html, body').animate({
        scrollTop: Jquery('#header').offset().top
      }, 500)
    }
  }
}
</script>

