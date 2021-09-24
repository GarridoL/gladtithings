<template>
  <div class="container">
    <label v-if="label"><b>{{title}}&nbsp;</b><span v-if="optional === false" style="color: red;">*</span></label><br>
    <input :placeholder="placeholder" class="generic-input">
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
export default{
  props: [
    'title',
    'placeholder',
    'label',
    'optional'
  ],
  mounted(){},
  data(){
    return {
      user: AUTH.user
    }
  },
  methods: {
    redirect(route) {
      ROUTER.push(route)
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container{
  width: 100%;
  margin: 0px;
}
label{
  margin-top: 5px;
}
.generic-input{
  height: 40px;
  width: 100%;
  border-radius: 20px;
  border: .5px solid rgb(204, 204, 204);
  outline: none;
  padding: 10px;
  margin-bottom: 20px;
}
@media (max-width: 992px){
  .container{
    width: 100%;
    display: flex;
  }
}
</style>
