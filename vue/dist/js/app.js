(function(t){function e(e){for(var a,o,i=e[0],l=e[1],u=e[2],p=0,d=[];p<i.length;p++)o=i[p],Object.prototype.hasOwnProperty.call(n,o)&&n[o]&&d.push(n[o][0]),n[o]=0;for(a in l)Object.prototype.hasOwnProperty.call(l,a)&&(t[a]=l[a]);c&&c(e);while(d.length)d.shift()();return r.push.apply(r,u||[]),s()}function s(){for(var t,e=0;e<r.length;e++){for(var s=r[e],a=!0,i=1;i<s.length;i++){var l=s[i];0!==n[l]&&(a=!1)}a&&(r.splice(e--,1),t=o(o.s=s[0]))}return t}var a={},n={app:0},r=[];function o(e){if(a[e])return a[e].exports;var s=a[e]={i:e,l:!1,exports:{}};return t[e].call(s.exports,s,s.exports,o),s.l=!0,s.exports}o.m=t,o.c=a,o.d=function(t,e,s){o.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:s})},o.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},o.t=function(t,e){if(1&e&&(t=o(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var s=Object.create(null);if(o.r(s),Object.defineProperty(s,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var a in t)o.d(s,a,function(e){return t[e]}.bind(null,a));return s},o.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return o.d(e,"a",e),e},o.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},o.p="/";var i=window["webpackJsonp"]=window["webpackJsonp"]||[],l=i.push.bind(i);i.push=e,i=i.slice();for(var u=0;u<i.length;u++)e(i[u]);var c=l;r.push([0,"chunk-vendors"]),s()})({0:function(t,e,s){t.exports=s("56d7")},"034f":function(t,e,s){"use strict";var a=s("85ec"),n=s.n(a);n.a},"56d7":function(t,e,s){"use strict";s.r(e);s("e260"),s("e6cf"),s("cca6"),s("a79d");var a=s("2b0e"),n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{class:t.appdata.slug,attrs:{id:"merrweb-api-wrapper"}},[s("form",{attrs:{id:"merrweb-api"}},[s("div",{staticClass:"form-group"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.appdata._wpnonce,expression:"appdata._wpnonce"}],attrs:{type:"hidden"},domProps:{value:t.appdata._wpnonce},on:{input:function(e){e.target.composing||t.$set(t.appdata,"_wpnonce",e.target.value)}}}),s("input",{directives:[{name:"model",rawName:"v-model",value:t.appdata.q,expression:"appdata.q"}],staticClass:"form-control",attrs:{placeholder:t.placeholder,type:"text",name:"q",id:"q"},domProps:{value:t.appdata.q},on:{input:[function(e){e.target.composing||t.$set(t.appdata,"q",e.target.value)},function(e){return t.clearResults()}]}}),t.appdata.q.length<2?s("button",{class:t.btnClass,attrs:{type:"submit",disabled:""}},[t._v(t._s(t.bntTxt))]):t._e(),t.appdata.q.length>1?s("button",{class:t.btnClass,attrs:{type:"submit"},on:{click:t.searchQuery}},[t._v(t._s(t.bntTxt))]):t._e()])]),null==t.isLoading?s("hr"):t._e(),t.total_results>0?s("div",{class:t.showResults},[s("p",{domProps:{innerHTML:t._s(t.resultsIntro())}}),t._l(t.data,(function(e,a){return s("ul",{key:a},[s("li",{staticClass:"lang"},[t._v(t._s(t.language(e.meta.lang)))]),s("li",{staticClass:"fl"},[t._v(t._s(e.fl))]),s("li",{staticClass:"shortdef"},[s("Shortdef",{attrs:{item:e}})],1)])}))],2):t._e(),!0===t.showSuggs?s("ul",{class:t.showResults,attrs:{suggestions:t.suggestions}},[s("li",[s("p",{domProps:{innerHTML:t._s(t.noResults())}})]),s("ul",t._l(t.suggestions,(function(e,a){return s("li",{key:a},[s("a",{attrs:{href:"#"},on:{click:function(s){return t.suggestion(e)}}},[t._v(t._s(e))])])})),0)]):t._e(),s("div",{class:t.showResults},[s("div",{staticClass:"branding"},[s("div",[s("a",{attrs:{href:t.logoHref}},[s("img",{attrs:{src:t.logoSrc,alt:t.logoAlt}})])]),s("div",[t._v("Results courtesy "),s("a",{attrs:{href:t.logoHref}},[t._v("Merriam-Webster Inc.")])])])]),null!=t.errorDesc?s("p",[t._v(t._s(t.errorDesc))]):t._e(),s("div",{class:t.isLoading,attrs:{id:t.loadingId},on:{click:function(e){return t.clearLoading()}}},[t._m(0)])])},r=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"status"},[s("div",{staticClass:"lds-spinner"},[s("div"),s("div"),s("div"),s("div"),s("div"),s("div"),s("div"),s("div"),s("div"),s("div"),s("div"),s("div")])])}],o=(s("ac1f"),s("5319"),function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("ul",t._l(t.item.shortdef,(function(e,a){return s("li",{key:a},[t._v(t._s(e))])})),0)}),i=[],l={props:{item:{}}},u=l,c=s("2877"),p=Object(c["a"])(u,o,i,!1,null,null,null),d=p.exports,h={components:{Shortdef:d},data:function(){return{isLoading:"",isFullPage:!0,loadingId:this.$appdata.loadingId,placeholder:this.$appdata.placeholder,loadingClass:this.$appdata.loadingClass,noResultsMsg:this.$appdata.noResultsMsg,resultsMsg:this.$appdata.resultsMsg,resultsMsgTxt:"",bntTxt:this.$appdata.btnTxt,btnClass:"btn btn-primary",appdata:this.$appdata,data:[],suggestions:[],total_results:0,item:{},showSuggs:!1,showResults:"hide",errorDesc:null,logoSrc:this.$appdata.logoSrc,logoAlt:this.$appdata.logoAlt,logoHref:this.$appdata.logoHref}},methods:{clearLoading:function(){return this.isLoading=""},clearResults:function(){this.showResults="hide"},noResults:function(){return this.noResultsMsg.replace("%s",'<span class="search-query">'+this.appdata.q+"</span>")},resultsIntro:function(){if(""==this.resultsMsg)return this.resultsMsg;var t=this.resultsMsg.replace("%s",'<span class="search-query">'+this.appdata.q+"</span>");return t.replace("%d",'<span class="total-results">'+this.total_results+"</span>")},searchQuery:function(){var t=this;event.preventDefault(),this.isLoading=this.loadingClass,this.total_results=0,this.data=[],this.suggestions=[],this.showSuggs=!1,this.errorDesc=null,this.showResults="hide";var e=new FormData;e.append("_wpnonce",this.appdata._wpnonce),e.append("action",this.appdata.action),e.append("q",this.appdata.q),this.$http.post(this.appdata.url,e).then((function(e){if(t.$appdata.q=t.appdata.q,t.isLoading="",t.showResults="show",void 0==e.data.error&&void 0!=e.data[0].meta)for(var s in e.data)e.data[s].shortdef.length>0&&(t.data.push(e.data[s]),t.total_results++);else"error"==e.data.error?(t.total_results=0,t.errorDesc=e.data.error_description):0!=e.data.length&&(t.suggestions=e.data,t.data=[],t.total_results=0,t.showSuggs=!0)})).catch((function(e){t.isLoading="",console.log(e)}))},suggestion:function(t){this.showResults="hide",this.suggestions=[],this.appdata.q=t,this.searchQuery()},language:function(t){return"en"==t?"English":"Spanish"}},mounted:function(){}},f=h,g=(s("034f"),Object(c["a"])(f,n,r,!1,null,null,null)),v=g.exports,_=s("9483");Object(_["a"])("".concat("/","service-worker.js"),{ready:function(){console.log("App is being served from cache by a service worker.\nFor more details, visit https://goo.gl/AFskqB")},registered:function(){console.log("Service worker has been registered.")},cached:function(){console.log("Content has been cached for offline use.")},updatefound:function(){console.log("New content is downloading.")},updated:function(){console.log("New content is available; please refresh.")},offline:function(){console.log("No internet connection found. App is running in offline mode.")},error:function(t){console.error("Error during service worker registration:",t)}});var m=s("8c4f");a["a"].use(m["a"]);var b=[],w=new m["a"]({mode:"history",history:!1,base:"/",routes:b}),y=w,$=s("2f62");a["a"].use($["a"]);var q=new $["a"].Store({state:{},mutations:{},actions:{},modules:{}}),S=s("bc3a"),x=s.n(S),M=s("a7fe"),R=s.n(M);s("7e7d");a["a"].use(R.a,x.a),a["a"].prototype.$appdata=window.merrweb_esbd,a["a"].config.productionTip=!1,new a["a"]({router:y,store:q,render:function(t){return t(v)}}).$mount("#app")},"7e7d":function(t,e,s){},"85ec":function(t,e,s){}});
//# sourceMappingURL=app.js.map