webpackJsonp([17],{1035:function(t,e,n){var r=n(985);"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n(410)("9bf53302",r,!0)},1104:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"modal fade",attrs:{id:"quickTutorialNavigationModal",tabindex:"-1",role:"dialog","aria-labelledby":"exampleModalLabel","aria-hidden":"true"}},[n("div",{staticClass:"modal-dialog modal-md",attrs:{role:"document"}},[n("div",{staticClass:"modal-content"},[n("div",{staticClass:"modal-header bg-primary"},[n("h5",{staticClass:"modal-title",attrs:{id:"exampleModalLabel"}},[t._v("Quick  Tutorial")]),t._v(" "),n("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"},on:{click:function(e){return t.close()}}},[n("span",{staticClass:"text-white",attrs:{"aria-hidden":"true"}},[t._v("×")])])]),t._v(" "),n("div",{staticClass:"modal-body"},[n("span",{staticClass:"guide-row"},[null!==t.common.GUIDE[t.activeIndex].image?n("img",{attrs:{src:t.common.GUIDE[t.activeIndex].image,height:"100px",width:"100px"}}):t._e(),t._v(" "),null!==t.common.GUIDE[t.activeIndex].icon?n("i",{staticClass:"fa text-primary",class:t.common.GUIDE[t.activeIndex].icon,staticStyle:{"font-size":"100px"}}):t._e(),t._v(" "),n("h2",{staticClass:"text-primary"},[t._v(t._s(t.common.GUIDE[t.activeIndex].title))]),t._v(" "),n("p",{domProps:{innerHTML:t._s(t.common.GUIDE[t.activeIndex].subtitle)}})])]),t._v(" "),n("div",{staticClass:"modal-footer"},[t.common.GUIDE.length-1>t.activeIndex?n("button",{staticClass:"btn btn-danger",on:{click:function(e){return t.markAsDone()}}},[t._v("Skip")]):t._e(),t._v(" "),t.common.GUIDE.length-1===t.activeIndex?n("button",{staticClass:"btn btn-primary pull-right",on:{click:function(e){return t.markAsDone()}}},[t._v("Finish")]):t._e(),t._v(" "),t.common.GUIDE.length-1>t.activeIndex?n("button",{staticClass:"btn btn-primary pull-right",on:{click:function(e){return t.next()}}},[t._v("Next")]):t._e(),t._v(" "),t.activeIndex>0?n("button",{staticClass:"btn btn-warning pull-right",staticStyle:{"margin-right":"10px"},on:{click:function(e){return t.previous()}}},[t._v("Previous")]):t._e()])])])])])},staticRenderFns:[]}},416:function(t,e,n){n(1035);var r=n(289)(n(934),n(1104),"data-v-037e6e98",null);t.exports=r.exports},448:function(t,e,n){"use strict";function r(t){return"[object Array]"===T.call(t)}function o(t){return void 0===t}function i(t){return null!==t&&!o(t)&&null!==t.constructor&&!o(t.constructor)&&"function"==typeof t.constructor.isBuffer&&t.constructor.isBuffer(t)}function a(t){return"[object ArrayBuffer]"===T.call(t)}function s(t){return"undefined"!=typeof FormData&&t instanceof FormData}function c(t){return"undefined"!=typeof ArrayBuffer&&ArrayBuffer.isView?ArrayBuffer.isView(t):t&&t.buffer&&t.buffer instanceof ArrayBuffer}function u(t){return"string"==typeof t}function f(t){return"number"==typeof t}function l(t){return null!==t&&"object"==typeof t}function d(t){if("[object Object]"!==T.call(t))return!1;var e=Object.getPrototypeOf(t);return null===e||e===Object.prototype}function p(t){return"[object Date]"===T.call(t)}function h(t){return"[object File]"===T.call(t)}function m(t){return"[object Blob]"===T.call(t)}function g(t){return"[object Function]"===T.call(t)}function v(t){return l(t)&&g(t.pipe)}function x(t){return"undefined"!=typeof URLSearchParams&&t instanceof URLSearchParams}function y(t){return t.replace(/^\s*/,"").replace(/\s*$/,"")}function A(){return("undefined"==typeof navigator||"ReactNative"!==navigator.product&&"NativeScript"!==navigator.product&&"NS"!==navigator.product)&&("undefined"!=typeof window&&"undefined"!=typeof document)}function b(t,e){if(null!==t&&void 0!==t)if("object"!=typeof t&&(t=[t]),r(t))for(var n=0,o=t.length;n<o;n++)e.call(null,t[n],n,t);else for(var i in t)Object.prototype.hasOwnProperty.call(t,i)&&e.call(null,t[i],i,t)}function w(){function t(t,n){d(e[n])&&d(t)?e[n]=w(e[n],t):d(t)?e[n]=w({},t):r(t)?e[n]=t.slice():e[n]=t}for(var e={},n=0,o=arguments.length;n<o;n++)b(arguments[n],t);return e}function C(t,e,n){return b(e,function(e,r){t[r]=n&&"function"==typeof e?S(e,n):e}),t}function E(t){return 65279===t.charCodeAt(0)&&(t=t.slice(1)),t}var S=n(456),T=Object.prototype.toString;t.exports={isArray:r,isArrayBuffer:a,isBuffer:i,isFormData:s,isArrayBufferView:c,isString:u,isNumber:f,isObject:l,isPlainObject:d,isUndefined:o,isDate:p,isFile:h,isBlob:m,isFunction:g,isStream:v,isURLSearchParams:x,isStandardBrowserEnv:A,forEach:b,merge:w,extend:C,trim:y,stripBOM:E}},449:function(t,e,n){"use strict";n(24);e.a={sidebarMenu:[{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Dashboard",icon:"fa fa-home",path:"dashboard",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Transactions",icon:"fas fa-clipboard",path:"transactions",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Events",icon:"fas fa-calendar-alt",path:"events",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Community",icon:"fa fa-users",path:"community",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Subscriptions",icon:"fas fa-user-check",path:"subscription_management",flag:!1,subMenu:null},{accountType:"ALL",showOnAdmin:!0,accountStatus:"ALL",description:"Settings",icon:"fas fa-cog",path:"settings",flag:!1,subMenu:null},{accountType:"ADMIN",showOnAdmin:!0,accountStatus:"ADMIN",description:"Accounts",icon:"fas fa-users-cog",path:"accounts",flag:!1,subMenu:null}],menuOff:[{id:1,users:"ALL",parent_id:0,description:"Dashboard",icon:"fa fa-tachometer",path:"dashboard",flag:!1,subMenu:null}],APP_NAME:"Glad Tithings",APP_NAME_HTML:"Glad Tithings",APP_EMAIL:"support@gladtithings.com",APP_SITE:"https://gladtithings.com",COMPANY:"Glad Tithings",COMPANY_URL:"http://gladtithings.com",COPYRIGHT:"Glad Tithings "+(new Date).getFullYear(),USER_TYPE:[{title:"USER"}],profileMenu:[{title:"My Profile",icon:"fa fa-cog",route:"/profile"}],USER_TYPE_SETTING:!1,plan:!1,broadcastingFlag:!0,header:["status","notification"],settingsMenu:[{title:"Account Settings",type:"account",allowed:[]},{title:"Business Setting",type:"merchant",allowed:["prefix","website","address","schedule","information"]}]}},450:function(t,e,n){"use strict";var r=n(448),o=n(475),i=n(478),a=n(457),s=n(472),c=n(483),u=n(481),f=n(453);t.exports=function(t){return new Promise(function(e,n){var l=t.data,d=t.headers;r.isFormData(l)&&delete d["Content-Type"];var p=new XMLHttpRequest;if(t.auth){var h=t.auth.username||"",m=t.auth.password?unescape(encodeURIComponent(t.auth.password)):"";d.Authorization="Basic "+btoa(h+":"+m)}var g=s(t.baseURL,t.url);if(p.open(t.method.toUpperCase(),a(g,t.params,t.paramsSerializer),!0),p.timeout=t.timeout,p.onreadystatechange=function(){if(p&&4===p.readyState&&(0!==p.status||p.responseURL&&0===p.responseURL.indexOf("file:"))){var r="getAllResponseHeaders"in p?c(p.getAllResponseHeaders()):null,i=t.responseType&&"text"!==t.responseType?p.response:p.responseText,a={data:i,status:p.status,statusText:p.statusText,headers:r,config:t,request:p};o(e,n,a),p=null}},p.onabort=function(){p&&(n(f("Request aborted",t,"ECONNABORTED",p)),p=null)},p.onerror=function(){n(f("Network Error",t,null,p)),p=null},p.ontimeout=function(){var e="timeout of "+t.timeout+"ms exceeded";t.timeoutErrorMessage&&(e=t.timeoutErrorMessage),n(f(e,t,"ECONNABORTED",p)),p=null},r.isStandardBrowserEnv()){var v=(t.withCredentials||u(g))&&t.xsrfCookieName?i.read(t.xsrfCookieName):void 0;v&&(d[t.xsrfHeaderName]=v)}if("setRequestHeader"in p&&r.forEach(d,function(t,e){void 0===l&&"content-type"===e.toLowerCase()?delete d[e]:p.setRequestHeader(e,t)}),r.isUndefined(t.withCredentials)||(p.withCredentials=!!t.withCredentials),t.responseType)try{p.responseType=t.responseType}catch(e){if("json"!==t.responseType)throw e}"function"==typeof t.onDownloadProgress&&p.addEventListener("progress",t.onDownloadProgress),"function"==typeof t.onUploadProgress&&p.upload&&p.upload.addEventListener("progress",t.onUploadProgress),t.cancelToken&&t.cancelToken.promise.then(function(t){p&&(p.abort(),n(t),p=null)}),l||(l=null),p.send(l)})}},451:function(t,e,n){"use strict";function r(t){this.message=t}r.prototype.toString=function(){return"Cancel"+(this.message?": "+this.message:"")},r.prototype.__CANCEL__=!0,t.exports=r},452:function(t,e,n){"use strict";t.exports=function(t){return!(!t||!t.__CANCEL__)}},453:function(t,e,n){"use strict";var r=n(474);t.exports=function(t,e,n,o,i){var a=new Error(t);return r(a,e,n,o,i)}},454:function(t,e,n){"use strict";var r=n(448);t.exports=function(t,e){function n(t,e){return r.isPlainObject(t)&&r.isPlainObject(e)?r.merge(t,e):r.isPlainObject(e)?r.merge({},e):r.isArray(e)?e.slice():e}function o(o){r.isUndefined(e[o])?r.isUndefined(t[o])||(i[o]=n(void 0,t[o])):i[o]=n(t[o],e[o])}e=e||{};var i={},a=["url","method","data"],s=["headers","auth","proxy","params"],c=["baseURL","transformRequest","transformResponse","paramsSerializer","timeout","timeoutMessage","withCredentials","adapter","responseType","xsrfCookieName","xsrfHeaderName","onUploadProgress","onDownloadProgress","decompress","maxContentLength","maxBodyLength","maxRedirects","transport","httpAgent","httpsAgent","cancelToken","socketPath","responseEncoding"],u=["validateStatus"];r.forEach(a,function(t){r.isUndefined(e[t])||(i[t]=n(void 0,e[t]))}),r.forEach(s,o),r.forEach(c,function(o){r.isUndefined(e[o])?r.isUndefined(t[o])||(i[o]=n(void 0,t[o])):i[o]=n(void 0,e[o])}),r.forEach(u,function(r){r in e?i[r]=n(t[r],e[r]):r in t&&(i[r]=n(void 0,t[r]))});var f=a.concat(s).concat(c).concat(u),l=Object.keys(t).concat(Object.keys(e)).filter(function(t){return-1===f.indexOf(t)});return r.forEach(l,o),i}},455:function(t,e,n){"use strict";(function(e){function r(t,e){!o.isUndefined(t)&&o.isUndefined(t["Content-Type"])&&(t["Content-Type"]=e)}var o=n(448),i=n(482),a={"Content-Type":"application/x-www-form-urlencoded"},s={adapter:function(){var t;return"undefined"!=typeof XMLHttpRequest?t=n(450):void 0!==e&&"[object process]"===Object.prototype.toString.call(e)&&(t=n(450)),t}(),transformRequest:[function(t,e){return i(e,"Accept"),i(e,"Content-Type"),o.isFormData(t)||o.isArrayBuffer(t)||o.isBuffer(t)||o.isStream(t)||o.isFile(t)||o.isBlob(t)?t:o.isArrayBufferView(t)?t.buffer:o.isURLSearchParams(t)?(r(e,"application/x-www-form-urlencoded;charset=utf-8"),t.toString()):o.isObject(t)?(r(e,"application/json;charset=utf-8"),JSON.stringify(t)):t}],transformResponse:[function(t){if("string"==typeof t)try{t=JSON.parse(t)}catch(t){}return t}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,maxBodyLength:-1,validateStatus:function(t){return t>=200&&t<300}};s.headers={common:{Accept:"application/json, text/plain, */*"}},o.forEach(["delete","get","head"],function(t){s.headers[t]={}}),o.forEach(["post","put","patch"],function(t){s.headers[t]=o.merge(a)}),t.exports=s}).call(e,n(137))},456:function(t,e,n){"use strict";t.exports=function(t,e){return function(){for(var n=new Array(arguments.length),r=0;r<n.length;r++)n[r]=arguments[r];return t.apply(e,n)}}},457:function(t,e,n){"use strict";function r(t){return encodeURIComponent(t).replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}var o=n(448);t.exports=function(t,e,n){if(!e)return t;var i;if(n)i=n(e);else if(o.isURLSearchParams(e))i=e.toString();else{var a=[];o.forEach(e,function(t,e){null!==t&&void 0!==t&&(o.isArray(t)?e+="[]":t=[t],o.forEach(t,function(t){o.isDate(t)?t=t.toISOString():o.isObject(t)&&(t=JSON.stringify(t)),a.push(r(e)+"="+r(t))}))}),i=a.join("&")}if(i){var s=t.indexOf("#");-1!==s&&(t=t.slice(0,s)),t+=(-1===t.indexOf("?")?"?":"&")+i}return t}},459:function(t,e,n){t.exports=n(468)},468:function(t,e,n){"use strict";function r(t){var e=new a(t),n=i(a.prototype.request,e);return o.extend(n,a.prototype,e),o.extend(n,e),n}var o=n(448),i=n(456),a=n(470),s=n(454),c=n(455),u=r(c);u.Axios=a,u.create=function(t){return r(s(u.defaults,t))},u.Cancel=n(451),u.CancelToken=n(469),u.isCancel=n(452),u.all=function(t){return Promise.all(t)},u.spread=n(484),u.isAxiosError=n(480),t.exports=u,t.exports.default=u},469:function(t,e,n){"use strict";function r(t){if("function"!=typeof t)throw new TypeError("executor must be a function.");var e;this.promise=new Promise(function(t){e=t});var n=this;t(function(t){n.reason||(n.reason=new o(t),e(n.reason))})}var o=n(451);r.prototype.throwIfRequested=function(){if(this.reason)throw this.reason},r.source=function(){var t;return{token:new r(function(e){t=e}),cancel:t}},t.exports=r},470:function(t,e,n){"use strict";function r(t){this.defaults=t,this.interceptors={request:new a,response:new a}}var o=n(448),i=n(457),a=n(471),s=n(473),c=n(454);r.prototype.request=function(t){"string"==typeof t?(t=arguments[1]||{},t.url=arguments[0]):t=t||{},t=c(this.defaults,t),t.method?t.method=t.method.toLowerCase():this.defaults.method?t.method=this.defaults.method.toLowerCase():t.method="get";var e=[s,void 0],n=Promise.resolve(t);for(this.interceptors.request.forEach(function(t){e.unshift(t.fulfilled,t.rejected)}),this.interceptors.response.forEach(function(t){e.push(t.fulfilled,t.rejected)});e.length;)n=n.then(e.shift(),e.shift());return n},r.prototype.getUri=function(t){return t=c(this.defaults,t),i(t.url,t.params,t.paramsSerializer).replace(/^\?/,"")},o.forEach(["delete","get","head","options"],function(t){r.prototype[t]=function(e,n){return this.request(c(n||{},{method:t,url:e,data:(n||{}).data}))}}),o.forEach(["post","put","patch"],function(t){r.prototype[t]=function(e,n,r){return this.request(c(r||{},{method:t,url:e,data:n}))}}),t.exports=r},471:function(t,e,n){"use strict";function r(){this.handlers=[]}var o=n(448);r.prototype.use=function(t,e){return this.handlers.push({fulfilled:t,rejected:e}),this.handlers.length-1},r.prototype.eject=function(t){this.handlers[t]&&(this.handlers[t]=null)},r.prototype.forEach=function(t){o.forEach(this.handlers,function(e){null!==e&&t(e)})},t.exports=r},472:function(t,e,n){"use strict";var r=n(479),o=n(477);t.exports=function(t,e){return t&&!r(e)?o(t,e):e}},473:function(t,e,n){"use strict";function r(t){t.cancelToken&&t.cancelToken.throwIfRequested()}var o=n(448),i=n(476),a=n(452),s=n(455);t.exports=function(t){return r(t),t.headers=t.headers||{},t.data=i(t.data,t.headers,t.transformRequest),t.headers=o.merge(t.headers.common||{},t.headers[t.method]||{},t.headers),o.forEach(["delete","get","head","post","put","patch","common"],function(e){delete t.headers[e]}),(t.adapter||s.adapter)(t).then(function(e){return r(t),e.data=i(e.data,e.headers,t.transformResponse),e},function(e){return a(e)||(r(t),e&&e.response&&(e.response.data=i(e.response.data,e.response.headers,t.transformResponse))),Promise.reject(e)})}},474:function(t,e,n){"use strict";t.exports=function(t,e,n,r,o){return t.config=e,n&&(t.code=n),t.request=r,t.response=o,t.isAxiosError=!0,t.toJSON=function(){return{message:this.message,name:this.name,description:this.description,number:this.number,fileName:this.fileName,lineNumber:this.lineNumber,columnNumber:this.columnNumber,stack:this.stack,config:this.config,code:this.code}},t}},475:function(t,e,n){"use strict";var r=n(453);t.exports=function(t,e,n){var o=n.config.validateStatus;n.status&&o&&!o(n.status)?e(r("Request failed with status code "+n.status,n.config,null,n.request,n)):t(n)}},476:function(t,e,n){"use strict";var r=n(448);t.exports=function(t,e,n){return r.forEach(n,function(n){t=n(t,e)}),t}},477:function(t,e,n){"use strict";t.exports=function(t,e){return e?t.replace(/\/+$/,"")+"/"+e.replace(/^\/+/,""):t}},478:function(t,e,n){"use strict";var r=n(448);t.exports=r.isStandardBrowserEnv()?function(){return{write:function(t,e,n,o,i,a){var s=[];s.push(t+"="+encodeURIComponent(e)),r.isNumber(n)&&s.push("expires="+new Date(n).toGMTString()),r.isString(o)&&s.push("path="+o),r.isString(i)&&s.push("domain="+i),!0===a&&s.push("secure"),document.cookie=s.join("; ")},read:function(t){var e=document.cookie.match(new RegExp("(^|;\\s*)("+t+")=([^;]*)"));return e?decodeURIComponent(e[3]):null},remove:function(t){this.write(t,"",Date.now()-864e5)}}}():function(){return{write:function(){},read:function(){return null},remove:function(){}}}()},479:function(t,e,n){"use strict";t.exports=function(t){return/^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(t)}},480:function(t,e,n){"use strict";t.exports=function(t){return"object"==typeof t&&!0===t.isAxiosError}},481:function(t,e,n){"use strict";var r=n(448);t.exports=r.isStandardBrowserEnv()?function(){function t(t){var e=t;return n&&(o.setAttribute("href",e),e=o.href),o.setAttribute("href",e),{href:o.href,protocol:o.protocol?o.protocol.replace(/:$/,""):"",host:o.host,search:o.search?o.search.replace(/^\?/,""):"",hash:o.hash?o.hash.replace(/^#/,""):"",hostname:o.hostname,port:o.port,pathname:"/"===o.pathname.charAt(0)?o.pathname:"/"+o.pathname}}var e,n=/(msie|trident)/i.test(navigator.userAgent),o=document.createElement("a");return e=t(window.location.href),function(n){var o=r.isString(n)?t(n):n;return o.protocol===e.protocol&&o.host===e.host}}():function(){return function(){return!0}}()},482:function(t,e,n){"use strict";var r=n(448);t.exports=function(t,e){r.forEach(t,function(n,r){r!==e&&r.toUpperCase()===e.toUpperCase()&&(t[e]=n,delete t[r])})}},483:function(t,e,n){"use strict";var r=n(448),o=["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"];t.exports=function(t){var e,n,i,a={};return t?(r.forEach(t.split("\n"),function(t){if(i=t.indexOf(":"),e=r.trim(t.substr(0,i)).toLowerCase(),n=r.trim(t.substr(i+1)),e){if(a[e]&&o.indexOf(e)>=0)return;a[e]="set-cookie"===e?(a[e]?a[e]:[]).concat([n]):a[e]?a[e]+", "+n:n}}),a):a}},484:function(t,e,n){"use strict";t.exports=function(t){return function(e){return t.apply(null,e)}}},934:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n(36),o=n(54),i=n(449),a=n(459);n.n(a);e.default={mounted:function(){this.checkIfDoneTutorial()},data:function(){return{user:o.a.user,activeIndex:0,common:i.a}},methods:{redirect:function(t){r.a.push(t)},checkIfDoneTutorial:function(){var t={condition:[{value:this.user.userID,column:"account_id",clause:"="}]};this.APIRequest("tutorial/retrieve",t).then(function(t){t.data.length<=0&&$("#quickTutorialNavigationModal").modal("show")})},previous:function(){this.activeIndex>0&&this.activeIndex--},next:function(){this.activeIndex<this.common.GUIDE.length&&this.activeIndex++},markAsDone:function(){var t={account_id:this.user.userID};this.APIRequest("tutorial/create",t).then(function(t){t.data>0&&$("#quickTutorialNavigationModal").modal("hide")})},close:function(){$("#quickTutorialNavigationModal").modal("hide")}}}},985:function(t,e,n){e=t.exports=n(409)(),e.push([t.i,".guide-row[data-v-037e6e98]{width:100%;float:left;min-height:50px;overflow-y:hidden;text-align:center;margin-bottom:50px;margin-top:50px}.modal-footer[data-v-037e6e98]{display:unset}.bg-primary[data-v-037e6e98]{background-color:#56c596!important}","",{version:3,sources:["C:/xampp/htdocs/gladtithings/src/components/increment/generic/tutorial/Tutorial.vue"],names:[],mappings:"AACA,4BAA4B,WAAW,WAAW,gBAAgB,kBAAkB,kBAAkB,mBAAmB,eAAe,CACvI,AACD,+BAA+B,aAAa,CAC3C,AACD,6BAA6B,kCAAmC,CAC/D",file:"Tutorial.vue",sourcesContent:["\n.guide-row[data-v-037e6e98]{width:100%;float:left;min-height:50px;overflow-y:hidden;text-align:center;margin-bottom:50px;margin-top:50px\n}\n.modal-footer[data-v-037e6e98]{display:unset\n}\n.bg-primary[data-v-037e6e98]{background-color:#56c596 !important\n}"],sourceRoot:""}])}});
//# sourceMappingURL=17.09bf19a1667a95121a63.js.map