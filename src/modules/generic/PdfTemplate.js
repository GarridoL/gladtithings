import PDFTemplate from 'pdfmake'

export default {
  getItem(data) {
    console.log('[this]')
  },
//   getImage(image) {
//     this.imageLogo = image
//   },
  template() {
    var docDefinition = {
      pageMargins: [20, 20, 20, 20],
      pageSize: {
        width: 595.28,
        height: 'auto'
      },
      content: [
        // {
        //   image: 'this.imageLogo',
        //   fit: [100, 100],
        //   alignment: 'center'
        //   // margin: [ 5, 5, 5, 5 ]
        // },
        {
          text: 'Gladtithings',
          bold: true,
          fontSize: 15,
          style: 'subheader',
          alignment: 'center',
          margin: [0, 0, 0, 3]
        },
        {
          text: [ { text: 'Summary ' }, { text: '(Yearly HardCoded)', bold: true } ],
          fontSize: 10,
          style: 'subheader',
          alignment: 'center',
          margin: [0, 0, 0, 7]
        },
        {
          style: 'tableExample',
          table: {
            width: 70,
            headerRows: 2,
            widths: ['*', '*', '*'],
            body: [
              [{text: 'Header 1', style: 'tableHeader'}, {text: ' ', style: 'tableHeader'}, {text: 'Header 2', style: 'tableHeader'}],
              ['Sample value 1', ' ', 'Sample value 2'],
              ['Sample value 1', ' ', 'Sample value 2'],
              ['Sample value 1', ' ', 'Sample value 2'],
              ['Sample value 1', ' ', 'Sample value 2'],
              ['Sample value 1', ' ', 'Sample value 2']
            ]
          },
          layout: 'lightHorizontalLines'
        }
      ]
    }
    PDFTemplate.createPdf(docDefinition).open()
  }
}
