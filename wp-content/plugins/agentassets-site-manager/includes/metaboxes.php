<?php

/*
 * User Custom Fields
 */

//add_action( 'show_user_profile', 'add_extra_custom_fields' );
//add_action( 'edit_user_profile', 'add_extra_custom_fields' );

function add_extra_custom_fields( $user )
{
    $args = array(
        'post_type' =>  'package',
        'post_status'   =>  'publish',
        'orderby'   =>  'title',
        'posts_per_page'    =>  '-1',
        'order' =>  'ASC'
    );
    $posts = get_posts($args);
    
    $assigned_package = get_user_meta( $user->ID,'assigned_package',true);
    
    
    ?>
   <?php if(is_admin())
   { ?>
    <h3>Assign Package</h3>

    <table class="assign-package form-table">
        <tr>
            <th><label for="assigned_package">Package Assigned</label></th>
            <td>
                <select name="assigned_package" id="assigned_package">
                    <option value="">Select Package</option>
                    <?php
                    foreach($posts AS $post)
                    {
                        ?>
                        <option <?php if($assigned_package==$post->ID){ echo ' selected="selected" ';}?> value="<?php echo $post->ID;?>"><?php echo $post->post_title;?></option>
                        <?php
                    }
                    ?>
                </select> 
            </td>
        </tr>
    </table>
<?php } ?>
    
    <?php
}

add_action( 'personal_options_update', 'save_extra_custom_fields' );
add_action( 'edit_user_profile_update', 'save_extra_custom_fields' );

function save_extra_custom_fields( $user_id )
{
    update_user_meta( $user_id,'assigned_package', sanitize_text_field( $_POST['assigned_package'] ) );
}

/*  Coupon Posttype | User specific metabox  */

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function micu_coupon_user_add_meta_box() {

	$screens = array( 'coupon' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'micu_coupon_user_sectionid',
			__( 'User Specific Coupon Allocation', 'micu_coupon_user_textdomain' ),
			'micu_coupon_user_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'micu_coupon_user_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function micu_coupon_user_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'micu_coupon_user_meta_box', 'micu_coupon_user_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'micu_coupon_users', true );
       
	echo '<label for="micu_coupon_user_list">';
	_e( 'Specify User', 'micu_coupon_user_textdomain' );
	echo '</label> ';
	echo '<select name="micu_coupon_users[]" multiple="multiple">';
	echo '<option value="0">All Users</option>';
	//Get All WordPress Users
	global $wpdb;
	$allusers = $wpdb->get_results("SELECT ID, user_nicename FROM $wpdb->users");
	foreach ( $allusers as $user ) {
            
            if($value == $user->ID)
            {
		echo '<option value="'.$user->ID.'" selected="selected">'.$user->user_nicename.'</option>';
            }else{
                
                echo '<option value="'.$user->ID.'">'.$user->user_nicename.'</option>';
                
            }
	}
	echo '</select>';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function micu_coupon_user_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['micu_coupon_user_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['micu_coupon_user_meta_box_nonce'], 'micu_coupon_user_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['coupon'] ) && 'page' == $_POST['coupon'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['micu_coupon_users'] ) ) {
		return;
	}

        global $wpdb;
	$allusers = $wpdb->get_results("SELECT ID, user_nicename FROM $wpdb->users");
        $count=0;
	$my_data = $_POST['micu_coupon_users'];
	// Update the meta field in the database.
	update_post_meta( $post_id, 'micu_coupon_users', $my_data );
}
add_action( 'save_post', 'micu_coupon_user_save_meta_box_data' );
?>
