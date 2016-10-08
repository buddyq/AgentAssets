<?php

add_action('admin_menu', 'custom_theme_options_menu');
//add_action( 'admin_menu', 'custom_admin_scripts' );


function custom_theme_options_menu()
{
    // add_menu_page('Agent Information', 'Customize Microsite', 'manage_options', 'mi-top-level-handle', 'mi_sub_agent_information');
    add_menu_page('Agent Information', 'Agent Information', 'manage_options', 'mi-sub-agent-information', 'mi_sub_agent_information','dashicons-businessman');

    if (get_current_blog_id() != 1) {
        remove_menu_page('themes.php');
        add_menu_page('Customize', 'Customize', 'customize', 'customize.php?return=%2Fwp-admin%2Fthemes.php', '', 'dashicons-admin-appearance');
    }

    add_menu_page('Property Details', 'Property Details', 'manage_options', 'mi-sub-property-details', 'mi_sub_property_details','dashicons-admin-home');
    add_menu_page('Printable Info', 'Printable Info', 'manage_options', 'mi-sub-printable-info', 'mi_sub_printable_info', 'dashicons-media-document');
    // add_menu_page('Contact Info', 'Contact Info', 'manage_options', 'mi-sub-contact-details', 'mi_sub_contact_details', 'dashicons-email-alt');
    add_menu_page('Meta Info', 'Meta Info', 'manage_options', 'mi-sub-meta-info', 'mi_sub_meta_information', 'dashicons-chart-area');
}
function mi_sub_meta_information()
{

    if (isset($_POST['submit'])) {
        $input_meta_keywords = $_POST['meta_keywords'];
        update_option('meta_keywords', $input_meta_keywords);
        $meta_keywords = stripslashes(get_option('meta_keywords', true));

        $input_meta_description = $_POST['meta_description'];
        update_option('meta_description', $input_meta_description);
        $meta_description = stripslashes(get_option('meta_description', true));

        $input_google_analytics = $_POST['google_analytics'];
        update_option('google_analytics', $input_google_analytics);
        $google_analytics = get_option('google_analytics', true);

    }
    $meta_keywords = stripslashes(get_option('meta_keywords', true));
    $meta_description = stripslashes(get_option('meta_description', true));
    $google_analytics = get_option('google_analytics', true);
    $aa_logo = '<img src="' . plugins_url( '../../images/logo.png', __FILE__ ) . '" height="50" style="vertical-align:middle;" > ';

    ?>
    <div class="wrap">
        <h1><?php echo $aa_logo ?> Meta Information</h1>

        <form method="post" action="" novalidate="novalidate">

            <table class="form-table">
                <tbody>

                <tr>
                    <th scope="row">
                        <label for="meta_keywords">Meta Keywords</label>
                    </th>
                    <td>
                        <textarea name="meta_keywords" cols="50" rows="10"><?php if (isset($meta_keywords)) {
                                echo $meta_keywords;
                            } ?></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="meta_description">Meta Description</label>
                    </th>
                    <td>
                        <textarea name="meta_description" cols="50"
                                  rows="10"><?php echo stripslashes($meta_description); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="google_analytics">Google Analytics ID</label>
                    </th>
                    <td>
                        <input name="google_analytics" type="text" id="google_analytics"
                               value="<?php if (isset($google_analytics)) {
                                   echo $google_analytics;
                               } ?>" class="regular-text">
                    </td>
                </tr>

                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    <?php

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
            <td><a href="<?php echo admin_url('edit.php?post_type=property-attachment'); ?>">Click Here</a> to add
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
        AAAdminFormHelper::beginForm('','post', array(), 'Contactinfo');
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
