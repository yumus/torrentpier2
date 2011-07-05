<?php

define('BB_ROOT', './');
require(BB_ROOT .'common.php');

$user->session_start();
$url  = (string) request_var('url', '');
$time = 15;

$url = urldecode($url);

if(!$url)
{
	meta_refresh(BB_ROOT, 0);
	bb_die ('Неверная ссылка');
}

meta_refresh($url, $time);

$template->assign_vars(array(
	'URL'              => $url,
	'URL_TITLE'        => str_short($url, 70),
	'PAGE_TITLE'       => 'Переадресация...',
	'TIME'             => $time,
));

print_page('redirect.tpl');
