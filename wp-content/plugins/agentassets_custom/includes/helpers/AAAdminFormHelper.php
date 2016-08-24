<?php

function deployTagOptions($htmlOptions) {
    $optionsHtml = array();
    foreach ($htmlOptions as $option => $value) {
        $optionsHtml[] = ' '.$option.'="'.htmlspecialchars($value).'"';
    }
    return implode(' ', $optionsHtml);
}

class AAAdminFormConfig {
    protected $_items = array();

    /**
     * @param $siteSettingsModel SiteSettingsModel
     * @throws Exception
     * @return AAAdminFormConfig
     */
    public static function build($siteSettingsModel) {
        $instance = new self();
        $className = get_class($siteSettingsModel);
        foreach($siteSettingsModel->attributesMetadata() as $name => $config) {
            $config['name'] = $className . '[' . $name . ']';
            $config['value'] = $siteSettingsModel->{$name};
            if ($siteSettingsModel->hasErrors($name)) {
                $config['error'] = $siteSettingsModel->getFirstError($name);
            }

            array_push($instance->_items, self::fieldFactory($config));
        }
        usort($instance->_items, array(__CLASS__, 'formItemCompare'));
        return $instance;
    }

    public static function formItemCompare($itemLeft, $itemRight) {
        if ($itemLeft->formIndex == $itemRight->formIndex)
            return 0;
        return ($itemLeft->formIndex < $itemRight->formIndex) ? -1 : 1;
    }

    public function appendItem($item, $position = null) {
        if (is_array($item)) {
            $item = self::fieldFactory($item);
        }
        if ($item) {
            if ($position && $position < count($this->_items)) {
                array_splice($this->_items, $position, 0, array($item));
            } else {
                array_push($this->_items, $item);
            }
        }
    }

    public function prependItem($item, $position = 0) {
        if (is_array($item)) {
            $item = self::fieldFactory($item);
        }
        if ($item) {
            if ($position < 0 || $position > (count($this->_items - 1))) {
                throw new Exception('Out of index');
            }
            array_splice($this->_items, $position, 0, $item);
        }
    }

    public static function fieldFactory($config) {
        $item = null;
        $typesMap = array(
            'string' => 'AAAdminFormTextField',
            'number' => 'AAAdminFormNumberField',
            'image' => 'AAAdminFormImageField',
            'textarea' => 'AAAdminFormTextareaField',
            'editor' => 'AAAdminFormEditorField',
            'select' => 'AAAdminFormDropdownField',
        );

        if (!isset($typesMap[$config['type']])) {
            throw new Exception('Unknown form field type '.$config['type']);
        }

        $item = new $typesMap[$config['type']];
        $item->id = self::getFieldId($config['name']);
        $item->label = $config['label'];
        $item->formIndex = $config['formIndex'];
        if (isset($config['htmlOptions'])) {
            $item->mergeHtmlOptions($config['htmlOptions']);
        }
        if (isset($config['description'])) {
            $item->description = $config['description'];
        }
        $item->htmlOptions['name'] = $config['name'];
        $item->htmlOptions['value'] = isset($config['value']) ? $config['value'] : '';
        if (!empty($config['error'])) {
            $item->error = $config['error'];
        }

        switch ($config['type']) {
            case 'string':
                $item->htmlOptions['type'] = 'text';
                break;
            case 'select':
                $item->options = $config['options'];
                break;
        }

        return $item;
    }

    public static function getFieldId($fieldName) {
        return trim(preg_replace('/[^a-zA-Z0-9-]{1,1}/', '-', $fieldName), "\t\n\r\0\x0B-");
    }

    public function getItems() {
        return $this->_items;
    }
}

class AAAdminFormHelper {
    public static function beginForm($action, $method='post', $htmlOptions = array(), $nonce = null) {
        $htmlOptions = array_merge(array(
            'method' => $method,
            'action' => $action,
        ), $htmlOptions);
        ?>
        <form <?php echo deployTagOptions($htmlOptions);?> >
        <?php if ($nonce) {
            wp_nonce_field($nonce);
        } ?>
            <table class="form-table">
                <tbody>
        <?php
    }

    public static function endForm($submit = null) {
        ?>
                </tbody>
            </table>
        <?php if ($submit) { ?>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo $submit;?>">
            </p>
        <?php } ?>
        </form>
        <?php
    }

    public static function checkFormNonce($nonce) {
        return check_admin_referer($nonce);
    }

    public static function renderFields($fieldsConfig) {
        /** @var AAAdminFormItem $item */
        foreach($fieldsConfig->getItems() as $item) {
            $item->render();
        }
    }

    /**
     * @param $model SiteSettingsModel
     */
    public static function renderVisibilityLinksScript($model) {
        $metadata = $model->attributesMetadata();
        $linksConfig = array();

        foreach($metadata as $attribute => $config) {
            if (!isset($config['visibilityLink'])) continue;
            $visibilityLink = $config['visibilityLink'];
            if (isset($visibilityLink['on'])) foreach ($visibilityLink['on'] as $fieldName => $values) {
                $fieldName = get_class($model).'['.$fieldName.']';
                if (!isset($linksConfig[$fieldName])) $linksConfig[$fieldName] = array();
                foreach($values as $value) {
                    if (!isset($linksConfig[$fieldName][$value])) $linksConfig[$fieldName][$value] = array('on' => array(), 'off' => array());
                    $linksConfig[$fieldName][$value]['on'][] = AAAdminFormConfig::getFieldId(get_class($model).'['.$attribute.']');
                }
            }
            if (isset($visibilityLink['off'])) foreach ($visibilityLink['off'] as $fieldName => $values) {
                $fieldName = get_class($model).'['.$fieldName.']';
                if (!isset($linksConfig[$fieldName])) $linksConfig[$fieldName] = array();
                foreach($values as $value) {
                    if (!isset($linksConfig[$fieldName][$value])) $linksConfig[$fieldName][$value] = array('on' => array(), 'off' => array());
                    $linksConfig[$fieldName][$value]['off'][] = AAAdminFormConfig::getFieldId(get_class($model).'['.$attribute.']');
                }
            }
        }
        ?>
        <script type="text/javascript">
            (function() {
                function jqesc(selector) {
                    return selector.replace(/(:|\.|\[|\]|,)/g, "\\$1");
                }

                var formLinksConfig = <?php echo json_encode($linksConfig, JSON_PRETTY_PRINT); ?>;

                var formFieldsVisibilityRefresh = function (e) {
                    if ('undefined' !== typeof(formLinksConfig[this.name])) {
                        var valuesCfg = formLinksConfig[this.name];
                        if ('undefined' !== typeof(valuesCfg[this.value])) {
                            var cfg = valuesCfg[this.value];
                            console.log(cfg);
                            var id;
                            if ('undefined' !== typeof(cfg['on'])) {
                                for (id in cfg['on']) {
                                    if (cfg['on'].hasOwnProperty(id)) {
                                        console.log('#' + jqesc(cfg['on'][id]));
                                        jQuery('#' + jqesc(cfg['on'][id])).show();
                                    }
                                }
                            }
                            if ('undefined' !== typeof(cfg['off'])) {
                                for (id in cfg['off']) {
                                    if (cfg['off'].hasOwnProperty(id)) {
                                        jQuery('#' + jqesc(cfg['off'][id])).hide();
                                    }
                                }
                            }
                        }
                    }
                };

                for (var name in formLinksConfig) {
                    if (formLinksConfig.hasOwnProperty(name)) {
                        var fields = jQuery('[name="' + jqesc(name) + '"]').change(formFieldsVisibilityRefresh);
                        fields.each(function(index, field) {
                            formFieldsVisibilityRefresh.call(field);
                        });
                    }
                }
            })();
        </script>
        <?php
    }
}