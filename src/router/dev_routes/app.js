
export default{
  routes: [{
    path: '/',
    name: 'login',
    component: resolve => require(['modules/basic/Login.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }, {
    path: '/dashboard',
    name: 'dashboard',
    component: resolve => require(['modules/dashboard/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/signup',
    name: 'signup',
    component: resolve => require(['modules/basic/Register.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }, {
    path: '/signup/:email/:code',
    name: 'signup',
    component: resolve => require(['modules/basic/Register.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }, {
    path: '/verification/:email',
    name: 'verification',
    component: resolve => require(['components/increment/basic/Verification.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }, {
    path: '/login_verification/:username/:code',
    name: 'loginVerification',
    component: resolve => require(['components/increment/basic/LoginByVerification.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }, {
    path: '/login',
    name: 'loginAccount',
    component: resolve => require(['modules/basic/Login.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }, {
    path: '/request_reset_password',
    name: 'requestResetPassword',
    component: resolve => require(['modules/basic/RequestResetPassword.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }, {
    path: '/reset_password/:username/:code',
    name: 'resetPassword',
    component: resolve => require(['modules/basic/ResetPassword.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }, {
    path: '/profile/:parameter?',
    name: 'profile',
    component: resolve => require(['components/increment/settings/UpdateBasic.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/accounts',
    name: 'accounts',
    component: resolve => require(['modules/account/List.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/events',
    name: 'events',
    component: resolve => require(['modules/events/List.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }
  ]
}
