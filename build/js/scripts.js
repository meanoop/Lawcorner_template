$("#find-a-lawyer-button").click(function(){window.location.href="/finde.html"}),$("#find-information-button").click(function(){window.location.href="/finde-info.html"}),$(".border-menu").click(function(){$(".menu ul").toggle("slow"),$(".sidebar-section").toggle(),$(".find-information #carousel-widen").toggle()}),!function(t){if("object"==typeof exports&&"undefined"!=typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var e;"undefined"!=typeof window?e=window:"undefined"!=typeof global?e=global:"undefined"!=typeof self&&(e=self),e.Slideout=t()}}(function(){return function t(e,n,i){function o(r,a){if(!n[r]){if(!e[r]){var u="function"==typeof require&&require;if(!a&&u)return u(r,!0);if(s)return s(r,!0);var l=new Error("Cannot find module '"+r+"'");throw l.code="MODULE_NOT_FOUND",l}var f=n[r]={exports:{}};e[r][0].call(f.exports,function(t){var n=e[r][1][t];return o(n?n:t)},f,f.exports,t,e,n,i)}return n[r].exports}for(var s="function"==typeof require&&require,r=0;r<i.length;r++)o(i[r]);return o}({1:[function(t,e){"use strict";function n(t){t=t||{},this._startOffsetX=0,this._currentOffsetX=0,this._opening=!1,this._moved=!1,this._opened=!1,this._preventOpen=!1,this.panel=t.panel,this.menu=t.menu,this.panel.className+=" slideout-panel",this.menu.className+=" slideout-menu",this._fx=t.fx||"ease",this._duration=parseInt(t.duration,10)||300,this._tolerance=parseInt(t.tolerance,10)||70,this._padding=parseInt(t.padding,10)||256,this._initTouchEvents()}var i,o=t("decouple"),s=!1,r=window.document,a=r.documentElement,u=window.navigator.msPointerEnabled,l={start:u?"MSPointerDown":"touchstart",move:u?"MSPointerMove":"touchmove",end:u?"MSPointerUp":"touchend"},f=function(){var t=/^(Webkit|Khtml|Moz|ms|O)(?=[A-Z])/,e=r.getElementsByTagName("script")[0].style;for(var n in e)if(t.test(n))return"-"+n.match(t)[0].toLowerCase()+"-";return"WebkitOpacity"in e?"-webkit-":"KhtmlOpacity"in e?"-khtml-":""}();n.prototype.open=function(){var t=this;return-1===a.className.search("slideout-open")&&(a.className+=" slideout-open"),this._setTransition(),this._translateXTo(this._padding),this._opened=!0,setTimeout(function(){t.panel.style.transition=t.panel.style["-webkit-transition"]=""},this._duration+50),this},n.prototype.close=function(){var t=this;return this.isOpen()||this._opening?(this._setTransition(),this._translateXTo(0),this._opened=!1,setTimeout(function(){a.className=a.className.replace(/ slideout-open/,""),t.panel.style.transition=t.panel.style["-webkit-transition"]=""},this._duration+50),this):this},n.prototype.toggle=function(){return this.isOpen()?this.close():this.open()},n.prototype.isOpen=function(){return this._opened},n.prototype._translateXTo=function(t){this._currentOffsetX=t,this.panel.style[f+"transform"]=this.panel.style.transform="translate3d("+t+"px, 0, 0)"},n.prototype._setTransition=function(){this.panel.style[f+"transition"]=this.panel.style.transition=f+"transform "+this._duration+"ms "+this._fx},n.prototype._initTouchEvents=function(){var t=this;o(r,"scroll",function(){t._moved||(clearTimeout(i),s=!0,i=setTimeout(function(){s=!1},250))}),r.addEventListener(l.move,function(e){t._moved&&e.preventDefault()}),this.panel.addEventListener(l.start,function(e){t._moved=!1,t._opening=!1,t._startOffsetX=e.touches[0].pageX,t._preventOpen=!t.isOpen()&&0!==t.menu.clientWidth}),this.panel.addEventListener("touchcancel",function(){t._moved=!1,t._opening=!1}),this.panel.addEventListener(l.end,function(){t._moved&&(t._opening&&Math.abs(t._currentOffsetX)>t._tolerance?t.open():t.close()),t._moved=!1}),this.panel.addEventListener(l.move,function(e){if(!s&&!t._preventOpen){var n=e.touches[0].clientX-t._startOffsetX,i=t._currentOffsetX=n;if(!(Math.abs(i)>t._padding)&&Math.abs(n)>20){if(t._opening=!0,t._opened&&n>0||!t._opened&&0>n)return;t._moved||-1!==a.className.search("slideout-open")||(a.className+=" slideout-open"),0>=n&&(i=n+t._padding,t._opening=!1),t.panel.style[f+"transform"]=t.panel.style.transform="translate3d("+i+"px, 0, 0)",t._moved=!0}}})},e.exports=n},{decouple:2}],2:[function(t,e){"use strict";function n(t,e,n){function o(t){a=t,s()}function s(){u||(i(r),u=!0)}function r(){n.call(t,a),u=!1}var a,u=!1;t.addEventListener(e,o,!1)}var i=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||function(t){window.setTimeout(t,1e3/60)}}();e.exports=n},{}]},{},[1])(1)});