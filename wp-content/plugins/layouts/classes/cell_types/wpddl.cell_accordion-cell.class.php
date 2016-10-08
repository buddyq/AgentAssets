<?php

if( ddl_has_feature('accordion-cell') === false ){
    return;
}

class WPDD_layout_accordion_cell extends WPDD_layout_container{

    protected $random_id = 0;

    function __construct($name, $width, $css_class_name = '', $editor_visual_template_id = '', $css_id = '', $tag = 'div', $cssframework = 'bootstrap', $args = array() ) {
        parent::__construct($name, $width, $css_class_name, 'accordion-cell', null, $css_id, $tag);
        $this->set_cell_type('accordion-cell');
        $this->layout = new WPDD_layout( $width, $cssframework);
        $this->random_id = uniqid();
        $this->id = $args['id'];
    }

    function get_as_array() {
        $data = parent::get_as_array();
        $data['kind'] = 'Accordion';
        $data = array_merge($data, $this->layout->get_as_array());

        return $data;
    }

    public function accordion_open(){
        ob_start();?>
        <div class="panel-group" id="<?php echo $this->get_unique_identifier();?>" role="tablist" aria-multiselectable="true">
        <?php
        return apply_filters('ddl-accordion_open', ob_get_clean(), $this );
    }

    public function accordion_close(){
        ob_start();?>
        </div>
        <?php
        return apply_filters('ddl-accordion_close', ob_get_clean(), $this );
    }

    public function get_unique_identifier(){
        return apply_filters('ddl-accordion-get_unique_identifier', strtolower($this->get_slug()).'_'.$this->get_id().'_'.$this->random_id, $this );
    }

    public function get_slug(){
        return str_replace( array('&', '#', '.', ',', ';', '@', '*', '+'), '', str_replace( ' ', '_', strtolower( $this->get_name() ) ) );
    }

    protected function get_id(){
        return $this->id;
    }

}

class WPDD_layout_accordion_cell_factory extends WPDD_layout_container_factory
{
    public function get_cell_info($template)
    {
        $template['cell-image-url'] = DDL_ICONS_SVG_REL_PATH.'svg-collapse.svg';
        $template['preview-image-url'] = DDL_ICONS_PNG_REL_PATH . 'layout-cells_accordion.png';
        $template['name'] = __('Accordion', 'ddl-layouts');
        $template['description'] = __('Auto-collapsing and expanding boxes.', 'ddl-layouts');
        $template['button-text'] = __('Assign a Accordion', 'ddl-layouts');
        $template['dialog-title-create'] = __('Create new Accordion', 'ddl-layouts');
        $template['dialog-title-edit'] = __('Edit Accordion', 'ddl-layouts');
        $template['dialog-template'] = $this->_dialog_template();
        $template['category'] = __('Layout structure', 'ddl-layouts');
        $template['has_settings'] = false;
        return $template;
    }

    protected function _dialog_template()
    {
        ob_start();
        echo '';
        return ob_get_clean();
    }

    public function build( ){
        // prevents possible error for not
    }
}


class WPDD_layout_accordion_panel extends WPDD_layout_row{
 
    protected $random_id = 0;

    function __construct( $name, $css_class_name = '', $editor_visual_template_id = '', $layout_type = 'fixed', $css_id = '', $additionalCssClasses = '', $tag = 'div', $mode = 'normal', $row = array(), $args = array() ){
        parent::__construct( $name, $css_class_name, $editor_visual_template_id, $layout_type, $css_id, $additionalCssClasses, $tag, $mode);
        $this->id = $row['id'];
        $this->random_id = uniqid();
    }

    function get_id(){
        return $this->id;
    }

    function get_anchor(){
        return apply_filters('ddl-accordion-get_panel_anchor', str_replace( array('&', '#', '.', ',', ';', '@', '*', '+'), '', strtolower( $this->get_slug() ) ).'_'.$this->get_id().'_'.$this->random_id, $this );
    }

    function get_slug(){
        return str_replace( ' ', '_', strtolower($this->get_name() ) );
    }

    function render_panel_open( $accordion_id ){
        $count = WPDD_layouts_layout_accordion::$panel_count;
        $collapse_active_class = $count === 1 ? 'in' : '';
        $suffix = '_'.$count . '_' . $this->random_id;
        $cssId = apply_filters('ddl-accordion-get_panel_row_css_id', $this->get_css_id() ? 'id="'.$this->get_css_id().'"' : '', $this, WPDD_layouts_layout_accordion::$panel_count );
        $anchor_class = $count > 1 ? 'collapsed' : '';
        $expanded = $count === 1 ? 'true' : 'false';
        ob_start();?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?php echo $suffix;?>">
                <h4 class="panel-title">
                    <a class="<?php echo $anchor_class;?>" role="button" data-toggle="collapse" data-parent="#<?php echo $accordion_id;?>" href="#<?php echo $this->get_anchor();?>" aria-expanded="<?php echo $expanded;?>" aria-controls="<?php echo $this->get_anchor();?>">
                        <?php echo $this->get_name();?>
                    </a>
                </h4>
            </div>
            <div id="<?php echo $this->get_anchor();?>" class="<?php echo $this->get_panel_css_class();?> <?php echo $collapse_active_class;?>" role="tabpanel" aria-labelledby="heading<?php echo $suffix;?>">
                <div class="panel-body">
        <?php
        echo apply_filters('ddl-accordion-get_panel_row_element_open', '<'.$this->tag.' class="row '.$this->additionalCssClasses.'" '.$cssId.'>', $this, WPDD_layouts_layout_accordion::$panel_count);
        return ob_get_clean();
    }

    function render_panel_close(){
        ob_start();
            echo apply_filters('ddl-accordion-get_panel_row_element_close', '</'.$this->tag.'>', $this, WPDD_layouts_layout_accordion::$panel_count);
        ?>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    function get_panel_css_class(){
        return apply_filters( 'ddl-accordion-get_panel_css_class', $this->get_css_class_name(), $this, WPDD_layouts_layout_accordion::$panel_count );
    }
}

class WPDD_layouts_layout_accordion{

    private static $instance;
    static $panel_count = 1;
    static $supported = array('accordion-cell');
    private $mode = 'panel';
    private $data_parent = '';

    private function __construct(){
        $this->init();
    }

    protected function init(){
        add_filter('dd_layouts_register_cell_factory', array(&$this, 'dd_layouts_register_layout_accordion_cell_factory') );
        add_filter( 'ddl-cell_render_output_before_content', array(&$this, 'render_accordion_open'), 99, 2 );
        add_filter( 'ddl-cell_render_output_after_content', array(&$this, 'render_accordion_close'), 99, 2 );
        add_filter( 'ddl_render_row_start', array(&$this, 'panel_start_render'), 99, 3 );
        add_filter( 'ddl_render_row_end', array(&$this, 'panel_end_render'), 99, 4 );
    }

    public function dd_layouts_register_layout_accordion_cell_factory($factories){
        $factories['accordion-cell'] = new WPDD_layout_accordion_cell_factory;
        return $factories;
    }
    
    public function render_accordion_open( $output, $cell ){
        if( $cell && in_array( $cell->get_cell_type(), self::$supported ) ){
            $output .= $cell->accordion_open();
            $this->data_parent = $cell->get_unique_identifier();
        }

        return $output;
    }
    
    public function render_accordion_close( $output, $cell){
        if( $cell && in_array( $cell->get_cell_type(), self::$supported ) ){
            $output .= $cell->accordion_close();
            self::$panel_count = 1;
        }

        return $output;
    }

    public function panel_start_render( $out, $args, $row ){

        if( method_exists( $row, 'get_mode') && $row->get_mode() === $this->mode ){
            $out = $row->render_panel_open( $this->data_parent );
            self::$panel_count++;
        }

        return $out;
    }

    public function panel_end_render( $out, $mode, $tag, $row ){

        if( method_exists( $row, 'get_mode') && $row->get_mode() === $this->mode ){
            $out = $row->render_panel_close();
        }

        return $out;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new WPDD_layouts_layout_accordion();
        }

        return self::$instance;
    }
}
add_action( 'ddl-before_init_layouts_plugin', array('WPDD_layouts_layout_accordion', 'getInstance') );