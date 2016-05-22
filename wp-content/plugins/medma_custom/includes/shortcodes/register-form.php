<?php

add_shortcode('cu_register_form','cu_register_form');

function cu_register_form()
{
    if(isset($_POST['submit']))
    {
		
		global $wpdb;
        $username = $_POST['micu_username'];
	      $email = $_POST['micu_email'];
        $password = trim($_POST['micu_pwd']);
        $name = $_POST['micu_name'];
        $business_phone = $_POST['micu_business_phone'];
        $mobile_phone = $_POST['micu_mobile_phone'];
        $broker = $_POST['micu_broker'];
        $broker_website = $_POST['micu_broker_website'];
        $twitter = $_POST['micu_twitter'];
        $facebook = $_POST['micu_facebook'];
        $googleplus = $_POST['micu_googleplus'];
        $billing_address_1 = $_POST['micu_billing_address_1'];
        $billing_address_2 = $_POST['micu_billing_address_2'];
        $billing_city = $_POST['micu_billing_city'];
        $billing_state = $_POST['micu_billing_state'];
        $billing_zip = $_POST['micu_billing_zip'];
        $billing_email = $_POST['micu_billing_email'];
        
        $return_url = $_POST['micu_return_url'];
        remove_action('wpmu_new_user', newuser_notify_siteadmin, 999);
        # User Created
        $user_id = wpmu_create_user( $username, $password, $email );
        if(isset($user_id) && $user_id>0)
        {
            
            # Profile Picture Upload
            $profile_picture_id = '';
            if(isset($_FILES['micu_profile_picture']['error']) && $_FILES['micu_profile_picture']['error']=="0")
            {
                // Get the type of the uploaded file. This is returned as "type/extension"
                $arr_file_type = wp_check_filetype(basename($_FILES['micu_profile_picture']['name']));
                $uploaded_file_type = $arr_file_type['type'];

                // Set an array containing a list of acceptable formats
                $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

                // If the uploaded file is the right format
                if(in_array($uploaded_file_type, $allowed_file_types)) {

                    // Options array for the wp_handle_upload function. 'test_upload' => false
                    $upload_overrides = array( 'test_form' => false ); 

                    // Handle the upload using WP's wp_handle_upload function. Takes the posted file and an options array
                    $uploaded_file = wp_handle_upload($_FILES['micu_profile_picture'], $upload_overrides);

                    // If the wp_handle_upload call returned a local path for the image
                    if(isset($uploaded_file['file'])) {

                        // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
                        $file_name_and_location = $uploaded_file['file'];

                        // Generate a title for the image that'll be used in the media library
                        $file_title_for_media_library = $name.'-'.$user_id;

                        // Set up options array to add this file as an attachment
                        $attachment = array(
                            'post_mime_type' => $uploaded_file_type,
                            'post_title' => addslashes($file_title_for_media_library),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );

                        // Run the wp_insert_attachment function. This adds the file to the media library and generates the thumbnails. If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
                        $profile_picture_id = wp_insert_attachment( $attachment, $file_name_and_location );
                        $attach_data = wp_generate_attachment_metadata( $profile_picture_id, $file_name_and_location );
                        wp_update_attachment_metadata($profile_picture_id,  $attach_data);

                        // Now, update the user meta to associate the new image with the user profile picture
                        update_user_meta($user_id,'profile_picture',$profile_picture_id);

                    }
                }
            }
            
            # Broker Logo Upload
            $broker_logo_id = '';
            if(isset($_FILES['micu_broker_logo']['error']) && $_FILES['micu_broker_logo']['error']=="0")
            {
                // Get the type of the uploaded file. This is returned as "type/extension"
                $arr_file_type = wp_check_filetype(basename($_FILES['micu_broker_logo']['name']));
                $uploaded_file_type = $arr_file_type['type'];

                // Set an array containing a list of acceptable formats
                $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

                // If the uploaded file is the right format
                if(in_array($uploaded_file_type, $allowed_file_types)) {

                    // Options array for the wp_handle_upload function. 'test_upload' => false
                    $upload_overrides = array( 'test_form' => false ); 

                    // Handle the upload using WP's wp_handle_upload function. Takes the posted file and an options array
                    $uploaded_file = wp_handle_upload($_FILES['micu_broker_logo'], $upload_overrides);

                    // If the wp_handle_upload call returned a local path for the image
                    if(isset($uploaded_file['file'])) {

                        // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
                        $file_name_and_location = $uploaded_file['file'];

                        // Generate a title for the image that'll be used in the media library
                        $file_title_for_media_library = $name.'-'.$user_id;

                        // Set up options array to add this file as an attachment
                        $attachment = array(
                            'post_mime_type' => $uploaded_file_type,
                            'post_title' => addslashes($file_title_for_media_library),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );

                        // Run the wp_insert_attachment function. This adds the file to the media library and generates the thumbnails. If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
                        $broker_logo_id = wp_insert_attachment( $attachment, $file_name_and_location );
                        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                        $attach_data = wp_generate_attachment_metadata( $broker_logo_id, $file_name_and_location );
                        wp_update_attachment_metadata($broker_logo_id,  $attach_data);

                        // Now, update the user meta to associate the new image with the user profile picture
                        update_user_meta($user_id,'broker_logo',$broker_logo_id);

                    }
                }
            }
            
            # User Meta Added and Updated
            update_user_meta($user_id, 'first_name', $name );
            update_user_meta($user_id, 'business_phone', $business_phone );
            update_user_meta($user_id, 'mobile_phone', $mobile_phone );
            update_user_meta($user_id, 'broker', $broker );
            update_user_meta($user_id, 'broker_website', $broker_website );
            update_user_meta($user_id, 'twitter', $twitter );
            update_user_meta($user_id, 'facebook', $facebook );
            update_user_meta($user_id, 'googleplus', $googleplus );
            update_user_meta($user_id, 'billing_address_1', $billing_address_1 );
            update_user_meta($user_id, 'billing_address_2', $billing_address_2 );
            update_user_meta($user_id, 'billing_city', $billing_city );
            update_user_meta($user_id, 'billing_state', $billing_state );
            update_user_meta($user_id, 'billing_zip', $billing_zip );
            update_user_meta($user_id, 'billing_email', $billing_email );
            
            # Notification Mail sent to User
            wpmu_welcome_user_notification($user_id, $password);    
            $user_data_list = array(
                'ID' => $user_id,
                'name' => $name,
                'business_phone' => $business_phone,
                'mobile_phone' => $mobile_phone,
                'broker' => $broker,
                'broker_website' => $broker_website,
                'twitter' => $twitter,
                'facebook' => $facebook,
                'googleplus' => $googleplus,
                'billing_address_1' => $billing_address_1,
                'billing_address_2' => $billing_address_2,
                'billing_city' => $billing_city,
                'billing_state' => $billing_state,
                'billing_zip' => $billing_zip,
                'billing_email' => $billing_email,
                
                
            );
            do_action( 'medma_custom_admin_user_notification', $user_data_list );
            ?>
            <div class="avia_message_box avia-color-green avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-0  el_before_av_notification  avia-builder-el-first ">
                <span class="avia_message_box_title">Success</span>
                <div class="avia_message_box_content">
                    <span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>
                    <p><?php _e( 'You are successfully registered.','micu' ); ?></p>
                    <h6><?php printf( __( 'Check your inbox at <strong>%s</strong>','micu' ), $email ); ?></h6>
                </div>
            </div>
            <?php
        }
        else
        {
			
			?>
            <div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">
                <span class="avia_message_box_title"><?php _e( 'ERROR','micu' ); ?></span>
                <div class="avia_message_box_content">
                    <span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>
                    <p>Sign up process failed. Please try again.</p>
                    <?php /*<h6><?php printf( __( 'Back to <a href="%s">Registration Form</a>' ), $return_url); ?></h6>*/?>
                </div>
                <p>Either Username or Email already exists.</p>
            </div>
            <?php
        }
    }
    else
    {
		?>
		<div id="username-error" class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">
                <span class="avia_message_box_title"><?php _e( 'ERROR','micu' ); ?></span>
                <div class="avia_message_box_content">
                    <span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>
                    <p>use a different username.</p>
                   
                </div>
            </div>
        
	<?php ?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery('#form-submit').click(function(e){
				
				var username = jQuery('#micu_username').val();
				var email = jQuery('#micu_email').val();
				var data = {
					'action': 'unique_check',
					'username': username,
					'email': email
				};
                               
				jQuery('.wploaderimg').css('display','inline-block');
				// We can also pass the url value separately from ajaxurl for front end AJAX implementations
				jQuery.post('<?php echo get_option("siteurl")."/wp-admin/admin-ajax.php";?>', data, function(response) {
					//alert(response);
                                        jQuery('.wploaderimg').css('display','none');
					if(response==1)
					{
						jQuery('#micu_signup_form').submit();
					}
					else
					{
						jQuery('#username-error p').html(response);
						jQuery('#username-error').css('display','block');
						
						jQuery('html, body').animate({
							scrollTop: jQuery("#main").offset().top
						}, 2000);
						e.preventDefault();
					}
					
				});
			});
		});
		</script>
      <?php
        $html = '';
        $html .= '<form id="micu_signup_form" class="micu_ajax_form el_after_av_heading  avia-builder-el-last  " method="post" novalidate="novalidate" enctype="multipart/form-data">';

        # USER INFORMATION
        $html .= '<div class="av-special-heading av-special-heading-h3 meta-heading  el_after_av_textblock  el_before_av_contact ">';
        $html .= '<h3 class="av-special-heading-tag" itemprop="headline">'.__('User Information','micu').'</h3>';
        $html .= '<div class="special-heading-border"><div class="special-heading-inner-border"></div></div>';
        $html .= '</div>';

        $html .= '<fieldset>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_username">';
        $html .= '<label for="micu_username">'.__('Username','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_username" class="text_input is_empty" type="text" id="micu_username" value="">';
        $html.='<span class="error" id="emailError"></span>';
		$html .= '</p>';
        
        $html .= '<p class=" form_element form_element_half" id="element_micu_name">';
        $html .= '<label for="micu_name">'.__('Name','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_name" class="text_input is_empty" type="text" id="micu_name" value="">';
        $html .= '</p>';

        $html .= '<p class="first_form form_element form_element_half" id="element_micu_email">';
        $html .= '<label for="micu_email">'.__('Email','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_email" class="text_input is_empty is_email" type="text" id="micu_email" value="">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_email_confirm">';
        $html .= '<label for="micu_email_confirm">'.__('Email Confirm','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_email_confirm" class="text_input is_empty is_email" type="text" id="micu_email_confirm" value="">';
        $html .= '</p>';

        $html .= '<p class="first_form form_element form_element_half" id="element_micu_pwd">';
        $html .= '<label for="micu_pwd">'.__('Password','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_pwd" class="text_input is_empty" type="password" id="micu_pwd" value="">';
        $html .= '</p>';

        $html .= '<p class="form_element form_element_half" id="element_micu_pwd_confirm">';
        $html .= '<label for="micu_pwd_confirm">'.__('Password Confirm','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_pwd_confirm" class="text_input is_empty" type="password" id="micu_pwd_confirm" value="">';
        $html .= '</p>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_business_phone">';
        $html .= '<label for="micu_business_phone">'.__('Business Phone','micu').' </label>';
        $html .= '<input name="micu_business_phone" class="text_input" type="text" id="micu_business_phone" value="">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_mobile_phone">';
        $html .= '<label for="micu_mobile_phone">'.__('Mobile Phone','micu').' </label>';
        $html .= '<input name="micu_mobile_phone" class="text_input" type="text" id="micu_mobile_phone" value="">';
        $html .= '</p>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_profile_picture">';
        $html .= '<label for="micu_profile_picture">'.__('Profile Picture','micu').' </label>';
        $html .= '<input name="micu_profile_picture" class="text_input is_empty" type="file" id="micu_profile_picture" value="">';
        $html .= '</p>';

        $html .= '</fieldset>';

        # BROKER INFORMATION
        $html .= '<div class="av-special-heading av-special-heading-h3 meta-heading   avia-builder-el-4  el_after_av_textblock  el_before_av_contact ">';
        $html .= '<h3 class="av-special-heading-tag" itemprop="headline">'.__('Broker Information','micu').'</h3>';
        $html .= '<div class="special-heading-border"><div class="special-heading-inner-border"></div></div>';
        $html .= '</div>';

        $html .= '<fieldset>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_broker">';
        $html .= '<label for="micu_broker">'.__('Broker','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_broker" class="text_input is_empty" type="text" id="micu_broker" value="">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_broker_website">';
        $html .= '<label for="micu_broker_website">'.__('Broker Website','micu').' </label>';
        $html .= '<input name="micu_broker_website" class="text_input" type="text" id="micu_broker_website" value="">';
        $html .= '</p>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_broker_logo">';
        $html .= '<label for="micu_broker_logo">'.__('Broker Logo','micu').' </label>';
        $html .= '<input name="micu_broker_logo" class="text_input" type="file" id="micu_broker_logo" value="">';
        $html .= '</p>';

        $html .= '</fieldset>';

        # SOCIAL MEDIA
        $html .= '<div class="av-special-heading av-special-heading-h3 meta-heading   avia-builder-el-4  el_after_av_textblock  el_before_av_contact ">';
        $html .= '<h3 class="av-special-heading-tag" itemprop="headline">'.__('Social Media','micu').'</h3>';
        $html .= '<div class="special-heading-border"><div class="special-heading-inner-border"></div></div>';
        $html .= '</div>';

        $html .= '<fieldset>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_twitter">';
        $html .= '<label for="micu_twitter">'.__('Twitter','micu').' </label>';
        $html .= '<input name="micu_twitter" class="text_input" type="text" id="micu_twitter" value="">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_facebook">';
        $html .= '<label for="micu_facebook">'.__('Facebook','micu').' </label>';
        $html .= '<input name="micu_facebook" class="text_input" type="text" id="micu_facebook" value="">';
        $html .= '</p>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_googleplus">';
        $html .= '<label for="micu_googleplus">'.__('Google+','micu').' </label>';
        $html .= '<input name="micu_googleplus" class="text_input" type="text" id="micu_googleplus" value="">';
        $html .= '</p>';

        $html .= '</fieldset>';

        # BILLING INFORMATION
        $html .= '<div class="av-special-heading av-special-heading-h3 meta-heading   avia-builder-el-4  el_after_av_textblock  el_before_av_contact ">';
        $html .= '<h3 class="av-special-heading-tag" itemprop="headline">'.__('Billing Information','micu').'</h3>';
        $html .= '<div class="special-heading-border"><div class="special-heading-inner-border"></div></div>';
        $html .= '</div>';

        $html .= '<fieldset>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_billing_address_1">';
        $html .= '<label for="micu_billing_address_1">'.__('Billing Address 1','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_billing_address_1" class="text_input is_empty" type="text" id="micu_billing_address_1" value="">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_billing_address_2">';
        $html .= '<label for="micu_billing_address_2">'.__('Billing Address 2','micu').' </label>';
        $html .= '<input name="micu_billing_address_2" class="text_input" type="text" id="micu_billing_address_2" value="">';
        $html .= '</p>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_billing_city">';
        $html .= '<label for="micu_billing_city">'.__('Billing City','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_billing_city" class="text_input is_empty" type="text" id="micu_billing_city" value="">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_billing_state">';
        $html .= '<label for="micu_billing_state">'.__('Billing State','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_billing_state" class="text_input is_empty" type="text" id="micu_billing_state" value="">';
        $html .= '</p>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_billing_zip">';
        $html .= '<label for="micu_billing_zip">'.__('Billing Zip','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_billing_zip" class="text_input is_empty is_number" type="text" id="micu_billing_zip" value="">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_billing_email">';
        $html .= '<label for="micu_billing_email">'.__('Billing Email','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_billing_email" class="text_input is_empty is_email" type="text" id="micu_billing_email" value="">';
        $html .= '</p>';

        $html .= '</fieldset>';

        $html .= '<input type="hidden" name="micu_return_url" value="'.$_SERVER['REQUEST_URI'].'">';
        $html .= '<input id="form-submit" name="submit" type="submit" value="Submit" class="button" data-sending-label="Processing"><span class="wploaderimg" style="   display: none;margin: 0 10px;"><img style="margin: -10px 0;" src="'.plugins_url("medma_custom").'/images/wpspin.gif"/></span>';
        $html .= '</form>';

        return $html;
    }
}

// AJAX Call
add_action( 'wp_ajax_nopriv_unique_check', 'unique_check_callback' );
add_action( 'wp_ajax_unique_check', 'unique_check_callback' );
function unique_check_callback() {
	global $wpdb;
	
	$username = $_POST['username'];
	$email = $_POST['email'];
	
	$username_exists = 0;
	$sql = "SELECT * FROM `" . $wpdb->base_prefix . "users` WHERE `user_login`='" . $username . "'";
	$username_details = $wpdb->get_results($sql);
	$username_exists = count($username_details);
	
	$email_exists = 0;
	$sql = "SELECT * FROM `" . $wpdb->base_prefix . "users` WHERE `user_email`='" . $email . "'";
	$email_details = $wpdb->get_results($sql);
	$email_exists = count($email_details);
	
	if($username_exists>0 && $email_exists>0)
	{
		echo "Username and Email already exists";
	}
	elseif($username_exists>0)
	{
		echo "Username already exists";
	}
	elseif($email_exists>0)
	{
		echo "Email already exists";
	}
	else
	{
		// Success
		echo 1;
	}
	
	
	
	/*$sql = "SELECT user_login FROM `{$wpdb->base_prefix}users";
    $sql = "SELECT user_login FROM `" . $wpdb->base_prefix . "users` WHERE `user_login`='" . $_POST['username'] . "' OR `user_email`='" . $_POST['email'] . "'";
    $results = $wpdb->get_results($sql);
     echo "<pre>";
   print_r($results);
   echo $same_username = count($results);
*/
	wp_die();
}

add_action('medma_custom_admin_user_notification','medma_custom_admin_user_notification_callback');
                
function medma_custom_admin_user_notification_callback($userdata){
    $email = get_site_option( 'admin_email' );

    if ( is_email($email) == false )
            return false;
    
    $user_id = $userdata['ID'];
    
    $user = get_userdata( $user_id );
    
    $name = $userdata['first_name'];
    if(!$name){
        $name = 'N/A';
    }

    $business_phone = $userdata['business_phone'];
    if(!$business_phone){
        $business_phone = 'N/A';
    }

    $mobile_phone = $userdata['mobile_phone'];
    if(!$mobile_phone){
        $mobile_phone = 'N/A';
    }

    $broker = $userdata['broker'];
    if(!$broker){
        $broker = 'N/A';
    }

    $broker_website = $userdata['broker_website'];
    if(!$broker_website){
        $broker_website = 'N/A';
    }

    $twitter = $userdata['twitter'];
    if(!$twitter){
        $twitter = '#';
    }

    $facebook = $userdata['facebook'];
    if(!$facebook){
        $facebook = '#';
    }

    $googleplus = $userdata['googleplus'];
    if(!$googleplus){
        $googleplus = '#';
    }

    $billing_address_1 = $userdata['billing_address_1'];
    if(!$billing_address_1){
        $billing_address_1 = 'N/A';
    }

    $billing_address_2 = $userdata['billing_address_2'];
    if(!$billing_address_2){
        $billing_address_2 = 'N/A';
    }

    $billing_state = $userdata['billing_state'];
    if(!$billing_state){
        $billing_state = 'N/A';
    }

    $billing_city= $userdata['billing_city'];
    if(!$billing_city){
        $billing_city = 'N/A';
    }

    $billing_zip = $userdata['billing_zip'];
    if(!$billing_zip){
        $billing_zip = 'N/A';
    }

    $billing_email = $userdata['billing_email'];
    if(!$billing_email){
        $billing_email = 'N/A';
    }
    
    $msg = '<p>Dear Admin,</p>'
            . '<p>&nbsp;</p>'
            . '<p>A new user has registered with Agent Assets with below details:</p>'
            . '<p></p>'
            . '<p>Username: '.$user->user_login.'</p>'
            . '<p>Name: '.$user->user_nicename.' </p>'
            . '<p>Email: '.$user->user_email.' </p>'
            . '<p>Business Phone: '.$business_phone.' </p>'
            . '<p>Mobile Phone: '.$mobile_phone.' </p>'
            . '<p>Broker: '.$broker.'</p>'
            . '<p>Broker Website: '.$broker_website.'</p>'
            . '<p>Twitter: http://twitter.com/'.$twitter.'</p>'
            . '<p>Facebook: http://facebook.com/'.$facebook.'</p>'
            . '<p>Google Plus: http://plus.google.com/'.$googleplus.'</p>'
            . '<p>Billing Address 1: '.$billing_address_1.'</p>'
            . '<p>Billing Address 2: '.$billing_address_2.'</p>'
            . '<p>Billing City: '.$billing_city.'</p>'
            . '<p>Billing State: '.$billing_state.'</p>'
            . '<p>Billing Zip: '.$billing_zip.'</p>'
            . '<p>Billing Email: '.$billing_email.'</p>'
            . '<p>&nbsp;</p>'
            . '<p>Thanks,</p>'
            . '<p> '.$user->user_nicename.' </p>';
    
    wp_mail( $email, sprintf(__('New User Registration: %s'), $user->user_login), $msg );
}


?>
