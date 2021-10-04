
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
    component: resolve => require(['modules/accountSettings/index.vue'], resolve),
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
  },
  {
    path: '/events/details',
    name: 'eventDetails',
    component: resolve => require(['modules/events/Details.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/events/:status?',
    name: 'createEvents',
    component: resolve => require(['modules/events/Create.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/subscription_management',
    name: 'subscriptionManagement',
    component: resolve => require(['modules/subscriptionManagement/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/settings',
    name: 'settings',
    component: resolve => require(['modules/settings/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/payment_methods',
    name: 'paymentMethods',
    component: resolve => require(['modules/paymentMethods/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/notification_settings',
    name: 'notificationSettings',
    component: resolve => require(['modules/notificationSettings/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/subscriptions',
    name: 'subscriptions',
    component: resolve => require(['modules/subscriptions/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/transactions',
    name: 'transactions',
    component: resolve => require(['modules/transactions/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/church_details',
    name: 'churchDetails',
    component: resolve => require(['modules/churchDetails/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/account_settings',
    name: 'accountSettings',
    component: resolve => require(['modules/accountSettings/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }, {
    path: '/community',
    name: 'community',
    component: resolve => require(['modules/community/index.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/community/create',
    name: 'createCommunity',
    component: resolve => require(['modules/community/Create.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }]
}
