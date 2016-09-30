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
        $blogOwner = OrderMap::getBlogOwner(get_current_blog_id());
        $user_meta = array();
        $user_data = false;
        if ((!is_null($blogOwner) && 1 != $blogOwner)) {
            $user_meta = get_user_meta($blogOwner);
            $user_data = WP_User::get_data_by('id', $blogOwner );
        }
        $agent_name = (isset($user_meta['first_name']) ? $user_meta['first_name'][0] : '')
            . (isset($user_meta['last_name']) ? ' ' . $user_meta['last_name'][0] : '');
        return array(
            'agent_name' => array(
                'label'      => 'Agent Name',
                'type'       => 'string',
                'default' => $agent_name,
                'rules' => array(
                    array('require'),
                    array('length', 'min' => 6),
                ),
                'formIndex'  => 0,

            ),
            'agent_email' => array(
                'label'      => 'Agent Email',
                'type'       => 'string',
                'default'   => $user_data->user_email,
                'rules' => array(
                    //array('validate_email'),
                ),
                'formIndex'  => 1,
            ),
            'designations' => array(
                'label'      => 'Designations',
                'type'       => 'string',
                'formIndex'  => 2,
                'default' => isset($user_meta['designation']) ? $user_meta['designation'][0] : '',
                'rules' => array(),
            ),
            'business_phone' => array(
                'label'      => 'Business Phone',
                'type'       => 'string',
                'formIndex'  => 3,
                'default' => isset($user_meta['business_phone']) ? $user_meta['business_phone'][0] : '',
                'rules' => array(),
            ),
            'mobile_phone' => array(
                'label'      => 'Mobile Phone',
                'type'       => 'string',
                'formIndex'  => 4,
                'default' => isset($user_meta['mobile_phone']) ? $user_meta['mobile_phone'][0] : '',
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
                'default' => isset($user_meta['broker_name']) ? $user_meta['broker_name'][0] : '',
                'rules' => array(),
            ),
            'broker_website' => array(
                'label'      => 'Broker Website',
                'type'       => 'string',
                'formIndex'  => 7,
                'default' => isset($user_meta['broker_website']) ? $user_meta['broker_website'][0] : '',
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
                'default' => isset($user_meta['facebook']) ? $user_meta['facebook'][0] : '',
                'rules' => array(),
            ),
            'twitter' => array(
                'label'      => 'Twitter',
                'type'       => 'string',
                'formIndex'  => 10,
                'default' => isset($user_meta['twitter']) ? $user_meta['twitter'][0] : '',
                'rules' => array(),
            ),
            'google_plus' => array(
                'label'      => 'Google Plus',
                'type'       => 'string',
                'formIndex'  => 11,
                'default' => isset($user_meta['google_plus']) ? $user_meta['google_plus'][0] : '',
                'rules' => array(),
            ),
        );
    }
}
