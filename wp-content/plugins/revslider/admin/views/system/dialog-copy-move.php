<<<<<<< HEAD
<?php if( !defined( 'ABSPATH') ) exit(); ?>

<div id="dialog_copy_move" data-textclose="<?php _e("Close",'revslider')?>" data-textupdate="<?php _e("Do It!",'revslider')?>" title="<?php _e("Copy / move slide",'revslider')?>" style="display:none">
	
	<br>
	
	<?php _e("Choose Slider",'revslider')?>:
	<?php echo $selectSliders; ?>
	
	<br><br>
	
	<?php _e("Choose Operation",'revslider')?>:
	
	<input type="radio" id="radio_copy" value="copy" name="copy_move_operation" checked />
	<label for="radio_copy" style="cursor:pointer;"><?php _e("Copy",'revslider')?></label>
	&nbsp; &nbsp;
	<input type="radio" id="radio_move" value="move" name="copy_move_operation" />
	<label for="radio_move" style="cursor:pointer;"><?php _e("Move",'revslider')?></label>		
	
=======
<?php if( !defined( 'ABSPATH') ) exit(); ?>

<div id="dialog_copy_move" data-textclose="<?php _e("Close",'revslider')?>" data-textupdate="<?php _e("Do It!",'revslider')?>" title="<?php _e("Copy / move slide",'revslider')?>" style="display:none">
	
	<br>
	
	<?php _e("Choose Slider",'revslider')?>:
	<?php echo $selectSliders; ?>
	
	<br><br>
	
	<?php _e("Choose Operation",'revslider')?>:
	
	<input type="radio" id="radio_copy" value="copy" name="copy_move_operation" checked />
	<label for="radio_copy" style="cursor:pointer;"><?php _e("Copy",'revslider')?></label>
	&nbsp; &nbsp;
	<input type="radio" id="radio_move" value="move" name="copy_move_operation" />
	<label for="radio_move" style="cursor:pointer;"><?php _e("Move",'revslider')?></label>		
	
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
</div>