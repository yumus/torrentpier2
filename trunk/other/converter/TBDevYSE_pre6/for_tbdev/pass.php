<?php
	
require_once("include/bittorrent.php");

dbconn();

loggedinorreturn();

$new_tr_url = "http://pushchino.tv/forum/"; // with ending slash
$subject = "������� �� ����� ������";
$msg = '[b]��������![/b] ��� ������ �������� �� ����� ������! ����� ������� - [url='.$new_tr_url.']'.$new_tr_url.'[/url] 
	��� ���� ���������� �� ����� ������, ���������������� ������ �� ����. 
	����� �� ������ ����� [url='.$new_tr_url.'login.php]�����[/url]. ���� ������ �� ����� �������: 
	[b]�����:[/b] %s 
	[b]������:[/b] %s 
	������� ������ ����� ����� ����� �� ������ � [url='.$new_tr_url.'profile.php?mode=editprofile]����������[/url].';
	


if (empty($_POST['confirm']))
{
	stdhead();
	echo '
		<br />
		<center>
		<form action="'. $_SERVER['PHP_SELF'] .'" method="post">
		<input type="submit" name="confirm" value="Start mass PM" />
		</form>
		</center>
	';
}
else
{
	if(!file_exists('passwords.php')) stderr($tracker_lang['error'], 'passwords.php not exists');
	
	include('passwords.php');
	stdhead();
	foreach ($passwords as $user)
	{
		$msg_sql = sprintf($msg, $user['username'], $user['new_passwd']);
		sql_query("INSERT INTO messages (receiver, added, subject, msg)	VALUES({$user['tb_user_id']}, NOW(), ".sqlesc($subject).", ".sqlesc($msg_sql).")");
	}	
	stdmsg('OK', 'Mass PM succesful');
}

stdfoot();