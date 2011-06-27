<?php if (!empty($V['SIMPLE_FOOTER'])) { ?><?php } elseif (!empty($V['IN_ADMIN'])) { ?><?php } else { ?>

	</div><!--/main_content_wrap-->
	</td><!--/main_content-->

	<?php if (!empty($V['SHOW_SIDEBAR2'])) { ?>
		<!--sidebar2-->
		<td id="sidebar2">
		<div id="sidebar2_wrap">
			<?php if (!empty($bb_cfg['sidebar2_static_content_path'])) include($bb_cfg['sidebar2_static_content_path']); ?>
			<img width="210" class="spacer" src="<?php echo isset($V['SPACER']) ? $V['SPACER'] : ''; ?>" alt="" />
		</div><!--/sidebar2_wrap-->
		</td><!--/sidebar2-->
	<?php } ?>

	</tr></table>
	</div>
	<!--/page_content-->

	<!--page_footer-->
	<div id="page_footer">

		<div class="clear"></div>

		<br /><br />

		<?php if (!empty($bb_cfg['user_agreement_html_path'])) { ?>
		<div class="med bold tCenter">
			<a href="<?php echo isset($bb_cfg['user_agreement_url']) ? $bb_cfg['user_agreement_url'] : ''; ?>" onclick="window.open(this.href, '', InfoWinParams); return false;"><?php echo isset($L['USER_AGREEMENT']) ? $L['USER_AGREEMENT'] : $V['L_USER_AGREEMENT']; ?></a>
			<?php if (!empty($bb_cfg['copyright_holders_html_path'])) { ?>
			<span class="normal">&nbsp;|&nbsp;</span>
			<a href="<?php echo isset($bb_cfg['copyright_holders_url']) ? $bb_cfg['copyright_holders_url'] : ''; ?>" onclick="window.open(this.href, '', InfoWinParams); return false;"><?php echo isset($L['COPYRIGHT_HOLDERS']) ? $L['COPYRIGHT_HOLDERS'] : $V['L_COPYRIGHT_HOLDERS']; ?></a>
			<?php } ?>
			<?php if (!empty($bb_cfg['advert_html_path'])) { ?>
			<span class="normal">&nbsp;|&nbsp;</span>
			<a href="<?php echo isset($bb_cfg['advert_url']) ? $bb_cfg['advert_url'] : ''; ?>" onclick="window.open(this.href, '', InfoWinParams); return false;"><?php echo isset($L['ADVERT']) ? $L['ADVERT'] : $V['L_ADVERT']; ?></a>
			<?php } ?>
		</div>
		<br />
		<?php } ?>

		<?php if (!empty($V['SHOW_ADMIN_LINK'])) { ?>
		<div class="tiny tCenter"><a href="<?php echo isset($V['ADMIN_LINK_HREF']) ? $V['ADMIN_LINK_HREF'] : ''; ?>"><?php echo isset($L['GOTO_ADMINCP']) ? $L['GOTO_ADMINCP'] : $V['L_GOTO_ADMINCP']; ?></a></div>
		<br />
		<?php } ?>

		<?php echo isset($V['SAPE']) ? $V['SAPE'] : ''; ?>
		<?php echo isset($V['MAINLINK']) ? $V['MAINLINK'] : ''; ?>
		<div class="copyright tleft" align="center">
			<?php echo isset($L['POWERED']) ? $L['POWERED'] : $V['L_POWERED']; ?> <br />
			<?php echo isset($L['DIVE']) ? $L['DIVE'] : $V['L_DIVE']; ?> <br />
		</div>

	</div>

	<div class="copyright" align="center">
		<b style="color:rgb(204,0,0);"><?php echo isset($L['NOTICE']) ? $L['NOTICE'] : $V['L_NOTICE']; ?></b><br />
		<?php echo isset($L['COPY']) ? $L['COPY'] : $V['L_COPY']; ?>
	</div>

	<!--/page_footer -->

	</div>
	<!--/page_container -->

<?php } ?>

<?php if (!empty($V['ONLOAD_FOCUS_ID'])) { ?>

<script type="text/javascript">
$p('<?php echo isset($V['ONLOAD_FOCUS_ID']) ? $V['ONLOAD_FOCUS_ID'] : ''; ?>').focus();
</script>

<?php } ?>