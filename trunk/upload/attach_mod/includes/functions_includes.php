<?php


/**
* Include the FAQ-File (faq.php)
*/
function attach_faq_include($lang_file)
{
	global $bb_cfg, $faq, $attach_config;

	if (intval($attach_config['disable_mod']))
	{
		return;
	}

	if ($lang_file == 'lang_faq')
	{
		$language = attach_mod_get_lang('lang_faq_attach');
		include(LANG_ROOT_DIR ."lang_$language/lang_faq_attach.php");
	}
}

/**
* Setup Basic Authentication
*/
// moved to auth

/**
* Setup Forum Authentication (admin/admin_forumauth.php)
*/
//admin/admin_forumauth.php


/**
* Setup Usergroup Authentication
*/
//admin/admin_ug_auth.php

/**
* Setup s_auth_can in viewforum and viewtopic (viewtopic.php/viewforum.php)
*/
function attach_build_auth_levels($is_auth, &$s_auth_can)
{
	global $lang, $attach_config, $forum_id;

	if (intval($attach_config['disable_mod']))
	{
		return;
	}

	// If you want to have the rules window link within the forum view too, comment out the two lines, and comment the third line
//	$rules_link = '(<a href="' . BB_ROOT . 'attach_rules.php?f=' . $forum_id . '" target="_blank">Rules</a>)';
//	$s_auth_can .= ( ( $is_auth['auth_attachments'] ) ? $rules_link . ' ' . $lang['RULES_ATTACH_CAN'] : $lang['RULES_ATTACH_CANNOT'] ) . '<br />';
	$s_auth_can .= (($is_auth['auth_attachments']) ? $lang['RULES_ATTACH_CAN'] : $lang['RULES_ATTACH_CANNOT'] ) . '<br />';

	$s_auth_can .= (($is_auth['auth_download']) ? $lang['RULES_DOWNLOAD_CAN'] : $lang['RULES_DOWNLOAD_CANNOT'] ) . '<br />';
}

/**
* Called from admin_users.php and admin_groups.php in order to process Quota Settings (admin/admin_users.php:admin/admin_groups.php)
*/
function attachment_quota_settings($admin_mode, $submit = false, $mode)
{
	global $template, $lang, $attach_config;

	if (!intval($attach_config['allow_ftp_upload']))
	{
		if ($attach_config['upload_dir'][0] == '/' || ($attach_config['upload_dir'][0] != '/' && $attach_config['upload_dir'][1] == ':'))
		{
			$upload_dir = $attach_config['upload_dir'];
		}
		else
		{
			$upload_dir = BB_ROOT . $attach_config['upload_dir'];
		}
	}
	else
	{
		$upload_dir = $attach_config['download_path'];
	}

	include(BB_ROOT .'attach_mod/includes/functions_selects.php');
	if (!function_exists("process_quota_settings"))
		include(BB_ROOT . 'attach_mod/includes/functions_admin.php');

	$user_id = 0;

	if ($admin_mode == 'user')
	{
		// We overwrite submit here... to be sure
		$submit = (isset($_POST['submit'])) ? true : false;

		if (!$submit && $mode != 'save')
		{
			$user_id = get_var(POST_USERS_URL, 0);
			$u_name = get_var('username', '');

			if (!$user_id && !$u_name)
			{
				message_die(GENERAL_MESSAGE, $lang['NO_USER_ID_SPECIFIED'] );
			}

			if ($user_id)
			{
				$this_userdata['user_id'] = $user_id;
			}
			else
			{
				// Get userdata is handling the sanitizing of username
				$this_userdata = get_userdata($_POST['username'], true);
			}

			$user_id = (int) $this_userdata['user_id'];
		}
		else
		{
			$user_id = get_var('id', 0);

			if (!$user_id)
			{
				message_die(GENERAL_MESSAGE, $lang['NO_USER_ID_SPECIFIED'] );
			}
		}
	}

	if ($admin_mode == 'user' && !$submit && $mode != 'save')
	{
		// Show the contents
		$sql = 'SELECT quota_limit_id, quota_type FROM ' . BB_QUOTA . '
			WHERE user_id = ' . (int) $user_id;

		if( !($result = DB()->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Unable to get Quota Settings', '', __LINE__, __FILE__, $sql);
		}

		$pm_quota = $upload_quota = 0;

		if ($row = DB()->sql_fetchrow($result))
		{
			do
			{
				if ($row['quota_type'] == QUOTA_UPLOAD_LIMIT)
				{
					$upload_quota = $row['quota_limit_id'];
				}
				else if ($row['quota_type'] == QUOTA_PM_LIMIT)
				{
					$pm_quota = $row['quota_limit_id'];
				}
			}
			while ($row = DB()->sql_fetchrow($result));
		}
		else
		{
			// Set Default Quota Limit
			$upload_quota = $attach_config['default_upload_quota'];
			$pm_quota = $attach_config['default_pm_quota'];

		}
		DB()->sql_freeresult($result);

		$template->assign_vars(array(
			'S_SELECT_UPLOAD_QUOTA'		=> quota_limit_select('user_upload_quota', $upload_quota),
			'S_SELECT_PM_QUOTA'			=> quota_limit_select('user_pm_quota', $pm_quota),
		));
	}

	if ($admin_mode == 'user' && $submit && @$_POST['deleteuser'])
	{
		process_quota_settings($admin_mode, $user_id, QUOTA_UPLOAD_LIMIT, 0);
		process_quota_settings($admin_mode, $user_id, QUOTA_PM_LIMIT, 0);
	}
	else if ($admin_mode == 'user' && $submit && $mode == 'save')
	{
		// Get the contents
		$upload_quota = get_var('user_upload_quota', 0);
		$pm_quota = get_var('user_pm_quota', 0);

		process_quota_settings($admin_mode, $user_id, QUOTA_UPLOAD_LIMIT, $upload_quota);
		process_quota_settings($admin_mode, $user_id, QUOTA_PM_LIMIT, $pm_quota);
	}

	if ($admin_mode == 'group' && $mode == 'newgroup')
	{
		return;
	}

	if ($admin_mode == 'group' && !$submit && isset($_POST['edit']))
	{
		// Get group id again, we do not trust phpBB here, Mods may be installed ;)
		$group_id = get_var(POST_GROUPS_URL, 0);

		// Show the contents
		$sql = 'SELECT quota_limit_id, quota_type FROM ' . BB_QUOTA . '
			WHERE group_id = ' . (int) $group_id;

		if( !($result = DB()->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Unable to get Quota Settings', '', __LINE__, __FILE__, $sql);
		}

		$pm_quota = $upload_quota = 0;

		if ($row = DB()->sql_fetchrow($result))
		{
			do
			{
				if ($row['quota_type'] == QUOTA_UPLOAD_LIMIT)
				{
					$upload_quota = $row['quota_limit_id'];
				}
				else if ($row['quota_type'] == QUOTA_PM_LIMIT)
				{
					$pm_quota = $row['quota_limit_id'];
				}
			}
			while ($row = DB()->sql_fetchrow($result));
		}
		else
		{
			// Set Default Quota Limit
			$upload_quota = $attach_config['default_upload_quota'];
			$pm_quota = $attach_config['default_pm_quota'];
		}
		DB()->sql_freeresult($result);

		$template->assign_vars(array(
			'S_SELECT_UPLOAD_QUOTA'	=> quota_limit_select('group_upload_quota', $upload_quota),
			'S_SELECT_PM_QUOTA'		=> quota_limit_select('group_pm_quota', $pm_quota),
		));
	}

	if ($admin_mode == 'group' && $submit && isset($_POST['group_delete']))
	{
		$group_id = get_var(POST_GROUPS_URL, 0);

		process_quota_settings($admin_mode, $group_id, QUOTA_UPLOAD_LIMIT, 0);
		process_quota_settings($admin_mode, $group_id, QUOTA_PM_LIMIT, 0);
	}
	else if ($admin_mode == 'group' && $submit)
	{
		$group_id = get_var(POST_GROUPS_URL, 0);

		// Get the contents
		$upload_quota = get_var('group_upload_quota', 0);
		$pm_quota = get_var('group_pm_quota', 0);

		process_quota_settings($admin_mode, $group_id, QUOTA_UPLOAD_LIMIT, $upload_quota);
		process_quota_settings($admin_mode, $group_id, QUOTA_PM_LIMIT, $pm_quota);
	}
}