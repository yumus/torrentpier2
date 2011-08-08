
<script type="text/javascript">
ajax.callback.user_register = function(data){
	$('#'+ data.mode).html(data.html);
};
</script>

<h1 class="pagetitle">{PAGE_TITLE}</h1>

<p class="nav"><a href="{U_INDEX}">{T_INDEX}</a></p>

<form method="post" action="profile.php" class="tokenized" enctype="multipart/form-data">
<input type="hidden" name="mode" value="{MODE}" />
<input type="hidden" name="reg_agreed" value="1" />
<!-- IF ADM_EDIT -->
<input type="hidden" name="u" value="{PR_USER_ID}" />
<!-- ENDIF -->

<table class="forumline usercp_register">
<col class="row1" width="35%">
<col class="row2" width="65%">
<tbody class="pad_4">
<tr>
	<th colspan="2">{L_REGISTRATION_INFO}</th>
</tr>
<tr>
	<td class="row2 small" colspan="2">{L_ITEMS_REQUIRED}</td>
</tr>
<tr>
	<td>{L_USERNAME}: *</td>
	<td><!-- IF CAN_EDIT_USERNAME --><input id="username" onBlur="ajax.exec({ action: 'user_register', mode: 'check_name', username: $('#username').val()}); return false;" type="text" name="username" size="35" maxlength="25" value="{USERNAME}" /><!-- ELSE --><b>{USERNAME}</b><!-- ENDIF -->
    &nbsp;<span id="check_name"></span></td>
</tr>
<tr>
	<td>{L_EMAIL}: * <!-- IF EDIT_PROFILE --><!-- ELSE IF $bb_cfg['reg_email_activation'] --><h6>{L_EMAIL_EXPLAIN}</h6><!-- ENDIF --></td>
	<td><input id="email" onBlur="ajax.exec({ action: 'user_register', mode: 'check_email', email: $('#email').val()}); return false;" type="text" name="user_email" size="35" maxlength="40" value="{USER_EMAIL}" <!-- IF EDIT_PROFILE --><!-- IF $bb_cfg['emailer_disabled'] -->readonly="readonly" style="color: gray;"<!-- ENDIF --><!-- ENDIF --> />
	    <span id="check_email"></span></td>
</tr>
<!-- IF EDIT_PROFILE and not ADM_EDIT -->
<tr>
	<td>{L_CURRENT_PASSWORD}: * <h6>{L_CONFIRM_PASSWORD_EXPLAIN}</h6></td>
	<td><input type="password" name="cur_pass" size="35" maxlength="32" value="" /></td>
</tr>
<!-- ENDIF -->
<tr>
	<td><!-- IF EDIT_PROFILE -->{L_NEW_PASSWORD}: * <h6>{L_PASSWORD_IF_CHANGED}</h6><!-- ELSE -->{L_PASSWORD}: *<!-- ENDIF --></td>
	<td><input id="pass" type="<!-- IF SHOW_PASS -->text<!-- ELSE -->password<!-- ENDIF -->" name="new_pass" size="35" maxlength="32" value="" /> &nbsp;<i class="med">{L_PASSWORD_LONG}</i></td>
</tr>
<tr>
	<td>{L_CONFIRM_PASSWORD}: * <!-- IF EDIT_PROFILE --><h6>{L_PASSWORD_CONFIRM_IF_CHANGED}</h6><!-- ENDIF --></td>
	<td><input id="pass_confirm" onBlur="ajax.exec({ action: 'user_register', mode: 'check_pass', pass: $('#pass').val(), pass_confirm: $('#pass_confirm').val() }); return false;" type="<!-- IF SHOW_PASS -->text<!-- ELSE -->password<!-- ENDIF -->" name="cfm_pass" size="35" maxlength="32" value="" />
	    <span id="check_pass"></span></td>
</tr>
<!-- IF CAPTCHA_HTML -->
<tr>
	<td>{L_CONFIRM_CODE}:</td>
	<td><span id="refresh_captcha">{CAPTCHA_HTML}</span> <img align="middle" src="/images/pic_loading.gif" title="{L_UPDATE}" onclick="ajax.exec({ action: 'user_register', mode: 'refresh_captcha'}); return false;"></td>
</tr>
<!-- ENDIF -->
<!-- IF EDIT_PROFILE -->
<!-- IF not ADM_EDIT -->
<tr>
	<td>{L_AUTOLOGIN}:</td>
	<td><a href="{U_RESET_AUTOLOGIN}">{L_RESET_AUTOLOGIN}</a><h6>{L_RESET_AUTOLOGIN_EXPL}</h6></td>
</tr>
<!-- ENDIF -->
<!-- BEGIN switch_bittorrent -->
<script type="text/javascript">
ajax.callback.gen_passkey = function(data){
	$('#passkey').text(data.passkey);
};
</script>
<tr>
	<th colspan="2"><a name="bittorrent"></a>TorrentPier</th>
</tr>
<tr>
	<td>{L_BT_GEN_PASSKEY}<h6>{L_BT_GEN_PASSKEY_EXPLAIN}</h6></td>
	<td class="med">{L_BT_GEN_PASSKEY_EXPLAIN_2}<br />{S_GEN_PASSKEY}</td>
</tr>
<tr>
	<td>{L_CURR_PASSKEY}</td>
	<td class="med" id="passkey">{CURR_PASSKEY}</td>
</tr>
<!-- END switch_bittorrent -->
<tr>
	<th colspan="2">{L_PROFILE_INFO}</th>
</tr>
<tr>
	<td>{L_GENDER}:</td>
	<td>{USER_GENDER}</td>
</tr>
<!-- IF BIRTHDAY -->
<tr>
	<td>{L_BIRTHDAY}:</td>
	<td>{BIRTHDAY}</td>
</tr>
<!-- ENDIF -->
<tr>
	<td>ICQ:</td>
	<td><input type="text" name="user_icq" size="30" maxlength="15" value="{USER_ICQ}" /></td>
</tr>
<tr>
	<td>{L_SKYPE}:</td>
	<td><input type="text" name="user_skype" size="30" maxlength="250" value="{USER_SKYPE}" /></td>
</tr>
<tr>
	<td>{L_WEBSITE}:</td>
	<td><input type="text" name="user_website" size="50" maxlength="100" value="{USER_WEBSITE}" /></td>
</tr>
<tr>
	<td>{L_OCCUPATION}:</td>
	<td><input type="text" name="user_occ" size="50" maxlength="100" value="{USER_OCC}" /></td>
</tr>
<tr>
	<td>{L_INTERESTS}:</td>
	<td><input type="text" name="user_interests" size="50" maxlength="150" value="{USER_INTERESTS}" /></td>
</tr>
<tr>
	<td>{L_LOCATION}:</td>
	<td>
		<div><input type="text" name="user_from" size="50" maxlength="100" value="{USER_FROM}" /></div>
	</td>
</tr>
<!-- ENDIF -->
<!-- IF $bb_cfg['allow_change']['language'] -->
<tr>
	<td>{L_BOARD_LANG}:</td>
	<td>{LANGUAGE_SELECT}</td>
</tr>
<!-- ENDIF -->
<tr>
	<td>{L_TIMEZONE}:</td>
	<td>{TIMEZONE_SELECT}</td>
</tr>
<!-- IF EDIT_PROFILE -->
<tr>
	<th colspan="2">{L_PREFERENCES}</th>
</tr>
<!-- IF not SIG_DISALLOWED -->
<tr colspan="2" id="view_message" class="hidden">
	<td colspan="2">
	    <div class="signature"></div>
	</td>
</tr>
<script type="text/javascript">
ajax.callback.posts = function(data){
    $('#view_message').show();
    $('.signature').html(data.message_html);
    initPostBBCode('.signature');
};
</script>
<!-- ENDIF -->
<tr>
	<td>{L_SIGNATURE}:<h6>{SIGNATURE_EXPLAIN}</h6></td>
	<!-- IF SIG_DISALLOWED -->
	<td class="tCenter">{L_SIGNATURE_DISABLE}</td>
	<!-- ELSE -->
	<td>
		<textarea id="user_sig" name="user_sig" rows="5" cols="60" style="width: 96%;">{USER_SIG}</textarea>
		<input type="button" value="{L_PREVIEW}" onclick="ajax.exec({ action: 'posts', type: 'view_message', message: $('textarea#user_sig').val() });">
	</td>
	<!-- ENDIF -->
</tr>

<tr>
	<td>{L_PUBLIC_VIEW_EMAIL}:</td>
	<td>
		<label><input type="radio" name="viewemail" value="1" <!-- IF VIEWEMAIL -->checked="checked"<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="viewemail" value="0" <!-- IF not VIEWEMAIL -->checked="checked"<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>
<tr>
	<td>{L_HIDE_USER}:</td>
	<td>
		<label><input type="radio" name="allow_viewonline" value="1" <!-- IF ALLOW_VIEWONLINE -->checked="checked"<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="allow_viewonline" value="0" <!-- IF not ALLOW_VIEWONLINE -->checked="checked"<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>
<tr>
	<td>{L_DENY_VISITORS}</td>
	<td>
		<label><input type="radio" name="view_profile" value="1" <!-- IF VIEW_PROFILE -->checked="checked"<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="view_profile" value="0" <!-- IF not VIEW_PROFILE -->checked="checked"<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>
<tr>
	<td>{L_ALWAYS_NOTIFY}:<h6>{L_ALWAYS_NOTIFY_EXPLAIN}</h6></td>
	<td>
		<label><input type="radio" name="notify" value="1" <!-- IF NOTIFY -->checked="checked"<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="notify" value="0" <!-- IF not NOTIFY -->checked="checked"<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>

<!-- IF $bb_cfg['pm_notify_enabled'] -->
<tr>
	<td>{L_NOTIFY_ON_PRIVMSG}:</td>
	<td>
		<label><input type="radio" name="notify_pm" value="1" <!-- IF NOTIFY_PM -->checked="checked"<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="notify_pm" value="0" <!-- IF not NOTIFY_PM -->checked="checked"<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>
<!-- ENDIF -->
<!-- IF $bb_cfg['porno_forums'] -->
<tr>
	<td>{L_HIDE_PORN_FORUMS}:</td>
	<td>
		<label><input type="radio" name="hide_porn_forums" value="1" <!-- IF HIDE_PORN_FORUMS -->checked="checked"<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="hide_porn_forums" value="0" <!-- IF not HIDE_PORN_FORUMS -->checked="checked"<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>
<!-- ENDIF -->
<!-- IF SHOW_DATEFORMAT -->
<tr>
	<td>{L_DATE_FORMAT}:<h6>{L_DATE_FORMAT_EXPLAIN}</h6></td>
	<td><input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14" /></td>
</tr>
<!-- ENDIF -->
<!-- BEGIN not_avatar_block -->
<tr>
	<th colspan="2">{L_AVATAR_PANEL}</th>
</tr>
<tr>
	<td colspan="2">
		<table class="borderless bCenter w80">
		<tr>
			<td>{L_AVATAR_DISABLE}</td>
			<td class="tCenter nowrap med">
				<p>{L_CURRENT_IMAGE}</p>
				<p class="mrg_6">{USER_AVATAR}</p>
			</td>
		</tr>
		</table>
	</td>
</tr>
<!-- END not_avatar_block -->
<!-- BEGIN switch_avatar_block -->
<tr>
	<th colspan="2">{L_AVATAR_PANEL}</th>
</tr>
<tr>
	<td colspan="2">
		<table class="borderless bCenter w80 med">
		<tr>
			<td>{AVATAR_EXPLAIN}</td>
			<td class="tCenter nowrap">
				<p>{L_CURRENT_IMAGE}</p>
				<p class="mrg_6">{USER_AVATAR}</p>
				<p><label><input type="checkbox" name="avatardel" /> {L_DELETE_IMAGE}</label></p>
			</td>
		</tr>
		</table>
	</td>
</tr>
<!-- BEGIN switch_avatar_local_upload -->
<tr>
	<td>{L_UPLOAD_AVATAR_FILE}:</td>
	<td>
		<input type="file" name="avatar" size="40" />
		<input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_SIZE}" />
	</td>
</tr>
<!-- END switch_avatar_local_upload -->
<!-- BEGIN switch_avatar_remote_upload -->
<tr>
	<td>{L_UPLOAD_AVATAR_URL}:<h6>{L_UPLOAD_AVATAR_URL_EXPLAIN}</h6></td>
	<td><input type="text" name="avatarurl" size="44" /></td>
</tr>
<!-- END switch_avatar_remote_upload -->
<!-- BEGIN switch_avatar_remote_link -->
<tr>
	<td>{L_LINK_REMOTE_AVATAR}:<h6>{L_LINK_REMOTE_AVATAR_EXPLAIN}</h6></td>
	<td><input type="text" name="avatarremoteurl" size="44" /></td>
</tr>
<!-- END switch_avatar_remote_link -->
<!-- BEGIN switch_avatar_local_gallery -->
<tr>
	<td>{L_AVATAR_GALLERY}:</td>
	<td><input type="submit" name="avatargallery" value="{L_VIEW_AVATAR_GALLERY}" class="lite" /></td>
</tr>
<!-- END switch_avatar_local_gallery -->
<!-- END switch_avatar_block -->
<!-- IF IS_ADMIN && ADM_EDIT -->
<tr>
	<th colspan="2">{L_MANAGE_USER}</th>
</tr>
<tr>
	<td>{L_USER_STATUS}</td>
	<td>
		<label><input type="radio" name="user_active" value="1" <!-- IF USER_ACTIVE -->checked="checked"<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="user_active" value="0" <!-- IF not USER_ACTIVE -->checked="checked"<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>
<tr>
	<td>{L_USER_DELETE}?</td>
	<td>
		<label><input type="checkbox" name="deleteuser">{L_USER_DELETE_EXPLAIN}</label>
		<br />
		<label><input type="checkbox" name="delete_user_posts">{L_DELETE_USER_POSTS}</label>
	</td>
</tr>
<!-- ENDIF -->
<!-- ENDIF / EDIT_PROFILE -->

<!-- IF SHOW_REG_AGREEMENT -->
<tr>
	<td class="row2" colspan="2">
	<style type="text/css">
	#infobox-wrap { width: 740px; }
	#infobox-body {
		background: #FFFFFF; color: #000000; padding: 1em;
		height: 300px; overflow: auto; border: 1px inset #000000;
	}
	</style>
	<div id="infobox-wrap" class="bCenter row1">
		<fieldset class="pad_6">
		<legend class="med bold mrg_2 warnColor1">{L_USER_AGREEMENT_HEAD}</legend>
			<div class="bCenter">
				<?php include($bb_cfg['user_agreement_html_path']) ?>
			</div>
			<p class="med bold mrg_4 tCenter"><label><input type="checkbox" value="" checked="checked" disabled="disabled" /> {L_USER_AGREEMENT_AGREE}</label></p>
		</fieldset>
	</div><!--/infobox-wrap-->
	</td>
</tr>
<!-- ENDIF / SHOW_REG_AGREEMENT -->

<tr>
	<td class="catBottom" colspan="2">
	<div id="submit-buttons">
		<!-- IF EDIT_PROFILE --><input type="reset" value="{L_RESET}" name="reset" class="lite" />&nbsp;&nbsp;<!-- ENDIF -->
		<input type="submit" name="submit" value="{L_SUBMIT}" class="main" />
	</div>
	</td>
</tr>

</tbody>
</table>

</form>