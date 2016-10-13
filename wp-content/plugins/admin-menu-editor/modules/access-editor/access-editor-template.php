<<<<<<< HEAD
<div id="ws_menu_access_editor" title="Permissions">

	<div class="ws_dialog_panel">
		<div class="error inline" id="ws_hardcoded_role_error">
			<p>
				<strong>Note:</strong>
				Only users with the "<span id="ws_hardcoded_role_name">[role]</span>" role
				can access this menu. This restriction is hard&shy;coded in the plugin that
				created	the menu.
			</p>
		</div>

		<div id="ws_role_access_container" class="ws_dialog_subpanel ws_has_extended_permissions">
			<div style="float: left; min-width: 352px;">
			<strong>Grant access</strong>
			<a class="ws_tooltip_trigger" title="
				&#x2611; = give access and show the menu.
				&lt;br&gt;
				&#x2610; = prevent access and hide the menu.

				&lt;br&gt;&lt;br&gt;
				Checking a box will also give that role the required capability (see below).
			">[?]</a>
			<br>

			<div id="ws_role_table_body_container">
				<div id="ws_role_access_overlay" class="ws_hide_if_pro"></div>
				<div id="ws_role_access_overlay_content" class="ws_hide_if_pro">
					Pro only feature.
					Use capabilities (below) instead.
				</div>

				<table class="widefat ws_role_table_body">
					<tbody>
					<!-- Table contents will be generated by JavaScript. -->
					</tbody>
				</table>
			</div>
			</div>

			<div id="ws_ext_permissions_container" class="ws_ext_readable_names_enabled">
				<div id="ws_ext_permissions_container_caption">
					<strong>
						<span class="ws_aed_selected_actor_name">Role name</span>
						<span class="ws_ame_breadcrumb_separator">&#187;</span>
						<span id="ws_ext_selected_object_type_name">Post type or taxonomy</span>
					</strong>
					<span id="ws_ext_toggle_capability_names" class="dashicons dashicons-editor-code"
					      title="Toggle capability names"></span>
					<br>
				</div>

				<?php
				$cpt_actions = array(
					'General' => array(
						'edit_posts' => 'Edit',
						'publish_posts' => 'Publish',
						'delete_posts' => 'Delete',
						'create_posts' => 'Create',
					),

					'Published' => array(
						'edit_published_posts' => 'Edit published',
						'delete_published_posts' => 'Delete published',
					),

					'Others' => array(
						'edit_others_posts' => 'Edit others',
						'delete_others_posts' => 'Delete others',
					),

					'Private' => array(
						'edit_private_posts' => 'Edit private',
						'delete_private_posts' => 'Delete private',
						'read_private_posts' => 'Read private',
					),
				);
				?>

				<table class="widefat ws_ext_permissions_table" id="ws_post_type_permissions_table">
					<?php foreach($cpt_actions as $group => $actions): ?>
						<tr>
							<td class="ws_ext_group_title" colspan="2"><?php echo $group; ?></td>
						</tr>
						<?php foreach($actions as $action => $readable_name): ?>
							<?php $checkbox_id = 'ws_cpt_action-' . $action; ?>
							<tr class="ws_ext_action-<?php echo esc_attr($action); ?>">
								<td class="ws_ext_action_check_column">
									<input
										type="checkbox"
										id="<?php echo esc_attr($checkbox_id); ?>"
										class="ws_ext_action_allowed"
										data-ext_action="<?php echo esc_attr($action); ?>">
								</td>
								<td class="ws_ext_action_name_column">
									<label for="<?php echo esc_attr($checkbox_id); ?>" class="ws_ext_action_name">
										<?php echo $readable_name; ?>
									</label>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endforeach; ?>

					<tr class="ws_ext_padding_row"><td colspan="2"></td></tr>
				</table>

				<?php
				$taxonomy_actions = array(
					'manage_terms'  => 'Manage',
					'edit_terms'    => 'Edit',
					'delete_terms'  => 'Delete',
					'assign_terms'  => 'Assign',
				);
				?>

				<table class="widefat ws_ext_permissions_table" id="ws_taxonomy_permissions_table">
					<?php foreach($taxonomy_actions as $action => $readable_name): ?>
						<?php $checkbox_id = 'ws_taxonomy_action-' . $action; ?>
						<tr class="ws_ext_action-<?php echo esc_attr($action); ?>">
							<td class="ws_ext_action_check_column">
								<input
									type="checkbox"
									id="<?php echo esc_attr($checkbox_id); ?>"
									class="ws_ext_action_allowed"
									data-ext_action="<?php echo esc_attr($action); ?>">
							</td>
							<td class="ws_ext_action_name_column">
								<label for="<?php echo esc_attr($checkbox_id); ?>" class="ws_ext_action_name">
									<?php echo $readable_name; ?>
								</label>
							</td>
						</tr>
					<?php endforeach; ?>

					<tr class="ws_ext_padding_row"><td colspan="2"></td></tr>
				</table>
			</div>
		</div>
		<div class="clear"></div>


		<div id="ws_required_cap_container" class="ws_dialog_subpanel">
			<strong>Required capability</strong>
			<a class="ws_tooltip_trigger" title="
				This capability check is hard-coded in WordPress or the plugin that created the menu.

				&lt;ul class=&quot;ws_tooltip_content_list&quot;&gt;
					&lt;li&gt;
						Only roles with this capability will be able to access this menu.
					&lt;li&gt;
						Admin Menu Editor will automatically grant the required capability to
						all roles you check in the &quot;Roles&quot; list.
					&lt;li&gt;
						Custom menus have no hard-coded capability requirements.
				&lt;/ul&gt;
			">[?]</a>
			<br>
			<span id="ws_required_capability">capability_here</span>
		</div>

		<div id="ws_extra_cap_container" class="ws_dialog_subpanel">
			<label for="ws_extra_capability">
				<strong>Extra capability</strong>
			</label>
			<a class="ws_tooltip_trigger" title="
				Optional. An additional capability check that will be applied on top of
				the &quot;Roles&quot; and &quot;Required capability&quot; settings.
				Leave empty to disable.
			">[?]</a>
			<br>
			<input type="text" id="ws_extra_capability" class="ws_has_dropdown" value=""><input type="button" id="ws_trigger_capability_dropdown" value="&#9660;"
			       class="button ws_dropdown_button" tabindex="-1">
		</div>

		<div id="ws_item_restriction_container" class="ws_dialog_subpanel">
			<strong>Override submenus</strong>
			<a class="ws_tooltip_trigger" title="
				&#x2611; = when this menu is hidden from a role or user, all of its submenu items will also be hidden
					from that role or user.
				&lt;br&gt;&lt;br&gt;
				&#x2610; = this menu will stay visible as long as it has at least one visible submenu item.

				&lt;br&gt;&lt;br&gt;

				In WordPress, submenu item permissions usually have precedence. Check the box to give this menu
				precedence over its submenus (but only when it is hidden).
			">[?]</a>
			<br>
			<label>
				<input type="checkbox" id="ws_restrict_access_to_items">
				Hide all submenu items when this item is hidden
			</label>
		</div>
	</div>

	<div class="ws_dialog_buttons">
		<input type="button" class="button-primary" value="Save Changes" id="ws_save_access_settings">
		<input type="button" class="button ws_close_dialog" value="Cancel">
	</div>

=======
<div id="ws_menu_access_editor" title="Permissions">

	<div class="ws_dialog_panel">
		<div class="error inline" id="ws_hardcoded_role_error">
			<p>
				<strong>Note:</strong>
				Only users with the "<span id="ws_hardcoded_role_name">[role]</span>" role
				can access this menu. This restriction is hard&shy;coded in the plugin that
				created	the menu.
			</p>
		</div>

		<div id="ws_role_access_container" class="ws_dialog_subpanel ws_has_extended_permissions">
			<div style="float: left; min-width: 352px;">
			<strong>Grant access</strong>
			<a class="ws_tooltip_trigger" title="
				&#x2611; = give access and show the menu.
				&lt;br&gt;
				&#x2610; = prevent access and hide the menu.

				&lt;br&gt;&lt;br&gt;
				Checking a box will also give that role the required capability (see below).
			">[?]</a>
			<br>

			<div id="ws_role_table_body_container">
				<div id="ws_role_access_overlay" class="ws_hide_if_pro"></div>
				<div id="ws_role_access_overlay_content" class="ws_hide_if_pro">
					Pro only feature.
					Use capabilities (below) instead.
				</div>

				<table class="widefat ws_role_table_body">
					<tbody>
					<!-- Table contents will be generated by JavaScript. -->
					</tbody>
				</table>
			</div>
			</div>

			<div id="ws_ext_permissions_container" class="ws_ext_readable_names_enabled">
				<div id="ws_ext_permissions_container_caption">
					<strong>
						<span class="ws_aed_selected_actor_name">Role name</span>
						<span class="ws_ame_breadcrumb_separator">&#187;</span>
						<span id="ws_ext_selected_object_type_name">Post type or taxonomy</span>
					</strong>
					<span id="ws_ext_toggle_capability_names" class="dashicons dashicons-editor-code"
					      title="Toggle capability names"></span>
					<br>
				</div>

				<?php
				$cpt_actions = array(
					'General' => array(
						'edit_posts' => 'Edit',
						'publish_posts' => 'Publish',
						'delete_posts' => 'Delete',
						'create_posts' => 'Create',
					),

					'Published' => array(
						'edit_published_posts' => 'Edit published',
						'delete_published_posts' => 'Delete published',
					),

					'Others' => array(
						'edit_others_posts' => 'Edit others',
						'delete_others_posts' => 'Delete others',
					),

					'Private' => array(
						'edit_private_posts' => 'Edit private',
						'delete_private_posts' => 'Delete private',
						'read_private_posts' => 'Read private',
					),
				);
				?>

				<table class="widefat ws_ext_permissions_table" id="ws_post_type_permissions_table">
					<?php foreach($cpt_actions as $group => $actions): ?>
						<tr>
							<td class="ws_ext_group_title" colspan="2"><?php echo $group; ?></td>
						</tr>
						<?php foreach($actions as $action => $readable_name): ?>
							<?php $checkbox_id = 'ws_cpt_action-' . $action; ?>
							<tr class="ws_ext_action-<?php echo esc_attr($action); ?>">
								<td class="ws_ext_action_check_column">
									<input
										type="checkbox"
										id="<?php echo esc_attr($checkbox_id); ?>"
										class="ws_ext_action_allowed"
										data-ext_action="<?php echo esc_attr($action); ?>">
								</td>
								<td class="ws_ext_action_name_column">
									<label for="<?php echo esc_attr($checkbox_id); ?>" class="ws_ext_action_name">
										<?php echo $readable_name; ?>
									</label>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endforeach; ?>

					<tr class="ws_ext_padding_row"><td colspan="2"></td></tr>
				</table>

				<?php
				$taxonomy_actions = array(
					'manage_terms'  => 'Manage',
					'edit_terms'    => 'Edit',
					'delete_terms'  => 'Delete',
					'assign_terms'  => 'Assign',
				);
				?>

				<table class="widefat ws_ext_permissions_table" id="ws_taxonomy_permissions_table">
					<?php foreach($taxonomy_actions as $action => $readable_name): ?>
						<?php $checkbox_id = 'ws_taxonomy_action-' . $action; ?>
						<tr class="ws_ext_action-<?php echo esc_attr($action); ?>">
							<td class="ws_ext_action_check_column">
								<input
									type="checkbox"
									id="<?php echo esc_attr($checkbox_id); ?>"
									class="ws_ext_action_allowed"
									data-ext_action="<?php echo esc_attr($action); ?>">
							</td>
							<td class="ws_ext_action_name_column">
								<label for="<?php echo esc_attr($checkbox_id); ?>" class="ws_ext_action_name">
									<?php echo $readable_name; ?>
								</label>
							</td>
						</tr>
					<?php endforeach; ?>

					<tr class="ws_ext_padding_row"><td colspan="2"></td></tr>
				</table>
			</div>
		</div>
		<div class="clear"></div>


		<div id="ws_required_cap_container" class="ws_dialog_subpanel">
			<strong>Required capability</strong>
			<a class="ws_tooltip_trigger" title="
				This capability check is hard-coded in WordPress or the plugin that created the menu.

				&lt;ul class=&quot;ws_tooltip_content_list&quot;&gt;
					&lt;li&gt;
						Only roles with this capability will be able to access this menu.
					&lt;li&gt;
						Admin Menu Editor will automatically grant the required capability to
						all roles you check in the &quot;Roles&quot; list.
					&lt;li&gt;
						Custom menus have no hard-coded capability requirements.
				&lt;/ul&gt;
			">[?]</a>
			<br>
			<span id="ws_required_capability">capability_here</span>
		</div>

		<div id="ws_extra_cap_container" class="ws_dialog_subpanel">
			<label for="ws_extra_capability">
				<strong>Extra capability</strong>
			</label>
			<a class="ws_tooltip_trigger" title="
				Optional. An additional capability check that will be applied on top of
				the &quot;Roles&quot; and &quot;Required capability&quot; settings.
				Leave empty to disable.
			">[?]</a>
			<br>
			<input type="text" id="ws_extra_capability" class="ws_has_dropdown" value=""><input type="button" id="ws_trigger_capability_dropdown" value="&#9660;"
			       class="button ws_dropdown_button" tabindex="-1">
		</div>

		<div id="ws_item_restriction_container" class="ws_dialog_subpanel">
			<strong>Override submenus</strong>
			<a class="ws_tooltip_trigger" title="
				&#x2611; = when this menu is hidden from a role or user, all of its submenu items will also be hidden
					from that role or user.
				&lt;br&gt;&lt;br&gt;
				&#x2610; = this menu will stay visible as long as it has at least one visible submenu item.

				&lt;br&gt;&lt;br&gt;

				In WordPress, submenu item permissions usually have precedence. Check the box to give this menu
				precedence over its submenus (but only when it is hidden).
			">[?]</a>
			<br>
			<label>
				<input type="checkbox" id="ws_restrict_access_to_items">
				Hide all submenu items when this item is hidden
			</label>
		</div>
	</div>

	<div class="ws_dialog_buttons">
		<input type="button" class="button-primary" value="Save Changes" id="ws_save_access_settings">
		<input type="button" class="button ws_close_dialog" value="Cancel">
	</div>

>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
</div>