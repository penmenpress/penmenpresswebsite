!function(e){var t={};function s(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,s),o.l=!0,o.exports}s.m=e,s.c=t,s.d=function(e,t,n){s.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:n})},s.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="",s(s.s=511)}({511:function(e,t,s){"use strict";!function(e){function t(e,t){jQuery.ajax({beforeSend:function(e){e.setRequestHeader("X-WP-Nonce",PM_Global_Vars.permission)},url:PM_Global_Vars.rest_url+"/pm/v2/search",data:{query:e,model:"project"},success:function(e){"function"==typeof t&&t(e)}})}function s(e){var t=null;switch(e.type){case"task":t="#/projects/"+e.project_id+"/task-lists/tasks/"+e.id;break;case"subtask":t="#/projects/"+e.project_id+"/task-lists/tasks/"+e.parent_id;break;case"project":t="#/projects/"+e.id+"/overview/";break;case"milestone":t="#/projects/"+e.project_id+"/milestones/";break;case"discussion_board":break;case"task_list":t="#/projects/"+e.project_id+"/task-lists/"+e.id;break;default:t=t}return t?PM_Global_Vars.project_page+t:t}e.widget("custom.pmautocomplete",e.ui.autocomplete,{_create:function(){this._super(),this.widget().menu("option","items","> :not(.pm-search-type)")}}),e(document).ready(function(){var n=!1,o=!1,a=!1,i=e("#pmswitchproject");function c(){i.css("display","block").addClass("active"),i.find("input").focus(),i.find("input").val("")}e(document).bind("keydown",function(e){var t=e.keyCode||e.which;17!==t&&91!==t||a?o||!n||74!==t||a?o&&n&&74===t?(e.preventDefault(),o=!1,a=!1,i.css("display","none").removeClass("active")):a=!0:(e.preventDefault(),o=!0,a=!1,c()):(n=!0,a=!1),27===t&&(o=!1,n=!1,a=!1,i.css("display","none").removeClass("active"))}),e(document).bind("keyup",function(e){var t=e.keyCode||e.which;a=!1,17!==t&&91!==t||(n=!1)}),e(document).bind("click",function(t){e(t.target).closest("#wp-admin-bar-pm_search").length||e(t.target).closest(".pmswitcharea").length||e(this).find("#pmswitchproject").hasClass("active")&&(o=!1,n=!1,a=!1,i.css("display","none").removeClass("active"))}),e("#wp-admin-bar-pm_search a").bind("click",function(e){c()});var r=[];i.find("input").pmautocomplete({autoFocus:!0,appendTo:".pm-spresult",source:function(s,n){if(e(this).removeClass("pm-open"),s.term.trim()||!r.length)if(s.term.trim()||r.length){var o=e.ui.autocomplete.escapeRegex(s.term),a=new RegExp(o,"ig"),i=e.grep(r,function(e){return a.test(e.title)});i.length&&n(i),t(s.term,function(e){r=e,n(e)})}else t("",function(e){r=e,n(e)});else n(r)},search:function(t,s){e(this).addClass("pm-sspinner")},open:function(){e(this).removeClass("pm-sspinner"),e(this).addClass("pm-open"),e(this).pmautocomplete("widget").css({"z-index":999999,position:"relative",top:0,left:0})},select:function(e,t){var n=s(t.item);n&&(location.href=n,i.css("display","none").removeClass("active"))}}).focus(function(){e(this).data("custom-pmautocomplete").search(" ")}).data("custom-pmautocomplete")._renderItem=function(t,n){return void 0!==n.no_result?e('<li class="no-result">').data("ui-autocomplete-item",n).append(n.no_result).appendTo(t):e("<li>").data("ui-autocomplete-item",n).append("<span class='icon-pm-incomplete'></span>").append("<a href='"+s(n)+"'>"+n.title+"</a>").appendTo(t)}})}(jQuery)}});