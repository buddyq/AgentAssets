<?php

abstract class AAAbstractValidator {
    public $defaultMessages = array(
        'message' => 'The error message is not implemented for this validator!',
    );

    public function getErrorMessage($prefix, $arguments, $params = array()) {
        $message = isset($arguments['message']) ? $arguments['message']
            : (isset($this->defaultMessages[$prefix]) ? $this->defaultMessages[$prefix] : $this->defaultMessages['default']);
        return count($params) ? vsprintf($message, $params) : $message;
    }
    abstract public function validate($model, $attributes, $arguments);
}

class AARequireValidator extends  AAAbstractValidator {
    public $defaultMessages = array(
        'default' => '%s cannot be blank.',
    );

    public function  validate($model, $attributes, $arguments) {
        foreach($attributes as $attribute) {
            $label = $model->getAttributeLabel($attribute);
            if (empty($model->{$attribute})) {
                $model->addError($attribute, $this->getErrorMessage('default', $arguments, array($label)));
            }
        }
    }
}

class AALengthValidator extends  AAAbstractValidator  {
    public $defaultMessages = array(
        'default' => '%s is invalid.',
        'tooBig' => '%s is too long (maximum is %s characters).',
        'tooSmall' => '%s  is too short (minimum is %s characters).',
        'is' => '%s is of the wrong length (should be %s characters).'
    );

    public function  validate($model, $attributes, $arguments) {
        foreach($attributes as $attribute) {
            $value = $model->{$attribute};
            $label = $model->getAttributeLabel($attribute);
            while(true) {
                if (isset($arguments['allowEmpty']) && $arguments['allowEmpty'] && empty($value))
                    break;
                if (is_array($value)) {
                    $model->addError($attribute, $this->getErrorMessage('default', $arguments, array($label)));
                    break;
                }
                if (function_exists('mb_strlen'))
                    $length = mb_strlen($value);
                else
                    $length = strlen($value);
                if (isset($arguments['min']) && $length < $arguments['min']) {
                    $model->addError($attribute, $this->getErrorMessage('tooSmall', $arguments, array($label, $arguments['min'])));
                    break;
                }
                if (isset($arguments['max']) && $length > $arguments['max']) {
                    $model->addError($attribute, $this->getErrorMessage('tooBig', $arguments, array($label, $arguments['max'])));
                    break;
                }
                if (isset($arguments['is']) && $length !== $arguments['is']) {
                    $model->addError($attribute, $this->getErrorMessage('is', $arguments, array($label, $arguments['is'])));
                    break;
                }
                break;
            }
        }
    }
}

class AANumberValidator extends  AAAbstractValidator  {
    public $defaultMessages = array(
        'default' => '%s must be a number.',
        'integer' => '%s must be an integer.',
        'tooBig' => '%s is too big (maximum is %s).',
        'tooSmall' => '%s is too small (minimum is %s).',
    );

    const INT_PATTERN = '/^\s*[+-]?\d+\s*$/';
    const NUM_PATTERN = '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/';

    public function  validate($model, $attributes, $arguments) {
        foreach($attributes as $attribute) {
            $value = $model->{$attribute};
            $label = $model->getAttributeLabel($attribute);
            while (true) {
                if (isset($arguments['allowEmpty']) && $arguments['allowEmpty'] && empty($value))
                    break;
                if (!is_numeric($value)) {
                    $model->addError($attribute, $this->getErrorMessage('default', $arguments, array($label)));
                    break;
                }
                if (isset($arguments['integerOnly']) && $arguments['integerOnly']) {
                    if (!preg_match(self::INT_PATTERN, "$value")) {
                        $model->addError($attribute, $this->getErrorMessage('integer', $arguments, array($label)));
                        break;
                    }
                } else {
                    if (!preg_match(self::NUM_PATTERN, "$value")) {
                        $model->addError($attribute, $this->getErrorMessage('default', $arguments, array($label)));
                        break;
                    }
                }
                if (isset($arguments['min']) && $value < $arguments['min']) {
                    $model->addError($attribute, $this->getErrorMessage('tooSmall', $arguments, array($label, $arguments['min'])));
                    break;
                }
                if (isset($arguments['max']) && $value > $arguments['max']) {
                    $model->addError($attribute, $this->getErrorMessage('tooBig', $arguments, array($label, $arguments['max'])));
                    break;
                }
                break;
            }
        }
    }
}

class AAMatchValidator extends AAAbstractValidator {
    public $defaultMessages = array(
        'default' => '%s is invalid.',
    );

    public function  validate($model, $attributes, $arguments)
    {
        foreach ($attributes as $attribute) {
            while(true) {
                $value = $model->{$attribute};
                $label = $model->getAttributeLabel($attribute);
                if(isset($arguments['allowEmpty']) && $arguments['allowEmpty'] && empty($value))
                    break;

                if(empty($arguments['pattern']))
                    throw new Exception('The "pattern" property must be specified with a valid regular expression.');

                $not = isset($arguments['not']) ? ($arguments['not'] == true) : false;

                if(is_array($value) ||
                    (!$not && !preg_match($arguments['pattern'],$value)) ||
                    ($not && preg_match($arguments['pattern'],$value)))
                {
                    $model->addError($attribute, $this->getErrorMessage('default', $arguments, array($label)));
                }
                break;
            }
        }
    }
}