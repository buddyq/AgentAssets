<?php
new Customizer_Shortcodes();

class Customizer_Shortcodes {
	public function __construct() {
		add_shortcode( 'property-name', array( &$this, 'aa_property_name' ) );
		add_shortcode( 'get-theme-mod', array( &$this, 'get_theme_mod' ) );
		add_shortcode( 'property-overview', array( &$this, 'aa_property_overview' ) );
		add_shortcode( 'aa_property_description', array( &$this, 'aa_property_description' ) );
		// add_shortcode( 'aa_property_itemized', array( &$this, 'aa_property_itemized' ) );
		add_shortcode( 'aa_property_itemized', array( &$this, 'aa_property_itemized_html' ) );
	}

	/**
	 * Add the Customize link to the admin menu
	 * @return void
	 */
	public function aa_property_name() {
		$aa_property_name = get_theme_mod( 'aa_property_name' );
		return $aa_property_name;
	}

	public function aa_property_description() {
		$aa_property_description = get_theme_mod( 'aa_property_description' );
		return $aa_property_description;
	}


	public function aa_property_overview() {
		$aa_property_overview = '<h3>' . get_theme_mod( 'aa_property_label' ) . '</h3><div class="cover-image"><img src="' . get_theme_mod( 'aa_cover_image' ) . '" /></div><div style="float:right;font-size:1.3rem;">Offered at just <span style="color: #b40000;font-style: italic;">' . get_theme_mod( 'aa_property_price' ) . '</span></div>';
		return $aa_property_overview;
	}


	public function aa_cover_image() {
		$aa_cover_image = '<div class="cover-image">' . get_theme_mod( 'aa_cover_image' ) . '</div>';
		return $aa_cover_image;
	}


	public function aa_property_itemized_html() {
		$aa_property_itemized = '
			<section class="av_textblock_section"  itemscope="itemscope" itemtype="https://schema.org/CreativeWork" ><div class="avia_textblock "   itemprop="text" ><div class="row property-details av-catalogue-container">
			  <ul class="av-catalogue-list details">
			    <li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Price:</div>
			            <div class="av-catalogue-price col-sm-6">$2,500,000</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Type:</div>
			            <div class="av-catalogue-price col-sm-6">House</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">MLS#:</div>
			            <div class="av-catalogue-price col-sm-6">1234567</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Area:</div>
			            <div class="av-catalogue-price col-sm-6">1B</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Bedrooms:</div>
			            <div class="av-catalogue-price col-sm-6">4</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Baths:</div>
			            <div class="av-catalogue-price col-sm-6">3</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Living Areas:</div>
			            <div class="av-catalogue-price col-sm-6">2</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Square Feet:</div>
			            <div class="av-catalogue-price col-sm-6">3,400</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">School District:</div>
			            <div class="av-catalogue-price col-sm-6">AISD</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Pool:</div>
			            <div class="av-catalogue-price col-sm-6">Yes</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">View:</div>
			            <div class="av-catalogue-price col-sm-6">City/Downtown</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Garages:</div>
			            <div class="av-catalogue-price col-sm-6">2 Car</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Year Built:</div>
			            <div class="av-catalogue-price col-sm-6">1975</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Acres:</div>
			            <div class="av-catalogue-price col-sm-6">.45</div>
			        </div>
			    </div>
			  </div>
			  </li>  </ul>
			</div>

			</div></section>';
			return $aa_property_itemized;
	}

	
	public function get_theme_mod( $name, $default = false ) {
	    $mods = get_theme_mods();

	    $theme_mods = array();
	 
	    if ( isset( $mods[$name] ) ) {
	        /**
	         * Filters the theme modification, or 'theme_mod', value.
	         *
	         * The dynamic portion of the hook name, `$name`, refers to
	         * the key name of the modification array. For example,
	         * 'header_textcolor', 'header_image', and so on depending
	         * on the theme options.
	         *
	         * @since 2.2.0
	         *
	         * @param string $current_mod The value of the current theme modification.
	         */
	        // return apply_filters( "theme_mod_{$name}", $mods[$name] );
	    }

	    echo '<pre>';
	    print_r( $mods );
	    echo '</pre>';

	}

	public function aa_property_itemized() {
		$aa_property_itemized = '
			<section class="av_textblock_section"  itemscope="itemscope" itemtype="https://schema.org/CreativeWork" ><div class="avia_textblock "   itemprop="text" ><div class="row property-details av-catalogue-container">
	
			  <ul class="av-catalogue-list details">
	
			    <li class="row">
	
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Price:</div>
			            <div class="av-catalogue-price col-sm-6">$2,500,000</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Type:</div>
			            <div class="av-catalogue-price col-sm-6">House</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">MLS#:</div>
			            <div class="av-catalogue-price col-sm-6">1234567</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Area:</div>
			            <div class="av-catalogue-price col-sm-6">1B</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Bedrooms:</div>
			            <div class="av-catalogue-price col-sm-6">4</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Baths:</div>
			            <div class="av-catalogue-price col-sm-6">3</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Living Areas:</div>
			            <div class="av-catalogue-price col-sm-6">2</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Square Feet:</div>
			            <div class="av-catalogue-price col-sm-6">3,400</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">School District:</div>
			            <div class="av-catalogue-price col-sm-6">AISD</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Pool:</div>
			            <div class="av-catalogue-price col-sm-6">Yes</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">View:</div>
			            <div class="av-catalogue-price col-sm-6">City/Downtown</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Garages:</div>
			            <div class="av-catalogue-price col-sm-6">2 Car</div>
			        </div>
			    </div>
			  </div>
			  </li><li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Year Built:</div>
			            <div class="av-catalogue-price col-sm-6">1975</div>
			        </div>
			    </div>
			  </div>
			  </li>



			  <li class="row">
			  <div class="av-catalogue-item">
			    <div class="av-catalogue-item-inner">
			        <div class="av-catalogue-title-container">
			            <div class="av-catalogue-title col-sm-6">Acres:</div>
			            <div class="av-catalogue-price col-sm-6">.45</div>
			        </div>
			    </div>
			  </div>
			  </li>

			    </ul>
			</div>

			</div></section>';
		return $aa_property_itemized;
	}

}
