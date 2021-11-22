<template>
  <div>
    <table class="table table-bordered">
          <thead style="text-align: left; margin-top: 3%">
            <tr class="header123">
              <td class="header" @click="show('yearly')"><b>Yearly</b></td>
              <td class="header" @click="show('current_year')"><b>This Year</b></td>
              <td class="header" @click="show('yearly')"><b>Last Month</b></td>
              <td class="header" @click="show('last_month')"><b>This Month</b></td>
              <td class="header" @click="show('current_month')"><b>Last 7 Days</b></td>
              <td class="header">
                <b>Custom:</b>
                <date-picker
                  class="datetime-picker"
                  v-model="custom"
                  range
                  :value-type="'YYYY-MM-DD'"
                  :format="'MMM D, YYYY'"
                  :input-class="'form-control'"
                  >
                  </date-picker> 
                  <div class="fas fa-file-export hover">
                    <div class="tooltip">Export
                    </div>
                  </div>
                  <div class="fas fa-print hover">
                    <div class="tooltip">Print
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
  data() {
    return {
      custom: null
    }
  },
  components: {
    DatePicker
  },
  methods: {
    show(e){
      this.$emit('select', e)
    }
  }
}
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<style scoped lang="scss">
@import '~assets/style/colors.scss';

.datetime-picker{
  width: 35% !important;
  margin-left: 2%;
}
.header{
	text-align: center;
}
.fa-file-export {
  margin-right: 2px;
}

.fa-file-export, .fa-print{
  color: $primary;
}

.hover {
  position: relative;
  top: 0px;
  left: 5%;
  font-size: 18px;
}

.tooltip {
  font-size: 12px;
  text-align: center;
  width: 80px;
  height: 20px;
  top: -30px;
  left: -35px;
  background-color: black;
  color: white;
  border-radius: 5px;
  opacity: 0;
  z-index: 1;
  position: absolute;
  -webkit-transition: opacity 0.5s;
  -moz-transition: opacity 0.5s;
  -ms-transition: opacity 0.5s;
  -o-transition: opacity 0.5s;
  transition: opacity 0.5s;
}

.tooltip::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: black transparent transparent transparent;
}
.hover:hover .tooltip {
  opacity: 1;
}
</style>
