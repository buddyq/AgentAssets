<?php

/* Basic plugin definitions */

define('AVEONE_VERSION', '0.9');

/* Make sure we don't expose any info if called directly */

if ( !function_exists( 'add_action' ) ) {
	_e( "Hi there!  I'm just a little plugin, don't mind me.", "aveone" );
	exit;
}

/* If the user can't edit theme options, no use running this plugin */

add_action('init', 'aveone_rolescheck' );

function aveone_rolescheck () {
	if ( current_user_can( 'edit_theme_options' ) ) {
		// If the user can edit theme options, let the fun begin!
		add_action( 'admin_menu', 'aveone_add_page');
		add_action( 'admin_init', 'aveone_init' );
	}
}

/* Loads the file for option sanitization */

add_action('init', 'aveone_load_sanitization' );

function aveone_load_sanitization() {
	get_template_part( 'library/functions/options-sanitize' );
}

/*
 * Creates the settings in the database by looping through the array
 * we supplied in options.php.  This is a neat way to do it since
 * we won't have to save settings for headers, descriptions, or arguments.
 *
 * Read more about the Settings API in the WordPress codex:
 * http://codex.wordpress.org/Settings_API
 *
 */

function aveone_init() {

	// Include the required files
	get_template_part( 'library/functions/options-interface' );
	get_template_part( 'library/functions/options-medialibrary-uploader' );

	// Loads the options array from the theme
	if ( $optionsfile = locate_template( array('options.php') ) ) {
		get_template_part( $optionsfile );
	}
	else if (file_exists( dirname( __FILE__ ) . '/options.php' ) ) {
    require_once dirname( __FILE__ ) . '/options.php';
	}

	$aveone_settings = get_option('aveone');

	// Updates the unique option id in the database if it has changed
	aveone_option_name();

	// Gets the unique id, returning a default if it isn't defined
	if ( isset($aveone_settings['id']) ) {
		$option_name = $aveone_settings['id'];
	}
	else {
		$option_name = 'aveone';
	}

	// If the option has no saved data, load the defaults
	if ( ! get_option($option_name) ) {
		aveone_setdefaults();
	}

	// Registers the settings fields and callback
	if (!isset( $_POST['aveone-backup-import'] )) {
		register_setting( 'aveone', $option_name, 'aveone_validate' );
	}

	// Instantiate the media uploader class
	$aveone_media_uploader = new aveone_Framework_Media_Uploader;
	$aveone_media_uploader->init();
}

/*
 * Adds default options to the database if they aren't already present.
 * May update this later to load only on plugin activation, or theme
 * activation since most people won't be editing the options.php
 * on a regular basis.
 *
 * http://codex.wordpress.org/Function_Reference/add_option
 *
 */

function aveone_setdefaults() {

	$aveone_settings = get_option('aveone');

	// Gets the unique option id
	$option_name = $aveone_settings['id'];

	/*
	 * Each theme will hopefully have a unique id, and all of its options saved
	 * as a separate option set.  We need to track all of these option sets so
	 * it can be easily deleted if someone wishes to remove the plugin and
	 * its associated data.  No need to clutter the database.
	 *
	 */

	if ( isset($aveone_settings['knownoptions']) ) {
		$knownoptions =  $aveone_settings['knownoptions'];
		if ( !in_array($option_name, $knownoptions) ) {
			array_push( $knownoptions, $option_name );
			$aveone_settings['knownoptions'] = $knownoptions;
			update_option('aveone', $aveone_settings);
		}
	} else {
		$newoptionname = array($option_name);
		$aveone_settings['knownoptions'] = $newoptionname;
		update_option('aveone', $aveone_settings);
	}

	// Gets the default options data from the array in options.php
	$options = aveone_options();

	// If the options haven't been added to the database yet, they are added now
	$values = aveone_get_default_values();

	if ( isset($values) ) {
		add_option( $option_name, $values ); // Add option with default settings
	}
}

/* Add a subpage called "Theme Options" to the appearance menu. */

if ( !function_exists( 'aveone_add_page' ) ) {
function aveone_add_page() {

global $aveone_themename;

  $page = add_theme_page( __( "Theme Options", "aveone" ), __( "Theme Options", "aveone" ), 'edit_theme_options', 'theme_options', 'aveone_theme_options_do_page');

	// Adds actions to hook in the required css and javascript
	add_action("admin_print_styles-$page",'aveone_load_styles');
	add_action("admin_print_scripts-$page", 'aveone_load_scripts');

}
}


/* Loads the CSS */

function aveone_load_styles() {
	wp_enqueue_style('theme-options', AVEONE_DIRECTORY.'css/theme-options.css');

	// ColorPicker
	wp_enqueue_style( 'wp-color-picker' );

	wp_enqueue_style('thickbox', site_url() . '/' . WPINC . '/js/thickbox/thickbox.css');
	wp_enqueue_style('google-fonts', "//fonts.googleapis.com/css?family=Raleway:200,200i,300,300i,400,400i|Roboto:100,300,300i,400,400i,700,700i");
	/**
	 * If plugin "Benchmark Email Lite" active and we are on "Theme Options" page
	 * dequeue "jquery-ui.css" which is causing conflict with Aveone theme options css
	 *
	 * @queued by Benchmark Email Lite
	 * @jquery-ui.css
	 * @since 3.1.5
	 * @by jerry
	 */
	if( class_exists( 'benchmarkemaillite_posts' ) ) {
		wp_dequeue_style( 'jquery-ui-theme' );
	}
}

/* Loads the javascript */

function aveone_load_scripts() {

	// Inline scripts from options-interface.php
	add_action('admin_head', 'aveone_admin_head');

	// Enqueued scripts
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script('options-custom', AVEONE_DIRECTORY.'js/options-custom.js', array( 'jquery', 'iris' ));
	wp_enqueue_script('myjquerycookie', AVEONE_DIRECTORY .'js/jquery-cookie.js', false);

}

function aveone_admin_head() {

	// Hook to add custom scripts
	do_action( 'aveone_custom_scripts' );
}

/*
 * Builds out the options panel.
 *
 * If we were using the Settings API as it was likely intended we would use
 * do_settings_sections here.  But as we don't want the settings wrapped in a table,
 * we'll call our own custom aveone_fields.  See options-interface.php
 * for specifics on how each individual field is generated.
 *
 * Nonces are provided using the settings_fields()
 *
 */

if ( !function_exists( 'aveone_theme_options_do_page' ) ) {

function aveone_theme_options_do_page() {
	$return = aveone_fields();
	settings_errors('theme_options');

  $aveone_themename = "aveone";

	?>

	<div class="wrap">



  <form id="default_setting_form" method="post" action="options.php" enctype="multipart/form-data">

   <div id="t4p_container" style="clear:left;">


<div id="header">
        <div class="logo">
				<h3>Ave One</h3>
				<span>1.0.0</span>
			</div>
        <div class="icon-option"></div>
			<div class="clear"></div>
		</div>

    	<div id="support-links">

      <input type="submit" class="submit-button button-primary" name="update" value="<?php _e( 'Save All Changes', 'aveone' ); ?>" />
		</div>

    <div id="tabs" style="clear:both;">
    <ul class="tabNavigation">
        <?php /*<li class="layout"><a href="#section-evl-tab-1"><?php _e( 'General', 'aveone' ); ?></a></li>*/?>
        <li class="header"><a href="#section-evl-tab-1"><?php _e( 'Header', 'aveone' ); ?></a></li>
        <?php /*<li class="footer"><a href="#section-evl-tab-2"><?php _e( 'Footer', 'aveone' ); ?></a></li>*/?>
        <li class="typography"><a href="#section-evl-tab-8"><?php _e( 'Typography', 'aveone' ); ?></a></li>
        <li class="styling"><a href="#section-evl-tab-9"><?php _e( 'Styling', 'aveone' ); ?></a></li>
        <?php /*<li class="post"><a href="#section-evl-tab-2"><?php _e( 'Blog', 'aveone' ); ?></a></li>*/?>
        <li class="connect"><a href="#section-evl-tab-2"><?php _e( 'Social Media Links', 'aveone' ); ?></a></li>
        <li class="post"><a href="#section-evl-tab-7"><?php _e( 'Agent Information', 'aveone' ); ?></a></li>
        <li class="post"><a href="#section-evl-tab-3"><?php _e( 'Property Details', 'aveone' ); ?></a></li>
        <li class="post"><a href="#section-evl-tab-4"><?php _e( 'Printables Information', 'aveone' ); ?></a></li>
        <li class="typography"><a href="#section-evl-tab-5"><?php _e( 'Meta Information', 'aveone' ); ?></a></li>
        <?php /*<li class="contentboxes"><a href="#section-evl-tab-16"><?php _e( 'Front Page Content Boxes', 'aveone' ); ?></a></li>        */?>
        <?php /*<li class="bootstrap"><a href="#section-evl-tab-14"><?php _e( 'Bootstrap Slider', 'aveone' ); ?></a></li>
        <li class="parallax"><a href="#section-evl-tab-8"><?php _e( 'Parallax Slider', 'aveone' ); ?></a></li>
        <li class="posts"><a href="#section-evl-tab-9"><?php _e( 'Posts Slider', 'aveone' ); ?></a></li>*/?>
        <li class="contact"><a href="#section-evl-tab-6"><?php _e( 'Contact', 'aveone' ); ?></a></li>
        <?php /*<li class="nav"><a href="#section-evl-tab-7"><?php _e( 'Extra', 'aveone' ); ?></a></li>
        <li class="css"><a href="#section-evl-tab-11"><?php _e( 'Custom CSS', 'aveone' ); ?></a></li>
        <li class="backup"><a href="#section-evl-tab-12"><?php _e( 'Backup', 'aveone' ); ?></a></li>*/?>
    </ul>




   <div class="tabContainer">





		<form action="options.php" method="post">
		<?php settings_fields('aveone'); ?>



		<?php echo $return[0]; /* Settings */ ?>

        <?php /* Bottom buttons */ ?>




            <div style="clear:both;"></div>

       <div class="save_bar">
				<input type="submit" class="submit-button button-primary" name="update" value="<?php _e( 'Save All Changes', 'aveone' ); ?>" />
        <input id="t4pform-reset" name="reset" type="submit" value="Options Reset" class="button submit-button reset-button" onclick="return confirm( '<?php _e( 'Click OK to reset all options. All settings will be lost!', 'aveone' ); ?>' );" />


		</form>

</div>


</form>

 <!-- / #container -->
</div>
</div><!-- / .wrap -->

<?php
}
}

/**
 * Validate Options.
 *
 * This runs after the submit/reset button has been clicked and
 * validates the inputs.
 *
 * @uses $_POST['reset']
 * @uses $_POST['update']
 */
function aveone_validate( $input ) {

	/*
	 * Restore Defaults.
	 *
	 * In the event that the user clicked the "Restore Defaults"
	 * button, the options defined in the theme's options.php
	 * file will be added to the option for the active theme.
	 */

	if ( isset( $_POST['reset'] ) ) {

	add_settings_error( 'theme_options', 'restore_defaults', '<div id="t4p-popup-reset" class="t4p-save-popup"><div class="t4p-save-reset">'.__( 'Options Reset', 'aveone' ).'</div></div>', 'updated fade' );
	 return aveone_get_default_values();
	}

	/*
	 * Udpdate Settings.
	 */

	if ( 1==1 ) {//isset( $_POST['update'] )
		$clean = array();
		$options = aveone_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = '0';
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = '0';
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'aveone_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'aveone_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		add_settings_error( 'theme_options', 'save_options', '<div id="t4p-popup-save" class="t4p-save-popup"><div class="t4p-save-reset">'.__( 'Options Updated', 'aveone' ).'</div></div>', 'updated fade' );
		return $clean;
	}

	/*
	 * Request Not Recognized.
	 */

	return aveone_get_default_values();
}

/**
 * Format Configuration Array.
 *
 * Get an array of all default values as set in
 * options.php. The 'id','std' and 'type' keys need
 * to be defined in the configuration array. In the
 * event that these keys are not present the option
 * will not be included in this function's output.
 *
 * @return    array     Rey-keyed options configuration array.
 *
 * @access    private
 */

function aveone_get_default_values() {
	$output = array();
	$config = aveone_options();
	foreach ( (array) $config as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['std'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
		if ( has_filter( 'aveone_sanitize_' . $option['type'] ) ) {
			$output[$option['id']] = apply_filters( 'aveone_sanitize_' . $option['type'], $option['std'], $option );
		}
	}
	return $output;
}

/**
 * Add Theme Options menu item to Admin Bar.
 */

add_action( 'wp_before_admin_bar_render', 'aveone_adminbar' );

function aveone_adminbar() {

	global $wp_admin_bar;

	$wp_admin_bar->add_menu( array(
		'parent' => 'appearance',
		'id' => 'aveone_theme_options',
		'title' => __( 'Theme Options', 'aveone' ),
		'href' => admin_url( 'themes.php?page=theme_options' )
  ));
}

if ( ! function_exists( 'aveone_get_option' ) ) {

	/**
	 * Get Option.
	 *
	 * Helper function to return the theme option value.
	 * If no value has been saved, it returns $default.
	 * Needed because options are
    as serialized strings.
	 */

	function aveone_get_option( $name, $default = false ) {
		$config = get_option( 'aveone' );

		if ( ! isset( $config['id'] ) ) {
			return $default;
		}

		$options = get_option( $config['id'] );

		if ( isset( $options[$name] ) ) {
			return $options[$name];
		}

		return $default;
	}
}
