<?php
// Tools menu page for plugin

if (!defined('ABSPATH')) {
	exit;
}
?>

<div class='wrap'>
<<<<<<< HEAD
<h1><?php _e('Delete Expired Transients', 'delete-expired-transients'); ?></h1>

<?php if ($msg): ?>
<div class='updated'>
	<p><?php echo esc_html($msg); ?></p>
=======
<h2><?php _e('Delete Expired Transients', 'delete-expired-transients'); ?></h2>

<?php if ($action == 'delete-expired'): ?>
<div class='updated fade'>
	<p><?php _e('Expired transients deleted.', 'delete-expired-transients'); ?></p>
</div>
<?php endif; ?>

<?php if ($action == 'delete-all'): ?>
<div class='updated fade'>
	<p><?php _e('All transients deleted.', 'delete-expired-transients'); ?></p>
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
</div>
<?php endif; ?>

<p><?php printf(__('Expired transients: %s', 'delete-expired-transients'), number_format_i18n($counts->expired)); ?></p>
<p><?php printf(__('Total transients: %s', 'delete-expired-transients'), number_format_i18n($counts->total + $counts->never_expire)); ?></p>
<<<<<<< HEAD
<?php if ($counts->woocommerce_sessions): ?>
<p><?php printf(__('Obsolete WooCommerce sessions: %s', 'delete-expired-transients'), number_format_i18n($counts->woocommerce_sessions)); ?></p>
<?php endif; ?>

<form action="<?php echo admin_url('tools.php'); ?>?page=delxtrans" method="post" id="delxtrans-tools">
	<?php wp_nonce_field('delete', 'delxtrans_wpnonce', false); ?>

	<fieldset>

		<legend><?php esc_html_e('Delete the selected items immediately', 'delete-expired-transients'); ?></legend>

		<ul>
			<li>
				<input type="radio" name="delxtrans-action" id="delxtrans-delete-expired" value="delete-expired" checked="checked" />
				<label for="delxtrans-delete-expired"><?php _e('expired transients', 'delete-expired-transients'); ?></label>
			</li>
			<li>
				<input type="radio" name="delxtrans-action" id="delxtrans-delete-all" value="delete-all" />
				<label for="delxtrans-delete-all"><?php _e('all transients -- use with caution!', 'delete-expired-transients'); ?></label>
			</li>
			<?php if ($counts->woocommerce_sessions): ?>
			<li>
				<input type="radio" name="delxtrans-action" id="delxtrans-woo-sessions" value="delete-woo-sessions" />
				<label for="delxtrans-woo-sessions"><?php _e('obsolete sessions from WooCommerce version 2.4 and earlier', 'delete-expired-transients'); ?></label>
			</li>
			<?php endif; ?>
		</ul>

	</fieldset>

	<p>
		<input type="submit" name="Submit" class="button-primary" value="<?php echo esc_html_x('Delete', 'tools page submit button', 'delete-expired-transients'); ?>" />
	</p>
=======

<form action="<?php echo admin_url('tools.php'); ?>?page=delxtrans" method="post">

	<table class="form-table">

	<tr valign='top'>
		<th><strong><?php _e('Delete transients', 'delete-expired-transients'); ?></strong></th>
		<td>
			<label><input type="radio" name="delxtrans-action" value="delete-expired" checked="checked" />
				<?php _e('expired transients', 'delete-expired-transients'); ?></label><br />
			<label><input type="radio" name="delxtrans-action" value="delete-all" />
				<?php _e('all transients -- use with caution!', 'delete-expired-transients'); ?></label>
		</td>
	</tr>

	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Delete', 'delete-expired-transients'); ?>" />
			<?php wp_nonce_field('delete', 'delxtrans_wpnonce', false); ?>
		</td>
	</tr>

	</table>
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6

</form>
