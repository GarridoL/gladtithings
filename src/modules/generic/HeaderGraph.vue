<template>
  <div>
    <table class="table table-bordered">
          <thead>
            <tr class="header123">
              <td class="header"><b>Yearly</b></td>
              <td class="header"><b>This Year</b></td>
              <td class="header"><b>Last Month</b></td>
              <td class="header"><b>This Month</b></td>
              <td class="header"><b>Last 7 Days</b></td>
              <td class="header2">
        <div class="row no-gutters">
          <b>Custom:</b>
          <div class="col-sm
           datetime-picker-ui">
            <date-picker
              class="datetime-picker"
              v-model="custom"
              range
              :value-type="'YYYY-MM-DD'"
              :format="'MMM D, YYYY'"
              :input-class="'form-control'"
              >
              </date-picker> 
          </div>
            <div  class="col-sm-3 file-export">
              <i class="fas fa-file-export">&nbsp;<b>Export</b></i>
            </div>
            <div  class="col-sm-3 print">
              <i class="fas fa-print">&nbsp;<b>Print</b></i>
            </div>  
        </div>
          </td>
            </tr>
          </thead>
    </table>
  </div>
</template>
<script>
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'
export default {
  data() {},
  components: {
    DatePicker
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.datetime-picker-ui{
  width: 60% !important;
}
.datetime-picker{
	width: 100%;
	margin-left: 5%;
}
.header{
	text-align: center;
}
.header2{
  width: 60%;
}
.no-gutters{
  justify-content: center;
  text-align: center;
  align-content: center;
  align-items: center;
}
.file-export {
	width: 10%;
  color: $white;
  background-color: $secondary;
  margin-left: 3%;
  padding: 3%;
  border-radius: 5px;
  font-size: 10px;
}
.print {
	width: 10%;
  background-color: $primary;
  margin-left: 2%;
  padding: 3%;
  border-radius: 5px;
}
.fa-print{
  color: $white;
}
</style>
