(()=>{var e={n:t=>{var a=t&&t.__esModule?()=>t.default:()=>t;return e.d(a,{a}),a},d:(t,a)=>{for(var n in a)e.o(a,n)&&!e.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:a[n]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t),r:e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}},t={};(()=>{"use strict";e.r(t);const a=flarum.core.compat["admin/app"];var n=e.n(a);n().initializers.add("datlechin/flarum-bbcode-hide-content",(function(){n().extensionData.for("datlechin-bbcode-hide-content").registerPermission({icon:"fas fa-eye-slash",label:n().translator.trans("datlechin-bbcode-hide-content.admin.permissions.bypass_like_label"),permission:"post.bypassLikeRequirement"},"view").registerPermission({icon:"fas fa-eye-slash",label:n().translator.trans("datlechin-bbcode-hide-content.admin.permissions.bypass_reply_label"),permission:"post.bypassReplyRequirement"},"view")}))})(),module.exports=t})();
//# sourceMappingURL=admin.js.map