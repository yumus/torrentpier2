
<script type="text/javascript">
ajax.callback.user_register = function(data){
	$('#'+ data.mode).html(data.html);
};
</script>

<h1 class="pagetitle"><?php echo isset($V['PAGE_TITLE']) ? $V['PAGE_TITLE'] : ''; ?></h1>

<p class="nav"><a href="<?php echo isset($V['U_INDEX']) ? $V['U_INDEX'] : ''; ?>"><?php echo isset($V['T_INDEX']) ? $V['T_INDEX'] : ''; ?></a></p>

<form method="post" action="profile.php" class="tokenized" enctype="multipart/form-data">
<input type="hidden" name="mode" value="<?php echo isset($V['MODE']) ? $V['MODE'] : ''; ?>" />
<input type="hidden" name="reg_agreed" value="1" />
<?php if (!empty($V['ADM_EDIT'])) { ?>
<input type="hidden" name="u" value="<?php echo isset($V['PR_USER_ID']) ? $V['PR_USER_ID'] : ''; ?>" />
<?php } ?>

<table class="forumline usercp_register">
<col class="row1" width="35%">
<col class="row2" width="65%">
<tbody class="pad_4">
<tr>
	<th colspan="2">Регистрационная информация</th>
</tr>
<tr>
	<td class="row2 small" colspan="2">Поля отмеченные * обязательны к заполнению</td>
</tr>
<tr>
	<td>Имя: *</td>
	<td><?php if (!empty($V['CAN_EDIT_USERNAME'])) { ?><input id="username" onBlur="ajax.exec({ action: 'user_register', mode: 'check_name', username: $('#username').val()}); return false;" type="text" name="username" size="35" maxlength="25" value="<?php echo isset($V['USERNAME']) ? $V['USERNAME'] : ''; ?>" /><?php } else { ?><b><?php echo isset($V['USERNAME']) ? $V['USERNAME'] : ''; ?></b><?php } ?>
    &nbsp;<span id="check_name"></span></td>
</tr>
<tr>
	<td>Адрес email: * <?php if (!empty($V['EDIT_PROFILE'])) { ?><?php } else { ?><h6>На этот адрес вам будет отправлено письмо для завершения регистрации</h6><?php } ?></td>
	<td><input id="email" onBlur="ajax.exec({ action: 'user_register', mode: 'check_email', email: $('#email').val()}); return false;" type="text" name="user_email" size="35" maxlength="40" value="<?php echo isset($V['USER_EMAIL']) ? $V['USER_EMAIL'] : ''; ?>" <?php if (!empty($V['EDIT_PROFILE'])) { ?><?php if (!empty($bb_cfg['email_change_disabled'])) { ?>readonly="readonly" style="color: gray;"<?php } ?><?php } ?> />
	    <span id="check_email"></span></td>
</tr>
<?php if ($V['EDIT_PROFILE'] && ! $V['ADM_EDIT']) { ?>
<tr>
	<td>Текущий пароль: * <h6>Вы должны указать ваш текущий пароль, если хотите изменить его или поменять свой e-mail</h6></td>
	<td><input type="password" name="cur_pass" size="35" maxlength="20" value="" /></td>
</tr>
<?php } ?>
<tr>
	<td><?php if (!empty($V['EDIT_PROFILE'])) { ?>Новый пароль: * <h6>Указывайте пароль только если вы хотите его поменять</h6><?php } else { ?>Пароль: *<?php } ?></td>
	<td><input id="pass" type="<?php if (!empty($V['SHOW_PASS'])) { ?>text<?php } else { ?>password<?php } ?>" name="new_pass" size="35" maxlength="20" value="" /> &nbsp;<i class="med">максимум 20 символов</i></td>
</tr>
<tr>
	<td>Подтвердите пароль: * <?php if (!empty($V['EDIT_PROFILE'])) { ?><h6>Подтверждать пароль нужно в том случае, если вы изменили его выше</h6><?php } ?></td>
	<td><input id="pass_confirm" onBlur="ajax.exec({ action: 'user_register', mode: 'check_pass', pass: $('#pass').val(), pass_confirm: $('#pass_confirm').val() }); return false;" type="<?php if (!empty($V['SHOW_PASS'])) { ?>text<?php } else { ?>password<?php } ?>" name="cfm_pass" size="35" maxlength="20" value="" />
	    <span id="check_pass"></span></td>
</tr>
<?php if (!empty($V['CAPTCHA_HTML'])) { ?>
<tr>
	<td>Код подтверждения:</td>
	<td><?php echo isset($V['CAPTCHA_HTML']) ? $V['CAPTCHA_HTML'] : ''; ?></td>
</tr>
<?php } ?>
<?php if (!empty($V['EDIT_PROFILE'])) { ?>
<?php if (! $V['ADM_EDIT']) { ?>
<tr>
	<td><?php echo isset($L['AUTOLOGIN']) ? $L['AUTOLOGIN'] : $V['L_AUTOLOGIN']; ?>:</td>
	<td><a href="<?php echo isset($V['U_RESET_AUTOLOGIN']) ? $V['U_RESET_AUTOLOGIN'] : ''; ?>"><?php echo isset($L['RESET_AUTOLOGIN']) ? $L['RESET_AUTOLOGIN'] : $V['L_RESET_AUTOLOGIN']; ?></a><h6><?php echo isset($L['RESET_AUTOLOGIN_EXPL']) ? $L['RESET_AUTOLOGIN_EXPL'] : $V['L_RESET_AUTOLOGIN_EXPL']; ?></h6></td>
</tr>
<?php } ?>
<?php

$switch_bittorrent_count = ( isset($this->_tpldata['switch_bittorrent.']) ) ?  sizeof($this->_tpldata['switch_bittorrent.']) : 0;
for ($switch_bittorrent_i = 0; $switch_bittorrent_i < $switch_bittorrent_count; $switch_bittorrent_i++)
{
 $switch_bittorrent_item = &$this->_tpldata['switch_bittorrent.'][$switch_bittorrent_i];
 $switch_bittorrent_item['S_ROW_COUNT'] = $switch_bittorrent_i;
 $switch_bittorrent_item['S_NUM_ROWS'] = $switch_bittorrent_count;

?>
<tr>
	<th colspan="2"><a name="bittorrent"></a>TorrentPier</th>
</tr>
<tr>
	<td><?php echo isset($L['GEN_PASSKEY']) ? $L['GEN_PASSKEY'] : $V['L_GEN_PASSKEY']; ?><h6><?php echo isset($L['GEN_PASSKEY_EXPLAIN']) ? $L['GEN_PASSKEY_EXPLAIN'] : $V['L_GEN_PASSKEY_EXPLAIN']; ?></h6></td>
	<td class="med"><?php echo isset($L['GEN_PASSKEY_EXPLAIN_2']) ? $L['GEN_PASSKEY_EXPLAIN_2'] : $V['L_GEN_PASSKEY_EXPLAIN_2']; ?><br /><?php echo isset($V['S_GEN_PASSKEY']) ? $V['S_GEN_PASSKEY'] : ''; ?></td>
</tr>
<tr>
	<td><?php echo isset($L['CURR_PASSKEY']) ? $L['CURR_PASSKEY'] : $V['L_CURR_PASSKEY']; ?></td>
	<td class="med"><?php echo isset($V['CURR_PASSKEY']) ? $V['CURR_PASSKEY'] : ''; ?></td>
</tr>
<?php

} // END switch_bittorrent

if(isset($switch_bittorrent_item)) { unset($switch_bittorrent_item); } 

?>
<tr>
	<th colspan="2">Профиль</th>
</tr>
<tr>
	<td>Пол:</td>
	<td>
		<select name="user_gender" id="user_gender">
			<option value="0" <?php if (!empty($V['USER_GENDER_0'])) { ?>selected="selected"<?php } ?>>&nbsp;Не определилось&nbsp;</option>
			<option value="1" <?php if (!empty($V['USER_GENDER_1'])) { ?>selected="selected"<?php } ?>>&nbsp;Мужской&nbsp;</option>
			<option value="2" <?php if (!empty($V['USER_GENDER_2'])) { ?>selected="selected"<?php } ?>>&nbsp;Женский&nbsp;</option>
		</select>
	</td>
</tr>
<tr>
	<td>ICQ:</td>
	<td><input type="text" name="user_icq" size="30" maxlength="15" value="<?php echo isset($V['USER_ICQ']) ? $V['USER_ICQ'] : ''; ?>" /></td>
</tr>
<tr>
	<td>CommFort:</td>
	<td><input type="text" name="user_commfort" size="30" maxlength="15" value="<?php echo isset($V['USER_COMMFORT']) ? $V['USER_COMMFORT'] : ''; ?>" /></td>
</tr>
<tr>
	<td>Skype:</td>
	<td><input type="text" name="user_skype" size="30" maxlength="15" value="<?php echo isset($V['USER_SKYPE']) ? $V['USER_SKYPE'] : ''; ?>" /></td>
</tr>
<tr>
	<td>Сайт:</td>
	<td><input type="text" name="user_website" size="50" maxlength="100" value="<?php echo isset($V['USER_WEBSITE']) ? $V['USER_WEBSITE'] : ''; ?>" /></td>
</tr>
<tr>
	<td>Род занятий:</td>
	<td><input type="text" name="user_occ" size="50" maxlength="100" value="<?php echo isset($V['USER_OCC']) ? $V['USER_OCC'] : ''; ?>" /></td>
</tr>
<tr>
	<td>Интересы:</td>
	<td><input type="text" name="user_interests" size="50" maxlength="150" value="<?php echo isset($V['USER_INTERESTS']) ? $V['USER_INTERESTS'] : ''; ?>" /></td>
</tr>
<tr>
	<td>Откуда:</td>
	<td>
		<div><input type="text" name="user_from" size="50" maxlength="100" value="<?php echo isset($V['USER_FROM']) ? $V['USER_FROM'] : ''; ?>" /></div>
	</td>
</tr>
<?php } ?>
<tr>
	<td>Часовой пояс:</td>
	<td><?php echo isset($V['TIMEZONE_SELECT']) ? $V['TIMEZONE_SELECT'] : ''; ?></td>
</tr>
<?php if (!empty($V['EDIT_PROFILE'])) { ?>
<tr>
	<th colspan="2">Личные настройки</th>
</tr>
<?php if (!empty($V['SIG_DISALLOWED'])) { ?>
<tr>
	<td colspan="2" class="tCenter pad_12">Опция управления подписью отключена за нарушение <a href="<?php echo isset($bb_cfg['terms_and_conditions_url']) ? $bb_cfg['terms_and_conditions_url'] : ''; ?>"><b>правил форума</b></a></td>
</tr>
<?php } else { ?>
<tr>
	<td>Подпись:<h6>максимум <?php echo isset($bb_cfg['max_sig_chars']) ? $bb_cfg['max_sig_chars'] : ''; ?> символов</h6></td>
	<td><textarea name="user_sig" rows="5" cols="60" style="width: 96%;"><?php echo isset($V['USER_SIG']) ? $V['USER_SIG'] : ''; ?></textarea></td>
</tr>
<?php } ?>

<?php if (!empty($bb_cfg['pm_notify_enabled'])) { ?>
<tr>
	<td>Уведомлять о новых личных сообщениях:</td>
	<td>
		<label><input type="radio" name="notify_pm" value="1" <?php if (!empty($V['NOTIFY_PM'])) { ?>checked="checked"<?php } ?> />	Да</label>&nbsp;&nbsp;
		<label><input type="radio" name="notify_pm" value="0" <?php if (! $V['NOTIFY_PM']) { ?>checked="checked"<?php } ?> />	Нет</label>
	</td>
</tr>
<?php } ?>
<?php if (!empty($bb_cfg['porno_forums'])) { ?>
<tr>
	<td><?php echo isset($bb_cfg['lang_hide_porno_forums']) ? $bb_cfg['lang_hide_porno_forums'] : ''; ?>:</td>
	<td>
		<label><input type="radio" name="hide_porn_forums" value="1" <?php if (!empty($V['HIDE_PORN_FORUMS'])) { ?>checked="checked"<?php } ?> />	Да</label>&nbsp;&nbsp;
		<label><input type="radio" name="hide_porn_forums" value="0" <?php if (! $V['HIDE_PORN_FORUMS']) { ?>checked="checked"<?php } ?> />	Нет</label>
	</td>
</tr>
<?php } ?>


<?php } ?>

<?php if (!empty($V['SHOW_REG_AGREEMENT'])) { ?>
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
		<legend class="med bold mrg_2 warnColor1">Для продолжения регистрации Вы должны принять наше ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ</legend>
			<div class="bCenter">
				<?php include($bb_cfg['user_agreement_html_path']) ?>
			</div>
			<p class="med bold mrg_4 tCenter"><label><input type="checkbox" value="" checked="checked" disabled="disabled" /> Я прочел ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ и обязуюсь его не нарушать</label></p>
		</fieldset>
	</div><!--/infobox-wrap-->
	</td>
</tr>
<?php } ?>

<tr>
	<td class="catBottom" colspan="2">
	<div>
		<?php if (!empty($V['EDIT_PROFILE'])) { ?><input type="reset" value="Вернуть" name="reset" /> &nbsp; <?php } ?>
		<input type="submit" name="submit" value="Отправить<?php if (!empty($V['SHOW_REG_AGREEMENT'])) { ?> (Я согласен с условиями)<?php } ?>" class="bold" />
	</div>
	</td>
</tr>

</tbody>
</table>

</form>