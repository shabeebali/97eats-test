(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([[7],{"56b4":function(e,s,r){"use strict";r.r(s);var a=function(){var e=this,s=e.$createElement,r=e._self._c||s;return e.appLoading?e._e():r("q-layout",{attrs:{view:"lHh Lpr lFf"}},[r("q-page-container",[r("q-page",{staticClass:"row justify-center items-center"},[r("div",{staticClass:"col-12 col-md-4"},[r("q-card",{},[r("q-card-section",{staticClass:"bg-pink-7 text-white q-my-0 q-py-sm",attrs:{dense:""}},[r("div",{staticClass:"text-center text-h6 text-bold"},[e._v("Registration")])]),r("q-separator"),r("q-card-section",[r("q-form",{ref:"form"},[r("div",{staticClass:"row q-col-gutter-sm"},[r("div",{staticClass:"col-12"},[r("q-input",{attrs:{name:"name",outlined:"",label:"Name",id:"name","lazy-rules":"ondemand",error:e.errors.name&&e.errors.name.length>0,"error-message":e.errors.name,rules:[function(e){return!!e||"Required"}]},on:{input:function(s){e.errors.name=null}},model:{value:e.model.name,callback:function(s){e.$set(e.model,"name",s)},expression:"model.name"}})],1)]),r("div",{staticClass:"row q-mt-md"},[r("div",{staticClass:"col-12"},[r("q-input",{attrs:{name:"email",outlined:"",label:"Email",id:"email",error:e.errors.email&&e.errors.email.length>0,"error-message":e.errors.email,"lazy-rules":"ondemand",rules:[function(e){return!!e||"Required"},function(s){return e.validateEmail(s)}]},on:{input:function(s){e.errors.email=null}},model:{value:e.model.email,callback:function(s){e.$set(e.model,"email",s)},expression:"model.email"}})],1)]),r("div",{staticClass:"row q-mt-md"},[r("div",{staticClass:"col-12"},[r("q-input",{attrs:{name:"password",outlined:"",label:"Password",type:"password",id:"password",error:e.errors.password&&e.errors.password.length>0,"error-message":e.errors.password,"lazy-rules":"ondemand",rules:[function(e){return!!e||"Required"}]},on:{input:function(s){e.errors.password=null}},model:{value:e.model.password,callback:function(s){e.$set(e.model,"password",s)},expression:"model.password"}})],1),r("div",{staticClass:"col-12"},[r("q-input",{attrs:{name:"password_confirmation",outlined:"",label:"Confirm Password",type:"password",id:"password_confirmation",error:e.errors.password_confirmation&&e.errors.password_confirmation.length>0,"error-message":e.errors.password_confirmation,"lazy-rules":"ondemand",rules:[function(e){return!!e||"Required"}]},on:{input:function(s){e.errors.password_confirmation=null}},model:{value:e.model.password_confirmation,callback:function(s){e.$set(e.model,"password_confirmation",s)},expression:"model.password_confirmation"}})],1)])])],1),r("q-separator"),r("q-card-actions",[r("q-btn",{staticClass:"full-width q-mt-sm",attrs:{color:"pink-8",outline:"",label:"Register"},on:{click:function(s){return e.register()}}})],1)],1)],1)])],1)],1)},t=[],o=(r("a79d"),r("758b"),{data(){return{model:{name:null,email:null,password:null,password_confirmation:null},errors:{name:null,password_confirmation:null,password:null,email:null},appLoading:!0}},mounted(){this.initFn()},computed:{},methods:{initFn(){this.$store.dispatch("init").then((e=>{"authenticated"===e&&this.$router.push("/")})).catch((e=>{console.log(e)})).finally((()=>{this.appLoading=!1}))},register(){this.$refs.form.validate().then((e=>{e&&(this.$q.loading.show(),Object.keys(this.errors).forEach((e=>{this.errors[e]=null})),this.$axios.post("register",this.model).then((e=>{"success"===e.data.message&&(this.$q.notify("Registration is success. Login using your credentials"),this.$router.push("/login"))})).catch((e=>{422!==e.response.status&&400!==e.response.status||(this.$q.notify({type:"negative",message:"There are errors in data submitted"}),"errors"in e.response.data?Object.keys(e.response.data.errors).forEach((s=>{this.errors[s]=e.response.data.errors[s][0]})):"messages"in e.response.data&&Object.keys(e.response.data.messages).forEach((s=>{this.errors[s]=e.response.data.messages[s]})))})).finally((()=>this.$q.loading.hide())))}))},validateEmail(e){return!!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(e)||"Invalid Email"}}}),n=o,i=r("2877"),l=r("4d5a"),d=r("09e3"),c=r("9989"),m=r("f09f"),u=r("a370"),p=r("eb85"),f=r("0378"),h=r("27f9"),w=r("4b7e"),g=r("9c40"),q=r("eebe"),b=r.n(q),v=Object(i["a"])(n,a,t,!1,null,null,null);s["default"]=v.exports;b()(v,"components",{QLayout:l["a"],QPageContainer:d["a"],QPage:c["a"],QCard:m["a"],QCardSection:u["a"],QSeparator:p["a"],QForm:f["a"],QInput:h["a"],QCardActions:w["a"],QBtn:g["a"]})}}]);