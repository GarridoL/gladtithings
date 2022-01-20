import PDFTemplate from 'pdfmake'

export default {
  dataSet: [],
  data: null,
  getItem(data) {
    this.dataSet = data
  },
  getDate(date){
    this.date = date.replace(/_/g, ' ').toUpperCase()
  },
  template() {
    var retrieve = []
    retrieve.push(
      [
        {
          text: 'Date',
          margin: [120, 0, 0, 0],
          fontSize: 10,
          bold: true
        },
        {
          text: ' ',
          margin: [0, 0, 0, 0],
          fontSize: 10,
          bold: true
        },
        {
          text: 'Amount',
          bold: true,
          margin: [0, 0, 120, 0],
          fontSize: 10,
          alignment: 'right'
        }
      ]
    )
    if(this.dataSet !== undefined && this.dataSet.labels.length > 0 && this.dataSet.datasets[0].data.length > 0){
      for (let index = 0; index < this.dataSet.labels.length; index++) {
        const items = this.dataSet.labels[index]
        for (let index = 0; index < this.dataSet.datasets[0].data.length; index++) {
          const item = this.dataSet.datasets[0].data[index]
          retrieve.push([
            { text: items, fontSize: 10, margin: [120, 0, 0, 0], border: [false, false, false, false] },
            { text: ' ', fontSize: 10, margin: [0, 0, 0, 0], border: [false, false, false, false] },
            { text: item, fontSize: 10, margin: [0, 0, 120, 0], border: [false, false, false, false], alignment: 'right' }
          ])
        }
      }
    }
    var docDefinition = {
      pageMargins: [20, 20, 20, 20],
      pageSize: {
        width: 595.28,
        height: 'auto'
      },
      content: [
        {
          image: 'data:image/png;base64,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',
          fit: [70, 70],
          alignment: 'center',
          margin: [ 5, 5, 5, 10 ]
        },
        {
          text: 'Gladtithings',
          bold: true,
          fontSize: 12,
          style: 'subheader',
          alignment: 'center',
          margin: [0, 0, 0, 3]
        },
        {
          text: '8WF6+H29, Cebu City, Cebu',
          fontSize: 10,
          style: 'subheader',
          alignment: 'center',
          margin: [0, 0, 0, 15]
        },
        {
          text: [ { text: 'Summary ' }, { text: '(' + this.date + ')', bold: true } ],
          fontSize: 15,
          style: 'subheader',
          alignment: 'center',
          margin: [0, 0, 0, 10]
        },
        {
          style: 'tableExample',
          table: {
            headerRows: 1,
            widths: ['*', '*', '*'],
            body: retrieve
          },
          layout: 'lightHorizontalLines'
        }
      ]
    }
    PDFTemplate.createPdf(docDefinition).open()
  }
}
