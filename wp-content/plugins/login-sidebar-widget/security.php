<<<<<<< HEAD
<<<<<<< HEAD
<?php

if(!class_exists('login_widget_admin_security')){
	class login_widget_admin_security {
		
		function __construct(){
			$captcha_on_admin_login = (get_option('captcha_on_admin_login') == 'Yes'?true:false);
			if($captcha_on_admin_login){
				add_action( 'login_form', array( $this, 'security_add' ) );
				add_filter( 'authenticate', array( $this, 'myplugin_auth_signon'), 30, 3 );
			}
			
			$captcha_on_user_login = (get_option('captcha_on_user_login') == 'Yes'?true:false);
			if($captcha_on_user_login){
				add_action( 'login_afo_form', array( $this, 'security_add_user' ) );
			}
		}
		
		function security_add(){
			echo '<p><img src="'.plugin_dir_url( __FILE__ ).'/captcha/captcha.php" alt="code"></p>
			<p>
				<label for="captcha">'.__('Captcha','login-sidebar-widget').'<br>
				<input type="text" name="admin_captcha" id="admin_captcha" class="input" value="" size="20" autocomplete="off"></label>
			</p>';
		}
	
		function myplugin_auth_signon( $user, $username, $password ) {
			if(!session_id()){
				@session_start();
			}
			
			if( isset($_POST['admin_captcha']) and $_POST['admin_captcha'] != $_SESSION['captcha_code'] ){
				return new WP_Error( 'error', __( "Security code do not match.", "my_textdomain" ) );
			} else {
				return $user;
			}
		}
		
		
		function security_add_user(){
			
		echo '<div class="form-group">
			<label for="captcha">'.__('Captcha','login-sidebar-widget').' </label>
			<img src="'.plugin_dir_url( __FILE__ ).'/captcha/captcha.php" alt="code">
			<input type="text" name="user_captcha" id="user_captcha" autocomplete="off"/>
		</div>';
		}
	}
}

if(!function_exists('security_init')){
	function security_init(){
		new login_widget_admin_security;
	}
}

=======
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
<?php

if(!class_exists('login_widget_admin_security')){
	class login_widget_admin_security {
		
		function __construct(){
			$captcha_on_admin_login = (get_option('captcha_on_admin_login') == 'Yes'?true:false);
			if($captcha_on_admin_login){
				add_action( 'login_form', array( $this, 'security_add' ) );
				add_filter( 'authenticate', array( $this, 'myplugin_auth_signon'), 30, 3 );
			}
			
			$captcha_on_user_login = (get_option('captcha_on_user_login') == 'Yes'?true:false);
			if($captcha_on_user_login){
				add_action( 'login_afo_form', array( $this, 'security_add_user' ) );
			}
		}
		
		function security_add(){
			echo '<p><img src="'.plugin_dir_url( __FILE__ ).'/captcha/captcha.php" alt="code"></p>
			<p>
				<label for="captcha">'.__('Captcha','login-sidebar-widget').'<br>
				<input type="text" name="admin_captcha" id="admin_captcha" class="input" value="" size="20" autocomplete="off"></label>
			</p>';
		}
	
		function myplugin_auth_signon( $user, $username, $password ) {
			if(!session_id()){
				@session_start();
			}
			
			if( isset($_POST['admin_captcha']) and $_POST['admin_captcha'] != $_SESSION['captcha_code'] ){
				return new WP_Error( 'error', __( "Security code do not match.", "my_textdomain" ) );
			} else {
				return $user;
			}
		}
		
		
		function security_add_user(){
			
		echo '<div class="form-group">
			<label for="captcha">'.__('Captcha','login-sidebar-widget').' </label>
			<img src="'.plugin_dir_url( __FILE__ ).'/captcha/captcha.php" alt="code">
			<input type="text" name="user_captcha" id="user_captcha" autocomplete="off"/>
		</div>';
		}
	}
}

if(!function_exists('security_init')){
	function security_init(){
		new login_widget_admin_security;
	}
}

<<<<<<< HEAD
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
security_init();