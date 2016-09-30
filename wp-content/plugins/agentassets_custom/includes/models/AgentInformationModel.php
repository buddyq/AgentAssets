<?php

require_once "SiteSettingsModel.php";

/**
 * Class AgentInformationModel
 *
 * @property string agent_name
 * @property string designations
 * @property string business_phone
 * @property string mobile_phone
 * @property int profile_picture
 * @property string broker_name
 * @property string broker_website
 * @property int broker_logo
 * @property string facebook
 * @property string twitter
 * @property string google_plus
 */
class AgentInformationModel extends SiteSettingsModel {
    const OPTION_PREFIX = 'agentassets_agentinformation_';

    /**
     * @param string $className
     * @return AgentInformationModel
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributesMetadata() {
        return array(
            'agent_name' => array(
                'label'      => 'Agent Name',
                'type'       => 'string',
                'rules' => array(
                    array('require'),
                    array('length', 'min' => 6),
                ),
                'formIndex'  => 0,
            ),
            'agent_email' => array(
                'label'      => 'Agent Email',
                'type'       => 'string',
                'rules' => array(
                    //array('validate_email'),
                ),
                'formIndex'  => 1,
            ),
            'designations' => array(
                'label'      => 'Designations',
                'type'       => 'string',
                'formIndex'  => 2,
                'rules' => array(),
            ),
            'business_phone' => array(
                'label'      => 'Business Phone',
                'type'       => 'string',
                'formIndex'  => 3,
                'rules' => array(),
            ),
            'mobile_phone' => array(
                'label'      => 'Mobile Phone',
                'type'       => 'string',
                'formIndex'  => 4,
                'rules' => array(),
            ),
            'profile_picture' => array(
                'label'      => 'Profile Picture',
                'type'       => 'image',
                'rules' => array(),
                'formIndex'  => 5,
            ),
            'broker_name' => array(
                'label'      => 'Broker Name',
                'type'       => 'string',
                'formIndex'  => 6,
                'rules' => array(),
            ),
            'broker_website' => array(
                'label'      => 'Broker Website',
                'type'       => 'string',
                'formIndex'  => 7,
                'rules' => array(),
            ),
            'broker_logo' => array(
                'label'      => 'Broker Logo',
                'type'       => 'image',
                'rules' => array(),
                'formIndex'  => 8,
            ),
            'facebook' => array(
                'label'      => 'Facebook',
                'type'       => 'string',
                'formIndex'  => 9,
                'rules' => array(),
            ),
            'twitter' => array(
                'label'      => 'Twitter',
                'type'       => 'string',
                'formIndex'  => 10,
                'rules' => array(),
            ),
            'google_plus' => array(
                'label'      => 'Google Plus',
                'type'       => 'string',
                'formIndex'  => 11,
                'rules' => array(),
            ),
        );
    }
}
