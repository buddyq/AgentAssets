<?php
/**
 * BuddyPress - Users Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

wp_enqueue_style( 'groups_style', get_stylesheet_directory_uri() . '/inc/css/groups.css' );

/* TABLE                  |      meta_key       |      meta_value     |
=======================================================================
/* aa_bp_groups_groupmeta |     group_code      |   ####-####-######  |
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if ( isset( $_POST['join-group'] ) ) {
		$result = AgentAssets::join_group($_POST['group-code']);
		$status = $result['status'];
	}
	
	if ($status) {
		write_log("Status was successful");
		$message = "Awesome! You've been added to the group!";
        // bp_core_add_message($message, 'success'); // Sends error message to the page.
		$status = "Success";
		$color = "green";
	} else{
		write_log("Status was false!");
		$message = "Error: " . $result['reason'];
		$status = "Error";
		$color = "red";
        // bp_core_add_message($message, 'error'); // Sends error message to the page.
		// header("Refresh:0");
	}
	
}

?>
<?php if ($result): ?>
	<div class="avia_notification">
		<div class="avia_message_box avia-color-<?php echo $color;?> avia-size-large avia-icon_select-yes avia-border avia-builder-el-0  el_before_av_notification  avia-builder-el-first ">
				<span class="avia_message_box_title"><?php _e($status, 'mism'); ?></span>

				<div class="avia_message_box_content">
					<p><?php _e($message, 'mism'); ?></p>
				</div>
		</div>
	</div>
<?php endif; ?>

<div class="entry-content-wrapper clearfix">
	<div class="flex_column av_two_third flex_column_div av-zero-column-padding first avia-builder-el-0 el_before_av_one_third avia-builder-el-first" style="border-radius:0px; ">
		<section class="av_textblock_section " itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
			<div class="avia_textblock" itemprop="text">
				<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'buddypress' ); ?>" role="navigation">
					<ul>
						<?php if ( bp_is_my_profile() ) { bp_get_options_nav(); } ?>

						<?php if ( ! bp_is_current_action( 'invites' ) ) : ?>

							<!-- <li id="groups-order-select" class="last filter">

								<label for="groups-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
								<select id="groups-order-by">
									<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
									<option value="popular"><?php _e( 'Most Members', 'buddypress' ); ?></option>
									<option value="newest"><?php _e( 'Newly Created', 'buddypress' ); ?></option>
									<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>

									<?php

									/**
									 * Fires inside the members group order options select input.
									 *
									 * @since 1.2.0
									 */
									do_action( 'bp_member_group_order_options' ); ?>

								</select>
							</li> -->

						<?php endif; ?>

					</ul>
				</div><!-- .item-list-tabs -->

				<?php

				switch ( bp_current_action() ) :

					// Home/My Groups
					case 'my-groups' :

						/**
						 * Fires before the display of member groups content.
						 *
						 * @since 1.2.0
						 */
						do_action( 'bp_before_member_groups_content' ); ?>

						<?php if ( is_user_logged_in() ) : ?>
							<h2 class="bp-screen-reader-text"><?php
								/* translators: accessibility text */
								_e( 'My groups', 'buddypress' );
							?></h2>
						<?php else : ?>
							<h2 class="bp-screen-reader-text"><?php
								/* translators: accessibility text */
								_e( 'Member\'s groups', 'buddypress' );
							?></h2>
						<?php endif; ?>

						<div class="groups mygroups">

							<?php bp_get_template_part( 'groups/groups-loop' ); ?>

						</div>

						<?php

						/**
						 * Fires after the display of member groups content.
						 *
						 * @since 1.2.0
						 */
						do_action( 'bp_after_member_groups_content' );
						break;

					// Group Invitations
					case 'invites' :
						bp_get_template_part( 'members/single/groups/invites' );
						break;

					// Any other
					default :
						bp_get_template_part( 'members/single/plugins' );
						break;
				endswitch;
				?>
			</div>
		</section>
	</div>
	<div class="flex_column av_one_third flex_column_div av-zero-column-padding avia-builder-el-2 el_after_av_two_third avia-builder-el-last" style="border-radius:0px; ">
		<section class="av_textblock_section groups-sidebar-wrapper" itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
			<div class="avia_textblock groups-sidebar-inner" itemprop="text">
				<div style="padding-bottom:10px;" class="av-special-heading av-special-heading-h3 avia-builder-el-3 el_before_av_textblock avia-builder-el-first">
					<h3 class="av-special-heading-tag" itemprop="headline">Join A Group</h3>
					<div class="special-heading-border">
						<div class="special-heading-inner-border"></div>
					</div>
					<div class="content">
						<p>If you were given a group code, you can enter it below to join the group.</p>
						<form class="group_code_form" action="" method="post">
							<input type="text" name="group-code" value="" placeholder="GROUP CODE">
							<input type="submit" name="join-group" value="Join Group" class="btn-fullwidth avia-button avia-button-fullwidth">
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>



