<template>
  <div class="table-container">
    <table class="table table-bordered table-responsive" v-if="data !== null">
      <thead>
        <tr>
          <td class="header" v-for="(item, index) in headers" :key="index"><b>{{item}}</b></td>
        </tr>
      </thead>
    </table>
  </div>
</template>
<script>
export default{
  props: ['headers']
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.header {
  text-align: center;
}
.table-container{
  height: 50vh;
  background-color: white;
  margin-bottom: 10px;
  margin-top: 50px;
}
</style>
