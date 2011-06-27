<?php

function get_sql_log ()
{
	global $bb_cfg, $DBS, $CACHES, $sphinx, $datastore;

	$log = '';

	foreach ($DBS->srv as $srv_name => $db_obj)
	{
		$log .= !empty($db_obj) ? get_sql_log_html($db_obj, "$srv_name [MySQL]") : '';
	}
	foreach ($CACHES->obj as $cache_name => $cache_obj)
	{
		$log .= !empty($cache_obj->db) ? get_sql_log_html($cache_obj->db, "cache: $cache_name [{$cache_obj->db->engine}]") : '';
	}

	$log .= !empty($sphinx) ? get_sql_log_html($sphinx, '$sphinx') : '';
	$log .= !empty($datastore->db) ? get_sql_log_html($datastore->db, '$datastore ['.$datastore->engine.']') : '';

	return $log;
}

function get_sql_log_html ($db_obj, $log_name)
{
	if (empty($db_obj->dbg)) return '';

	$log = '';

	foreach ($db_obj->dbg as $i => $dbg)
	{
		$id   = "sql_{$i}_". mt_rand();
		$sql  = short_query($dbg['sql'], true);
		$time = sprintf('%.4f', $dbg['time']);
		$perc = sprintf('[%2d]', $dbg['time']*100/$db_obj->sql_timetotal);
		$info = !empty($dbg['info']) ? $dbg['info'] .' ['. $dbg['src'] .']' : $dbg['src'];
		$file = addslashes($dbg['file']);
		$line = $dbg['line'];
		$edit = (DEBUG === true) ? "OpenInEditor('$file', $line);" : '';

		$log .= ''
		. '<div class="sqlLogRow" title="'. $info .'" ondblclick="'. $edit .'">'
		.  '<span style="letter-spacing: -1px;">'. $time .' </span>'
		.  '<span title="Copy to clipboard" onclick="$.copyToClipboard( $(\'#'. $id .'\').text() );" style="color: gray; letter-spacing: -1px;">'. $perc .'</span>'
		.  ' '
		.  '<span style="letter-spacing: 0px;" id="'. $id .'">'. $sql .'</span>'
		.  '<span style="color: gray"> # '. $info .' </span>'
		. '</div>'
		. "\n";
	}
	return '
		<div class="sqlLogTitle">'. $log_name .'</div>
		'. $log .'
	';
}
