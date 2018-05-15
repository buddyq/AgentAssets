<?php
/**
 * Template: Sidebar.php
 *
 * @package Aveone
 * @subpackage Template
 */
 
 $aveone_layout = aveone_get_option('evl_layout','2cl');
 
?>
    <!--BEGIN #secondary-2 .aside-->
    <div id="secondary-2" class="aside <?php if (($aveone_layout == "1c")) {} if (($aveone_layout == "3cm" || $aveone_layout == "3cl" || $aveone_layout == "3cr")) {echo 'col-xs-12 col-sm-6 col-md-3';} else {echo 'col-sm-6 col-md-4';} ?>">
		<?php	/* Widgetized Area */
				if ( !dynamic_sidebar( 'sidebar-2' )) : ?>
		<?php endif; /* (!function_exists('dynamic_sidebar') */ ?>
	</div><!--END #secondary-2 .aside-->