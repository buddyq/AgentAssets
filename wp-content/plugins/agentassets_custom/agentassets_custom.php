<?php
/*
 * Plugin Name: Agentassets Custom
 *
 */

# Required Files
// These files need to be included as dependencies when on the front end.
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

# Include Files
include 'includes/shortcodes/register-form.php';
include 'includes/shortcodes/profile-form.php';

include 'includes/meta-boxes.php';
include 'includes/filters.php';
include 'includes/actions.php';
include 'includes/widgets.php';

const USE_EXPERIMENTAL = false;
if (USE_EXPERIMENTAL) {
    require_once(dirname(__FILE__) . '/includes/models/AgentInformationModel.php');
    require_once(dirname(__FILE__) . '/includes/models/PropertyDetailsModel.php');
    require_once(dirname(__FILE__) . '/includes/models/PrintableInfoModel.php');
    require_once(dirname(__FILE__) . '/includes/models/ContactInfoModel.php');

    require_once(dirname(__FILE__) . '/includes/helpers/AAAdminFormItems.php');
    require_once(dirname(__FILE__) . '/includes/helpers/AAAdminFormHelper.php');
    require_once(dirname(__FILE__) . '/includes/helpers/AAShortcodeModelMap.php');

    AAShortcodeModelMap::map('AgentInformation', AgentInformationModel::model());
    AAShortcodeModelMap::map('PropertyDetails', PropertyDetailsModel::model());
    AAShortcodeModelMap::map('PrintableInfo', PrintableInfoModel::model());
    AAShortcodeModelMap::map('ContactInfo', ContactInfoModel::model());

    include 'includes/settings/site_settings.php';
} else {
    include 'includes/shortcodes/agentinformation.php';
    include 'includes/shortcodes/theme_settings.php';
}

include 'includes/shortcodes/aa-map-render.php';
include 'includes/shortcodes/aa-media-image.php';

# Add Scripts
//wp_enqueue_script( 'jquery-validate', plugins_url('medma_custom').'/js/jquery.validate.js', '', '1.13.1', true );
// wp_enqueue_script( 'additional-methods', plugins_url('medma_custom').'/js/additional-methods.js', '', '1.13.1', true );

// wp_enqueue_script( 'mi-custom', plugins_url('medma_custom').'/js/custom.js', '', '1.0', true );

# Add Styles
add_action('init', 'medma_custom_init');

function medma_custom_init() {
    wp_enqueue_style( 'mi-custom', plugins_url('agentassets_custom').'/css/custom.css', '', time(), 'all');
    if (USE_EXPERIMENTAL)
        add_action('admin_footer','add_aa_custom_scripts_to_footer');
}

add_filter( 'wp_mail_content_type', 'custom_mi_agentassets_set_content_type' );
function custom_mi_agentassets_set_content_type( $content_type ) {
	return 'text/html';
}



function add_aa_custom_scripts_to_footer(){
?>
<script type="text/javascript">
    var media_upload = function(e) {
        var target = e.target;
        e.preventDefault();
        var image = wp.media({
            title: 'Upload File',
            multiple: false
        }).open()
            .on('select', function(e){
                var uploaded_image = image.state().get('selection').first();
                var imageData = uploaded_image.toJSON();
                console.log(imageData)
                jQuery(target).parent().find('.aa-upload-image').attr('src', imageData.url);
                jQuery(target).parent().find('.aa-upload-input').val(imageData.id);
                //jQuery(target).parent().find('.close').removeClass('hidden');
            });
    };
    jQuery(document).ready(function() {
        jQuery('.aa-upload-button').on('click', function(e) {
            media_upload(e);
        });

        jQuery(document).on('keyup', '.number-with-commas', function () {
            var x = jQuery(this).val();
            jQuery(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
    });
</script>
<?php
}
