<template>
  <div>
    <table class="table table-bordered">
          <thead style="text-align: left; margin-top: 3%">
            <tr class="header123">
              <td class="header" id="yearly" @click="activate('yearly')"><b>Yearly</b></td>
              <td class="header" id="current_year" @click="activate('current_year')"><b>This Year</b></td>
              <td class="header" id="last_month" @click="activate('last_month')"><b>Last Month</b></td>
              <td class="header" id="current_month" @click="activate('current_month')"><b>This Month</b></td>
              <td class="header" id="last_days" @click="activate('last_days')"><b>Last 7 Days</b></td>
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
          </thead>
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
  name: 'GraphHeader',
  props: ['data'],
  mounted(){
    const {vfs} = pdfFonts.pdfMake
    PDFTemplate.vfs = vfs
  },
  data() {
    return {
      PdfTemplate: TemplatePdf,
      custom: null,
      tempStyle: null
    }
  },
  components: {
    DatePicker
  },
  methods: {
    exportD(){
      let options = {
        fieldSeparator: ',',
        quoteStrings: '"',
        decimalSeparator: '.',
        showLabels: true,
        showTitle: true,
        title: 'Summary',
        useTextFile: false,
        useBom: true,
        // useKeysAsHeaders: true,
        filename: this.data !== undefined ? this.data.datasets[0].label : 'No Summary',
        headers: ['Date', 'Amount']
      }
      var exportData = []
      if(this.data !== undefined && this.data.labels.length > 0 && this.data.datasets[0].data.length > 0){
        for (let index = 0; index < this.data.labels.length; index++) {
          const items = this.data.labels[index]
          for (let index = 0; index < this.data.datasets[0].data.length; index++) {
            const item = this.data.datasets[0].data[index]
            let obj = {
              date: items,
              amount: Math.abs(item)
            }
            exportData.push(obj)
          }
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
        // let tempStyle = document.querySelector(`#${tempStyle}`)
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
.datetime-picker{
  width: 50% !important;
  // margin-left: 2%;
}
.header{
	text-align: center;
  vertical-align: middle;
  background-color: #F6F6F6;
}
.fa-file-export {
  margin-right: 2px;
  margin-left: 2%;
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
