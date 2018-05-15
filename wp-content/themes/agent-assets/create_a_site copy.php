<?php
/* Template Name: Create_A_Site */
/** Sets up the WordPress Environment. */
// require( dirname(__FILE__) . '/wp-load.php' );

// This overrides the WP-SIGNUP.php page in the WP main folder!

add_action( 'wp_head', 'wp_no_robots' );

global $avia_config;

get_header();
if (get_post_meta(get_the_ID(), 'header', true) != 'no')
    echo avia_title();
// require( dirname( __FILE__ ) . '/wp-blog-header.php' );

if ( is_array( get_site_option( 'illegal_names' )) && isset( $_GET[ 'new' ] ) && in_array( $_GET[ 'new' ], get_site_option( 'illegal_names' ) ) ) {
	wp_redirect( network_home_url() );
	die();
}

/**
 * Prints signup_header via wp_head
 *
 * @since MU
 */
function do_signup_header() {
	/**
	 * Fires within the head section of the site sign-up screen.
	 *
	 * @since 3.0.0
	 */
	do_action( 'signup_header' );
}
add_action( 'wp_head', 'do_signup_header' );

if ( !is_multisite() ) {
	wp_redirect( wp_registration_url() );
	die();
}

if ( !is_main_site() ) {
	wp_redirect( network_site_url( 'wp-signup.php' ) );
	die();
}

// Fix for page title
$wp_query->is_404 = false;

/**
 * Fires before the Site Signup page is loaded.
 *
 * @since 4.4.0
 */
// do_action( 'before_signup_header' );

/**
 * Prints styles for front-end Multisite signup pages
 *
 * @since MU
 */
function wpmu_signup_stylesheet() {
	?>
	<style type="text/css">
		#top .main_color #setupform input::placeholder{
			color:#aaa;
			font-style: italic;
		}
		#top .main_color input[type='text']{ padding: 13px;}
		.mu_register { width: 90%; margin:0 auto; }
		.mu_register form { margin-top: 2em; }
		.mu_register .error { font-weight:700; padding:10px; color:#333333; background:#FFEBE8; border:1px solid #CC0000; }
		.mu_register input[type="submit"],
			.mu_register #blog_title,
			.mu_register #user_email,
			.mu_register #blogname,
			.mu_register #user_name { width:100%; font-size: 24px; margin:5px 0; }
		.mu_register #site-language { display: block; }
		.mu_register .prefix_address,
			.mu_register .suffix_address {font-size: 18px;display:inline; }
		.mu_register label { font-weight:700; font-size:15px; display:block; margin:10px 0; }
		.mu_register label.checkbox { display:inline; }
		.mu_register .mu_alert { font-weight:700; padding:10px; color:#333333; background:#ffffe0; border:1px solid #e6db55; }
	</style>
	<?php
}

add_action( 'wp_head', 'wpmu_signup_stylesheet' );
wp_enqueue_script( 'steps-script', get_stylesheet_directory_uri().'/inc/js/jquery.steps.min.js' );
wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri().'/inc/js/theme-scripts.js' );
get_header( 'wp-signup' );

/**
 * Fires before the site sign-up form.
 *
 * @since 3.0.0
 */
do_action( 'before_signup_form' );
?>
<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

	<div class='container'>

		<main class='template-page content  <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'page'));?>>

<div id="signup-content" class="widecolumn">
  <div class="mu_register wp-signup-container">
<?php
/**
 * Generates and displays the Signup and Create Site forms
 *
 * @since MU
 *
 * @param string          $blogname   The new site name.
 * @param string          $blog_title The new site title.
 * @param WP_Error|string $errors     A WP_Error object containing existing errors. Defaults to empty string.
 */
function show_blog_form( $blogname = '', $blog_title = '', $errors = '' ) {
	if ( ! is_wp_error( $errors ) ) {
		$errors = new WP_Error();
	}

	$current_site = get_current_site();
	// Blog name
	/*Start field row */
	echo '<p class="first_form form_element form_fullwidth">';
	if ( !is_subdomain_install() )
		echo '<label for="blogname">' . __('Site Name') . '</label>';
	else
		echo '<label for="blogname">' . __('Your Domain Name') . '</label>';

	if ( $errmsg = $errors->get_error_message('blogname') ) { ?>
		<span class="error"><?php echo $errmsg ?></span>
	<?php }
	
	if ( !is_subdomain_install() )
		echo '<span class="prefix_address">' . $current_site->domain . $current_site->path . '</span><input name="blogname" type="text" id="blogname" value="'. esc_attr($blogname) .'" maxlength="60" /><br />';
	else
		echo '<input class="text_input is_empty" name="blogname" placeholder="Example: yourdomain.com" type="text" id="blogname" value="'.esc_attr($blogname).'" maxlength="60" />';
		echo '<span class="description">Either of these will work: http://www.yoursite.com, www.yoursite.com, yoursite.com</span>';
	if ( ! is_user_logged_in() ) {
		if ( ! is_subdomain_install() ) {
			$site = $current_site->domain . $current_site->path . __( 'sitename' );
		} else {
			$site = __( 'domain' ) . '.' . $site_domain . $current_site->path;
		}

		/* translators: %s: site address */
		echo '<p>(<strong>' . sprintf( __( 'Your address will be %s.' ), $site ) . '</strong>) ' . __( 'Must be at least 4 characters, letters and numbers only. It cannot be changed, so choose carefully!' ) . '</p>';
	}
	echo '</p>';
	// Blog Title
	?>
	<p class="first_form form_element form_fullwidth">
	<label for="blog_title"><?php _e('Site Title') ?></label>
	<?php if ( $errmsg = $errors->get_error_message('blog_title') ) { ?>
		<span class="error"><?php echo $errmsg ?></span>
	<?php }
	echo '<input class="text_input is_empty" name="blog_title" placeholder="1234 Anywhere Road" type="text" id="blog_title" value="'.esc_attr($blog_title).'" />';
	echo '<span class="description">This will be the title of your site. This is visible on the web.</span>';
  ?>
	</p>
	<?php
	// Site Language.
	$languages = signup_get_available_languages();

	if ( ! empty( $languages ) ) :
		?>
		<p>
			<label for="site-language"><?php _e( 'Site Language' ); ?></label>
			<?php
			// Network default.
			$lang = get_site_option( 'WPLANG' );

			if ( isset( $_POST['WPLANG'] ) ) {
				$lang = $_POST['WPLANG'];
			}

			// Use US English if the default isn't available.
			if ( ! in_array( $lang, $languages ) ) {
				$lang = '';
			}

			wp_dropdown_languages( array(
				'name'                        => 'WPLANG',
				'id'                          => 'site-language',
				'selected'                    => $lang,
				'languages'                   => $languages,
				'show_available_translations' => false,
			) );
			?>
		</p>
	<?php endif; // Languages. ?>
	<input type="hidden" name="blog_public" value="1" />
  </div><!-- end div of step! -->

	<?php
	/**
	 * Fires after the site sign-up form.
	 *
	 * @since 3.0.0
	 *
	 * @param WP_Error $errors A WP_Error object possibly containing 'blogname' or 'blog_title' errors.
	 */
	do_action( 'signup_blogform', $errors );
}

/**
 * Validate the new site signup
 *
 * @since MU
 *
 * @return array Contains the new site data and error messages.
 */
 
function validate_blog_form() {
	global $domain_name_to_park;
	$user = '';
	if ( is_user_logged_in() )
		$user = wp_get_current_user();
		
		// Added by Buddy Quaid
		$errors = new WP_Error();
		$domain = $_POST['blogname'];
		$domain_root = parse_url($domain); //strips possible http://
		if (isset($domain_root['host'])) {
			 $domain_name_to_park = preg_replace( '|^www\.|', '', $domain_root['host'] );
		}elseif (isset($domain_root['path'])) {
			 $domain_name_to_park = preg_replace( '|^www\.|', '', $domain_root['path'] );
		}
		
		$subdomain = preg_split( '/(?=\.[^.]+$)/', $domain_name_to_park );
		$subdomain = $subdomain[0]; 
		if( count($subdomain) == 1 ){
			$errors->add('blogname','If you dont use a valid domain name, then it wont park a domain!');
		}

	// return wpmu_validate_blog_signup($_POST['blogname'], $_POST['blog_title'], $user);
	return wpmu_validate_blog_signup( $subdomain , $_POST['blog_title'], $user);

}

/**
 * Display user registration form
 *
 * @since MU
 *
 * @param string          $user_name  The entered username.
 * @param string          $user_email The entered email address.
 * @param WP_Error|string $errors     A WP_Error object containing existing errors. Defaults to empty string.
 */
function show_user_form($user_name = '', $user_email = '', $errors = '') {
	if ( ! is_wp_error( $errors ) ) {
		$errors = new WP_Error();
	}

	// User name
	echo '<label for="user_name">' . __('Username') . '</label>';
	if ( $errmsg = $errors->get_error_message('user_name') ) {
		echo '<p class="error">'.$errmsg.'</p>';
	}
	echo '<input name="user_name" type="text" id="user_name" value="'. esc_attr( $user_name ) .'" autocapitalize="none" autocorrect="off" maxlength="60" /><br />';
	_e( '(Must be at least 4 characters, letters and numbers only.)' );
	?>

	<label for="user_email"><?php _e( 'Email&nbsp;Address' ) ?></label>
	<?php if ( $errmsg = $errors->get_error_message('user_email') ) { ?>
		<p class="error"><?php echo $errmsg ?></p>
	<?php } ?>
	<input name="user_email" type="email" id="user_email" value="<?php  echo esc_attr($user_email) ?>" maxlength="200" /><br /><?php _e('We send your registration email to this address. (Double-check your email address before continuing.)') ?>
	<?php
	if ( $errmsg = $errors->get_error_message('generic') ) {
		echo '<p class="error">' . $errmsg . '</p>';
	}
	/**
	 * Fires at the end of the user registration form on the site sign-up form.
	 *
	 * @since 3.0.0
	 *
	 * @param WP_Error $errors A WP_Error object containing containing 'user_name' or 'user_email' errors.
	 */
	do_action( 'signup_extra_fields', $errors );
}

/**
 * Validate user signup name and email
 *
 * @since MU
 *
 * @return array Contains username, email, and error messages.
 */
function validate_user_form() {
	return wpmu_validate_user_signup($_POST['user_name'], $_POST['user_email']);
}

/**
 * Allow returning users to sign up for another site
 *
 * @since MU
 *
 * @param string          $blogname   The new site name
 * @param string          $blog_title The new site title.
 * @param WP_Error|string $errors     A WP_Error object containing existing errors. Defaults to empty string.
 */
function signup_another_blog( $blogname = '', $blog_title = '', $errors = '' ) {
	$current_user = wp_get_current_user();

	if ( ! is_wp_error($errors) ) {
		$errors = new WP_Error();
	}

	$signup_defaults = array(
		'blogname'   => $blogname,
		'blog_title' => $blog_title,
		'errors'     => $errors
	);

	/**
	 * Filters the default site sign-up variables.
	 *
	 * @since 3.0.0
	 *
	 * @param array $signup_defaults {
	 *     An array of default site sign-up variables.
	 *
	 *     @type string   $blogname   The site blogname.
	 *     @type string   $blog_title The site title.
	 *     @type WP_Error $errors     A WP_Error object possibly containing 'blogname' or 'blog_title' errors.
	 * }
	 */
	$filtered_results = apply_filters( 'signup_another_blog_init', $signup_defaults );

	$blogname = $filtered_results['blogname'];
	$blog_title = $filtered_results['blog_title'];
	$errors = $filtered_results['errors'];
  
  echo '<h2>Step: 1</h2>';
  echo '<div class="step">';
	echo '<div style="padding-bottom:20px;color:#559987;" class="av-special-heading av-special-heading-h3 custom-color-heading   avia-builder-el-1  el_after_av_button  avia-builder-el-last  page-top "><h3 class="av-special-heading-tag page-top" itemprop="headline">Enter Your Site Information</h3><div class="special-heading-border"><div class="special-heading-inner-border" style="border-color:#559987"></div></div></div>';

	// echo '<h2>' . sprintf( __( 'Get <em>another</em> %s site in seconds' ), get_current_site()->site_name ) . '</h2>';

	if ( $errors->get_error_code() ) {
		echo '<p class="errors">' . __( 'There was a problem, please correct the form below and try again.' ) . '</p>';
	}
	?>
	
	<!-- <form id="setupform" method="post" action="wp-signup.php"> -->
	<form id="setupform" method="post" action="">
		<input type="hidden" name="stage" value="gimmeanotherblog" />
		<?php
		/**
		 * Hidden sign-up form fields output when creating another site or user.
		 *
		 * @since MU
		 *
		 * @param string $context A string describing the steps of the sign-up process. The value can be
		 *                        'create-another-site', 'validate-user', or 'validate-site'.
		 */
		do_action( 'signup_hidden_fields', 'create-another-site' );
		?>
		<?php show_blog_form($blogname, $blog_title, $errors); ?>
		<div class="avia-button-wrap avia-button-center  avia-builder-el-0  el_before_av_heading  avia-builder-el-first  ">
			<a onclick="document.getElementById('setupform').submit();" href="javascript:{}" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-x-large avia-position-center ">
				<span class="avia_iconbox_title">Create A Site</span>
			</a>
		</div>
		<!-- <p class="submit"><input type="submit" name="submit" class="submit" value="<?php esc_attr_e( 'Create Site' ) ?>" /></p> -->
	</form>
</div>
	<?php
}

/**
 * Validate a new site signup.
 *
 * @since MU
 *
 * @return null|bool True if site signup was validated, false if error.
 *                   The function halts all execution if the user is not logged in.
 */
function validate_another_blog_signup() { // Buddy Quaid
	global $wpdb, $blogname, $blog_title, $errors, $domain, $path, $domain_name_to_park;
	$current_user = wp_get_current_user();
	if ( ! is_user_logged_in() ) {
		die();
	}

	$result = validate_blog_form();

	// $is_domain_parked     = AgentAssets::add_parked_domain($domain_name_to_park);
    // 
	// if (!$is_domain_parked){
	// 	$result['errors'][] = 'Hmmm... We were unable to park the domain for some reason! Lemme tell my boss.';
    // //TO-DO Send email message that this failed!
    // $message  = '<h1>AgentAssets failed to park a domain!</h1>';
    // $message .= '<h3>Here is the info: </h3>';
    // $message .= "<p><strong>Site Name: </strong>$blogname</p>";
    // $message .= "<p><strong>Site Domain: </strong>$domain</p>";
    // $message .= "<p><strong>Site Path: </strong>$path</p>";
    // $message .= "<p><strong>Site to Park: </strong>$domain_name_to_park</p>";
    // $subject = "System Alert - Site was not parked on AgentAssets";
    // 
    // wp_mail('bquaid@gmail.com', $subject, $message);
	// }
	// Extracted values set/overwrite globals.
	$domain = $result['domain'];
	$path = $result['path'];
	$blogname = $result['blogname'];
	$blog_title = $result['blog_title'];
	$errors = $result['errors'];

	if ( $errors->get_error_code() ) {
		signup_another_blog($blogname, $blog_title, $errors);
		return false;
	}

	$public = (int) $_POST['blog_public'];

	$blog_meta_defaults = array(
		'lang_id' => 1,
		'public'  => $public
	);

	// Handle the language setting for the new site.
	if ( ! empty( $_POST['WPLANG'] ) ) {

		$languages = signup_get_available_languages();

		if ( in_array( $_POST['WPLANG'], $languages ) ) {
			$language = wp_unslash( sanitize_text_field( $_POST['WPLANG'] ) );

			if ( $language ) {
				$blog_meta_defaults['WPLANG'] = $language;
			}
		}

	}
    
    $blog_meta_defaults['domain_name_to_park'] = $domain_name_to_park;
    

	/**
	 * Filters the new site meta variables.
	 *
	 * Use the {@see 'add_signup_meta'} filter instead.
	 *
	 * @since MU
	 * @deprecated 3.0.0 Use the {@see 'add_signup_meta'} filter instead.
	 *
	 * @param array $blog_meta_defaults An array of default blog meta variables.
	 */
	$meta_defaults = apply_filters( 'signup_create_blog_meta', $blog_meta_defaults );

	/**
	 * Filters the new default site meta variables.
	 *
	 * @since 3.0.0
	 *
	 * @param array $meta {
	 *     An array of default site meta variables.
	 *
	 *     @type int $lang_id     The language ID.
	 *     @type int $blog_public Whether search engines should be discouraged from indexing the site. 1 for true, 0 for false.
	 * }
	 */
	$meta = apply_filters( 'add_signup_meta', $meta_defaults );

	$blog_id = wpmu_create_blog( $domain, $path, $blog_title, $current_user->ID, $meta, $wpdb->siteid );
	// $added_domain_mapping = AgentAssets::add_domain_mapping($domain_name_to_park, $blog_id);
	if ( is_wp_error( $blog_id ) ) {
		return false;
	}

	confirm_another_blog_signup( $domain, $path, $blog_title, $current_user->user_login, $current_user->user_email, $meta, $blog_id );
	return true;
}

/**
 * Confirm a new site signup.
 *
 * @since MU
 * @since 4.4.0 Added the `$blog_id` parameter.
 *
 * @param string $domain     The domain URL.
 * @param string $path       The site root path.
 * @param string $blog_title The site title.
 * @param string $user_name  The username.
 * @param string $user_email The user's email address.
 * @param array  $meta       Any additional meta from the {@see 'add_signup_meta'} filter in validate_blog_signup().
 * @param int    $blog_id    The site ID.
 */
function confirm_another_blog_signup( $domain, $path, $blog_title, $user_name, $user_email = '', $meta = array(), $blog_id = 0 ) {

	$mycred  = mycred();
	$user_id = get_current_user_id(); // Added by Buddy Quaid
	$mycred->add_creds(
		'Create a Site',
		$user_id,
		-1,
		'Site created: <strong>' . $blog_title . '</strong>'
	);
    $new_balance = $mycred->get_users_balance( $user_id );
    
    site_create_checklist( $blog_id, $user_id, $domain, $path, $site_id = 0, $meta );
    
	if ( $blog_id ) {
		switch_to_blog( $blog_id );
		$home_url  = home_url( '/' );
		$login_url = wp_login_url();
		$edit_url  = $home_url . "wp-admin";
		restore_current_blog();
	} else {
		$home_url  = 'http://' . $domain . $path;
		$login_url = 'http://' . $domain . $path . 'wp-login.php';
		$edit_url  = 'http://' . $domain . $path . 'wp-admin.php'; //Added by Buddy Quaid
	}

	$site = sprintf( '<a href="%1$s" target="_blank">%2$s</a>',
		esc_url( $home_url ),
		$blog_title
	);
    
    $user = get_userdata($user_id);
    
	?>
	<script>jQuery('.credit-counter').html(<?php echo $new_balance;?>);</script>
	<!-- <div class="avia_message_box avia-color-green avia-size-large avia-icon_select-yes avia-border  avia-builder-el-0  el_before_av_notification  avia-builder-el-first "> -->
        
    <div id="avia-messagebox-b502e87b7e1903cc488bd38d66e701bb" class="avia_message_box avia-color-green avia-size-large avia-icon_select-yes avia-border avia-builder-el-0 el_before_av_icon_box messagebox-large" data-contents="b502e87b7e1903cc488bd38d66e701bb">
        
			<!-- <span class="avia_message_box_title"><?php _e('Success', 'mism'); ?></span> -->

			<div class="avia_message_box_content">
					<span class="avia_message_box_icon" aria-hidden="true" data-av_icon=""
								data-av_iconfont="entypo-fontello"></span>

					<p><?php _e('Site created successfully.', 'mism'); ?></p>
			</div>
	</div>
    
    <div id="av-layout-grid-1" class="av-layout-grid-container entry-content-wrapper main_color av-flex-cells avia-builder-el-2 el_after_av_heading  avia-builder-el-last submenu-not-first container_wrap fullsize">
        <div class="flex_cell no_margin av_one_third  avia-builder-el-3 el_before_av_cell_one_third avia-builder-el-first">
            <div class="flex_cell_inner"></div>
        </div>
        <div class="flex_cell no_margin av_one_third avia-builder-el-4 el_after_av_cell_one_third el_before_av_cell_one_third">
            <div class="flex_cell_inner">
                <article class="iconbox iconbox_top main_color avia-builder-el-5 avia-builder-el-no-sibling" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
                    <div class="iconbox_content">
                        <header class="entry-content-header">
                            <div class="iconbox_icon heading-color" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></div>
                            <h3 class="iconbox_content_title" itemprop="headline">Your Site was Created!</h3>
                        </header>
                        <div class="iconbox_content_container" itemprop="text">
                            <!-- <h3>Here's the deets...</h3>
                            <p>Site Name: <strong><?php echo $site; ?></strong><br>
                            You can see it here: <a href="<?php echo esc_url( $home_url ); ?>" title="Visit the site" target="_blank"><?php echo esc_url( $home_url ); ?></a>
                        </p> --><p class="center">Using your own domain name? <strong><br><a href="<?php echo esc_url(get_permalink('11551'));?>">DO THIS NEXT!</a></strong></p>
                            <div class="avia-button-wrap avia-button-center avia-builder-el-0 el_before_av_heading avia-builder-el-first"><a href="/members/<?php echo $user->user_login; ?>/sites" class="avia-button avia-icon_select-no avia-color-theme-color avia-size-small avia-position-center "><span class="avia_iconbox_title">Go to My Sites</span></a></div>
                        </div>
                    </div>
                    <footer class="entry-footer"></footer>
                </article>
            </div>
        </div>
        <div class="flex_cell no_margin av_one_third avia-builder-el-6 el_after_av_cell_one_third avia-builder-el-last" style="vertical-align:top; padding:30px; ">
            <div class="flex_cell_inner"></div>
        </div>
    </div>
	
	<?php
	/**
	 * Fires when the site or user sign-up process is complete.
	 *
	 * @since 3.0.0
	 */
	do_action( 'signup_finished' );
}

/**
 * Setup the new user signup process
 *
 * @since MU
 *
 * @param string          $user_name  The username.
 * @param string          $user_email The user's email.
 * @param WP_Error|string $errors     A WP_Error object containing existing errors. Defaults to empty string.
 */
function signup_user( $user_name = '', $user_email = '', $errors = '' ) {
	global $active_signup;

	if ( !is_wp_error($errors) )
		$errors = new WP_Error();

	$signup_for = isset( $_POST[ 'signup_for' ] ) ? esc_html( $_POST[ 'signup_for' ] ) : 'blog';

	$signup_user_defaults = array(
		'user_name'  => $user_name,
		'user_email' => $user_email,
		'errors'     => $errors,
	);

	/**
	 * Filters the default user variables used on the user sign-up form.
	 *
	 * @since 3.0.0
	 *
	 * @param array $signup_user_defaults {
	 *     An array of default user variables.
	 *
	 *     @type string   $user_name  The user username.
	 *     @type string   $user_email The user email address.
	 *     @type WP_Error $errors     A WP_Error object with possible errors relevant to the sign-up user.
	 * }
	 */
	$filtered_results = apply_filters( 'signup_user_init', $signup_user_defaults );
	$user_name = $filtered_results['user_name'];
	$user_email = $filtered_results['user_email'];
	$errors = $filtered_results['errors'];

	?>

	<h2><?php
		/* translators: %s: name of the network */
		printf( __( 'Get your own %s account in seconds' ), get_current_site()->site_name );
	?></h2>
	<form id="setupform" method="post" action="wp-signup.php" novalidate="novalidate">
		<input type="hidden" name="stage" value="validate-user-signup" />
		<?php
		/** This action is documented in wp-signup.php */
		do_action( 'signup_hidden_fields', 'validate-user' );
		?>
		<?php show_user_form($user_name, $user_email, $errors); ?>

		<p>
		<?php if ( $active_signup == 'blog' ) { ?>
			<input id="signupblog" type="hidden" name="signup_for" value="blog" />
		<?php } elseif ( $active_signup == 'user' ) { ?>
			<input id="signupblog" type="hidden" name="signup_for" value="user" />
		<?php } else { ?>
			<input id="signupblog" type="radio" name="signup_for" value="blog" <?php checked( $signup_for, 'blog' ); ?> />
			<label class="checkbox" for="signupblog"><?php _e('Gimme a site!') ?></label>
			<br />
			<input id="signupuser" type="radio" name="signup_for" value="user" <?php checked( $signup_for, 'user' ); ?> />
			<label class="checkbox" for="signupuser"><?php _e('Just a username, please.') ?></label>
		<?php } ?>
		</p>

		<p class="submit"><input type="submit" name="submit" class="submit" value="<?php esc_attr_e('Next') ?>" /></p>
	</form>
	<?php
}

/**
 * Validate the new user signup
 *
 * @since MU
 *
 * @return bool True if new user signup was validated, false if error
 */
function validate_user_signup() {
	$result = validate_user_form();
	$user_name = $result['user_name'];
	$user_email = $result['user_email'];
	$errors = $result['errors'];

	if ( $errors->get_error_code() ) {
		signup_user($user_name, $user_email, $errors);
		return false;
	}

	if ( 'blog' == $_POST['signup_for'] ) {
		signup_blog($user_name, $user_email);
		return false;
	}

	/** This filter is documented in wp-signup.php */
	wpmu_signup_user( $user_name, $user_email, apply_filters( 'add_signup_meta', array() ) );

	confirm_user_signup($user_name, $user_email);
	return true;
}

/**
 * New user signup confirmation
 *
 * @since MU
 *
 * @param string $user_name The username
 * @param string $user_email The user's email address
 */
function confirm_user_signup($user_name, $user_email) {
	?>
	<h2><?php /* translators: %s: username */
	printf( __( '%s is your new username' ), $user_name) ?></h2>
	<p><?php _e( 'But, before you can start using your new username, <strong>you must activate it</strong>.' ) ?></p>
	<p><?php /* translators: %s: email address */
	printf( __( 'Check your inbox at %s and click the link given.' ), '<strong>' . $user_email . '</strong>' ); ?></p>
	<p><?php _e( 'If you do not activate your username within two days, you will have to sign up again.' ); ?></p>
	<?php
	/** This action is documented in wp-signup.php */
	do_action( 'signup_finished' );
}

/**
 * Setup the new site signup
 *
 * @since MU
 *
 * @param string          $user_name  The username.
 * @param string          $user_email The user's email address.
 * @param string          $blogname   The site name.
 * @param string          $blog_title The site title.
 * @param WP_Error|string $errors     A WP_Error object containing existing errors. Defaults to empty string.
 */
function signup_blog($user_name = '', $user_email = '', $blogname = '', $blog_title = '', $errors = '') {
	if ( !is_wp_error($errors) )
		$errors = new WP_Error();

	$signup_blog_defaults = array(
		'user_name'  => $user_name,
		'user_email' => $user_email,
		'blogname'   => $blogname,
		'blog_title' => $blog_title,
		'errors'     => $errors
	);

	/**
	 * Filters the default site creation variables for the site sign-up form.
	 *
	 * @since 3.0.0
	 *
	 * @param array $signup_blog_defaults {
	 *     An array of default site creation variables.
	 *
	 *     @type string   $user_name  The user username.
	 *     @type string   $user_email The user email address.
	 *     @type string   $blogname   The blogname.
	 *     @type string   $blog_title The title of the site.
	 *     @type WP_Error $errors     A WP_Error object with possible errors relevant to new site creation variables.
	 * }
	 */
	$filtered_results = apply_filters( 'signup_blog_init', $signup_blog_defaults );

	$user_name = $filtered_results['user_name'];
	$user_email = $filtered_results['user_email'];
	$blogname = $filtered_results['blogname'];
	$blog_title = $filtered_results['blog_title'];
	$errors = $filtered_results['errors'];

	if ( empty($blogname) )
		$blogname = $user_name;
	?>
	<form id="setupform" method="post" action="wp-signup.php">
		<input type="hidden" name="stage" value="validate-blog-signup" />
		<input type="hidden" name="user_name" value="<?php echo esc_attr($user_name) ?>" />
		<input type="hidden" name="user_email" value="<?php echo esc_attr($user_email) ?>" />
		<?php
		/** This action is documented in wp-signup.php */
		do_action( 'signup_hidden_fields', 'validate-site' );
		?>
		<?php show_blog_form($blogname, $blog_title, $errors); ?>
		<p class="submit"><input type="submit" name="submit" class="submit" value="<?php esc_attr_e('Signup') ?>" /></p>
	</form>
	<?php
}

/**
 * Validate new site signup
 *
 * @since MU
 *
 * @return bool True if the site signup was validated, false if error
 */
function validate_blog_signup() {
	// Re-validate user info.
	$user_result = wpmu_validate_user_signup( $_POST['user_name'], $_POST['user_email'] );
	$user_name = $user_result['user_name'];
	$user_email = $user_result['user_email'];
	$user_errors = $user_result['errors'];

	if ( $user_errors->get_error_code() ) {
		signup_user( $user_name, $user_email, $user_errors );
		return false;
	}
	echo "BLOG NAME: ".$_POST['blogname']." - BLOG TITLE: ".$_POST['blog_title'];
	exit;
	$result = wpmu_validate_blog_signup( $_POST['blogname'], $_POST['blog_title'] );
	$domain = $result['domain'];
	$path = $result['path'];
	$blogname = $result['blogname'];
	$blog_title = $result['blog_title'];
	$errors = $result['errors'];

	if ( $errors->get_error_code() ) {
		signup_blog($user_name, $user_email, $blogname, $blog_title, $errors);
		return false;
	}

	$public = (int) $_POST['blog_public'];
	$signup_meta = array ('lang_id' => 1, 'public' => $public);

	// Handle the language setting for the new site.
	if ( ! empty( $_POST['WPLANG'] ) ) {

		$languages = signup_get_available_languages();

		if ( in_array( $_POST['WPLANG'], $languages ) ) {
			$language = wp_unslash( sanitize_text_field( $_POST['WPLANG'] ) );

			if ( $language ) {
				$signup_meta['WPLANG'] = $language;
			}
		}

	}

	/** This filter is documented in wp-signup.php */
	$meta = apply_filters( 'add_signup_meta', $signup_meta );

	wpmu_signup_blog($domain, $path, $blog_title, $user_name, $user_email, $meta);
	confirm_blog_signup($domain, $path, $blog_title, $user_name, $user_email, $meta);
	return true;
}

/**
 * New site signup confirmation
 *
 * @since MU
 *
 * @param string $domain The domain URL
 * @param string $path The site root path
 * @param string $blog_title The new site title
 * @param string $user_name The user's username
 * @param string $user_email The user's email address
 * @param array $meta Any additional meta from the {@see 'add_signup_meta'} filter in validate_blog_signup()
 */
function confirm_blog_signup( $domain, $path, $blog_title, $user_name = '', $user_email = '', $meta = array() ) {
	?>
	<h2><?php /* translators: %s: site address */
	printf( __( 'Congratulations! Your new site, %s, is almost ready.' ), "<a href='http://{$domain}{$path}'>{$blog_title}</a>" ) ?></h2>

	<p><?php _e( 'But, before you can start using your site, <strong>you must activate it</strong>.' ) ?></p>
	<p><?php /* translators: %s: email address */
	printf( __( 'Check your inbox at %s and click the link given.' ), '<strong>' . $user_email . '</strong>' ); ?></p>
	<p><?php _e( 'If you do not activate your site within two days, you will have to sign up again.' ); ?></p>
	<h2><?php _e( 'Still waiting for your email?' ); ?></h2>
	<p>
		<?php _e( 'If you haven&#8217;t received your email yet, there are a number of things you can do:' ) ?>
		<ul id="noemail-tips">
			<li><p><strong><?php _e( 'Wait a little longer. Sometimes delivery of email can be delayed by processes outside of our control.' ) ?></strong></p></li>
			<li><p><?php _e( 'Check the junk or spam folder of your email client. Sometime emails wind up there by mistake.' ) ?></p></li>
			<li><?php
				/* translators: %s: email address */
				printf( __( 'Have you entered your email correctly? You have entered %s, if it&#8217;s incorrect, you will not receive your email.' ), $user_email );
			?></li>
		</ul>
	</p>
	<?php
	/** This action is documented in wp-signup.php */
	do_action( 'signup_finished' );
}

/**
 * Retrieves languages available during the site/user signup process.
 *
 * @since 4.4.0
 *
 * @see get_available_languages()
 *
 * @return array List of available languages.
 */
function signup_get_available_languages() {
	/**
	 * Filters the list of available languages for front-end site signups.
	 *
	 * Passing an empty array to this hook will disable output of the setting on the
	 * signup form, and the default language will be used when creating the site.
	 *
	 * Languages not already installed will be stripped.
	 *
	 * @since 4.4.0
	 *
	 * @param array $available_languages Available languages.
	 */
	$languages = (array) apply_filters( 'signup_get_available_languages', get_available_languages() );

	/*
	 * Strip any non-installed languages and return.
	 *
	 * Re-call get_available_languages() here in case a language pack was installed
	 * in a callback hooked to the 'signup_get_available_languages' filter before this point.
	 */
	return array_intersect_assoc( $languages, get_available_languages() );
}

// Main
$active_signup = get_site_option( 'registration', 'none' );

/**
 * Filters the type of site sign-up.
 *
 * @since 3.0.0
 *
 * @param string $active_signup String that returns registration type. The value can be
 *                              'all', 'none', 'blog', or 'user'.
 */
$active_signup = apply_filters( 'wpmu_active_signup', $active_signup );

// Make the signup type translatable.
$i18n_signup['all'] = _x('all', 'Multisite active signup type');
$i18n_signup['none'] = _x('none', 'Multisite active signup type');
$i18n_signup['blog'] = _x('blog', 'Multisite active signup type');
$i18n_signup['user'] = _x('user', 'Multisite active signup type');

if ( is_super_admin() ) {
	/* translators: 1: type of site sign-up; 2: network settings URL */
	echo '<div class="mu_alert">' . sprintf( __( 'Greetings Site Administrator! You are currently allowing &#8220;%s&#8221; registrations. To change or disable registration go to your <a href="%s">Options page</a>.' ), $i18n_signup[$active_signup], esc_url( network_admin_url( 'settings.php' ) ) ) . '</div>';
}

$newblogname = isset($_GET['new']) ? strtolower(preg_replace('/^-|-$|[^-a-zA-Z0-9]/', '', $_GET['new'])) : null;

$current_user = wp_get_current_user();
if ( $active_signup == 'none' ) {
	_e( 'Registration has been disabled.' );
} elseif ( $active_signup == 'blog' && !is_user_logged_in() ) {
	$login_url = wp_login_url( network_site_url( 'wp-signup.php' ) );
	/* translators: %s: login URL */
	printf( __( 'You must first <a href="%s">log in</a>, and then you can create a new site.' ), $login_url );
} else {
	$stage = isset( $_POST['stage'] ) ?  $_POST['stage'] : 'default';
	switch ( $stage ) {
		case 'validate-user-signup' :
			if ( $active_signup == 'all' || $_POST[ 'signup_for' ] == 'blog' && $active_signup == 'blog' || $_POST[ 'signup_for' ] == 'user' && $active_signup == 'user' )
				validate_user_signup();
			else
				_e( 'User registration has been disabled.' );
		break;
		case 'validate-blog-signup':
			if ( $active_signup == 'all' || $active_signup == 'blog' )
				validate_blog_signup();
			else
				_e( 'Site registration has been disabled.' );
			break;
		case 'gimmeanotherblog':
			validate_another_blog_signup();
			break;
		case 'default':
		default :
			$user_email = isset( $_POST[ 'user_email' ] ) ? $_POST[ 'user_email' ] : '';
			/**
			 * Fires when the site sign-up form is sent.
			 *
			 * @since 3.0.0
			 */
			do_action( 'preprocess_signup_form' );
			
			if ( is_user_logged_in() && ( $active_signup == 'all' || $active_signup == 'blog' ) ){
				/* Redirect if user is NOT A MEMBER! - Buddy Quaid */
				global $current_user;
				$current_user->membership_level = pmpro_getMembershipLevelForUser($current_user->ID);

				if( !$current_user->membership_level && !is_super_admin($current_user->ID) ){ // if not a member
					$page = get_page_by_title('no membership');
					wp_redirect(get_permalink($page->ID));
				}else{
					signup_another_blog($newblogname);
				}
			}
			elseif ( ! is_user_logged_in() && ( $active_signup == 'all' || $active_signup == 'user' ) ){
        $page = get_page_by_path('register');
        $message = 'You need to login or your don\'t have an account yet!';
        bp_core_add_message($message, 'error'); // Sends error message to the page.
        wp_redirect(get_permalink($page->ID));
        // signup_user( $newblogname, $user_email );
      }
			elseif ( ! is_user_logged_in() && ( $active_signup == 'blog' ) )
				_e( 'Sorry, new registrations are not allowed at this time.' );
			else
				_e( 'You are logged in already. No need to register again!' );

			if ( $newblogname ) {
				$newblog = get_blogaddress_by_name( $newblogname );

				if ( $active_signup == 'blog' || $active_signup == 'all' )
					/* translators: %s: site address */
					printf( '<p><em>' . __( 'The site you were looking for, %s, does not exist, but you can create it now!' ) . '</em></p>',
						'<strong>' . $newblog . '</strong>'
					);
				else
					/* translators: %s: site address */
					printf( '<p><em>' . __( 'The site you were looking for, %s, does not exist.' ) . '</em></p>',
						'<strong>' . $newblog . '</strong>'
					);
			}
			break;
	}
}
?>
</div>
</div>
</main>
</div>
</div>
<?php
/**
 * Fires after the sign-up forms, before wp_footer.
 *
 * @since 3.0.0
 */
do_action( 'after_signup_form' ); ?>

<?php get_footer( 'wp-signup' );
