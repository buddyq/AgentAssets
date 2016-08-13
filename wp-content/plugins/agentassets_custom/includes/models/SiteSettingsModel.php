<?php

require_once(dirname(dirname(__FILE__)) . '/validators/AAValidators.php');

class SiteSettingsModel {
    const OPTION_PREFIX = 'agentassets_site_setting_';

    protected static $_model = null;
    protected $_attributes;

    protected $_errors = array();

    public static function model($className = __CLASS__) {
        if (is_null(self::$_model)) {
            self::$_model = new $className();
            self::$_model->load();
        }
        return self::$_model;
    }

    public function __get($key) {
        $retValue = null;
        $getterName = 'get'.ucfirst($key);
        if (method_exists($this, $getterName)) {
            $retValue = $this->{$getterName}();
        } else if (isset($this->_attributes[$key])) {
            $retValue = $this->_attributes[$key];
        }
        return $retValue;
    }

    public function __isset($key) {
        $getterName = 'get'.ucfirst($key);
        return (method_exists($this, $getterName) || isset($this->_attributes[$key]));
    }

    public function __set($key, $value) {
        if ('attributes' === $key && is_array($value)) {
            $this->setAttributes($value);
        } else {
            $metadata = $this->attributesMetadata();
            if (isset($metadata[$key])) {
                $this->_attributes[$key] = $value;
            }
        }
    }

    public function setAttributes($values) {
        $metadata = $this->attributesMetadata();
        foreach ($values as $vKey => $vValue) {
            if (isset($metadata[$vKey])) {
                $reflectionClass = new ReflectionClass($this);
                if ($reflectionClass->hasProperty($vKey)) {
                    $this->{$vKey} = $vValue;
                } else {
                    $this->_attributes[$vKey] = $vValue;
                }
            }
        }
    }

    public function load() {
        $metadata = $this->attributesMetadata();
        foreach($metadata as $attribute => $info) {
            $this->{$attribute} = get_option($this::OPTION_PREFIX . $attribute, isset($info['default']) ? $info['default'] : $this->{$attribute});
        }
    }

    public function save() {
        $status = $this->validate();
        if ($status) {
            $metadata = $this->attributesMetadata();
            foreach ($metadata as $attribute => $info) {
                update_option($this::OPTION_PREFIX . $attribute, $this->{$attribute});
            }
        }
        return $status;
    }

    public function validate() {
        $validatorsMap = array();
        foreach ($this->attributesMetadata() as $attribute => $config) {
            if (!isset($config['rules'])) continue;
            foreach($config['rules'] as $rule) {
                $validatorName = $rule[0];
                if (!isset($validatorsMap[$validatorName])) {
                    $validatorsMap[$validatorName] = array();
                }
                $argSig = serialize($rule);
                if (!isset($validatorsMap[$validatorName][$argSig])) {
                    $validatorsMap[$validatorName][$argSig] = array();
                }
                $validatorsMap[$validatorName][$argSig][] = $attribute;
            }
        }
        foreach($validatorsMap as $validatorName => $argSigs) {
            $validatorClass = 'AA'.ucfirst($validatorName).'Validator';
            /** @var AAAbstractValidator $validator */
            $validator = new $validatorClass;
            foreach($argSigs as $argSig => $attributes) {
                $validator->validate($this, $attributes, unserialize($argSig));
            }
        }
        return !$this->hasErrors();
    }

    public function hasErrors($key = null) {
        if (empty($key)) return (0 < count($this->_errors));
        return (isset($this->_errors[$key]) && 0 < count($this->_errors[$key]));
    }

    public function getErrors($key = null) {
        $errors = $this->_errors;
        if (!empty($key)) {
            if (isset($errors[$key])) {
                $errors = $errors[$key];
            } else {
                $errors = null;
            }
        }
        return $errors;
    }

    public function flushErrors() {
        $this->_errors = array();
    }

    public function addError($attribute, $error) {
        if (!isset($this->_errors[$attribute])) {
            $this->_errors[$attribute] = array();
        }
        $this->_errors[$attribute][] = $error;
    }

    public function setError($attribute, $error) {
        $this->addError($attribute, $error);
    }

    public function getFirstError($key = null) {
        $error = null;
        $errors = $this->getErrors($key);
        if (is_array($errors) && count($errors)) {
            $error = $errors[key($errors)];
        }
        if (empty($key) && is_array($error) && count($error)) {
            $error = $error[key($errors)];
        }
        return $error;
    }

    public function attributesMetadata() {
        return array();
    }

    public function getAttributeLabel($attribute) {
        $metadata = $this->attributesMetadata();
        return isset($metadata[$attribute]) ? $metadata[$attribute]['label'] : null;
    }
}