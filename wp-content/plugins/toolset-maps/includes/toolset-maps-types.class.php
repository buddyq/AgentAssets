<?php

/**
* Toolset Maps - Types field GUI
*
* @package ToolsetMaps
*
* @since 0.1
*/

// This file can be included during AJAX call. In such case we must obtain the file with the parent class manually.
if( !class_exists( 'FieldFactory' ) ) {
	$tcl_bootstrap = Toolset_Common_Bootstrap::getInstance();
	$tcl_bootstrap->register_toolset_forms();

	require_once WPTOOLSET_FORMS_ABSPATH . '/classes/class.field_factory.php';
}

class WPToolset_Field_google_address extends FieldFactory {

    public function metaform() {
        $attributes =  $this->getAttr();
        $attributes['placeholder'] = __('Enter address', 'toolset-maps');
        if ( ! isset( $attributes['class'] ) ) {
            $attributes['class'] = '';
        }
        if ( ! empty($attributes['class'])) {
            $attributes['class'] .= ' ';
        }
        $attributes['class'] .= 'toolset-google-map js-toolset-google-map';
		
		if ( ! isset( $attributes['data-coordinates'] ) ) {
            $attributes['data-coordinates'] = '';
        }
		
		$value = $this->getValue();
		
		if ( ! empty( $value ) ) {
			$has_coordinates = Toolset_Addon_Maps_Common::get_coordinates( $value );
			if ( is_array( $has_coordinates ) ) {
				$attributes['data-coordinates'] = '{' . esc_attr( $has_coordinates['lat'] ) . ',' . esc_attr( $has_coordinates['lon'] ) . '}';
			}
		}
		
		$wpml_action = $this->getWPMLAction();
		
		$before = '<div class="toolset-google-map-container js-toolset-google-map-container">';
		$before .= '<div class="toolset-google-map-inputs-container js-toolset-google-map-inputs-container">';
		if ( $this->isRepetitive() ) {
			$before .= '<span class="toolset-google-map-label">' . __('Address', 'toolset-maps') . '</span>';
			$attributes['style'] = 'max-width:80%';
		}

        $metaform = array();
        $metaform[] = array(
            '#type'			=> 'textfield',
			'#before'		=> $before,
			'#after'		=> '</div></div>',
            '#description'	=> $this->getDescription(),
            '#name'			=> $this->getName(),
            '#value'		=> $value,
            '#validate'		=> $this->getValidationData(),
            '#repetitive'	=> $this->isRepetitive(),
            '#attributes'	=> $attributes,
            '#title'		=> $this->getTitle(),
			'wpml_action'	=> $wpml_action,
        );
        return $metaform;
    }

    public function enqueueScripts() {
        wp_enqueue_script('toolset-google-map-editor-script');
    }

}
