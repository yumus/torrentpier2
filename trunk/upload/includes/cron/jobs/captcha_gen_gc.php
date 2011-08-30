<?php

if (!defined('BB_ROOT')) die(basename(__FILE__));

//
// �������� ����� ��������
//
$cap_img_total   = CAPTCHA()->cap_img_total;    // ������� ������ ���� ����� �������� (cap_id > 0)
$new_per_minute  = CAPTCHA()->new_per_minute;   // ������� ��������� �����
$cap_expire_time = TIMENOW + CAPTCHA()->key_ttl*2;

$gen_new_img_count = $new_per_minute;           // ������� ������� ����� ��������� �����
$expire_img_count  = $new_per_minute;           // ������� �������� ��� ��������

$row = DB('cap')->fetch_row("SELECT COUNT(*) AS cnt, MAX(cap_id) AS max_id FROM ". BB_CAPTCHA ." WHERE cap_id > 0");

$cur_total_count = (int) $row['cnt'];
$cur_max_id      = (int) $row['max_id'];

if ($cur_total_count < $cap_img_total)
{
	$gen_new_img_count += ($cap_img_total - $cur_total_count);
}

$start_id  = $cur_max_id + 1;
$cur_id    = $start_id;
$finish_id = $start_id + $gen_new_img_count - 1;

while ($cur_id <= $finish_id)
{
	$code = CAPTCHA()->gen_img($cur_id);
	DB('cap')->query("INSERT INTO ". BB_CAPTCHA ." (cap_id, cap_code) VALUES ($cur_id, '$code')");
	$cur_id++;
}

//
// ����� � ������������ � �� ��������� �����
//
DB('cap')->query("
	UPDATE ". BB_CAPTCHA ." SET
		cap_id = -cap_id,
		cap_expire = $cap_expire_time
	WHERE cap_id > 0
	ORDER BY cap_id
	LIMIT $expire_img_count
");

//
// �������� ������
//
$del_ids = DB('cap')->fetch_rowset("SELECT cap_id FROM ". BB_CAPTCHA ." WHERE cap_id < 0 AND cap_expire < ". TIMENOW, 'cap_id');

foreach ($del_ids as $del_id)
{
	$cap_img_path = CAPTCHA()->get_img_path(abs($del_id));
	if(@fopen($cap_img_path, 'r'))
	{
		unlink($cap_img_path);
    }
	DB('cap')->query("DELETE FROM ". BB_CAPTCHA ." WHERE cap_id = $del_id LIMIT 1");
}

