(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-4244a488"],{2017:function(t,e,o){"use strict";o("cafe")},"9ed6":function(t,e,o){"use strict";o.r(e);var n=function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"login-container"},[o("el-form",{ref:"loginForm",staticClass:"login-form",attrs:{model:t.loginForm,rules:t.loginRules,autocomplete:"on","label-position":"left"}},[o("div",{staticClass:"title-container"},[o("h3",{staticClass:"title"},[t._v("Login Form")])]),o("el-form-item",{attrs:{prop:"email"}},[o("span",{staticClass:"svg-container"},[o("svg-icon",{attrs:{"icon-class":"user"}})],1),o("el-input",{ref:"email",attrs:{placeholder:"Email",name:"email",type:"email",tabindex:"1",autocomplete:"on"},model:{value:t.loginForm.email,callback:function(e){t.$set(t.loginForm,"email",e)},expression:"loginForm.email"}})],1),o("el-tooltip",{attrs:{content:"Caps lock is On",placement:"right",manual:""},model:{value:t.capsTooltip,callback:function(e){t.capsTooltip=e},expression:"capsTooltip"}},[o("el-form-item",{attrs:{prop:"password"}},[o("span",{staticClass:"svg-container"},[o("svg-icon",{attrs:{"icon-class":"password"}})],1),o("el-input",{key:t.passwordType,ref:"password",attrs:{type:t.passwordType,placeholder:"Password",name:"password",tabindex:"2",autocomplete:"on"},on:{blur:function(e){t.capsTooltip=!1}},nativeOn:{keyup:[function(e){return t.checkCapslock(e)},function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.handleLogin(e)}]},model:{value:t.loginForm.password,callback:function(e){t.$set(t.loginForm,"password",e)},expression:"loginForm.password"}}),o("span",{staticClass:"show-pwd",on:{click:t.showPwd}},[o("svg-icon",{attrs:{"icon-class":"password"===t.passwordType?"eye":"eye-open"}})],1)],1)],1),o("br"),o("el-button",{staticStyle:{width:"100%","margin-bottom":"10px"},attrs:{loading:t.loading,type:"primary"},nativeOn:{click:function(e){return e.preventDefault(),t.handleLogin(e)}}},[t._v("Login")]),o("router-link",{attrs:{to:"/register"}},[o("el-button",{staticStyle:{width:"100%","margin-top":"10px"},attrs:{type:"primary"}},[t._v("Register")])],1)],1)],1)},a=[],s=o("61f7"),i={name:"Login",data:function(){var t=function(t,e,o){Object(s["e"])(e)?o():o(new Error("Please enter a valid email"))},e=function(t,e,o){Object(s["g"])(e)?o():o(new Error("Password must be longer than 6 characters"))};return{loginForm:{email:"",password:""},loginRules:{email:[{required:!0,trigger:"blur",validator:t}],password:[{required:!0,trigger:"blur",validator:e}]},passwordType:"password",capsTooltip:!1,loading:!1,redirect:void 0}},watch:{},created:function(){},mounted:function(){},methods:{checkCapslock:function(t){var e=t.key;this.capsTooltip=e&&1===e.length&&e>="A"&&e<="Z"},showPwd:function(){var t=this;"password"===this.passwordType?this.passwordType="":this.passwordType="password",this.$nextTick((function(){t.$refs.password.focus()}))},handleLogin:function(){var t=this;this.$refs.loginForm.validate((function(e){if(!e)return t.$message.error("Sign in failed"),!1;t.loading=!0,t.$store.dispatch("user/login",t.loginForm).then((function(){t.$router.push("/"),t.loading=!1})).catch((function(){t.loading=!1,t.$message.error("Sign in failed")}))}))}}},r=i,l=(o("2017"),o("a14e"),o("2877")),c=Object(l["a"])(r,n,a,!1,null,"105b2502",null);e["default"]=c.exports},a14e:function(t,e,o){"use strict";o("c050")},c050:function(t,e,o){},cafe:function(t,e,o){}}]);