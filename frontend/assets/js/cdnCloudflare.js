"use strict";!function(e){"object"==typeof module&&"object"==typeof module.exports?e(require("jquery"),window,document):e(jQuery,window,document)}(function(l,h,c,r){function t(e,t){this.$chartContainer=l(e),this.opts=t,this.defaultOptions={icons:{theme:"oci",parentNode:"oci-menu",expandToUp:"oci-chevron-up",collapseToDown:"oci-chevron-down",collapseToLeft:"oci-chevron-left",expandToRight:"oci-chevron-right",backToCompact:"oci-corner-top-left",backToLoose:"oci-corner-bottom-right",collapsed:"oci-plus-square",expanded:"oci-minus-square",spinner:"oci-spinner"},nodeTitle:"name",nodeId:"id",toggleSiblingsResp:!1,visibleLevel:999,chartClass:"",exportButton:!1,exportButtonName:"Export",exportFilename:"OrgChart",exportFileextension:"png",draggable:!1,direction:"t2b",pan:!1,zoom:!1,zoominLimit:7,zoomoutLimit:.5}}t.prototype={init:function(e){this.options=l.extend({},this.defaultOptions,this.opts,e);var e=this.$chartContainer,t=(this.$chart&&this.$chart.remove(),this.options.data),i=this.$chart=l("<div>",{data:{options:this.options},class:"orgchart"+(""!==this.options.chartClass?" "+this.options.chartClass:"")+("t2b"!==this.options.direction?" "+this.options.direction:""),click:function(e){l(e.target).closest(".node").length||i.find(".node.focused").removeClass("focused")}}),s=("undefined"!=typeof MutationObserver&&this.triggerInitEvent(),i.append(l('<ul class="nodes"><li class="hierarchy"></li></ul>')).find(".hierarchy"));return t instanceof l?this.buildHierarchy(s,this.buildJsonDS(t.children()),0,this.options):t.relationship?this.buildHierarchy(s,t):this.buildHierarchy(s,this.attachRel(t,"00")),e.append(i),this.options.exportButton&&!l(".oc-export-btn").length&&this.attachExportButton(),this.options.pan&&this.bindPan(),this.options.zoom&&this.bindZoom(),this},handleCompactNodes:function(){this.$chart.find(".node.compact").each((e,t)=>{l(t).addClass(l(t).parents(".compact").length%2==0?"even":"odd")})},triggerInitEvent:function(){var n=this,o=new MutationObserver(function(e){o.disconnect();e:for(var t=0;t<e.length;t++)for(var i=0;i<e[t].addedNodes.length;i++)if(e[t].addedNodes[i].classList.contains("orgchart")){n.handleCompactNodes(),n.options.initCompleted&&"function"==typeof n.options.initCompleted&&n.options.initCompleted(n.$chart);var s=l.Event("init.orgchart");n.$chart.trigger(s);break e}});o.observe(this.$chartContainer[0],{childList:!0})},triggerShowEvent:function(e,t){t=l.Event("show-"+t+".orgchart");e.trigger(t)},triggerHideEvent:function(e,t){t=l.Event("hide-"+t+".orgchart");e.trigger(t)},attachExportButton:function(){var t=this,e=l("<button>",{class:"oc-export-btn",text:this.options.exportButtonName,click:function(e){e.preventDefault(),t.export()}});this.$chartContainer.after(e)},setOptions:function(e,t){return"string"==typeof e&&("pan"===e&&(t?this.bindPan():this.unbindPan()),"zoom"===e)&&(t?this.bindZoom():this.unbindZoom()),"object"==typeof e&&(e.data?this.init(e):(void 0!==e.pan&&(e.pan?this.bindPan():this.unbindPan()),void 0!==e.zoom&&(e.zoom?this.bindZoom():this.unbindZoom()))),this},panStartHandler:function(e){var n=l(e.delegateTarget);if(l(e.target).closest(".node").length||e.touches&&1<e.touches.length)n.data("panning",!1);else{n.css("cursor","move").data("panning",!0);var t,i=0,s=0,o=n.css("transform"),a=("none"!==o&&(t=o.split(","),s=-1===o.indexOf("3d")?(i=parseInt(t[4]),parseInt(t[5])):(i=parseInt(t[12]),parseInt(t[13]))),0),d=0;if(e.targetTouches){if(1===e.targetTouches.length)a=e.targetTouches[0].pageX-i,d=e.targetTouches[0].pageY-s;else if(1<e.targetTouches.length)return}else a=e.pageX-i,d=e.pageY-s;n.on("mousemove touchmove",function(e){if(n.data("panning")){var t=0,i=0;if(e.targetTouches){if(1===e.targetTouches.length)t=e.targetTouches[0].pageX-a,i=e.targetTouches[0].pageY-d;else if(1<e.targetTouches.length)return}else t=e.pageX-a,i=e.pageY-d;var s,e=n.css("transform");"none"===e?-1===e.indexOf("3d")?n.css("transform","matrix(1, 0, 0, 1, "+t+", "+i+")"):n.css("transform","matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, "+t+", "+i+", 0, 1)"):(s=e.split(","),-1===e.indexOf("3d")?(s[4]=" "+t,s[5]=" "+i+")"):(s[12]=" "+t,s[13]=" "+i),n.css("transform",s.join(",")))}})}},panEndHandler:function(e){e.data.chart.data("panning")&&e.data.chart.data("panning",!1).css("cursor","default").off("mousemove")},bindPan:function(){this.$chartContainer.css("overflow","hidden"),this.$chart.on("mousedown touchstart",this.panStartHandler),l(c).on("mouseup touchend",{chart:this.$chart},this.panEndHandler)},unbindPan:function(){this.$chartContainer.css("overflow","auto"),this.$chart.off("mousedown touchstart",this.panStartHandler),l(c).off("mouseup touchend",this.panEndHandler)},zoomWheelHandler:function(e){var t=e.data.oc,e=(e.preventDefault(),1+(0<e.originalEvent.deltaY?-.2:.2));t.setChartScale(t.$chart,e)},zoomStartHandler:function(e){var t;e.touches&&2===e.touches.length&&((t=e.data.oc).$chart.data("pinching",!0),e=t.getPinchDist(e),t.$chart.data("pinchDistStart",e))},zoomingHandler:function(e){var t=e.data.oc;t.$chart.data("pinching")&&(e=t.getPinchDist(e),t.$chart.data("pinchDistEnd",e))},zoomEndHandler:function(e){var t,e=e.data.oc;e.$chart.data("pinching")&&(e.$chart.data("pinching",!1),0<(t=e.$chart.data("pinchDistEnd")-e.$chart.data("pinchDistStart"))?e.setChartScale(e.$chart,1.2):t<0&&e.setChartScale(e.$chart,.8))},bindZoom:function(){this.$chartContainer.on("wheel",{oc:this},this.zoomWheelHandler),this.$chartContainer.on("touchstart",{oc:this},this.zoomStartHandler),l(c).on("touchmove",{oc:this},this.zoomingHandler),l(c).on("touchend",{oc:this},this.zoomEndHandler)},unbindZoom:function(){this.$chartContainer.off("wheel",this.zoomWheelHandler),this.$chartContainer.off("touchstart",this.zoomStartHandler),l(c).off("touchmove",this.zoomingHandler),l(c).off("touchend",this.zoomEndHandler)},getPinchDist:function(e){return Math.sqrt((e.touches[0].clientX-e.touches[1].clientX)*(e.touches[0].clientX-e.touches[1].clientX)+(e.touches[0].clientY-e.touches[1].clientY)*(e.touches[0].clientY-e.touches[1].clientY))},setChartScale:function(e,t){var i,s=e.data("options"),n=e.css("transform"),o=1;"none"===n?e.css("transform","scale("+t+","+t+")"):(i=n.split(","),-1===n.indexOf("3d")?(o=Math.abs(h.parseFloat(i[3])*t))>s.zoomoutLimit&&o<s.zoominLimit&&e.css("transform",n+" scale("+t+","+t+")"):(o=Math.abs(h.parseFloat(i[1])*t))>s.zoomoutLimit&&o<s.zoominLimit&&e.css("transform",n+" scale3d("+t+","+t+", 1)"))},buildJsonDS:function(e){var t=this,i={name:e.contents().eq(0).text().trim(),relationship:(e.parent().parent().is("li")?"1":"0")+(e.siblings("li").length?1:0)+(e.children("ul").length?1:0)};return l.each(e.data(),function(e,t){i[e]=t}),e.children("ul").children().each(function(){i.children||(i.children=[]),i.children.push(t.buildJsonDS(l(this)))}),i},attachRel:function(t,e){var i=this;return t.relationship=e+(t.children&&0<t.children.length?1:0),this.options?.compact?.constructor===Function&&this.options.compact(t)&&(t.compact=!0),t.children&&t.children.forEach(function(e){t.hybrid||t.vertical?e.vertical=!0:t.compact&&e.children?e.compact=!0:t.compact&&!e.children&&(e.associatedCompact=!0),i.attachRel(e,"1"+(1<t.children.length?1:0))}),t},loopChart:function(e,t){t=null!==t&&t!==r&&t;var i=this,e=e.find(".node:first"),s={id:e[0].id};return t&&l.each(e.data("nodeData"),function(e,t){s[e]=t}),e.siblings(".nodes").children().each(function(){s.children||(s.children=[]),s.children.push(i.loopChart(l(this),t))}),s},getHierarchy:function(e){var t;return e=null!==e&&e!==r&&e,void 0===this.$chart?"Error: orgchart does not exist":this.$chart.find(".node").length?(t=!0,this.$chart.find(".node").each(function(){if(!this.id)return t=!1}),t?this.loopChart(this.$chart,e):"Error: All nodes of orghcart to be exported must have data-id attribute!"):"Error: nodes do not exist"},getNodeState:function(e,t){var i={},s=!!e.closest("vertical").length;if("parent"===(t=t||"self")){if(s?(i=e.closest("ul").parents("ul")).length||(i=e.closest(".nodes")).length||(i=e.closest(".vertical").siblings(":first")):i=e.closest(".nodes").siblings(".node"),i.length)return i.is(".hidden")||!i.is(".hidden")&&i.closest(".nodes").is(".hidden")||!i.is(".hidden")&&i.closest(".vertical").is(".hidden")?{exist:!0,visible:!1}:{exist:!0,visible:!0}}else if("children"===t){if((i=s?e.parent().children("ul"):e.siblings(".nodes")).length)return i.is(".hidden")?{exist:!0,visible:!1}:{exist:!0,visible:!0}}else if("siblings"===t){if((i=s?e.closest("ul"):e.parent().siblings()).length&&(!s||1<i.children("li").length))return i.is(".hidden")||i.parent().is(".hidden")||s&&i.closest(".vertical").is(".hidden")?{exist:!0,visible:!1}:{exist:!0,visible:!0}}else if((i=e).length)return i.closest(".nodes").length&&i.closest(".nodes").is(".hidden")||i.closest(".hierarchy").length&&i.closest(".hierarchy").is(".hidden")||i.closest(".vertical").length&&(i.closest(".nodes").is(".hidden")||i.closest(".vertical").is(".hidden"))?{exist:!0,visible:!1}:{exist:!0,visible:!0};return{exist:!1,visible:!1}},getParent:function(e){return this.getRelatedNodes(e,"parent")},getChildren:function(e){return this.getRelatedNodes(e,"children")},getSiblings:function(e){return this.getRelatedNodes(e,"siblings")},getRelatedNodes:function(e,t){return e&&e instanceof l&&e.is(".node")?"parent"===t?e.closest(".nodes").siblings(".node"):"children"===t?e.siblings(".nodes").children(".hierarchy").find(".node:first"):"siblings"===t?e.closest(".hierarchy").siblings().find(".node:first"):l():l()},hideParentEnd:function(e){l(e.target).removeClass("sliding"),e.data.parent.addClass("hidden")},hideParent:function(e){var t=e.closest(".nodes").siblings(".node");t.find(".spinner").length&&e.closest(".orgchart").data("inAjax",!1),this.getNodeState(e,"siblings").visible&&this.hideSiblings(e),e.parent().addClass("isAncestorsCollapsed"),this.getNodeState(t).visible&&t.addClass("sliding slide-down").one("transitionend",{parent:t},this.hideParentEnd),this.getNodeState(t,"parent").visible&&this.hideParent(t)},showParentEnd:function(e){var t=e.data.node;l(e.target).removeClass("sliding"),this.isInAction(t)&&this.switchVerticalArrow(t.children(".topEdge"))},showParent:function(e){var t=e.closest(".nodes").siblings(".node").removeClass("hidden");e.closest(".hierarchy").removeClass("isAncestorsCollapsed"),this.repaint(t[0]),t.addClass("sliding").removeClass("slide-down").one("transitionend",{node:e},this.showParentEnd.bind(this))},stopAjax:function(e){e.find(".spinner").length&&e.closest(".orgchart").data("inAjax",!1)},isVisibleNode:function(e,t){return this.getNodeState(l(t)).visible},isCompactDescendant:function(e,t){return l(t).parent().is(".node.compact")},hideChildrenEnd:function(e){var t=e.data.node;e.data.animatedNodes.removeClass("sliding"),e.data.animatedNodes.closest(".nodes").addClass("hidden"),this.isInAction(t)&&this.switchVerticalArrow(t.children(".bottomEdge"))},hideChildren:function(e){e.closest(".hierarchy").addClass("isChildrenCollapsed");var t=e.siblings(".nodes"),i=(this.stopAjax(t),t.find(".node").filter(this.isVisibleNode.bind(this)).not(this.isCompactDescendant.bind(this)));t.is(".vertical")||i.closest(".hierarchy").addClass("isCollapsedDescendant"),(t.is(".vertical")||t.find(".vertical").length)&&i.find(this.options.icons.expanded).removeClass(this.options.icons.expanded).addClass(this.options.icons.collapsed),this.repaint(i.get(0)),i.addClass("sliding slide-up").eq(0).one("transitionend",{animatedNodes:i,lowerLevel:t,node:e},this.hideChildrenEnd.bind(this))},showChildrenEnd:function(e){var t=e.data.node;e.data.animatedNodes.removeClass("sliding"),this.isInAction(t)&&this.switchVerticalArrow(t.children(".bottomEdge"))},showChildren:function(e){e.closest(".hierarchy").removeClass("isChildrenCollapsed");var t=e.siblings(".nodes"),i=t.is(".vertical"),t=(i?t.removeClass("hidden").find(".node"):t.removeClass("hidden").children(".hierarchy").find(".node:first")).filter(this.isVisibleNode.bind(this));i||(t.filter(":not(:only-child)").closest(".hierarchy").addClass("isChildrenCollapsed"),t.closest(".hierarchy").removeClass("isCollapsedDescendant")),this.repaint(t.get(0)),t.addClass("sliding").removeClass("slide-up").eq(0).one("transitionend",{node:e,animatedNodes:t},this.showChildrenEnd.bind(this))},hideSiblingsEnd:function(e){var t=this,i=e.data.node,s=e.data.nodeContainer,n=e.data.direction,n=n?"left"===n?s.prevAll(":not(.hidden)"):s.nextAll(":not(.hidden)"):s.siblings();e.data.animatedNodes.removeClass("sliding"),n.find(".node:gt(0)").filter(this.isVisibleNode.bind(this)).removeClass("slide-left slide-right").addClass(function(){return t.options.compact?"":"slide-up"}),n.find(".nodes, .vertical").addClass("hidden").end().addClass("hidden"),this.isInAction(i)&&this.switchHorizontalArrow(i)},hideSiblings:function(e,t){var i=e.closest(".hierarchy").addClass("isSiblingsCollapsed"),s=(i.siblings().find(".spinner").length&&e.closest(".orgchart").data("inAjax",!1),t?"left"===t?i.addClass("left-sibs").prevAll(".isSiblingsCollapsed").removeClass("isSiblingsCollapsed left-sibs").end().prevAll().addClass("isCollapsedSibling isChildrenCollapsed").find(".node").filter(this.isVisibleNode.bind(this)).addClass("sliding slide-right"):i.addClass("right-sibs").nextAll(".isSiblingsCollapsed").removeClass("isSiblingsCollapsed right-sibs").end().nextAll().addClass("isCollapsedSibling isChildrenCollapsed").find(".node").filter(this.isVisibleNode.bind(this)).addClass("sliding slide-left"):(i.prevAll().find(".node").filter(this.isVisibleNode.bind(this)).addClass("sliding slide-right"),i.nextAll().find(".node").filter(this.isVisibleNode.bind(this)).addClass("sliding slide-left"),i.siblings().addClass("isCollapsedSibling isChildrenCollapsed")),i.siblings().find(".sliding"));s.eq(0).one("transitionend",{node:e,nodeContainer:i,direction:t,animatedNodes:s},this.hideSiblingsEnd.bind(this))},showSiblingsEnd:function(e){var t=e.data.node;e.data.visibleNodes.removeClass("sliding"),this.isInAction(t)&&(this.switchHorizontalArrow(t),t.children(".topEdge").removeClass(this.options.icons.expandToUp).addClass(this.options.icons.collapseToDown))},showRelatedParentEnd:function(e){l(e.target).removeClass("sliding")},showSiblings:function(e,t){var i=l(),s=e.closest(".hierarchy"),i=(t?"left"===t?s.prevAll():s.nextAll():e.closest(".hierarchy").siblings()).removeClass("hidden"),n=e.closest(".nodes").siblings(".node"),s=(t?(s.removeClass(t+"-sibs"),s.is("[class*=-sibs]")||s.removeClass("isSiblingsCollapsed"),i.removeClass("isCollapsedSibling "+t+"-sibs")):(e.closest(".hierarchy").removeClass("isSiblingsCollapsed"),i.removeClass("isCollapsedSibling")),this.getNodeState(e,"parent").visible||(e.closest(".hierarchy").removeClass("isAncestorsCollapsed"),n.removeClass("hidden"),this.repaint(n[0]),n.addClass("sliding").removeClass("slide-down").one("transitionend",this.showRelatedParentEnd)),i.find(".node").filter(this.isVisibleNode.bind(this)));this.repaint(s.get(0)),s.addClass("sliding").removeClass("slide-left slide-right"),s.eq(0).one("transitionend",{node:e,visibleNodes:s},this.showSiblingsEnd.bind(this))},startLoading:function(e){var t=this.$chart;return(void 0===t.data("inAjax")||!0!==t.data("inAjax"))&&(e.addClass("hidden"),e.parent().append(`<i class="${this.options.icons.theme} ${this.options.icons.spinner} spinner"></i>`).children().not(".spinner").css("opacity",.2),t.data("inAjax",!0),l(".oc-export-btn").prop("disabled",!0),!0)},endLoading:function(e){var t=e.parent();e.removeClass("hidden"),t.find(".spinner").remove(),t.children().removeAttr("style"),this.$chart.data("inAjax",!1),l(".oc-export-btn").prop("disabled",!1)},isInAction:function(t){return[this.options.icons.expandToUp,this.options.icons.collapseToDown,this.options.icons.collapseToLeft,this.options.icons.expandToRight].some(e=>-1<t.children(".edge").attr("class").indexOf(e))},switchVerticalArrow:function(e){e.toggleClass(this.options.icons.expandToUp+" "+this.options.icons.collapseToDown)},switchHorizontalArrow:function(e){var t,i=this.options;i.toggleSiblingsResp&&(void 0===i.ajaxURL||e.closest(".nodes").data("siblingsLoaded"))?((t=e.parent().prev()).length&&(t.is(".hidden")?e.children(".leftEdge").addClass(i.icons.collapseToLeft).removeClass(i.icons.expandToRight):e.children(".leftEdge").addClass(i.icons.expandToRight).removeClass(i.icons.collapseToLeft)),(t=e.parent().next()).length&&(t.is(".hidden")?e.children(".rightEdge").addClass(i.icons.expandToRight).removeClass(i.icons.collapseToLeft):e.children(".rightEdge").addClass(i.icons.collapseToLeft).removeClass(i.icons.expandToRight))):(t=!!(t=e.parent().siblings()).length&&!t.is(".hidden"),e.children(".leftEdge").toggleClass(i.icons.expandToRight,t).toggleClass(i.icons.collapseToLeft,!t),e.children(".rightEdge").toggleClass(i.icons.collapseToLeft,t).toggleClass(i.icons.expandToRight,!t))},repaint:function(e){e&&(e.style.offsetWidth=e.offsetWidth)},nodeEnterLeaveHandler:function(e){var t,i,s,n=l(e.delegateTarget),o=!1;n.closest(".nodes.vertical").length?(t=n.children(".toggleBtn"),"mouseenter"===e.type?n.children(".toggleBtn").length&&(o=this.getNodeState(n,"children").visible,t.toggleClass(this.options.icons.collapsed,!o).toggleClass(this.options.icons.expanded,o)):t.removeClass(this.options.icons.collapsed+" "+this.options.icons.expanded)):(t=n.children(".topEdge"),n.children(".rightEdge"),i=n.children(".bottomEdge"),s=n.children(".leftEdge"),"mouseenter"===e.type?(t.length&&(o=this.getNodeState(n,"parent").visible,t.toggleClass(this.options.icons.expandToUp,!o).toggleClass(this.options.icons.collapseToDown,o)),i.length&&(o=this.getNodeState(n,"children").visible,i.toggleClass(this.options.icons.collapseToDown,!o).toggleClass(this.options.icons.expandToUp,o)),s.length&&this.switchHorizontalArrow(n)):n.children(".edge").removeClass(`${this.options.icons.expandToUp} ${this.options.icons.collapseToDown} ${this.options.icons.collapseToLeft} `+this.options.icons.expandToRight))},nodeClickHandler:function(e){this.$chart.find(".focused").removeClass("focused"),l(e.delegateTarget).addClass("focused")},addAncestors:function(e,t){var i=this.$chart.children(".nodes").children(".hierarchy");this.buildHierarchy(i,e),i.children().slice(0,2).wrapAll('<li class="hierarchy"></li>').parent().appendTo(l("#"+t).siblings(".nodes"))},addDescendants:function(e,t){var i=this,s=l('<ul class="nodes"></ul>');t.after(s),l.each(e,function(e){s.append(l('<li class="hierarchy"></li>')),i.buildHierarchy(s.children().eq(e),this)})},HideFirstParentEnd:function(e){var e=e.data.topEdge,t=e.parent();this.isInAction(t)&&(this.switchVerticalArrow(e),this.switchHorizontalArrow(t))},topEdgeClickHandler:function(e){var t,i=l(e.target),e=l(e.delegateTarget),s=this.getNodeState(e,"parent");s.exist&&!(t=e.closest(".nodes").siblings(".node")).is(".sliding")&&(s.visible?(this.hideParent(e),t.one("transitionend",{topEdge:i},this.HideFirstParentEnd.bind(this)),this.triggerHideEvent(e,"parent")):(this.showParent(e),this.triggerShowEvent(e,"parent")))},bottomEdgeClickHandler:function(e){l(e.target);var e=l(e.delegateTarget),t=this.getNodeState(e,"children");t.exist&&!e.siblings(".nodes").children().children(".node").is(".sliding")&&(t.visible?(this.hideChildren(e),this.triggerHideEvent(e,"children")):(this.showChildren(e),this.triggerShowEvent(e,"children")))},hEdgeClickHandler:function(e){var t,i=l(e.target),e=l(e.delegateTarget),s=this.options,n=this.getNodeState(e,"siblings");n.exist&&!e.closest(".hierarchy").siblings().find(".sliding").length&&(s.toggleSiblingsResp?(s=e.closest(".hierarchy").prev(),t=e.closest(".hierarchy").next(),i.is(".leftEdge")?s.is(".hidden")?(this.showSiblings(e,"left"),this.triggerShowEvent(e,"siblings")):(this.hideSiblings(e,"left"),this.triggerHideEvent(e,"siblings")):t.is(".hidden")?(this.showSiblings(e,"right"),this.triggerShowEvent(e,"siblings")):(this.hideSiblings(e,"right"),this.triggerHideEvent(e,"siblings"))):n.visible?(this.hideSiblings(e),this.triggerHideEvent(e,"siblings")):(this.showSiblings(e),this.triggerShowEvent(e,"siblings")))},backToCompactHandler:function(e){l(e.delegateTarget).removeClass("looseMode").find(".looseMode").removeClass("looseMode").children(".backToCompactSymbol").addClass("hidden").end().children(".backToLooseSymbol").removeClass("hidden"),l(e.delegateTarget).children(".backToCompactSymbol").addClass("hidden").end().children(".backToLooseSymbol").removeClass("hidden")},backToLooseHandler:function(e){l(e.delegateTarget).addClass("looseMode").children(".backToLooseSymbol").addClass("hidden").end().children(".backToCompactSymbol").removeClass("hidden")},expandVNodesEnd:function(e){e.data.vNodes.removeClass("sliding")},collapseVNodesEnd:function(e){e.data.vNodes.removeClass("sliding").closest("ul").addClass("hidden")},toggleVNodes:function(e){var e=l(e.target),t=e.parent().next(),i=t.find(".node"),s=t.children().children(".node");s.is(".sliding")||(e.toggleClass(this.options.icons.collapsed+" "+this.options.icons.expanded),i.eq(0).is(".slide-up")?(t.removeClass("hidden"),this.repaint(s.get(0)),s.addClass("sliding").removeClass("slide-up").eq(0).one("transitionend",{vNodes:s},this.expandVNodesEnd)):(i.addClass("sliding slide-up").eq(0).one("transitionend",{vNodes:i},this.collapseVNodesEnd),i.find(".toggleBtn").removeClass(this.options.icons.collapsed+" "+this.options.icons.expanded)))},createGhostNode:function(e){var t,i,s=l(e.target),n=this.options,e=e.originalEvent,o=/firefox/.test(h.navigator.userAgent.toLowerCase());if(c.querySelector(".ghost-node"))t=s.closest(".orgchart").children(".ghost-node").get(0),i=l(t).children().get(0);else{if(!(t=c.createElementNS("http://www.w3.org/2000/svg","svg")).classList)return;t.classList.add("ghost-node"),i=c.createElementNS("http://www.w3.org/2000/svg","rect"),t.appendChild(i),s.closest(".orgchart").append(t)}var a=s.closest(".orgchart").css("transform").split(","),d="t2b"===n.direction||"b2t"===n.direction,a=Math.abs(h.parseFloat(d?a[0].slice(a[0].indexOf("(")+1):a[1])),d=(t.setAttribute("width",d?s.outerWidth(!1):s.outerHeight(!1)),t.setAttribute("height",d?s.outerHeight(!1):s.outerWidth(!1)),i.setAttribute("x",5*a),i.setAttribute("y",5*a),i.setAttribute("width",120*a),i.setAttribute("height",40*a),i.setAttribute("rx",4*a),i.setAttribute("ry",4*a),i.setAttribute("stroke-width",+a),e.offsetX*a),r=e.offsetY*a;"l2r"===n.direction?(d=e.offsetY*a,r=e.offsetX*a):"r2l"===n.direction?(d=s.outerWidth(!1)-e.offsetY*a,r=e.offsetX*a):"b2t"===n.direction&&(d=s.outerWidth(!1)-e.offsetX*a,r=s.outerHeight(!1)-e.offsetY*a),o?(i.setAttribute("fill","rgb(255, 255, 255)"),i.setAttribute("stroke","rgb(191, 0, 0)"),(n=c.createElement("img")).src="data:image/svg+xml;utf8,"+(new XMLSerializer).serializeToString(t),e.dataTransfer.setDragImage(n,d,r)):e.dataTransfer.setDragImage&&e.dataTransfer.setDragImage(t,d,r)},getUpperLevel:function(e){return e.is(".node")?e.parents(".hierarchy").length:0},getLowerLevel:function(e){return e.is(".node")?e.closest(".hierarchy").find(".nodes").length+1:0},getLevelOrderNodes:function(e){if(!e)return[];var t=[],i=[];for(t.push(e);t.length;){for(var s=[],n=0;n<t.length;n++){var o=t.shift(),a=this.getChildren(o);a.length&&t.push(a.toArray().flat()),s.push(l(o))}i.push(s)}return i},filterAllowedDropNodes:function(i){var s=this.options,n=i.closest("[draggable]").hasClass("node"),o=i.closest(".nodes").siblings(".node"),a=i.closest(".hierarchy").find(".node");this.$chart.data("dragged",i).find(".node").each(function(e,t){n&&-1!==a.index(t)||s.dropCriteria&&!s.dropCriteria(i,o,l(t))||l(t).addClass("allowedDrop")})},dragstartHandler:function(e){e.originalEvent.dataTransfer.setData("text/html","hack for firefox"),"none"!==this.$chart.css("transform")&&this.createGhostNode(e),this.filterAllowedDropNodes(l(e.target))},dragoverHandler:function(e){l(e.delegateTarget).is(".allowedDrop")?e.preventDefault():e.originalEvent.dataTransfer.dropEffect="none"},dragendHandler:function(e){this.$chart.find(".allowedDrop").removeClass("allowedDrop")},dropHandler:async function(e){var t,i,s,n,o,e=l(e.delegateTarget),a=this.$chart.data("dragged");a.hasClass("node")?e.hasClass("allowedDrop")&&(t=a.closest(".nodes").siblings(".node"),i=l.Event("nodedrop.orgchart"),this.$chart.trigger(i,{draggedNode:a,dragZone:t,dropZone:e}),i.isDefaultPrevented()||(i=this.$chart.data("options").data,o=(n=new JSONDigger(i,this.$chart.data("options").nodeId,"children")).findOneNode({hybrid:!0}),1<this.$chart.data("options").verticalLevel||o?(o=n.findNodeById(a.data("nodeData").id),s=Object.assign({},o),n.removeNode(o.id),(o=n.findNodeById(e.data("nodeData").id)).children?o.children.push(s):o.children=[s],this.init({data:i})):(e.siblings(".nodes").length?(n=`<i class="edge horizontalEdge rightEdge ${this.options.icons.theme}"></i><i class="edge horizontalEdge leftEdge ${this.options.icons.theme}"></i>`,a.find(".horizontalEdge").length||a.append(n),e.siblings(".nodes").append(a.closest(".hierarchy")),1===(o=a.closest(".hierarchy").siblings().find(".node:first")).length&&o.append(n)):(e.append(`<i class="edge verticalEdge bottomEdge ${this.options.icons.theme}"></i>`).after('<ul class="nodes"></ul>').siblings(".nodes").append(a.find(".horizontalEdge").remove().end().closest(".hierarchy")),e.children(".title").length&&e.children(".title").prepend(`<i class="${this.options.icons.theme} ${this.$chart.data("options").icons.parentNode} parentNodeSymbol"></i>`)),1===t.siblings(".nodes").children(".hierarchy").length?t.siblings(".nodes").children(".hierarchy").find(".node:first").find(".horizontalEdge").remove():0===t.siblings(".nodes").children(".hierarchy").length&&t.find(".bottomEdge, .parentNodeSymbol").remove().end().siblings(".nodes").remove()))):this.$chart.triggerHandler({type:"otherdropped.orgchart",draggedItem:a,dropZone:e})},touchstartHandler:function(e){this.touchHandled||e.touches&&1<e.touches.length||(this.touchHandled=!0,this.touchMoved=!1,e.preventDefault())},touchmoveHandler:function(e){var t;!this.touchHandled||e.touches&&1<e.touches.length||(e.preventDefault(),this.touchMoved||(this.filterAllowedDropNodes(l(e.currentTarget)),this.touchDragImage=this.createDragImage(e,this.$chart.data("dragged")[0])),this.touchMoved=!0,this.moveDragImage(e,this.touchDragImage),0<(e=l(c.elementFromPoint(e.touches[0].clientX,e.touches[0].clientY)).closest("div.node")).length&&(t=e[0],e.is(".allowedDrop"))?this.touchTargetNode=t:this.touchTargetNode=null)},touchendHandler:function(e){var t,i;this.touchHandled&&(this.destroyDragImage(),this.touchMoved?(this.touchTargetNode&&(t={delegateTarget:this.touchTargetNode},this.dropHandler(t),this.touchTargetNode=null),this.dragendHandler(e)):(t=e.changedTouches[0],(i=c.createEvent("MouseEvents")).initMouseEvent("click",!0,!0,h,1,t.screenX,t.screenY,t.clientX,t.clientY,e.ctrlKey,e.altKey,e.shiftKey,e.metaKey,0,null),e.target.dispatchEvent(i)),this.touchHandled=!1)},createDragImage:function(e,t){var i=t.cloneNode(!0),t=(this.copyStyle(t,i),i.style.top=i.style.left="-9999px",t.getBoundingClientRect()),e=this.getTouchPoint(e);return this.touchDragImageOffset={x:e.x-t.left,y:e.y-t.top},i.style.opacity="0.5",c.body.appendChild(i),i},destroyDragImage:function(){this.touchDragImage&&this.touchDragImage.parentElement&&this.touchDragImage.parentElement.removeChild(this.touchDragImage),this.touchDragImageOffset=null,this.touchDragImage=null},copyStyle:function(e,t){["id","class","style","draggable"].forEach(function(e){t.removeAttribute(e)}),e instanceof HTMLCanvasElement&&((s=t).width=(i=e).width,s.height=i.height,s.getContext("2d").drawImage(i,0,0));for(var i,s,n=getComputedStyle(e),o=0;o<n.length;o++){var a=n[o];a.indexOf("transition")<0&&(t.style[a]=n[a])}t.style.pointerEvents="none";for(o=0;o<e.children.length;o++)this.copyStyle(e.children[o],t.children[o])},getTouchPoint:function(e){return{x:(e=e&&e.touches?e.touches[0]:e).clientX,y:e.clientY}},moveDragImage:function(i,s){var n;i&&s&&(n=this,requestAnimationFrame(function(){var e=n.getTouchPoint(i),t=s.style;t.position="absolute",t.pointerEvents="none",t.zIndex="999999",n.touchDragImageOffset&&(t.left=Math.round(e.x-n.touchDragImageOffset.x)+"px",t.top=Math.round(e.y-n.touchDragImageOffset.y)+"px")}))},bindDragDrop:function(e){e.on("dragstart",this.dragstartHandler.bind(this)).on("dragover",this.dragoverHandler.bind(this)).on("dragend",this.dragendHandler.bind(this)).on("drop",this.dropHandler.bind(this)).on("touchstart",this.touchstartHandler.bind(this)).on("touchmove",this.touchmoveHandler.bind(this)).on("touchend",this.touchendHandler.bind(this))},createNode:function(i){var s=this.options,e=i.level,t=(i.children&&i[s.nodeId]&&l.each(i.children,function(e,t){t.parentId=i[s.nodeId]}),l("<div"+(s.draggable?' draggable="true"':"")+(i[s.nodeId]?' id="'+i[s.nodeId]+'"':"")+(i.parentId?' data-parent="'+i.parentId+'"':"")+">").addClass("node "+(i.className||"")+(e>s.visibleLevel?" slide-up":""))),n=(s.nodeTemplate?t.append(s.nodeTemplate(i)):t.append('<div class="title">'+i[s.nodeTitle]+"</div>").append(void 0!==s.nodeContent?'<div class="content">'+(i[s.nodeContent]||"")+"</div>":""),l.extend({},i)),n=(delete n.children,t.data("nodeData",n),i.relationship||"");return s.verticalLevel&&e>=s.verticalLevel||i.vertical?Number(n.substr(2,1))&&t.append(`<i class="toggleBtn ${s.icons.theme}"></i>`).children(".title").prepend(`<i class="${s.icons.theme} ${s.icons.parentNode} parentNodeSymbol"></i>`):i.hybrid?Number(n.substr(2,1))&&t.append(`<i class="edge verticalEdge bottomEdge ${s.icons.theme}"></i>`).children(".title").prepend(`<i class="${s.icons.theme} ${s.icons.parentNode} parentNodeSymbol"></i>`):i.compact?(t.css("grid-template-columns",`repeat(${Math.floor(Math.sqrt(i.children.length+1))}, auto)`),Number(n.substr(2,1))&&t.append(`
            <i class="${s.icons.theme} ${s.icons.backToCompact} backToCompactSymbol hidden"></i>
            <i class="${s.icons.theme} ${s.icons.backToLoose} backToLooseSymbol"></i>
            `).children(".title").prepend(`<i class="${s.icons.theme} ${s.icons.parentNode} parentNodeSymbol"></i>`)):i.associatedCompact||(Number(n.substr(0,1))&&t.append(`<i class="edge verticalEdge topEdge ${s.icons.theme}"></i>`),Number(n.substr(1,1))&&t.append(`<i class="edge horizontalEdge rightEdge ${s.icons.theme}"></i><i class="edge horizontalEdge leftEdge ${s.icons.theme}"></i>`),Number(n.substr(2,1))&&t.append(`<i class="edge verticalEdge bottomEdge ${s.icons.theme}"></i>`).children(".title").prepend(`<i class="${s.icons.theme} ${s.icons.parentNode} parentNodeSymbol"></i>`)),t.on("mouseenter mouseleave",this.nodeEnterLeaveHandler.bind(this)),t.on("click",this.nodeClickHandler.bind(this)),t.on("click",".topEdge",this.topEdgeClickHandler.bind(this)),t.on("click",".bottomEdge",this.bottomEdgeClickHandler.bind(this)),t.on("click",".leftEdge, .rightEdge",this.hEdgeClickHandler.bind(this)),t.on("click",".toggleBtn",this.toggleVNodes.bind(this)),t.on("click","> .backToCompactSymbol",this.backToCompactHandler.bind(this)),t.on("click","> .backToLooseSymbol",this.backToLooseHandler.bind(this)),s.draggable&&(this.bindDragDrop(t),this.touchHandled=!1,this.touchMoved=!1,this.touchTargetNode=null),s.createNode&&s.createNode(t,i),t},buildHierarchy:function(e,t){var i,s,n,o=this,a=this.options,d=0,d=t.level||(t.level=e.parentsUntil(".orgchart",".nodes").length);2<Object.keys(t).length&&(i=this.createNode(t),e.append(i)),t.children&&t.children.length&&(s=d+1>a.visibleLevel||t.collapsed!==r&&t.collapsed,a.verticalLevel&&d+1>=a.verticalLevel||t.hybrid?(n=l('<ul class="nodes">'),s&&a.verticalLevel&&d+1>=a.verticalLevel&&n.addClass("hidden"),(a.verticalLevel&&d+1===a.verticalLevel||t.hybrid)&&!e.closest(".vertical").length?e.append(n.addClass("vertical")):e.append(n)):t.compact?i.addClass("compact"):(n=l('<ul class="nodes'+(s?" hidden":"")+'">'),2!==Object.keys(t).length&&s&&e.addClass("isChildrenCollapsed"),e.append(n)),l.each(t.children,function(){var e;this.level=d+1,t.compact?o.buildHierarchy(i,this):(e=l('<li class="hierarchy">'),n.append(e),o.buildHierarchy(e,this))}))},buildChildNode:function(e,t){this.buildHierarchy(e,{children:t})},addChildren:function(e,t){this.buildChildNode(e.closest(".hierarchy"),t),e.find(".parentNodeSymbol").length||e.children(".title").prepend(`<i class="${this.options.icons.theme} ${this.options.icons.parentNode} parentNodeSymbol"></i>`),e.closest(".nodes.vertical").length?e.children(".toggleBtn").length||e.append(`<i class="toggleBtn ${this.options.icons.theme}"></i>`):e.children(".bottomEdge").length||e.append(`<i class="edge verticalEdge bottomEdge ${this.options.icons.theme}"></i>`),this.isInAction(e)&&this.switchVerticalArrow(e.children(".bottomEdge"))},buildParentNode:function(e,t){t.relationship=t.relationship||"001";t=l('<ul class="nodes"><li class="hierarchy"></li></ul>').find(".hierarchy").append(this.createNode(t)).end();this.$chart.prepend(t).find(".hierarchy:first").append(e.closest("ul").addClass("nodes"))},addParent:function(e,t){this.buildParentNode(e,t),e.children(".topEdge").length||e.children(".title").after(`<i class="edge verticalEdge topEdge ${this.options.icons.theme}"></i>`),this.isInAction(e)&&this.switchVerticalArrow(e.children(".topEdge"))},buildSiblingNode:function(e,t){var i,s=(l.isArray(t)?t:t.children).length,n=e.parent().is(".nodes")?e.siblings().length+1:1,s=n+s,s=1<s?Math.floor(s/2-1):0;e.closest(".nodes").parent().is(".hierarchy")?(this.buildChildNode(e.parent().closest(".hierarchy"),t),i=e.parent().closest(".hierarchy").children(".nodes:last").children(".hierarchy"),1<n?i.eq(0).before(e.siblings().addBack().unwrap()):i.eq(s).after(e.unwrap())):(this.buildHierarchy(e.parent().prepend(l('<li class="hierarchy">')).children(".hierarchy:first"),t),e.prevAll(".hierarchy").children(".nodes").children().eq(s).after(e))},addSiblings:function(e,t){this.buildSiblingNode(e.closest(".hierarchy"),t),e.closest(".nodes").data("siblingsLoaded",!0),e.children(".leftEdge").length||e.children(".topEdge").after(`<i class="edge horizontalEdge rightEdge ${this.options.icons.theme}"></i><i class="edge horizontalEdge leftEdge ${this.options.icons.theme}"></i>`),this.isInAction(e)&&(this.switchHorizontalArrow(e),e.children(".topEdge").removeClass(this.options.icons.expandToUp).addClass(this.options.icons.collapseToDown))},removeNodes:function(e){var t=e.closest(".hierarchy").parent();t.parent().is(".hierarchy")?this.getNodeState(e,"siblings").exist?(e.closest(".hierarchy").remove(),1===t.children().length&&t.find(".node:first .horizontalEdge").remove()):t.siblings(".node").find(".bottomEdge").remove().end().end().remove():t.closest(".orgchart").remove()},hideDropZones:function(){this.$chart.find(".allowedDrop").removeClass("allowedDrop")},showDropZones:function(e){this.$chart.find(".node").each(function(e,t){l(t).addClass("allowedDrop")}),this.$chart.data("dragged",l(e))},processExternalDrop:function(e,t){t&&this.$chart.data("dragged",l(t)),e.closest(".node").triggerHandler({type:"drop"})},exportPDF:function(e,t){var i={},s=Math.floor(e.width),n=Math.floor(e.height);h.jsPDF||(h.jsPDF=h.jspdf.jsPDF),(i=n<s?new jsPDF({orientation:"landscape",unit:"px",format:[s,n]}):new jsPDF({orientation:"portrait",unit:"px",format:[n,s]})).addImage(e.toDataURL(),"png",0,0),i.save(t+".pdf")},exportPNG:function(e,t){var i="WebkitAppearance"in c.documentElement.style,s=!!h.sidebar,n="Microsoft Internet Explorer"===navigator.appName||"Netscape"===navigator.appName&&-1<navigator.appVersion.indexOf("Edge"),o=this.$chartContainer;!i&&!s||n?h.navigator.msSaveBlob(e.msToBlob(),t+".png"):(i=".download-btn"+(""!==this.options.chartClass?"."+this.options.chartClass:""),o.find(i).length||o.append('<a class="download-btn'+(""!==this.options.chartClass?" "+this.options.chartClass:"")+'" download="'+t+'.png"></a>'),o.find(i).attr("href",e.toDataURL())[0].click())},export:function(t,i){var s=this;if(t=void 0!==t?t:this.options.exportFilename,i=void 0!==i?i:this.options.exportFileextension,l(this).children(".spinner").length)return!1;var n=this.$chartContainer,e=n.find(".mask"),e=(e.length?e.removeClass("hidden"):n.append(`<div class="mask"><i class="${this.options.icons.theme} ${this.options.icons.spinner} spinner"></i></div>`),n.addClass("canvasContainer").find('.orgchart:not(".hidden")').get(0)),o="l2r"===s.options.direction||"r2l"===s.options.direction;html2canvas(e,{width:o?e.clientHeight:e.clientWidth,height:o?e.clientWidth:e.clientHeight,onclone:function(e){l(e).find(".canvasContainer").css("overflow","visible").find('.orgchart:not(".hidden"):first').css("transform","")}}).then(function(e){n.find(".mask").addClass("hidden"),"pdf"===i.toLowerCase()?s.exportPDF(e,t):s.exportPNG(e,t),n.removeClass("canvasContainer")},function(){n.removeClass("canvasContainer")})}},l.fn.orgchart=function(e){return new t(this,e).init()}});
//# sourceMappingURL=jquery.orgchart.min.js.map