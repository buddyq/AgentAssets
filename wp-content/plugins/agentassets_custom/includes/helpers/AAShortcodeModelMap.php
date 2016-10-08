<?php

class AAShortcodeModelMap {
    protected $model = null;
    protected $modelMetadata;

    /**
     * @param $shortcodename
     * @param $model SiteSettingsModel
     * @return AAShortcodeModelMap
     */
    public static function map($shortcodeName, $model) {
        $instance = new self();
        $instance->model = $model;

        $instance->modelMetadata = $model->attributesMetadata();
        //$shortcodeName = self::getShortcodeName($model);
        foreach($instance->modelMetadata as $attribute => $config) {
            add_shortcode($shortcodeName.'.'.$attribute, array($instance, $attribute));
        }

        return $instance;
    }

    public function __call($method, $arguments) {
        if (isset($this->modelMetadata[$method])) {
            return $this->model->{$method};
        } else {
            throw new Exception('Unknown method');
        }
    }

    public static function getShortcodeName($model) {
        return str_replace('Model', '', get_class($model));
    }
}