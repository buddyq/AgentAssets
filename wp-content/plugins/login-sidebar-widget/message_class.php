<<<<<<< HEAD
<?php
if(!class_exists('login_message_class')){
	class login_message_class {
		function __construct(){
			if(!session_id()){
				@session_start();
			}
		}
		
		function show_message(){
			if(isset($_SESSION['login_message_class']) and $_SESSION['login_message_msg']){
				echo '<p class="'.$_SESSION['login_message_class'].'">'.$_SESSION['login_message_msg'].'</p>';
				unset($_SESSION['login_message_msg']);
				unset($_SESSION['login_message_class']);
			}
		}
		
		function add_message($msg = '', $class = ''){
			$_SESSION['login_message_msg'] = $msg;
			$_SESSION['login_message_class'] = $class;		
		}
	}
=======
<?php
if(!class_exists('login_message_class')){
	class login_message_class {
		function __construct(){
			if(!session_id()){
				@session_start();
			}
		}
		
		function show_message(){
			if(isset($_SESSION['login_message_class']) and $_SESSION['login_message_msg']){
				echo '<p class="'.$_SESSION['login_message_class'].'">'.$_SESSION['login_message_msg'].'</p>';
				unset($_SESSION['login_message_msg']);
				unset($_SESSION['login_message_class']);
			}
		}
		
		function add_message($msg = '', $class = ''){
			$_SESSION['login_message_msg'] = $msg;
			$_SESSION['login_message_class'] = $class;		
		}
	}
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
}