!function(e){var t={};function n(r){if(t[r])return t[r].exports;var i=t[r]={i:r,l:!1,exports:{}};return e[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(r,i,function(t){return e[t]}.bind(null,i));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=13)}([function(e,t){e.exports=wp.i18n},function(e,t,n){e.exports=n(12)},function(e,t){e.exports=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}},function(e,t){function n(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}e.exports=function(e,t,r){return t&&n(e.prototype,t),r&&n(e,r),e}},function(e,t,n){var r=n(9),i=n(10);e.exports=function(e,t){return!t||"object"!==r(t)&&"function"!=typeof t?i(e):t}},function(e,t){function n(t){return e.exports=n=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},n(t)}e.exports=n},function(e,t,n){var r=n(11);e.exports=function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&r(e,t)}},function(e,t){e.exports=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}},function(e,t){function n(e,t,n,r,i,o,a){try{var l=e[o](a),s=l.value}catch(e){return void n(e)}l.done?t(s):Promise.resolve(s).then(r,i)}e.exports=function(e){return function(){var t=this,r=arguments;return new Promise((function(i,o){var a=e.apply(t,r);function l(e){n(a,i,o,l,s,"next",e)}function s(e){n(a,i,o,l,s,"throw",e)}l(void 0)}))}}},function(e,t){function n(t){return"function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?e.exports=n=function(e){return typeof e}:e.exports=n=function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(t)}e.exports=n},function(e,t){e.exports=function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}},function(e,t){function n(t,r){return e.exports=n=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},n(t,r)}e.exports=n},function(e,t,n){var r=function(e){"use strict";var t=Object.prototype,n=t.hasOwnProperty,r="function"==typeof Symbol?Symbol:{},i=r.iterator||"@@iterator",o=r.asyncIterator||"@@asyncIterator",a=r.toStringTag||"@@toStringTag";function l(e,t,n,r){var i=t&&t.prototype instanceof u?t:u,o=Object.create(i.prototype),a=new E(r||[]);return o._invoke=function(e,t,n){var r="suspendedStart";return function(i,o){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===i)throw o;return x()}for(n.method=i,n.arg=o;;){var a=n.delegate;if(a){var l=y(a,n);if(l){if(l===c)continue;return l}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var u=s(e,t,n);if("normal"===u.type){if(r=n.done?"completed":"suspendedYield",u.arg===c)continue;return{value:u.arg,done:n.done}}"throw"===u.type&&(r="completed",n.method="throw",n.arg=u.arg)}}}(e,n,a),o}function s(e,t,n){try{return{type:"normal",arg:e.call(t,n)}}catch(e){return{type:"throw",arg:e}}}e.wrap=l;var c={};function u(){}function p(){}function m(){}var d={};d[i]=function(){return this};var h=Object.getPrototypeOf,f=h&&h(h(k([])));f&&f!==t&&n.call(f,i)&&(d=f);var w=m.prototype=u.prototype=Object.create(d);function g(e){["next","throw","return"].forEach((function(t){e[t]=function(e){return this._invoke(t,e)}}))}function v(e,t){var r;this._invoke=function(i,o){function a(){return new t((function(r,a){!function r(i,o,a,l){var c=s(e[i],e,o);if("throw"!==c.type){var u=c.arg,p=u.value;return p&&"object"==typeof p&&n.call(p,"__await")?t.resolve(p.__await).then((function(e){r("next",e,a,l)}),(function(e){r("throw",e,a,l)})):t.resolve(p).then((function(e){u.value=e,a(u)}),(function(e){return r("throw",e,a,l)}))}l(c.arg)}(i,o,r,a)}))}return r=r?r.then(a,a):a()}}function y(e,t){var n=e.iterator[t.method];if(void 0===n){if(t.delegate=null,"throw"===t.method){if(e.iterator.return&&(t.method="return",t.arg=void 0,y(e,t),"throw"===t.method))return c;t.method="throw",t.arg=new TypeError("The iterator does not provide a 'throw' method")}return c}var r=s(n,e.iterator,t.arg);if("throw"===r.type)return t.method="throw",t.arg=r.arg,t.delegate=null,c;var i=r.arg;return i?i.done?(t[e.resultName]=i.value,t.next=e.nextLoc,"return"!==t.method&&(t.method="next",t.arg=void 0),t.delegate=null,c):i:(t.method="throw",t.arg=new TypeError("iterator result is not an object"),t.delegate=null,c)}function _(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function b(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function E(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(_,this),this.reset(!0)}function k(e){if(e){var t=e[i];if(t)return t.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var r=-1,o=function t(){for(;++r<e.length;)if(n.call(e,r))return t.value=e[r],t.done=!1,t;return t.value=void 0,t.done=!0,t};return o.next=o}}return{next:x}}function x(){return{value:void 0,done:!0}}return p.prototype=w.constructor=m,m.constructor=p,m[a]=p.displayName="GeneratorFunction",e.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===p||"GeneratorFunction"===(t.displayName||t.name))},e.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,m):(e.__proto__=m,a in e||(e[a]="GeneratorFunction")),e.prototype=Object.create(w),e},e.awrap=function(e){return{__await:e}},g(v.prototype),v.prototype[o]=function(){return this},e.AsyncIterator=v,e.async=function(t,n,r,i,o){void 0===o&&(o=Promise);var a=new v(l(t,n,r,i),o);return e.isGeneratorFunction(n)?a:a.next().then((function(e){return e.done?e.value:a.next()}))},g(w),w[a]="Generator",w[i]=function(){return this},w.toString=function(){return"[object Generator]"},e.keys=function(e){var t=[];for(var n in e)t.push(n);return t.reverse(),function n(){for(;t.length;){var r=t.pop();if(r in e)return n.value=r,n.done=!1,n}return n.done=!0,n}},e.values=k,E.prototype={constructor:E,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(b),!e)for(var t in this)"t"===t.charAt(0)&&n.call(this,t)&&!isNaN(+t.slice(1))&&(this[t]=void 0)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var t=this;function r(n,r){return a.type="throw",a.arg=e,t.next=n,r&&(t.method="next",t.arg=void 0),!!r}for(var i=this.tryEntries.length-1;i>=0;--i){var o=this.tryEntries[i],a=o.completion;if("root"===o.tryLoc)return r("end");if(o.tryLoc<=this.prev){var l=n.call(o,"catchLoc"),s=n.call(o,"finallyLoc");if(l&&s){if(this.prev<o.catchLoc)return r(o.catchLoc,!0);if(this.prev<o.finallyLoc)return r(o.finallyLoc)}else if(l){if(this.prev<o.catchLoc)return r(o.catchLoc,!0)}else{if(!s)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return r(o.finallyLoc)}}}},abrupt:function(e,t){for(var r=this.tryEntries.length-1;r>=0;--r){var i=this.tryEntries[r];if(i.tryLoc<=this.prev&&n.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var o=i;break}}o&&("break"===e||"continue"===e)&&o.tryLoc<=t&&t<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=e,a.arg=t,o?(this.method="next",this.next=o.finallyLoc,c):this.complete(a)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),c},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var n=this.tryEntries[t];if(n.finallyLoc===e)return this.complete(n.completion,n.afterLoc),b(n),c}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var n=this.tryEntries[t];if(n.tryLoc===e){var r=n.completion;if("throw"===r.type){var i=r.arg;b(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(e,t,n){return this.delegate={iterator:k(e),resultName:t,nextLoc:n},"next"===this.method&&(this.arg=void 0),c}},e}(e.exports);try{regeneratorRuntime=r}catch(e){Function("r","regeneratorRuntime = r")(r)}},function(e,t,n){"use strict";n.r(t);var r=n(2),i=n.n(r),o=n(3),a=n.n(o),l=n(4),s=n.n(l),c=n(5),u=n.n(c),p=n(6),m=n.n(p),d=n(0),h=n(7),f=n.n(h),w=n(1),g=n.n(w),v=n(8),y=n.n(v);function _(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function b(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?_(Object(n),!0).forEach((function(t){f()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):_(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}var E=wp.element.Component,k=wp.apiFetch,x=wp.components.Icon,O=function(e){function t(e){var n;return i()(this,t),(n=s()(this,u()(t).call(this,e))).state={media:null},n}return m()(t,e),a()(t,[{key:"componentDidMount",value:function(){this.loadMedia()}},{key:"loadMedia",value:function(){var e=this;this.props.attachment?k({path:"/wp/v2/media/"+parseInt(this.props.attachment)}).then((function(t){e.setState({media:t})})):console.warn("Le composant WKG_Media doit recevoir l'attribut 'attachment'")}},{key:"render",value:function(){if(this.state.media){if("image"===this.state.media.media_type){var e="";e=this.props.size&&this.state.media.media_details&&this.state.media.media_details.sizes&&this.state.media.media_details.sizes[this.props.size]?this.state.media.media_details.sizes[this.props.size].source_url:this.state.media.media_details&&this.state.media.media_details.sizes&&this.state.media.media_details.sizes.thumbnail?this.state.media.media_details.sizes.thumbnail.source_url:this.state.media.source_url;var t="";return this.state.media.title&&(t=this.state.media.title.rendered),wp.element.createElement("img",{style:b({},z.img,{},this.props.style),src:e,alt:t})}if("file"===this.state.media.media_type){var n=null;return n="application/pdf"===this.state.media.mime_type?wp.element.createElement(x,{icon:"media-document",size:50}):wp.element.createElement(x,{icon:"media-default",size:50}),wp.element.createElement("div",{style:z.file},wp.element.createElement("div",{style:z.file_icon},n),wp.element.createElement("div",{style:z.file_title},this.state.media.title?this.state.media.title.rendered:"sans titre"))}return wp.element.createElement("div",{style:z.warning},"Media type not supported")}return wp.element.createElement("div",{style:b({},z.loading,{},this.props.styleLoading)},"Loading...")}}]),t}(E),z={img:{display:"inline-block"},loading:{color:"#999999"},file:{margin:"6px 0",padding:"6px",border:"1px solid #eeeeee"},warning:{color:"#999999"},file_icon:{},file_title:{fontSize:"10px"}};function j(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}var C=wp.element.Component,S=wp.apiFetch,P=wp.components,M=P.Button,L=P.SelectControl,N=(P.Placeholder,wp.blockEditor.MediaUpload),T=function(e){function t(e){var n;return i()(this,t),(n=s()(this,u()(t).call(this,e))).state={id:n.props.value&&n.props.value.id?parseInt(n.props.value.id):n.props.value,size:n.props.value&&n.props.value.size?n.props.value.size:n.props.defaultSize||"thumbnail",url:n.props.value&&n.props.value.url?n.props.value.url:"",media:null,ready:!1,defaultSize:n.props.defaultSize?n.props.defaultSize:"thumbnail"},n}var n,r,o;return m()(t,e),a()(t,[{key:"componentDidMount",value:(o=y()(g.a.mark((function e(){return g.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!this.props.available_sizes||1!==this.props.available_sizes.length){e.next=3;break}return e.next=3,this.setState({size:this.props.available_sizes[0].value});case 3:this.state.id?this.setMedia(this.state.id,this.state.size,!0):this.setState({ready:!0});case 4:case"end":return e.stop()}}),e,this)}))),function(){return o.apply(this,arguments)})},{key:"setMedia",value:(r=y()(g.a.mark((function e(t,n,r){var i,o,a=this;return g.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return i=n||this.state.size,o=t||this.state.id,e.next=4,this.setState({ready:!1});case 4:if(!o||!Number.isInteger(o)){e.next=8;break}S({path:"/wp/v2/media/"+parseInt(o)}).then((function(e){a.setState({ready:!0,media:e,id:o,url:a.getMediaUrlForSize(e,i),size:i}),r||a.onChange()})),e.next=11;break;case 8:return e.next=10,this.setState({ready:!0,media:null,id:null,url:null,size:i});case 10:r||this.onChange();case 11:case"end":return e.stop()}}),e,this)}))),function(e,t,n){return r.apply(this,arguments)})},{key:"getMediaUrlForSize",value:function(e,t){var n="";return t&&""!==t&&e&&e.media_details.sizes&&e.media_details.sizes[t]&&(n=e.media_details.sizes[t].source_url),""===n&&this.state.defaultSize&&""!==this.state.defaultSize&&e&&e.media_details.sizes&&e.media_details.sizes[this.state.defaultSize]&&(n=e.media_details.sizes[this.state.defaultSize].source_url),""===n&&(n=e.source_url),n}},{key:"removeMedia",value:(n=y()(g.a.mark((function e(t){return g.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,this.setState({media:null,id:null,url:null});case 2:t||this.onChange();case 3:case"end":return e.stop()}}),e,this)}))),function(e){return n.apply(this,arguments)})},{key:"onChange",value:function(){this.props.onChange?this.props.onChange({id:this.state.id,size:this.state.size,url:this.state.url}):console.warn("WKG_Media_Selector doit recevoir la propriété 'onChange={(media) => {}}}'")}},{key:"render_open",value:function(e){return this.state.id?wp.element.createElement(M,{className:"wkg-btn light",onClick:e},this.props.label_button_update?this.props.label_button_update:"Modifier"):wp.element.createElement(M,{className:"wkg-btn light",onClick:e},this.props.label_button?this.props.label_button:"Choisir l'image")}},{key:"render_media",value:function(){if(this.props.show&&this.state.id){var e=this.props.showsize||"medium",t=function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?j(Object(n),!0).forEach((function(t){f()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):j(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}({},{width:"100%",height:"auto"},{},this.props.styleMedia);return wp.element.createElement("div",{className:"media_render"},wp.element.createElement(O,{attachment:this.state.id,size:e,style:t}))}return null}},{key:"render_remove",value:function(){var e=this;return this.state.id?wp.element.createElement(M,{className:"wkg-btn icon light",style:{marginLeft:"6px"},onClick:function(){return e.removeMedia()}},"[DEL]"):null}},{key:"render_size_control",value:function(){var e=this;if(this.state.media&&"image"===this.state.media.media_type){var t=this.props.available_sizes;if(t||(t=[{value:"thumbnail",label:"thumbnail"},{value:"small",label:"small"},{value:"medium",label:"medium"},{value:"large",label:"large"}]),t&&t.length>1)return wp.element.createElement("div",{class:"media_controls",style:D.size_controler},wp.element.createElement(L,{options:t,onChange:function(t){return e.setMedia(null,t)},value:this.state.size}))}return null}},{key:"render",value:function(){var e=this;if(!this.state.ready)return wp.element.createElement("div",{style:D.loading},"Loading");var t=null;return this.props.label&&(t=wp.element.createElement("div",{className:"label",style:D.label},wp.element.createElement("label",null,this.props.label))),wp.element.createElement("div",{style:D.selector},t,this.render_media(),wp.element.createElement("div",{style:D.controler},wp.element.createElement(N,{allowedTypes:this.props.allowedTypes,value:this.state.id,onSelect:function(t){return e.setMedia(t.id)},render:function(t){var n=t.open;return e.render_open(n)}}),this.render_remove()),this.render_size_control())}}]),t}(C),D={selector:{width:"100%",height:"100%",position:"relative"},controler:{display:"flex",justifyContent:"space-between"},size_controler:{marginTop:"6px"},label:{marginBottom:"3px"},loading:{fontSize:"12px",color:"#999999"}},B=wp.primitives,F=B.SVG,G=B.Path,I={};I.logo=wp.element.createElement(F,{class:"wkg-icon wkg-icon-logo",role:"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 120 120"},wp.element.createElement(G,{d:"M60.1,0c-33.1,0-60,26.9-60,60c0,33.1,26.9,60,60,60s60-26.9,60-60C120.1,26.9,93.2,0,60.1,0z M103.8,36.9c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1c-1.1,0-2.1-0.9-2.1-2.1C101.8,39.9,102.7,36.9,103.8,36.9z M88.4,19.9c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1c-1.1,0-2.1-0.9-2.1-2.1C86.3,22.9,87.3,19.9,88.4,19.9z M77.1,41.5c1.1-6,5.8-13.2,10.8-12.4c5,0.9,7.2,9.5,6.2,15.5c-1.1,6-6.7,9.9-11.7,9.1C77.4,52.9,76,47.6,77.1,41.5z M60.1,9.1c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1S58,14.4,58,13.2C58,12.1,58.9,9.1,60.1,9.1z M60.1,19.9c5.1,0,9.3,10,9.3,15.8s-4.1,10.5-9.3,10.5s-9.3-4.7-9.3-10.5S55,19.9,60.1,19.9z M31.8,19.9c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1c-1.1,0-2.1-0.9-2.1-2.1C29.7,22.9,30.6,19.9,31.8,19.9z M32.3,29.2c5-0.9,9.7,6.3,10.8,12.4c1.1,6-0.3,11.3-5.3,12.2c-5,0.9-10.6-2.9-11.7-9C25,38.7,27.2,30.1,32.3,29.2z M16.3,36.9c1.1,0,2.1,3,2.1,4.1c0,1.1-0.9,2.1-2.1,2.1c-1.1,0-2.1-0.9-2.1-2.1C14.2,39.9,15.2,36.9,16.3,36.9z M11.9,62.4c-1.6-4.5,0.3-13.9,4.3-15.4c4-1.5,8.3,7,9.9,11.5c1.6,4.5,1.5,7.3-2.5,8.8C19.6,68.8,13.5,66.9,11.9,62.4z M78.6,101.8c-6.2,0-9.3-3.3-18.5-3.3s-12.4,3.3-18.5,3.3c-9.3,0-17-6.2-17-15.4C24.5,74,38.5,57,60.1,57c21.6,0,35.5,17,35.5,29.4C95.6,95.6,87.9,101.8,78.6,101.8z M96.6,67.3c-4-1.5-4.2-4.3-2.5-8.8c1.6-4.5,5.9-13,9.9-11.5c4,1.5,5.9,10.9,4.3,15.4C106.6,66.9,100.6,68.8,96.6,67.3z"})),I.bear=wp.element.createElement(F,{class:"wkg-icon wkg-icon-bear",role:"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 120 114"},wp.element.createElement(G,{d:"M107.1,25.7l-0.2-0.7c5.1-1.7,8.8-6.5,8.8-12.1C115.7,8.6,110,0,102.9,0c-4.9,0-9,2.7-11.2,6.7C84.1,3.4,73.2,0,60,0S35.9,3.4,28.4,6.7C26.2,2.7,22,0,17.1,0C10,0,4.3,8.6,4.3,12.9c0,5.7,3.7,10.4,8.8,12.1l-0.2,0.7L0,68.6c0,0,0,32.6,60,45.4c60-12.9,60-45.4,60-45.4L107.1,25.7z M60,64.3c0,0-25.7,0-21.4-21.5C43.7,17.3,60,17.1,60,17.1s16.3,0.2,21.4,25.8C85.7,64.3,60,64.3,60,64.3z"}),wp.element.createElement(G,{d:"M69.1,41.8c-2.7-1.4-5.4-1.9-7.9-2v-5.5c0-2.5,5.5-3.1,7.4-3.1c0.7,0,1.2-0.5,1.2-1.2c0-3.4-2-9.8-9.8-9.8c-3.4,0-9.8,2-9.8,9.8c0,0.7,0.5,1.2,1.2,1.2c1.9,0,7.4,0.6,7.4,3.1v5.5c-4.5,0.3-7.7,1.9-7.9,2c-0.6,0.3-0.8,1-0.5,1.6s1,0.8,1.6,0.5c0.1,0,8.2-4,16.1,0c0.2,0.1,0.4,0.1,0.5,0.1c0.4,0,0.9-0.2,1.1-0.7C70,42.8,69.7,42.1,69.1,41.8z"})),I.bear_plain=wp.element.createElement(F,{class:"wkg-icon wkg-icon-bear-plain",role:"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 120 114"},wp.element.createElement(G,{d:"M107.1,25.7l-0.2-0.7c5.1-1.7,8.8-6.5,8.8-12.1C115.7,8.6,110,0,102.9,0c-4.9,0-9,2.7-11.2,6.7C84.1,3.4,73.2,0,60,0S35.9,3.4,28.4,6.7C26.2,2.7,22,0,17.1,0C10,0,4.3,8.6,4.3,12.9c0,5.7,3.7,10.4,8.8,12.1l-0.2,0.7L0,68.6c0,0,0,32.6,60,45.4c60-12.9,60-45.4,60-45.4L107.1,25.7z M69.6,43.4c-0.2,0.4-0.6,0.7-1.1,0.7c-0.2,0-0.4,0-0.5-0.1c-7.9-4-16,0-16.1,0c-0.6,0.3-1.3,0.1-1.6-0.5s-0.1-1.3,0.5-1.6c0.2-0.1,3.4-1.7,7.9-2v-5.5c0-2.6-5.8-3.1-7.4-3.1c-0.7,0-1.2-0.5-1.2-1.2c0-7.7,6.4-9.8,9.8-9.8c7.7,0,9.8,6.4,9.8,9.8c0,0.7-0.5,1.2-1.2,1.2c-1.9,0-7.4,0.6-7.4,3.1v5.5c2.6,0,5.3,0.5,8,1.9C69.7,42.1,69.9,42.8,69.6,43.4z"})),I.face=wp.element.createElement(F,{class:"wkg-icon wkg-icon-face",role:"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 120 129.1"},wp.element.createElement(G,{d:"M118.9,70.4C104.9,0.4,60.2,0,60.2,0S15.5,0.4,1.5,70.4c-11.7,58.7,58.7,58.7,58.7,58.7S130.6,129.1,118.9,70.4z M85.1,67.5c1,0.5,1.7,1.5,1.8,2.5c0.1,0.6,0,1.3-0.3,1.9c-0.6,1.2-1.7,1.8-3,1.8c-0.5,0-1-0.1-1.5-0.3c-7.8-3.9-15.7-5-22.6-4.8c-8.1,0.2-14.8,2.2-18.4,3.6c-1.9,0.7-2.9,1.2-3,1.2c-1.6,0.8-3.6,0.1-4.4-1.5c-0.2-0.4-0.3-0.8-0.3-1.3c-0.1-1.3,0.6-2.6,1.8-3.2c0.6-0.3,9.4-4.6,21.6-5.4V46.9c0-6.7-14.8-8.3-19.7-8.4c-0.2,0-0.3,0-0.5,0s-0.4,0-0.6-0.1l0,0c-0.1,0-0.2-0.1-0.3-0.1c-1.3-0.4-2.3-1.7-2.3-3.1c0-4.5,0.8-8.3,2.1-11.5c5-11.8,17.4-15.3,24.7-15.3C81.4,8.4,87,25.9,87,35.2c0,1.8-1.5,3.3-3.3,3.3c-5.2,0-20.2,1.6-20.2,8.4v15C70.3,62.2,77.7,63.7,85.1,67.5z"})),I.seo=wp.element.createElement(F,{class:"wkg-icon wkg-icon-seo",role:"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 62.2 49.6"},wp.element.createElement(G,{d:"M43.5,19.5c-2.9,0-5.3,2.4-5.3,4.9c0,3.2,2.4,5.6,5.3,5.6c2.9,0,5.3-2.4,5.3-5.6C48.8,21.9,46.4,19.5,43.5,19.5z"}),wp.element.createElement(G,{d:"M60.9,21.3L45.6,2.1C44.5,0.8,42.9,0,41.2,0H5.7C2.5,0,0,2.5,0,5.7v38.3c0,3.1,2.5,5.7,5.7,5.7h35.5c1.7,0,3.3-0.8,4.4-2.1l15.3-19.1C62.6,26.3,62.6,23.3,60.9,21.3z M16.1,32.9c-1.5,1.2-3.4,1.8-5.3,1.8c-2.4,0-4.7-0.8-6.6-2.1l2.1-3.9c1.2,1.1,2.7,1.9,4.3,1.9c1.1,0,2.4-0.6,2.4-1.9c0-1.4-1.9-1.8-3-2.1C7,25.6,5,24.9,5,21.2c0-3.8,2.7-6.3,6.5-6.3c1.9,0,4.2,0.6,5.9,1.5l-1.9,3.8c-0.9-0.7-2-1.2-3.2-1.2c-0.9,0-2.1,0.5-2.1,1.6c0,1.1,1.3,1.5,2.2,1.8l1.2,0.4c2.6,0.8,4.6,2.1,4.6,5.1C18.1,29.7,17.6,31.6,16.1,32.9z M31.1,19.6h-5.8v3.1h5.5v4.1h-5.5V30h5.8v4.1H20.4V15.4h10.7V19.6zM43.5,34.8c-6,0-10.4-4.3-10.4-10.3c0-5.7,5-9.6,10.4-9.6c5.4,0,10.4,4,10.4,9.6C53.8,30.5,49.5,34.8,43.5,34.8z"}));var A=I,V=wp.plugins.registerPlugin,R=wp.element,K=R.Component,U=R.Fragment,H=wp.data,W=H.withSelect,Y=H.withDispatch,q=wp.compose.compose,J=wp.editPost,Q=J.PluginSidebar,X=J.PluginSidebarMoreMenuItem,Z=wp.components,$=Z.PanelBody,ee=Z.PanelRow,te=Z.TextControl;V("wkg-plugin-seometa",{icon:A.seo,render:function(e){return wp.element.createElement(U,null,wp.element.createElement(X,{target:"wkg-plugin-seometa"},Object(d.__)("Search engine optimisation","woodkit")),wp.element.createElement(Q,{name:"wkg-plugin-seometa",title:Object(d.__)("Search engine optimisation","woodkit"),className:"wkg-plugin-seometa"},wp.element.createElement(re,null)))}});var ne=function(e){function t(e){return i()(this,t),s()(this,u()(t).call(this,e))}return m()(t,e),a()(t,[{key:"render",value:function(){var e=this;return wp.element.createElement(U,null,wp.element.createElement($,{className:"wkg-plugin-panelbody"},wp.element.createElement("h4",null,Object(d.__)("Search engines","woodkit")),wp.element.createElement(ee,{className:"wkg-plugin-panelrow"},wp.element.createElement(te,{label:Object(d.__)("Title","woodkit"),value:this.props.meta_title,onChange:function(t){return e.props.on_meta_change({_seo_meta_title:t})}}),wp.element.createElement("div",{className:"wkg-info"},Object(d.__)("By default, publication title will be used.","woodkit"))),wp.element.createElement(ee,{className:"wkg-plugin-panelrow"},wp.element.createElement(te,{label:Object(d.__)("Description","woodkit"),value:this.props.meta_description,onChange:function(t){return e.props.on_meta_change({_seo_meta_description:t})}}),wp.element.createElement("div",{className:"wkg-info"},Object(d.__)("By default, publication excerpt will be used.","woodkit"))),wp.element.createElement(ee,{className:"wkg-plugin-panelrow"},wp.element.createElement(te,{label:Object(d.__)("Keywords","woodkit"),value:this.props.meta_keywords,onChange:function(t){return e.props.on_meta_change({_seo_meta_keywords:t})}}),wp.element.createElement("div",{className:"wkg-info"},Object(d.__)("Separate keywords by comma.","woodkit")))),wp.element.createElement($,{className:"wkg-plugin-panelbody"},wp.element.createElement("h4",null,Object(d.__)("Social networks","woodkit")),wp.element.createElement(ee,{className:"wkg-plugin-panelrow"},wp.element.createElement(te,{label:Object(d.__)("Titre","woodkit"),value:this.props.meta_og_title,onChange:function(t){return e.props.on_meta_change({_seo_meta_og_title:t})}}),wp.element.createElement("div",{className:"wkg-info"},Object(d.__)("By default, title set for search engines will be used.","woodkit"))),wp.element.createElement(ee,{className:"wkg-plugin-panelrow"},wp.element.createElement(te,{label:Object(d.__)("Description","woodkit"),value:this.props.meta_og_description,onChange:function(t){return e.props.on_meta_change({_seo_meta_og_description:t})}}),wp.element.createElement("div",{className:"wkg-info"},Object(d.__)("By default, description set for search engines will be used.","woodkit"))),wp.element.createElement(ee,{className:"wkg-plugin-panelrow"},wp.element.createElement(T,{show:!0,label:Object(d.__)("Image","woodkit"),value:this.props.meta_og_image&&0!==this.props.meta_og_image?this.props.meta_og_image:null,onChange:function(t){return e.props.on_meta_change({_seo_meta_og_image:t&&t.id?t.id:0})}}),wp.element.createElement("div",{className:"wkg-info"},Object(d.__)("By default, publication featured image will be used.","woodkit")))))}}]),t}(K),re=q(W((function(e){var t=e("core/editor");return{meta_title:t.getEditedPostAttribute("meta")._seo_meta_title,meta_description:t.getEditedPostAttribute("meta")._seo_meta_description,meta_keywords:t.getEditedPostAttribute("meta")._seo_meta_keywords,meta_og_title:t.getEditedPostAttribute("meta")._seo_meta_og_title,meta_og_description:t.getEditedPostAttribute("meta")._seo_meta_og_description,meta_og_image:t.getEditedPostAttribute("meta")._seo_meta_og_image}})),Y((function(e){var t=e("core/editor");return{on_meta_change:function(e){t.editPost({meta:e})}}})))(ne)}]);