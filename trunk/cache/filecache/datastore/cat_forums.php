<?php
if (!defined('BB_ROOT')) die(basename(__FILE__));
$filestore = array (
  'not_auth_forums' => 
  array (
    'guest_view' => '',
    'guest_read' => '',
    'user_view' => '',
    'user_read' => '',
  ),
  'tracker_forums' => '2',
  'cat_title_html' => 
  array (
    1 => 'Форумы',
    2 => 'Трекер',
  ),
  'forum_name_html' => 
  array (
    1 => 'Форум',
    2 => 'Раздачи',
  ),
  'c' => 
  array (
    1 => 
    array (
      'cat_id' => '1',
      'cat_title' => 'Форумы',
      'cat_order' => '10',
      'forums' => 
      array (
        0 => '1',
      ),
    ),
    2 => 
    array (
      'cat_id' => '2',
      'cat_title' => 'Трекер',
      'cat_order' => '20',
      'forums' => 
      array (
        0 => '2',
      ),
    ),
  ),
  'f' => 
  array (
    1 => 
    array (
      'forum_id' => '1',
      'cat_id' => '1',
      'forum_name' => 'Форум',
      'forum_desc' => '',
      'forum_status' => '0',
      'forum_posts' => '1',
      'forum_topics' => '1',
      'auth_view' => '0',
      'auth_read' => '0',
      'auth_post' => '0',
      'auth_reply' => '0',
      'auth_edit' => '1',
      'auth_delete' => '1',
      'auth_sticky' => '3',
      'auth_announce' => '3',
      'auth_vote' => '1',
      'auth_pollcreate' => '1',
      'auth_attachments' => '1',
      'auth_download' => '0',
      'forum_parent' => '0',
    ),
    2 => 
    array (
      'forum_id' => '2',
      'cat_id' => '2',
      'forum_name' => 'Раздачи',
      'forum_desc' => '',
      'forum_status' => '0',
      'forum_posts' => '4',
      'forum_topics' => '2',
      'auth_view' => '0',
      'auth_read' => '0',
      'auth_post' => '1',
      'auth_reply' => '1',
      'auth_edit' => '1',
      'auth_delete' => '1',
      'auth_sticky' => '3',
      'auth_announce' => '3',
      'auth_vote' => '1',
      'auth_pollcreate' => '1',
      'auth_attachments' => '1',
      'auth_download' => '1',
      'forum_parent' => '0',
    ),
  ),
);
?>