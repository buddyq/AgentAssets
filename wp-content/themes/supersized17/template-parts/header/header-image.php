<?php
/**
 * Displays header media
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="custom-header">

	<div class="custom-header-media">
		<?php
		if ( is_front_page() ) {
			echo do_shortcode( '[slick-slider-shortcode]' );
			// echo do_shortcode( '[customizer-image-gallery]' );
		} else {
			the_custom_header_markup();
		}
	?>
	</div>

	<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

</div><!-- .custom-header -->
