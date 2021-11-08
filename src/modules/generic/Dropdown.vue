<template>
  <span class="dropdown-menu dropdown-menu-right" aria-labelledby="settings" style="font-weight: 400;">
    <span class="dropdown-item dropdown-item-menu-title">
      <i class="fas fa-cog post"></i>
      <label>Post Actions</label>
      <span class="dropdown-item">
        <i class="fas fa-pencil-alt pencil"></i>
        <label style="cursor: pointer;">Edit</label>
      </span>
      <span class="dropdown-item">
        <i class="fas fa-file-alt file"></i>
        <label style="cursor: pointer;">Report</label>
      </span>
      <span class="dropdown-item">
          <i class="fas fa-eye-slash eye-slash"></i>
          <label style="cursor: pointer;">Hide</label>
      </span>
      <span class="dropdown-item">
        <i class="fas fa-trash-alt trash"></i>
        <label style="color: red; cursor: pointer;">Delete</label>
      </span>
    </span>
  </span>
</template>
<script>
export default{
  props: [],
  methods: {}
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.dropdown-menu.show{
  position: absolute;
  margin: 40px -25px;
  
}
.dropdown-menu{
  margin-top: 40px;
  width: 240px;
  min-height: 230px;
  padding-bottom: 0px !important;
}
.dropdown-item .trash{
  color: red;
}
.dropdown-item{
  width: 100% !important;
  height: 40px !important;
  float: left !important;
  background: #fff !important;
  padding-top: 0px !important;
  cursor: pointer !important;
}
.dropdown-item i{
  padding-right: 10px !important;
}
.dropdown-item-menu-title label{
  margin-bottom: 0px;
  line-height: 40px;
  font-weight: 550;
}
.dropdown-item-menu-title:hover, .dropdown-item-menu-title label:hover{
  cursor: default;
  background: #fff !important;
}

</style>
