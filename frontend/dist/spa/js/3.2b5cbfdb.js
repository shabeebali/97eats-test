(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[3],{"713b":function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.appLoading?t._e():n("q-layout",[n("q-header",{attrs:{elevated:""}},[n("q-toolbar",{staticClass:"bg-pink-8"},[n("q-btn",{attrs:{flat:"",dense:"",round:"",icon:"menu","aria-label":"Menu"},on:{click:function(e){t.leftDrawerOpen=!t.leftDrawerOpen}}}),n("q-toolbar-title",[t._v("\n        97eats App\n      ")]),n("q-btn",{attrs:{flat:"",label:"Logout"},on:{click:function(e){return t.logout()}}})],1)],1),n("q-drawer",{attrs:{"show-if-above":"",bordered:"","content-class":"bg-grey-1"},model:{value:t.leftDrawerOpen,callback:function(e){t.leftDrawerOpen=e},expression:"leftDrawerOpen"}},[n("q-list",t._l(t.essentialLinks,(function(e){return n("EssentialLink",t._b({key:e.title},"EssentialLink",e,!1))})),1)],1),n("q-page-container",[n("router-view")],1)],1)},o=[],i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("q-item",{attrs:{exact:"",clickable:"",tag:"a",to:t.link}},[t.icon?n("q-item-section",{attrs:{avatar:""}},[n("q-icon",{attrs:{name:t.icon}})],1):t._e(),n("q-item-section",[n("q-item-label",[t._v(t._s(t.title))]),n("q-item-label",{attrs:{caption:""}},[t._v("\n      "+t._s(t.caption)+"\n    ")])],1)],1)},l=[],r={name:"EssentialLink",props:{title:{type:String,required:!0},caption:{type:String,default:""},link:{type:String,default:"#"},icon:{type:String,default:""}}},s=r,c=n("2877"),u=n("66e5"),p=n("4074"),d=n("0016"),m=n("0170"),b=n("eebe"),g=n.n(b),f=Object(c["a"])(s,i,l,!1,null,null,null),k=f.exports;g()(f,"components",{QItem:u["a"],QItemSection:p["a"],QIcon:d["a"],QItemLabel:m["a"]});const h=[{title:"Dashboard",icon:"home",link:"/"},{title:"Restaurants",icon:"restaurant",link:"/restaurants"}];var q={name:"MainLayout",components:{EssentialLink:k},data(){return{leftDrawerOpen:!1,essentialLinks:h,appLoading:!0}},computed:{},mounted(){this.$store.dispatch("init").then((t=>{console.log("msg"),this.appLoading=!1})).catch((t=>{console.log(t),"unauthenticated"===t&&this.$router.push("/login")}))},methods:{logout(){this.$q.dialog({title:"Confirm",message:"Do you want to logout?"}).onOk((()=>{localStorage.removeItem("token"),this.$router.go()}))}}},w=q,L=n("4d5a"),v=n("e359"),_=n("65c6"),Q=n("9c40"),y=n("6ac5"),D=n("9404"),O=n("1c1c"),E=n("09e3"),S=Object(c["a"])(w,a,o,!1,null,null,null);e["default"]=S.exports;g()(S,"components",{QLayout:L["a"],QHeader:v["a"],QToolbar:_["a"],QBtn:Q["a"],QToolbarTitle:y["a"],QDrawer:D["a"],QList:O["a"],QPageContainer:E["a"]})}}]);