<template>
  <div class="container">
    <i class="fas fa-chevron-left mr-2" style="font-size: 22px; cursor: pointer;" @click="back()"></i>
    <span style="font-size: 22px;"><b>Create/Edit Community</b></span>
    <p style="margin-top: 10px;">Fill out the details below to create a community.</p>
    <div style="margin-top: 30px;">
      <span class="inputs">
        <b>Name</b>
        <div class="form-input">
          <span class="icon"><i class="far fa-user"></i></span>
          <input type="text" class="form-control generic-input" placeholder="Name of the Organization">
        </div>
        <b>Address</b>
        <div class="form-input">
          <span class="icon"><i class="far fa-user"></i></span>
          <input type="text" class="form-control generic-input" placeholder="Address">
        </div>
        <b>Category</b>
        <div class="form-input">
          <span class="icon"><i class="far fa-user"></i></span>
          <input type="text" class="form-control generic-input" placeholder="Church Volunteers">
        </div>
        <b>Logo</b>
        <div class="form-input">
          <i class="fas fa-image image-upload"></i>
        </div>
        <b>Banner</b>
        <div class="form-input">
          <i class="fas fa-image image-upload"></i>
        </div>
      </span>
      <br>
      <button class="sort-button">Submit</button>
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
export default{
  mounted(){},
  data(){
    return {
      user: AUTH.user
    }
  },
  methods: {
    back() {
      ROUTER.push('/community')
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
button:focus{
  outline: none;
}
.container{
  width: 50%;
  background-color: $white;
  padding: 30px;
}
.sort-button{
  border-radius: 25px;
  width: 150px;
  color: $white;
  border: 0px;
  height: 40px;
  background-color: $secondary;
  margin-bottom: 50px;
}
.form-input {
  margin: 10px auto;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}
input {
  padding: 10px 10px;
  border-radius: 30px;
  padding-left: 35px;
  font-size: 10px;
}
.icon {
  position: absolute;
  left: 15px;
  font-size: 13px;
  color: $primary;
  height: 100%;
  display: flex;
  align-items: center;
}
input,
input::-webkit-input-placeholder {
    font-size: 13px;
}
.image-upload{
  text-align: center;
  padding-top: 20px;
  border: 0.5px solid $gray;
  height: 130px;
  width: 100%;
  border-radius: 15px;
  font-size: 90px;
  color: $secondary;
  cursor: pointer;
}
@media (max-width: 992px){
  .container{
    width: 60%;
  }
}
</style>
