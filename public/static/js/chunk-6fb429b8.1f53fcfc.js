(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-6fb429b8"],{1251:function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{attrs:{id:"container"}},[n("el-row",{attrs:{gutter:32}},[n("el-col",{attrs:{xs:24,sm:24,lg:12}},[n("h1",[t._v("Commitments")])]),n("el-col",{attrs:{xs:24,sm:24,lg:12}},[n("el-button",{staticClass:"addBtn",attrs:{type:"success"},on:{click:function(e){return t.addCommitment()}}},[t._v("Add")])],1)],1),n("br"),n("br"),n("el-row",{attrs:{gutter:20}},[n("el-col",{attrs:{xs:24,sm:24,md:24,lg:24,xl:24}},[n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingCommitments,expression:"loadingCommitments"}],ref:"commitments",staticStyle:{width:"100%"},attrs:{data:t.paginatedCommitments}},[n("el-table-column",{attrs:{prop:"id",label:"ID",width:"50"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.id)+" ")]}}])}),n("el-table-column",{attrs:{prop:"name",label:"name",width:"150"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.name)+" ")]}}])}),n("el-table-column",{attrs:{prop:"tag",label:"Tag"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.tag)+" ")]}}])}),n("el-table-column",{attrs:{prop:"occurance",label:"Occurance"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.occurance)+" ")]}}])}),n("el-table-column",{attrs:{prop:"day",label:"Day"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(null===e.row.day?"daily":e.row.day)+" ")]}}])}),n("el-table-column",{attrs:{prop:"start_time",label:"start_time"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.all_day?"All":e.row.start_time)+" ")]}}])}),n("el-table-column",{attrs:{prop:"end_time",label:"end_time"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.all_day?"Day":e.row.end_time)+" ")]}}])}),n("el-table-column",{attrs:{prop:"start_date",label:"start_date"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.start_date)+" ")]}}])}),n("el-table-column",{attrs:{prop:"end_date",label:"end_date"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.end_date)+" ")]}}])}),n("el-table-column",{attrs:{prop:"actions",label:"Actions",width:"250"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("el-button",{attrs:{type:"primary"},on:{click:function(n){return t.updateCommitment(e.row)}}},[t._v("Update")]),n("el-button",{attrs:{type:"danger"},on:{click:function(n){return t.deleteCommitment(e.row.id)}}},[t._v("Delete")])]}}])})],1)],1)],1),n("br"),n("br"),n("el-pagination",{attrs:{background:"","page-size":t.pagination.commitmentsPerPage,layout:"prev, pager, next",total:t.pagination.totalCommitments,"current-page":t.pagination.currentPage},on:{"current-change":t.newPage}})],1)},o=[],l=n("ebd1"),i={name:"Commitments",data:function(){return{loadingCommitments:!0,paginatedCommitments:[],pagination:{}}},computed:{},watch:{},created:function(){this.getCommitments()},methods:{getCommitments:function(){var t=this;Object(l["s"])().then((function(e){console.log(e),t.paginatedCommitments=e.data.data,t.pagination=e.data.pagination,t.loadingCommitments=!1})).catch((function(e){console.log(e),t.loadingCommitments=!1}))},deleteCommitment:function(t){var e=this;this.loadingCommitments=!0,Object(l["k"])(t).then((function(t){e.$message.success("Commitment and Events Deleted Successfully")})).catch((function(t){e.$message.danger("Error Deleting Commitment"),console.log(t.response)})),this.getCommitments()},addCommitment:function(){this.$router.push("/commitments/add")},updateCommitment:function(t){this.$router.push("/commitments/update?commitmentID="+t.id)},newPage:function(t){var e=this;console.log(t);var n=this.pagination.pageUrls[t-1];Object(l["A"])(n).then((function(t){console.log(t),e.paginatedCommitments=t.data.data,e.pagination=t.data.pagination,e.loadingCommitments=!1})).catch((function(t){console.log(t),e.loadingCommitments=!1}))}}},s=i,r=(n("253c"),n("2877")),m=Object(r["a"])(s,a,o,!1,null,"ba5328d6",null);e["default"]=m.exports},"253c":function(t,e,n){"use strict";n("814f")},"814f":function(t,e,n){}}]);