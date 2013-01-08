<script type="text/javascript">
	ajax.callback.user_register = function (data) {
		$('#' + data.mode).html(data.html);
	};

	/** @Author: dimka3210
	 *  @Desc: Method autocomplete password
	 */
	var array_for_rand_pass = ["a", "A", "b", "B", "c", "C", "d", "D", "e", "E", "f", "F", "g", "G", "h", "H", "i", "I", "j", "J", "k", "K", "l", "L", "m", "M", "n", "N", "o", "O", "p", "P", "q", "Q", "r", "R", "s", "S", "t", "T", "u", "U", "v", "V", "w", "W", "x", "X", "y", "Y", "z", "Z", 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
	var array_rand = function (array) {
		var array_length = array.length;
		var result = Math.random() * array_length;
		return Math.floor(result);

	};

	var autocomplete = function (noCenter) {
		var string_result = ""; // Empty string
		for (var i = 1; i <= 8; i++) {
			string_result += array_for_rand_pass[array_rand(array_for_rand_pass)];
		}

		var _popup_left = (Math.ceil(window.screen.availWidth / 2) - 150);
		var _popup_top = (Math.ceil(window.screen.availHeight / 2) - 50);

		if (!noCenter) {
			jQuery("div#autocomplete_popup").css({
				left:_popup_left + "px",
				top:_popup_top + "px"
			}).show(1000);
		} else {
			jQuery("div#autocomplete_popup").show(1000);
		}

		jQuery("input#pass, input#pass_confirm, div#autocomplete_popup input").each(function () {
			jQuery(this).val(string_result);
		});
	};

	jQuery(document).ready(function () {
		jQuery("span#autocomplete").click(function() {
			autocomplete();
		});

		/**
		 * @Author: dimka3210
		 * @Desc: А давайте окно сделаем перемещаемым.
		 */
		var _X, _Y;
		var _bMoveble = false;

		jQuery("div#autocomplete_popup div.title").mousedown(function (event) {
			_bMoveble = true;
			_X = event.clientX;
			_Y = event.clientY;
		});

		jQuery("div#autocomplete_popup div.title").mousemove(function (event) {
			var jFrame = jQuery("div#autocomplete_popup");
			var jFLeft = parseInt(jFrame.css("left"));
			var jFTop = parseInt(jFrame.css("top"));

			if (_bMoveble) {
				if (event.clientX < _X) {
					jFrame.css("left", jFLeft - (_X - event.clientX) + "px");
				} else {
					jFrame.css("left", (jFLeft + (event.clientX - _X)) + "px");
				}

				if (event.clientY < _Y) {
					jFrame.css("top", jFTop - (_Y - event.clientY) + "px");
				} else {
					jFrame.css("top", (jFTop + (event.clientY - _Y)) + "px");
				}

				_X = event.clientX;
				_Y = event.clientY;
			}
		});

		jQuery("div#autocomplete_popup div.title").mouseup(function () {
			_bMoveble = false;
		}).mouseout(function () {
					_bMoveble = false;
				});


	});
</script>
<div id="autocomplete_popup">
	<div class="relative">
		<div class="close" onclick="jQuery('div#autocomplete_popup').hide();"></div>
		<div class="title">{L_YOUR_NEW_PASSWORD}</div>
		<div>
			<input value="" autocomplete="off" type="text"/>
			<span class="regenerate" title="{L_REGENERATE}" onclick="autocomplete(true)"
				  title=""></span>
		</div>
	</div>
</div>
<h1 class="pagetitle">{PAGE_TITLE}</h1>

<p class="nav"><a href="{U_INDEX}">{T_INDEX}</a></p>

<form method="post" action="profile.php" class="tokenized" enctype="multipart/form-data">
<input type="hidden" name="mode" value="{MODE}"/>
<input type="hidden" name="reg_agreed" value="1"/>
<!-- IF NEW_USER --><input type="hidden" name="admin" value="1"/><!-- ENDIF -->
<!-- IF ADM_EDIT -->
<input type="hidden" name="u" value="{PR_USER_ID}"/>
<!-- ENDIF -->
<!-- IF not ADM_EDIT -->
<script type="text/javascript">
	x = new Date();
	tz = -x.getTimezoneOffset() / 60;
	document.write('<input type="hidden" name="user_timezone" value="' + tz + '" />');
</script>
<!-- ELSE -->
<input type="hidden" name="user_timezone" value="{USER_TIMEZONE}"/>
<!-- ENDIF -->

<table class="forumline usercp_register">
<col class="row1" width="35%">
<col class="row2" width="65%">
<tbody class="pad_4">
<tr>
	<th colspan="2">{L_REGISTRATION_INFO}</th>
</tr>
<tr class="row3 med">
	<td class="bold" colspan="2">{L_ITEMS_REQUIRED}</td>
</tr>
<tr>
	<td>{L_USERNAME}: *</td>
	<td><!-- IF CAN_EDIT_USERNAME --><input id="username"
											onBlur="ajax.exec({ action: 'user_register', mode: 'check_name', username: $('#username').val()}); return false;"
											type="text" name="username" size="35" maxlength="25" value="{USERNAME}"/><!-- ELSE --><b>{USERNAME}</b><!-- ENDIF -->
		<span id="check_name"></span></td>
</tr>
<tr>
	<td>{L_EMAIL}: * <!-- IF EDIT_PROFILE --><!-- ELSE IF $bb_cfg['reg_email_activation'] --><h6>{L_EMAIL_EXPLAIN}</h6>
		<!-- ENDIF --></td>
	<td><input id="email"
			   onBlur="ajax.exec({ action: 'user_register', mode: 'check_email', email: $('#email').val()}); return false;"
			   type="text" name="user_email" size="35" maxlength="40" value="{USER_EMAIL}" <!-- IF EDIT_PROFILE -->
		<!-- IF $bb_cfg['emailer_disabled'] -->readonly="readonly" style="color: gray;"<!-- ENDIF --><!-- ENDIF --> />
		<span id="check_email"></span></td>
</tr>
<!-- IF EDIT_PROFILE and not ADM_EDIT -->
<tr>
	<td>{L_CURRENT_PASSWORD}: * <h6>{L_CONFIRM_PASSWORD_EXPLAIN}</h6></td>
	<td><input type="password" name="cur_pass" size="35" maxlength="32" value="" autocomplete="off"/></td>
</tr>
<!-- ENDIF -->
<tr>
	<td><!-- IF EDIT_PROFILE -->{L_NEW_PASSWORD}: * <h6>{L_PASSWORD_IF_CHANGED}</h6><!-- ELSE -->{L_PASSWORD}: *
		<!-- ENDIF --></td>
	<td><input id="pass" type="<!-- IF SHOW_PASS -->text<!-- ELSE -->password<!-- ENDIF -->" name="new_pass" size="35"
			   maxlength="32" value="" autocomplete="off"/>&nbsp;<span id="autocomplete"
																	   title="{L_AUTOCOMPLETE}">◄</span> &nbsp;<i
			class="med">{L_PASSWORD_LONG}</i></td>
</tr>
<tr>
	<td>{L_CONFIRM_PASSWORD}: * <!-- IF EDIT_PROFILE --><h6>{L_PASSWORD_CONFIRM_IF_CHANGED}</h6><!-- ENDIF --></td>
	<td><input id="pass_confirm"
			   onBlur="ajax.exec({ action: 'user_register', mode: 'check_pass', pass: $('#pass').val(), pass_confirm: $('#pass_confirm').val() }); return false;"
			   type="<!-- IF SHOW_PASS -->text<!-- ELSE -->password<!-- ENDIF -->" name="cfm_pass" size="35"
			   maxlength="32" value=""/>
		<span id="check_pass"></span></td>
</tr>
<!-- IF CAPTCHA_HTML -->
<tr>
	<td>{L_CONFIRM_CODE}:</td>
	<td><span id="refresh_captcha">{CAPTCHA_HTML}</span> <img align="middle" src="/images/pic_loading.gif"
															  title="{L_UPDATE}"
															  onclick="ajax.exec({ action: 'user_register', mode: 'refresh_captcha'}); return false;">
	</td>
</tr>
<!-- ENDIF -->
<!-- IF EDIT_PROFILE -->
<!-- IF not ADM_EDIT -->
<tr>
	<td>{L_AUTOLOGIN}:</td>
	<td><a href="{U_RESET_AUTOLOGIN}">{L_RESET_AUTOLOGIN}</a><h6>{L_RESET_AUTOLOGIN_EXPL}</h6></td>
</tr>
<!-- ENDIF -->
<tr>
	<th colspan="2">{L_PROFILE_INFO}</th>
</tr>
<!-- IF $bb_cfg['gender'] -->
<tr>
	<td>{L_GENDER}:</td>
	<td>{USER_GENDER}</td>
</tr>
<!-- ENDIF -->
<!-- IF BIRTHDAY -->
<tr>
	<td>{L_BIRTHDAY}:</td>
	<td>{BIRTHDAY}</td>
</tr>
<!-- ENDIF -->
<tr>
	<td>ICQ:</td>
	<td><input type="text" name="user_icq" size="30" maxlength="15" value="{USER_ICQ}"/></td>
</tr>
<tr>
	<td>{L_SKYPE}:</td>
	<td><input type="text" name="user_skype" size="30" maxlength="250" value="{USER_SKYPE}"/></td>
</tr>
<tr>
	<td>{L_WEBSITE}:</td>
	<td><input type="text" name="user_website" size="50" maxlength="100" value="{USER_WEBSITE}"/></td>
</tr>
<tr>
	<td>{L_OCCUPATION}:</td>
	<td><input type="text" name="user_occ" size="50" maxlength="100" value="{USER_OCC}"/></td>
</tr>
<tr>
	<td>{L_INTERESTS}:</td>
	<td><input type="text" name="user_interests" size="50" maxlength="150" value="{USER_INTERESTS}"/></td>
</tr>
<tr>
	<td>{L_LOCATION}:</td>
	<td>
		<div><input type="text" name="user_from" size="50" maxlength="100" value="{USER_FROM}"/></div>
	</td>
</tr>
<!-- ENDIF -->
<!-- IF $bb_cfg['allow_change']['language'] -->
<tr>
	<td>{L_BOARD_LANG}:</td>
	<td>{LANGUAGE_SELECT}</td>
</tr>
<!-- ENDIF -->
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
	ajax.callback.posts = function (data) {
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
		<input type="button" value="{L_PREVIEW}"
			   onclick="ajax.exec({ action: 'posts', type: 'view_message', message: $('textarea#user_sig').val() });">
	</td>
	<!-- ENDIF -->
</tr>

<tr>
	<td>{L_PUBLIC_VIEW_EMAIL}:</td>
	<td>
		<label><input type="radio" name="viewemail" value="1" <!-- IF VIEWEMAIL -->checked="checked"<!-- ENDIF -->
			/>{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="viewemail" value="0" <!-- IF not VIEWEMAIL -->checked="checked"<!-- ENDIF -->
			/>{L_NO}</label>
	</td>
</tr>
<tr>
	<td>{L_HIDE_USER}:</td>
	<td>
		<label><input type="radio" name="allow_viewonline" value="1" <!-- IF ALLOW_VIEWONLINE -->checked="checked"
			<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="allow_viewonline" value="0" <!-- IF not ALLOW_VIEWONLINE -->checked="checked"
			<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>
<tr>
	<td>{L_DENY_VISITORS}:</td>
	<td>
		<label><input type="radio" name="allow_dls" value="1" <!-- IF ALLOW_DLS -->checked="checked"<!-- ENDIF -->
			/>{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="allow_dls" value="0" <!-- IF not ALLOW_DLS -->checked="checked"<!-- ENDIF -->
			/>{L_NO}</label>
	</td>
</tr>
<tr>
	<td>{L_ALWAYS_NOTIFY}:<h6>{L_ALWAYS_NOTIFY_EXPLAIN}</h6></td>
	<td>
		<label><input type="radio" name="notify" value="1" <!-- IF NOTIFY -->checked="checked"<!-- ENDIF --> />{L_YES}
		</label>&nbsp;&nbsp;
		<label><input type="radio" name="notify" value="0" <!-- IF not NOTIFY -->checked="checked"<!-- ENDIF -->
			/>{L_NO}</label>
	</td>
</tr>

<!-- IF $bb_cfg['pm_notify_enabled'] -->
<tr>
	<td>{L_NOTIFY_ON_PRIVMSG}:</td>
	<td>
		<label><input type="radio" name="notify_pm" value="1" <!-- IF NOTIFY_PM -->checked="checked"<!-- ENDIF -->
			/>{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="notify_pm" value="0" <!-- IF not NOTIFY_PM -->checked="checked"<!-- ENDIF -->
			/>{L_NO}</label>
	</td>
</tr>
<!-- ENDIF -->
<tr>
	<td>{L_HIDE_PORN_FORUMS}:</td>
	<td>
		<label><input type="radio" name="hide_porn_forums" value="1" <!-- IF HIDE_PORN_FORUMS -->checked="checked"
			<!-- ENDIF --> />{L_YES}</label>&nbsp;&nbsp;
		<label><input type="radio" name="hide_porn_forums" value="0" <!-- IF not HIDE_PORN_FORUMS -->checked="checked"
			<!-- ENDIF --> />{L_NO}</label>
	</td>
</tr>
<!-- IF SHOW_DATEFORMAT -->
<tr>
	<td>{L_DATE_FORMAT}:<h6>{L_DATE_FORMAT_EXPLAIN}</h6></td>
	<td><input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14"/></td>
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

					<p><label><input type="checkbox" name="avatardel"/> {L_DELETE_IMAGE}</label></p>
				</td>
			</tr>
		</table>
	</td>
</tr>
<!-- BEGIN switch_avatar_local_upload -->
<tr>
	<td>{L_UPLOAD_AVATAR_FILE}:</td>
	<td>
		<input type="file" name="avatar" size="40"/>
		<input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_SIZE}"/>
	</td>
</tr>
<!-- END switch_avatar_local_upload -->
<!-- BEGIN switch_avatar_remote_upload -->
<tr>
	<td>{L_UPLOAD_AVATAR_URL}:<h6>{L_UPLOAD_AVATAR_URL_EXPLAIN}</h6></td>
	<td><input type="text" name="avatarurl" size="44"/></td>
</tr>
<!-- END switch_avatar_remote_upload -->
<!-- BEGIN switch_avatar_remote_link -->
<tr>
	<td>{L_LINK_REMOTE_AVATAR}:<h6>{L_LINK_REMOTE_AVATAR_EXPLAIN}</h6></td>
	<td><input type="text" name="avatarremoteurl" size="44"/></td>
</tr>
<!-- END switch_avatar_remote_link -->
<!-- BEGIN switch_avatar_local_gallery -->
<tr>
	<td>{L_AVATAR_GALLERY}:</td>
	<td><input type="submit" name="avatargallery" value="{L_VIEW_AVATAR_GALLERY}" class="lite"/></td>
</tr>
<!-- END switch_avatar_local_gallery -->
<!-- END switch_avatar_block -->
<!-- ENDIF / EDIT_PROFILE -->

<!-- IF SHOW_REG_AGREEMENT -->
<tr>
	<td class="row2" colspan="2">
		<div id="infobox-wrap" class="bCenter row1">
			<fieldset class="pad_6">
				<legend class="med bold mrg_2 warnColor1">{L_USER_AGREEMENT_HEAD}</legend>
				<div class="bCenter">
					<?php include($bb_cfg['user_agreement_html_path']) ?>
				</div>
				<p class="med bold mrg_4 tCenter"><label><input type="checkbox" value="" checked="checked"
																disabled="disabled"/> {L_USER_AGREEMENT_AGREE}</label>
				</p>
			</fieldset>
		</div>
		<!--/infobox-wrap-->
	</td>
</tr>
<!-- ENDIF / SHOW_REG_AGREEMENT -->

<tr>
	<td class="catBottom" colspan="2">
		<div id="submit-buttons">
			<!-- IF EDIT_PROFILE --><input type="reset" value="{L_RESET}" name="reset" class="lite"/>&nbsp;&nbsp;
			<!-- ENDIF -->
			<input type="submit" name="submit" value="{L_SUBMIT}" class="main"/>
		</div>
	</td>
</tr>

</tbody>
</table>

</form>