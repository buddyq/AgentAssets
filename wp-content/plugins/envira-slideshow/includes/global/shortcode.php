<?php
/**
 * Shortcode class.
 *
 * @since 1.0.8
 *
 * @package Envira_Slideshow
 * @author  Tim Carr
 */
class Envira_Slideshow_Shortcode {

    /**
     * Holds the class object.
     *
     * @since 1.0.8
     *
     * @var object
     */
    public static $instance;

    /**
     * Path to the file.
     *
     * @since 1.0.8
     *
     * @var string
     */
    public $file = __FILE__;

    /**
     * Primary class constructor.
     *
     * @since 1.0.8
     */
    public function __construct() {
        
        // Gallery
        add_action( 'envira_gallery_api_config', array( $this, 'gallery_output' ) );
        add_filter( 'envira_gallery_toolbar_after_prev', array( $this, 'gallery_toolbar_button' ), 10, 2 );

        // Album
        add_action( 'envira_albums_api_config', array( $this, 'album_output' ) );
        add_filter( 'envira_albums_toolbar_after_prev', array( $this, 'album_toolbar_button' ), 10, 2 );

        add_filter( 'envirabox_actions', array( $this, 'envirabox_actions' ), 90, 2 );
        add_filter( 'envira_always_show_title', array( $this, 'envira_always_show_title' ), 10, 2 );

    }

    /**
     * Outputs the slideshow settings for a gallery.
     *
     * @since 1.0.8
     *
     * @param array $data Data for the Envira gallery.
     * @return null       Return early if the slideshow is not enabled.
     */
    public function gallery_output( $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'slideshow', $data ) ) {
            return;
        }

        // Output the slideshow init code.
        echo 'autoPlay:' . Envira_Gallery_Shortcode::get_instance()->get_config( 'autoplay', $data ) . ',';
        echo 'playSpeed:' . Envira_Gallery_Shortcode::get_instance()->get_config( 'ss_speed', $data ) . ',';

    }

    /**
     * Outputs the slideshow settings for an album.
     *
     * @since 1.0.8
     *
     * @param array $data Data for the Envira Album.
     * @return null       Return early if the slideshow is not enabled.
     */
    public function album_output( $data ) {

        $instance = Envira_Albums_Shortcode::get_instance();

        if ( ! $instance->get_config( 'slideshow', $data ) ) {
            return;
        }

        // Output the slideshow init code.
        echo 'autoPlay:' . $instance->get_config( 'autoplay', $data ) . ',';
        echo 'playSpeed:' . $instance->get_config( 'ss_speed', $data ) . ',';

    }

    /**
     * Outputs the slideshow button in the gallery toolbar.
     *
     * @since 1.0.8
     *
     * @param string $template  The template HTML for the gallery toolbar.
     * @param array $data       Data for the Envira gallery.
     * @return string $template Amended template HTML for the gallery toolbar.
     */
    public function gallery_toolbar_button( $template, $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'slideshow', $data ) ) {
            return $template;
        }

        // Create the slideshow button.
        $button = '<li><a class="btnPlay" title="' . __( 'Start Slideshow', 'envira-slideshow' ) . '" href="javascript:;"></a></li>';

        // Return with the button appended to the template.
        return $template . $button;

    }

    public function envirabox_actions( $template, $data ) {

        // Check if Download Button output is enabled
        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'slideshow', $data ) || ( ! in_array( Envira_Gallery_Shortcode::get_instance()->get_config( 'lightbox_theme', $data ), array( 'base_light', 'base_dark', 'space_dark', 'space_light', 'box_dark', 'box_light', 'burnt_dark', 'burnt_light', 'modern-dark', 'modern-light' ) ) ) ) {
            return $template;
        }

        // Build Button
        $button = '<div class="envirabox-slideshow-button"><a href="javascript:;" class="btnPlay" title="' . __( 'Start Slideshow', 'envira-slideshow' ) . '"></a></div>';

        return $template . $button;
    }

    public function envira_always_show_title( $show, $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'slideshow', $data ) || ( ! in_array( Envira_Gallery_Shortcode::get_instance()->get_config( 'lightbox_theme', $data ), array( 'base_dark', 'base_light' ) ) ) ) {
            return $show;
        }

        return true;
    }

    /**
     * Outputs the slideshow button in the album toolbar.
     *
     * @since 1.0.4
     *
     * @param string $template  The template HTML for the album toolbar.
     * @param array $data       Data for the Envira album.
     * @return string $template Amended template HTML for the album toolbar.
     */
    public function album_toolbar_button( $template, $data ) {

        if ( ! Envira_Albums_Shortcode::get_instance()->get_config( 'slideshow', $data ) ) {
            return $template;
        }

        // Create the slideshow button.
        $button = '<li><a class="btnPlay" title="' . __( 'Start Slideshow', 'envira-slideshow' ) . '" href="javascript:;"></a></li>';

        // Return with the button appended to the template.
        return $template . $button;

    }

    /**
     * Returns the singleton instance of the class.
     *
     * @since 1.0.8
     *
     * @return object The Envira_Slideshow_Shortcode object.
     */
    public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Envira_Slideshow_Shortcode ) ) {
            self::$instance = new Envira_Slideshow_Shortcode();
        }

        return self::$instance;

    }

}

// Load the shortcode class.
$envira_slideshow_shortcode = Envira_Slideshow_Shortcode::get_instance();