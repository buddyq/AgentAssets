<?php

add_action('customize_register','agentassets_theme_customize', 99);

add_action('customize_register', 'agentassets_customize_remove_system_sections', 99);
add_action('customize_preview_init', 'agentassets_customize_remove_system_sections', 99);

/**
 * @param $wp_c WP_Customize_Manager
 */

function agentassets_customize_remove_system_sections($wp_c) {
    $model = ThemeSettingsModel::model();
    $blogOwner = OrderMap::getBlogOwner(get_current_blog_id());

    if (!$model->currentThemeIsPrivate() && $blogOwner != 1 && $blogOwner != null) {
        //$wp_c->remove_section('nav');
        $wp_c->remove_section('static_front_page');

        $wp_c->remove_panel('nav_menus');
        $wp_c->remove_panel('widgets');
        //$wp_c->remove_section('themes');
        //$wp_c->remove_section('title_tagline');
    }
}

/**
 * @param $wp_c WP_Customize_Manager
 */

function agentassets_theme_customize($wp_c) {
    $model = ThemeSettingsModel::model();

    //$wp_c->remove_section('static_front_page');

    $blogOwner = OrderMap::getBlogOwner(get_current_blog_id());
    if ( !$model->currentThemeIsPrivate()  || ($blogOwner == 1 || $blogOwner == null)) {
        $wp_c->add_section('header', array('title' => 'Header'));
        $wp_c->add_section('typography', array('title' => 'Typography'));
        //$wp_c->add_section('styling', array('title' => 'Styling'));
    }

    /*if ($blogOwner == 1 || $blogOwner == null) {
        $wp_c->add_section('styling', array('title' => 'Styling'));
    }*/

    if (!$model->currentThemeIsPrivate()) {
        $wp_c->add_section('styling', array('title' => 'Styling'));
    }

    foreach($model->attributesMetadata() as $id => $attributeData) {
        $config = array(
            'transport' => 'refresh',
        );

        if (isset($attributeData['default'])) {
            $config['default'] = $attributeData['default'];
        }
        $wp_c->add_setting( $id , $config);

        if (class_exists($attributeData['type'])) {
            $controllClass = $attributeData['type'];
            $wp_c->add_control( new $controllClass( $wp_c, $id, array(
                'label'        => $attributeData['label'],
                'section'    => $attributeData['section'],
                'settings'   => $id,
            )));
        } else {
            $controlConfig = array(
                'label'    => $attributeData['label'],
                'section'  => $attributeData['section'],
                'settings' => $id,
                'type'     => $attributeData['type'],
            );
            switch ($attributeData['type']) {
                case 'text':
                    break;
                case 'number':
                    break;
                case 'select':
                    $controlConfig['choices'] = $attributeData['options'];
                    break;
                case 'radio':
                    $controlConfig['choices'] = $attributeData['options'];
                    break;
            }

            $wp_c->add_control($id, $controlConfig);
        }
    }
}
