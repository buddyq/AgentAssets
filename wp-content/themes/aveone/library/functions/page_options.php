<div class='pyre_metabox'>
<h2 style="margin-top:0;"><?php _e( 'Post options', 'aveone' ); ?></h2>
<?php
$this->aveone_select(	'full_width',
				__( 'Full Width', 'aveone' ),
				array(
					'no' => __( 'No', 'aveone' ), 
					'yes' => __( 'Yes', 'aveone' ),
				),
				''
			);
?>  
<h2 style="margin-top:0;"><?php _e( 'Slider Options', 'aveone' ); ?>:</h2>
<?php   
$this->aveone_select(	'slider_type',
				__( 'Slider Type', 'aveone' ),
				array(
					'no' => __( 'No Slider', 'aveone' ),
					'parallax' => __( 'Parallax Slider', 'aveone' ),
					'posts' => __( 'Posts Slider', 'aveone' ),
					'bootstrap' => __( 'Bootstrap Slider', 'aveone' )
				),
				''
			);
?>
<h2 style="margin-top:0;"><?php _e( 'Widget Options', 'aveone' ); ?></h2>
<?php   
$this->aveone_select(	'widget_page',
				__( 'Enable Header Widgets', 'aveone' ),
				array( 
				'no' => __( 'No', 'aveone' ),
				'yes' => __( 'Yes', 'aveone' )
				),
				''
			);
?>
</div>
