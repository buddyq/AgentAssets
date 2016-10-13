<<<<<<< HEAD
<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 * @version   1.0.0
 */
 
if( !defined( 'ABSPATH') ) exit();

if(!class_exists('ThemePunch_Newsletter')) {
	 
	class ThemePunch_Newsletter {
	
		protected static $remote_url	= 'http://newsletter.themepunch.com/';
		protected static $subscribe		= 'subscribe.php';
		protected static $unsubscribe	= 'unsubscribe.php';
		
		public function __construct(){
			
		}
		
		
		/**
		 * Subscribe to the ThemePunch Newsletter
		 * @since: 1.0.0
		 **/
		public static function subscribe($email){
			global $wp_version;
			
			$request = wp_remote_post(self::$remote_url.self::$subscribe, array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'timeout' => 15,
				'body' => array(
					'email' => urlencode($email)
				)
			));
			
			if(!is_wp_error($request)) {
				if($response = json_decode($request['body'], true)) {
					if(is_array($response)) {
						$data = $response;
						
						return $data;
					}else{
						return false;
					}
				}
			}
		}
		
		
		/**
		 * Unsubscribe to the ThemePunch Newsletter
		 * @since: 1.0.0
		 **/
		public static function unsubscribe($email){
			global $wp_version;
			
			$request = wp_remote_post(self::$remote_url.self::$unsubscribe, array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'timeout' => 15,
				'body' => array(
					'email' => urlencode($email)
				)
			));
			
			if(!is_wp_error($request)) {
				if($response = json_decode($request['body'], true)) {
					if(is_array($response)) {
						$data = $response;
						
						return $data;
					}else{
						return false;
					}
				}
			}
		}
		
	}
}

=======
<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2015 ThemePunch
 * @version   1.0.0
 */
 
if( !defined( 'ABSPATH') ) exit();

if(!class_exists('ThemePunch_Newsletter')) {
	 
	class ThemePunch_Newsletter {
	
		protected static $remote_url	= 'http://newsletter.themepunch.com/';
		protected static $subscribe		= 'subscribe.php';
		protected static $unsubscribe	= 'unsubscribe.php';
		
		public function __construct(){
			
		}
		
		
		/**
		 * Subscribe to the ThemePunch Newsletter
		 * @since: 1.0.0
		 **/
		public static function subscribe($email){
			global $wp_version;
			
			$request = wp_remote_post(self::$remote_url.self::$subscribe, array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'timeout' => 15,
				'body' => array(
					'email' => urlencode($email)
				)
			));
			
			if(!is_wp_error($request)) {
				if($response = json_decode($request['body'], true)) {
					if(is_array($response)) {
						$data = $response;
						
						return $data;
					}else{
						return false;
					}
				}
			}
		}
		
		
		/**
		 * Unsubscribe to the ThemePunch Newsletter
		 * @since: 1.0.0
		 **/
		public static function unsubscribe($email){
			global $wp_version;
			
			$request = wp_remote_post(self::$remote_url.self::$unsubscribe, array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'timeout' => 15,
				'body' => array(
					'email' => urlencode($email)
				)
			));
			
			if(!is_wp_error($request)) {
				if($response = json_decode($request['body'], true)) {
					if(is_array($response)) {
						$data = $response;
						
						return $data;
					}else{
						return false;
					}
				}
			}
		}
		
	}
}

>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
?>