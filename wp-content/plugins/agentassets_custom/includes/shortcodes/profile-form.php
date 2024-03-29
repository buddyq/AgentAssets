<?php

add_shortcode('edit_my_profile','cu_edit_profile_form');

function cu_edit_profile_form()
{

    $user_id = get_current_user_id();
    $user_details = get_user_by('id',$user_id);

    if(isset($_POST['update_form']) && $_POST['update_form'] == "Update")
    {
        $username = $_POST['micu_username'];
        $email = $_POST['micu_email'];

//        if(isset($_POST['micu_pwd']) && $_POST['micu_pwd']!="")
//        {
//            $password = trim($_POST['micu_pwd']);
//        }

        $name = $_POST['micu_name'];
        $business_phone = $_POST['micu_business_phone'];
        $mobile_phone = $_POST['micu_mobile_phone'];
        $broker = $_POST['micu_broker'];
        $broker_website = $_POST['micu_broker_website'];
        $twitter = $_POST['micu_twitter'];
        $facebook = $_POST['micu_facebook'];
        $designation = $_POST['micu_designation'];
        $googleplus = $_POST['micu_googleplus'];
        $return_url = $_POST['micu_return_url'];

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
        update_user_meta($user_id, 'designation', $designation );
    }


    $username = $user_details->data->user_login;
    $email = $user_details->data->user_email;
    $attachment_id = get_user_meta($user_id, 'profile_picture', true);

    if($attachment_id!=""){
        $profile_pic_url = wp_get_attachment_image_src($attachment_id,'full');
        $profile_pic = is_array($profile_pic_url) ? $profile_pic_url[0] : (plugins_url('medma-site-manager').'/images/dummy_agent_pic.png');
    }else{
        $profile_pic = plugins_url('medma-site-manager').'/images/dummy_agent_pic.png';
    }

    $broker_attachment_id = get_user_meta($user_id, 'broker_logo', true);
    if($broker_attachment_id!=""){
        $broker_pic_url = wp_get_attachment_image_src($broker_attachment_id,'full');
        $broker_pic = is_array($broker_pic_url) ? $broker_pic_url[0] : (plugins_url('medma-site-manager').'/images/placeholder_wide.jpg');
    }else{
        $broker_pic = plugins_url('medma-site-manager').'/images/placeholder_wide.jpg';
    }

    $html = '';
    if(isset($_GET['form']) && $_GET['form']=="edit")
    {

        # Fetch User Meta Information
        $firstName = get_user_meta($user_id, 'first_name', true);
        $businessPhone = get_user_meta($user_id, 'business_phone', true);
        $mobilePhone = get_user_meta($user_id, 'mobile_phone', true);
        $twitter_url = get_user_meta($user_id, 'twitter', true);
        $facebook_url = get_user_meta($user_id, 'facebook', true);
        $google_plus_url = get_user_meta($user_id, 'googleplus', true);
        $designation = get_user_meta($user_id, 'designation', true);
        $brokerName = get_user_meta($user_id, 'broker', true);
        $brokerWebsite = get_user_meta($user_id, 'broker_website', true);
        $edit_form_return_url = get_option('msm_edit_return_url');

        $html .= '<form id="micu_signup_form" class="micu_ajax_form el_after_av_heading  avia-builder-el-last  " method="post" novalidate="novalidate" enctype="multipart/form-data" action="'.$edit_form_return_url.'">';

        # USER INFORMATION
        $html .= '<div class="av-special-heading av-special-heading-h3 meta-heading  el_after_av_textblock  el_before_av_contact ">';
        $html .= '<h3 class="av-special-heading-tag" itemprop="headline">'.__('User Information','micu').'</h3>';
        $html .= '<div class="special-heading-border"><div class="special-heading-inner-border"></div></div>';
        $html .= '</div>';

        $html .= '<fieldset>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_username">';
        $html .= '<label for="micu_username">'.__('Username','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_username" class="text_input is_empty" type="text" readonly="true" id="micu_username" value="'.$username.'">';
        $html .= '</p>';

        $html .= '<p class="form_element form_element_half" id="element_micu_name">';
        $html .= '<label for="micu_name">'.__('Name','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_name" class="text_input is_empty" type="text" id="micu_name" value="'.$firstName.'">';
        $html .= '</p>';

//        $html .= '<p class="first_form form_element form_element_half" id="element_micu_pwd">';
//        $html .= '<label for="micu_pwd">'.__('Password','micu').' <abbr class="required" title="required">*</abbr></label>';
//        $html .= '<input name="micu_pwd" class="text_input is_empty" type="password" id="micu_pwd" value="">';
//        $html .= '</p>';
//
//        $html .= '<p class=" form_element form_element_half" id="element_micu_pwd_confirm">';
//        $html .= '<label for="micu_pwd_confirm">'.__('Password Confirm','micu').' <abbr class="required" title="required">*</abbr></label>';
//        $html .= '<input name="micu_pwd_confirm" class="text_input is_empty" type="password" id="micu_pwd_confirm" value="">';
//        $html .= '</p>';

        $html .= '<p class="first_form form_element form_element_half" id="element_micu_business_phone">';
        $html .= '<label for="micu_business_phone">'.__('Business Phone','micu').' </label>';
        $html .= '<input name="micu_business_phone" class="text_input" type="text" id="micu_business_phone" value="'.$businessPhone.'">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_mobile_phone">';
        $html .= '<label for="micu_mobile_phone">'.__('Mobile Phone','micu').' </label>';
        $html .= '<input name="micu_mobile_phone" class="text_input" type="text" id="micu_mobile_phone" value="'.$mobilePhone.'">';
        $html .= '</p>';

        $html .= '<p class="first_form form_element form_element_half" id="element_micu_email">';
        $html .= '<label for="micu_email">'.__('Email','micu').' <abbr class="required" title="required">*</abbr></label>';
        $html .= '<input name="micu_email" readonly="true" class="text_input is_empty is_email" type="text" id="micu_email" value="'.$email.'">';
        $html .= '</p>';

        $html .= '<p class="form_element form_element_half" id="element_micu_designation">';
        $html .= '<label for="micu_designation">'.__('Designaton','micu').' </label>';
        $html .= '<input class="av_four_fiftth edit_form_designation text_input" name="micu_designation" class="text_input is_empty" type="text" id="micu_designation" value="'.$designation.'">';
        $html .= '</p>';

        $html .= '<p class="first_form form_element form_element_half" id="element_micu_profile_picture">';
        $html .= '<label for="micu_profile_picture">'.__('Profile Picture','micu').' </label>';
        $html .= '<img class="av_one_fifth edit_form_profile_pic no_margin" src="'.$profile_pic.'" /><input class="av_four_fiftth edit_form_profile_pic_file" name="micu_profile_picture" class="text_input is_empty" type="file" id="micu_profile_picture" value="">';
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
        $html .= '<input name="micu_broker" class="text_input is_empty" type="text" id="micu_broker" value="'.$brokerName.'">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_broker_website">';
        $html .= '<label for="micu_broker_website">'.__('Broker Website','micu').' </label>';
        $html .= '<input name="micu_broker_website" class="text_input" type="text" id="micu_broker_website" value="'.$brokerWebsite.'">';
        $html .= '</p>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_broker_logo">';
        $html .= '<label for="micu_broker_logo">'.__('Broker Logo','micu').' </label>';
        $html .= '<img class="av_one_fifth edit_form_broker_pic no_margin" src="'.$broker_pic.'" /><input class="av_four_fiftth edit_form_broker_pic_file" name="micu_broker_logo" class="text_input" type="file" id="micu_broker_logo" value="">';
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
        $html .= '<input name="micu_twitter" class="text_input" type="text" id="micu_twitter" value="'.$twitter_url.'">';
        $html .= '</p>';

        $html .= '<p class=" form_element form_element_half" id="element_micu_facebook">';
        $html .= '<label for="micu_facebook">'.__('Facebook','micu').' </label>';
        $html .= '<input name="micu_facebook" class="text_input" type="text" id="micu_facebook" value="'.$facebook_url.'">';
        $html .= '</p>';

        $html .= '<p class=" first_form  form_element form_element_half" id="element_micu_googleplus">';
        $html .= '<label for="micu_googleplus">'.__('Google+','micu').' </label>';
        $html .= '<input name="micu_googleplus" class="text_input" type="text" id="micu_googleplus" value="'.$google_plus_url.'">';
        $html .= '</p>';

        $html .= '</fieldset>';

        $html .= '<input name="update_form" type="submit" value="'.__('Update','micu').'" class="button" data-sending-label="Processing">';

        $html .= '</form>';
    }
    else
    {
        if(isset($_GET['message']) && $_GET['message']== "success"){
            ?>
            <div class="avia_message_box avia-color-green avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-0  el_before_av_notification  avia-builder-el-first ">
                <span class="avia_message_box_title">Success</span>
                <div class="avia_message_box_content">
                    <span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>
                    <p>Profile updated successfully.</p>
                </div>
            </div>
            <?php
        }

        # Fetch User Meta Information
        $firstName = get_user_meta($user_id, 'first_name', true);
        if($firstName==""){
            $firstName = 'N/A';
        }
        $businessPhone = get_user_meta($user_id, 'business_phone', true);
        if($businessPhone==""){
            $businessPhone = 'N/A';
        }
        $mobilePhone = get_user_meta($user_id, 'mobile_phone', true);
        if($mobilePhone==""){
            $mobilePhone = 'N/A';
        }

        $designation = get_user_meta($user_id, 'designation', true);
        if($designation==""){
            $designation = 'N/A';
        }

        $brokerName = get_user_meta($user_id, 'broker', true);
        if($brokerName==""){
            $brokerName = 'N/A';
        }

        $html .= '<div id="micu_signup_form" class="micu_ajax_form el_after_av_heading  avia-builder-el-last  ">';

        # USER INFORMATION
        $html .= '<table>';
        $html .= '<thead class="site-list-container">';
        $html .= '<th colspan="2" itemprop="headline">'.__('User Information','micu').'</th>';
        $html .= '</thead>';

        $html .= '<tbody>';

        $html .= '<tr>';
        $html .= '<td >';
        $html .= '<label for="micu_username">'.__('Username','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span>'.$username.'</span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="micu_name">'.__('Name','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span>'.$firstName.'</span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="micu_designation">'.__('Designations','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span>'.$designation.'</span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="micu_email">'.__('Email','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span>'.$email.'</span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="micu_business_phone">'.__('Business Phone','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span>'.$businessPhone.'</span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="micu_mobile_phone">'.__('Mobile Phone','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span>'.$mobilePhone.'</span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="micu_profile_picture">'.__('Profile Picture','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span><img src="'.$profile_pic.'" alt="'.$firstName.'" height="75" width="75"/></span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="micu_broker">'.__('Broker','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span>'.$brokerName.'</span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<label for="micu_broker">'.__('Broker Logo','micu').' </label>';
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<span><img class="broker_logo_edit_view" src="'.$broker_pic.'" alt="broker_logo" width="150px" height="150px"/></span>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td colspan="2" align="right">';
        $html .= '<a class="button" href="?form=edit">'.__('Edit Profile','micu').'</a>';
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
    }
    return $html;

}

?>
