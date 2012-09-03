
// prototype $
function $p() {
  var elements = new Array();

  for (var i = 0; i < arguments.length; i++) {
    var element = arguments[i];
    if (typeof element == 'string')
      element = document.getElementById(element);

    if (arguments.length == 1)
      return element;

    elements.push(element);
  }

  return elements;
}

// from http://www.dustindiaz.com/rock-solid-addevent/
function addEvent( obj, type, fn ) {
	if (obj.addEventListener) {
		obj.addEventListener( type, fn, false );
		EventCache.add(obj, type, fn);
	}
	else if (obj.attachEvent) {
		obj["e"+type+fn] = fn;
		obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
		obj.attachEvent( "on"+type, obj[type+fn] );
		EventCache.add(obj, type, fn);
	}
	else {
		obj["on"+type] = obj["e"+type+fn];
	}
}

var EventCache = function(){
	var listEvents = [];
	return {
		listEvents : listEvents,
		add : function(node, sEventName, fHandler){
			listEvents.push(arguments);
		},
		flush : function(){
			var i, item;
			for(i = listEvents.length - 1; i >= 0; i = i - 1){
				item = listEvents[i];
				if(item[0].removeEventListener){
					item[0].removeEventListener(item[1], item[2], item[3]);
				};
				if(item[1].substring(0, 2) != "on"){
					item[1] = "on" + item[1];
				};
				if(item[0].detachEvent){
					item[0].detachEvent(item[1], item[2]);
				};
				item[0][item[1]] = null;
			};
		}
	};
}();
if (document.all) { addEvent(window,'unload',EventCache.flush); }

function imgFit (img, maxW)
{
	img.title  = 'Размеры изображения: '+img.width+' x '+img.height;
	if (typeof(img.naturalHeight) == 'undefined') {
		img.naturalHeight = img.height;
		img.naturalWidth  = img.width;
	}
	if (img.width > maxW) {
		img.height = Math.round((maxW/img.width)*img.height);
		img.width  = maxW;
		img.title  = 'Нажмите на изображение, чтобы посмотреть его в полный размер';
		img.style.cursor = 'move';
		return false;
	}
	else if (img.width == maxW && img.width < img.naturalWidth) {
		img.height = img.naturalHeight;
		img.width  = img.naturalWidth;
		img.title  = 'Размеры изображения: '+img.naturalWidth+' x '+img.naturalHeight;
		return false;
	}
	else {
		return true;
	}
}

function toggle_block (id)
{
	var el = document.getElementById(id);
	el.style.display = (el.style.display == 'none') ? '' : 'none';
}

function toggle_disabled (id, val)
{
	document.getElementById(id).disabled = (val) ? 0 : 1;
}

function rand (min, max)
{
	return min + Math.floor((max - min + 1) * Math.random());
}

//
// Cookie functions [based on ???]
//
/**
 * name       Name of the cookie
 * value      Value of the cookie
 * [days]     Number of days to remain active (default: end of current session)
 * [path]     Path where the cookie is valid (default: path of calling document)
 * [domain]   Domain where the cookie is valid
 *            (default: domain of calling document)
 * [secure]   Boolean value indicating if the cookie transmission requires a
 *            secure transmission
 */
function setCookie (name, value, days, path, domain, secure)
{
	if (days != 'SESSION') {
		var date = new Date();
		days = days || 365;
		date.setTime(date.getTime() + days*24*60*60*1000);
		var expires = date.toGMTString();
	} else {
		var expires = '';
	}

	document.cookie =
		name +'='+ escape(value)
	+	((expires) ? '; expires='+ expires : '')
	+	((path) ? '; path='+ path : ((cookiePath) ? '; path='+ cookiePath : ''))
	+	((domain) ? '; domain='+ domain : ((cookieDomain) ? '; domain='+ cookieDomain : ''))
	+	((secure) ? '; secure' : ((cookieSecure) ? '; secure' : ''));
}

/**
 * Returns a string containing value of specified cookie,
 *   or null if cookie does not exist.
 */
function getCookie (name)
{
	var c, RE = new RegExp('(^|;)\\s*'+ name +'\\s*=\\s*([^\\s;]+)', 'g');
	return (c = RE.exec(document.cookie)) ? c[2] : null;
}

/**
 * name      name of the cookie
 * [path]    path of the cookie (must be same as path used to create cookie)
 * [domain]  domain of the cookie (must be same as domain used to create cookie)
 */
function deleteCookie (name, path, domain)
{
	setCookie(name, '', -1, path, domain);
}

// Simple Javascript Browser/OS detection (based on "Harald Hope, Tapio Markula, http://techpatterns.com ver 2.0.1")
var ua = navigator.userAgent;

var os_win = ( navigator.appVersion.indexOf( 'Win' ) != -1 );
var os_mac = ( navigator.appVersion.indexOf( 'Mac' ) != -1 );
var os_lin = ( ua.indexOf( 'Linux' ) != -1 );

var is_opera = ( ua.indexOf( 'Opera' ) != -1 );
var is_konq  = ( ua.indexOf( 'Konqueror' ) != -1 );
var is_saf   = ( ua.indexOf( 'Safari' ) != -1 );
var is_moz   = ( ua.indexOf( 'Gecko' ) != -1 && !is_saf && !is_konq);
var is_ie    = ( document.all && !is_opera );
var is_ie4   = ( is_ie && !document.getElementById );

// ie5x tests only for functionality
// Opera will register true in this test if set to identify as IE 5
var is_ie5x    = ( document.all && document.getElementById );
var os_ie5mac  = ( os_mac && is_ie5x );
var os_ie5xwin = ( os_win && is_ie5x );

// Copy text to clipboard. Originally got from decompiled `php_manual_en.chm`.
function ie_copyTextToClipboard (fromNode)
{
	var txt = document.body.createTextRange();
	txt.moveToElementText(fromNode);
	return txt.execCommand("Copy");
}

// Clickable LABELs in IE
// based on http://web.tampabay.rr.com/bmerkey/examples/clickable-labels.html
function ie6_make_clickable_labels ()
{
	var labels = document.getElementsByTagName("label");
	for (var i=0, len=labels.length; i<len; i++) {
		if (!labels[i].getAttribute("htmlFor")) {
			labels[i].onclick = function() { this.children[0].click(); }
		}
	}
}

//
// Menus
//
var Menu = {
	hideSpeed          : 'fast',
	offsetCorrection_X : -4,
	offsetCorrection_Y : 2,
	iframeFix          : false,

	activeMenuId       : null,  //  currently opened menu (from previous click)
	clickedMenuId      : null,  //  menu to show up
	$root              : null,  //  root element for menu with "href = '#clickedMenuId'"
	$menu              : null,  //  clicked menu
	positioningType    : null,  //  reserved
	outsideClickWatch  : false, //  prevent multiple $(document).click binding

	clicked: function($root) {
		$root.blur();
		this.clickedMenuId = this.getMenuId($root);
		this.$menu = $(this.clickedMenuId);
		this.$root = $root;
		this.toggle();
	},

	hovered: function($root) {
		if (this.activeMenuId && this.activeMenuId !== this.getMenuId($root)) {
			this.clicked($root);
		}
	},

	unhovered: function($root) {
	},

	getMenuId: function($el) {
		var href = $el.attr('href');
		return href.substr(href.indexOf('#'));
	},

	setLocation: function() {
		var CSS = this.$root.offset();
		CSS.top  += this.$root.height() + this.offsetCorrection_Y;
		CSS.left += this.offsetCorrection_X;
		this.$menu.css(CSS);
	},

	fixLocation: function() {
		var $menu = this.$menu;
		var curLeft = parseInt($menu.css('left'));
		var rCorner = $(document).scrollLeft() + $(window).width() - 6;
		var maxVisibleLeft = Math.min(curLeft, Math.max(0, rCorner - $menu.width()));
		if (curLeft != maxVisibleLeft) {
			$menu.css('left', maxVisibleLeft);
		}
		var curTop = parseInt($menu.css('top'));
		var tCorner = $(document).scrollTop() + $(window).height() - 20;
		var maxVisibleTop = Math.min(curTop, Math.max(0, tCorner - $menu.height()));
		if (curTop != maxVisibleTop) {
			$menu.css('top', maxVisibleTop);
		}
		if (this.iframeFix) {
			$('iframe.ie-fix-select-overlap', $menu).css({ width: $menu.width(), height: $menu.height() });
		}
	},

	toggle: function() {
		if (this.activeMenuId && this.activeMenuId !== this.clickedMenuId) {
			$(this.activeMenuId).hide(this.hideSpeed);
		}
		// toggle clicked menu
		if (this.$menu.is(':visible')) {
			this.$menu.hide(this.hideSpeed);
			this.activeMenuId = null;
		}	else {
			this.showClickedMenu();
			if (!this.outsideClickWatch) {
				$(document).one('mousedown', function(e){ Menu.hideClickWatcher(e); });
				this.outsideClickWatch = true;
			}
		}
	},

	showClickedMenu: function() {
		this.setLocation();
		this.$menu.css({display: 'block'});
		this.fixLocation();
		this.activeMenuId = this.clickedMenuId;
	},

	// hide if clicked outside of menu
	hideClickWatcher: function(e) {
		this.outsideClickWatch = false;
		this.hide(e);
	},

	hide: function(e) {
		if (this.$menu) {
			this.$menu.hide(this.hideSpeed);
		}
		this.activeMenuId = this.clickedMenuId = this.$menu = null;
	}
};

$(document).ready(function(){
	// Menus
	$('body').append($('div.menu-sub'));
	$('a.menu-root')
		.click(
			function(e){ e.preventDefault(); Menu.clicked($(this)); return false; })
		.hover(
			function(){ Menu.hovered($(this)); return false; },
			function(){ Menu.unhovered($(this)); return false; }
		)
	;
	$('div.menu-sub')
		.mousedown(function(e){ e.stopPropagation(); })
		.find('a')
			.click(function(e){ Menu.hide(e); })
	;
	// Input hints
	$('input')
		.filter('.hint').one('focus', function(){
			$(this).val('').removeClass('hint');
		})
		.end()
		.filter('.error').one('focus', function(){
			$(this).removeClass('error');
		})
	;
});

//
// Ajax
//
function Ajax(handlerURL, requestType, dataType) {
	this.url      = handlerURL;
	this.type     = requestType;
	this.dataType = dataType;
	this.errors   = { };
}

Ajax.prototype = {
	init       : {},  // init functions (run before submit, after triggering ajax event)
	callback   : {},  // callback functions (response handlers)
	state      : {},  // current action state
	request    : {},  // request data
	params     : {},  // action params, format: ajax.params[ElementID] = { param: "val" ... }
	form_token : '',

	exec: function(request) {
		this.request[request.action] = request;
		request['form_token'] = this.form_token;
		$.ajax({
			url      : this.url,
			type     : this.type,
			dataType : this.dataType,
			data     : request,
			success  : ajax.success,
			error    : ajax.error
		});
	},

	success: function(response) {
		var action = response.action;
		// raw_output normally might contain only error messages (if php.ini.display_errors == 1)
		if (response.raw_output) {
			$('body').prepend(response.raw_output);
		}
		if (response.sql_log) {
			$('#sqlLog').prepend(response.sql_log +'<hr />');
			fixSqlLog();
		}
		if (response.update_ids) {
			for (id in response.update_ids) {
				$('#'+id).html( response.update_ids[id] );
			}
		}
		if (response.prompt_password) {
			var user_password = prompt('Для доступа к данной функции, пожалуйста, введите свой пароль', '');
			if (user_password) {
				var req = ajax.request[action];
				req.user_password = user_password;
				ajax.exec(req);
			}
			else {
				ajax.clearActionState(action);
				ajax.showErrorMsg('Введен неверный пароль');
			}
		}
		else if (response.prompt_confirm) {
			if (window.confirm(response.confirm_msg)) {
				var req = ajax.request[action];
				req.confirmed = 1;
				ajax.exec(req);
			}
			else {
				ajax.clearActionState(action);
			}
		}
		else if (response.error_code) {
			ajax.showErrorMsg(response.error_msg);
			$('.loading-1').removeClass('loading-1').html('error');
		}
		else {
			ajax.callback[action](response);
			ajax.clearActionState(action);
		}
	},

	error: function(xml, desc) {
	},

	clearActionState: function(action){
		ajax.state[action] = ajax.request[action] = '';
	},

	showErrorMsg: function(msg){
		alert(msg);
	},

	callInitFn: function(event) {
		event.stopPropagation();
		var params = ajax.params[$(this).attr('id')];
		var action = params.action;
		if (ajax.state[action] == 'readyToSubmit' || ajax.state[action] == 'error') {
			return false;
		} else {
			ajax.state[action] = 'readyToSubmit';
		}
		ajax.init[action](params);
	},

	setStatusBoxPosition: function($el) {
		var newTop = $(document).scrollTop();
		var rCorner = $(document).scrollLeft() + $(window).width() - ($.browser.opera ? 14 : 8);
		var newLeft = Math.max(0, rCorner - $el.width());
		$el.css({ top: newTop, left: newLeft });
	},

	makeEditable: function(rootElementId, editableType) {
		var $root = $('#'+rootElementId);
		var $editable = $('.editable', $root);
		var inputsHtml = $('#editable-tpl-'+editableType).html();
		$editable.hide().after(inputsHtml);
		var $inputs = $('.editable-inputs', $root);
		if (editableType == 'input' || editableType == 'textarea') {
			$('.editable-value', $inputs).val( $.trim($editable.text()) );
		}
		$('input.editable-submit', $inputs).click(function(){
			var params = ajax.params[rootElementId];
			var $val = $('.editable-value', '#'+rootElementId);
			params.value = ($val.size() == 1) ? $val.val() : $val.filter(':checked').val();
			params.submit = true;
			ajax.init[params.action](params);
		});
		$('input.editable-cancel', $inputs).click(function(){
			ajax.restoreEditable(rootElementId);
		});
		$inputs.show().find('.editable-value').focus();
		$root.removeClass('editable-container');
	},

	restoreEditable: function(rootElementId, newValue) {
		var $root = $('#'+rootElementId);
		var $editable = $('.editable', $root);
		$('.editable-inputs', $root).remove();
		if (newValue) {
			$editable.text(newValue);
		}
		$editable.show();
		ajax.clearActionState( ajax.params[rootElementId].action );
		ajax.params[rootElementId].submit = false;
		$root.addClass('editable-container');
	}
};

$(document).ready(function(){
	// Setup ajax-loading box
	$("#ajax-loading").ajaxStart(function(){
		$("#ajax-error").hide();
		$(this).show();
		ajax.setStatusBoxPosition($(this));
	});
	$("#ajax-loading").ajaxStop(function(){ $(this).hide(); });

	// Setup ajax-error box
	$("#ajax-error").ajaxError(function(req, xml){
		var status = xml.status;
		var text = xml.statusText;
		if (status == 200) {
			status = '';
			text = 'invalid data format';
		}
		$(this).html(
			"Ошибка в: <i>"+ ajax.url +"</i><br /><b>"+ status +" "+ text +"</b>"
		).show();
		ajax.setStatusBoxPosition($(this));
	});

	// Bind ajax events
	$('var.ajax-params').each(function(){
		var params = $.evalJSON( $(this).html() );
		params.event = params.event || 'dblclick';
		ajax.params[params.id] = params;
		$("#"+params.id).bind(params.event, ajax.callInitFn);
		if (params.event == 'click' || params.event == 'dblclick') {
			$("#"+params.id).addClass('editable-container');
		}
	});
});
