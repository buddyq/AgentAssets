<?php

class PrintableInfoModel extends SiteSettingsModel {
    const OPTION_PREFIX = 'agentassets_printableinfo_';

    /**
     * @param string $className
     * @return PrintableInfoModel
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributesMetadata()
    {
        return array(
            'printable_image' => array(
                'label' => 'Printable Image',
                'type' => 'image',
                'rules' => array(),
                'formIndex' => 1,
            ),
            /*'printable_text' => array(
                'label' => 'Printable Text',
                'type' => 'editor',
                'rules' => array(),
                'formIndex' => 2,
            ),*/
        );
    }
}