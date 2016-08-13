<?php

add_action('admin_menu', 'custom_theme_options_menu');
//add_action( 'admin_menu', 'custom_admin_scripts' );


function custom_theme_options_menu()
{

    // add_menu_page('Agent Information', 'Customize Microsite', 'manage_options', 'mi-top-level-handle', 'mi_sub_agent_information');
    add_menu_page('Agent Information', 'Agent Information', 'manage_options', 'mi-sub-agent-information', 'mi_sub_agent_information','dashicons-businessman');
    add_menu_page('Property Details', 'Property Details', 'manage_options', 'mi-sub-property-details', 'mi_sub_property_details','dashicons-admin-home');
    add_menu_page('Printable Info', 'Printable Info', 'manage_options', 'mi-sub-printable-info', 'mi_sub_printable_info', 'dashicons-media-document');
    add_menu_page('Contact Info', 'Contact Info', 'manage_options', 'mi-sub-contact-details', 'mi_sub_contact_details', 'dashicons-email-alt');
    //add_menu_page('Meta Info', 'Meta Info', 'manage_options', 'mi-sub-meta-info', 'mi_sub_meta_information', 'dashicons-chart-area');
}

function mi_sub_agent_information() {
    // controller
    $notifications = array();
    $model = AgentInformationModel::model();
    if (isset($_POST[get_class($model)])) {
        $postData = $_POST[get_class($model)];
        $model->setAttributes($postData);
        if ($model->save()) {
            $notifications[] = array('class' => 'success', 'message' => 'Settings has been successfully saved.');
        }
    }
    // view
    ?>
    <div class="wrap">
        <h1><img height="50" style="vertical-align:middle;" src="http://aveone.agentassets.com/wp-content/plugins/agentassets_custom/includes/shortcodes/../../images/logo.png">
            Agent Information
        </h1>
    <?php

    // render notices
    foreach($notifications as $notification) { ?>
        <div class="notice notice-<?php echo $notification['class'];?> is-dismissible">
            <p><?php echo $notification['message'];?></p>
        </div>
    <?php }

    // render form
    AAAdminFormHelper::beginForm('','post', array(), 'AgentInformation');
    $fieldsConfig = AAAdminFormConfig::build($model);
    AAAdminFormHelper::renderFields($fieldsConfig);
    AAAdminFormHelper::endForm('Save Changes');
    ?>
    </div>
    <?php
}

function mi_sub_property_details() {
    // controller
    $notifications = array();
    $model = PropertyDetailsModel::model();
    if (isset($_POST[get_class($model)])) {
        $postData = $_POST[get_class($model)];
        $model->setAttributes($postData);
        if ($model->save()) {
            $notifications[] = array('class' => 'success', 'message' => 'Settings has been successfully saved.');
        }
    }
    // view
    ?>
    <div class="wrap">
        <h1><img height="50" style="vertical-align:middle;" src="http://aveone.agentassets.com/wp-content/plugins/agentassets_custom/includes/shortcodes/../../images/logo.png">
            Property Details
        </h1>
        <?php

        // render notices
        foreach($notifications as $notification) { ?>
            <div class="notice notice-<?php echo $notification['class'];?> is-dismissible">
                <p><?php echo $notification['message'];?></p>
            </div>
        <?php }

        // render form
        AAAdminFormHelper::beginForm('','post', array(), 'PropertyDetails');
        $fieldsConfig = AAAdminFormConfig::build($model);
        AAAdminFormHelper::renderFields($fieldsConfig);
        AAAdminFormHelper::endForm('Save Changes');
        AAAdminFormHelper::renderVisibilityLinksScript($model);
        ?>
    </div>
    <?php
}

function mi_sub_printable_info() {
    // controller
    $notifications = array();
    $model = PrintableInfoModel::model();
    if (isset($_POST[get_class($model)])) {
        $postData = $_POST[get_class($model)];
        $model->setAttributes($postData);
        if ($model->save()) {
            $notifications[] = array('class' => 'success', 'message' => 'Settings has been successfully saved.');
        }
    }
    // view
    ?>
    <div class="wrap">
        <h1><img height="50" style="vertical-align:middle;" src="http://aveone.agentassets.com/wp-content/plugins/agentassets_custom/includes/shortcodes/../../images/logo.png">
            Printable Info
        </h1>
        <?php

        // render notices
        foreach($notifications as $notification) { ?>
            <div class="notice notice-<?php echo $notification['class'];?> is-dismissible">
                <p><?php echo $notification['message'];?></p>
            </div>
        <?php }

        // render form
        AAAdminFormHelper::beginForm('','post', array(), 'PrintableInfo');
        $fieldsConfig = AAAdminFormConfig::build($model);
        $formHtml = new AAAdminFormHtml();
        $formHtml->beginContent(); ?>
        <tr>

            <td><h3>Note:</h3></td>
            <td><a href="<?php echo admin_url('edit.php?post_type=property_attachment'); ?>">Click Here</a> to add
                attachments to Printable Info
            </td>
        </tr>
        <?php
        $formHtml->endContent();
        $fieldsConfig->appendItem($formHtml);
        AAAdminFormHelper::renderFields($fieldsConfig);
        AAAdminFormHelper::endForm('Save Changes');
        ?>
    </div>
    <?php
}

function mi_sub_contact_details() {
    // controller
    $notifications = array();
    $model = ContactInfoModel::model();
    if (isset($_POST[get_class($model)])) {
        $postData = $_POST[get_class($model)];
        $model->setAttributes($postData);
        if ($model->save()) {
            $notifications[] = array('class' => 'success', 'message' => 'Settings has been successfully saved.');
        }
    }
    // view
    ?>
    <div class="wrap">
        <h1><img height="50" style="vertical-align:middle;" src="http://aveone.agentassets.com/wp-content/plugins/agentassets_custom/includes/shortcodes/../../images/logo.png">
            Contact Info
        </h1>
        <?php

        // render notices
        foreach($notifications as $notification) { ?>
            <div class="notice notice-<?php echo $notification['class'];?> is-dismissible">
                <p><?php echo $notification['message'];?></p>
            </div>
        <?php }

        // render form
        AAAdminFormHelper::beginForm('','post', array(), 'ContactInfo');
        $fieldsConfig = AAAdminFormConfig::build($model);
        $locationHeader = new AAAdminFormHtml();
        $locationHeader->beginContent();?>
        <tr>
            <th colspan="2" scope="row">
                <h2 class="options">Map Settings for Location Page</h2>
            </th>
        </tr>
        <?php
        $locationHeader->endContent();
        $fieldsConfig->appendItem($locationHeader, 2);
        AAAdminFormHelper::renderFields($fieldsConfig);
        AAAdminFormHelper::endForm('Save Changes');
        ?>
    </div>
    <?php
}
/*
function wp_gear_manager_admin_scripts()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('jquery');
}

function wp_gear_manager_admin_styles()
{
    wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
add_action('admin_print_styles', 'wp_gear_manager_admin_styles');
*/