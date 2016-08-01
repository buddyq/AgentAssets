<?php

/*
 * Settings API
 */



add_action( 'admin_menu', 'mism_add_admin_menu' );
add_action( 'admin_init', 'mism_settings_init' );


function mism_add_admin_menu(  ) { 
	add_submenu_page( 'edit.php?post_type=package', 'Settings', 'Settings', 'manage_options', 'package_settings', 'package_settings_page' );
}


function mism_settings_init(  ) { 

	register_setting( 'mismSettings', 'mism_package_settings' );

        #   General Settings
	add_settings_section(
		'mism_generalSettings_section', 
		__( 'General Settings', 'mism' ), 
		'mism_general_settings_section_callback', 
		'mismSettings'
	);
        
        add_settings_field( 
		'mism_default_currency_field', 
		__( 'Default Currency', 'mism' ), 
		'mism_default_currency_field_callback', 
		'mismSettings', 
		'mism_generalSettings_section' 
	);
	
	add_settings_field( 
		'mism_tax_field', 
		__( 'Tax', 'mism' ), 
		'mism_tax_field_callback', 
		'mismSettings', 
		'mism_generalSettings_section' 
	);
        
        #   Paypal Settings
        add_settings_section(
		'mism_paypalSettings_section', 
		__( 'Paypal Settings', 'mism' ), 
		'mism_paypal_settings_section_callback', 
		'mismSettings'
	);

        add_settings_field( 
		'mism_business_email_field', 
		__( 'Business Email', 'mism' ), 
		'mism_business_email_field_callback', 
		'mismSettings', 
		'mism_paypalSettings_section' 
	);
        
        add_settings_field( 
		'mism_environment_field', 
		__( 'Environment', 'mism' ), 
		'mism_environment_field_callback', 
		'mismSettings', 
		'mism_paypalSettings_section' 
	);
        
        #   Redirection Settings
        add_settings_section(
		'mism_redirectionSettings_section', 
		__( 'Redirection Settings', 'mism' ), 
		'mism_redirection_settings_section_callback', 
		'mismSettings'
	);
        
        add_settings_field( 
		'mism_package_not_active_field', 
		__( 'Package not active URL', 'mism' ), 
		'mism_package_not_active_field_callback', 
		'mismSettings', 
		'mism_redirectionSettings_section' 
	);
        
        add_settings_field( 
		'mism_checkout_field', 
		__( 'CheckOut URL', 'mism' ), 
		'mism_checkout_field_callback', 
		'mismSettings', 
		'mism_redirectionSettings_section' 
	);
        
        add_settings_field( 
		'mism_return_field', 
		__( 'Return URL', 'mism' ), 
		'mism_return_field_callback', 
		'mismSettings', 
		'mism_redirectionSettings_section' 
	);
        
        add_settings_field( 
		'mism_cancel_field', 
		__( 'Cancel URL', 'mism' ), 
		'mism_cancel_field_callback', 
		'mismSettings', 
		'mism_redirectionSettings_section' 
	);
        
        add_settings_field( 
		'mism_notify_field', 
		__( 'Notify URL', 'mism' ), 
		'mism_notify_field_callback', 
		'mismSettings', 
		'mism_redirectionSettings_section' 
	);

	


}

function mism_redirection_settings_section_callback(){
    
}

function mism_default_currency_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <select name='mism_package_settings[default_currency]'>
        <option value='1' <?php selected( $mism_package_settings['default_currency'], 1 ); ?>>Dollar ($)</option>
        <option value='2' <?php selected( $mism_package_settings['default_currency'], 2 ); ?>>Euro (EUR)</option>
    </select>
    <?php
}

function mism_environment_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <select name='mism_package_settings[environment]'>
        <option value='1' <?php selected( $mism_package_settings['environment'], 1 ); ?>>SANDBOX</option>
        <option value='2' <?php selected( $mism_package_settings['environment'], 2 ); ?>>LIVE</option>
    </select>
    <?php
}


function mism_business_email_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <input type='text' name='mism_package_settings[business_email]' value='<?php echo $mism_package_settings['business_email']; ?>'>
    <?php

}

function mism_package_not_active_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <input type='text' name='mism_package_settings[package_not_active]' value='<?php echo $mism_package_settings['package_not_active']; ?>'>
    <?php

}

function mism_checkout_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <input type='text' name='mism_package_settings[checkout]' value='<?php echo $mism_package_settings['checkout']; ?>'>
    <?php

}

function mism_return_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <input type='text' name='mism_package_settings[return]' value='<?php echo $mism_package_settings['return']; ?>'>
    <?php

}

function mism_tax_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <input type='text' name='mism_package_settings[tax]' value='<?php echo $mism_package_settings['tax']; ?>'><span>(in percentage)</span>
    <?php

}

function mism_cancel_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <input type='text' name='mism_package_settings[cancel]' value='<?php echo $mism_package_settings['cancel']; ?>'>
    <?php

}

function mism_notify_field_callback(  ) { 

    $mism_package_settings = get_option( 'mism_package_settings' );
    ?>
    <input type='text' name='mism_package_settings[notify]' value='<?php echo $mism_package_settings['notify']; ?>'>
    <span>IPN Listener URL: <?php echo "<DOMAIN_URL>/wp-admin/admin-ajax.php?action=mi_ipnlistener_notification";?></span>
    <?php

}

function medma_site_manager_radio_field_2_render(  ) { 

	$options = get_option( 'medma-site-manager_settings' );
	?>
	<input type='radio' name='medma-site-manager_settings[medma-site-manager_radio_field_2]' <?php checked( $options['medma-site-manager_radio_field_2'], 1 ); ?> value='1'>
	<?php

}


function medma_site_manager_select_field_3_render(  ) { 

	$options = get_option( 'medma-site-manager_settings' );
	?>
	<select name='medma-site-manager_settings[medma-site-manager_select_field_3]'>
		<option value='1' <?php selected( $options['medma-site-manager_select_field_3'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['medma-site-manager_select_field_3'], 2 ); ?>>Option 2</option>
	</select>

<?php

}



function mism_general_settings_section_callback(  ) { 

	

}

function mism_paypal_settings_section_callback(  ) { 

	

}


function package_settings_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
		<h2><?php _e('Settings','mism');?></h2>
		
		<?php
		settings_fields( 'mismSettings' );
		do_settings_sections( 'mismSettings' );
		submit_button();
		?>
		
	</form>
	<?php

}

