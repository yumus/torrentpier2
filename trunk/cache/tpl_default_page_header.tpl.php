<?php if (!empty($V['QUIRKS_MODE'])) { ?><?php } else { ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><?php } ?>
<html dir="<?php echo isset($L['CONTENT_DIRECTION']) ? $L['CONTENT_DIRECTION'] : $V['L_CONTENT_DIRECTION']; ?>">

<head>
<title><?php if (!empty($V['PAGE_TITLE'])) { ?><?php echo isset($V['PAGE_TITLE']) ? $V['PAGE_TITLE'] : ''; ?> :: <?php echo isset($V['SITENAME']) ? $V['SITENAME'] : ''; ?><?php } else { ?><?php echo isset($V['SITENAME']) ? $V['SITENAME'] : ''; ?><?php } ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo isset($L['CONTENT_ENCODING']) ? $L['CONTENT_ENCODING'] : $V['L_CONTENT_ENCODING']; ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<?php echo isset($V['META']) ? $V['META'] : ''; ?>
<link rel="stylesheet" href="<?php echo isset($V['STYLESHEET']) ? $V['STYLESHEET'] : ''; ?>?v=<?php echo isset($bb_cfg['css_ver']) ? $bb_cfg['css_ver'] : ''; ?>" type="text/css">
<?php if (!empty($V['DEBUG'])) { ?><link rel="stylesheet" href="<?php echo isset($V['DBG_CSS']) ? $V['DBG_CSS'] : ''; ?>" type="text/css"><?php } ?>
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<link rel="search" type="application/opensearchdescription+xml" href="opensearch_desc.xml" title="<?php echo isset($V['SITENAME']) ? $V['SITENAME'] : ''; ?> (Forum)" />
<link rel="search" type="application/opensearchdescription+xml" href="opensearch_desc_bt.xml" title="<?php echo isset($V['SITENAME']) ? $V['SITENAME'] : ''; ?> (Tracker)" />
<?php if (!empty($V['DEBUG'])) { ?>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/source/jquery.js"></script>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/source/jquery_plugins/dimensions.js"></script>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/source/jquery_plugins/json.js"></script>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/source/jquery_plugins/metadata.js"></script>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/source/jquery_plugins/jquery.media.js"></script>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/firebug/firebug.js"></script>
<?php } else { ?>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/jquery.pack.js?v=<?php echo isset($bb_cfg['js_ver']) ? $bb_cfg['js_ver'] : ''; ?>"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/main.js?v=<?php echo isset($bb_cfg['js_ver']) ? $bb_cfg['js_ver'] : ''; ?>"></script>
<?php if (!empty($V['INCLUDE_BBCODE_JS'])) { ?>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/bbcode.js?v=<?php echo isset($bb_cfg['js_ver']) ? $bb_cfg['js_ver'] : ''; ?>"></script>
<script type="text/javascript">
var postImg_MaxWidth = screen.width - <?php echo isset($V['POST_IMG_WIDTH_DECR_JS']) ? $V['POST_IMG_WIDTH_DECR_JS'] : ''; ?>;
var postImgAligned_MaxWidth = Math.round(screen.width/3);
var attachImg_MaxWidth = screen.width - <?php echo isset($V['ATTACH_IMG_WIDTH_DECR_JS']) ? $V['ATTACH_IMG_WIDTH_DECR_JS'] : ''; ?>;
var ExternalLinks_InNewWindow = '<?php echo isset($V['EXT_LINK_NEW_WIN']) ? $V['EXT_LINK_NEW_WIN'] : ''; ?>';
var hidePostImg = false;

function copyText_writeLink(node)
{
	if (!is_ie) return;
	document.write('<p style="float: right;"><a class="txtb" onclick="if (ie_copyTextToClipboard('+node+')) alert(\'<?php echo isset($L['CODE_COPIED']) ? $L['CODE_COPIED'] : $V['L_CODE_COPIED']; ?>\'); return false;" href="#"><?php echo isset($L['CODE_COPY']) ? $L['CODE_COPY'] : $V['L_CODE_COPY']; ?></a></p>');
}
function initPostBBCode(context)
{
	$('span.post-hr', context).html('<hr align="left" />');
	initQuotes(context);
	initExternalLinks(context);
	initPostImages(context);
	initSpoilers(context);
}
function initQuotes(context)
{
	$('div.q', context).each(function(){
		var $q = $(this);
		var name = $(this).attr('head');
		$q.before('<div class="q-head">'+ (name ? '<b>'+name+'</b> писал(а):' : '<b>Цитата:</b>') +'</div>');
	});
}
function initPostImages(context)
{
	if (hidePostImg) return;
	var $in_spoilers = $('div.sp-body var.postImg', context);
	$('var.postImg', context).not($in_spoilers).each(function(){
		var $v = $(this);
		var src = $v.attr('title');
		var $img = $('<img src="'+ src +'" class="'+ $v.attr('className') +'" alt="pic" />');
		$img = fixPostImage($img);
		var maxW = ($v.hasClass('postImgAligned')) ? postImgAligned_MaxWidth : postImg_MaxWidth;
		$img.bind('click', function(){ return imgFit(this, maxW); });
		if (user.opt_js.i_aft_l) {
			$('#preload').append($img);
			var loading_icon = '<a href="'+ src +'" target="_blank"><img src="/loading.gif" alt="" /></a>';
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
		var name = $.trim(this.title) || 'скрытый текст';
		this.title = '';
		var $sp_head = $('<div class="sp-head folded clickable">'+ name +'</div>');
		$sp_head.insertBefore($sp_body).click(function(e){
			if (!$sp_body.hasClass('inited')) {
				initPostImages($sp_body);
				var $sp_fold_btn = $('<div class="sp-fold clickable">[свернуть]</div>').click(function(){
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
  		//$("a.postLink:not([@href*='"+ window.location.hostname +"/'])", context).replaceWith('<span style="color: red;">Ссылки запрещены</span>');
  	}
}
function fixPostImage ($img)
{
	var banned_image_hosts = /imagebanana|hidebehind/i;  // imageshack
	var src = $img[0].src;
	if (src.match(banned_image_hosts)) {
		$img.wrap('<a href="'+ this.src +'" target="_blank"></a>').attr({ src: "<?php echo isset($V['SMILES_URL']) ? $V['SMILES_URL'] : ''; ?>/tr_oops.gif", title: "Прочтите правила выкладывания скриншотов!" });
	}
	return $img;
}
$(document).ready(function(){
  	$('div.post_wrap, div.signature').each(function(){ initPostBBCode( $(this) ) });
});
</script>
<?php } ?>
<script type="text/javascript">
var BB_ROOT       = "<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>";
var cookieDomain  = "<?php echo isset($bb_cfg['cookie_domain']) ? $bb_cfg['cookie_domain'] : ''; ?>";
var cookiePath    = "<?php echo isset($bb_cfg['cookie_path']) ? $bb_cfg['cookie_path'] : ''; ?>";
var cookieSecure  = <?php echo isset($bb_cfg['cookie_secure']) ? $bb_cfg['cookie_secure'] : ''; ?>;
var cookiePrefix  = "<?php echo isset($bb_cfg['cookie_prefix']) ? $bb_cfg['cookie_prefix'] : ''; ?>";
var LOGGED_IN     = <?php echo isset($V['LOGGED_IN']) ? $V['LOGGED_IN'] : ''; ?>;
var InfoWinParams = 'HEIGHT=510,resizable=yes,WIDTH=780';

var user = {
  	opt_js: <?php echo isset($V['USER_OPTIONS_JS']) ? $V['USER_OPTIONS_JS'] : ''; ?>,

  	set: function(opt, val, days, reload) {
  		this.opt_js[opt] = val;
  		setCookie('opt_js', $.toJSON(this.opt_js), days);
  		if (reload) {
  			window.location.reload();
  		}
  	}
}
<?php if (!empty($V['SHOW_JUMPBOX'])) { ?>
$(document).ready(function(){
  	$("div.jumpbox").html('\
  		<span id="jumpbox-container"> \
  		<select id="jumpbox"> \
  			<option id="jumpbox-title" value="-1">&nbsp;&raquo;&raquo; <?php echo isset($L['JUMPBOX_TITLE']) ? $L['JUMPBOX_TITLE'] : $V['L_JUMPBOX_TITLE']; ?> &nbsp;</option> \
  		</select> \
  		</span> \
  		<input id="jumpbox-submit" type="button" class="lite" value="<?php echo isset($L['GO']) ? $L['GO'] : $V['L_GO']; ?>" /> \
  	');
  	$('#jumpbox-container').one('click', function(){
  		$('#jumpbox-title').html('&nbsp;&nbsp; <?php echo isset($L['LOADING']) ? $L['LOADING'] : $V['L_LOADING']; ?> ... &nbsp;');
  		var jumpbox_src = '<?php echo isset($V['AJAX_HTML_DIR']) ? $V['AJAX_HTML_DIR'] : ''; ?>' + (<?php echo isset($V['LOGGED_IN']) ? $V['LOGGED_IN'] : ''; ?> ? 'jumpbox_user.html' : 'jumpbox_guest.html');
  		$(this).load(jumpbox_src);
  		$('#jumpbox-submit').click(function(){ window.location.href='<?php echo isset($V['FORUM_URL']) ? $V['FORUM_URL'] : ''; ?>'+$('#jumpbox').val(); });
  	});
});
<?php } ?>

var ajax = new Ajax('<?php echo isset($V['AJAX_HANDLER']) ? $V['AJAX_HANDLER'] : ''; ?>', 'POST', 'json');

<?php if (!empty($V['USE_TABLESORTER'])) { ?>
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

$(document).ready(function(){
  	$('.tablesorter').tablesorter(); //	{debug: true}
});
<?php } ?>
</script>

<!--[if lt IE 7]>
<script type="text/javascript">
$(document).ready(ie6_make_clickable_labels);

$(document).ready(function(){
  	$('div.menu-sub').prepend('<iframe class="ie-fix-select-overlap"></iframe>'); // iframe for IE select box z-index issue
  	Menu.iframeFix = true;
});
</script>
<![endif]-->

<!--[if gte IE 7]><style type="text/css">input[type="checkbox"] { margin-bottom: -1px; }</style><![endif]-->
<!--[if lte IE 6]><style type="text/css">.forumline th { height: 24px; padding: 2px 4px; }</style><![endif]-->
<!--[if IE]><style type="text/css">.code-copy { display: block; }.post-hr   { margin: 2px auto; }</style><![endif]-->

<?php if (!empty($V['INCLUDE_DEVELOP_JS'])) { ?>
<script type="text/javascript" src="<?php echo defined('BB_ROOT') ? BB_ROOT : ''; ?>misc/js/develop.js"></script>
<script type="text/javascript">
function OpenInEditor ($file, $line)
{
  	$editor_path = '<?php echo isset($V['EDITOR_PATH']) ? $V['EDITOR_PATH'] : ''; ?>';
  	$editor_args = '<?php echo isset($V['EDITOR_ARGS']) ? $V['EDITOR_ARGS'] : ''; ?>';

  	$url = BB_ROOT +'develop/open_editor.php';
  	$url += '?prog='+ $editor_path +'&args='+ $editor_args.sprintf($file, $line);

  	window.open($url,'','height=1,width=1,left=1,top=1,resizable=yes,scrollbars=no,toolbar=no');
}
</script>
<?php } ?>
<style type="text/css">
	.menu-sub, #ajax-loading, #ajax-error, var.ajax-params { display: none; }
</style>
</head>

<body>
<?php if (!empty($V['EDITABLE_TPLS'])) { ?>
<div id="editable-tpl-input" style="display: none;">
	<span class="editable-inputs nowrap" style="display: none;">
		<input type="text" class="editable-value" />
		<input type="button" class="editable-submit" value="&raquo;" style="width: 30px; font-weight: bold;" />
		<input type="button" class="editable-cancel" value="x" style="width: 30px;" />
	</span>
</div>
<div id="editable-tpl-yesno-select" style="display: none;">
	<span class="editable-inputs nowrap" style="display: none;">
		<select class="editable-value"><option value="1"><?php echo isset($L['YES']) ? $L['YES'] : $V['L_YES']; ?></option><option value="0"><?php echo isset($L['NO']) ? $L['NO'] : $V['L_NO']; ?></option></select>
		<input type="button" class="editable-submit" value="&raquo;" style="width: 30px; font-weight: bold;" />
		<input type="button" class="editable-cancel" value="x" style="width: 30px;" />
	</span>
</div>
<div id="editable-tpl-yesno-radio" style="display: none;">
	<span class="editable-inputs nowrap" style="display: none;">
		<label><input class="editable-value" type="radio" name="editable-value" value="1" /><?php echo isset($L['YES']) ? $L['YES'] : $V['L_YES']; ?></label>
		<label><input class="editable-value" type="radio" name="editable-value" value="0" /><?php echo isset($L['NO']) ? $L['NO'] : $V['L_NO']; ?></label>&nbsp;
		<input type="button" class="editable-submit" value="&raquo;" style="width: 30px; font-weight: bold;" />
		<input type="button" class="editable-cancel" value="x" style="width: 30px;" />
	</span>
</div>
<?php } ?>

<table id="ajax-loading" cellpadding="0" cellspacing="0"><tr><td class="icon"></td><td>Loading...</td></tr></table>
<table id="ajax-error" cellpadding="0" cellspacing="0"><tr><td>Error</td></tr></table>

<div id="preload" style="position: absolute; overflow: hidden; top: 0; left: 0; height: 1px; width: 1px;"></div>

<div id="body_container">

<!--******************-->
<?php if (!empty($V['SIMPLE_HEADER'])) { ?>
<!--==================-->

<style type="text/css">body { background: #E3E3E3; min-width: 10px; }</style>

<!--=================-->
<?php } elseif (!empty($V['IN_ADMIN'])) { ?>
<!--=================-->

<!--======-->
<?php } else { ?>
<!--======-->

<!--page_container-->
<div id="page_container">
<a name="top"></a>

<!--page_header-->
<div id="page_header">

<!--main_nav-->
<div id="main-nav" <?php if (!empty($V['HAVE_NEW_PM'])) { ?>class="new-pm"<?php } ?> style="height: 17px;">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td class="nowrap">
			<a href="<?php echo isset($V['U_INDEX']) ? $V['U_INDEX'] : ''; ?>"><b><?php echo isset($L['HOME']) ? $L['HOME'] : $V['L_HOME']; ?></b></a>&#0183;

			<a href="<?php echo isset($V['U_TRACKER']) ? $V['U_TRACKER'] : ''; ?>"><b><?php echo isset($L['TRACKER']) ? $L['TRACKER'] : $V['L_TRACKER']; ?></b></a>&#0183;
			<?php if (!empty($V['LOGGED_IN'])) { ?><a href="<?php echo isset($V['U_GALLERY']) ? $V['U_GALLERY'] : ''; ?>"><b><?php echo isset($L['GALLERY']) ? $L['GALLERY'] : $V['L_GALLERY']; ?></b></a>&#0183;<?php } ?>
			<a href="<?php echo isset($V['U_SEARCH']) ? $V['U_SEARCH'] : ''; ?>"><b><?php echo isset($L['SEARCH']) ? $L['SEARCH'] : $V['L_SEARCH']; ?></b></a>&#0183;
			<a href="<?php echo isset($V['U_TERMS']) ? $V['U_TERMS'] : ''; ?>"><b><?php echo isset($L['TERMS']) ? $L['TERMS'] : $V['L_TERMS']; ?></b></a>&#0183;
			<a href="<?php echo isset($V['U_FAQ']) ? $V['U_FAQ'] : ''; ?>"><b style="color: #993300;"><?php echo isset($L['FAQ']) ? $L['FAQ'] : $V['L_FAQ']; ?></b></a>&#0183;
			<a href="<?php echo isset($V['U_GROUP_CP']) ? $V['U_GROUP_CP'] : ''; ?>"><b><?php echo isset($L['USERGROUPS']) ? $L['USERGROUPS'] : $V['L_USERGROUPS']; ?></b></a>&#0183;
			<a href="<?php echo isset($V['U_MEMBERLIST']) ? $V['U_MEMBERLIST'] : ''; ?>"><b><?php echo isset($L['MEMBERLIST']) ? $L['MEMBERLIST'] : $V['L_MEMBERLIST']; ?></b></a>
		</td>
		<td class="nowrap" align="right">
			<?php if (!empty($V['LOGGED_IN'])) { ?>
				<?php if ($V['HAVE_NEW_PM'] || $V['HAVE_UNREAD_PM']) { ?>
					<a href="<?php echo isset($V['U_READ_PM']) ? $V['U_READ_PM'] : ''; ?>" class="new-pm-link"><b><?php echo isset($L['PRIVATE_MESSAGES']) ? $L['PRIVATE_MESSAGES'] : $V['L_PRIVATE_MESSAGES']; ?>: <?php echo isset($V['PM_INFO']) ? $V['PM_INFO'] : ''; ?></b></a>
				<?php } else { ?>
					<a href="<?php echo isset($V['U_PRIVATEMSGS']) ? $V['U_PRIVATEMSGS'] : ''; ?>"><b><?php echo isset($L['PRIVATE_MESSAGES']) ? $L['PRIVATE_MESSAGES'] : $V['L_PRIVATE_MESSAGES']; ?>: <?php echo isset($V['PM_INFO']) ? $V['PM_INFO'] : ''; ?></b></a>
				<?php } ?>
			<?php } else { ?>
				<a href="<?php echo isset($V['U_PRIVATEMSGS']) ? $V['U_PRIVATEMSGS'] : ''; ?>"><b><?php echo isset($L['SEND_PM_TXTB']) ? $L['SEND_PM_TXTB'] : $V['L_SEND_PM_TXTB']; ?></b></a>
			<?php } ?>
		</td>
	</tr>
	</table>
</div>
<!--/main_nav-->

<!--logo-->
<div id="logo">
	<!--<h1><?php echo isset($V['SITENAME']) ? $V['SITENAME'] : ''; ?></h1>
	<h6><?php echo isset($V['SITE_DESCRIPTION']) ? $V['SITE_DESCRIPTION'] : ''; ?></h6> -->

	<a href="<?php echo isset($V['U_INDEX']) ? $V['U_INDEX'] : ''; ?>"><img src="images/logo/logo.png" alt="<?php echo isset($V['SITENAME']) ? $V['SITENAME'] : ''; ?>" /></a>

</div>
<!--/logo-->

<?php if (!empty($V['LOGGED_IN'])) { ?>
<!--logout-->
<div class="topmenu">
   <table width="100%" cellpadding="0" cellspacing="0">
   <tr>
            <td width="40%">
         <?php echo isset($L['USER_WELCOME']) ? $L['USER_WELCOME'] : $V['L_USER_WELCOME']; ?> &nbsp;<a href="<?php echo isset($V['U_PROFILE']) ? $V['U_PROFILE'] : ''; ?>"><b class="med"><?php echo isset($V['THIS_USERNAME']) ? $V['THIS_USERNAME'] : ''; ?></b></a>&nbsp; [ <a href="<?php echo isset($V['U_LOGIN_LOGOUT']) ? $V['U_LOGIN_LOGOUT'] : ''; ?>" onclick="return confirm('<?php echo isset($L['CONFIRM_LOGOUT']) ? $L['CONFIRM_LOGOUT'] : $V['L_CONFIRM_LOGOUT']; ?>');"><?php echo isset($L['LOGOUT']) ? $L['LOGOUT'] : $V['L_LOGOUT']; ?></a> ]
      </td>
	<!-- Report -->
	<td align="center" nowrap="nowrap">
		<?php

$switch_report_list_count = ( isset($this->_tpldata['switch_report_list.']) ) ?  sizeof($this->_tpldata['switch_report_list.']) : 0;
for ($switch_report_list_i = 0; $switch_report_list_i < $switch_report_list_count; $switch_report_list_i++)
{
 $switch_report_list_item = &$this->_tpldata['switch_report_list.'][$switch_report_list_i];
 $switch_report_list_item['S_ROW_COUNT'] = $switch_report_list_i;
 $switch_report_list_item['S_NUM_ROWS'] = $switch_report_list_count;

?>
		&nbsp;<a href="<?php echo isset($V['U_REPORT_LIST']) ? $V['U_REPORT_LIST'] : ''; ?>" class="mainmenu"><?php echo isset($V['REPORT_LIST']) ? $V['REPORT_LIST'] : ''; ?></a>  &nbsp;&#0183;
		<?php

} // END switch_report_list

if(isset($switch_report_list_item)) { unset($switch_report_list_item); } 

?>
		<?php

$switch_report_list_new_count = ( isset($this->_tpldata['switch_report_list_new.']) ) ?  sizeof($this->_tpldata['switch_report_list_new.']) : 0;
for ($switch_report_list_new_i = 0; $switch_report_list_new_i < $switch_report_list_new_count; $switch_report_list_new_i++)
{
 $switch_report_list_new_item = &$this->_tpldata['switch_report_list_new.'][$switch_report_list_new_i];
 $switch_report_list_new_item['S_ROW_COUNT'] = $switch_report_list_new_i;
 $switch_report_list_new_item['S_NUM_ROWS'] = $switch_report_list_new_count;

?>
		&nbsp;<strong><a href="<?php echo isset($V['U_REPORT_LIST']) ? $V['U_REPORT_LIST'] : ''; ?>" class="mainmenu"><?php echo isset($V['REPORT_LIST']) ? $V['REPORT_LIST'] : ''; ?> &#0183; </a></strong>
		<?php

} // END switch_report_list_new

if(isset($switch_report_list_new_item)) { unset($switch_report_list_new_item); } 

?>
	<!-- Report [END] -->
	<td style="padding: 2px;">
	<div>
	<form id="quick-search" action="" method="post" onsubmit="
		$(this).attr('action', $('#search-action').val());
		var txt=$('#search-text').val(); return !(txt=='<?php echo isset($L['SEARCH_S']) ? $L['SEARCH_S'] : $V['L_SEARCH_S']; ?>' || !txt);
	">
		<input type="hidden" name="max" value="1" />
		<input type="hidden" name="to" value="1" />
		<input id="search-text" type="text" name="nm" onfocus="if(this.value=='<?php echo isset($L['SEARCH_S']) ? $L['SEARCH_S'] : $V['L_SEARCH_S']; ?>') this.value='';" onblur="if(this.value=='') this.value='<?php echo isset($L['SEARCH_S']) ? $L['SEARCH_S'] : $V['L_SEARCH_S']; ?>';" value="<?php echo isset($L['SEARCH_S']) ? $L['SEARCH_S'] : $V['L_SEARCH_S']; ?>" class="hint" style="width: 120px;" />
		<select id="search-action">
			<option value="tracker.php#results" selected="selected"> <?php echo isset($L['TRACKER_S']) ? $L['TRACKER_S'] : $V['L_TRACKER_S']; ?> </option>
			<option value="search.php"> <?php echo isset($L['FORUM_S']) ? $L['FORUM_S'] : $V['L_FORUM_S']; ?> </option>
					</select>
		<input type="submit" class="med bold" value="&raquo;" style="width: 30px;" />
	</form>
	</div>
	</td>
      <td width="50%" class="tRight">
		<!-- Report -->
		<?php

$switch_report_general_count = ( isset($this->_tpldata['switch_report_general.']) ) ?  sizeof($this->_tpldata['switch_report_general.']) : 0;
for ($switch_report_general_i = 0; $switch_report_general_i < $switch_report_general_count; $switch_report_general_i++)
{
 $switch_report_general_item = &$this->_tpldata['switch_report_general.'][$switch_report_general_i];
 $switch_report_general_item['S_ROW_COUNT'] = $switch_report_general_i;
 $switch_report_general_item['S_NUM_ROWS'] = $switch_report_general_count;

?>
		<a href="<?php echo isset($V['U_WRITE_REPORT']) ? $V['U_WRITE_REPORT'] : ''; ?>"><?php echo isset($L['WRITE_REPORT']) ? $L['WRITE_REPORT'] : $V['L_WRITE_REPORT']; ?></a> &#0183;
		<?php

} // END switch_report_general

if(isset($switch_report_general_item)) { unset($switch_report_general_item); } 

?>
		<!-- Report [END] -->
         <a href="<?php echo isset($V['U_OPTIONS']) ? $V['U_OPTIONS'] : ''; ?>" style="color:#993300"><b><?php echo isset($L['OPTIONS']) ? $L['OPTIONS'] : $V['L_OPTIONS']; ?></b></a> &#0183;
		 <a href="<?php echo isset($V['U_CUR_DOWNLOADS']) ? $V['U_CUR_DOWNLOADS'] : ''; ?>"><?php echo isset($L['CUR_DOWNLOADS']) ? $L['CUR_DOWNLOADS'] : $V['L_CUR_DOWNLOADS']; ?></a> <a href="#dls-menu" class="menu-root menu-alt1"><img src="images/menu_open_1.gif" class="menu-alt1" width="9" height="9" align="middle" alt="" /></a> &#0183;
		 <a href="<?php echo isset($V['U_SEARCH_SELF_BY_LAST']) ? $V['U_SEARCH_SELF_BY_LAST'] : ''; ?>"><?php echo isset($L['SEARCH_SELF']) ? $L['SEARCH_SELF'] : $V['L_SEARCH_SELF']; ?></a>
      </td>
         </tr>
   </table>
</div>
<!--/logout-->
<style type="text/css">
.menu-a { background: #FFFFFF; border: 1px solid #92A3A4; }
.menu-a a { background: #EFEFEF; padding: 4px 10px 5px; margin: 1px; display: block; }
</style>
<div class="menu-sub" id="dls-menu">
	<div class="menu-a bold nowrap">
		<a class="med" href="<?php echo isset($V['U_TRACKER']) ? $V['U_TRACKER'] : ''; ?>?rid=<?php echo isset($V['SESSION_USER_ID']) ? $V['SESSION_USER_ID'] : ''; ?>#results"><?php echo isset($L['CUR_UPLOADS']) ? $L['CUR_UPLOADS'] : $V['L_CUR_UPLOADS']; ?></a>
		<a class="med" href="<?php echo isset($V['U_SEARCH']) ? $V['U_SEARCH'] : ''; ?>?dlu=<?php echo isset($V['SESSION_USER_ID']) ? $V['SESSION_USER_ID'] : ''; ?>&dlc=1"><?php echo isset($L['SEARCH_DL_COMPLETE_DOWNLOADS']) ? $L['SEARCH_DL_COMPLETE_DOWNLOADS'] : $V['L_SEARCH_DL_COMPLETE_DOWNLOADS']; ?></a>
		<a class="med" href="<?php echo isset($V['U_SEARCH']) ? $V['U_SEARCH'] : ''; ?>?dlu=<?php echo isset($V['SESSION_USER_ID']) ? $V['SESSION_USER_ID'] : ''; ?>&dlw=1"><?php echo isset($L['SEARCH_DL_WILL_DOWNLOADS']) ? $L['SEARCH_DL_WILL_DOWNLOADS'] : $V['L_SEARCH_DL_WILL_DOWNLOADS']; ?></a>
	</div>
</div>
<?php } else { ?>

<!--login form-->
<div class="topmenu">
   <table width="100%" cellpadding="0" cellspacing="0">
   <tr>

            <td class="tCenter pad_2">
         <a href="<?php echo isset($V['U_REGISTER']) ? $V['U_REGISTER'] : ''; ?>" id="register_link"><b><?php echo isset($L['REGISTER']) ? $L['REGISTER'] : $V['L_REGISTER']; ?></b></a>
         &nbsp;&#0183;&nbsp;
         <form action="<?php echo isset($V['S_LOGIN_ACTION']) ? $V['S_LOGIN_ACTION'] : ''; ?>" method="post">
            <?php echo isset($L['USERNAME']) ? $L['USERNAME'] : $V['L_USERNAME']; ?>: <input type="text" name="login_username" size="12" tabindex="1" accesskey="l" />
            <?php echo isset($L['PASSWORD']) ? $L['PASSWORD'] : $V['L_PASSWORD']; ?>: <input type="password" name="login_password" size="12" tabindex="2" />
            <label title="<?php echo isset($L['AUTO_LOGIN']) ? $L['AUTO_LOGIN'] : $V['L_AUTO_LOGIN']; ?>"><input type="checkbox" name="autologin" value="1" tabindex="3" /> <?php echo isset($L['REMEMBER']) ? $L['REMEMBER'] : $V['L_REMEMBER']; ?></label>&nbsp;
            <input type="submit" name="login" value="<?php echo isset($L['LOGIN']) ? $L['LOGIN'] : $V['L_LOGIN']; ?>" tabindex="4" />
         </form>
         &nbsp;&#0183;&nbsp;
         <a href="<?php echo isset($V['U_SEND_PASSWORD']) ? $V['U_SEND_PASSWORD'] : ''; ?>"><?php echo isset($L['FORGOTTEN_PASSWORD']) ? $L['FORGOTTEN_PASSWORD'] : $V['L_FORGOTTEN_PASSWORD']; ?></a>
      </td>
         </tr>
   </table>
</div>

<!--/login form-->
<?php } ?>


<!--breadcrumb-->
<!--<div id="breadcrumb"></div>-->
<!--/breadcrumb-->

<?php if (!empty($V['SHOW_IMPORTANT_INFO'])) { ?>
<!--important_info-->
<!--<div id="important_info">
important_info
</div>-->
<!--/important_info-->
<?php } ?>

</div>
<!--/page_header-->

<!--menus-->

<?php if (!empty($V['SHOW_ONLY_NEW_MENU'])) { ?>
<div class="menu-sub" id="only-new-options">
	<table cellspacing="1" cellpadding="4">
	<tr>
		<th><?php echo isset($L['DISPLAYING_OPTIONS']) ? $L['DISPLAYING_OPTIONS'] : $V['L_DISPLAYING_OPTIONS']; ?></th>
	</tr>
	<tr>
		<td>
			<fieldset id="show-only">
			<legend><?php echo isset($L['SHOW_ONLY']) ? $L['SHOW_ONLY'] : $V['L_SHOW_ONLY']; ?></legend>
			<div class="pad_4">
				<label>
					<input id="only_new_posts" type="checkbox" <?php if (!empty($V['ONLY_NEW_POSTS_ON'])) { ?><?php echo isset($V['CHECKED']) ? $V['CHECKED'] : ''; ?><?php } ?>
						onclick="
							user.set('only_new', ( this.checked ? <?php echo isset($V['ONLY_NEW_POSTS']) ? $V['ONLY_NEW_POSTS'] : ''; ?> : 0 ), 365, true);
							$('#only_new_topics').attr('checked', 0);
						" /><?php echo isset($L['ONLY_NEW_POSTS']) ? $L['ONLY_NEW_POSTS'] : $V['L_ONLY_NEW_POSTS']; ?>
				</label>
				<label>
					<input id="only_new_topics" type="checkbox" <?php if (!empty($V['ONLY_NEW_TOPICS_ON'])) { ?><?php echo isset($V['CHECKED']) ? $V['CHECKED'] : ''; ?><?php } ?>
						onclick="
							user.set('only_new', ( this.checked ? <?php echo isset($V['ONLY_NEW_TOPICS']) ? $V['ONLY_NEW_TOPICS'] : ''; ?> : 0 ), 365, true);
							$('#only_new_posts').attr('checked', 0);
						" /><?php echo isset($L['ONLY_NEW_TOPICS']) ? $L['ONLY_NEW_TOPICS'] : $V['L_ONLY_NEW_TOPICS']; ?>
				</label>
			</div>
			</fieldset>
		</td>
	</tr>
	</table>
</div><!--/only-new-options-->
<?php } ?>

<!--/menus-->



<!--page_content-->
<div id="page_content">
<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;">
 <tr><?php if (!empty($V['SHOW_SIDEBAR1'])) { ?>
  <!--sidebar1-->
  <td id="sidebar1">
   <div id="sidebar1-wrap">

     <?php if (!empty($V['SHOW_BT_USERDATA'])) { ?><div id="user_ratio">
      <h3><?php echo isset($L['BT_RATIO']) ? $L['BT_RATIO'] : $V['L_BT_RATIO']; ?></h3>
       <table cellpadding="0">
	   <div align="center"><?php echo isset($V['AVATAR']) ? $V['AVATAR'] : ''; ?></div>
       <tr><td><?php echo isset($L['YOUR_RATIO']) ? $L['YOUR_RATIO'] : $V['L_YOUR_RATIO']; ?></td><td><?php if ($V['DOWN_TOTAL_BYTES'] > $V['MIN_DL_BYTES']) { ?><b><?php echo isset($V['USER_RATIO']) ? $V['USER_RATIO'] : ''; ?></b><?php } else { ?><b><?php echo isset($L['NONE']) ? $L['NONE'] : $V['L_NONE']; ?></b> (DL < <?php echo isset($V['MIN_DL_FOR_RATIO']) ? $V['MIN_DL_FOR_RATIO'] : ''; ?>)<?php } ?></td></tr>
       <tr><td><?php echo isset($L['DOWNLOADED']) ? $L['DOWNLOADED'] : $V['L_DOWNLOADED']; ?></td><td class="leechmed"><b><?php echo isset($V['DOWN_TOTAL']) ? $V['DOWN_TOTAL'] : ''; ?></b></td></tr>
       <tr><td><?php echo isset($L['UPLOADED']) ? $L['UPLOADED'] : $V['L_UPLOADED']; ?></td><td class="seedmed"><b><?php echo isset($V['UP_TOTAL']) ? $V['UP_TOTAL'] : ''; ?></b></td></tr>
       <tr><td><i><?php echo isset($L['RELEASED']) ? $L['RELEASED'] : $V['L_RELEASED']; ?></i></td><td class="seedmed"><?php echo isset($V['RELEASED']) ? $V['RELEASED'] : ''; ?></td></tr>
       <tr><td><i><?php echo isset($L['BT_BONUS_UP']) ? $L['BT_BONUS_UP'] : $V['L_BT_BONUS_UP']; ?></i></td><td class="seedmed"><?php echo isset($V['UP_BONUS']) ? $V['UP_BONUS'] : ''; ?></td></tr>
       </table>
     </div><?php } ?>

	<?php if (!empty($bb_cfg['sidebar1_static_content_path'])) include($bb_cfg['sidebar1_static_content_path']); ?>
	<img width="210" class="spacer" src="<?php echo isset($V['SPACER']) ? $V['SPACER'] : ''; ?>" alt="" />

   </div><!--/sidebar1-wrap-->
  </td><!--/sidebar1-->
<?php } ?>

<!--main_content-->
  <td id="main_content">
   <div id="main_content_wrap">
    <?php if (!empty($V['SHOW_LATEST_NEWS'])) { ?>
    <!--latest_news-->
     <div id="latest_news">
      <table cellspacing="0" cellpadding="0" width="100%">
       <tr>
        <td width="70%">
         <h3><?php echo isset($L['LATEST_NEWS']) ? $L['LATEST_NEWS'] : $V['L_LATEST_NEWS']; ?></h3>
          <table cellpadding="0">
            <?php

$news_count = ( isset($this->_tpldata['news.']) ) ?  sizeof($this->_tpldata['news.']) : 0;
for ($news_i = 0; $news_i < $news_count; $news_i++)
{
 $news_item = &$this->_tpldata['news.'][$news_i];
 $news_item['S_ROW_COUNT'] = $news_i;
 $news_item['S_NUM_ROWS'] = $news_count;

?>
             <tr>
               <td><div class="news_date"><?php echo isset($news_item['NEWS_TIME']) ? $news_item['NEWS_TIME'] : ''; ?></div></td>
               <td width="100%"><div class="news_title<?php if ($news_item['NEWS_IS_NEW']) { ?> new<?php } ?>"><a href="<?php echo isset($V['TOPIC_URL']) ? $V['TOPIC_URL'] : ''; ?><?php echo isset($news_item['NEWS_TOPIC_ID']) ? $news_item['NEWS_TOPIC_ID'] : ''; ?>"><?php echo isset($news_item['NEWS_TITLE']) ? $news_item['NEWS_TITLE'] : ''; ?></a></div></td>
             </tr>
            <?php

} // END news

if(isset($news_item)) { unset($news_item); } 

?>
          </table>
      </table>
     </div>
     <!--/latest_news-->
<?php } ?>

<?php if (!empty($V['AD_BLOCK_200'])) { ?><div id="ad-200"><?php echo isset($V['AD_BLOCK_200']) ? $V['AD_BLOCK_200'] : ''; ?></div><!--/ad-200--><?php } elseif (!empty($V['AD_BLOCK_100'])) { ?><div id="ad-100"><?php echo isset($V['AD_BLOCK_100']) ? $V['AD_BLOCK_100'] : ''; ?></div><!--/ad-100--><?php } ?>

<!--=======================-->
<?php } ?>
<!--***********************-->

<?php if (!empty($V['ERROR_MESSAGE'])) { ?>
<div class="info_msg_wrap">
<table class="error">
	<tr><td><div class="msg"><?php echo isset($V['ERROR_MESSAGE']) ? $V['ERROR_MESSAGE'] : ''; ?></div></td></tr>
</table>
</div>
<?php } ?>

<?php if (!empty($V['INFO_MESSAGE'])) { ?>
<div class="info_msg_wrap">
<table class="info_msg">
	<tr><td><div class="msg"><?php echo isset($V['INFO_MESSAGE']) ? $V['INFO_MESSAGE'] : ''; ?></div></td></tr>
</table>
</div>
<?php } ?>

<!-- page_header.tpl END -->
<!-- module_xx.tpl START -->