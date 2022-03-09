<template>
  <div>
    <table class="table table-bordered">
      <tr class="test">
        <td class="header" id="yearlyD" @click="activateDon('yearly', 'yearlyD')"><b>Yearly</b></td>
        <td class="header" id="current_yearD" @click="activateDon('current_year', 'current_yearD')"><b>This Year</b></td>
        <td class="header" id="last_monthD" @click="activateDon('last_month', 'last_monthD')"><b>Last Month</b></td>
        <td class="header" id="current_monthD" @click="activateDon('current_month', 'current_monthD')"><b>This Month</b></td>
        <td class="header" id="7daysD" @click="activateDon('7days', '7daysD')"><b>Last 7 Days</b></td>
        <td class="header">
          <div class="fas fa-file-export hover" @click="exportD(data)">
            <div class="tooltip">Export
            </div>
          </div>
          <div class="fas fa-print hover" @click="print(data)">
            <div class="tooltip">Print
            </div>
          </div>
        </td>
      </tr>
    </table>
  </div> 
</template>
<script>
import pdfFonts from 'pdfmake/build/vfs_fonts'
import PDFTemplate from 'pdfmake'
import TemplatePdf from './PdfTemplate.js'
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'
import { ExportToCsv } from 'export-to-csv'
import { LayoutPlugin } from 'bootstrap-vue'
export default {
  props: ['dataDonate', 'name'],
  mounted(){
    this.activateDon('yearly', 'yearlyD')
    const {vfs} = pdfFonts.pdfMake
    PDFTemplate.vfs = vfs
  },
  data() {
    return {
      PdfTemplate: TemplatePdf,
      custom: null,
      tempStyleDonate: null,
      temp: null
    }
  },
  components: {
    DatePicker
  },
  methods: {
    dataSet(data){
      return data
    },
    exportD(){
      let options = {
        fieldSeparator: ',',
        quoteStrings: '"',
        decimalSeparator: '.',
        showLabels: true,
        showTitle: true,
        title: 'Summary of ' + this.name,
        useTextFile: false,
        useBom: true,
        // useKeysAsHeaders: true,
        filename: this.dataDonate !== undefined ? this.dataDonate.datasets[0].label : 'No Summary',
        headers: ['Date', 'Amount']
      }
      var exportData = []
      if(this.dataDonate !== undefined && this.dataDonate.labels.length > 0 && this.dataDonate.datasets[0].data.length > 0){
        for (let index = 0; index < this.dataDonate.labels.length; index++) {
          const items = this.dataDonate.labels[index]
          const item = this.dataSet(this.dataDonate.datasets[0].data[index])
          let obj = {
            date: items,
            amount: item
          }
          exportData.push(obj)
        }
      }
      if(exportData.length > 0){
        var csvExporter = new ExportToCsv(options)
        csvExporter.generateCsv(exportData)
      }
    },
    print(data){
      this.PdfTemplate.getItem(data)
      this.PdfTemplate.getDate(this.tempStyleDonate === null ? 'yearly' : this.tempStyleDonate)
      this.PdfTemplate.template()
    },
    activateDon(id, name){
      if(this.tempStyleDonate === null){
        this.temp = name
        this.tempStyleDonate = id
        document.getElementById(`${name}`).style.backgroundColor = 'white'
      }else{
        if(this.temp === null){
          document.getElementById(`${name}`).style.backgroundColor = 'white'
          this.temp = name
        }else{
          if(this.temp !== name){
            document.getElementById(`${this.temp}`).style.backgroundColor = '#F6F6F6'
            document.getElementById(`${name}`).style.backgroundColor = 'white'
            this.temp = name
          }
        }
        this.tempStyleDonate = id
      }
    }
  }
}
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<style scoped lang="scss">
@import '~assets/style/colors.scss';
.theads{
  width: 90%
}
.header{
	text-align: center;
  vertical-align: middle;
  background-color: #F6F6F6;
}
.fa-file-export {
  // margin-right: 2px;
  // margin-left: 2%;
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
  // margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: black transparent transparent transparent;
}
.hover:hover .tooltip {
  opacity: 1;
}
@media (max-width: 991px){
  .head{
    width: 80% !important;
    // text-align: center;
  }
  .test{
    width: 100% !important;
  }
  .canvas{
    width: 100% !important;
  }
}
</style>
