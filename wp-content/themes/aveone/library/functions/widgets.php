<?php

$aveone_layout = aveone_get_option('evl_layout','2cr');
$aveone_widgets_header = aveone_get_option('evl_widgets_header','one');
$aveone_widgets_footer = aveone_get_option('evl_widgets_num','disable');

if (($aveone_layout == "2cr" || $aveone_layout == "2cl" || $aveone_layout == "3cr" || $aveone_layout == "3cl" || $aveone_layout == "3cm"))  
{

if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Sidebar 1', 'aveone' ),
'id' => 'sidebar-1',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
));
} else {
register_sidebar(array(
'name' => __( 'Sidebar Widgets Disabled', 'aveone' ),
'id' => 'sidebar-1',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
'description' => __('You are using one column layout. Please visit theme settings page and change layout to enable sidebar widgets. Widgets placed on this area won\'t be active.', 'pure-line'),
));
}

if (($aveone_layout == "3cr" || $aveone_layout == "3cl" || $aveone_layout == "3cm"))  
{
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Sidebar 2', 'aveone' ),
'id' => 'sidebar-2',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
));
}


function aveone_header1() {
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Header 1', 'aveone' ),
'id' => 'header-1',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
)); }
function aveone_header2() { if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Header 2', 'aveone' ),
'id' => 'header-2',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
)); }
function aveone_header3() { if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Header 3', 'aveone' ),
'id' => 'header-3',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
)); }
function aveone_header4() { if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Header 4', 'aveone' ),
'id' => 'header-4',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
));
}

function aveone_footer1() {
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Footer 1', 'aveone' ),
'id' => 'footer-1',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
)); }
function aveone_footer2() { if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Footer 2', 'aveone' ),
'id' => 'footer-2',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
)); }
function aveone_footer3() { if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Footer 3', 'aveone' ),
'id' => 'footer-3',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
)); }
function aveone_footer4() { if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => __( 'Footer 4', 'aveone' ),
'id' => 'footer-4',
'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
'after_widget' => '</div></div>',
'before_title' => '<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">',
'after_title' => '</h3></div>',
));
}

// Header widgets

  if (($aveone_widgets_header == "one"))  
{
aveone_header1();
}
  if (($aveone_widgets_header == "two"))  
{
aveone_header1();
aveone_header2();
}
  if (($aveone_widgets_header == "three"))  
{
aveone_header1();
aveone_header2();
aveone_header3();
}
  if (($aveone_widgets_header == "four"))  
{
aveone_header1();
aveone_header2();
aveone_header3();
aveone_header4();
} else {}

// Footer widgets

  if (($aveone_widgets_footer == "one"))  
{
aveone_footer1();
}
  if (($aveone_widgets_footer == "two"))  
{
aveone_footer1();
aveone_footer2();
}
  if (($aveone_widgets_footer == "three"))  
{
aveone_footer1();
aveone_footer2();
aveone_footer3();
}
  if (($aveone_widgets_footer == "four"))  
{
aveone_footer1();
aveone_footer2();
aveone_footer3();
aveone_footer4();
} else {}

function aveone_widget_area_active( $index ) {
	global $wp_registered_sidebars;
	
	$widgetarea = wp_get_sidebars_widgets();
	if ( isset($widgetarea[$index]) ) return true;
	
	return false;
}

function aveone_widget_area( $name = false ) {
	if ( !isset($name) ) {
		$widget[] = "widget.php";
	} else {
		$widget[] = "widget-{$name}.php";
	}
	locate_template( $widget, true );
}




function aveone_widget_before_title() { ?>

<div class="before-title"><div class="widget-title-background"></div><h3 class="widget-title">

<?php }

function aveone_widget_after_title() { ?>

</h3></div>

<?php }

function aveone_widget_before_widget() { ?>

<div class="widget"><div class="widget-content">

<?php }

function aveone_widget_after_widget() { ?>

</div></div>

<?php }


function aveone_widget_text($args, $number = 1) {
extract($args);
$options = get_option('aveone_widget_text');
$title = $options[$number]['title'];
if ( empty($title) )
$title = '';  }



class aveone_carousel_WP_Widget extends WP_Widget {

function __construct() {
		$widget_ops = array('classname' => 'carousel-slider', 'description' => __('Insert your custom image slides', 'aveone' ));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('carousel-slider', __('aveone: Carousel Slider', 'aveone'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
  
  $aveone_defaultslider = "<div id='myCarousel' class='carousel slide'  data-ride='carousel'>
  
  <ol class='carousel-indicators'>
<li data-target='#myCarousel' data-slide-to='0' class='active'></li>
<li data-target='#myCarousel' data-slide-to='1'></li>
<li data-target='#myCarousel' data-slide-to='2'></li>
<li data-target='#myCarousel' data-slide-to='3'></li>
</ol>


<div class='carousel-inner'>
<div class='item active'>

<img src='".get_template_directory_uri()."/library/media/images/slider/slider_img_01.jpg' alt='' />
<div class='carousel-caption'>
<h4>Built-in Bootstrap Elements and Font Awesome let you do amazing things with your website</h4>
</div>
</div>

<div class='item'>

<img src='".get_template_directory_uri()."/library/media/images/slider/slider_img_02.jpg' alt='' />
<div class='carousel-caption'>
<h4>Easy to use control panel with a lot of options</h4> 
</div>
</div>

<div class='item'>

<img src='".get_template_directory_uri()."/library/media/images/slider/slider_img_03.jpg' alt='' />
<div class='carousel-caption'>
<h4>Fully responsive theme for any device</h4>  
</div>
</div> 

<div class='item'>

<img src='".get_template_directory_uri()."/library/media/images/slider/slider_img_04.jpg' alt='' />
<div class='carousel-caption'>
<h4>Unlimited color schemes</h4> 
</div>
</div>


</div>

<a class='left carousel-control' href='#myCarousel' data-slide='prev'><img src='".get_template_directory_uri()."/library/media/images/left-ar.png' /></a>
<a class='right carousel-control' href='#myCarousel' data-slide='next'><img src='".get_template_directory_uri()."/library/media/images/right-ar.png' /></a>

</div>
";
  
  
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => $aveone_defaultslider ) );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'aveone'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

<?php
	}
}


function aveone_carousel_init() {
   
	register_widget('aveone_carousel_WP_Widget');

}

add_action('widgets_init', 'aveone_carousel_init', 1);

?>
