import common from 'src/common.js'
export default {
  page: [{
    property: {
      width: '100%',
      background: common.colors.primary
    },
    title: 'Sending cash in a new and convenient way!',
    description: 'In Payhiram, we have partners to fulfill your cash needed in any locations you want. Start sending today!',
    image: require('assets/img/logo.png'),
    frame: {
      height: '350px',
      width: '550px',
      float: 'right',
      margin: '70px 90px 50px 40px'
    },
    textColor: 'text-white',
    buttonsFlag: true,
    appUrl: {
      android: 'https://play.google.com/store/apps/details?id=com.payhiram',
      ios: null
    }
  }]
}

