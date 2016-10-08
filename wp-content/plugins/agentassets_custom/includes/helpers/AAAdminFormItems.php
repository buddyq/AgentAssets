<?php

abstract class AAAdminFormItem {
    public $formIndex = 0;
    public $id = null;
    public $error = null;
    public $htmlOptions = array();
    public $adminOption = false;

    abstract public function render();

    public function mergeHtmlOptions($mOptions) {
        foreach ($mOptions as $attr => $value) {
            if ('class' === $attr) {
                $classes = array();
                if (isset($this->htmlOptions['class'])) {
                    foreach(explode(' ', $this->htmlOptions['class']) as $class) {
                        if (!in_array($class, $classes))
                            $classes[] = trim($class);
                    }
                }
                if (!is_array($value)) $value = explode(' ', $value);
                foreach ($value as $class) {
                    if (!in_array($class, $classes))
                        $classes[] = trim($class);
                }
                $this->htmlOptions['class'] = implode(' ', $classes);
            } else {
                $this->htmlOptions[$attr] = $value;
            }
        }
    }
}

abstract class AAAdminFormField extends AAAdminFormItem {
    public $tagName = 'input';
    public $label = '';
    public $labelOptions = array();
    public $description = null;
}

class AAAdminFormHtml extends AAAdminFormItem{
    public $content = '';
    protected $_cacheOn = false;

    public function render() {
        if ($this->_cacheOn) {
            throw new Exception('beginContent() executed without endContent()');
        }
        echo $this->content;
    }

    public function beginContent() {
        $this->_cacheOn = true;
        ob_start();
    }

    public function endContent() {
        $this->content = ob_get_contents();
        ob_end_clean();
        $this->_cacheOn = false;
    }
}

class AAAdminFormTextField extends AAAdminFormField {
    public $htmlOptions = array(
        'class' => 'regular-text',
    );

    public function render() {
        ?>
        <tr <?php echo isset($this->id) ? 'id="'.$this->id.'"' : '';?> <?php echo isset($this->error) ? 'class="form-invalid"' : '';?>>
            <th scope="row">
                <label for="<?php echo $this->htmlOptions['name'];?>" <?php echo deployTagOptions($this->labelOptions);?>>
                    <?php echo $this->label;?>
                </label>
            </th>
            <td>
                <input <?php echo deployTagOptions($this->htmlOptions);?>>
                <?php echo $this->description;?>
                <?php if ($this->error) { ?>
                    <p class="wp-ui-text-notification"><?php echo $this->error;?></p>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
}

class AAAdminFormImageField extends AAAdminFormField {
    public $htmlOptions = array(
        'class' => 'regular-text',
    );

    public function render() {
        wp_enqueue_media();
        $image = wp_get_attachment_image_src($this->htmlOptions['value'], $size='large');
        $image_url = ($image) ? $image[0] : '';
        ?>
        <tr <?php echo isset($this->id) ? 'id="'.$this->id.'"' : '';?> <?php echo isset($this->error) ? 'class="form-invalid"' : '';?>>
            <th scope="row">
                <label for="<?php echo $this->htmlOptions['name'];?>" <?php echo deployTagOptions($this->labelOptions);?>>
                    <?php echo $this->label;?>
                </label>
            </th>
            <td>
                <input name="<?php echo $this->htmlOptions['name'];?>" type="hidden" class="aa-upload-input" value="<?php echo $this->htmlOptions['value'];?>">
                <img class="aa-upload-image" style="max-width: 348px" src="<?php echo $image_url;?>" /><br/>
                <button class="aa-upload-button" type="button">Upload</button>
                <?php echo $this->description;?>
                <!--<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->

                <!--<input <?php echo deployTagOptions($this->htmlOptions);?>> -->
                <?php if ($this->error) { ?>
                    <p class="wp-ui-text-notification"><?php echo $this->error;?></p>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
}

class AAAdminFormNumberField extends AAAdminFormField {
    public $htmlOptions = array(
        'class' => 'regular-text',
    );

    public function render() {
        $this->htmlOptions['type'] = 'number';
        ?>
        <tr <?php echo isset($this->id) ? 'id="'.$this->id.'"' : '';?> <?php echo isset($this->error) ? 'class="form-invalid"' : '';?>>
            <th scope="row">
                <label for="<?php echo $this->htmlOptions['name'];?>" <?php echo deployTagOptions($this->labelOptions);?>>
                    <?php echo $this->label;?>
                </label>
            </th>
            <td>
                <input <?php echo deployTagOptions($this->htmlOptions);?>>
                <?php echo $this->description;?>
                <?php if ($this->error) { ?>
                    <p class="wp-ui-text-notification"><?php echo $this->error;?></p>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
}

class AAAdminFormTextareaField extends AAAdminFormField {
    public $htmlOptions = array(
        'class' => 'regular-text',
    );

    public function render() {
        $value = $this->htmlOptions['value'];
        unset($this->htmlOptions['value']);
        ?>
        <tr <?php echo isset($this->id) ? 'id="'.$this->id.'"' : '';?> <?php echo isset($this->error) ? 'class="form-invalid"' : '';?>>
            <th scope="row">
                <label for="<?php echo $this->htmlOptions['name'];?>" <?php echo deployTagOptions($this->labelOptions);?>>
                    <?php echo $this->label;?>
                </label>
            </th>
            <td>
                <textarea <?php echo deployTagOptions($this->htmlOptions);?>><?php echo htmlspecialchars($value);?></textarea>
                <?php echo $this->description;?>
                <?php if ($this->error) { ?>
                    <p class="wp-ui-text-notification"><?php echo $this->error;?></p>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
}

class AAAdminFormDropdownField extends AAAdminFormField {
    public $htmlOptions = array(
        'class' => '',
    );

    public $options = array();

    public function render() {
        $value = $this->htmlOptions['value'];
        unset($this->htmlOptions['value']);

        $optionsHtml = array();
        foreach ($this->options as $oVal => $oTitle) {
            $selected = ($oVal == $value) ? ' selected ' : '';
            $optionsHtml[] = '<option value="'.htmlspecialchars($oVal).'" '.$selected.'>'.htmlspecialchars($oTitle).'</option>';
        }
        ?>
        <tr <?php echo isset($this->id) ? 'id="'.$this->id.'"' : '';?> <?php echo isset($this->error) ? 'class="form-invalid"' : '';?>>
            <th scope="row">
                <label for="<?php echo $this->htmlOptions['name'];?>" <?php echo deployTagOptions($this->labelOptions);?>>
                    <?php echo $this->label;?>
                </label>
            </th>
            <td>
                <select <?php echo deployTagOptions($this->htmlOptions);?>>
                    <?php echo implode("\n", $optionsHtml);?>
                </select>
                <?php echo $this->description;?>
                <?php if ($this->error) { ?>
                    <p class="wp-ui-text-notification"><?php echo $this->error;?></p>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
}

class AAAdminFormEditorField extends AAAdminFormField {
    public $htmlOptions = array();

    public function render() {
        $value = $this->htmlOptions['value'];
        unset($this->htmlOptions['value']);
        ?>
        <tr <?php echo isset($this->id) ? 'id="'.$this->id.'"' : '';?> <?php echo isset($this->error) ? 'class="form-invalid"' : '';?>>
            <th scope="row">
                <label for="<?php echo $this->htmlOptions['name'];?>" <?php echo deployTagOptions($this->labelOptions);?>>
                    <?php echo $this->label;?>
                </label>
            </th>
            <td>
                <div>
                <?php wp_editor($value, $this->id . '-editor', array(
                    'textarea_name' => $this->htmlOptions['name'],
                )); ?>
                </div>
                <?php echo $this->description;?>
                <?php if ($this->error) { ?>
                    <p class="wp-ui-text-notification"><?php echo $this->error;?></p>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
}
