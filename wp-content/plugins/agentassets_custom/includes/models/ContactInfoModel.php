<?php

/**
 * Class ContactInfoModel
 *
 * @property int contact_image
 * @property string contact_form_shortcode
 * @property string google_map_address
 * @property string google_map_bubble_marker_address
 * @property string google_map_bubble_marker_city_state
 * @property string google_map_bubble_marker_price
 * @property string google_map_bubble_marker_agentname
 */

class ContactInfoModel extends SiteSettingsModel {
    const OPTION_PREFIX = 'agentassets_contactinfo_';

    /**
     * @param string $className
     * @return ContactInfoModel
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributesMetadata()
    {
        return array(
            'contact_image' => array(
                'label' => 'Contact Picture<span class="desc">Picutre will show on the contact page.</span>',
                'type' => 'image',
                'rules' => array(),
                'formIndex' => 1,
            ),
            'contact_form_shortcode' => array(
                'label' => 'Contact Form Shortcode',
                'description' => 'Copy/Paste Contact Form Shortcode',
                'default' => '[contact-form-7 id="9" title="Contact Form"]',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 2,
                'adminOption' => true,
            ),
            'google_map_address' => array(
                'label' => 'Map Pin Location<span class="desc">This is the actual pin position on the earth.</span>',
                'type' => 'string',
                'description' => '<em>Example: 1600 Pennsylvania Ave, Washington D.C.</em>',
                'rules' => array(),
                'formIndex' => 3,
            ),
            'google_map_bubble_marker_address' => array(
                'label' => 'Map Info Box Address<span class="desc">This is the address that will show up in the info box above the map pin.</span>',
                'type' => 'string',
                'description' => '<em>Example: 1600 Pennsylvania Ave, Washington D.C.</em>',
                'rules' => array(),
                'formIndex' => 4,
            ),
            'google_map_bubble_marker_city_state' => array(
                'label' => 'Map Info Box City/State<span class="desc">Enter city & state to complete the address</span>',
                'type' => 'string',
                'description' => '<em>Displays City/State on Map Info Box</em>',
                'rules' => array(),
                'formIndex' => 5,
            ),
            'google_map_bubble_marker_price' => array(
                'label' => 'Map Info Price<span class="desc">Enter the price of the property or leave blank if you don\'t want to hide it.</span>',
                'type' => 'string',
                'description' => '<em>Displays Price inside Map Info Box</em>',
                'rules' => array(),
                'formIndex' => 6,
            ),
            'google_map_bubble_marker_agentname' => array(
                'label' => 'Map Info Box Agent Name<span class="desc">Listing agent\'s name will be show inside map info box. Leave blank to hide.</span>',
                'type' => 'string',
                'description' => '<em>Displays Agent Name on Map Info Box</em>',
                'rules' => array(),
                'formIndex' => 7,
            ),

        );
    }
}