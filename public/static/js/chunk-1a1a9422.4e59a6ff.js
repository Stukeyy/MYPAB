(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-1a1a9422"],{"06af":function(e,t,r){},"0bd4":function(e,t,r){"use strict";r("5fb4")},"16dc":function(e,t,r){"use strict";r("c2f5")},"335b":function(e,t,r){},"3f00":function(e,t,r){},4565:function(e,t,r){"use strict";r("6bec")},4683:function(e,t,r){},"540a":function(e,t,r){"use strict";r("e9f4")},"5fb4":function(e,t,r){},"63f5":function(e,t,r){"use strict";r("cdc8")},6658:function(e,t,r){"use strict";r("7878")},"6bec":function(e,t,r){},7878:function(e,t,r){},"8ad5":function(e,t,r){"use strict";r("335b")},a727:function(e,t,r){},c1f5:function(e,t,r){"use strict";r("4683")},c2f5:function(e,t,r){},c453:function(e,t,r){"use strict";r("a727")},c64a:function(e,t,r){"use strict";r("3f00")},c67e:function(e,t,r){"use strict";r("eab3")},cdc8:function(e,t,r){},cf09:function(e,t,r){"use strict";r("06af")},d5c2:function(e,t,r){"use strict";r.r(t);var o=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("el-row",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"register-container"},[r("div",{directives:[{name:"show",rawName:"v-show",value:e.personalForm,expression:"personalForm"}]},[r("PersonalForm",{on:{personalComplete:e.addPersonal,previousForm:e.previousForm}})],1),r("div",{directives:[{name:"show",rawName:"v-show",value:e.educationForm,expression:"educationForm"}]},[r("EducationForm",{on:{educationComplete:e.addEducation,previousForm:e.previousForm}})],1),r("div",{directives:[{name:"show",rawName:"v-show",value:e.employmentForm,expression:"employmentForm"}]},[r("EmploymentForm",{on:{employmentComplete:e.addEmployment,previousForm:e.previousForm}})],1),r("div",{directives:[{name:"show",rawName:"v-show",value:e.physicalForm,expression:"physicalForm"}]},[r("PhysicalForm",{on:{physicalComplete:e.addPhysical,previousForm:e.previousForm}})],1),r("div",{directives:[{name:"show",rawName:"v-show",value:e.socialForm,expression:"socialForm"}]},[r("SocialForm",{on:{socialComplete:e.addSocial,previousForm:e.previousForm}})],1)])},a=[],i=r("ebd1"),s=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"register-container"},[r("el-form",{ref:"registerForm",staticClass:"register-form",attrs:{model:e.registerForm,rules:e.registerRules,autocomplete:"on","label-position":"left"}},[r("div",{staticClass:"title-container"},[r("h3",{staticClass:"title"},[e._v("Personal")])]),r("el-form-item",{attrs:{prop:"firstname"}},[r("span",{staticClass:"svg-container"},[r("svg-icon",{attrs:{"icon-class":"user"}})],1),r("el-input",{ref:"firstname",attrs:{placeholder:"firstname",name:"firstname",type:"firstname",tabindex:"1",autocomplete:"on"},model:{value:e.registerForm.firstname,callback:function(t){e.$set(e.registerForm,"firstname",t)},expression:"registerForm.firstname"}})],1),r("el-form-item",{attrs:{prop:"lastname"}},[r("span",{staticClass:"svg-container"},[r("svg-icon",{attrs:{"icon-class":"user"}})],1),r("el-input",{ref:"lastname",attrs:{placeholder:"lastname",name:"lastname",type:"lastname",tabindex:"2",autocomplete:"on"},model:{value:e.registerForm.lastname,callback:function(t){e.$set(e.registerForm,"lastname",t)},expression:"registerForm.lastname"}})],1),r("el-form-item",{attrs:{prop:"age"}},[r("span",{staticClass:"svg-container"},[r("svg-icon",{attrs:{"icon-class":"user"}})],1),r("el-input",{ref:"age",attrs:{placeholder:"age",name:"age",type:"age",tabindex:"3",autocomplete:"on"},model:{value:e.registerForm.age,callback:function(t){e.$set(e.registerForm,"age",t)},expression:"registerForm.age"}})],1),r("el-form-item",{attrs:{prop:"gender"}},[r("span",{staticClass:"svg-container"},[r("svg-icon",{attrs:{"icon-class":"user"}})],1),r("el-select",{staticClass:"genderSelect",attrs:{placeholder:"gender",tabindex:"4",filterable:"",remote:""},model:{value:e.registerForm.gender,callback:function(t){e.$set(e.registerForm,"gender",t)},expression:"registerForm.gender"}},[r("el-option",{attrs:{label:"Male",value:"male"}}),r("el-option",{attrs:{label:"Female",value:"female"}})],1)],1),r("el-form-item",{attrs:{prop:"location"}},[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-discover"})]),r("el-select",{staticClass:"locationSelect",attrs:{placeholder:"location",tabindex:"5",filterable:"",remote:""},model:{value:e.registerForm.location,callback:function(t){e.$set(e.registerForm,"location",t)},expression:"registerForm.location"}},[r("el-option",{attrs:{label:"Antrim",value:"antrim"}}),r("el-option",{attrs:{label:"Armagh",value:"armagh"}}),r("el-option",{attrs:{label:"Down",value:"down"}}),r("el-option",{attrs:{label:"Fermanagh",value:"fermanagh"}}),r("el-option",{attrs:{label:"Londonderry",value:"londonderry"}}),r("el-option",{attrs:{label:"Tyrone",value:"tyrone"}})],1)],1),r("el-form-item",{attrs:{prop:"email"}},[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-message"})]),r("el-input",{ref:"email",attrs:{placeholder:"Email",name:"email",type:"email",tabindex:"6",autocomplete:"on"},model:{value:e.registerForm.email,callback:function(t){e.$set(e.registerForm,"email",t)},expression:"registerForm.email"}})],1),r("el-tooltip",{attrs:{content:"Caps lock is On",placement:"right",manual:""},model:{value:e.capsTooltip,callback:function(t){e.capsTooltip=t},expression:"capsTooltip"}},[r("el-form-item",{attrs:{prop:"password"}},[r("span",{staticClass:"svg-container"},[r("svg-icon",{attrs:{"icon-class":"password"}})],1),r("el-input",{key:e.passwordType,ref:"password",attrs:{type:e.passwordType,placeholder:"Password",name:"password",tabindex:"7",autocomplete:"on"},on:{blur:function(t){e.capsTooltip=!1}},nativeOn:{keyup:[function(t){return e.checkCapslock(t)},function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter")?null:e.validate(t)}]},model:{value:e.registerForm.password,callback:function(t){e.$set(e.registerForm,"password",t)},expression:"registerForm.password"}}),r("span",{staticClass:"show-pwd",on:{click:e.showPwd}},[r("svg-icon",{attrs:{"icon-class":"password"===e.passwordType?"eye":"eye-open"}})],1)],1)],1),r("br"),r("el-button",{staticClass:"nextForm",attrs:{loading:e.loading,type:"primary"},nativeOn:{click:function(t){return t.preventDefault(),e.validate(t)}}},[e._v("Next")]),r("el-button",{staticClass:"previousForm",attrs:{type:"primary"},on:{click:e.previousForm}},[e._v(" Previous ")])],1)],1)},l=[],n=r("61f7"),c={name:"Personal",data:function(){var e=function(e,t,r){Object(n["f"])(t)?r():r(new Error("Please enter a valid name"))},t=function(e,t,r){Object(n["d"])(t)?r():r(new Error("Please enter a valid age"))},r=function(e,t,r){console.log(t),Object(n["e"])(t)?Object(i["L"])(t).then((function(e){r()})).catch((function(e){r(new Error("Email is already registered")),console.log(e.response)})):r(new Error("Please enter a valid email"))},o=function(e,t,r){Object(n["g"])(t)?r():r(new Error("Please enter a valid password"))};return{registerForm:{firstname:"",lastname:"",age:"",gender:"",location:"",email:"",password:""},registerRules:{firstname:[{required:!0,trigger:["blur","change"],validator:e}],lastname:[{required:!0,trigger:["blur","change"],validator:e}],age:[{required:!0,trigger:["blur","change"],validator:t}],gender:[{required:!0,trigger:["blur","change"]}],location:[{required:!0,trigger:["blur","change"]}],email:[{required:!0,trigger:["blur","change"],validator:r}],password:[{required:!0,trigger:["blur","change"],validator:o}]},passwordType:"password",capsTooltip:!1,loading:!1}},computed:{},watch:{},created:function(){},methods:{checkCapslock:function(e){var t=e.key;this.capsTooltip=t&&1===t.length&&t>="A"&&t<="Z"},showPwd:function(){var e=this;"password"===this.passwordType?this.passwordType="":this.passwordType="password",this.$nextTick((function(){e.$refs.password.focus()}))},validate:function(){var e=this;this.$refs.registerForm.validate((function(t){if(!t)return e.$message.error("Please Complete Form"),!1;e.loading=!0,e.registerForm.age=parseInt(e.registerForm.age),e.$emit("personalComplete",e.registerForm),e.loading=!1}))},previousForm:function(){this.$emit("previousForm","login")}}},u=c,m=(r("cf09"),r("8ad5"),r("2877")),p=Object(m["a"])(u,s,l,!1,null,"b8e9fc3c",null),d=p.exports,v=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"register-container"},[r("el-form",{ref:"registerForm",staticClass:"register-form",attrs:{model:e.registerForm,rules:e.registerRules,autocomplete:"on","label-position":"left"}},[r("div",{staticClass:"title-container"},[r("h3",{staticClass:"title"},[e._v("Education")])]),r("el-form-item",{attrs:{prop:"level"}},[r("span",{staticClass:"svg-container"},[r("svg-icon",{attrs:{"icon-class":"user"}})],1),r("el-select",{staticClass:"levelSelect",attrs:{placeholder:"level",tabindex:"1",filterable:"",remote:""},model:{value:e.registerForm.level,callback:function(t){e.$set(e.registerForm,"level",t)},expression:"registerForm.level"}},[r("el-option",{attrs:{label:"Undergraduate",value:"undergraduate"}}),r("el-option",{attrs:{label:"Postgraduate",value:"postgraduate"}}),r("el-option",{attrs:{label:"Graduate",value:"graduate"}})],1)],1),r("el-form-item",{attrs:{prop:"institution"}},[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-office-building"})]),r("el-select",{staticClass:"institutionSelect",attrs:{placeholder:"institution",tabindex:"2",filterable:"",remote:""},model:{value:e.registerForm.institution,callback:function(t){e.$set(e.registerForm,"institution",t)},expression:"registerForm.institution"}},[r("el-option",{attrs:{label:"The Open University",value:"the open university"}}),r("el-option",{attrs:{label:"Queens University Belfast",value:"queens university belfast"}}),r("el-option",{attrs:{label:"Ulster University",value:"ulster university"}}),r("el-option",{attrs:{label:"St Mary's University College",value:"st mary's university college"}}),r("el-option",{attrs:{label:"Stranmillis University College",value:"stranmillis university college"}}),r("el-option",{attrs:{label:"Belfast Metropolitian College",value:"belfast metropolitian college"}}),r("el-option",{attrs:{label:"Northern Regional College",value:"northern regional college"}}),r("el-option",{attrs:{label:"Southern Regional College",value:"Southern regional college"}}),r("el-option",{attrs:{label:"South Eastern Regional College",value:"south eastern regional college"}}),r("el-option",{attrs:{label:"North West Regional College",value:"north west regional college"}}),r("el-option",{attrs:{label:"South West College",value:"south west college"}})],1)],1),r("el-form-item",{attrs:{prop:"subject"}},[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-collection-tag"})]),r("el-select",{staticClass:"subjectSelect",attrs:{placeholder:"subject",tabindex:"3",filterable:"",remote:""},model:{value:e.registerForm.subject,callback:function(t){e.$set(e.registerForm,"subject",t)},expression:"registerForm.subject"}},[r("el-option",{attrs:{label:"Accounting",value:"accounting"}}),r("el-option",{attrs:{label:"Architecture, Construction and Civil Engineering",value:"architecture, construction and civil engineering"}}),r("el-option",{attrs:{label:"Art and Design Including Digital",value:"art and design including digital"}}),r("el-option",{attrs:{label:"Biology and Biomedical Sciences",value:"biology and biomedical sciences"}}),r("el-option",{attrs:{label:"Business, Entrepreneurship and Management",value:"business, entrepreneurship and management"}}),r("el-option",{attrs:{label:"Communication and Counselling Studies",value:"communication and counselling studies"}}),r("el-option",{attrs:{label:"Computing",value:"computing"}}),r("el-option",{attrs:{label:"Culinary, Food and Food Safety",value:"culinary, food and food safety"}}),r("el-option",{attrs:{label:"Education",value:"education"}}),r("el-option",{attrs:{label:"Energy and Surveying",value:"energy and surveying"}}),r("el-option",{attrs:{label:"Engineering",value:"engineering"}}),r("el-option",{attrs:{label:"English",value:"english"}}),r("el-option",{attrs:{label:"Finance, Investment and Economics",value:"finance, investment and economics"}}),r("el-option",{attrs:{label:"Geography, Environmental and Marine Sciences",value:"geography, environmental and marine sciences"}}),r("el-option",{attrs:{label:"Healthcare",value:"healthcare"}}),r("el-option",{attrs:{label:"History",value:"history"}}),r("el-option",{attrs:{label:"Hospitality, Travel and Tourism",value:"hospitality, travel and tourism"}}),r("el-option",{attrs:{label:"Interactive Media, Design & Computing",value:"interactive media, design & computing"}}),r("el-option",{attrs:{label:"Irish and Irish Studies",value:"irish and irish studies"}}),r("el-option",{attrs:{label:"Journalism",value:"journalism"}}),r("el-option",{attrs:{label:"Language and Linguistics",value:"language and linguistics"}}),r("el-option",{attrs:{label:"Law, Criminology and Criminal Justice",value:"law, criminology and criminal justice"}}),r("el-option",{attrs:{label:"Marketing, Communication, Pr and Advertising",value:"marketing, communication, pr and advertising"}}),r("el-option",{attrs:{label:"Music",value:"music"}}),r("el-option",{attrs:{label:"Nursing",value:"nursing"}}),r("el-option",{attrs:{label:"Nutrition",value:"nutrition"}}),r("el-option",{attrs:{label:"Optometry",value:"optometry"}}),r("el-option",{attrs:{label:"Pharmacy",value:"pharmacy"}}),r("el-option",{attrs:{label:"Planning, Development and Real Estate",value:"planning, development and real estate"}}),r("el-option",{attrs:{label:"Politics",value:"politics"}}),r("el-option",{attrs:{label:"Psychology",value:"psychology"}}),r("el-option",{attrs:{label:"Regeneration and Environmental Health",value:"regeneration and environmental health"}}),r("el-option",{attrs:{label:"Screen, Film & Perfoming Arts",value:"screen, film & perfoming arts"}}),r("el-option",{attrs:{label:"Social Work and Community Youth Work",value:"social work and community youth work"}}),r("el-option",{attrs:{label:"Social, Health Policy and Community",value:"social, health policy and community"}}),r("el-option",{attrs:{label:"Sociology",value:"sociology"}}),r("el-option",{attrs:{label:"Sport, Coaching and Management",value:"sport, coaching and management"}})],1)],1),e._l(e.modules,(function(t){return r("div",{key:t.key},[r("el-form-item",[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-notebook-2"})]),r("el-input",{attrs:{placeholder:"module (optional)"},model:{value:t.value,callback:function(r){e.$set(t,"value",r)},expression:"topic.value"}}),r("span",{staticClass:"remove-module",on:{click:function(r){return e.removeModule(t)}}},[r("i",{staticClass:"el-icon-close"})])],1),r("div",{directives:[{name:"show",rawName:"v-show",value:t.error,expression:"topic.error"}]},[r("p",{staticClass:"moduleError"},[e._v("Please enter a valid module")])])],1)})),r("br"),r("el-button",{staticClass:"addModule",attrs:{type:"primary"},on:{click:function(t){return e.checkModules("add")}}},[e._v("Add Module")]),r("el-button",{staticClass:"nextForm",attrs:{loading:e.loading,type:"primary"},nativeOn:{click:function(t){return t.preventDefault(),e.validate(t)}}},[e._v("Next")]),r("el-button",{staticClass:"previousForm",attrs:{type:"primary"},on:{click:e.previousForm}},[e._v(" Previous ")])],2)],1)},g=[],f=(r("d3b7"),r("159b"),r("a434"),{name:"Education",data:function(){return{registerForm:{level:"",institution:"",subject:"",modules:[]},registerRules:{level:[{required:!0,trigger:["blur","change"]}],institution:[{required:!0,trigger:["blur","change"]}],subject:[{required:!0,trigger:["blur","change"]}]},modules:[{key:0,value:"",error:!1}],loading:!1}},computed:{},watch:{},created:function(){},methods:{checkModules:function(e){if("validate"===e)return!0;"add"===e&&(this.modules.forEach((function(e){""===e.value?e.error=!0:e.error=!1})),this.modules.some((function(e){return!0===e.error}))||this.modules.push({key:Date.now(),value:"",error:!1}))},removeModule:function(e){var t=this.modules.indexOf(e);this.modules.splice(t,1)},validate:function(){var e=this,t=this.checkModules("validate");this.$refs.registerForm.validate((function(r){if(!r||!t)return e.$message.error("Registration failed"),!1;e.loading=!0,e.registerForm.modules=[],e.modules.forEach((function(t){""!==t.value?e.registerForm.modules.push(t.value):""===t.value&&e.modules.indexOf(t)>1&&e.removeModule(t),t.error=!1})),e.$emit("educationComplete",e.registerForm),e.loading=!1}))},previousForm:function(){this.$emit("previousForm","personal")}}}),h=f,b=(r("c64a"),r("540a"),Object(m["a"])(h,v,g,!1,null,"c9e54c76",null)),y=b.exports,F=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"register-container"},[r("el-form",{ref:"registerForm",staticClass:"register-form",attrs:{model:e.registerForm,rules:e.registerRules,autocomplete:"on","label-position":"left"}},[r("div",{staticClass:"title-container"},[r("h3",{staticClass:"title"},[e._v("Employment")])]),r("el-form-item",{attrs:{prop:"employment"}},[r("span",{staticClass:"svg-container"},[r("svg-icon",{attrs:{"icon-class":"user"}})],1),r("el-select",{staticClass:"employmentSelect",attrs:{placeholder:"employment",tabindex:"1",filterable:"",remote:""},model:{value:e.registerForm.employment,callback:function(t){e.$set(e.registerForm,"employment",t)},expression:"registerForm.employment"}},[r("el-option",{attrs:{label:"Employed",value:!0}}),r("el-option",{attrs:{label:"Seeking Employment",value:!1}})],1)],1),r("el-form-item",{attrs:{prop:"company"}},[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-office-building"})]),r("el-input",{ref:"company",class:{"disabled-input":!e.employed},attrs:{placeholder:"company",name:"company",type:"company",tabindex:"2",autocomplete:"on",readonly:!e.employed},model:{value:e.registerForm.company,callback:function(t){e.$set(e.registerForm,"company",t)},expression:"registerForm.company"}})],1),e._l(e.projects,(function(t){return r("div",{key:t.key},[r("el-form-item",[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-notebook-2"})]),r("el-input",{class:{"disabled-input":!e.employed},attrs:{placeholder:"project (optional)",readonly:!e.employed},model:{value:t.value,callback:function(r){e.$set(t,"value",r)},expression:"project.value"}}),r("span",{staticClass:"remove-project",on:{click:function(r){return e.removeProject(t)}}},[r("i",{staticClass:"el-icon-close"})])],1),r("div",{directives:[{name:"show",rawName:"v-show",value:t.error,expression:"project.error"}]},[r("p",{staticClass:"projectError"},[e._v("Please enter a valid project")])])],1)})),r("br"),r("el-button",{staticClass:"addModule",attrs:{type:"primary",disabled:!e.employed},on:{click:function(t){return e.checkProjects("add")}}},[e._v("Add Project")]),r("el-button",{staticClass:"nextForm",attrs:{loading:e.loading,type:"primary"},nativeOn:{click:function(t){return t.preventDefault(),e.validate(t)}}},[e._v("Next")]),r("el-button",{staticClass:"previousForm",attrs:{type:"primary"},on:{click:e.previousForm}},[e._v(" Previous ")])],2)],1)},C=[],k={name:"Employment",data:function(){return{registerForm:{employment:"",company:"",projects:[]},employed:!0,projects:[{key:Date.now(),value:"",error:!1}],loading:!1}},computed:{registerRules:function(){return{employment:[{required:!0,trigger:["blur","change"]}],company:[{required:this.employed,message:"Please enter a valid company",trigger:["blur","change"]}]}}},watch:{"registerForm.employment":function(e){this.employed=e,this.employed||(this.registerForm.company="",this.registerForm.projects=[],this.projects.forEach((function(e){e.error=!1})),this.projects=[{key:0,value:"",error:!1}])}},created:function(){},methods:{checkProjects:function(e){if("validate"===e)return!0;"add"===e&&(this.projects.forEach((function(e){""===e.value?e.error=!0:e.error=!1})),this.projects.some((function(e){return!0===e.error}))||this.projects.push({key:Date.now(),value:"",error:!1}))},removeProject:function(e){var t=this.projects.indexOf(e);this.projects.splice(t,1)},validate:function(){var e=this,t=!this.employed||this.checkProjects("validate");this.$refs.registerForm.validate((function(r){if(!r||!t)return e.$message.error("Registration failed"),!1;e.loading=!0,e.registerForm.projects=[],e.projects.forEach((function(t){""!==t.value?e.registerForm.projects.push(t.value):""===t.value&&e.projects.indexOf(t)>1&&e.removeProject(t),t.error=!1})),e.$emit("employmentComplete",e.registerForm),e.loading=!1}))},previousForm:function(){this.$emit("previousForm","education")}}},w=k,x=(r("6658"),r("c453"),Object(m["a"])(w,F,C,!1,null,"d0a3ae5c",null)),E=x.exports,j=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"register-container"},[r("el-form",{ref:"registerForm",staticClass:"register-form",attrs:{model:e.registerForm,rules:e.registerRules,autocomplete:"on","label-position":"left"}},[r("div",{staticClass:"title-container"},[r("h3",{staticClass:"title"},[e._v("Physical")])]),e._l(e.clubs,(function(t){return r("div",{key:t.key},[r("el-form-item",[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-soccer"})]),r("el-input",{attrs:{placeholder:"club (optional)"},model:{value:t.value,callback:function(r){e.$set(t,"value",r)},expression:"club.value"}}),r("span",{staticClass:"remove-club",on:{click:function(r){return e.removeClub(t)}}},[r("i",{staticClass:"el-icon-close"})])],1),r("div",{directives:[{name:"show",rawName:"v-show",value:t.error,expression:"club.error"}]},[r("p",{staticClass:"clubError"},[e._v("Please enter a valid club")])])],1)})),r("br"),r("el-button",{staticClass:"addClub",attrs:{type:"primary"},on:{click:function(t){return e.checkClubs("add")}}},[e._v("Add Club")]),r("el-button",{staticClass:"nextForm",attrs:{loading:e.loading,type:"primary"},nativeOn:{click:function(t){return t.preventDefault(),e.validate(t)}}},[e._v("Next")]),r("el-button",{staticClass:"previousForm",attrs:{type:"primary"},on:{click:e.previousForm}},[e._v(" Previous ")])],2)],1)},$=[],P={name:"Physical",data:function(){return{registerForm:{clubs:[]},registerRules:{},clubs:[{key:0,value:"",error:!1},{key:1,value:"",error:!1},{key:2,value:"",error:!1}],loading:!1}},computed:{},watch:{},created:function(){},methods:{checkClubs:function(e){if("validate"===e)return!0;"add"===e&&(this.clubs.forEach((function(e){""===e.value?e.error=!0:e.error=!1})),this.clubs.some((function(e){return!0===e.error}))||this.clubs.push({key:Date.now(),value:"",error:!1}))},removeClub:function(e){var t=this.clubs.indexOf(e);t>2?this.clubs.splice(t,1):(e.value="",e.error=!1)},validate:function(){var e=this,t=this.checkClubs("validate");this.$refs.registerForm.validate((function(r){if(!r||!t)return e.$message.error("Registration failed"),!1;e.loading=!0,e.registerForm.clubs=[],e.clubs.forEach((function(t){""!==t.value?e.registerForm.clubs.push(t.value):""===t.value&&e.clubs.indexOf(t)>2&&e.removeClub(t),t.error=!1})),e.$emit("physicalComplete",e.registerForm),e.loading=!1}))},previousForm:function(){this.$emit("previousForm","employment")}}},_=P,S=(r("c1f5"),r("16dc"),Object(m["a"])(_,j,$,!1,null,"d0b718f0",null)),O=S.exports,R=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"register-container"},[r("el-form",{ref:"registerForm",staticClass:"register-form",attrs:{model:e.registerForm,rules:e.registerRules,autocomplete:"on","label-position":"left"}},[r("div",{staticClass:"title-container"},[r("h3",{staticClass:"title"},[e._v("Social")])]),e._l(e.clubs,(function(t){return r("div",{key:t.key},[r("el-form-item",[r("span",{staticClass:"svg-container"},[r("i",{staticClass:"el-icon-chat-round"})]),r("el-input",{attrs:{placeholder:"club (optional)"},model:{value:t.value,callback:function(r){e.$set(t,"value",r)},expression:"club.value"}}),r("span",{staticClass:"remove-club",on:{click:function(r){return e.removeClub(t)}}},[r("i",{staticClass:"el-icon-close"})])],1),r("div",{directives:[{name:"show",rawName:"v-show",value:t.error,expression:"club.error"}]},[r("p",{staticClass:"clubError"},[e._v("Please enter a valid club")])])],1)})),r("br"),r("el-button",{staticClass:"addClub",attrs:{type:"primary"},on:{click:function(t){return e.checkClubs("add")}}},[e._v("Add Club")]),r("el-button",{staticClass:"nextForm",attrs:{loading:e.loading,type:"primary"},nativeOn:{click:function(t){return t.preventDefault(),e.validate(t)}}},[e._v("Next")]),r("el-button",{staticClass:"previousForm",attrs:{type:"primary"},on:{click:e.previousForm}},[e._v(" Previous ")])],2)],1)},N=[],M={name:"Social",data:function(){return{registerForm:{clubs:[]},registerRules:{},clubs:[{key:0,value:"",error:!1},{key:1,value:"",error:!1},{key:2,value:"",error:!1}],loading:!1}},computed:{},watch:{},created:function(){},methods:{checkClubs:function(e){if("validate"===e)return!0;"add"===e&&(this.clubs.forEach((function(e){""===e.value?e.error=!0:e.error=!1})),this.clubs.some((function(e){return!0===e.error}))||this.clubs.push({key:Date.now(),value:"",error:!1}))},removeClub:function(e){var t=this.clubs.indexOf(e);t>2?this.clubs.splice(t,1):(e.value="",e.error=!1)},validate:function(){var e=this,t=this.checkClubs("validate");this.$refs.registerForm.validate((function(r){if(!r||!t)return e.$message.error("Registration failed"),!1;e.loading=!0,e.registerForm.clubs=[],e.clubs.forEach((function(t){""!==t.value?e.registerForm.clubs.push(t.value):""===t.value&&e.clubs.indexOf(t)>2&&e.removeClub(t),t.error=!1})),e.$emit("socialComplete",e.registerForm),e.loading=!1}))},previousForm:function(){this.$emit("previousForm","physical")}}},T=M,D=(r("63f5"),r("0bd4"),Object(m["a"])(T,R,N,!1,null,"7e6c0ad2",null)),q=D.exports,A={name:"Register",components:{PersonalForm:d,EducationForm:y,EmploymentForm:E,PhysicalForm:O,SocialForm:q},data:function(){return{loading:!0,personalForm:!0,educationForm:!1,employmentForm:!1,physicalForm:!1,socialForm:!1,registerForm:{personalForm:"",educationForm:"",employmentForm:"",physicalForm:"",socialForm:""}}},computed:{},watch:{},created:function(){this.loading=!1},methods:{addPersonal:function(e){this.registerForm.personalForm=e,this.personalForm=!1,this.educationForm=!0},addEducation:function(e){this.registerForm.educationForm=e,this.educationForm=!1,this.employmentForm=!0},addEmployment:function(e){this.registerForm.employmentForm=e,this.employmentForm=!1,this.physicalForm=!0},addPhysical:function(e){this.registerForm.physicalForm=e,this.physicalForm=!1,this.socialForm=!0},addSocial:function(e){this.registerForm.socialForm=e,this.socialForm=!1,this.register()},previousForm:function(e){switch(e){case"login":this.$router.go(-1);break;case"personal":this.personalForm=!0,this.educationForm=!1;break;case"education":this.educationForm=!0,this.employmentForm=!1;break;case"employment":this.employmentForm=!0,this.physicalForm=!1;break;case"physical":this.physicalForm=!0,this.socialForm=!1;break}},register:function(){var e=this;this.loading=!0,Object(i["K"])(this.registerForm).then((function(t){console.log(t),e.$store.dispatch("user/register",t.data.token).then((function(t){e.$message.success("Registration Successfull"),e.$router.push("/")}))})).catch((function(t){e.$message.error("Registration Error"),console.log(t.response),e.personalForm=!0,e.loading=!1}))}}},U=A,I=(r("4565"),r("c67e"),Object(m["a"])(U,o,a,!1,null,"e88e85c2",null));t["default"]=I.exports},e9f4:function(e,t,r){},eab3:function(e,t,r){}}]);