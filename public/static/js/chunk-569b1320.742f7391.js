(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-569b1320"],{4083:function(t,e,a){"use strict";a("494d")},"494d":function(t,e,a){},"54ba":function(t,e,a){"use strict";a("61d0")},"61d0":function(t,e,a){},df7f:function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{attrs:{id:"container"}},[a("el-row",{attrs:{gutter:32}},[a("el-col",{attrs:{xs:24,sm:24,lg:12}},[a("h1",[t._v(t._s(t.tag.name))])]),a("el-col",{attrs:{xs:24,sm:24,lg:12}})],1),a("br"),a("br"),a("el-row",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],attrs:{gutter:20}},[a("FamilyTree",{attrs:{tag:t.tag,ancestors:t.ancestors,descendants:t.descendants},on:{newBranch:t.newBranch,deleteDescendant:t.deleteDescendant}})],1),a("br"),a("br"),a("el-row",{attrs:{gutter:20}},[a("el-col",{attrs:{xs:24,sm:24,lg:24}},[a("el-button",{staticClass:"updateBtn",attrs:{type:"primary"},on:{click:function(e){return t.updateTag(t.tag.id)}}},[t._v("Update")]),a("el-button",{staticClass:"deleteBtn",attrs:{type:"danger"},on:{click:function(e){return t.deleteTag(t.tag.id)}}},[t._v("Delete")]),a("el-button",{staticClass:"backBtn",attrs:{type:"danger"},on:{click:function(e){return t.$router.go(-1)}}},[t._v("Back")])],1)],1)],1)},s=[],r=a("ebd1"),o=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{attrs:{id:"container"}},[a("el-row",{attrs:{gutter:32}},[a("h3",[t._v("Ancestors")]),a("el-table",{staticStyle:{width:"100%","margin-bottom":"20px"},attrs:{data:t.ancestors,"row-key":"id","default-expand-all":""}},[a("el-table-column",{attrs:{prop:"name",label:"Name"}}),a("el-table-column",{attrs:{prop:"actions",label:"Actions",width:"750",align:"right"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{staticClass:"viewTag",attrs:{type:"primary"},on:{click:function(a){return t.viewTag(e.row.id)}}},[t._v("View")]),a("el-button",{staticClass:"updateTag",attrs:{type:"primary",disabled:"Work"===e.row.name||"Life"===e.row.name},on:{click:function(a){return t.updateTag(e.row.id)}}},[t._v("Update")])]}}])})],1)],1),a("br"),a("br"),a("el-row",{attrs:{gutter:32}},[a("h3",[t._v("Descendants")]),a("el-table",{staticStyle:{width:"100%","margin-bottom":"20px"},attrs:{data:t.descendants,"row-key":"id","default-expand-all":""}},[a("el-table-column",{attrs:{prop:"name",label:"Name"}}),a("el-table-column",{attrs:{prop:"actions",label:"Actions",width:"750",align:"right"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{staticClass:"viewTag",attrs:{type:"primary"},on:{click:function(a){return t.viewTag(e.row.id)}}},[t._v("View")]),a("el-button",{staticClass:"updateTag",attrs:{type:"primary",disabled:"Work"===e.row.name||"Life"===e.row.name},on:{click:function(a){return t.updateTag(e.row.id)}}},[t._v("Update")]),a("el-button",{staticClass:"deleteTag",attrs:{type:"danger",disabled:"Work"===e.row.name||"Life"===e.row.name},on:{click:function(a){return t.deleteTag(e.row.id)}}},[t._v("Delete")])]}}])})],1)],1),a("br"),a("br")],1)},c=[],i={name:"FamilyTree",props:{tag:{type:Object,default:function(){return{}}},ancestors:{type:Array,default:function(){return[]}},descendants:{type:Array,default:function(){return[]}}},data:function(){return{loading:!0,treeProps:{children:"children",label:"name"}}},computed:{},watch:{},created:function(){},methods:{viewTag:function(t){this.$router.push("/tags/view?tagID="+t),this.$emit("newBranch",t)},updateTag:function(t){this.$router.push("/tags/update?tagID="+t)},deleteTag:function(t){this.$emit("deleteDescendant",t)}}},l=i,d=(a("4083"),a("2877")),u=Object(d["a"])(l,o,c,!1,null,"601369d2",null),g=u.exports,p={name:"ViewTag",components:{FamilyTree:g},data:function(){return{loading:!0,tag:{},ancestors:[],descendants:[]}},computed:{},watch:{},created:function(){this.tagID=this.$route.query.tagID,this.getTag()},methods:{getTag:function(){var t=this;Object(r["E"])(this.tagID).then((function(e){console.log(e),t.tag=e.data.descendants,t.familyTree=e.data,t.ancestors=e.data.ancestors,t.descendants=e.data.descendants.children,t.loading=!1})).catch((function(e){console.log(e),t.loading=!1}))},deleteTag:function(t){var e=this;this.loading=!0,Object(r["m"])(t).then((function(t){e.$message.success("Tag and Descendants Deleted Successfully"),console.log(t)})).catch((function(t){e.$message.danger("Error Deleting Tag"),console.log(t.response)})),this.$router.go(-1)},deleteDescendant:function(t){var e=this;this.loading=!0,Object(r["m"])(t).then((function(t){e.$message.success("Tag and Descendants Deleted Successfully"),console.log(t)})).catch((function(t){e.$message.danger("Error Deleting Tag"),console.log(t.response)})),this.getTag()},newBranch:function(t){this.tagID=t,this.getTag()},updateTag:function(t){this.$router.push("/tags/update?tagID="+t)}}},f=p,h=(a("54ba"),Object(d["a"])(f,n,s,!1,null,"4f7c056f",null));e["default"]=h.exports}}]);