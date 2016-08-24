<?php

require_once "SiteSettingsModel.php";

/**
 * Class AgentInformationModel
 *
 * @property string property_description
 * @property string price_type
 * @property string price
 * @property string price1
 * @property string price2
 * @property string property_type
 * @property string property_mls
 * @property string property_area
 * @property string property_bedrooms
 * @property string property_baths
 * @property string property_living_areas
 * @property string property_square_feet
 * @property string property_school_district
 * @property string property_pool
 * @property string property_view
 * @property string property_garages
 * @property string property_year_built
 * @property string property_lot_size
 * @property string property_acreage
 * @property string property_tour_link1
 * @property string property_tour_link2
 */
class PropertyDetailsModel extends SiteSettingsModel
{
    const OPTION_PREFIX = 'agentassets_propertydetails_';

    /**
     * @param string $className
     * @return PropertyDetailsModel
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributesMetadata()
    {
        return array(
            'property_description' => array(
                'label' => 'Property Description',
                'type' => 'editor',
                'rules' => array(),
                'formIndex' => 1,
            ),
            'price_type' => array(
                'label' => 'Price Type',
                'type' => 'select',
                'options' => array(
                    '' => 'Select Price Type',
                    'fixed' => 'Fixed',
                    'range' => 'Range',
                ),
                'rules' => array(),
                'formIndex' => 2,
            ),
            'price' => array(
                'label' => 'Price',
                'type' => 'string',
                'rules' => array(
                    array('match', 'pattern' => '/^[0-9,\.\ ]+$/', 'allowEmpty' => true),
                ),
                'formIndex' => 3,
                'htmlOptions' => array(
                    'class' => 'number-with-commas',
                ),
                'visibilityLink' => array(
                    'on' => array(
                        'price_type' => array('fixed'),
                    ),
                    'off' => array(
                        'price_type' => array('', 'range'),
                    )
                ),
            ),
            'price1' => array(
                'label' => 'Min. Price',
                'type' => 'string',
                'rules' => array(
                    array('match', 'pattern' => '/^[0-9,\.\ ]+$/', 'allowEmpty' => true),
                ),
                'htmlOptions' => array(
                    'class' => 'number-with-commas',
                ),
                'formIndex' => 4,
                'visibilityLink' => array(
                    'on' => array(
                        'price_type' => array('', 'range'),
                    ),
                    'off' => array(
                        'price_type' => array('fixed'),
                    )
                ),
            ),
            'price2' => array(
                'label' => 'Max. Price',
                'type' => 'string',
                'rules' => array(
                    array('match', 'pattern' => '/^[0-9,\.\ ]+$/', 'allowEmpty' => true),
                ),
                'htmlOptions' => array(
                    'class' => 'number-with-commas',
                ),
                'formIndex' => 5,
                'visibilityLink' => array(
                    'on' => array(
                        'price_type' => array('', 'range'),
                    ),
                    'off' => array(
                        'price_type' => array('fixed'),
                    ),
                ),
            ),
            'property_type' => array(
                'label' => 'Type:',
                'type' => 'select',
                'options' => array(
                    ''                  => 'Please select Property Type',
                    'House'             => 'House',
                    'Condo'             => 'Condo',
                    'Ranch'             => 'Ranch',
                    'Lot'               => 'Lot',
                    'Townhouse'         => 'Townhouse',
                    'Commercial'        => 'Commercial',
                    'Duplex'            => 'Duplex',
                    'Loft'              => 'Loft',
                    'Land'              => 'Land',
                    'Multi-Family'      => 'Multi-Family',
                    'Single-Family'     => 'Single-Family',
                    'Office'            => 'Office',
                    'Retail'            => 'Retail',
                    'Mixed Development' => 'Mixed Development',
                ),
                'rules' => array(),
                'formIndex' => 6,
            ),
            'property_mls' => array(
                'label' => 'MLS#:',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 7,
            ),
            'property_area' => array(
                'label' => 'Area:',
                'type' => 'select',
                'options' => array(
                    '0' => 'N/A',
                    '1B' => '1B',
                    '1N' => '1N',
                    '2' => '2',
                    '4' => '4',
                    '6' => '6',
                    '7' => '7',
                    'DT' => 'DT',
                    'UT' => 'UT',
                    '3' => '3',
                    '5' => '5',
                    '3E' => '3E',
                    '5E' => '5E',
                    'NE' => 'NE',
                    '1A' => '1A',
                    '2N' => '2N',
                    'N' => 'N',
                    'NW' => 'NW',
                    '10N' => '10N',
                    '10S' => '10S',
                    'SWE' => 'SWE',
                    'SWW' => 'SWW',
                    '11' => '11',
                    '9' => '9',
                    'SC' => 'SC',
                    'SE' => 'SE',
                    '8W' => '8W',
                    'RN' => 'RN',
                    'W' => 'W',
                    'CLN' => 'CLN',
                    'LN' => 'LN',
                    'MA' => 'MA',
                    'BL' => 'BL',
                    'HD' => 'HD',
                    'LS' => 'LS',
                    'GTE' => 'GTE',
                    'GTW' => 'GTW',
                    'HU' => 'HU',
                    'JA' => 'JA',
                    'PF' => 'PF',
                    'RRE' => 'RRE',
                    'RRW' => 'RRW',
                    '8E' => '8E',
                ),
                'rules' => array(),
                'formIndex' => 8,
            ),
            'property_bedrooms' => array(
                'label' => 'Bedrooms:',
                'type' => 'number',
                'rules' => array(),
                'formIndex' => 9,
            ),
            'property_baths' => array(
                'label' => 'Baths:',
                'type' => 'number',
                'rules' => array(),
                'formIndex' => 10,
            ),
            'property_living_areas' => array(
                'label' => 'Living Areas:',
                'type' => 'number',
                'rules' => array(),
                'formIndex' => 11,
            ),
            'property_square_feet' => array(
                'label' => 'Square Feet:',
                'type' => 'string',
                'htmlOptions' => array(
                    'class' => 'number-with-commas',
                ),
                'rules' => array(
                    array('match', 'pattern' => '/^[0-9,\.\ ]+$/'),
                ),
                'formIndex' => 12,
            ),
            'property_school_district' => array(
                'label' => 'School District:',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 13,
            ),
            'property_pool' => array(
                'label' => 'Pool:',
                'type' => 'select',
                'options' => array(
                    '0' => 'N/A',
                    '1' => 'Yes',
                    '2' => 'No',
                ),
                'rules' => array(),
                'formIndex' => 14,
            ),
            'property_view' => array(
                'label' => 'View:',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 15,
            ),
            'property_garages' => array(
                'label' => 'Garages:',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 16,
            ),
            'property_year_built' => array(
                'label' => 'Year Built:',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 17,
            ),
            'property_lot_size' => array(
                'label' => 'Lot Size:',
                'type' => 'string',
                'htmlOptions' => array(
                    'class' => 'number-with-commas',
                ),
                'rules' => array(),
                'formIndex' => 18,
            ),
            'property_acreage' => array(
                'label' => 'Acreage:',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 19,
            ),
            'property_tour_link1' => array(
                'label' => 'Tour Link1:',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 20,
            ),
            'property_tour_link2' => array(
                'label' => 'Tour Link2:',
                'type' => 'string',
                'rules' => array(),
                'formIndex' => 21,
            ),
        );
    }
}