<?php
// Network menu page for plugin

if (!defined('ABSPATH')) {
	exit;
}
?>

<div class='wrap'>
<<<<<<< HEAD
	<h1><?php _e('Delete Expired Transients', 'delete-expired-transients'); ?></h1>

	<?php if (!empty($message)): ?>
	<div class='updated'>
=======
	<h2><?php _e('Delete Expired Transients', 'delete-expired-transients'); ?></h2>

	<?php if (!empty($message)): ?>
	<div class='updated fade'>
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
		<p><?php echo $message; ?></p>
	</div>
	<?php endif; ?>

	<p class="delxtran-site-counts"><?php
		printf(__('Site Transients: %1$s expired, %2$s total', 'delete-expired-transients'),
			number_format_i18n($site_counts->expired), number_format_i18n($site_counts->total + $site_counts->never_expire));

		$action_url = add_query_arg('site_id', $site->id, $this->pageURL);

		if ($site_counts->expired > 0) {
			$url = wp_nonce_url(add_query_arg('action', 'site-expired', $action_url), 'site-delete', 'delxtrans_nonce');
<<<<<<< HEAD
			printf(' <a href="%s">%s</a>', esc_url($url), __('Delete expired site transients', 'delete-expired-transients'));
=======
			printf(' <a href="%s">%s</a>', $url, __('Delete expired site transients', 'delete-expired-transients'));
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
		}

		if ($site_counts->total + $site_counts->never_expire > 0) {
			$url = wp_nonce_url(add_query_arg('action', 'site-deleteall', $action_url), 'site-delete', 'delxtrans_nonce');
<<<<<<< HEAD
			printf(' <a class="delete" href="%s">%s</a>', esc_url($url), __('Delete all site transients', 'delete-expired-transients'));
=======
			printf(' <a class="delete" href="%s">%s</a>', $url, __('Delete all site transients', 'delete-expired-transients'));
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
		}
	?></p>

	<form action="<?php echo esc_url($this->pageURL); ?>" method="post">
	<?php wp_nonce_field('blog-delete', 'delxtrans_nonce', false); ?>

	<?php
	$sitelistTable->prepare_items();
	$sitelistTable->display();
	?>

	</form>

</div>
