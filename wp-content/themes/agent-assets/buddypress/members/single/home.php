<?php
/**
 * BuddyPress - Members Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div id="buddypress">

	<?php

	/**
	 * Fires before the display of member home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_member_home_content' ); ?>

	<div id="item-header" role="complementary">

		<?php
		if ( bp_is_user_front() ) :
			bp_displayed_user_front_template_part();

		elseif ( bp_is_user_activity() ) :
			include_once( get_stylesheet_directory() . '/buddypress/headers/activity.php');

		elseif ( bp_is_user_blogs() ) :
			include_once( get_stylesheet_directory() . '/buddypress/headers/blogs.php');

		elseif ( bp_is_user_groups() ) :
			include_once( get_stylesheet_directory() . '/buddypress/headers/groups.php');

		elseif ( bp_is_user_profile() ) :
			include_once( get_stylesheet_directory() . '/buddypress/headers/profile.php');

		elseif ( bp_is_user_notifications() ) :
			include_once( get_stylesheet_directory() . '/buddypress/headers/notifications.php');

		elseif ( bp_is_user_settings() ) :
			include_once( get_stylesheet_directory(). '/buddypress/headers/settings.php');

		endif;
		
		?>

	</div><!-- #item-header -->

	<div id="item-nav">
		<div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Member primary navigation', 'buddypress' ); ?>" role="navigation">
			<ul>

				<?php bp_get_displayed_user_nav(); ?>

				<?php

				/**
				 * Fires after the display of member options navigation.
				 *
				 * @since 1.2.4
				 */
				do_action( 'bp_member_options_nav' ); ?>

			</ul>
		</div>
	</div><!-- #item-nav -->

	<div id="item-body">

		<?php

		/**
		 * Fires before the display of member body content.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_body' );

		if ( bp_is_user_front() ) :
			bp_displayed_user_front_template_part();

		elseif ( bp_is_user_activity() ) :
			bp_get_template_part( 'members/single/activity' );

		elseif ( bp_is_user_blogs() ) :
			bp_get_template_part( 'members/single/blogs' );

		elseif ( bp_is_user_friends() ) :
			bp_get_template_part( 'members/single/friends' );

		elseif ( bp_is_user_groups() ) :
			bp_get_template_part( 'members/single/groups' );

		elseif ( bp_is_user_messages() ) :
			bp_get_template_part( 'members/single/messages' );

		elseif ( bp_is_user_profile() ) :
			bp_get_template_part( 'members/single/profile' );

		elseif ( bp_is_user_forums() ) :
			bp_get_template_part( 'members/single/forums' );

		elseif ( bp_is_user_notifications() ) :
			bp_get_template_part( 'members/single/notifications' );

		elseif ( bp_is_user_settings() ) :
			bp_get_template_part( 'members/single/settings' );

			// If nothing sticks, load a generic template
		else :
			bp_get_template_part( 'members/single/plugins' );

		endif;

		/**
		 * Fires after the display of member body content.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_body' ); ?>

	</div><!-- #item-body -->

	<?php

	/**
	 * Fires after the display of member home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_home_content' ); ?>

</div><!-- #buddypress -->
