<?php
new Custom_Theme_Customizer();

class Custom_Theme_Customizer {
    public function __construct() {
        add_action( 'customize_register', array( &$this, 'customizer_manager' ) );
    }


    /**
     * Customizer manager demo
     * @param  WP_Customizer_Manager $wp_manager
     * @return void
     */
    public function customizer_manager( $wp_manager ) {
        $this->demo_section( $wp_manager );
        $this->custom_sections( $wp_manager );
    }

    /**
     * A section to show how you use the default customizer controls in WordPress
     *
     * @param  Obj $wp_manager - WP Manager
     *
     * @return Void
     */
    private function demo_section( $wp_manager ) {
        $wp_manager->add_section( 'realtor_data_section', array(
            'title'          => 'Property Details',
            'priority'       => 35,
        ) );

        // Textbox control
        $wp_manager->add_setting( 'textbox_setting', array(
            'default'        => 'Value',
        ) );

        $wp_manager->add_control( 'textbox_setting', array(
            'label'   => 'Text Setting',
            'section' => 'realtor_data_section',
            'type'    => 'text',
            'priority' => 1,
        ) );

        // Checkbox control
        $wp_manager->add_setting( 'checkbox_setting', array(
            'default'        => '1',
        ) );

        $wp_manager->add_control( 'checkbox_setting', array(
            'label'   => 'Checkbox Setting',
            'section' => 'realtor_data_section',
            'type'    => 'checkbox',
            'priority' => 2,
        ) );
        // WP_Customize_Upload_Control
        $wp_manager->add_setting( 'aa_printable_info1',
            array(
                'default'        => '',
            )
        );

        $wp_manager->add_control(
            new WP_Customize_Upload_Control( $wp_manager, 'aa_printable_info1',
                array(
                    'label'   => 'Printable Flyer',
                    'section' => 'realtor_data_section',
                    'settings'   => 'aa_printable_info1',
                    'priority' => 7,
                )
            )
        );

        // Checkbox control
        $wp_manager->add_setting( 'checkbox_setting',
            array(
                'realtor'        => '1',
            )
        );

        $wp_manager->add_control( 'checkbox_setting',
            array(
                'label'   => 'Checkbox Setting',
                'section' => 'realtor_data_section',
                'type'    => 'checkbox',
                'priority' => 12,
            )
        );

        // Radio control
        $wp_manager->add_setting( 'radio_setting',
            array(
                'default'        => '1',
            )
        );

        $wp_manager->add_control( 'radio_setting',
            array(
                'label'   => 'Radio Setting',
                'section' => 'realtor_data_section',
                'type'    => 'radio',
                'choices' => array( '1', '2', '3', '4', '5' ),
                'priority' => 13,
            )
        );

        // Radio control
        $wp_manager->add_setting( 'radio_setting', array(
            'default'        => '1',
        ) );

        $wp_manager->add_control( 'radio_setting', array(
            'label'   => 'Radio Setting',
            'section' => 'realtor_data_section',
            'type'    => 'radio',
            'choices' => array( '1', '2', '3', '4', '5' ),
            'priority' => 3,
        ) );

        // Select control
        $wp_manager->add_setting( 'select_setting', array(
            'default'        => '1',
        ) );

        $wp_manager->add_control( 'select_setting', array(
            'label'   => 'Select Dropdown Setting',
            'section' => 'realtor_data_section',
            'type'    => 'select',
            'choices' => array( '1', '2', '3', '4', '5' ),
            'priority' => 4,
        ) );

        // Dropdown pages control
        $wp_manager->add_setting( 'dropdown_pages_setting', array(
            'default'        => '1',
        ) );

        $wp_manager->add_control( 'dropdown_pages_setting', array(
            'label'   => 'Dropdown Pages Setting',
            'section' => 'realtor_data_section',
            'type'    => 'dropdown-pages',
            'priority' => 5,
        ) );

        // Color control
        $wp_manager->add_setting( 'color_setting', array(
            'default'        => '#000000',
        ) );

        $wp_manager->add_control( new WP_Customize_Color_Control( $wp_manager, 'color_setting', array(
            'label'   => 'Color Setting',
            'section' => 'realtor_data_section',
            'settings'   => 'color_setting',
            'priority' => 6,
        ) ) );

        // WP_Customize_Upload_Control
        $wp_manager->add_setting( 'upload_setting', array(
            'default'        => '',
        ) );

        $wp_manager->add_control( new WP_Customize_Upload_Control( $wp_manager, 'upload_setting', array(
            'label'   => 'Upload Setting',
            'section' => 'realtor_data_section',
            'settings'   => 'upload_setting',
            'priority' => 7,
        ) ) );

        // WP_Customize_Image_Control
        $wp_manager->add_setting( 'image_setting', array(
            'default'        => '',
        ) );

        $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'image_setting', array(
            'label'   => 'Image Setting',
            'section' => 'realtor_data_section',
            'settings'   => 'image_setting',
            'priority' => 8,
        ) ) );

        // WP_Customize_Background_Image_Control
        $wp_manager->add_setting( 'background_image_setting', array(
            'default'        => '',
        ) );

        $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'background_image_setting', array(
            'label'   => 'Background Image Setting',
            'section' => 'realtor_data_section',
            'settings'   => 'background_image_setting',
            'priority' => 9,
        ) ) );

        // WP_Customize_Background_Image_Control
        $wp_manager->add_setting( 'background_image_setting', array(
            'default'        => '',
        ) );

        $wp_manager->add_control( new WP_Customize_Background_Image_Control( $wp_manager, 'background_image_setting', array(
            'label'   => 'Background Image Setting',
            'section' => 'realtor_data_section',
            'settings'   => 'background_image_setting',
            'priority' => 9,
        ) ) );
    }

    /**
     * Adds a new section to use custom controls in the WordPress customiser
     *
     * @param  Obj $wp_manager - WP Manager
     *
     * @return Void
     */
    private function custom_sections( $wp_manager ) {
        $wp_manager->add_section( 'realtor_description_section', array(
            'title'          => 'Property Description',
            'priority'       => 36,
        ) );

        // Add A Date Picker
        require_once dirname( __FILE__ ) . '/date/date-picker-custom-control.php';
        $wp_manager->add_setting( 'date_picker_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Date_Picker_Custom_Control( $wp_manager, 'date_picker_setting', array(
            'label'   => 'Date Picker Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'date_picker_setting',
            'priority' => 1,
        ) ) );

        // Add A Layout Picker
        require_once dirname( __FILE__ ) . '/layout/layout-picker-custom-control.php';
        $wp_manager->add_setting( 'layout_picker_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Layout_Picker_Custom_Control( $wp_manager, 'layout_picker_setting', array(
            'label'   => 'Layout Picker Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'layout_picker_setting',
            'priority' => 2,
        ) ) );

        // Add a category dropdown control
        require_once dirname( __FILE__ ) . '/select/category-dropdown-custom-control.php';
        $wp_manager->add_setting( 'category_dropdown_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Category_Dropdown_Custom_Control( $wp_manager, 'category_dropdown_setting', array(
            'label'   => 'Category Dropdown Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'category_dropdown_setting',
            'priority' => 3,
        ) ) );

        // Add a menu dropdown control
        require_once dirname( __FILE__ ) . '/select/menu-dropdown-custom-control.php';
        $wp_manager->add_setting( 'menu_dropdown_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Menu_Dropdown_Custom_Control( $wp_manager, 'menu_dropdown_setting', array(
            'label'   => 'Menu Dropdown Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'menu_dropdown_setting',
            'priority' => 4,
        ) ) );

        // Add a post dropdown control
        require_once dirname( __FILE__ ) . '/select/post-dropdown-custom-control.php';
        $wp_manager->add_setting( 'post_dropdown_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Post_Dropdown_Custom_Control( $wp_manager, 'post_dropdown_setting', array(
            'label'   => 'Post Dropdown Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'post_dropdown_setting',
            'priority' => 5,
        ) ) );

        // Add a post type dropdown control
        require_once dirname( __FILE__ ) . '/select/post-type-dropdown-custom-control.php';
        $wp_manager->add_setting( 'post_type_dropdown_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Post_Type_Dropdown_Custom_Control( $wp_manager, 'post_type_dropdown_setting', array(
            'label'   => 'Post Type Dropdown Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'post_type_dropdown_setting',
            'priority' => 6,
        ) ) );

        // Add a tags dropdown control
        require_once dirname( __FILE__ ) . '/select/tags-dropdown-custom-control.php';
        $wp_manager->add_setting( 'tags_dropdown_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Tags_Dropdown_Custom_Control( $wp_manager, 'tags_dropdown_setting', array(
            'label'   => 'Tags Dropdown Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'tags_dropdown_setting',
            'priority' => 7,
        ) ) );

        // Add a taxonomy dropdown control
        require_once dirname( __FILE__ ) . '/select/taxonomy-dropdown-custom-control.php';
        $wp_manager->add_setting( 'taxonomy_dropdown_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Taxonomy_Dropdown_Custom_Control( $wp_manager, 'taxonomy_dropdown_setting', array(
            'label'   => 'Taxonomy Dropdown Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'taxonomy_dropdown_setting',
            'priority' => 8,
        ) ) );

        // Add a user dropdown control
        require_once dirname( __FILE__ ) . '/select/user-dropdown-custom-control.php';
        $wp_manager->add_setting( 'user_dropdown_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new User_Dropdown_Custom_Control( $wp_manager, 'user_dropdown_setting', array(
            'label'   => 'User Dropdown Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'user_dropdown_setting',
            'priority' => 9,
        ) ) );

        // Add a textarea control
        require_once dirname( __FILE__ ) . '/text/textarea-custom-control.php';
        $wp_manager->add_setting( 'textarea_text_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Textarea_Custom_Control( $wp_manager, 'textarea_text_setting', array(
            'label'   => 'Textarea Text Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'textarea_text_setting',
            'priority' => 10,
        ) ) );

        // Add a text editor control
        require_once dirname( __FILE__ ) . '/text/text-editor-custom-control.php';
        $wp_manager->add_setting( 'text_editor_setting', array(
            'default'        => '',
        ) );
        $wp_manager->add_control( new Text_Editor_Custom_Control( $wp_manager, 'text_editor_setting', array(
            'label'   => 'Text Editor Setting',
            'section' => 'realtor_description_section',
            'settings'   => 'text_editor_setting',
            'priority' => 11,
        ) ) );

        // Add a Google Font control
        // require_once dirname( __FILE__ ) . '/select/google-font-dropdown-custom-control.php';
        // $wp_manager->add_setting( 'google_font_setting', array(
        //     'default'        => '',
        // ) );
        // $wp_manager->add_control( new Google_Font_Dropdown_Custom_Control( $wp_manager, 'google_font_setting', array(
        //     'label'   => 'Google Font Setting',
        //     'section' => 'realtor_description_section',
        //     'settings'   => 'google_font_setting',
        //     'priority' => 12
        // ) ) );
    }
}
