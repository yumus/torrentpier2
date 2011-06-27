<?php
if (!defined('BB_ROOT')) die(basename(__FILE__));
$filestore = array (
  'guest' => '
<select  id="jumpbox" onchange="window.location.href=\'viewforum.php?f=\'+this.value;" name="f" id="f">
	<optgroup label="&nbsp;Форумы">
		<option class="root_forum" value="1">&nbsp;Форум&nbsp;</option>
	</optgroup>
	<optgroup label="&nbsp;Трекер">
		<option class="root_forum" value="2">&nbsp;Раздачи&nbsp;</option>
	</optgroup>
</select>
',
  'user' => '
<select  id="jumpbox" onchange="window.location.href=\'viewforum.php?f=\'+this.value;" name="f" id="f">
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