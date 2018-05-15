<?php
/********************************************
            *
            * Typography add new by ddo
            *
            * class aveone_Customize_Typography_Control 
            * override function render_content()
            * hien thi 4 basic control
            *
            *********************************************/

class aveone_User_Dropdown_Custom_Control extends WP_Customize_Control
{

    private $users = false;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->users = get_users( $options );

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the control's content.
     *
     * Allows the content to be overriden without having to rewrite the wrapper.
     *
     * @return  void
     */
    public function render_content()
    {
        if(empty($this->users))
        {
            return false;
        }
	?>
		<label>
			<span class="customize-control-title" ><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?>>
			<?php foreach( $this->users as $user )
                              {
                                printf('<option value="%s" %s>%s</option>',
                                $user->data->ID,
                                selected($this->value(), $user->data->ID, false),
                                $user->data->display_name);
                              } ?>
			</select>
		</label>
	<?php
    }
} // end class

class aveone_Customize_Typography_Control extends WP_Customize_Control {
    public $type = 'typography';
 
    public function render_content() {
		  $output = '';
    		$options = aveone_options();


			$optionname= mb_substr($this->id,13);
			
			$typography_stored = $options[$optionname];

			$value['id']=$optionname;
			$name= "aveone-theme[$optionname]";
			$value = $this->value();
	?>
			<input style = 'display:none' class = 'typography-font' name =<?php echo $name ?> <?php $this->link(); ?> value = '' />
			<!-- Font Size -->
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select class="t4p-typography t4p-typography-size">
			
			<?php 
			
			for ($i = 9; $i < 71; $i++) { 
				$size = $i . 'px'; 
				printf('<option value="%s" %s>%s</option>',
                               esc_attr($size),
                                selected($value['size'], $size, false),
                                esc_attr($size));
			?>	

			<?php 
			}

			?>
			</select>
			</label >
			<label >

			<!-- Font Face -->
			<?php $faces = aveone_recognized_font_faces();	
			//print_r ($faces) ; 
			?>
			
			
			<select  class="t4p-typography t4p-typography-face">
			<?php 
				foreach ( $faces as $key => $face ) { 
					printf('<option value="%s" %s>%s</option>',
								esc_attr($key),
                                selected($value['face'], $key, false),
                                esc_attr($face));
				?>

			<?php 
			}

			?>
			</select>
			</label >
			<label >

			<!-- Font Weight -->
			<?php $styles = aveone_recognized_font_styles();	 ?>
			
			
			<select  class="t4p-typography t4p-typography-style">
			<?php 
				foreach ( $styles as $key => $style ) { 
					printf('<option value="%s" %s>%s</option>',
	                               strtolower (esc_attr($style)),
	                                selected(strtolower ($value['style']), strtolower ($key), false),
	                                esc_attr($style));
					
				?>
		
			<?php 
			}

			?>
			</select>


			<!-- Color -->
			<!--

			$output .= '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $typography_stored['color'] ) . '"></div></div>';
			$output .= '<input class="t4p-color t4p-typography t4p-typography-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $typography_stored['color'] ) . '" />';
			-->
			</label >
			<label >
			<div id="" class="colorSelector"><div style="background:<?php echo $value['color'] ;?>"></div></div>
			<input style = 'width:80%;float:left;margin-left:10px;' class="t4p-typography-color"  id="" type="text" value="<?php echo $value['color'] ;?>">			
			</label>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('.t4p-typography').change(function(){
						var p = $(this).parent().parent();
						set_json (p) ;
					});	
					var set_json = function(p){
						var size = p.find('.t4p-typography-size').val();
						var face = p.find('.t4p-typography-face').val();
						var style = p.find('.t4p-typography-style').val();
						var color = p.find('.t4p-typography-color').val();
						var json = '{"size":"'+size+'","face":"'+face+'","style":"'+style+'","color":"'+color+'"}';
						p.find('input.typography-font').val(json);
						p.find('input.typography-font').keyup();
					};
					$('.colorSelector').each(function(){
						var Othis = this; //cache a copy of the this variable for use inside nested function
						var initialColor = $(Othis).next('input').attr('value');
						$(this).ColorPicker({
							color: initialColor,
							onShow: function (colpkr) {
							$(colpkr).fadeIn(500);
							return false;
							},
							onHide: function (colpkr) {
							$(colpkr).fadeOut(500);
								var p = $(Othis).parent ().parent () ;
								set_json (p) ;
							return false;
							},
							onChange: function (hsb, hex, rgb) {
								$(Othis).children('div').css('backgroundColor', '#' + hex);
								$(Othis).next('input').attr('value','#' + hex);
							}
						});
					});
					
				});

			</script>
			<style>
			.colorpicker{z-index: 1111111111111111111;}
			.t4p-typography{width:100%;}
			</style>
<?php	

    }
}

/*end add new by ddo */

class aveone_Customize_Image_Control extends WP_Customize_Control {

    public function render_content() {
	
				if ( empty( $this->choices ) )
					return;

				$name = '_customize-radio-' . $this->id;

				?>
				<style>
				#t4p_container .t4p-radio-img-img {
					border: 3px solid #DEDEDE;
					margin: 0 5px 5px 0;
					cursor: pointer;
					border-radius: 3px;
					-moz-border-radius: 3px;
					-webkit-border-radius: 3px;
					}
				#t4p_container .t4p-radio-img-selected {
					border: 3px solid #AAA;
					border-radius: 3px;
					-moz-border-radius: 3px;
					-webkit-border-radius: 3px;
					}
				input[type=checkbox]:before {
					content: '';
					margin: -3px 0 0 -4px;
					}
				</style>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<ul class="controls" id = 't4p_container'>
				<?php
				foreach ( $this->choices as $value => $label ) :
					$class = ($this->value() == $value)?'t4p-radio-img-selected t4p-radio-img-img':'t4p-radio-img-img';
					?>
					<li style="display: inline;">
					<label>
						<input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
					</label>
					</li>
					<?php
				endforeach;
				?>
				</ul>
				<script type="text/javascript">
				
				jQuery(document).ready(function($) {
					$('.controls#t4p_container li img').click(function(){console.log ('ssss') ;
						$('.controls#t4p_container li').each(function(){
							$(this).find('img').removeClass ('t4p-radio-img-selected') ;
						});
						$(this).addClass ('t4p-radio-img-selected') ;
					});
				});
				
				</script>
				<?php
    }
}
class aveone_Customize_Textarea_Control extends WP_Customize_Control {

    public function render_content() {
	
				$name = '_customize-textarea-' . $this->id;

				?>
				<style>
				</style>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<label>
					<textarea style="margin: 2px; width: 100%; height: 102px;" <?php $this->link(); ?>><?php echo esc_attr( $this->value() ); ?></textarea>
				</label>
				<script type="text/javascript">
				jQuery(document).ready(function($) {
				});
				</script>
				<?php
    }
}
?>