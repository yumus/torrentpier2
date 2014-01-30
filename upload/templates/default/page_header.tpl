<!DOCTYPE html>
<html>
<head>
<title><!-- IF PAGE_TITLE -->{PAGE_TITLE} :: {SITENAME}<!-- ELSE -->{SITENAME}<!-- ENDIF --></title>
<meta http-equiv="Content-Type" content="text/html; charset={L_CONTENT_ENCODING}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
{META}
<link rel="stylesheet" href="{STYLESHEET}?v={$bb_cfg['css_ver']}" type="text/css">
<link rel="icon" type="image/png" href="{SITE_URL}images/logo/logo_big.png" />
<link rel="shortcut icon" href="{SITE_URL}favicon.ico" type="image/x-icon">
<link rel="search" type="application/opensearchdescription+xml" href="{SITE_URL}opensearch_desc.xml" title="{SITENAME} (Forum)" />
<link rel="search" type="application/opensearchdescription+xml" href="{SITE_URL}opensearch_desc_bt.xml" title="{SITENAME} (Tracker)" />

<script type="text/javascript" src="{SITE_URL}misc/js/jquery.pack.js?v={$bb_cfg['js_ver']}"></script>
<script type="text/javascript" src="{SITE_URL}misc/js/main.js?v={$bb_cfg['js_ver']}"></script>

<!-- IF INCLUDE_BBCODE_JS -->
<script type="text/javascript" src="{SITE_URL}misc/js/bbcode.js?v={$bb_cfg['js_ver']}"></script>
<script type="text/javascript">
	window.BB = {};
	window.encURL = encodeURIComponent;
</script>
<script type="text/javascript">
var postImg_MaxWidth = screen.width - {POST_IMG_WIDTH_DECR_JS};
var postImgAligned_MaxWidth = Math.round(screen.width/3);
var attachImg_MaxWidth = screen.width - {ATTACH_IMG_WIDTH_DECR_JS};
var ExternalLinks_InNewWindow = '{EXT_LINK_NEW_WIN}';
var hidePostImg = false;

function copyText_writeLink(node)
{
	if (!is_ie) return;
	document.write('<p style="float: right;"><a class="txtb" onclick="if (ie_copyTextToClipboard('+node+')) alert(\'{L_CODE_COPIED}\'); return false;" href="#">{L_CODE_COPY}</a></p>');
}
function initPostBBCode(context)
{
	$('span.post-hr', context).html('<hr align="left" />');
	initCodes(context);
	initQuotes(context);
	initExternalLinks(context);
	initPostImages(context);
	initSpoilers(context);
	initMedia(context);
}
function initCodes(context)
{
	$('div.c-body', context).each(function(){
		var $c = $(this);
		$c.before('<div class="c-head"><b>{L_CODE}:</b></div>');
	});
}
function initQuotes(context)
{
	$('div.q', context).each(function(){
		var $q = $(this);
		var name = $(this).attr('head');
		var q_title = (name ? '<b>'+name+'</b> {L_WROTE}:' : '<b>{L_QUOTE}</b>');
		if ( quoted_pid = $q.children('u.q-post:first').text() ) {
			var on_this_page = $('#post_'+quoted_pid).length;
			var href = (on_this_page) ? '#'+ quoted_pid : './viewtopic.php?p='+ quoted_pid +'#'+ quoted_pid;
			q_title += ' <a href="'+ href +'" title="{L_GOTO_QUOTED_POST}"><img src="{SITE_URL}templates/default/images/icon_latest_reply.gif" class="icon2" alt="" /></a>';
		}
		$q.before('<div class="q-head">'+ q_title +'</div>');
	});
}
function initPostImages(context)
{
	if (hidePostImg) return;
	var $in_spoilers = $('div.sp-body var.postImg', context);
	$('var.postImg', context).not($in_spoilers).each(function(){
		var $v = $(this);
		var src = $v.attr('title');
		var $img = $('<img src="'+ src +'" class="'+ $v.attr('class') +'" alt="pic" />');
		$img = fixPostImage($img);
		var maxW = ($v.hasClass('postImgAligned')) ? postImgAligned_MaxWidth : postImg_MaxWidth;
		$img.bind('click', function(){ return imgFit(this, maxW); });
		if (user.opt_js.i_aft_l) {
			$('#preload').append($img);
			var loading_icon = '<a href="'+ src +'" target="_blank"><img src="{SITE_URL}images/pic_loading.gif" alt="" /></a>';
			$v.html(loading_icon);
			if ($.browser.msie) {
				$v.after('<wbr>');
			}
			$img.one('load', function(){
				imgFit(this, maxW);
				$v.empty().append(this);
			});
		}
		else {
			$img.one('load', function(){ imgFit(this, maxW) });
			$v.empty().append($img);
			if ($.browser.msie) {
				$v.after('<wbr>');
			}
		}
	});
}
function initSpoilers(context)
{
	$('div.sp-body', context).each(function(){
		var $sp_body = $(this);
		var name = $.trim(this.title) || '{L_SPOILER_HEAD}';
		this.title = '';
		var $sp_head = $('<div class="sp-head folded clickable">'+ name +'</div>');
		$sp_head.insertBefore($sp_body).click(function(e){
			if (!$sp_body.hasClass('inited')) {
				initPostImages($sp_body);
				var $sp_fold_btn = $('<div class="sp-fold clickable">[{L_SPOILER_CLOSE}]</div>').click(function(){
					$.scrollTo($sp_head, { duration:200, axis:'y', offset:-200 });
					$sp_head.click().animate({opacity: 0.1}, 500).animate({opacity: 1}, 700);
				});
				$sp_body.prepend('<div class="clear"></div>').append('<div class="clear"></div>').append($sp_fold_btn).addClass('inited');
			}
			if (e.shiftKey) {
				e.stopPropagation();
				e.shiftKey = false;
				var fold = $(this).hasClass('unfolded');
				$('div.sp-head', $($sp_body.parents('td')[0])).filter( function(){ return $(this).hasClass('unfolded') ? fold : !fold } ).click();
			}
			else {
				$(this).toggleClass('unfolded');
				$sp_body.slideToggle('fast');
			}
		});
	});
}
function initExternalLinks(context)
{
  	var context = context || 'body';
  	if (ExternalLinks_InNewWindow) {
  		$("a.postLink:not([href*='"+ window.location.hostname +"/'])", context).attr({ target: '_blank' });
  		//$("a.postLink:not([@href*='"+ window.location.hostname +"/'])", context).replaceWith('<span style="color: red;">{L_LINKS_ARE_FORBIDDEN}</span>');
  	}
}
function fixPostImage ($img)
{
	var banned_image_hosts = /imagebanana|hidebehind/i;  // imageshack
	var src = $img[0].src;
	if (src.match(banned_image_hosts)) {
		$img.wrap('<a href="'+ this.src +'" target="_blank"></a>').attr({ src: "{SITE_URL}images/tr_oops.gif", title: "{L_SCREENSHOTS_RULES}" });
	}
	return $img;
}
function initMedia(context)
{
	var apostLink = $('a.postLink', context);
	for (var i = 0; i < apostLink.length; i++) {
		var link = apostLink[i];
		if (typeof link.href != 'string') {
			continue;
		}
		if (/^http(?:s|):\/\/www.youtube.com\/watch\?(.*)?(&?v=([a-z0-9\-_]+))(.*)?|http:\/\/youtu.be\/.+/i.test(link.href)) {
			var a = document.createElement('span');
			a.className = 'YTLink';
			a.innerHTML = '<span title="{L_PLAY_ON_CURPAGE}" class="YTLinkButton">&#9658;</span>';
			window.addEvent(a, 'click', function (e) {
				var vhref = e.target.nextSibling.href.replace(/^http(?:s|):\/\/www.youtube.com\/watch\?(.*)?(&?v=([a-z0-9\-_]+))(.*)?|http:\/\/youtu.be\//ig, "http://www.youtube.com/embed/$3");
				var text  = e.target.nextSibling.innerText != "" ? e.target.nextSibling.innerText : e.target.nextSibling.href;
				$('#Panel_youtube').remove();
				ypanel('youtube', {
					title: '<b>' + text + '</b>',
					resizing: 0,
					width: 862,
					height: 550,
					content: '<iframe width="853" height="510" frameborder="0" allowfullscreen="" src="' + vhref + '?wmode=opaque"></iframe>'
				});
			});
			link.parentNode.insertBefore(a, link);
			a.appendChild(link);
		}
	}
}
$(document).ready(function(){
  	$('div.post_wrap, div.signature').each(function(){ initPostBBCode( $(this) ) });
});
</script>
<!-- ENDIF / INCLUDE_BBCODE_JS -->
<script type="text/javascript">
var BB_ROOT       = "{#BB_ROOT}";
var cookieDomain  = "{$bb_cfg['cookie_domain']}";
var cookiePath    = "{$bb_cfg['script_path']}";
var cookieSecure  = {$bb_cfg['cookie_secure']};
var cookiePrefix  = "{$bb_cfg['cookie_prefix']}";
var LOGGED_IN     = {LOGGED_IN};
var InfoWinParams = 'HEIGHT=510,resizable=yes,WIDTH=780';

var user = {
  	opt_js: {USER_OPTIONS_JS},

  	set: function(opt, val, days, reload) {
  		this.opt_js[opt] = val;
  		setCookie('opt_js', $.toJSON(this.opt_js), days);
  		if (reload) {
  			window.location.reload();
  		}
  	}
}
<!-- IF SHOW_JUMPBOX -->
$(document).ready(function(){
  	$("div.jumpbox").html('\
  		<span id="jumpbox-container"> \
  		<select id="jumpbox"> \
  			<option id="jumpbox-title" value="-1">&nbsp;&raquo;&raquo; {L_JUMPBOX_TITLE} &nbsp;</option> \
  		</select> \
  		</span> \
  		<input id="jumpbox-submit" type="button" class="lite" value="{L_GO}" /> \
  	');
  	$('#jumpbox-container').one('click', function(){
  		$('#jumpbox-title').html('&nbsp;&nbsp; {L_LOADING} ... &nbsp;');
  		var jumpbox_src = '{AJAX_HTML_DIR}' + ({LOGGED_IN} ? 'jumpbox_user.html' : 'jumpbox_guest.html');
  		$(this).load(jumpbox_src);
  		$('#jumpbox-submit').click(function(){ window.location.href='{FORUM_URL}'+$('#jumpbox').val(); });
  	});
});
<!-- ENDIF -->

var ajax = new Ajax('{SITE_URL}{$bb_cfg['ajax_url']}', 'POST', 'json');

function getElText (e)
{
  	var t = '';
  	if (e.textContent !== undefined) { t = e.textContent; } else if (e.innerText !== undefined) { t = e.innerText; } else { t = jQuery(e).text(); }
  	return t;
}
function escHTML (txt)
{
  	return txt.replace(/</g, '&lt;');
}
<!-- IF USE_TABLESORTER -->
$(document).ready(function(){
  	$('.tablesorter').tablesorter(); //	{debug: true}
});
<!-- ENDIF -->

function cfm (txt)
{
	return window.confirm(txt);
}
function post2url (url, params) {
	params = params || {};
	var f = document.createElement('form');
	f.setAttribute('method', 'post');
	f.setAttribute('action', url);
	params['form_token'] = '{FORM_TOKEN}';
	for (var k in params) {
		var h = document.createElement('input');
		h.setAttribute('type', 'hidden');
		h.setAttribute('name', k);
		h.setAttribute('value', params[k]);
		f.appendChild(h);
	}
	document.body.appendChild(f);
	f.submit();
	return false;
}
</script>

<!--[if lte IE 6]><script type="text/javascript">
$(ie6_make_clickable_labels);

$(function(){
	$('div.menu-sub').prepend('<iframe class="ie-fix-select-overlap"></iframe>'); // iframe for IE select box z-index issue
	Menu.iframeFix = true;
});
</script><![endif]-->


<!--[if gte IE 7]><style type="text/css">
input[type="checkbox"] { margin-bottom: -1px; }
</style><![endif]-->

<!--[if lte IE 6]><style type="text/css">
.forumline th { height: 24px; padding: 2px 4px; }
.menu-sub iframe.ie-fix-select-overlap { display: none; display: block; position: absolute; z-index: -1; filter: mask(); }
</style><![endif]-->

<!--[if IE]><style type="text/css">
.post-hr { margin: 2px auto; }
.fieldsets div > p { margin-bottom: 0; }
</style><![endif]-->

<!-- IF INCLUDE_DEVELOP_JS -->
<script type="text/javascript">
var dev = true;
function OpenInEditor ($file, $line)
{
  	$editor_path = '{EDITOR_PATH}';
  	$editor_args = '{EDITOR_ARGS}';

  	$url = BB_ROOT +'develop/open_editor.php';
  	$url += '?prog='+ $editor_path +'&args='+ $editor_args.sprintf($file, $line);

  	window.open($url,'','height=1,width=1,left=1,top=1,resizable=yes,scrollbars=no,toolbar=no');
}
</script>
<!-- ENDIF / INCLUDE_DEVELOP_JS -->
<style type="text/css">
	.menu-sub, #ajax-loading, #ajax-error, var.ajax-params, .sp-title, .q-post { display: none; }
</style>
</head>

<body>
<!-- IF EDITABLE_TPLS -->
<div id="editable-tpl-input" style="display: none;">
	<span class="editable-inputs nowrap" style="display: none;">
		<input type="text" class="editable-value" />
		<input type="button" class="editable-submit" value="&raquo;" style="width: 30px; font-weight: bold;" />
		<input type="button" class="editable-cancel" value="x" style="width: 30px;" />
	</span>
</div>
<div id="editable-tpl-yesno-select" style="display: none;">
	<span class="editable-inputs nowrap" style="display: none;">
		<select class="editable-value"><option value="1">{L_YES}</option><option value="0">{L_NO}</option></select>
		<input type="button" class="editable-submit" value="&raquo;" style="width: 30px; font-weight: bold;" />
		<input type="button" class="editable-cancel" value="x" style="width: 30px;" />
	</span>
</div>
<div id="editable-tpl-yesno-radio" style="display: none;">
	<span class="editable-inputs nowrap" style="display: none;">
		<label><input class="editable-value" type="radio" name="editable-value" value="1" />{L_YES}</label>
		<label><input class="editable-value" type="radio" name="editable-value" value="0" />{L_NO}</label>&nbsp;
		<input type="button" class="editable-submit" value="&raquo;" style="width: 30px; font-weight: bold;" />
		<input type="button" class="editable-cancel" value="x" style="width: 30px;" />
	</span>
</div>
<div id="editable-tpl-yesno-gender" style="display: none;">
	<span class="editable-inputs nowrap" style="display: none;">
		<label><input class="editable-value" type="radio" name="editable-value" value="1">{$lang['GENDER_SELECT'][1]}</label>
		<label><input class="editable-value" type="radio" name="editable-value" value="2">{$lang['GENDER_SELECT'][2]}</label>&nbsp;
		<label><input class="editable-value" type="radio" name="editable-value" value="0">{$lang['GENDER_SELECT'][0]}</label>
		<input type="button" class="editable-submit" value="&raquo;" style="width: 30px; font-weight: bold;">
		<input type="button" class="editable-cancel" value="x" style="width: 30px;">
	</span>
</div>
<!-- ENDIF / EDITABLE_TPLS -->

<!-- IF PAGINATION -->
<div class="menu-sub" id="pg-jump">
	<table cellspacing="1" cellpadding="4">
	<tr><th>{L_GO_TO_PAGE}</th></tr>
	<tr><td>
		<form method="get" onsubmit="return go_to_page();">
			<input id="pg-page" type="text" size="5" maxlength="4" />
			<input type="submit" value="{L_GO}"/>
		</form>
	</td></tr>
	</table>
</div>
<script type="text/javascript">
function go_to_page ()
{
	var page_num = (parseInt( $('#pg-page').val() ) > 1) ? $('#pg-page').val() : 1;
	var pg_start = (page_num - 1) * {PG_PER_PAGE};
	window.location = '{PG_BASE_URL}&start=' + pg_start;
	return false;
}
</script>
<!-- ENDIF -->

<div id="ajax-loading"></div><div id="ajax-error"></div>
<div id="preload" style="position: absolute; overflow: hidden; top: 0; left: 0; height: 1px; width: 1px;"></div>

<div id="body_container">

<!--******************-->
<!-- IF SIMPLE_HEADER -->
<!--==================-->

<style type="text/css">body { background: #E3E3E3; min-width: 10px; }</style>

<!--=================-->
<!-- ELSEIF IN_ADMIN -->
<!--=================-->

<!--======-->
<!-- ELSE -->
<!--======-->

<script type="text/javascript">
if (top != self) {
	allowed_self = /^(translate\.googleusercontent\.com)$/;
	if (!self.location.hostname.match(allowed_self)) {
		$(function(){
			$('body').html('<center><h1><br /><br />{L_YOU_ARE_BEING_CHEATED}&nbsp;'+ self.location.hostname +'</h1></center>');
		});
	}
}
</script>

<!--page_container-->
<div id="page_container">
<a name="top"></a>

<!--page_header-->
<div id="page_header">

<!--main_nav-->
<div id="main-nav" <!-- IF HAVE_NEW_PM -->class="new-pm"<!-- ENDIF --> style="height: 17px;">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td class="nowrap">
			<a href="{U_INDEX}"><b>{L_HOME}</b></a><span style="color:#CDCDCD;">|</span>
			<a href="{U_TRACKER}"><b>{L_TRACKER}</b></a><span style="color:#CDCDCD;">|</span>
			<a href="{U_SEARCH}"><b>{L_SEARCH}</b></a><span style="color:#CDCDCD;">|</span>
			<a href="{U_TERMS}"><b style="color: #993300;">{L_TERMS}</b></a><span style="color:#CDCDCD;">|</span>
			<a href="{U_GROUP_CP}"><b>{L_USERGROUPS}</b></a><span style="color:#CDCDCD;">|</span>
			<a href="{U_MEMBERLIST}"><b>{L_MEMBERLIST}</b></a><span style="color:#CDCDCD;">|</span>
		</td>
		<td class="nowrap" align="right">
			<!-- BEGIN switch_report_list -->
				<a href="{U_REPORT_LIST}" class="mainmenu">{REPORT_LIST}</a> &#0183;
			<!-- END switch_report_list -->
			<!-- BEGIN switch_report_list_new -->
				<strong><a href="{U_REPORT_LIST}" class="mainmenu">{REPORT_LIST} &#0183; </a></strong>
			<!-- END switch_report_list_new -->

			<!-- IF LOGGED_IN -->
				<!-- IF HAVE_NEW_PM || HAVE_UNREAD_PM -->
					<a href="{U_READ_PM}" class="new-pm-link"><b>{L_PRIVATE_MESSAGES}: {PM_INFO}</b></a>
				<!-- ELSE -->
					<a href="{U_PRIVATEMSGS}"><b>{L_PRIVATE_MESSAGES}: {PM_INFO}</b></a>
				<!-- ENDIF -->
			<!-- ENDIF -->
		</td>
	</tr>
	</table>
</div>
<!--/main_nav-->

<!--logo-->
<div id="logo">
	<!--<h1>{SITENAME}</h1>
	<h6>{SITE_DESCRIPTION}</h6> -->
	<a href="{U_INDEX}"><img src="images/logo/logo.png" alt="{SITENAME}" /></a>
</div>
<!--/logo-->

<!-- IF LOGGED_IN -->
<script type="text/javascript">
ajax.index_data = function(tz) {
	ajax.exec({
		action  : 'index_data',
		mode    : 'change_tz',
		tz      : tz
	});
};
ajax.callback.index_data = function(data) {};
$(document).ready(function() {
	x = new Date();
	tz = -x.getTimezoneOffset()/60;
	if (tz != <?php echo $bb_cfg['board_timezone']?>)
	{
		ajax.index_data(tz);
	}
});
</script>

<!--logout-->
<div class="topmenu">
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td width="40%">
		{L_USER_WELCOME} &nbsp;<b class="med">{THIS_USER}</b>&nbsp; [ <a href="{U_LOGIN_LOGOUT}" onclick="return confirm('{L_CONFIRM_LOGOUT}');">{L_LOGOUT}</a> ]
	</td>

	<td style="padding: 2px;">
		<div>
			<form id="quick-search" action="" method="post" onsubmit="$(this).attr('action', $('#search-action').val());">
				<input type="hidden" name="max" value="1" />
				<input type="hidden" name="to" value="1" />
				<input id="search-text" type="text" name="nm" placeholder="{L_SEARCH_S}" required />
				<select id="search-action">
					<option value="tracker.php#results" selected="selected"> {L_TRACKER_S} </option>
					<option value="search.php"> {L_FORUM_S} </option>
				</select>
				<input type="submit" class="med" value="{L_SEARCH}" style="width: 55px;" />
			</form>
		</div>
	</td>
	<td width="50%" class="tRight">
		<!-- BEGIN switch_report_general -->
		<a href="{U_WRITE_REPORT}">{L_WRITE_REPORT}</a> &#0183;
		<!-- END switch_report_general -->
		<a href="{U_OPTIONS}"><b>{L_OPTIONS}</b></a> &#0183;
		<a href="{U_CUR_DOWNLOADS}">{L_PROFILE}</a> <a href="#dls-menu" class="menu-root menu-alt1">&#9660;</a> &#0183;
		<a href="{U_SEARCH_SELF_BY_LAST}">{L_SEARCH_SELF}</a>
	</td>
</tr>
</table>
</div>
<!--/logout-->

<div class="menu-sub" id="dls-menu">
	<div class="menu-a bold nowrap">
		<a class="med" href="{U_TRACKER}?rid={SESSION_USER_ID}#results">{L_CUR_UPLOADS}</a>
		<a class="med" href="{U_SEARCH}?dlu={SESSION_USER_ID}&dlc=1">{L_SEARCH_DL_COMPLETE_DOWNLOADS}</a>
		<a class="med" href="{U_SEARCH}?dlu={SESSION_USER_ID}&dlw=1">{L_SEARCH_DL_WILL_DOWNLOADS}</a>
		<a class="med" href="{U_WATCHED_TOPICS}">{L_WATCHED_TOPICS}</a>
	</div>
</div>
<!-- ELSE -->

<!--login form-->
<div class="topmenu">
   <table width="100%" cellpadding="0" cellspacing="0">
   <tr>
        <td class="tCenter pad_2">
            <a href="{U_REGISTER}" id="register_link"><b>{L_REGISTER}</b></a> &#0183;
                <form action="{S_LOGIN_ACTION}" method="post">
                    {L_USERNAME}: <input type="text" name="login_username" size="12" tabindex="1" accesskey="l" />
                    {L_PASSWORD}: <input type="password" name="login_password" size="12" tabindex="2" />
                    <label title="{L_AUTO_LOGIN}"><input type="checkbox" name="autologin" value="1" tabindex="3" checked="checked" />{L_REMEMBER}</label>&nbsp;
                    <input type="submit" name="login" value="{L_LOGIN}" tabindex="4" />
                </form> &#0183;
            <a href="{U_SEND_PASSWORD}">{L_FORGOTTEN_PASSWORD}</a>
        </td>
    </tr>
    </table>
</div>
<!--/login form-->
<!-- ENDIF -->

<!--breadcrumb-->
<!--<div id="breadcrumb"></div>-->
<!--/breadcrumb-->

<!-- IF SHOW_IMPORTANT_INFO -->
<!--important_info-->
<!--<div id="important_info">
important_info
</div>-->
<!--/important_info-->
<!-- ENDIF -->

</div>
<!--/page_header-->

<!--menus-->

<!-- IF SHOW_ONLY_NEW_MENU -->
<div class="menu-sub" id="only-new-options">
	<table cellspacing="1" cellpadding="4">
	<tr>
		<th>{L_DISPLAYING_OPTIONS}</th>
	</tr>
	<tr>
		<td>
			<fieldset id="show-only">
			<legend>{L_SHOW_ONLY}</legend>
			<div class="pad_4">
				<label>
					<input id="only_new_posts" type="checkbox" <!-- IF ONLY_NEW_POSTS_ON -->{CHECKED}<!-- ENDIF -->
						onclick="
							user.set('only_new', ( this.checked ? {ONLY_NEW_POSTS} : 0 ), 365, true);
							$('#only_new_topics').attr('checked', 0);
						" />{L_ONLY_NEW_POSTS}
				</label>
				<label>
					<input id="only_new_topics" type="checkbox" <!-- IF ONLY_NEW_TOPICS_ON -->{CHECKED}<!-- ENDIF -->
						onclick="
							user.set('only_new', ( this.checked ? {ONLY_NEW_TOPICS} : 0 ), 365, true);
							$('#only_new_posts').attr('checked', 0);
						" />{L_ONLY_NEW_TOPICS}
				</label>
			</div>
			</fieldset>
			<!-- IF USER_HIDE_CAT -->
			<fieldset id="user_hide_cat">
			<legend>{L_HIDE_CAT}</legend>
			<div id="h-cat-ctl" class="pad_4 nowrap">
				<form autocomplete="off">
					<!-- BEGIN h_c -->
					<label><input class="h-cat-cbx" type="checkbox" value="{h_c.H_C_ID}" {h_c.H_C_CHEKED} />{h_c.H_C_TITLE}</label>
					<!-- END h_c -->
				</form>
				<div class="spacer_6"></div>
				<div class="tCenter">
					<!-- IF H_C_AL_MESS -->
					<input style="width: 100px;" type="button" onclick="$('input.h-cat-cbx').attr('checked',false); $('input#sec_h_cat').click(); return false;" value="{L_RESET}">
					<!-- ENDIF -->
					<input id="sec_h_cat" type="button" onclick="set_h_cat();" style="width: 100px;" value="{L_SUBMIT}">
				    <script type="text/javascript">
					function set_h_cat ()
					{
						h_cats = [];
						$.each($('input.h-cat-cbx:checked'), function(i,el){
							h_cats.push( $(this).val() );
						});
						user.set('h_cat', h_cats.join('-'), 365, true);
					}
					</script>
				</div>
			</div>
			</fieldset>
			<!-- ENDIF -->
		</td>
	</tr>
	</table>
</div><!--/only-new-options-->
<!-- ENDIF / SHOW_ONLY_NEW_MENU -->

<!--/menus-->

<!--page_content-->
<div id="page_content">
<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;">
 <tr><!-- IF SHOW_SIDEBAR1 -->
  <!--sidebar1-->
  <td id="sidebar1">
   <div id="sidebar1-wrap">

     <!-- IF SHOW_BT_USERDATA --><div id="user_ratio">
      <h3>{L_USER_RATIO}</h3>
       <table cellpadding="0">
	   <div align="center">{THIS_AVATAR}</div>
       <tr><td>{L_USER_RATIO}</td><td><!-- IF DOWN_TOTAL_BYTES gt MIN_DL_BYTES --><b>{USER_RATIO}</b><!-- ELSE --><b>{L_NONE}</b> (DL < {MIN_DL_FOR_RATIO})<!-- ENDIF --></td></tr>
       <tr><td>{L_DOWNLOADED}</td><td class="leechmed"><b>{DOWN_TOTAL}</b></td></tr>
       <tr><td>{L_UPLOADED}</td><td class="seedmed"><b>{UP_TOTAL}</b></td></tr>
       <tr><td>{L_RELEASED}</td><td class="seedmed">{RELEASED}</td></tr>
       <tr><td>{L_BONUS}</td><td class="seedmed">{UP_BONUS}</td></tr>
       <!-- IF $bb_cfg['seed_bonus_enabled'] --><tr><td>{L_SEED_BONUS}</td><td><a href="profile.php?mode=bonus"><span class="points bold">{POINTS}</span></a></td></tr><!-- ENDIF -->
       </table>
     </div><!-- ENDIF -->

	<?php if (!empty($bb_cfg['sidebar1_static_content_path'])) include($bb_cfg['sidebar1_static_content_path']); ?>
	<img width="210" class="spacer" src="{SPACER}" alt="" />

   </div><!--/sidebar1-wrap-->
  </td><!--/sidebar1-->
<!-- ENDIF -->

<!--main_content-->
<td id="main_content">
    <div id="main_content_wrap">
        <div id="latest_news">
            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <!-- IF SHOW_LATEST_NEWS -->
                    <td width="50%">
                        <h3>{L_LATEST_NEWS}</h3>
                        <table cellpadding="0">
                            <!-- BEGIN news -->
                            <tr>
                                <td><div class="news_date">{news.NEWS_TIME}</div></td>
                                <td width="100%">
                                    <div class="news_title<!-- IF news.NEWS_IS_NEW --> new<!-- ENDIF -->"><a href="{TOPIC_URL}{news.NEWS_TOPIC_ID}">{news.NEWS_TITLE}</a></div>
                                </td>
                            </tr>
                            <!-- END news -->
                        </table>
                     </td>
                     <!-- ENDIF -->

                     <!-- IF SHOW_NETWORK_NEWS -->
                     <td width="50%">
                        <h3>{L_NETWORK_NEWS}</h3>
                        <table cellpadding="0">
                            <!-- BEGIN net -->
                            <tr>
                                <td><div class="news_date">{net.NEWS_TIME}</div></td>
                                <td width="100%">
                                    <div class="news_title<!-- IF net.NEWS_IS_NEW --> new<!-- ENDIF -->"><a href="{TOPIC_URL}{net.NEWS_TOPIC_ID}">{net.NEWS_TITLE}</a></div>
                                </td>
                            </tr>
                            <!-- END net -->
                         </table>
                     </td>
                     <!-- ENDIF -->
                </tr>
             </table>
        </div>

<!-- IF AD_BLOCK_200 -->
        <div id="ad-200">{AD_BLOCK_200}</div><!--/ad-200-->
<!-- ELSEIF AD_BLOCK_100 -->
        <div id="ad-100">{AD_BLOCK_100}</div><!--/ad-100-->
<!-- ENDIF / AD_BLOCK_100 -->

<!--=======================-->
<!-- ENDIF / COMMON_HEADER -->
<!--***********************-->

<!-- IF ERROR_MESSAGE -->
<div class="info_msg_wrap">
<table class="error">
	<tr><td><div class="msg">{ERROR_MESSAGE}</div></td></tr>
</table>
</div>
<!-- ENDIF / ERROR_MESSAGE -->

<!-- IF INFO_MESSAGE -->
<div class="info_msg_wrap">
<table class="info_msg">
	<tr><td><div class="msg">{INFO_MESSAGE}</div></td></tr>
</table>
</div>
<!-- ENDIF / INFO_MESSAGE -->

<!-- page_header.tpl END -->
<!-- module_xx.tpl START -->