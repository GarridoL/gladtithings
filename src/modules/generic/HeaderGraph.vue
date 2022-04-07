<template>
  <div>
    <table class="table table-bordered">
      <tr class="test">
        <td class="header" id="yearly" @click="activate('yearly')"><b>Yearly</b></td>
        <td class="header" id="current_year" @click="activate('current_year')"><b>This Year</b></td>
        <td class="header" id="last_month" @click="activate('last_month')"><b>Last Month</b></td>
        <td class="header" id="current_month" @click="activate('current_month')"><b>This Month</b></td>
        <td class="header" id="7days" @click="activate('7days')"><b>Last 7 Days</b></td>
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
export default {
  props: ['data', 'name'],
  mounted(){
    this.activate('yearly')
    const {vfs} = pdfFonts.pdfMake
    PDFTemplate.vfs = vfs
  },
  data() {
    return {
      PdfTemplate: TemplatePdf,
      custom: null,
      tempStyle: null,
      datum: []
    }
  },
  components: {
    DatePicker
  },
  methods: {
    details(){
      this.datum = []
      for (let ndx = 0; ndx < this.data.details.length; ndx++) {
        var obj = {
          currency: this.setDetailsCurrency(this.data.details[ndx], ndx),
          from: this.setDetailsFrom(this.data.details[ndx], ndx),
          description: this.setDetailsDescription(this.data.details[ndx], ndx)
        }
        this.datum.push(obj)
      }
    },
    setDetailsCurrency(data, ndx){
      if(data.details !== null){
        return Array.isArray(data.details) ? data.details[ndx].currency : data.details.currency
      }
    },
    setDetailsFrom(data, ndx){
      if(data.details !== null){
        return Array.isArray(data.details) ? data.details[ndx].details.from : data.details.details.from
      }
    },
    setDetailsDescription(data, ndx){
      if(data.details !== null){
        return Array.isArray(data.details) ? data.details[ndx].description : data.details.description
      }
    },
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
        filename: this.data !== undefined ? this.data.datasets[0].label : 'No Summary',
        headers: ['DATE/YEAR', 'CURRENCY', 'AMOUNT', 'DESCRIPTION', 'FROM']
      }
      this.details()
      var exportData = []
      if(this.data !== undefined && this.data.labels.length > 0 && this.data.datasets[0].data.length > 0){
        for (let index = 0; index < this.data.labels.length; index++) {
          const items = this.data.labels[index]
          const item = this.dataSet(this.data.datasets[0].data[index])
          let obj = {
            date: items,
            from: this.datum[index].from !== undefined ? this.datum[index].from : 'N/A',
            currencu: this.datum[index].currency !== undefined ? this.datum[index].currency : 'N/A',
            amount: item,
            description: this.datum[index].description !== undefined ? this.datum[index].description : 'N/A'
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
      this.PdfTemplate.getDate(this.tempStyle === null ? 'yearly' : this.tempStyle)
      this.PdfTemplate.template()
    },
    activate(id){
      if(this.tempStyle === null){
        this.tempStyle = id
        document.getElementById(`${id}`).style.backgroundColor = 'white'
      }else{
        document.getElementById(`${this.tempStyle}`).style.backgroundColor = '#F6F6F6'
        document.getElementById(`${id}`).style.backgroundColor = 'white'
        this.tempStyle = id
        this.$emit('temp', this.tempStyle)
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
