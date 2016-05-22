<script type="application/javascript">
	var ddl_create_layout_error = '<?php echo esc_js( __('Failed to create the layout.', 'ddl-layouts') ); ?>';
</script>
<?php wp_nonce_field('wp_nonce_create_layout', 'wp_nonce_create_layout'); ?>
<input class="js-layout-new-redirect" name="layout_creation_redirect" type="hidden" value="<?php echo admin_url( 'admin.php?page=dd_layouts_edit&amp;layout_id='); ?>" />


<?php if ( isset( $_GET['new_layout'] ) && $_GET['new_layout'] == 'true'): ?>

	<script type="application/javascript">
		var ddl_layouts_create_new_layout_trigger = true;
	</script>

<?php endif; ?>

<script type="text/html" id="js-ddl-create-layout-for-post-types-selection">
    <div class="ddl-dialog-header">
        <h2><?php _e('New layout for:', 'ddl-layouts');?></h2>
        <i class="fa fa-remove icon-remove js-edit-dialog-close"></i>
    </div>
    <div class="ddl-dialog-content">
		<p><input type="radio" name="create_layout_for_post_type" id="create_layout_for_post_type_one" value="one" checked /><label for="create_layout_for_post_type_one"><?php printf(__('Just for %s', 'ddl-layouts'), '{{{ post_title }}}'); ?></label></p>
        <p><input type="radio" name="create_layout_for_post_type" id="create_layout_for_post_type_all" value="all" /><label for="create_layout_for_post_type_all"><?php printf(__('Template for all %s', 'ddl-layouts'), '{{{ post_type_label }}}'); ?></label></p>
    </div>
    <div class="ddl-dialog-footer">
        <button class="button button-primary js-ddl-continue-to-layout-creation ddl-continue-to-layout-creation">
				<?php _e('Continue', 'ddl-layouts'); ?></button>
        <button class="button js-edit-dialog-close close-change-use"><?php _e('Cancel', 'ddl-layouts'); ?></button>

    </div>

</script>

<div class="ddl-dialogs-container">
    <div class="ddl-dialog auto-width" id="js-ddl-create-layout-for-post-types-selection-wrap"></div>
</div>