<?php

if (!defined('IN_AJAX')) die(basename(__FILE__));

global $bb_cfg, $lang, $userdata;

$mode = (string) $this->request['mode'];

$html = '<img src="./images/good.gif">';
switch($mode)
{
	case 'check_name':
		$username = clean_username($this->request['username']);

		if (empty($username))
		{
			$html = '<img src="./images/bad.gif"> <span class="leechmed bold">'.$lang['CHOOSE_A_NAME'].'</span>';
		}
		else if($err = validate_username($username))
		{
			$html = '<img src="./images/bad.gif"> <span class="leechmed bold">'. $err .'</span>';
		}
		break;
	case 'check_email':
		$email = (string) $this->request['email'];

		if (empty($email))
		{
			$html = '<img src="./images/bad.gif"> <span class="leechmed bold">'.$lang['CHOOSE_E_MAIL'].'</span>';
		}
		else if($err = validate_email($email))
		{
			$html = '<img src="./images/bad.gif"> <span class="leechmed bold">'. $err .'</span>';
		}
		break;
	case 'check_pass':
		$pass = (string) $this->request['pass'];
		$pass_confirm = (string) $this->request['pass_confirm'];
		if (empty($pass) || empty($pass_confirm))
		{
			$html = '<img src="./images/bad.gif"> <span class="leechmed bold">'.$lang['CHOOSE_PASS'].'</span>';
		}
		else
		{
			if ($pass != $pass_confirm)
			{
				$html = '<img src="./images/bad.gif"> <span class="leechmed bold">'.$lang['CHOOSE_PASS_ERR'].'</span>';
			}
			else
			{
				$text = (IS_GUEST) ? $lang['CHOOSE_PASS_REG_OK'] : $lang['CHOOSE_PASS_OK'];
				$html = '<img src="./images/good.gif"> <span class="seedmed bold">'.$text.'</span>';
			}
		}
	break;
	case 'refresh_captcha';
	    $html = CAPTCHA()->get_html();
	break;
}

$this->response['html'] = $html;
$this->response['mode'] = $mode;