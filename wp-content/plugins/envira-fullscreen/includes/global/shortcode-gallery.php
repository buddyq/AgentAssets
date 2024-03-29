<?php
/**
 * Gallery Shortcode class.
 *
 * @since 1.0.4
 *
 * @package Envira_Fullscreen
 * @author  Tim Carr
 */
class Envira_Fullscreen_Shortcode_Gallery {

    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;

    /**
     * Path to the file.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $file = __FILE__;

     /**
     * Holds the base class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public $base;

    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Load the base class object.
        $this->base = Envira_Fullscreen::get_instance();

        // Actions and Filters
        add_action( 'envira_gallery_before_output', array( $this, 'scripts' ) );
        add_action( 'envira_gallery_api_lightbox', array( $this, 'init' ) );
        add_action( 'envira_gallery_api_before_show', array( $this, 'remove_fullscreen' ) );
        add_action( 'envira_gallery_api_after_close', array( $this, 'close' ) );
        add_filter( 'envira_gallery_toolbar_after_next', array( $this, 'toolbar_button' ), 10, 2 );
        add_filter( 'envirabox_actions', array( $this, 'envirabox_actions' ), 100, 2 );
        add_filter( 'envira_always_show_title', array( $this, 'envira_always_show_title' ), 10, 2 );
    
    }

    /**
     * Registers and enqueues the fullscreen script.
     *
     * @since 1.0.0
     *
     * @param array $data Data for the Envira gallery.
     * @return null       Return early if fullscreen is not enabled.
     */
    public function scripts( $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'fullscreen', $data ) ) {
            return;
        }

        wp_register_script( 'envira-fullscreen', plugins_url( 'assets/js/min/fullscreen-min.js', $this->base->file ), array( 'jquery' ), $this->base->version, true );
        wp_enqueue_script( 'envira-fullscreen' );

    }

    /**
     * Outputs the fullscreen control for the gallery lightbox.
     *
     * @since 1.0.0
     *
     * @param array $data Data for the Envira gallery.
     * @return null       Return early if fullscreen is not enabled.
     */
    public function init( $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'fullscreen', $data ) ) {
            return;
        }

        // Output the fullscreen the controller.
        ?>
        if ( null === $(document).fullScreen() ) { 
            $(".btnFullscreen").addClass("btnDisabled"); 
        } else { 
            $(document).on("click", ".btnFullscreen:not(.btnFullscreenOn)", function(e){
                e.preventDefault(); 
                $(".btnFullscreen").addClass("btnFullscreenOn"); 
                $(document).fullScreen(true);
            }); 

            $(document).on("click", ".btnFullscreenOn, .btnClose, .envirabox-close", function(e){
                e.preventDefault(); 
                $(".btnFullscreen").removeClass("btnFullscreenOn"); 
                $(document).fullScreen(false);
            }); 
        }
        <?php

    }

    public function remove_fullscreen( $data ) {
        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'fullscreen', $data ) ) {
            return;
        }

        ?>
        if ( null === $(document).fullScreen() ) { 
            $(".btnFullscreen").parent().remove(); 
        }
        <?php
    }

    /**
     * Closes fullscreen mode.
     *
     * @since 1.0.0
     *
     * @param array $data Data for the Envira gallery.
     * @return null       Return early if fullscreen is not enabled.
     */
    public function close( $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'fullscreen', $data ) ) {
            return;
        }

        // Output the fullscreen the controller.
        echo '$(document).fullScreen(false); $(".btnFullscreen").removeClass("btnFullscreenOn");';

    }

    /**
     * Outputs the fullscreen button in the gallery toolbar.
     *
     * @since 1.0.0
     *
     * @param string $template  The template HTML for the gallery toolbar.
     * @param array $data       Data for the Envira gallery.
     * @return string $template Amended template HTML for the gallery toolbar.
     */
    public function toolbar_button( $template, $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'fullscreen', $data ) ) {
            return $template;
        }

        // Create the fullscreen button.
        $button = '<li><a class="btnFullscreen" title="' . __( 'Toggle Fullscreen', 'envira-fullscreen' ) . '" href="javascript:;"></a></li>';

        // Return with the button appended to the template.
        return $template . $button;

    }

    public function envirabox_actions( $template, $data ) {

        // Check if Download Button output is enabled
        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'fullscreen', $data ) || ( ! in_array( Envira_Gallery_Shortcode::get_instance()->get_config( 'lightbox_theme', $data ), array( 'base_dark', 'base_light', 'space_dark', 'space_light', 'box_dark', 'box_light', 'burnt_dark', 'burnt_light' ) ) ) ) {
            return $template;
        }

        return $this->base_template_button( $template, $data );
    }

    public function envira_always_show_title( $show, $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'fullscreen', $data ) || ( ! in_array( Envira_Gallery_Shortcode::get_instance()->get_config( 'lightbox_theme', $data ), array( 'base_dark', 'base_light' ) ) ) ) {
            return $show;
        }

        return true;
    }

    /**
     * Outputs the fullscreen button in the gallery toolbar.
     *
     * @since 1.0.0
     *
     * @param string $template  The template HTML for the gallery toolbar.
     * @param array $data       Data for the Envira gallery.
     * @return string $template Amended template HTML for the gallery toolbar.
     */
    public function base_template_button( $template, $data ) {

        if ( ! Envira_Gallery_Shortcode::get_instance()->get_config( 'fullscreen', $data ) ) {
            return $template;
        }

        // Create the fullscreen button.
        $button = '<div class="envira-fullscreen-button"><a class="btnFullscreen" title="' . __( 'Toggle Fullscreen', 'envira-fullscreen' ) . '" href="javascript:;"></a></div>';

        // Return with the button appended to the template.
        return $template . $button;

    }

    /**
     * Returns the singleton instance of the class.
     *
     * @since 1.0.0
     *
     * @return object The Envira_Fullscreen_Shortcode_Gallery object.
     */
    public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Envira_Fullscreen_Shortcode_Gallery ) ) {
            self::$instance = new Envira_Fullscreen_Shortcode_Gallery();
        }

        return self::$instance;

    }

}

// Load the shortcode class.
$envira_fullscreen_shortcode_gallery = Envira_Fullscreen_Shortcode_Gallery::get_instance();