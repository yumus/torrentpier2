<?php
if (!defined('BB_ROOT')) die(basename(__FILE__));
$filestore = array (
  'viewtopic_forum_select' => '
<select  name="new_forum_id" id="new_forum_id">
	<optgroup label="&nbsp;Форумы">
		<option class="root_forum" value="1">&nbsp;Форум&nbsp;</option>
	</optgroup>
	<optgroup label="&nbsp;Трекер">
		<option class="root_forum" value="2">&nbsp;Раздачи&nbsp;</option>
	</optgroup>
</select>
',
);
?>