<?php

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class PBrx_Slick_Slider {

	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'slick_slider_scripts' ) );

		add_shortcode( 'slick-slider-shortcode', array( __CLASS__, 'slick_slider_shortcode' ) );

	}


	public static function slick_slider_scripts() {
		wp_enqueue_style( 'slick-slider', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css' );
		wp_enqueue_style( 'slick-theme', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css' );
		wp_enqueue_script( 'slick-slider', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array( 'jquery' ), false, true );

		wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/inc/css/slick.css' );
		wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/inc/js/slick.js', array( 'jquery' ), false, true );

	}


	/**
	 * Adds Settings admin menu page via ACF
	 **/
	public static function slick_slider_shortcode() {
		?>
		<div class="container">
			<div id="slick">
			<?php $gallery_images = get_theme_mod( 'customizer_image_gallery' );
				 // $gallery_images = array( '0' => '28', '1' => '4', '2' => '5' );

			foreach( $gallery_images as $key=>$mod ) {
			 ?>
				<div>
				<?php  ?>
					<div class="img--holder" style="background-image: url('<?php echo wp_get_attachment_url( $mod ); ?>');"></div>
				</div>
				<?php } ?>
			</div><!-- /#slick -->
		</div><?php
	}

	/**
	 * Adds Settings admin menu page via ACF
	 **/
	public static function slick_slider_demo_shortcode() {
		?>
		<div class="container">
			<div id="slick">
				<div>
					<div class="img--holder" style="background-image: url(http://images.unsplash.com/photo-1449023859676-22e61b0c0695?dpr=1&auto=format&fit=crop&w=767&h=431&q=80&cs=tinysrgb&crop=&bg=);"></div>
				</div>
				<div>
					<div class="img--holder" style="background-image: url(http://images.unsplash.com/photo-1481873098652-b87c7a2fd98c?dpr=1&auto=format&fit=crop&w=767&h=511&q=80&cs=tinysrgb&crop=&bg=);"></div>
				</div>
				<div>
					<div class="img--holder" style="background-image: url(http://images.unsplash.com/photo-1487241281672-301e0f542588?dpr=1&auto=format&fit=crop&w=767&h=511&q=80&cs=tinysrgb&crop=&bg=);"></div>
				</div>
			</div><!-- /#slick -->
		</div><?php
	}
}

PBrx_Slick_Slider::init();
