(()=>{var e={744:(e,t)=>{"use strict";t.Z=(e,t)=>{const n=e.__vccOpts||e;for(const[e,o]of t)n[e]=o;return n}},4:(e,t,n)=>{"use strict";n.d(t,{Z:()=>c});const o=Vue;var a={key:0,class:"text-base ml-4"},r={key:1,class:"grid md:grid-cols-12 gap-6"},l={class:"text-sm mt-2"};const s={data:function(){return{loading:!0,checks:[],finishedAt:null}},mounted:function(){this.load()},methods:{load:function(){var e=this;this.loading=!0,Nova.request().get("/nova-vendor/stepanenko3/nova-health").then((function(t){if(t.status&&t.data){e.loading=!1,e.checks=t.data.checkResults;var n=new Date(1e3*t.data.finishedAt),o=("0"+n.getDate()).slice(-2)+"/"+("0"+(n.getMonth()+1)).slice(-2)+"/"+n.getFullYear()+" "+("0"+n.getHours()).slice(-2)+":"+("0"+n.getMinutes()).slice(-2);e.finishedAt=o}else Nova.error("Error")}))},getByStatus:function(e,t){return t.hasOwnProperty(e)?t[e]:t.default}}};const c=(0,n(744).Z)(s,[["render",function(e,t,n,s,c,i){var d=(0,o.resolveComponent)("Icon"),u=(0,o.resolveComponent)("LoadingButton"),g=(0,o.resolveComponent)("Heading"),p=(0,o.resolveComponent)("Loader"),f=(0,o.resolveComponent)("Card");return(0,o.openBlock)(),(0,o.createElementBlock)(o.Fragment,null,[(0,o.createVNode)(g,{level:1,class:"flex items-center justify-between mb-6"},{default:(0,o.withCtx)((function(){return[(0,o.createElementVNode)("span",null,(0,o.toDisplayString)(e.__("Health")),1),e.finishedAt?((0,o.openBlock)(),(0,o.createElementBlock)("span",a,(0,o.toDisplayString)(e.finishedAt),1)):(0,o.createCommentVNode)("",!0),(0,o.createVNode)(u,{class:"relative ml-auto",size:"xs",component:"LinkButton",disabled:e.loading,loading:e.loading,onClick:i.load},{default:(0,o.withCtx)((function(){return[(0,o.createVNode)(d,{type:"refresh"})]})),_:1},8,["disabled","loading","onClick"])]})),_:1}),e.loading?((0,o.openBlock)(),(0,o.createBlock)(p,{key:0})):(0,o.createCommentVNode)("",!0),!e.loading&&e.checks.length?((0,o.openBlock)(),(0,o.createElementBlock)("div",r,[((0,o.openBlock)(!0),(0,o.createElementBlock)(o.Fragment,null,(0,o.renderList)(e.checks,(function(e){return(0,o.openBlock)(),(0,o.createBlock)(f,{class:"md:col-span-4 h-full p-6 flex items-start"},{default:(0,o.withCtx)((function(){return[(0,o.createVNode)(d,{width:"30",height:"30",class:(0,o.normalizeClass)(["mr-4 flex-shrink-0",i.getByStatus(e.status,{ok:"text-green-500",warning:"text-yellow-500",skipped:"text-blue-500",failed:"text-red-500",crashed:"text-red-500",default:"text-gray-500"})]),type:i.getByStatus(e.status,{ok:"check-circle",warning:"exclamation-circle",skipped:"arrow-circle-right",failed:"x-circle",crashed:"x-circle",default:"dots-circle-horizontal"})},null,8,["class","type"]),(0,o.createElementVNode)("div",null,[(0,o.createVNode)(g,{level:"3",textContent:(0,o.toDisplayString)(e.label)},null,8,["textContent"]),(0,o.createElementVNode)("div",l,(0,o.toDisplayString)(e.notificationMessage||e.shortSummary),1)])]})),_:2},1024)})),256))])):(0,o.createCommentVNode)("",!0)],64)}]])}},t={};function n(o){var a=t[o];if(void 0!==a)return a.exports;var r=t[o]={exports:{}};return e[o](r,r.exports,n),r.exports}n.d=(e,t)=>{for(var o in t)n.o(t,o)&&!n.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),Nova.booting((function(e,t,o){Nova.inertia("NovaHealth",n(4).Z)}))})();