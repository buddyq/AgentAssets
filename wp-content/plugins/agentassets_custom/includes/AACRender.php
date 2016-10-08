<?php

class AACRender {
    private static $_instance = array();

    /**
     * @param $name
     * @return AACRender
     */
    public static function instance($name) {
        if (!isset(self::$_instance[$name])) {
            self::$_instance[$name] = new self();
        }
        return self::$_instance[$name];
    }

    // render logic
    protected $_template_paths = array();

    public function addTemplatePath($path, $priority = 0) {
        if (is_dir($path)) {
            if ($priority < 0) $priority = 0;
            if ($priority >= count($this->_template_paths)) {
                $this->_template_paths[] = $path;
            } else {
                array_splice($this->_template_paths, $priority, 0, array($path));
            }
        } else {
            //throw new Exception('Invalid template path: '.$path);
        }
    }

    public function render($template, $namespace = '', $params = array()) {
        $templatePath = $this->locate_template($template, $namespace);
        if (count($params)) {
            extract($params);
        }
        include($templatePath);
    }

    public function srender($template, $namespace = '', $params = array()) {
        ob_start();
        $this->render($template, $namespace, $params);
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    public function locate_template($template, $namespace = '') {
        $namespace = str_replace('.', '/', $namespace);
        $templateView = self::normalizePath($namespace. '/'. $template);

        foreach($this->_template_paths as $templatePath) {
            $templateFile = self::normalizePath($templatePath . '/' . $templateView . '.php');

            if (is_file($templateFile))
                return $templateFile;
        }

        if ('/' === $templateView[0]) {
            $templateView = substr($templateView, 1);
        }

        $defaultTemplatePath = self::normalizePath(STYLESHEETPATH . '/' . $templateView . '.php');
        if (is_file($defaultTemplatePath)) {
            return $defaultTemplatePath;
        }

        // check system templates
        return locate_template($templateView . '.php');
    }

    public static function normalizePath($path) {
        return str_replace('//','/', $path);
    }
}