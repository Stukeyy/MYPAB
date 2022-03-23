(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-5b5e8226"],{"1a9a":function(t,e,s){"use strict";s("224b")},"224b":function(t,e,s){},3568:function(t,e,s){"use strict";s("dcd6")},9406:function(t,e,s){"use strict";s.r(e);var i=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"dashboardContainer"},[s("el-row",{attrs:{gutter:32}},[s("el-col",{attrs:{xs:24,sm:24,lg:24}},[s("h1",{staticClass:"dashboardTitle"},[t._v("NEW TITLE")])])],1),s("el-row",{attrs:{gutter:32}},[s("el-col",{attrs:{xs:24,sm:24,lg:12}},[s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.eventListLoading,expression:"eventListLoading"}],staticClass:"list-wrapper"},[s("FullCalendar",{staticClass:"fullCalendarList",attrs:{options:t.calendarOptions}})],1)]),s("el-col",{attrs:{xs:24,sm:24,lg:12}},[s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.taskListLoading,expression:"taskListLoading"}],staticClass:"list-wrapper"},[s("el-row",[s("el-col",{attrs:{xs:12,sm:12,lg:12}},[s("h1",{staticClass:"taskListTitle"},[t._v("Tasks")])]),s("el-col",{attrs:{xs:12,sm:12,lg:12}},[s("el-button",{staticClass:"taskListBtn",attrs:{type:"primary",disabled:"incomplete"===t.taskListType},on:{click:t.changeList}},[t._v("Incomplete")]),s("el-button",{staticClass:"taskListBtn",attrs:{type:"primary",disabled:"completed"===t.taskListType},on:{click:t.changeList}},[t._v("Completed")])],1),s("el-col",{attrs:{xs:24,sm:24,lg:24}},[s("TodoList",{staticClass:"todoList",attrs:{todos:t.tasks}})],1)],1)],1)])],1),s("el-row",{attrs:{gutter:32}},[s("el-col",{attrs:{xs:24,sm:24,lg:24}},[s("h1",{staticClass:"dashboardTitle"},[t._v("Tags")]),s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.barChartLoading,expression:"barChartLoading"}],staticClass:"chart-wrapper"},[s("bar-chart",{attrs:{"bar-chart":t.barChart}})],1)])],1)],1)},a=[],n=s("5530"),o=(s("5574"),s("f5ff")),r=s("e44e"),d=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("section",{staticClass:"todoapp"},[s("header",{staticClass:"header"}),s("section",{staticClass:"main"},[t.todos.length?s("div",[s("ul",{staticClass:"todo-list"},t._l(t.todos,(function(e,i){return s("todo",{key:i,attrs:{todo:e},on:{toggleTodo:t.toggleTodo,editTodo:t.editTodo,deleteTodo:t.deleteTodo}})})),1)]):s("div",[t._m(0)])])])},c=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"noTasks"},[s("p",{staticClass:"noTasksText"},[t._v("No tasks to display")])])}],l=(s("a434"),s("ebd1")),h=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("li",{staticClass:"todo",class:{completed:t.todo.completed,editing:t.editing}},[s("div",{staticClass:"view"},[s("input",{staticClass:"toggle",attrs:{type:"checkbox"},domProps:{checked:t.todo.completed},on:{change:function(e){return t.toggleTodo(t.todo)}}}),s("label",{domProps:{textContent:t._s(t.todo.task)},on:{dblclick:function(e){t.editing=!0}}}),s("button",{staticClass:"destroy",on:{click:function(e){return t.deleteTodo(t.todo)}}})]),s("input",{directives:[{name:"show",rawName:"v-show",value:t.editing,expression:"editing"},{name:"focus",rawName:"v-focus",value:t.editing,expression:"editing"}],staticClass:"edit",domProps:{value:t.todo.task},on:{keyup:[function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.doneEdit(e)},function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"esc",27,e.key,["Esc","Escape"])?null:t.cancelEdit(e)}],blur:t.doneEdit}})])},u=[],g=(s("498a"),{name:"Todo",directives:{focus:function(t,e,s){var i=e.value,a=s.context;i&&a.$nextTick((function(){t.focus()}))}},props:{todo:{type:Object,default:function(){return{}}}},data:function(){return{editing:!1}},methods:{deleteTodo:function(t){this.$emit("deleteTodo",t)},editTodo:function(t){var e=t.todo,s=t.value;this.$emit("editTodo",{todo:e,value:s})},toggleTodo:function(t){this.$emit("toggleTodo",t)},doneEdit:function(t){var e=t.target.value.trim(),s=this.todo;e?this.editing&&(this.editTodo({todo:s,value:e}),this.editing=!1):this.cancelEdit(t)},cancelEdit:function(t){t.target.value=this.todo.text,this.editing=!1}}}),p=g,v=s("2877"),f=Object(v["a"])(p,h,u,!1,null,null,null),b=f.exports,m={name:"TodoList",components:{Todo:b},props:{todos:{type:Array,default:function(){return[]}}},data:function(){return{}},computed:{},methods:{toggleTodo:function(t){var e=this;t.completed=!t.completed,Object(l["f"])(t.id).then((function(t){console.log(t),e.$message.success("Task Updated Successfully")})).catch((function(t){e.$message.danger("Error Completing Task"),console.log(t)}))},deleteTodo:function(t){var e=this;Object(l["n"])(t.id).then((function(s){e.$message.success("Task Deleted Successfully"),e.todos.splice(e.todos.indexOf(t),1)})).catch((function(t){e.$message.danger("Error Deleting Task"),console.log(t)}))},editTodo:function(t){var e=this,s=t.todo,i=t.value;s.task=i,console.log(s),Object(l["U"])(s).then((function(t){console.log(t),e.$message.success("Task Updated Successfully")})).catch((function(t){e.$message.error("Error Updating Task"),console.log(t.response)}))}}},k=m,y=(s("1a9a"),Object(v["a"])(k,d,c,!1,null,null,null)),T=y.exports,x=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{class:t.className,style:{height:t.height,width:t.width}})},C=[],L=s("313e"),_=s.n(L),E=s("ed08"),$={data:function(){return{$_sidebarElm:null,$_resizeHandler:null}},mounted:function(){var t=this;this.$_resizeHandler=Object(E["a"])((function(){t.chart&&t.chart.resize()}),100),this.$_initResizeEvent(),this.$_initSidebarResizeEvent()},beforeDestroy:function(){this.$_destroyResizeEvent(),this.$_destroySidebarResizeEvent()},activated:function(){this.$_initResizeEvent(),this.$_initSidebarResizeEvent()},deactivated:function(){this.$_destroyResizeEvent(),this.$_destroySidebarResizeEvent()},methods:{$_initResizeEvent:function(){window.addEventListener("resize",this.$_resizeHandler)},$_destroyResizeEvent:function(){window.removeEventListener("resize",this.$_resizeHandler)},$_sidebarResizeHandler:function(t){"width"===t.propertyName&&this.$_resizeHandler()},$_initSidebarResizeEvent:function(){this.$_sidebarElm=document.getElementsByClassName("sidebar-container")[0],this.$_sidebarElm&&this.$_sidebarElm.addEventListener("transitionend",this.$_sidebarResizeHandler)},$_destroySidebarResizeEvent:function(){this.$_sidebarElm&&this.$_sidebarElm.removeEventListener("transitionend",this.$_sidebarResizeHandler)}}};s("817d");var w={mixins:[$],props:{className:{type:String,default:"chart"},width:{type:String,default:"100%"},height:{type:String,default:"400px"},barChart:{type:Object,default:function(){return{}}}},data:function(){return{chart:null,config:{tooltip:{trigger:"axis",axisPointer:{type:"shadow"}},grid:{top:10,left:"2%",right:"2%",bottom:"3%",containLabel:!0},xAxis:[{type:"category",data:this.barChart.xaxis,axisTick:{alignWithLabel:!0}}],yAxis:[{type:"value",axisTick:{show:!1}}],series:[{data:this.barChart.bars,type:"bar"}]}}},watch:{barChart:function(){this.config.xAxis[0].data=this.barChart.xaxis,this.config.series[0].data=this.barChart.bars,this.chart.setOption(this.config)}},mounted:function(){var t=this;this.$nextTick((function(){t.initChart()}))},beforeDestroy:function(){this.chart&&(this.chart.dispose(),this.chart=null)},methods:{initChart:function(){this.chart=_.a.init(this.$el,"macarons"),this.chart.setOption({tooltip:{trigger:"axis",axisPointer:{type:"shadow"}},grid:{top:10,left:"2%",right:"2%",bottom:"3%",containLabel:!0},xAxis:[{type:"category",data:this.barChart.xaxis,axisTick:{alignWithLabel:!0}}],yAxis:[{type:"value",axisTick:{show:!1}}],series:[{data:this.barChart.bars,type:"bar"}]})}}},z=w,O=Object(v["a"])(z,x,C,!1,null,null,null),D=O.exports,j=s("2f62"),R={name:"Dashboard",components:{FullCalendar:o["a"],TodoList:T,BarChart:D},data:function(){return{eventListLoading:!0,taskListLoading:!0,barChartLoading:!0,type:"index",events:[],calendarOptions:{plugins:[r["a"]],initialView:"listWeek",events:this.events,views:{listDay:{buttonText:"Day"},listWeek:{buttonText:"Week"},listMonth:{buttonText:"Month"}},headerToolbar:{start:"title",center:"",end:"prev,listDay,listWeek,listMonth,next"},titleFormat:{year:"2-digit",month:"short",day:"numeric"},firstDay:1,eventClick:this.viewEvent},taskListType:"incomplete",tasks:[],barChart:{}}},computed:Object(n["a"])({},Object(j["b"])(["roles"])),watch:{events:function(){this.calendarOptions.events=this.events}},created:function(){this.getDashboard()},methods:{getDashboard:function(){this.getDashboardEvents()},getDashboardEvents:function(){var t=this;Object(l["u"])().then((function(e){console.log(e),t.events=e.data,t.eventListLoading=!1,t.getDashboardTasks()})).catch((function(t){console.log(t)}))},getDashboardTasks:function(){var t=this;this.taskListLoading=!1,Object(l["v"])(this.type,this.taskListType).then((function(e){console.log(e),t.tasks=e.data,t.taskListLoading=!1,t.getDashboardBarChart()})).catch((function(t){console.log(t)}))},getDashboardBarChart:function(){var t=this;Object(l["t"])().then((function(e){console.log(e),t.barChart=e.data,t.barChartLoading=!1})).catch((function(t){console.log(t)}))},viewEvent:function(t){console.log(t);var e=t.event.extendedProps.type;"event"===e?this.$router.push("/events/view?eventID="+t.event.id):"task"===e&&this.$router.push("/tasks/view?taskID="+t.event.id)},changeList:function(){this.taskListType="incomplete"===this.taskListType?"completed":"incomplete",this.getDashboardTasks()}}},S=R,N=(s("3568"),Object(v["a"])(S,i,a,!1,null,"a32db3f6",null));e["default"]=N.exports},dcd6:function(t,e,s){}}]);