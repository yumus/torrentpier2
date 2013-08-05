<!-- IF IS_ADMIN -->
<script type="text/javascript">
ajax.init.edit_user_profile = function(params){
	if (params.submit) {
		ajax.exec({
			action  : params.action,
			edit_id : params.id,
			user_id : params.user_id || {PROFILE_USER_ID},
			field   : params.field || params.id,
			value   : params.value
		});
	}
	else {
		editableType = params.editableType || "input";
		ajax.makeEditable(params.id, editableType);
	}
};
ajax.callback.edit_user_profile = function(data){
	ajax.restoreEditable(data.edit_id, data.new_value);
};

// change_user_rank
ajax.change_user_rank = function(uid, rank_id) {
	$('#rank-msg').html('<i class="loading-1">{L_LOADING}</i>');
	ajax.exec({
		action  : 'change_user_rank',
		user_id : uid,
		rank_id : rank_id
	});
}
ajax.callback.change_user_rank = function(data) {
	$('#rank-msg').html(data.html);
}

ajax.user_opt = {AJAX_USER_OPT};

// change_user_opt
ajax.change_user_opt = function() {
	ajax.exec({
		action   : 'change_user_opt',
		user_id  : {PROFILE_USER_ID},
		user_opt : $.toJSON(ajax.user_opt)
	});
};
ajax.callback.change_user_opt = function(data){
	$('#user-opt-resp').html(data.resp_html);
	$('#user-opt-save-btn').removeAttr('disabled');
}

$(document).ready(function(){
	$('#user-opt').find('input[type=checkbox]').click(function(){
		var $chbox = $(this);
		var opt_name = $chbox.attr('name');
		var opt_val  = $chbox.attr('checked') ? 1 : 0;
		ajax.user_opt[opt_name] = opt_val;
		$chbox.parents('label').toggleClass('bold');
		$('#user-opt-save').show();
	});
	$('#user-opt').find('input[type=checkbox]').each(function(){
		if (ajax.user_opt[ $(this).attr('name') ]) {
			$(this).attr({checked: 'checked'});
			$(this).parents('label').addClass('bold');
		}
	});
	$('#user-opt-save-btn').click(function(){
		this.disabled = 1;
		$('#user-opt-resp').html('&nbsp;');
		ajax.change_user_opt();
	});
});
</script>

<var class="ajax-params">{action: "edit_user_profile", id: "username"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_email"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_regdate"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_lastvisit"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_from"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_website"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_occ"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_interests"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_icq"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_skype"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_gender", editableType: "yesno-gender"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_birthday"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "u_up_total"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "u_down_total"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "u_up_release"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "u_up_bonus"}</var>
<var class="ajax-params">{action: "edit_user_profile", id: "user_points"}</var>

<script type="text/javascript">
ajax.callback.manage_user = function(data) {
	if(data.info) alert(data.info);
	if(data.url) document.location.href = data.url;
};
</script>
<!-- ENDIF / IS_ADMIN -->

<!-- IF IS_AM -->
<script type="text/javascript">
ajax.mod_action = function(mode) {
	ajax.exec({
		action  : 'mod_action',
		mode    : mode,
		user_id : {PROFILE_USER_ID}
	});
}
ajax.callback.mod_action = function(data) {
	$('#ip_list').toggle().html(data.ip_list_html);
}
</script>
<script type="text/javascript">
ajax.group_membership = function(mode) {
	$('#gr-mem-list').html('<i class="loading-1">{L_LOADING}</i>');
	ajax.exec({
		action  : 'group_membership',
		mode    : mode,
		user_id : {PROFILE_USER_ID}
	});
}
ajax.callback.group_membership = function(data) {
	$('#gr-mem-list').html(data.group_list_html);
}
</script>
<!-- ENDIF / IS_AM -->

<!-- IF TRAF_STATS -->
<script type="text/javascript">
ajax.index_data = function(mode) {
	ajax.exec({
		action  : 'index_data',
		mode    : mode,
		user_id : {PROFILE_USER_ID}
	});
}
ajax.callback.index_data = function(data) {
	$('#traf-stats-tbl').html(data.html);
	$('#bt_user_ratio').html(data.user_ratio);
	$('#traf-stats-span').hide();
	$('#traf-stats-tbl').show();
	$('#bt_user_ratio').show();
}
</script>
<!-- ENDIF -->

<!-- IF SHOW_PASSKEY -->
<script type="text/javascript">
ajax.callback.gen_passkey = function(data){
	$('#passkey').text(data.passkey);
};
</script>
<!-- ENDIF / SHOW_PASSKEY -->

<script type="text/javascript">
ajax.view_profile = function(mode) {
	ajax.exec({
		action  : 'view_profile',
		mode    : mode,
		user_id : {PROFILE_USER_ID}
	});
}
ajax.callback.view_profile = function(data) {
	$('#active_torrents').html(data.active_torrents);
}
</script>

<style type="text/css">
#traf-stats-tbl { width: 468px; background: #F9F9F9; border: 1px solid #A5AFB4; border-collapse: separate; }
#traf-stats-tbl th, #traf-stats-tbl td { padding: 2px 10px 3px; text-align: center; white-space: nowrap; font-size: 11px; }
#traf-stats-tbl th { padding: 2px <!-- IF $bb_cfg['seed_bonus_enabled'] -->11<!-- ELSE -->22<!-- ENDIF -->px 3px; }
</style>

<a name="editprofile"></a>
<h1 class="pagetitle">{L_VIEWING_PROFILE}</h1>

<div class="nav">
	<p class="floatL"><a href="{U_INDEX}">{T_INDEX}</a></p>
	<p class="floatR">
	<!-- IF IS_ADMIN || PROFILE_USER --><a href="{U_MANAGE}">{L_EDIT_PROFILE}</a><!-- ENDIF -->
	<!-- IF IS_ADMIN --> &middot; <a href="{U_PERMISSIONS}">{L_PERMISSIONS}</a><!-- ENDIF -->
	<div class="clear"></div>
</div>

<table class="user_profile bordered w100" cellpadding="0">
<tr>
	<th colspan="2" class="thHead">{L_VIEWING_PROFILE}</th>
</tr>
<tr>
	<td class="row1 vTop tCenter" width="30%">

		<p class="mrg_4">{AVATAR_IMG}</p>
		<p class="small mrg_4">
		<!-- IF IS_ADMIN -->
			{RANK_SELECT}
			<script type="text/javascript">
			$('#rank-sel').bind('change', function(){ ajax.change_user_rank( {PROFILE_USER_ID}, $(this).val() ); });
			</script>
			<div id="rank-msg" class="mrg_6"></div>
		<!-- ELSE IF POSTER_RANK -->
			{RANK_IMAGE}
		<!-- ENDIF -->
		</p>
		<h4 class="cat border bw_TB" id="username">{L_CONTACT} <span class="editable bold">{USERNAME}</span></h4>

		<table class="nowrap borderless user_contacts w100">
		<!-- IF EMAIL -->
		<tr>
			<th>{L_EMAIL_ADDRESS}:</th>
			<td class="tLeft med" id="user_email">{EMAIL}</td>
		</tr>
		<!-- ENDIF -->
		<!-- IF PM -->
		<tr>
			<th>{L_PRIVATE_MESSAGE}:</th>
			<td class="tLeft med">{PM}</td>
		</tr>
		<!-- ENDIF -->
		<!-- IF ICQ -->
		<tr>
			<th>{L_ICQ}:</th>
			<td class="tLeft med" id="user_icq">
				<span class="editable">{ICQ}
					<a href="http://www.icq.com/people/searched=1&uin={ICQ}"><img align="middle" src="http://web.icq.com/whitepages/online?icq={ICQ}&img=5"></a>
				</span>
			</td>
		</tr>
		<!-- ENDIF -->
		<!-- IF SKYPE -->
		<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
		<tr>
			<th>{L_SKYPE}:</th>
			<td class="tLeft med" id="user_skype">
				<span class="editable">{SKYPE}
					<a href="skype:{SKYPE}"><img align="middle" src="http://mystatus.skype.com/smallicon/{SKYPE}" width="16" height="16"></a>
				</span>
			</td>
		</tr>
		<!-- ENDIF -->
		</table><!--/user_contacts-->

		<!-- IF USER_RESTRICTIONS -->
		<fieldset class="mrg_6">
		<legend>{L_USER_NOT_ALLOWED}:</legend>
			<div class="tLeft" style="padding: 4px 6px 8px 2px;">
			<ul><li>{USER_RESTRICTIONS}</li></ul>
			</div>
		</fieldset>
		<!-- ENDIF -->

	</td>
	<td class="row1" valign="top" width="70%">

		<div class="spacer_4"></div>

		<!-- IF not USER_ACTIVE -->
		<h4 class="mrg_4 tCenter warnColor1">{L_DISABLED_USER}</h4>
		<!-- ENDIF -->

		<table class="user_details borderless w100">
			<!-- IF SHOW_ROLE -->
			<tr>
				<th>{L_ROLE}</th>
				<td id="role">
					<b>{POSTER_RANK}</b>
					<!-- IF GROUP_MEMBERSHIP and IS_MOD -->
					<span id="gr-mod-a">[ <a href="#" class="med" onclick="ajax.group_membership('get_group_list'); $('#gr-mem-tr').show(); $('#gr-mod-a').hide(); return false;">{L_MEMBERSHIP_IN}</a> ]</span>
					<!-- ENDIF -->
				</td>
			</tr>
			<!-- ENDIF -->
			<!-- IF GROUP_MEMBERSHIP -->
			<tr id="gr-mem-tr"<!-- IF IS_MOD --> style="display: none;"<!-- ENDIF -->>
				<th>{L_MEMBERSHIP_IN}:</th>
				<td id="gr-mem-list">
					<!-- IF IS_ADMIN --><a href="#" class="med" onclick="ajax.group_membership('get_group_list'); return false;">{GROUP_MEMBERSHIP_TXT}</a><!-- ENDIF -->
				</td>
			</tr>
			<!-- ENDIF -->
			<tr>
				<th>{L_JOINED}:</th>
				<td id="user_regdate">
					<span class="editable bold">{USER_REGDATE}</span>
					<!-- IF IS_ADMIN -->
					[ <a href="#admin" class="menu-root menu-alt1"><span class="adm">{L_MANAGE_USER}</span></a> ]
		            <div class="menu-sub row1 border bw_TRBL" id="admin">
			            <fieldset class="mrg_6">
			            <div class="tLeft" style="padding: 5px 6px 6px; display: block; font-size: 13px;">
				            <a href="#" onclick="ajax.exec({action : 'manage_user', mode: '<!-- IF USER_ACTIVE -->user_deactivate<!-- ELSE -->user_activate<!-- ENDIF -->', user_id : {PROFILE_USER_ID}}); return false;" class="<!-- IF USER_ACTIVE -->adm<!-- ELSE -->seed bold<!-- ENDIF -->"><!-- IF USER_ACTIVE -->{L_USER_DEACTIVATE}<!-- ELSE -->{L_USER_ACTIVATE}<!-- ENDIF --></a> <br />
					        <a href="#" onclick="ajax.exec({action : 'manage_user', mode: 'delete_profile', user_id : '{PROFILE_USER_ID}'}); return false;" class="adm">{L_USER_DELETE_EXPLAIN}</a> <br />
							<a href="#" onclick="ajax.exec({action : 'manage_user', mode: 'delete_topics', user_id : '{PROFILE_USER_ID}'}); return false;" class="adm">{L_DELETE_USER_ALL_POSTS}</a> <br />
                            <a href="#" onclick="ajax.exec({action : 'manage_user', mode: 'delete_message', user_id : '{PROFILE_USER_ID}'}); return false;" class="adm">{L_DELETE_USER_POSTS}</a> <br />
			            </div>
			            </fieldset>
						<fieldset class="mrg_6"><legend>{L_BAN_USER}</legend>
						<div class="tLeft" style="padding: 2px 6px 6px; display: block;" id="user-opt">
							<label><input type="checkbox" name="allow_avatar"/>{L_HIDE_AVATARS}</label>
							<label><input type="checkbox" name="allow_sig"/>{L_SHOW_CAPTION}</label>
							<label><input type="checkbox" name="allow_passkey"/>{L_DOWNLOAD_TORRENT}</label>
							<label><input type="checkbox" name="allow_pm"/>{L_SEND_PM}</label>
							<label><input type="checkbox" name="allow_post"/>{L_SEND_MESSAGE}</label>
							<label><input type="checkbox" name="allow_post_edit"/>{L_EDIT_POST}</label>
							<label><input type="checkbox" name="allow_topic"/>{L_NEW_THREADS}</label>
						</div>
						</fieldset>
						<div id="user-opt-save" class="hidden tCenter">
							<p><input id="user-opt-save-btn" class="bold long" type="button" value="{L_SUBMIT}" /></p>
							<p id="user-opt-resp" class="mrg_6"></p>
						</div>
					</div>
					<!-- ENDIF -->
					<!-- IF IS_AM -->[ <a href="#" class="adm" onclick="ajax.mod_action('profile_ip'); return false;">{L_IP_ADDRESS}</a> ]<!-- ENDIF -->
				</td>
			</tr>
			<tr>
				<th>{L_LAST_VISITED}:</th>
				<td id="user_lastvisit">
					<span class="editable bold">{LAST_VISIT_TIME}</span>
				</td>
			</tr>

		    <tr>
				<th class="nowrap">{L_LAST_ACTIVITY}:</th>
				<td>
				    <b>{LAST_ACTIVITY_TIME}</b>
					<!-- IF TRAF_STATS --><span id="traf-stats-span">[ <a href="#" id="traf-stats-btn" class="med" onclick="ajax.index_data('get_traf_stats'); return false;">{L_VIEWING_USER_BT_PROFILE}</a> ]</span><!-- ENDIF -->
					[ <a href="#torrent" class="med" onclick="ajax.view_profile('active_torrents'); return false;">{L_CUR_ACTIVE_DLS}</a> ]
				</td>
			</tr>
			<tr>
				<th>{L_TOTAL_POSTS}:</th>
				<td>
					<p>
						<b>{POSTS}</b>&nbsp;
						[ <a href="{U_SEARCH_USER}" class="med">{L_SEARCH_USER_POSTS}</a> ]
						[ <a href="{U_SEARCH_TOPICS}" class="med">{L_SEARCH_USER_TOPICS}</a> ]
						[ <a class="med" href="{U_SEARCH_RELEASES}">{L_SEARCH_RELEASES}</a> ]
						<!-- IF PROFILE_USER -->[ <a class="med" href="{U_WATCHED_TOPICS}">{L_WATCHED_TOPICS}</a> ]<!-- ENDIF -->
					</p>
				</td>
			</tr>

			<tr id="bt_user_ratio" <!-- IF TRAF_STATS -->style="display: none;"<!-- ENDIF -->>
			    <th>{L_USER_RATIO}:</th>
			    <td>
				    <!-- IF DOWN_TOTAL_BYTES gt MIN_DL_BYTES -->
				    <b id="u_ratio" class="gen">{USER_RATIO}</b>
				    [<a class="gen" href="#" onclick="toggle_block('ratio-expl'); return false;">?</a>]
				    <!-- ELSE -->
				    <span class="med" title="{L_IT_WILL_BE_DOWN} {MIN_DL_FOR_RATIO}"><b>{L_NONE}</b> (DL < {MIN_DL_FOR_RATIO})</span>
				    <!-- ENDIF -->

					<!-- IF SHOW_PASSKEY -->
					[ {L_BT_PASSKEY}:  <span id="passkey-btn"><a class="med" href="#" onclick="$('#passkey-gen').show(); $('#passkey-btn').hide(); return false;">{L_BT_PASSKEY_VIEW}</a></span>
					<span id="passkey-gen" class="med" style="display: none;">
						<b id="passkey" class="med bold">{AUTH_KEY}</b>&nbsp;
				        <a href="#" onclick="ajax.exec({ action: 'gen_passkey', user_id  : {PROFILE_USER_ID} }); return false;">{L_BT_GEN_PASSKEY}</a>
					</span> ]
					<!-- ENDIF -->
			    </td>
		    </tr>

		    <tr id="ratio-expl" style="display: none;">
			    <td colspan="2" class="med tCenter">
				( {L_UPLOADED} <b class="seedmed">{UP_TOTAL}</b> + {L_RELEASED} <b class="seedmed">{RELEASED}</b> + {L_BONUS} <b class="seedmed">{UP_BONUS}</b> ) / {L_DOWNLOADED} <b class="leechmed">{DOWN_TOTAL}</b>
			    </td>
		    </tr>

			<!-- IF LOCATION -->
			<tr>
				<th class="vBottom">{L_LOCATION}:</th>
				<td id="user_from"><b class="editable">{LOCATION}</b></td>
			</tr>
			<!-- ENDIF -->
			<!-- IF WWW -->
			<tr>
				<th>{L_WEBSITE}:</th>
				<td id="user_website"><a href="{WWW}" class="editable" target="_blank">{WWW}</a></td>
			</tr>
			<!-- ENDIF -->
			<!-- IF OCCUPATION -->
			<tr>
				<th>{L_OCCUPATION}:</th>
				<td id="user_occ"><b class="editable">{OCCUPATION}</b></td>
			</tr>
			<!-- ENDIF -->
			<!-- IF INTERESTS -->
			<tr>
				<th>{L_INTERESTS}:</th>
				<td id="user_interests"><b class="editable">{INTERESTS}</b></td>
			</tr>
			<!-- ENDIF -->
			<!-- IF GENDER -->
			<tr>
				<th>{L_GENDER}:</th>
				<td id="user_gender"><b class="editable">{GENDER}</b></td>
			</tr>
			<!-- ENDIF -->
			<!-- IF BIRTHDAY -->
			<tr>
				<th>{L_BIRTHDAY}:</th>
				<td id="user_birthday"><b class="editable">{BIRTHDAY}</b></td>
			</tr>
			<tr>
				<th>{L_AGE}:</th>
				<td><b>{AGE}</b></td>
			</tr>
			<!-- ENDIF -->
			<!-- IF SHOW_DRAFT -->
			<tr>
				<th>{L_DRAFTS}:</th>
				<td><a href="{U_DRAFTS}"><b>{COUNT_DRAFT}</b></a></td>
			</tr>
			<!-- ENDIF -->
		    <tr>
			    <td colspan="2" class="pad_4">

			    <table id="traf-stats-tbl" <!-- IF TRAF_STATS -->style="display: none;"<!-- ENDIF --> class="bCenter borderless" cellspacing="1">
			    <tr class="row3">
				    <th class="stats-ext"></th>
				    <th>{L_DOWNLOADED}</th>
				    <th>{L_UPLOADED}</th>
				    <th>{L_RELEASED}</th>
				    <th>{L_BONUS}</th>
				    <!-- IF $bb_cfg['seed_bonus_enabled'] --><th>{L_SEED_BONUS}</th><!-- ENDIF -->
			    </tr>
			    <tr class="row1 stats-ext">
			    	<td>{L_TD_TRAF}</td>
			    	<td class="leech">{TD_DL}</td>
			    	<td class="seed">{TD_UL}</td>
			    	<td class="seed">{TD_REL}</td>
				    <td class="seed">{TD_BONUS}</td>
				    <!-- IF $bb_cfg['seed_bonus_enabled'] --><td class="points">{TD_POINTS}</td><!-- ENDIF -->
			    </tr>
			    <tr class="row5 stats-ext">
				    <td>{L_YS_TRAF}</td>
				    <td class="leech">{YS_DL}</td>
				    <td class="seed">{YS_UL}</td>
				    <td class="seed">{YS_REL}</td>
				    <td class="seed">{YS_BONUS}</td>
				    <!-- IF $bb_cfg['seed_bonus_enabled'] --><td class="points">{YS_POINTS}</td><!-- ENDIF -->
			    </tr>
			    <tr class="row1">
				    <td class="stats-ext">{L_TOTAL_TRAF}</td>
				    <td id="u_down_total"><span class="editable bold leechmed">{DOWN_TOTAL}</span></td>
				    <td id="u_up_total"><span class="editable bold seedmed">{UP_TOTAL}</span></td>
				    <td id="u_up_release"><span class="editable bold seedmed">{RELEASED}</span></td>
				    <td id="u_up_bonus"><span class="editable bold seedmed">{UP_BONUS}</span></td>
				    <!-- IF $bb_cfg['seed_bonus_enabled'] --><td id="user_points"><span class="editable bold points">{USER_POINTS}</b></td><!-- ENDIF -->
			    </tr>
			    <tr class="row5">
				    <td colspan="1">{L_MAX_SPEED}</td>
				    <td colspan="2">{L_DL_DL_SPEED}: {SPEED_DOWN}</td>
				    <td colspan="2">{L_DL_UL_SPEED}: {SPEED_UP}</td>
				    <!-- IF $bb_cfg['seed_bonus_enabled'] --><td colspan="1"><!-- IF PROFILE_USER --><a href="profile.php?mode=bonus">{L_EXCHANGE}</a><!-- ENDIF --></td><!-- ENDIF -->
			    </tr>
			</table>

			</td>
		</tr>

		</table><!--/user_details-->

	<!-- IF IS_AM --><span id="ip_list"></span><!-- ENDIF -->

	</td>
</tr>
<!-- IF SIGNATURE -->
<tr>
	<td class="row1 pad_4" colspan="2">
	    <div class="signature">{SIGNATURE}</div>
	</td>
</tr>
<!-- ENDIF -->

<!-- BEGIN switch_report_user -->
<tr>
	<td class="catBottom" align="center" colspan="2"><a href="{U_REPORT_USER}" class="gen">{L_REPORT_USER}</a></td>
</tr>
<!-- END switch_report_user -->

</table><!--/user_profile-->

<div id="active_torrents"></div>

<!--bottom_info-->
<div class="bottom_info">

	<div class="spacer_6"></div>

	<div id="timezone">
		<p>{LAST_VISIT_DATE}</p>
		<p>{CURRENT_TIME}</p>
		<p>{S_TIMEZONE}</p>
	</div>
	<div class="clear"></div>

</div><!--/bottom_info-->