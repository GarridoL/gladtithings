webpackJsonp([19],{1040:function(a,t,n){var e=n(990);"string"==typeof e&&(e=[[a.i,e,""]]),e.locals&&(a.exports=e.locals);n(410)("1ca25b5b",e,!0)},1109:function(a,t,n){a.exports={render:function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("div",{staticClass:"header",attrs:{id:"header"}},[e("div",{staticClass:"header-section"},[e("span",{staticClass:"logo"},[e("a",{staticClass:"navbar-brand",on:{click:function(t){return a.redirect("/")}}},[e("img",{staticStyle:{"margin-bottom":"5px",width:"130px",height:"80px"},attrs:{src:n(913)}})])]),a._v(" "),e("span",{staticClass:"menu"},[a._m(0),a._v(" "),e("ul",{staticClass:"header-primary-menu"},[e("li",{staticClass:"nav-item",on:{click:function(t){return a.redirect("/signup")}}},[e("a",{staticClass:"nav-link"},[a._v("Register")])]),a._v(" "),e("li",{staticClass:"nav-item",on:{click:function(t){return a.redirect("/login")}}},[e("a",{staticClass:"nav-link"},[a._v("Login")])])])])]),a._v(" "),e("div",{staticClass:"collapse navbar-collapse",attrs:{id:"navbarSupportedContent"}},[e("ul",{staticClass:"navbar-nav ml-auto"},[e("li",{staticClass:"nav-item",attrs:{"data-toggle":"collapse","data-target":"#navbarSupportedContent"},on:{click:function(t){return a.redirect("/signup")}}},[e("a",{staticClass:"nav-link"},[a._v("Register")])]),a._v(" "),e("li",{staticClass:"nav-item",attrs:{"data-toggle":"collapse","data-target":"#navbarSupportedContent"},on:{click:function(t){return a.redirect("/login")}}},[e("a",{staticClass:"nav-link"},[a._v("Login")])])])])])},staticRenderFns:[function(){var a=this,t=a.$createElement,n=a._self._c||t;return n("span",{staticClass:"navbar-menu-toggler-md"},[n("i",{staticClass:"fa fa-bars",attrs:{"data-toggle":"collapse","data-target":"#navbarSupportedContent","aria-controls":"navbarSupportedContent","aria-expanded":"false","aria-label":"Toggle navigation",onclick:"void(0)"}})])}]}},436:function(a,t,n){n(1040);var e=n(289)(n(974),n(1109),"data-v-0fb90283",null);a.exports=e.exports},449:function(a,t,n){"use strict";n(24);t.a={sidebarMenu:[{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Dashboard",icon:"fa fa-home",path:"dashboard",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Transactions",icon:"fas fa-clipboard",path:"transactions",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Events",icon:"fas fa-calendar-alt",path:"events",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Community",icon:"fa fa-users",path:"community",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Subscriptions",icon:"fas fa-user-check",path:"subscription_management",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Settings",icon:"fas fa-cog",path:"settings",flag:!1,subMenu:null},{accountType:"ADMIN",showOnAdmin:!0,accountStatus:"ADMIN",description:"Accounts",icon:"fas fa-users-cog",path:"accounts",flag:!1,subMenu:null}],menuOff:[{id:1,users:"ALL",parent_id:0,description:"Dashboard",icon:"fa fa-tachometer",path:"dashboard",flag:!1,subMenu:null}],APP_NAME:"Glad Tithings",APP_NAME_HTML:"Glad Tithings",APP_EMAIL:"support@gladtithings.com",APP_SITE:"https://gladtithings.com",COMPANY:"Glad Tithings",COMPANY_URL:"http://gladtithings.com",COPYRIGHT:"Glad Tithings "+(new Date).getFullYear(),USER_TYPE:[{title:"USER"}],profileMenu:[{title:"My Profile",icon:"fa fa-cog",route:"/profile"}],USER_TYPE_SETTING:!1,plan:!1,broadcastingFlag:!0,header:["status","notification"],settingsMenu:[{title:"Account Settings",type:"account",allowed:[]},{title:"Business Setting",type:"merchant",allowed:["prefix","website","address","schedule","information"]}]}},913:function(a,t,n){a.exports=n.p+"static/img/white_logo.3ceefbc.png"},974:function(a,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var e=n(36),i=(n(54),n(24)),o=n(141),r=n.n(o),A=n(449);t.default={mounted:function(){},data:function(){return{flag:!0,config:i.default,common:A.a}},watch:{$route:function(a,t){"/"===a.path?this.flag=!0:this.flag=!1}},methods:{redirect:function(a){e.a.push(a)},scrollTo:function(a){this.barFlag=!1,r()("html, body").animate({scrollTop:r()(a).offset().top},500)}}}},990:function(a,t,n){t=a.exports=n(409)(),t.push([a.i,".header[data-v-0fb90283]{width:100%;float:left;min-height:70px;background:#56c596;overflow-y:hidden}.header-section[data-v-0fb90283]{min-height:50px;overflow-y:hidden;width:90%;font-size:12px;color:#fff;margin:5px auto}.header-section .logo[data-v-0fb90283]{width:20%;float:left;height:100%}.header-section .menu[data-v-0fb90283]{width:80%;float:left;height:100%;margin-top:30px}.navbar-menu-toggler-md[data-v-0fb90283]{width:100%;text-align:right;float:left;display:none}.menu .header-primary-menu[data-v-0fb90283]{width:100%;float:left;min-height:30px;list-style:none;overflow-y:hidden;padding:0;margin-bottom:0!important}.btn-white[data-v-0fb90283]{background:#fff;color:#00bff3!important}.fa-bars[data-v-0fb90283]{border:1px solid #fff;font-size:20px!important;padding:10px 8px!important;color:#fff!important}.fa-bars[data-v-0fb90283]:hover{cursor:pointer}.menu .header-primary-menu .nav-item[data-v-0fb90283]{float:right;font-size:15px;margin-left:5px}.header-primary-menu .nav-item .nav-link[data-v-0fb90283]{padding:.5rem}.header-primary-menu .nav-item a[data-v-0fb90283]{color:#fff;font-family:MuseoRounded700,sans-serif}.header-primary-menu .nav-item .nav-link[data-v-0fb90283]:hover{cursor:pointer;text-decoration:underline}.navbar-toggler[data-v-0fb90283]{background:inherit!important;border-radius:0!important;border:1px solid #fff;font-size:20px!important;padding:10px 8px!important;color:#fff!important}.navbar-toggler[data-v-0fb90283]:hover{color:#00bff3!important;background:#fff!important}.navbar-collapse .show[data-v-0fb90283]{display:none!important}.header-section .logo a img[data-v-0fb90283]{width:50px}.header-section .logo a label[data-v-0fb90283]{font-size:24px;margin-bottom:0}@media screen and (max-width:992px){.header-section[data-v-0fb90283]{width:90%!important;margin:0 5%!important}.header-section .logo[data-v-0fb90283]{width:80%;margin-top:10px}.header-section .menu[data-v-0fb90283]{width:20%;margin-top:15px}.menu .header-primary-menu[data-v-0fb90283],.menu .top-menu[data-v-0fb90283]{display:none}.navbar[data-v-0fb90283]{width:90%!important;margin:0 5%!important;padding:0!important}.navbar-collapse[data-v-0fb90283]{width:100%!important;position:absolute!important;z-index:100000!important;float:left;border-bottom:1px solid #00bff3}.navbar-nav[data-v-0fb90283]{background:#fff!important;margin:0!important}.navbar-nav .nav-link[data-v-0fb90283]{width:100%!important;padding:17px 30px!important}.navbar-nav .nav-link[data-v-0fb90283]:hover{background:#00bff3;color:#fff}.navbar-nav .nav-link[data-v-0fb90283]{color:#00bff3}.navbar-menu-toggler-md[data-v-0fb90283]{width:100%;text-align:right;float:left;display:block}}","",{version:3,sources:["C:/xampp/htdocs/gladtithings/src/modules/home/Landing/Header.vue"],names:[],mappings:"AACA,yBAAyB,WAAW,WAAW,gBAAgB,mBAAmB,iBAAiB,CAClG,AACD,iCAAiC,gBAAgB,kBAAkB,UAAU,eAAe,WAAW,eAAwB,CAC9H,AACD,uCAAuC,UAAU,WAAW,WAAW,CACtE,AACD,uCAAuC,UAAU,WAAW,YAAY,eAAe,CACtF,AACD,yCAAyC,WAAW,iBAAiB,WAAW,YAAY,CAC3F,AACD,4CAA4C,WAAW,WAAW,gBAAgB,gBAAgB,kBAAkB,UAAY,yBAA4B,CAC3J,AACD,4BAA4B,gBAAgB,uBAAwB,CACnE,AACD,0BAA0B,sBAAsB,yBAA0B,2BAAqC,oBAAqB,CACnI,AACD,gCAAgC,cAAc,CAC7C,AACD,sDAAsD,YAAY,eAAe,eAAe,CAC/F,AACD,0DAA0D,aAAa,CACtE,AACD,kDAAkD,WAAW,sCAAsC,CAClG,AACD,gEAAgE,eAAe,yBAAyB,CACvG,AACD,iCAAiC,6BAA8B,0BAA6B,sBAAsB,yBAA0B,2BAAqC,oBAAqB,CACrM,AACD,uCAAuC,wBAAyB,yBAA0B,CACzF,AACD,wCAAwC,sBAAuB,CAC9D,AACD,6CAA6C,UAAU,CACtD,AACD,+CAA+C,eAAe,eAAiB,CAC9E,AACD,oCACA,iCAAiC,oBAAqB,qBAA2B,CAChF,AACD,uCAAuC,UAAU,eAAe,CAC/D,AACD,uCAAuC,UAAU,eAAe,CAC/D,AACD,6EAA6E,YAAY,CACxF,AACD,yBAAyB,oBAAqB,sBAA4B,mBAAoB,CAC7F,AACD,kCAAkC,qBAAsB,4BAA6B,yBAA0B,WAAW,+BAA+B,CACxJ,AACD,6BAA6B,0BAA2B,kBAAmB,CAC1E,AACD,uCAAuC,qBAAsB,2BAAsC,CAClG,AACD,6CAA6C,mBAAmB,UAAU,CACzE,AACD,uCAAuC,aAAa,CACnD,AACD,yCAAyC,WAAW,iBAAiB,WAAW,aAAa,CAC5F,CACA",file:"Header.vue",sourcesContent:["\n.header[data-v-0fb90283]{width:100%;float:left;min-height:70px;background:#56c596;overflow-y:hidden\n}\n.header-section[data-v-0fb90283]{min-height:50px;overflow-y:hidden;width:90%;font-size:12px;color:#fff;margin:5px auto 5px auto\n}\n.header-section .logo[data-v-0fb90283]{width:20%;float:left;height:100%\n}\n.header-section .menu[data-v-0fb90283]{width:80%;float:left;height:100%;margin-top:30px\n}\n.navbar-menu-toggler-md[data-v-0fb90283]{width:100%;text-align:right;float:left;display:none\n}\n.menu .header-primary-menu[data-v-0fb90283]{width:100%;float:left;min-height:30px;list-style:none;overflow-y:hidden;padding:0px;margin-bottom:0px !important\n}\n.btn-white[data-v-0fb90283]{background:#fff;color:#00bff3 !important\n}\n.fa-bars[data-v-0fb90283]{border:solid 1px #fff;font-size:20px !important;padding:10px 8px 10px 8px !important;color:#fff !important\n}\n.fa-bars[data-v-0fb90283]:hover{cursor:pointer\n}\n.menu .header-primary-menu .nav-item[data-v-0fb90283]{float:right;font-size:15px;margin-left:5px\n}\n.header-primary-menu .nav-item .nav-link[data-v-0fb90283]{padding:.5rem\n}\n.header-primary-menu .nav-item a[data-v-0fb90283]{color:#fff;font-family:MuseoRounded700,sans-serif\n}\n.header-primary-menu .nav-item .nav-link[data-v-0fb90283]:hover{cursor:pointer;text-decoration:underline\n}\n.navbar-toggler[data-v-0fb90283]{background:inherit !important;border-radius:0px !important;border:solid 1px #fff;font-size:20px !important;padding:10px 8px 10px 8px !important;color:#fff !important\n}\n.navbar-toggler[data-v-0fb90283]:hover{color:#00bff3 !important;background:#fff !important\n}\n.navbar-collapse .show[data-v-0fb90283]{display:none !important\n}\n.header-section .logo a img[data-v-0fb90283]{width:50px\n}\n.header-section .logo a label[data-v-0fb90283]{font-size:24px;margin-bottom:0px\n}\n@media screen and (max-width: 992px){\n.header-section[data-v-0fb90283]{width:90% !important;margin:0 5% 0 5% !important\n}\n.header-section .logo[data-v-0fb90283]{width:80%;margin-top:10px\n}\n.header-section .menu[data-v-0fb90283]{width:20%;margin-top:15px\n}\n.menu .top-menu[data-v-0fb90283],.menu .header-primary-menu[data-v-0fb90283]{display:none\n}\n.navbar[data-v-0fb90283]{width:90% !important;margin:0 5% 0 5% !important;padding:0 !important\n}\n.navbar-collapse[data-v-0fb90283]{width:100% !important;position:absolute !important;z-index:100000 !important;float:left;border-bottom:solid 1px #00bff3\n}\n.navbar-nav[data-v-0fb90283]{background:#fff !important;margin:0 !important\n}\n.navbar-nav .nav-link[data-v-0fb90283]{width:100% !important;padding:17px 30px 17px 30px !important\n}\n.navbar-nav .nav-link[data-v-0fb90283]:hover{background:#00bff3;color:#fff\n}\n.navbar-nav .nav-link[data-v-0fb90283]{color:#00bff3\n}\n.navbar-menu-toggler-md[data-v-0fb90283]{width:100%;text-align:right;float:left;display:block\n}\n}"],sourceRoot:""}])}});
//# sourceMappingURL=19.d1e338141cbef14d5265.js.map