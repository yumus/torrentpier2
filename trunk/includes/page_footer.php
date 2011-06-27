<?php

if (!defined('BB_ROOT')) die(basename(__FILE__));

global $bb_cfg, $userdata, $template, $DBS, $lang;

$logged_in = !empty($userdata['session_logged_in']);

if (!empty($template))
{
	$template->assign_vars(array(
		'SIMPLE_FOOTER'    => !empty($gen_simple_header),

		'TRANSLATION_INFO' => isset($lang['TRANSLATION_INFO']) ? $lang['TRANSLATION_INFO'] : '',
		'SHOW_ADMIN_LINK'  => (IS_ADMIN && !defined('IN_ADMIN')),
		'ADMIN_LINK_HREF'  => "admin/index.php",
		'L_GOTO_ADMINCP'   => $lang['ADMIN_PANEL'],

	));

	$template->set_filenames(array('page_footer' => 'page_footer.tpl'));
	$template->pparse('page_footer');
}

$show_dbg_info = (DBG_USER && IS_ADMIN && !defined('IN_ADMIN'));

flush();

if ($show_dbg_info)
{
#	echo '</textarea></form></title></comment></a></div></span></ilayer></layer></iframe></noframes></style></noscript></table></script></applet></font>';

	$gen_time = utime() - TIMESTART;
	$gen_time_txt = sprintf('%.3f', $gen_time);
	$gzip_text = (UA_GZIP_SUPPORTED) ? 'GZIP' : '<s>GZIP</s>';
	$gzip_text .= ($bb_cfg['gzip_compress']) ? ' ON' : ' OFF';
	$debug_text = (DEBUG) ? 'Debug ON' : 'Debug OFF';

	$stat = '[&nbsp; ';
	$stat .= "Execution time: $gen_time_txt sec ";

	if (!empty($DBS))
	{
		$sql_t = $DBS->sql_timetotal;
		$sql_time_txt = ($sql_t) ? sprintf('%.3f sec (%d%%) in ', $sql_t, round($sql_t*100/$gen_time)) : '';
		$num_q = $DBS->num_queries;
		$stat .= " &nbsp;|&nbsp; MySQL: {$sql_time_txt}{$num_q} queries";
	}

	$stat .= " &nbsp;|&nbsp; $gzip_text";

	$stat .= ' &nbsp;|&nbsp; Mem: ';
	$stat .= humn_size($bb_cfg['mem_on_start'], 2) .' / ';
	$stat .= humn_size(sys('mem_peak'), 2) .' / ';
	$stat .= humn_size(sys('mem'), 2);

	if ($l = sys('la'))
	{
		$l = explode(' ', $l);
		for ($i=0; $i < 3; $i++)
		{
			$l[$i] = round($l[$i], 1);
			$l[$i] = (IS_ADMIN && $bb_cfg['max_srv_load'] && $l[$i] > ($bb_cfg['max_srv_load'] + 4)) ? "<span style='color: red'><b>$l[$i]</b></span>" : $l[$i];
		}
		$stat .= " &nbsp;|&nbsp; {$bb_cfg['node_name']} [{$bb_cfg['node_addr']}]<span title='�����: {$bb_cfg['max_srv_load']}'>: $l[0] $l[1] $l[2]</span>";
	}

	$stat .= ' &nbsp;]';

	echo '<div style="margin: 6px; font-size:10px; color: #444444; letter-spacing: -1px; text-align: center;">'. $stat .'</div>';
}

echo '
	</div><!--/body_container-->
';

if (DBG_USER && (SQL_DEBUG || PROFILER) && !defined('IN_ADMIN'))
{
	require(INC_DIR . 'page_footer_dev.php');
}

##### LOG #####
global $log_ip_resp;

if (isset($log_ip_resp[USER_IP]) || isset($log_ip_resp[CLIENT_IP]))
{
	$str = date('H:i:s') . LOG_SEPR . preg_replace("#\s+#", ' ', $contents) . LOG_LF;
	$file = 'sessions/'. date('m-d') .'_{'. USER_IP .'}_'. CLIENT_IP .'_resp';
	bb_log($str, $file);
}
### LOG END ###

if (DBG_USER && !empty($GLOBALS['timer_markers']))
{
	$GLOBALS['timer']->stop();
	$GLOBALS['timer']->display();
}

echo '
	</body>
	</html>
';

if (defined('REQUESTED_PAGE') && !defined('DISABLE_CACHING_OUTPUT'))
{
	if (IS_GUEST === true)
	{
		caching_output(true, 'store', REQUESTED_PAGE .'_guest');
	}
}

bb_exit();
