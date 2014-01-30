<?php

define('BB_SCRIPT', 'vote');
require('./common.php');

$user->session_start(array('req_login' => true));

$mode     = (string) @$_POST['mode'];
$topic_id = (int)    @$_POST['topic_id'];
$forum_id = (int)    @$_POST['forum_id'];
$vote_id  = (int)    @$_POST['vote_id'];

$return_topic_url = TOPIC_URL . $topic_id;
$return_topic_url .= !empty($_POST['start']) ? "&amp;start=". intval($_POST['start']) : '';

$template->assign_var('BB_DIE_APPEND_MSG', '
	<a href="'. $return_topic_url .'">Вернуться в тему</a>
	<br /><br />
	<a href="viewforum.php?f='. $forum_id .'">Вернуться в раздел</a>
	<br /><br />
	<a href="index.php">Вернуться на главную страницу</a>
');

$poll = new bb_poll();

// проверка валидности $topic_id
if (!$topic_id)
{
	bb_die('Invalid topic_id');
}
if (!$t_data = DB()->fetch_row("SELECT * FROM ". BB_TOPICS ." WHERE topic_id = $topic_id LIMIT 1"))
{
	bb_die('Тема не найдена');
}

// проверка прав
if ($mode != 'poll_vote')
{
	if ($t_data['topic_poster'] != $userdata['user_id'])
	{
		if (!IS_AM) bb_die('Нет прав');
	}
}

// проверка на возможность вносить изменения
if ($mode == 'poll_delete')
{
	if ($t_data['topic_time'] < TIMENOW - $bb_cfg['poll_max_days']*86400)
	{
		bb_die("Время для этого опроса ({$bb_cfg['poll_max_days']} дней с момента создания темы) уже закончилось");
	}
	if (!IS_ADMIN && ($t_data['topic_vote'] != POLL_FINISHED))
	{
		bb_die($lang['CANNOT_DELETE_POLL']);
	}
}

switch ($mode)
{
	// голосование
	case 'poll_vote':
		if (!$t_data['topic_vote'])
		{
			bb_die('Опрос не найден');
		}
		if ($t_data['topic_status'] == TOPIC_LOCKED)
		{
			bb_die($lang['TOPIC_LOCKED_SHORT']);
		}
		if (!poll_is_active($t_data))
		{
			bb_die('Этот опрос уже завершён');
		}
		if (!$vote_id)
		{
			bb_die('Вы не выбрали, за что голосуете');
		}
		if (DB()->fetch_row("SELECT 1 FROM ". BB_POLL_USERS ." WHERE topic_id = $topic_id AND user_id = {$userdata['user_id']} LIMIT 1"))
		{
			bb_die('Вы уже голосовали');
		}

		DB()->query("
			UPDATE ". BB_POLL_VOTES ." SET
				vote_result = vote_result + 1
			WHERE topic_id = $topic_id
				AND vote_id = $vote_id
			LIMIT 1
		");
		if (DB()->affected_rows() != 1)
		{
			bb_die('Вы не выбрали, за что голосуете');
		}

		DB()->query("INSERT IGNORE INTO ". BB_POLL_USERS ." (topic_id, user_id, vote_dt) VALUES ($topic_id, {$userdata['user_id']}, ". TIMENOW .")");

		CACHE('bb_poll_data')->rm("poll_$topic_id");

		bb_die('Спасибо! Ваш голос учтён');
		break;

	// возобновить возможность голосовать
	case 'poll_start':
		if (!$t_data['topic_vote'])
		{
			bb_die('Опрос не найден');
		}
		DB()->query("UPDATE ". BB_TOPICS ." SET topic_vote = 1 WHERE topic_id = $topic_id LIMIT 1");
		bb_die('Опрос включен');
		break;

	// завершить опрос
	case 'poll_finish':
		if (!$t_data['topic_vote'])
		{
			bb_die('Опрос не найден');
		}
		DB()->query("UPDATE ". BB_TOPICS ." SET topic_vote = ". POLL_FINISHED ." WHERE topic_id = $topic_id LIMIT 1");
		bb_die('Опрос завершён');
		break;

	// удаление
	case 'poll_delete':
		if (!$t_data['topic_vote'])
		{
			bb_die('Опрос не найден');
		}
		$poll->delete_poll($topic_id);
		bb_die('Опрос удалён');
		break;

	// добавление
	case 'poll_add':
		if ($t_data['topic_vote'])
		{
			bb_die('Тема уже имеет опрос');
		}
		$poll->build_poll_data($_POST);
		if ($poll->err_msg)
		{
			bb_die($poll->err_msg);
		}
		$poll->insert_votes_into_db($topic_id);
		bb_die('Опрос добавлен');
		break;

	// редакторование
	case 'poll_edit':
		if (!$t_data['topic_vote'])
		{
			bb_die('Опрос не найден');
		}
		$poll->build_poll_data($_POST);
		if ($poll->err_msg)
		{
			bb_die($poll->err_msg);
		}
		$poll->insert_votes_into_db($topic_id);
		CACHE('bb_poll_data')->rm("poll_$topic_id");
		bb_die('Опрос изменён и старые результаты удалены');
		break;

	default:
		bb_die("Invalid mode: ". htmlCHR($mode));
}

// ----------------------------------------------------------- //
// Functions
//


class bb_poll
{
	var $err_msg    = '';
	var $poll_votes = array();  // array(vote_id => vote_text)
	var $max_votes  = 0;

	function bb_poll ()
	{
		global $bb_cfg;
		$this->max_votes = $bb_cfg['max_poll_options'];
	}

	function build_poll_data ($posted_data)
	{
		$poll_caption = (string) @$posted_data['poll_caption'];
		$poll_votes   = (string) @$posted_data['poll_votes'];
		$this->poll_votes = array();

		if (!$poll_caption = str_compact($poll_caption))
		{
			return $this->err_msg = 'Вы должны указать заголовок';
		}
		$this->poll_votes[] = $poll_caption;  // заголовок имеет vote_id = 0

		foreach (explode("\n", $poll_votes) as $vote)
		{
			if (!$vote = str_compact($vote))
			{
				continue;
			}
			$this->poll_votes[] = $vote;
		}

		// проверять на "< 3" -- 2 варианта ответа + заголовок
		if (count($this->poll_votes) < 3 || count($this->poll_votes) > $this->max_votes + 1)
		{
			return $this->err_msg = "Вы должны правильно указать варианты ответа (минимум 2, максимум {$this->max_votes})";
		}
	}

	function insert_votes_into_db ($topic_id)
	{
		$this->delete_votes_data($topic_id);

		$sql_ary = array();
		foreach ($this->poll_votes as $vote_id => $vote_text)
		{
			$sql_ary[] = array(
				'topic_id'    => (int) $topic_id,
				'vote_id'     => (int) $vote_id,
				'vote_text'   => (string) $vote_text,
				'vote_result' => (int) 0,
			);
		}
		$sql_args = DB()->build_array('MULTI_INSERT', $sql_ary);

		DB()->query("REPLACE INTO ". BB_POLL_VOTES . $sql_args);

		DB()->query("UPDATE ". BB_TOPICS ." SET topic_vote = 1 WHERE topic_id = $topic_id LIMIT 1");
	}

	function delete_poll ($topic_id)
	{
		DB()->query("UPDATE ". BB_TOPICS ." SET topic_vote = 0 WHERE topic_id = $topic_id LIMIT 1");
		$this->delete_votes_data($topic_id);
	}

	function delete_votes_data ($topic_id)
	{
		DB()->query("DELETE FROM ". BB_POLL_VOTES ." WHERE topic_id = $topic_id");
		DB()->query("DELETE FROM ". BB_POLL_USERS ." WHERE topic_id = $topic_id");
		CACHE('bb_poll_data')->rm("poll_$topic_id");
	}
}