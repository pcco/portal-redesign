<?php

	/*	
	*	CrunchPress Options File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file contains the CrunchPress panel elements and create the 
	*	CrunchPress panel at the back-end of the framework
	*	---------------------------------------------------------------------
	*/
	
add_action('wp_ajax_slider_settings','slider_settings');
function slider_settings(){

	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
	
					$return_data = array('success'=>'-1', 'alert'=>'Save option failed, please try contacting your host provider to increase the post_max_size and suhosin.post.max_vars varialble on the server.');
					
					
					?>		
<div class="cp-wrapper bootstrap_admin cp-margin-left"> 

    <!--content area start -->	  
	<div class="hbg top_navigation row-fluid">
		<div class="cp-logo span2">
			<img src="<?php echo CP_PATH_URL;?>/framework/images/logo.png" class="logo" />
		</div>
		<div class="sidebar span10">
			<?php echo top_navigation_html_tooltip();?>
		</div>
	 <?php //echo top_navigation_html(); ?>
	</div>
	<div class="content-area-main row-fluid"> 
	
      <!--sidebar start -->
      <div class="sidebar-wraper span2">
        <div class="sidebar-sublinks">
      <ul id="wp_t_o_right_menu">
				<li class="slide_settings" id="active_tab"><?php _e('Slider Settings', 'crunchpress'); ?></li>
			</ul>
        </div>
      </div>
		  <!--sidebar end --> 
      <!--content start -->
      <div class="content-area span10">
	  <?php //echo top_navigation_html(); ?>
        <form id="options-panel-form" name="cp-panel-form">
          <div class="panel-elements" id="panel-elements">
            <div class="panel-element" id="panel-element-save-complete">
              <div class="panel-element-save-text">
                <?php _e('Save Options Complete', 'crunchpress'); ?>
                .</div>
              <div class="panel-element-save-arrow"></div>
            </div>
            <div class="panel-element">
			<?php
			if(isset($action) AND $action == 'slider_settings'){
				$slider_settings_xml = '<slider_settings>';
				$slider_settings_xml = $slider_settings_xml . create_xml_tag('select_slider',$select_slider);
				// $slider_settings_xml = $slider_settings_xml . '<flex_slider_settings>';
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('animation_type_flex',$animation_type_flex);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('reverse_order_flex',$reverse_order_flex);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('startat_flex_slider',$startat_flex_slider);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('auto_play_flex',$auto_play_flex);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('animation_speed_flex',$animation_speed_flex);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('pause_on_flex',$pause_on_flex);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('navigation_on_flex',$navigation_on_flex);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('arrow_on_flex',$arrow_on_flex);
				// $slider_settings_xml = $slider_settings_xml . '</flex_slider_settings>';
				// $slider_settings_xml = $slider_settings_xml . '<anything_slider_settings>';
				//$slider_settings_xml = $slider_settings_xml . create_xml_tag('slide_mod_anything',$slide_mod_anything);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('auto_play_anything',$auto_play_anything);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('pause_on_anything',$pause_on_anything);
				// $slider_settings_xml = $slider_settings_xml . create_xml_tag('animation_speed_anything',$animation_speed_anything);
				// $slider_settings_xml = $slider_settings_xml . '</anything_slider_settings>';
				
				$slider_settings_xml = $slider_settings_xml . '<bx_slider_settings>';
				$slider_settings_xml = $slider_settings_xml . create_xml_tag('slide_order_bx',$slide_order_bx);
				$slider_settings_xml = $slider_settings_xml . create_xml_tag('auto_play_bx',$auto_play_bx);
				$slider_settings_xml = $slider_settings_xml . create_xml_tag('pause_on_bx',$pause_on_bx);
				$slider_settings_xml = $slider_settings_xml . create_xml_tag('animation_speed_bx',$animation_speed_bx);
				$slider_settings_xml = $slider_settings_xml . create_xml_tag('show_bullets',$show_bullets);
				$slider_settings_xml = $slider_settings_xml . create_xml_tag('show_arrow',$show_arrow);
				$slider_settings_xml = $slider_settings_xml . '</bx_slider_settings>';
				$slider_settings_xml = $slider_settings_xml . '</slider_settings>';

				if(!save_option('slider_settings', get_option('slider_settings'), $slider_settings_xml)){
				
					die( json_encode($return_data) );
					
				}
				
				die( json_encode( array('success'=>'0') ) );
				
			}
			$select_slider = '';
			
			//Flex slider
			$animation_type_flex = '';
			$reverse_order_flex = '';
			$startat_flex_slider = '';
			$auto_play_flex = '';
			$animation_speed_flex = '';
			$pause_on_flex = '';
			$navigation_on_flex = '';
			$arrow_on_flex = '';
			
			//Anything slider
			$slide_mod_anything = '';
			$auto_play_anything = '';
			$pause_on_anything = '';
			$animation_speed_anything = '';
			
			
			//BX slider
			$slide_order_bx = '';
			$auto_play_bx = '';
			$pause_on_bx = '';
			$animation_speed_bx = '';
			$show_bullets = '';
			$show_arrow = '';
			
			$cp_slider_settings = get_option('slider_settings');
			//$dd = find_xml_node($logo_uploa_d,'logo_upload');
			if($cp_slider_settings <> ''){
				$cp_slider = new DOMDocument ();
				$cp_slider->preserveWhiteSpace = FALSE;
				$cp_slider->loadXML ( $cp_slider_settings );
				
				// $select_slider = find_xml_value($cp_slider->documentElement,'select_slider');
				// $animation_type_flex = find_xml_child_nodes($cp_slider_settings,'flex_slider_settings','animation_type_flex');
				// $reverse_order_flex = find_xml_child_nodes($cp_slider_settings,'flex_slider_settings','reverse_order_flex');
				// $startat_flex_slider = find_xml_child_nodes($cp_slider_settings,'flex_slider_settings','startat_flex_slider');
				// $auto_play_flex = find_xml_child_nodes($cp_slider_settings,'flex_slider_settings','auto_play_flex');
				// $animation_speed_flex = find_xml_child_nodes($cp_slider_settings,'flex_slider_settings','animation_speed_flex');
				// $pause_on_flex = find_xml_child_nodes($cp_slider_settings,'flex_slider_settings','pause_on_flex');
				// $navigation_on_flex = find_xml_child_nodes($cp_slider_settings,'flex_slider_settings','navigation_on_flex');
				// $arrow_on_flex = find_xml_child_nodes($cp_slider_settings,'flex_slider_settings','arrow_on_flex');
				
				//Anything Slider Values
				// $slide_mod_anything = find_xml_child_nodes($cp_slider_settings,'anything_slider_settings','slide_mod_anything');
				// $auto_play_anything = find_xml_child_nodes($cp_slider_settings,'anything_slider_settings','auto_play_anything');
				// $pause_on_anything = find_xml_child_nodes($cp_slider_settings,'anything_slider_settings','pause_on_anything');
				// $animation_speed_anything = find_xml_child_nodes($cp_slider_settings,'anything_slider_settings','animation_speed_anything');
				
				//Bx Slider Values
				$slide_order_bx = find_xml_child_nodes($cp_slider_settings,'bx_slider_settings','slide_order_bx');
				$auto_play_bx = find_xml_child_nodes($cp_slider_settings,'bx_slider_settings','auto_play_bx');
				$pause_on_bx = find_xml_child_nodes($cp_slider_settings,'bx_slider_settings','pause_on_bx');
				$animation_speed_bx = find_xml_child_nodes($cp_slider_settings,'bx_slider_settings','animation_speed_bx');
				$show_bullets = find_xml_child_nodes($cp_slider_settings,'bx_slider_settings','show_bullets');
				$show_arrow = find_xml_child_nodes($cp_slider_settings,'bx_slider_settings','show_arrow');
			} 
			?>
			</div>
					<ul class="slide_settings">
						<li id="slide_settings" class="slider_settings_class active_tab">
							<ul class="recipe_class row-fluid">
								<li class="panel-input span8">	
									<span class="panel-title">
										<h3 for="select_slider"><?php _e('SELECT SLIDER', 'crunchpress'); ?></h3>
									</span>
									<div class="combobox">
										<select name="select_slider" id="select_slider">
											<option value="default" selected class="default"> <?php _e('--No Slider--','crunchpress');?> </option>
											<!--<option value="flex_slider" class="flex_slider">Flex Slider</option>
											<option value="anything_slider" class="anything_slider">Anything Slider</option>-->
											<option value="bx_slider" class="bx_slider"> <?php _e('BX Slider','crunchpress');?> </option>
										</select>
									</div>
								</li>
								<li class="span4 right-box-sec"><p> <?php _e('Select slider for configuration.','crunchpress');?> </p></li>
							</ul>	
						
							<!--<div class="flex_slider_box">
							<h4>Flex Slider Configurations</h4>
								<ul class="recipe_class">
									<div class="panel-title">
										<label for="animation_type_flex"><?php _e('ANIMATION TYPE', 'crunchpress'); ?></label>
									</div>
									<div class="panel-input">	
										<div class="combobox">
											<select name="animation_type_flex" id="animation_type_flex">
												<option <?php if( $animation_type_flex == 'fade' ){ echo 'selected'; }?> value="fade">Fade</option>
												<option <?php if( $animation_type_flex == 'slide' ){ echo 'selected'; }?> value="slide">Slide</option>
											</select>
										</div>
									</div>
									<div class="description">Please Select animation type of slider.</div>
								</ul>
								<div class="clear"></div>
								<ul class="recipe_class">
									<li class="panel-title">
										<label for="reverse_order_flex"><?php _e('REVERSE ORDER', 'crunchpress'); ?></label>
									</li>
									<li class="panel-input">	
										<div class="combobox">
											<select name="reverse_order_flex" id="reverse_order_flex">
												<option value="true" <?php if( $reverse_order_flex == 'true' ){ echo 'selected'; }?>>Yes</option>
												<option value="false" <?php if( $reverse_order_flex == 'false' ){ echo 'selected'; }?>>No</option>
											</select>
										</div>
									</li>
									<li class="description">Please select slider image order.</li>
								</ul>
								<div class="clear"></div>
								<ul class="panel-body recipe_class">
									<li class="panel-title">
										<label for="startat_flex_slider" > <?php _e('START SLIDER FROM', 'crunchpress'); ?> </label>
									</li>				
									<li class="panel-input">
										<input type="text" name="startat_flex_slider" id="startat_flex_slider" value="<?php if($startat_flex_slider <> ''){echo $startat_flex_slider;};?>" />
									</li>
									<li class="description">Please give number from which image you want to start slider.</li>
								</ul>
								<div class="clear"></div>
								<ul class="panel-body recipe_class">
									<li class="panel-title">
										<label for="auto_play_flex" > <?php _e('AUTO PLAY', 'crunchpress'); ?> </label>
									</li>	
									<li class="panel-input">
										<label for="auto_play_flex">
											<div class="checkbox-switch <?php echo ($auto_play_flex=='enable' || ($auto_play_flex==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
										</label>
										<input type="checkbox" name="auto_play_flex" class="checkbox-switch" value="disable" checked>
										<input type="checkbox" name="auto_play_flex" id="auto_play_flex" class="checkbox-switch" value="enable" <?php echo ($auto_play_flex=='enable' || ($auto_play_flex==''))? 'checked': ''; ?>>
									</li>
									<li class="description">Please turn on/off autoplay.</li>
								</ul>
								<div class="clear"></div>
								<ul class="panel-body recipe_class">
									<div class="panel-title">
										<label for="animation_speed_flex" > <?php _e('ANIMATION SPEED', 'crunchpress'); ?> </label>
									</div>				
									<div class="panel-input">
										<input type="text" name="animation_speed_flex" id="animation_speed_flex" value="<?php if($animation_speed_flex <> ''){echo $animation_speed_flex;};?>" />
									</div>
									<div class="description">Please enter slider animation speed.</div>
								</ul>
								<div class="clear"></div>
								<ul class="panel-body recipe_class">
									<li class="panel-title">
										<label for="pause_on_flex" > <?php _e('PAUSE ON HOVER', 'crunchpress'); ?> </label>
									</li>	
									<li class="panel-input">
										<label for="pause_on_flex">
											<div class="checkbox-switch <?php echo ($pause_on_flex=='enable' || ($pause_on_flex==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
										</label>
										<input type="checkbox" name="pause_on_flex" class="checkbox-switch" value="disable" checked>
										<input type="checkbox" name="pause_on_flex" id="pause_on_flex" class="checkbox-switch" value="enable" <?php echo ($pause_on_flex=='enable' || ($pause_on_flex==''))? 'checked': ''; ?>>
									</li>
									<li class="description">Please turn on/off slider pause on hover.</li>
								</ul>
								<div class="clear"></div>
								<ul class="panel-body recipe_class">
									<li class="panel-title">
										<label for="navigation_on_flex" > <?php _e('BULLETS NAVIGATION', 'crunchpress'); ?> </label>
									</li>	
									<li class="panel-input">
										<label for="navigation_on_flex">
											<div class="checkbox-switch <?php echo ($navigation_on_flex=='enable' || ($navigation_on_flex==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
										</label>
										<input type="checkbox" name="navigation_on_flex" class="checkbox-switch" value="disable" checked>
										<input type="checkbox" name="navigation_on_flex" id="navigation_on_flex" class="checkbox-switch" value="enable" <?php echo ($navigation_on_flex=='enable' || ($navigation_on_flex==''))? 'checked': ''; ?>>
									</li>
									<li class="description">Please turn on/off slider navigation.</li>
								</ul>
								<div class="clear"></div>
								<ul class="panel-body recipe_class">
									<li class="panel-title">
										<label for="arrow_on_flex" > <?php _e('ARROW NAVIGATION', 'crunchpress'); ?> </label>
									</li>	
									<li class="panel-input">
										<label for="arrow_on_flex">
											<div class="checkbox-switch <?php echo ($arrow_on_flex=='enable' || ($arrow_on_flex==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
										</label>
										<input type="checkbox" name="arrow_on_flex" class="checkbox-switch" value="disable" checked>
										<input type="checkbox" name="arrow_on_flex" id="arrow_on_flex" class="checkbox-switch" value="enable" <?php echo ($arrow_on_flex=='enable' || ($arrow_on_flex==''))? 'checked': ''; ?>>
									</li>
									<li class="description">Please turn on/off Slider Arrow Navigation.</li>
								</ul>
							</div>
							<div class="anything_slider_box">
								<h4>Anything Slider Configurations</h4>
								<ul class="panel-body recipe_class">
									<li class="panel-title">
										<label for="auto_play_anything" > <?php _e('AUTO PLAY', 'crunchpress'); ?> </label>
									</li>	
									<li class="panel-input">
										<label for="auto_play_anything">
											<div class="checkbox-switch <?php echo ($auto_play_anything=='enable' || ($auto_play_anything==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
										</label>
										<input type="checkbox" name="auto_play_anything" class="checkbox-switch" value="disable" checked>
										<input type="checkbox" name="auto_play_anything" id="auto_play_anything" class="checkbox-switch" value="enable" <?php echo ($auto_play_anything=='enable' || ($auto_play_anything==''))? 'checked': ''; ?>>
									</li>
									<li class="description">Please turn on/off Slider autoplay.</li>
								</ul>
								<div class="clear"></div>
								<ul class="panel-body recipe_class">
									<li class="panel-title">
										<label for="pause_on_anything"><?php _e('PAUSE ON HOVER', 'crunchpress'); ?></label>
									</li>	
									<li class="panel-input">
										<label for="pause_on_anything">
											<div class="checkbox-switch <?php echo ($pause_on_anything=='enable' || ($pause_on_anything==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
										</label>
										<input type="checkbox" name="pause_on_anything" class="checkbox-switch" value="disable" checked>
										<input type="checkbox" name="pause_on_anything" id="pause_on_anything" class="checkbox-switch" value="enable" <?php echo ($pause_on_anything=='enable' || ($pause_on_anything==''))? 'checked': ''; ?>>
									</li>
									<li class="description">Please On/Off slider pause on hover.</li>
								</ul>
								<div class="clear"></div>
								<ul class="panel-body recipe_class">
									<li class="panel-title">
										<label for="animation_speed_anything" > <?php _e('ANIMATION SPEED', 'crunchpress'); ?> </label>
									</li>				
									<li class="panel-input">
										<input type="text" name="animation_speed_anything" id="animation_speed_anything" value="<?php if($animation_speed_anything <> ''){echo $animation_speed_anything;};?>" />
									</li>
									<li class="description">Please define animation speed for slider.</li>
								</ul>
							</div>-->
							<div class="clear"></div>
							<div class="bx_slider_box">
								<h4> <?php _e('BX Slider Configurations','crunchpress');?> </h4>
								<div class="row-fluid">
									<ul class="recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="slide_order_bx"><?php _e('Slider Effect', 'crunchpress'); ?></h3>
											</span>
											<div class="combobox">
												<select name="slide_order_bx" id="slide_order_bx">
													<option value="slide" <?php if( $slide_order_bx == 'false' ){ echo 'selected'; }?>> <?php _e('Slide','crunchpress');?> </option>
													<option value="fade" <?php if( $slide_order_bx == 'false' ){ echo 'selected'; }?>> <?php _e('Fade','crunchpress');?> </option>
												</select>
											</div>
											<p><?php _e('Please select slider image order.','crunchpress');?></p>
										</li>
									</ul>
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="auto_play_bx" > <?php _e('AUTO PLAY', 'crunchpress'); ?> </h3>
											</span>	
											<label for="auto_play_bx">
												<div class="checkbox-switch <?php echo ($auto_play_bx=='enable' || ($auto_play_bx==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
											</label>
											<input type="checkbox" name="auto_play_bx" class="checkbox-switch" value="disable" checked>
											<input type="checkbox" name="auto_play_bx" id="auto_play_bx" class="checkbox-switch" value="enable" <?php echo ($auto_play_bx=='enable' || ($auto_play_bx==''))? 'checked': ''; ?>>
											<p> <?php _e('Please turn on/off Slider autoplay.','crunchpress');?><p>
										</li>
									</ul>
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="pause_on_bx"><?php _e('PAUSE ON HOVER', 'crunchpress'); ?></h3>
											</span>	
											<label for="pause_on_bx">
												<div class="checkbox-switch <?php echo ($pause_on_bx=='enable' || ($pause_on_bx==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
											</label>
											<input type="checkbox" name="pause_on_bx" class="checkbox-switch" value="disable" checked>
											<input type="checkbox" name="pause_on_bx" id="pause_on_bx" class="checkbox-switch" value="enable" <?php echo ($pause_on_bx=='enable' || ($pause_on_bx==''))? 'checked': ''; ?>>
											<p> <?php _e('Please On/Off slider pause on hover.','crunchpress');?> </p>
										</li>
									</ul>
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="animation_speed_bx" > <?php _e('ANIMATION SPEED', 'crunchpress'); ?> </h3>
											</span>	
											<input type="text" name="animation_speed_bx" id="animation_speed_bx" value="<?php if($animation_speed_bx <> ''){echo $animation_speed_bx;};?>" />
											<p> <?php _e('Please define animation speed for slider.','crunchpress');?> </p>
										</li>									
									</ul>
								</div>
								<div class="row-fluid">
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="show_bullets"><?php _e('SHOW BULLETS NAVIGATION', 'crunchpress'); ?></h3>
											</span>	
											<label for="show_bullets">
												<div class="checkbox-switch <?php echo ($show_bullets=='enable' || ($show_bullets==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
											</label>
											<input type="checkbox" name="show_bullets" class="checkbox-switch" value="disable" checked>
											<input type="checkbox" name="show_bullets" id="show_bullets" class="checkbox-switch" value="enable" <?php echo ($show_bullets=='enable' || ($show_bullets==''))? 'checked': ''; ?>>
											<p> <?php _e('Please On/Off slider pause on hover.','crunchpress');?> </p>
										</li>
									</ul>
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="show_arrow"><?php _e('SHOW ARROW NAVIGATION', 'crunchpress'); ?></h3>
											</span>	
											<label for="show_arrow">
												<div class="checkbox-switch <?php echo ($show_arrow=='enable' || ($show_arrow==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
											</label>
											<input type="checkbox" name="show_arrow" class="checkbox-switch" value="disable" checked>
											<input type="checkbox" name="show_arrow" id="show_arrow" class="checkbox-switch" value="enable" <?php echo ($show_arrow=='enable' || ($show_arrow==''))? 'checked': ''; ?>>
											<p> <?php _e('Please On/Off slider pause on hover.','crunchpress');?> </p>
										</li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
          
            <div class="panel-element-tail">
              <div class="tail-save-changes">
                <div class="loading-save-changes"></div>
                <input type="submit" value="<?php echo __('Save Changes','crunchpress') ?>">
                <input type="hidden" name="action" value="slider_settings">
                <!--<input type="hidden" name="security" value="<?php //echo wp_create_nonce(plugin_basename(__FILE__))?>">--> 
              </div>
            </div>
          </div>
        </form>
      </div>
      <!--content End --> 
    </div>
    <!--content area end --> 
  </div>
	<?php
	
}	
?>
