<?php

if( ddl_has_feature('tabs-cell') === false ){
    return;
}

class WPDD_layout_tabs_cell extends WPDD_layout_container{

    private $navigation_style = 'tabs';
    private $justified = false;
    private $stacked = false;
    private $fade = false;

    function __construct($name, $width, $css_class_name = '', $editor_visual_template_id = '', $css_id = '', $tag = 'div', $cssframework = 'bootstrap', $args = array() ) {
        parent::__construct($name, $width, $css_class_name, 'tabs-cell', null, $css_id, $tag);
        $this->set_cell_type('tabs-cell');
        $this->layout = new WPDD_layout( $width, $cssframework);
        $this->navigation_style = isset( $args['navigation_style'] ) ? $args['navigation_style'] : $this->navigation_style;
        $this->justified = isset( $args['justified'] ) ? $args['justified'] : $this->justified;
        $this->stacked = isset( $args['stacked'] ) ? $args['stacked'] : $this->stacked;
        $this->fade = isset( $args['fade'] ) ? $args['fade'] : $this->fade;
    }

    function get_as_array() {
        $data = parent::get_as_array();

        $data['kind'] = 'Tabs';
        $data['navigation_style'] = $this->navigation_style;
        $data['justified'] = $this->justified;
        $data['stacked'] = $this->stacked;
        $data = array_merge($data, $this->layout->get_as_array());

        return $data;
    }

    protected function get_disabled_class(){
        return WPDD_layouts_layout_tabs::get_disabled_class($this);
    }

    protected function get_active_class(){
        return WPDD_layouts_layout_tabs::get_active_class($this);
    }

    protected function get_attr_for_tabs(){
        return WPDD_layouts_layout_tabs::get_attr_for_tabs($this);
    }

    protected function get_attr_for_justified(){
        return WPDD_layouts_layout_tabs::get_attr_for_justified($this);
    }

    protected function get_attr_for_stacked(){
        return WPDD_layouts_layout_tabs::get_attr_for_stacked($this);
    }

    protected function get_attr_for_pills(){
        return WPDD_layouts_layout_tabs::get_attr_for_pills($this);
    }

    protected function get_data_attr(){
        return WPDD_layouts_layout_tabs::get_data_attr($this);
    }

    protected function get_class_for_pills(){
        return WPDD_layouts_layout_tabs::get_class_for_pills($this);
    }

    protected function get_class_for_tabs(){
        return WPDD_layouts_layout_tabs::get_class_for_tabs($this);
    }

    public function render_navigation()
    {
        if( $this->navigation_style === WPDD_layouts_layout_tabs::$navigation_t ){
            return $this->render_as_tabs();
        } elseif ( $this->navigation_style === WPDD_layouts_layout_tabs::$navigation_p ){
            return $this->render_as_pills();
        }
        return $this->render_as_tabs();
    }

    protected function render_as_tabs(){
        ob_start();
        $justified = $this->justified ? $this->get_attr_for_justified () : '';
        $navigation_wrap_tag = apply_filters('ddl-tabs-get_navigation_wrap_tag', 'ul', $this);
        $navigation_element_tag = apply_filters('ddl-tabs-get_navigation_element_tag', 'li', $this);
        ?>
        <<?php echo $navigation_wrap_tag;?> class="<?php echo $this->get_class_for_tabs ();?> <?php echo $justified;?>" role="tablist">
            <?php
            $count = 1;
            $rows = $this->get_rows();
            foreach ($rows as $row):
                if( $row instanceof WPDD_layout_tabs_pane ):
                $name =  $row->get_name();
                $nav_name = $row->get_anchor();
                $disabled = $row->get_disabled() ? $this->get_disabled_class() : '';
                $active = $count === 1 ? $this->get_active_class() : '';
                ?>
                <<?php echo $navigation_element_tag;?> role="presentation" class="<?php echo $disabled;?> <?php echo $active;?>">
                    <a href="#<?php echo $nav_name ?>" aria-controls="<?php echo $nav_name ?>" role="<?php echo $this->get_attr_for_tabs();?>" <?php echo $this->get_data_attr();?>="<?php echo $this->get_attr_for_tabs();?>"><?php echo $name;?></a>
                </<?php echo $navigation_element_tag;?>>
                <?php
                $count++;
                endif;
            endforeach;
            ?>
        </<?php echo $navigation_wrap_tag;?>>
        <?php
        return ob_get_clean();
    }

    protected function render_as_pills(){
        ob_start();
        $justified = $this->justified ? $this->get_attr_for_justified () : '';
        $stacked = $this->stacked ? $this->get_attr_for_stacked () : '';
        $navigation_wrap_tag = apply_filters('ddl-tabs-get_navigation_wrap_tag', 'ul', $this);
        $navigation_element_tag = apply_filters('ddl-tabs-get_navigation_element_tag', 'li', $this);
        ?>
        <<?php echo $navigation_wrap_tag;?> class="<?php echo $this->get_class_for_pills ();?> <?php echo $justified;?> <?php echo $stacked;?>" role="navigation">
            <?php
            $count = 1;
            $rows = $this->get_rows();
            foreach ($rows as $row):
                if( $row instanceof WPDD_layout_tabs_pane ):
                $name =  $row->get_name();
                $nav_name = $row->get_anchor();
                    $disabled = $row->get_disabled() ? $this->get_disabled_class() : '';
                    $active = $count === 1 ? $this->get_active_class() : '';
                ?>
                <<?php echo $navigation_element_tag;?> role="presentation" class="<?php echo $disabled;?> <?php echo $active;?>">
                    <a href="#<?php echo $nav_name ?>" aria-controls="<?php echo $nav_name ?>" role="<?php echo $this->get_attr_for_pills();?>" <?php echo $this->get_data_attr();?>="<?php echo $this->get_attr_for_pills();?>"><?php echo $name;?></a>
                </<?php echo $navigation_element_tag;?>>
                <?php
                $count++;
                endif;
            endforeach;
            ?>
        </<?php echo $navigation_wrap_tag;?>>
        <?php
        return ob_get_clean();
    }
}

class WPDD_layout_tabs_cell_factory extends WPDD_layout_container_factory
{
    public function get_cell_info($template)
    {
        $template['cell-image-url'] = DDL_ICONS_SVG_REL_PATH.'svg-tabs.svg';
        $template['preview-image-url'] = DDL_ICONS_PNG_REL_PATH . 'layout-cells_tabs.jpg';
        $template['name'] = __('Tabs', 'ddl-layouts');
        $template['description'] = __('Allow visitors to switch between tabs inside the page.', 'ddl-layouts');
        $template['button-text'] = __('Assign a Tabs', 'ddl-layouts');
        $template['dialog-title-create'] = __('Create new Tabs', 'ddl-layouts');
        $template['dialog-title-edit'] = __('Edit Tabs', 'ddl-layouts');
        $template['dialog-template'] = $this->_dialog_template();
        $template['category'] = __('Layout structure', 'ddl-layouts');
        $template['has_settings'] = false;
        return $template;
    }

    protected function _dialog_template()
    {
        ob_start();
        include WPDDL_GUI_ABSPATH . '/dialogs/dialog_tabs_edit_fields.tpl.php';
        return ob_get_clean();
    }
}


class WPDD_layout_tabs_pane extends WPDD_layout_row{
    protected $disabled = false;
    protected $fade = false;
    protected $random_id = 0;

    function __construct( $name, $css_class_name = '', $editor_visual_template_id = '', $layout_type = 'fixed', $css_id = '', $additionalCssClasses = '', $tag = 'div', $mode = 'normal', $row = array(), $args = array() ){
        parent::__construct( $name, $css_class_name, $editor_visual_template_id, $layout_type, $css_id, $additionalCssClasses, $tag, $mode);
        $this->disabled = isset( $row['disabled'] ) ? $row['disabled'] : $this->disabled;
        $this->fade = isset( $args['fade'] ) ? $args['fade'] : $this->fade;
        $this->id = $row['id'];
        $this->random_id = uniqid();
    }

    function get_id(){
        return $this->id;
    }

    function get_anchor(){
        return apply_filters('ddl-tabs-get_tab_anchor', str_replace( array('&', '#', '.', ',', ';', '@', '*', '+'), '', strtolower($this->get_slug() ) ).'_'.$this->get_id().'_'.$this->random_id, $this );
    }

    function get_slug(){
        return str_replace( ' ', '_', strtolower($this->get_name() ) );
    }

    function get_disabled(){
        return $this->disabled;
    }

    function get_fade(){
        return $this->fade;
    }

    function render_tabs(){
        $active = apply_filters('ddl-tab_pane_active_class', WPDD_layouts_layout_tabs::$tab_count === 1 ? WPDD_layouts_layout_tabs::get_active_class($this) : '', $this, WPDD_layouts_layout_tabs::$tab_count );
        $fade = apply_filters('ddl-tab_pane_fade_class', $this->get_fade() ? WPDD_layouts_layout_tabs::$tab_count === 1 ? WPDD_layouts_layout_tabs::get_class_for_fade_in($this) : WPDD_layouts_layout_tabs::get_class_for_fade($this) : '', $this, WPDD_layouts_layout_tabs::$tab_count );
        $cssId = apply_filters('ddl-tab_pane_row_css_id', $this->get_css_id() ? 'id="'.$this->get_css_id().'"' : '', $this, WPDD_layouts_layout_tabs::$tab_count );
        $return = apply_filters('ddl-tab_get_tab_pane_element_open', '<div role="tabpanel" class="'.$this->get_class_for_tab().' '.$active. ' '. $fade.'" id="'.$this->get_anchor().'">', $this, WPDD_layouts_layout_tabs::$tab_count);
        $return .= apply_filters('ddl-tab_get_tab_pane_row_element_open', '<'.$this->tag.' class="'.WPDDL_Framework::get_row_class($this->get_mode()).' '.$this->additionalCssClasses.'" '.$cssId.'>', $this, WPDD_layouts_layout_tabs::$tab_count);
        return $return;
    }

    function render_tabs_close(){
        $return = apply_filters('ddl-tab_get_tab_pane_element_close', '</'.$this->tag.'>', $this, WPDD_layouts_layout_tabs::$tab_count);
        $return .= apply_filters('ddl-tab_get_tab_pane_element_close', '</div>', $this, WPDD_layouts_layout_tabs::$tab_count);;
        return $return;
    }

    function get_class_for_tab(){
        return WPDD_layouts_layout_tabs::get_class_for_tab($this);
}
}

class WPDD_layouts_layout_tabs{

    private static $instance;
    static $tab_count = 1;
    static $supported = array('tabs-cell');
    static $navigation_t = 'tabs';
    static $navigation_p = 'pills';
    static $width_justified = 'justified';
    static $width_text = 'text';
    static $navigation_h = 'horizontal';
    static $navigation_v = 'vertical';

    private function __construct(){
        self::$navigation_t = apply_filters('ddl-tabs_navigation_tabs', 'tabs', $this );
        self::$navigation_p = apply_filters('ddl-tabs_navigation_pills', 'pills', $this );
        self::$width_justified = apply_filters('ddl-tabs_navigation_width', 'justified', $this );
        self::$width_text = apply_filters('ddl-tabs_navigation_width', 'text', $this );
        self::$navigation_h = apply_filters('ddl-tabs_navigation_horizontal', 'horizontal', $this );
        self::$navigation_v = apply_filters('ddl-tabs_navigation_vertical', 'vertical', $this );
        $this->init();
    }

    protected function init(){
        add_filter('dd_layouts_register_cell_factory', array(&$this, 'dd_layouts_register_layout_tabs_cell_factory') );
        add_filter( 'ddl-cell_render_output_before_content', array(&$this, 'render_navigation'), 99, 2 );
        add_filter( 'ddl-cell_render_output_after_content', array(&$this, 'render_close'), 99, 2 );
        add_filter( 'ddl_render_row_start', array(&$this, 'start_render'), 99, 3 );
        add_filter( 'ddl_render_row_end', array(&$this, 'end_render'), 99, 4 );
    }

    public function dd_layouts_register_layout_tabs_cell_factory($factories){
        $factories['tabs-cell'] = new WPDD_layout_tabs_cell_factory;
        return $factories;
    }

    public function start_render( $out, $args, $row ){

        if( method_exists( $row, 'get_mode') && $row->get_mode() === 'tab'){
            $out = $row->render_tabs();
            self::$tab_count++;
        }

        return $out;
    }

    public function end_render( $out, $mode, $tag, $row ){

        if( method_exists( $row, 'get_mode') && $row->get_mode() === 'tab'){
            $out = $row->render_tabs_close();
        }

        return $out;
    }

    public function render_navigation( $output, $cell ){

            if( $cell && in_array( $cell->get_cell_type(), self::$supported ) ){
                $output .= $cell->render_navigation();
                $output .= '<div class="tab-content">';
            }

        return $output;
    }

    public function render_close( $output, $cell ){

        if( $cell && in_array( $cell->get_cell_type(), self::$supported ) ){
            $output .= '</div>';
            self::$tab_count = 1;
        }

        return $output;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new WPDD_layouts_layout_tabs();
        }

        return self::$instance;
    }

    public static function get_disabled_class($cell=null){
        return apply_filters('ddl-tabs-get_disabled_class', 'disabled', $cell);
    }

    public static function get_active_class($cell=null){
        return apply_filters('ddl-tabs-get_active_class', 'active', $cell, self::$tab_count);
    }

    public static function get_attr_for_tabs($cell=null){
        return apply_filters('ddl-tabs-get_attr_for_tab', 'tab', $cell);
    }

    public static function get_attr_for_justified($cell=null){
        return apply_filters('ddl-tabs-get_attr_for_justified', ' nav-justified', $cell);
    }

    public static function get_attr_for_stacked($cell=null){
        return apply_filters('ddl-tabs-get_attr_for_stacked', 'nav-stacked', $cell);
    }

    public static function get_attr_for_pills($cell=null){
        return apply_filters('ddl-tabs-get_attr_for_pill', 'pill', $cell);
    }

    public static function get_data_attr($cell=null){
        return apply_filters('ddl-tabs-get_data_attr', 'data-toggle', $cell);
    }

    public static function get_class_for_pills($cell=null){
        return apply_filters('ddl-tabs-get_class_for_pills', 'nav nav-pills', $cell);
    }

    public static function get_class_for_tabs($cell=null){
        return apply_filters('ddl-tabs-get_class_for_pills', 'nav nav-tabs', $cell);
    }

    public static function get_class_for_tab($row=null){
        return apply_filters('ddl-tabs-get_class_for_tab', 'tab-pane', $row, self::$tab_count);
    }

    public static function get_class_for_fade($row=null){
        return apply_filters('ddl-tabs-get_class_for_fade', 'fade', $row, self::$tab_count);
    }

    public static function get_class_for_fade_in($row=null){
        return apply_filters('ddl-tabs-get_class_for_fade_in', 'fade in', $row, self::$tab_count);
    }
}
add_action( 'ddl-before_init_layouts_plugin', array('WPDD_layouts_layout_tabs', 'getInstance') );