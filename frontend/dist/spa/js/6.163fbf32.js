(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[6],{"013f":function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return t.appLoading?t._e():a("q-layout",{attrs:{view:"lHh Lpr lFf"}},[a("q-page-container",[a("q-page",{staticClass:"row justify-center items-center"},[a("div",{staticClass:"col-12 col-md-4 bg-white"},[a("q-card",{staticClass:"q-mt-sm",attrs:{flat:""}},[a("q-card-section",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("q-input",{attrs:{name:"email",outlined:"",label:"Email",id:"email"},model:{value:t.model.email,callback:function(e){t.$set(t.model,"email",e)},expression:"model.email"}})],1)]),a("div",{staticClass:"row q-mt-md"},[a("div",{staticClass:"col-12"},[a("q-input",{attrs:{name:"password",outlined:"",label:"Password",type:"password",id:"password"},model:{value:t.model.password,callback:function(e){t.$set(t.model,"password",e)},expression:"model.password"}})],1)]),a("div",{staticClass:"row q-mt-md"},[a("div",{staticClass:"col-12"},[a("q-checkbox",{attrs:{label:"Remember Me?",color:"lime-7"},model:{value:t.model.remember,callback:function(e){t.$set(t.model,"remember",e)},expression:"model.remember"}})],1)])]),a("q-separator"),a("q-card-section",[a("q-btn",{staticClass:"full-width",attrs:{color:"pink-7","no-caps":"",label:"Login"},on:{click:function(e){return t.login()}}})],1),a("q-separator"),a("q-card-section",{staticClass:"text-center"},[a("div",{staticClass:"text-subtitle2"},[t._v("Don't have account?")]),a("q-btn",{staticClass:"full-width",attrs:{"no-caps":"",label:"Register",color:"pink-8"},on:{click:function(e){return t.$router.push({name:"RegisterPage"})}}})],1)],1)],1)])],1)],1)},o=[],i=(a("a79d"),{data(){return{model:{email:"",password:"",remember:!1},appLoading:!0}},mounted(){this.initFn()},computed:{},methods:{initFn(){this.$store.dispatch("init").then((t=>{"authenticated"===t&&this.$router.push("/")})).catch((t=>{console.log(t)})).finally((()=>{this.appLoading=!1}))},login(){this.$q.loading.show(),this.$axios.post("login",this.model).then((t=>{"authenticated"===t.data.message&&(localStorage.setItem("token",t.data.token),this.$router.push("/"))})).catch((t=>{422===t.response.status||400===t.response.status?this.$q.notify({type:"negative",message:"Incorrect credentials"}):this.$q.notify({type:"negative",message:"Something went wrong."})})).finally((()=>{this.$q.loading.hide()}))}}}),l=i,n=a("2877"),r=a("4d5a"),c=a("09e3"),d=a("9989"),m=a("f09f"),p=a("a370"),u=a("27f9"),h=a("8f8e"),g=a("eb85"),w=a("9c40"),b=a("eebe"),f=a.n(b),q=Object(n["a"])(l,s,o,!1,null,null,null);e["default"]=q.exports;f()(q,"components",{QLayout:r["a"],QPageContainer:c["a"],QPage:d["a"],QCard:m["a"],QCardSection:p["a"],QInput:u["a"],QCheckbox:h["a"],QSeparator:g["a"],QBtn:w["a"]})}}]);