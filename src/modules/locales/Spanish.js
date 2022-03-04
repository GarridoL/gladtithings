export default {
  lang: 'spanish',
  getStarted: 'Empezar',
  signIn: 'Registrarse',
  alreadyHaveAnAccount: 'Ya tienes una cuenta?',
  availableLanguages: 'Idiomas Disponibles',
  tapLanguage: 'Toque el idioma que desea usar.',
  username: 'Nombre de usuario',
  password: 'Contraseña',
  forgotPassword: 'Has olvidado tu contraseña?',
  signUp: 'Inscribirse',
  dontHaveAnAccount: '¿No tienes una cuenta?',
  languageSettings: 'Configuraciones de idioma',
  welcome: 'Bienvenida',
  viewMore: 'Ver más',
  add: 'Agregar',
  cancelConfirmation: '¿Estás segura de que quieres eliminar esto?',
  logout: 'Cerrar sesión',
  sideBarMenu: [
    {accountType: 'ALL', showOnAdmin: true, accountStatus: 'ALL', description: 'Tablero', icon: 'fa fa-home', path: 'dashboard', flag: false, subMenu: null},
    {accountType: 'ALL', showOnAdmin: true, accountStatus: 'ALL', description: 'Actas', icon: 'fas fa-clipboard', path: 'transactions', flag: false, subMenu: null},
    {accountType: 'ALL', showOnAdmin: true, accountStatus: 'ALL', description: 'Eventos', icon: 'fas fa-calendar-alt', path: 'events', flag: false, subMenu: null},
    {accountType: 'ALL', showOnAdmin: true, accountStatus: 'ALL', description: 'Comunidad', icon: 'fa fa-users', path: 'community', flag: false, subMenu: null},
    {accountType: 'ALL', showOnAdmin: true, accountStatus: 'ALL', description: 'Suscripciones', icon: 'fas fa-user-check', path: 'subscription_management', flag: false, subMenu: null},
    {accountType: 'ALL', showOnAdmin: true, accountStatus: 'ALL', description: 'Ajustes', icon: 'fas fa-cog', path: 'settings', flag: false, subMenu: null},
    {accountType: 'ADMIN', showOnAdmin: true, accountStatus: 'ADMIN', description: 'Cuenta', icon: 'fas fa-users-cog', path: 'accounts', flag: false, subMenu: null}
  ],
  DrawerMenu1: [{
    title: 'Términos y condiciones',
    route: 'termsAndConditionStack',
    icon: null,
    borderBottom: false
  },
  {
    title: 'Política de privacidad',
    route: 'privacyStack',
    icon: null,
    borderBottom: false
  }],
  settingsOptions: [
    {
      title: 'Configuraciones de la cuenta',
      description: 'Detalles de la cuenta y actualizar la contraseña',
      route: 'accountSettingsStack'
    },
    {
      title: 'Editar perfil',
      description: 'Actualice su información personal y más',
      route: 'profileStack'
    },
    {
      title: 'Suscripciones',
      description: 'Ver su plan de suscripción',
      route: 'subscriptionStack'
    },
    {
      title: 'Configuración de las notificaciones',
      description: 'Recibe notificación a cualquiera de los siguientes',
      route: 'notificationSettingsStack'
    },
    {
      title: 'Eventos a los que asistí',
      description: 'Ver todos los eventos a los que asistí.',
      route: 'eventSettingsStack'
    },
    {
      title: 'sobre la aplicación',
      description: 'Abrir sitio web',
      route: 'website'
    },
    {
      title: 'Configuración de pantalla',
      description: 'Cambia los colores de tu tema aquí',
      route: 'displayStack'
    },
    {
      title: 'Lista de Métodos de Pago',
      description: 'Ver la lista de todos sus métodos de pago',
      route: 'methodsStack'
    },
    {
      title: 'Configuración de idioma',
      description: 'Administre los idiomas que desea usar aquí',
      route: 'languageSettingsStack'
    }
  ],
  fieldError: 'Por favor complete los campos requeridos.',
  notMatchError: `El nombre de usuario y la contraseña no coincidían.`,
  emailError: 'El correo electrónico no existe.',
  emailAddress: 'Dirección de correo electrónico',
  confirmPassword: 'Confirmar Contraseña',
  newPassword: 'Nueva contraseña',
  reset: 'Reiniciar',
  submit: 'Enviar',
  requestReset: 'Solicitud para restablecer la contraseña',
  churchesNearby: 'Iglesias cercanas',
  search: 'Buscar',
  deposit: 'Depositar',
  withdraw: 'Retirar',
  tithings: 'diezmos',
  availableBalance: 'Saldo disponible',
  subscriptions: 'Suscripciones',
  subscriptionDescription: 'Diezmos sin complicaciones. Simplemente establezca la cantidad, la iglesia y el tiempo, luego lo haremos por usted.',
  accountSettings: 'Configuraciones de la cuenta',
  update: 'Actualizar',
  securityCredentials: 'Credenciales de seguridad',
  profile: 'Perfil',
  verified: 'Verificada',
  personalInformation: 'Informacion personal',
  edit: 'Editar',
  noEmail: 'No se proporcionó una dirección de correo electrónico',
  noPhoneNumber: 'No se proporcionó un número de teléfono',
  noLocation: 'No se proporcionó ubicación',
  noGender: 'Género',
  cancel: 'Cancelar',
  firstName: 'Primer nombre',
  lastName: 'Apellido',
  phoneNumber: 'Número de teléfono',
  address: 'Dirección',
  notificationSettings: 'Configuración de las notificaciones',
  notificationsOptions: [
    {
      title: 'Iniciar sesión por correo electrónico',
      description: 'Recibe la dirección de correo electrónico cada vez que hay un inicio de sesión de la cuenta.',
      flag: false
    },
    {
      title: 'Correo electrónico OTP',
      description: 'OTP se enviará a su dirección de correo electrónico',
      flag: false
    },
    {
      title: 'SMS OTP',
      description: 'Se le enviará OTP por SMS utilizando su número de móvil registrado',
      flag: true
    },
    {
      title: 'Suscríbete para recibir nuestras últimas actualizaciones',
      description: 'Recibe eventos y muchos más en su dirección de correo electrónico registrada',
      flag: false
    }
  ],
  themeSettings: 'Ajustes de tema',
  colorList: [
    {
      title: 'Modo 1',
      details: 'Add description here',
      colors: ['#4CCBA6', '#000000']
    },
    {
      title: 'Modo 2',
      details: 'Add description here',
      colors: ['#5842D7', '#000000']
    },
    {
      title: 'Modo 3',
      details: 'Add description here',
      colors: ['#000000', '#4CCBA6']
    }
  ],
  emptyTithings: 'Basta empty ni sya na spanish.',
  community: {
    name: 'Name(ES)',
    name_placeholder: 'Name of the Organization(ES)',
    address: 'Address(ES)',
    address_placeholder: 'Address(ES)',
    category: 'Category(ES)',
    category_placeholder: 'Church Volunteers(ES)',
    email: 'Email(ES)',
    email_placeholder: 'Email Address(ES)',
    website: 'Website(ES)',
    website_placeholder: 'Website(ES)',
    logo: 'Logo(ES)',
    banner: 'Banner(ES)',
    submit: 'Submit(ES)'
  },
  subscription: {
    hi: 'Hola',
    proceed: 'Continuar',
    greet: 'cómo estás ?',
    cancelSubscription: 'Cancelar suscripción',
    saveChanges: 'Guardar cambios',
    seeBillings: 'Vea su facturación aquí...',
    viewSubscriptionList: 'Ver lista de suscripciones',
    viewPaymentMethods: 'Ver métodos de pago',
    paymentMethods: 'Métodos de pago',
    noSubscription: 'No hay suscripción disponible',
    noPayment: 'No hay métodos de pago disponibles',
    message: 'Mensaje',
    noBillings: 'No tienes ninguna suscripción en esta iglesia.',
    noChurchSelectedMessage: `No tienes una iglesia seleccionada por ahora. Por favor haga clic en el botón de abajo para buscar la iglesia que le interesa para automatizar sus diezmos.`,
    ChurchSelectedMessage: `Aquí está la lista de iglesias a las que está suscrito. Haga clic en el botón de abajo para buscar más iglesias que le interesen para automatizar sus diezmos.`
  },
  pageMenuSetting: [{
    title: 'About(ES)',
    description: 'Manage information of this community',
    route: 'pageAboutScreen'
  }, {
    title: 'Page Roles(ES)',
    description: 'Roles management of the community',
    route: 'pageRolesScreen'
  }, {
    title: 'Members(ES)',
    description: 'View all members of this community',
    route: 'pageMembersScreen'
  }],
  pageRoles: {
    placeholder: 'Username or Email Address',
    user: 'Invite Member'
  },
  pageMembers: {
    placeholder: 'Username or Email Address',
    user: 'Invite Member'
  },
  churchProfile: {
    events: 'Eventos',
    announcement: 'Anuncios',
    noAnnouncement: 'Esta iglesia no tiene anuncio.'
  },
  massesNearby: {
    emptyMasses: 'No hay masas cercanas.'
  },
  homepage: {
    noSubscription: `No tienes ninguna suscripción a la iglesia. Haga clic en 'Buscar iglesia' a continuación para buscar iglesias que le interesen.`
  },
  events: {
    attend: 'Atender'
  },
  churches: {
    empty: 'No se encontró ninguna iglesia para este filtro.'
  }
}
