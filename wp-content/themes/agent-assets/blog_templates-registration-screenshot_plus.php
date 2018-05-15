<?php
/**
 * Theme screenshot selection with titles and description template.
 *
 * Copy this file into your theme directory and edit away!
 * You can also use $templates array to iterate through your templates.
 */

if (defined('BP_VERSION') && 'bp-default' == get_blog_option(bp_get_root_blog_id(), 'stylesheet')) echo '<br style="clear:both" />'; ?>
<h2>Step: 2</h2>
<div class="step">
	<div id="blog_template-selection">
		<!-- <h3><?php _e('Select a template', 'blog_templates') ?></h3> -->

		<?php
		echo '<div style="padding-bottom:20px;color:#559987;" class="av-special-heading av-special-heading-h3 custom-color-heading avia-builder-el-1 el_after_av_button avia-builder-el-last myclass"><h3 class="av-special-heading-tag" itemprop="headline">Select a Template</h3><div class="special-heading-border"><div class="special-heading-inner-border" style="border-color:#559987"></div></div></div>';

			if ( $settings['show-categories-selection'] )
				$templates = nbt_theme_selection_toolbar( $templates );
  		?>

		<div class="blog_template-option">

			<?php
			global $wpdb;
			$user_id = get_current_user_id();
			
			// 1.) Look in our NEW relationship table aa_aag_group_templates_relationships_table for the same group_id's
			$query  = 'SELECT '.$wpdb->base_prefix.'aag_group_templates_relationships_table.template_cat_id '; 
			$query .= 'FROM '.$wpdb->base_prefix.'aag_group_templates_relationships_table ';
			$query .= 'JOIN '.$wpdb->base_prefix.'bp_groups_members ';
			$query .= 'ON '.$wpdb->base_prefix.'aag_group_templates_relationships_table.bp_group_id = '.$wpdb->base_prefix.'bp_groups_members.group_id ';
			$query .= 'WHERE '.$wpdb->base_prefix.'bp_groups_members.user_id = '.$user_id;

			$template_cats = $wpdb->get_results($query, ARRAY_A);
			
			// Add category for "Public" templates for everyone to see.
			array_push( $template_cats , array('template_cat_id'=>1) );
			
			foreach ($template_cats as $key => $value) {
				$template_cats[$value] = $value['template_cat_id'];
			}
			
			$model = nbt_get_model();
			$templates = $model->get_templates_by_category_ids( $template_cats );
			foreach ($templates as $tkey => $template) {
				nbt_render_theme_selection_item( 'screenshot_plus', $tkey, $template, $settings );
			}
			?>
		<div style="clear:both;"></div>
	</div>
</div>
</div>
