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
	
	
	// add action to embeded the panel in to dashboard
	add_action('admin_menu','add_crunchpress_panel');
	function add_crunchpress_panel(){
	
		add_menu_page( 'CrunchPress Option', THEME_NAME_F, 'administrator', 'general_options', 'general_options', '' );
			//add_submenu_page( 'general_options', 'Home Page Settings', 'Home Page Settings', 'administrator','homepage_settings', 'homepage_settings' );
			add_submenu_page( 'general_options', 'Typography Settings', 'Typography Settings', 'administrator','typography_settings', 'typography_settings' );
			add_submenu_page( 'general_options', 'Slider Settings', 'Slider Settings', 'administrator','slider_settings', 'slider_settings' );
			add_submenu_page( 'general_options', 'Social Network', 'Social Network', 'administrator','social_settings', 'social_settings' );
			add_submenu_page( 'general_options', 'Sidebar Settings', 'Sidebar Settings', 'administrator','sidebar_settings', 'sidebar_settings' );
			add_submenu_page( 'general_options', 'Default Pages Settings', 'Default Pages Settings', 'administrator','default_pages_settings', 'default_pages_settings' );
			add_submenu_page( 'general_options', 'Newsletter Settings', 'Newsletter Settings', 'administrator','newsletter_settings', 'newsletter_settings' );
			add_submenu_page( 'general_options', 'Import Dummy Data', 'Import Dummy Data', 'administrator','dummydata_import', 'dummydata_import' );
	}
	
		
add_action('wp_ajax_general_options','general_options');
function general_options(){
		
	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}

	$return_data = array('success'=>'-1', 'alert'=>'Save option failed, please try contacting your host provider to increase the post_max_size and suhosin.post.max_vars varialble on the server.');?>
<div class="cp-wrapper bootstrap_admin cp-margin-left"> 

    <!--content area start -->	  
	<div class="hbg top_navigation row-fluid">
		<div class="cp-logo span2">
			<img src="<?php echo CP_PATH_URL;?>/framework/images/logo.png" class="logo" alt="logo" />
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
            <li id="active_tab" class="logo" >
              <?php _e('Logo Settings', 'crunchpress'); ?>
            </li>
            <li class="color_style">
              <?php _e('Style & Color Scheme', 'crunchpress'); ?>
              </li>
            <li class="hr_settings">
              <?php _e('Header Settings', 'crunchpress'); ?>
              </li>
            <li class="ft_settings">
              <?php _e('Footer Settings', 'crunchpress'); ?>
              </li>
            <li class="misc_settings">
              <?php _e('MISC Settings', 'crunchpress'); ?>
              </li>
			  <li class="maintenance_mode_settings">
              <?php _e('Maintenance Mode Settings', 'crunchpress'); ?>
              </li>
			  
            <?php if(!class_exists( 'Envato_WordPress_Theme_Upgrader' )){}else{?>
            <li class="envato_api">
              <?php _e('User API Settings', 'crunchpress'); ?>
              </li>
            <?php }?>
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
							if(isset($action) AND $action == 'general_options'){
								$general_logo_xml = '<general_settings>';
								$general_logo_xml = $general_logo_xml . create_xml_tag('header_logo',htmlspecialchars(stripslashes($header_logo)));
								$general_logo_xml = $general_logo_xml . create_xml_tag('logo_width',$logo_width);
								$general_logo_xml = $general_logo_xml . create_xml_tag('logo_height',$logo_height);
								$general_logo_xml = $general_logo_xml . create_xml_tag('select_layout_cp',$select_layout_cp);
								//$general_logo_xml = $general_logo_xml . create_xml_tag('boxed_scheme',$boxed_scheme);
								$general_logo_xml = $general_logo_xml . create_xml_tag('color_scheme',$color_scheme);
								$general_logo_xml = $general_logo_xml . create_xml_tag('select_bg_pat',$select_background_patren);
								$general_logo_xml = $general_logo_xml . create_xml_tag('bg_scheme',$bg_scheme);
								$general_logo_xml = $general_logo_xml . create_xml_tag('body_patren',$body_patren);
								$general_logo_xml = $general_logo_xml . create_xml_tag('color_patren',$color_patren);
								$general_logo_xml = $general_logo_xml . create_xml_tag('body_image',$body_image);
								$general_logo_xml = $general_logo_xml . create_xml_tag('position_image_layout',$position_image_layout);
								$general_logo_xml = $general_logo_xml . create_xml_tag('image_repeat_layout',$image_repeat_layout);
								$general_logo_xml = $general_logo_xml . create_xml_tag('image_attachment_layout',$image_attachment_layout);
								$general_logo_xml = $general_logo_xml . create_xml_tag('contact_us_code',htmlspecialchars(stripslashes($contact_us_code)));
								//$general_logo_xml = $general_logo_xml . create_xml_tag('topcounter_circle',$topcounter_circle);
								$general_logo_xml = $general_logo_xml . create_xml_tag('countd_event_category',htmlspecialchars(stripslashes($countd_event_category)));
								$general_logo_xml = $general_logo_xml . create_xml_tag('header_css_code',htmlspecialchars(stripslashes($header_css_code)));
								$general_logo_xml = $general_logo_xml . create_xml_tag('google_webmaster_code',htmlspecialchars(stripslashes($google_webmaster_code)));
								$general_logo_xml = $general_logo_xml . create_xml_tag('topbutton_icon',$topbutton_icon);
								//$general_logo_xml = $general_logo_xml . create_xml_tag('topcart_icon',$topcart_icon);
								$general_logo_xml = $general_logo_xml . create_xml_tag('topsocial_icon',$topsocial_icon);
								$general_logo_xml = $general_logo_xml . create_xml_tag('select_footer_cp',$select_footer_cp);
								$general_logo_xml = $general_logo_xml . create_xml_tag('footer_style_apply',$footer_style_apply);
								$general_logo_xml = $general_logo_xml . create_xml_tag('footer_upper_layout',$footer_upper_layout);
								$general_logo_xml = $general_logo_xml . create_xml_tag('copyright_code',htmlspecialchars(stripslashes($copyright_code)));
								$general_logo_xml = $general_logo_xml . create_xml_tag('social_networking',$social_networking);
								//$general_logo_xml = $general_logo_xml . create_xml_tag('top_count_header',$top_count_header);
								//$general_logo_xml = $general_logo_xml . create_xml_tag('footer_banner',htmlspecialchars(stripslashes($footer_banner)));	
								$general_logo_xml = $general_logo_xml . create_xml_tag('footer_col_layout',$footer_col_layout);	
								$general_logo_xml = $general_logo_xml . create_xml_tag('breadcrumbs',$breadcrumbs);	
								$general_logo_xml = $general_logo_xml . create_xml_tag('rtl_layout',$rtl_layout);
								$general_logo_xml = $general_logo_xml . create_xml_tag('site_loader',$site_loader);
								$general_logo_xml = $general_logo_xml . create_xml_tag('element_loader',$element_loader);
								
								$general_logo_xml = $general_logo_xml . create_xml_tag('maintenance_mode',$maintenance_mode);
								$general_logo_xml = $general_logo_xml . create_xml_tag('maintenace_title',htmlspecialchars(stripslashes($maintenace_title)));
								$general_logo_xml = $general_logo_xml . create_xml_tag('countdown_time',$countdown_time);
								$general_logo_xml = $general_logo_xml . create_xml_tag('email_mainte',$email_mainte);
								$general_logo_xml = $general_logo_xml . create_xml_tag('mainte_description',htmlspecialchars(stripslashes($mainte_description)));
								
								$general_logo_xml = $general_logo_xml . create_xml_tag('social_icons_mainte',$social_icons_mainte);
								
								$general_logo_xml = $general_logo_xml . create_xml_tag('tf_username',$tf_username);	
								$general_logo_xml = $general_logo_xml . create_xml_tag('tf_sec_api',$tf_sec_api);	
								$general_logo_xml = $general_logo_xml . '</general_settings>';

								if(!save_option('general_settings', get_option('general_settings'), $general_logo_xml)){
								
									die( json_encode($return_data) );
									
								}
								
								die( json_encode( array('success'=>'0') ) );
								
							}?>
            </div>
            <?php
				$header_logo_upload = '';
				$logo_width = '';
				$logo_height = '';
				$select_layout_cp = '';
				//$boxed_scheme = '';
				$select_bg_pat = '';
				$scheme_color_scheme = '';
				$color_scheme = '';
				//$color_scheme_1 = '';
				$border_color = '';
				$button_color = '';
				$button_hover_color = '';
				$color_patren = '';
				$bg_scheme = '';
				$body_patren = '';
				$body_image = '';
				$position_image_layout = '';
				$image_repeat_layout = '';
				$image_attachment_layout = '';
				$contact_us_code = '';
				$header_css_code = '';
				$google_webmaster_code = '';
				$topbutton_icon = '';
				$footer_upper_layout = '';
				$select_header_cp = '';
				$header_style_apply = '';
				$about_header = '';
				$topcart_icon = '';
				//$topcounter_circle = '';
				$countd_event_category = '';
				$topsocial_icon = '';
				$topsearch_icon = '';
				$copyright_code = '';
				$footer_banner = '';
				$footer_col_layout = '';
				$social_networking = '';
				$top_count_header = '';
				$footer_logo = '';
				$footer_logo_width = '';
				$footer_logo_height = '';
				$footer_layout = '';
				$breadcrumbs = '';			
				$rtl_layout = '';
				$site_loader = '';
				$element_loader = '';
				
				$maintenance_mode = '';
				$maintenace_title = '';
				$countdown_time = '';
				$email_mainte = '';
				$mainte_description = '';
				$social_icons_mainte = '';
				
				$tf_username = '';
				$tf_sec_api = '';
				$cp_general_settings = get_option('general_settings');
				if($cp_general_settings <> ''){
					$cp_logo = new DOMDocument ();
					$cp_logo->loadXML ( $cp_general_settings );
					$header_logo = find_xml_value($cp_logo->documentElement,'header_logo');
					$logo_width = find_xml_value($cp_logo->documentElement,'logo_width');
					$logo_height = find_xml_value($cp_logo->documentElement,'logo_height');
					$select_layout_cp = find_xml_value($cp_logo->documentElement,'select_layout_cp');
					//$boxed_scheme = find_xml_value($cp_logo->documentElement,'boxed_scheme');
					$color_scheme = find_xml_value($cp_logo->documentElement,'color_scheme');
					//$color_scheme_1 = find_xml_value($cp_logo->documentElement,'color_scheme_1');
					$select_bg_pat = find_xml_value($cp_logo->documentElement,'select_bg_pat');
					$bg_scheme = find_xml_value($cp_logo->documentElement,'bg_scheme');
					$body_patren = find_xml_value($cp_logo->documentElement,'body_patren');
					$color_patren = find_xml_value($cp_logo->documentElement,'color_patren');
					$body_image = find_xml_value($cp_logo->documentElement,'body_image');
					$position_image_layout = find_xml_value($cp_logo->documentElement,'position_image_layout');
					$image_repeat_layout = find_xml_value($cp_logo->documentElement,'image_repeat_layout');
					$image_attachment_layout = find_xml_value($cp_logo->documentElement,'image_attachment_layout');
					
					$contact_us_code = find_xml_value($cp_logo->documentElement,'contact_us_code');
					//$topcounter_circle = find_xml_value($cp_logo->documentElement,'topcounter_circle');
					$countd_event_category = find_xml_value($cp_logo->documentElement,'countd_event_category');
					
					$header_css_code = find_xml_value($cp_logo->documentElement,'header_css_code');
					$google_webmaster_code = find_xml_value($cp_logo->documentElement,'google_webmaster_code');
					$topbutton_icon = find_xml_value($cp_logo->documentElement,'topbutton_icon');
					$topcart_icon = find_xml_value($cp_logo->documentElement,'topcart_icon');
					$topsocial_icon = find_xml_value($cp_logo->documentElement,'topsocial_icon');
					$select_footer_cp = find_xml_value($cp_logo->documentElement,'select_footer_cp');
					$footer_style_apply = find_xml_value($cp_logo->documentElement,'footer_style_apply');
					$footer_upper_layout = find_xml_value($cp_logo->documentElement,'footer_upper_layout');
					$copyright_code = find_xml_value($cp_logo->documentElement,'copyright_code');
					//$footer_banner = find_xml_value($cp_logo->documentElement,'footer_banner');
					$footer_col_layout = find_xml_value($cp_logo->documentElement,'footer_col_layout');
					$social_networking = find_xml_value($cp_logo->documentElement,'social_networking');
					$breadcrumbs = find_xml_value($cp_logo->documentElement,'breadcrumbs');
					$rtl_layout = find_xml_value($cp_logo->documentElement,'rtl_layout');
					$site_loader = find_xml_value($cp_logo->documentElement,'site_loader');
					$element_loader = find_xml_value($cp_logo->documentElement,'element_loader');
					
					$maintenance_mode = find_xml_value($cp_logo->documentElement,'maintenance_mode');
					$maintenace_title = find_xml_value($cp_logo->documentElement,'maintenace_title');
					$countdown_time = find_xml_value($cp_logo->documentElement,'countdown_time');
					$email_mainte = find_xml_value($cp_logo->documentElement,'email_mainte');
					$mainte_description = find_xml_value($cp_logo->documentElement,'mainte_description');
					
					$social_icons_mainte = find_xml_value($cp_logo->documentElement,'social_icons_mainte');
					
					$tf_username = find_xml_value($cp_logo->documentElement,'tf_username');
					$tf_sec_api = find_xml_value($cp_logo->documentElement,'tf_sec_api');
				}
				
			
			?>
            <ul class="logo_tab">
              <li id="logo" class="logo_dimenstion active_tab">
                <ul class="panel-body recipe_class logo_upload row-fluid">
                  <?php 
					$image_src_head = '';
					if(!empty($header_logo)){ 
						$image_src_head = wp_get_attachment_image_src( $header_logo, 'full' );
						$image_src_head = (empty($image_src_head))? '': $image_src_head[0];
					}
					?>
					<li class="panel-input span8 eql_height">
						<span class="panel-title">
							<h3 for="header_logo" >
							  <?php _e('Logo', 'crunchpress'); ?>
							</h3>
						</span>
						<div class="content_con">
							<input name="header_logo" type="hidden" class="clearme" id="upload_image_attachment_id" value="<?php echo $header_logo; ?>" />
							<input name="header_link" id="upload_image_text" class="clearme upload_image_text" type="text" value="<?php echo $image_src_head; ?>" />
							<input class="upload_image_button" type="button" value="Upload" />
						</div>
						<p> <?php _e('Upload logo image here, PNG, Gif, JPEG, JPG format supported only.','crunchpress');?> </p>  
					</li>
					<li class="panel-right-box span4 eql_height">
						<div class="admin-logo-image">
						  <?php 
							if(!empty($header_logo)){ 
								$image_src_head = wp_get_attachment_image_src( $header_logo, 'full' );
								$image_src_head = (empty($image_src_head))? '': $image_src_head[0];
								$thumb_src_preview = wp_get_attachment_image_src( $header_logo, array(150,150)); ?>
									<img class="clearme img-class" src="<?php if(!empty($image_src_head)){echo $thumb_src_preview[0];}?>" alt="logo" />
									<span class="close-me"></span>
						  <?php } ?>
						</div>
					</li>
                </ul>
                <div class="clear"></div>
                <ul class="panel-body recipe_class row-fluid">
                  <li class="panel-input span8">
					  <span class="panel-title">
						<h3 for="logo_width" >
						  <?php _e('Width', 'crunchpress'); ?>
						</h3>
					  </span>
                    <div id="logo_width" class="sliderbar" rel="logo_bar"></div>
                    <input type="hidden" name="logo_width" value="<?php echo $logo_width;?>">
					<p> <?php _e('Please scroll Left to Right to adjust logo image width, you can also use Arrow keys UP,Down - Left,Right.','crunchpress');?> </p>                  
                  </li>
                  <li class="span4 right-box-sec" id="slidertext"><?php echo $logo_width;?> <?php _e('px','crunchpress');?> </li>
                </ul>
                <div class="clear"></div>
                <ul class="panel-body recipe_class row-fluid">
                  <li class="panel-input span8">
					  <span class="panel-title">
						<h3 for="logo_height" >
						  <?php _e('Height', 'crunchpress'); ?>
						</h3>
					  </span>
                    <div id="logo_height" class="sliderbar" rel="logo_bar"></div>
                    <input type="hidden" name="logo_height" value="<?php echo $logo_height;?>">
					<p> <?php _e('Please scroll Left to Right to adjust logo image height, you can also use Arrow keys UP,Down - Left,Right.','crunchpress');?> </p>  
                  </li>
				  <li class="span4 right-box-sec" id="slidertext"><?php echo $logo_height;?> <?php _e('px','crunchpress');?> </li>
                </ul>
              </li>
              <li id="color_style" class="style_color_scheme">
                <ul class="panel-body recipe_class row-fluid">
                  <li class="panel-input span8">
					<span class="panel-title">
						<h3 for="select_layout_cp">
						  <?php _e('SELECT LAYOUT', 'crunchpress'); ?>
						</h3>
					</span>
                    <div class="combobox">
                      <select name="select_layout_cp" class="select_layout_cp" id="select_layout_cp">
                        <option <?php if($select_layout_cp == 'full_layout'){echo 'selected';}?> value="full_layout" class="full_layout">Full Layout</option>
                        <option <?php if($select_layout_cp == 'boxed_layout'){echo 'selected';}?> value="boxed_layout" class="box_layout">Box Layout</option>
                      </select>
                    </div>
					<p> <?php _e('Please select website layout Full or Boxed.','crunchpress');?> </p>
                  </li>
                  <li class="span4 logo_upload">
					<div class="admin-logo-image">
						<img src="<?php echo CP_PATH_URL;?>/images/full_version.jpg" class="full_v" />
						<img src="<?php echo CP_PATH_URL;?>/images/boxed_version.jpg" class="boxed_v" />
					</div>	
				  </li>
                </ul>
                <!--<div class="clear"></div>
						<ul id="boxed_layout" class="panel-body recipe_class ">
							<li class="panel-title">
								<label for="boxed_scheme" > <?php _e('BOXED LAYOUT BACKGROUND', 'crunchpress'); ?> </label>
							</li>				
							<li class="panel-input">
								<input type="text" name="boxed_scheme" class="color-picker" value="<?php //if($boxed_scheme <> ''){echo $boxed_scheme;}?>"/>
							</li>
							<li class="description">Please select any color from color palette to use as color scheme, leaving blank color scheme will be auto selected as default.</li>
						</ul>-->
                <div class="clear"></div>
                <ul class="panel-body recipe_class row-fluid">
                   <li class="panel-input span8">
					<span class="panel-title">
						<h3 for="color_scheme" >
						  <?php _e('COLOR SCHEME', 'crunchpress'); ?>
						</h3>
					</span>
					<div class="color-picker-container">
						<input type="text" name="color_scheme" class="color-picker" value="<?php if($color_scheme <> ''){echo $color_scheme;}?>" />
					</div>
					<p> <?php _e('Please select any color from color palette to use as color scheme (it will effect on all headings and anchors), leaving blank color scheme will be auto selected as default.','crunchpress');?> </p>
                  </li>
                  <li class="span4 right-box-sec"> </li>
                </ul>
				<div class="clear"></div>
                <ul class="panel-body recipe_class row-fluid"> 
                  <li class="panel-input span8">
				  <span class="panel-title">
                    <h3>
                      <?php _e('SELECT BACKGROUND TYPE', 'crunchpress'); ?>
                    </h3>
                  </span>
                    <div class="combobox">
                      <select name="select_background_patren" class="select_background_patren" id="select_background_patren">
                        <option <?php if($select_bg_pat == 'Background-Patren'){echo 'selected';}?> value="Background-Patren" class="select_bg_patren"> <?php _e('Background Pattern','crunchpress');?> </option>
                        <option <?php if($select_bg_pat == 'Background-Color'){echo 'selected';}?> value="Background-Color" class="select_bg_color"> <?php _e('Background Color','crunchpress');?> </option>
                        <option <?php if($select_bg_pat == 'Background-Image'){echo 'selected';}?> value="Background-Image" class="select_bg_image"> <?php _e('Background Image','crunchpress');?> </option>
                      </select>
                    </div>
					<p> <?php _e('Please select background pattern or background color.','crunchpress');?> </p>
                  </li>
                  <li id="select_bg_patren" class="span4 pattern-container">
				  <?php 
								$options = array(
									'1'=>array('value'=>'1', 'image'=>'/framework/images/pattern/pattern-1.png'),
									'2'=>array('value'=>'2','image'=>'/framework/images/pattern/pattern-2.png'),
									'3'=>array('value'=>'3','image'=>'/framework/images/pattern/pattern-3.png'),
									'4'=>array('value'=>'4','image'=>'/framework/images/pattern/pattern-4.png'),
									'5'=>array('value'=>'5','image'=>'/framework/images/pattern/pattern-5.png'),
									'6'=>array('value'=>'6','image'=>'/framework/images/pattern/pattern-6.png'),
									'7'=>array('value'=>'7','image'=>'/framework/images/pattern/pattern-7.png'),
									'8'=>array('value'=>'8','image'=>'/framework/images/pattern/pattern-8.png'),
									'9'=>array('value'=>'9','image'=>'/framework/images/pattern/pattern-9.png'),
									'10'=>array('value'=>'10','image'=>'/framework/images/pattern/pattern-10.png'),
									'11'=>array('value'=>'11','image'=>'/framework/images/pattern/pattern-11.png'),
									'12'=>array('value'=>'12','image'=>'/framework/images/pattern/pattern-12.png'),
									'13'=>array('value'=>'13','image'=>'/framework/images/pattern/pattern-13.png'),
									'14'=>array('value'=>'14','image'=>'/framework/images/pattern/pattern-14.png'),
									'15'=>array('value'=>'15','image'=>'/framework/images/pattern/pattern-15.png'),
									'16'=>array('value'=>'16','image'=>'/framework/images/pattern/pattern-16.png'),
									'17'=>array('value'=>'17','image'=>'/framework/images/pattern/pattern-17.png'),
									'18'=>array('value'=>'18','image'=>'/framework/images/pattern/pattern-18.png'),
									'19'=>array('value'=>'19','image'=>'/framework/images/pattern/pattern-19.png'),
									'20'=>array('value'=>'20','image'=>'/framework/images/pattern/pattern-20.png'),
									'21'=>array('value'=>'21','image'=>'/framework/images/pattern/pattern-21.png'),
									'22'=>array('value'=>'22','image'=>'/framework/images/pattern/pattern-22.png'),
									'23'=>array('value'=>'23','image'=>'/framework/images/pattern/pattern-45.png'),
								);
								$value = '';
								$default = '';
								foreach( $options as $option ){ 
								?>
                    <div class='radio-image-wrapper'>
                      <label for="<?php echo $option['value']; ?>">
                      <img src=<?php echo CP_PATH_URL.$option['image']?> class="color_patren" alt="color_patren">
                      <div id="check-list"></div>
                      </label>
                      <input type="radio" class="checkbox_class" name="color_patren" value="<?php echo $option['image']; ?>" <?php 
											if($color_patren == $option['image']){
												echo 'checked';
											}else if($color_patren == '' && $default == $option['image']){
												echo 'checked';
											}
										?> id="<?php echo $option['value']; ?>" class=""
										>
                    </div>
                    <?php } ?> 
				  </li>
                </ul>
                <div class="clear"></div>
                <ul id="select_bg_color" class="panel-body recipe_class row-fluid">
                  
                  <li class="panel-input span8">
				  <span class="panel-title">
                    <h3 for="bg_scheme" >
                      <?php _e('BACKGROUND COLOR', 'crunchpress'); ?>
                    </h3>
                  </span>
                    <div class="color-picker-container">
						<input type="text" name="bg_scheme" class="color-picker" value="<?php if($bg_scheme <> ''){echo $bg_scheme;}?>"/>
					</div>
					<p> <?php _e('Please select any color from color palette to use as background color, leaving blank background will be auto selected as default background.','crunchpress');?> </p>
                  </li>
                  <li class="span4 right-box-sec"></li>
                </ul>
                <div class="clear"></div>
                <ul id="bg_upload_id" class="recipe_class logo_upload row-fluid">
                  <li class="panel-input span8 ">
					  <span class="panel-title">
						<h3 for="body_patren" >
						  <?php _e('Upload Background Pattern', 'crunchpress'); ?>
						</h3>
					  </span>
					  <?php
					  $image_src_head = '';
								
								if(!empty($header_logo)){ 
								
									$image_src_head = wp_get_attachment_image_src( $body_patren, 'full' );
									$image_src_head = (empty($image_src_head))? '': $image_src_head[0];
									//$thumb_src_preview = wp_get_attachment_image_src( $header_logo, '150x150');
									//echo '<img src="' . $thumb_src_preview[0] . '" />';
									
								} 
					  ?>
					<div class="content_con">
						<input name="body_patren" class="emptyme" type="hidden" id="upload_image_attachment_id" value="<?php echo $body_patren; ?>" />
						<input id="upload_image_text" class="emptyme upload_image_text" type="text" value="<?php echo $image_src_head; ?>" />
						<input class="upload_image_button" type="button" value="Upload" />
					</div>
					<p> <?php _e('Upload background pattern for your theme this option provide you access to put your own image to use as background pattern.','crunchpress');?> </p>
                  </li>
                  
				   <li class="panel-right-box span4">
					   <div class="admin-logo-image">
						  <?php 
							if(!empty($body_patren)){ 
								$image_src_head = wp_get_attachment_image_src( $body_patren, 'full' );
								$image_src_head = (empty($image_src_head))? '': $image_src_head[0];
								$thumb_src_preview = wp_get_attachment_image_src( $body_patren, array(150,150));?>
						  <img class="clearme img-class" src="<?php if(!empty($image_src_head)){echo $thumb_src_preview[0];}?>" /><span class="close-me"></span>
						  <?php } ?>
						</div>
					</li>
                </ul>
                <ul id="image_upload_id" class="recipe_class logo_upload row-fluid">
                 
                  <li class="panel-input span8">
					   <span class="panel-title">
						<h3 for="body_image" >
						  <?php _e('Upload Background Image', 'crunchpress'); ?>
						</h3>
					  </span>
					  <?php
					   $image_src_head = '';
								
								if(!empty($body_image)){ 
								
									$image_src_head = wp_get_attachment_image_src( $body_image, 'full' );
									$image_src_head = (empty($image_src_head))? '': $image_src_head[0];
									//$thumb_src_preview = wp_get_attachment_image_src( $header_logo, '150x150');
									//echo '<img src="' . $thumb_src_preview[0] . '" />';
								}
						
					  ?>
                    <div class="content_con">
						<input name="body_image" class="clearme" type="hidden" id="upload_image_attachment_id" value="<?php echo $body_image; ?>" />
						<input id="upload_image_text" class="clearme upload_image_text" type="text" value="<?php echo $image_src_head; ?>" />
						<input class="upload_image_button" type="button" value="Upload" />
					</div>
					<p> <?php _e('Upload background Image for your theme this option provide you access to put your own image to use as background Image.','crunchpress');?> </p>
                  </li>
				   <li class="span4 description" >
					   <div class="admin-logo-image">
						  <?php 
							if(!empty($body_image)){ 
								$image_src_head = wp_get_attachment_image_src( $body_image, 'full' );
								$image_src_head = (empty($image_src_head))? '': $image_src_head[0];
								$thumb_src_preview = wp_get_attachment_image_src( $body_image, array(150,150));?>
						  <img class="clearme img-class" src="<?php if(!empty($image_src_head)){echo $thumb_src_preview[0];}?>" /><span class="close-me"></span>
						  <?php } ?>
						</div>
					</li>
					
                </ul>
                <div class="clear"></div>
				<div class="row-fluid">
                <ul class="recipe_class image_upload_options span4">
                 
                  <li class="panel-radioimage panel-input full-width">
				   <span class="panel-title">
                    <h3 for="position_image_layout">
                      <?php _e('Image Position', 'crunchpress'); ?>
                    </h3>
                  </span>
				  <div class="combobox cp-select-wrap">
					<select name="position_image_layout" class="position_image_layout" id="position_image_layout">
							<?php 
								$value = '';
								$options = array(
									
									'1'=>array('value'=>'top','title'=>'Position Top'),
									'2'=>array('value'=>'right','title'=>'Position Right'),
									'3'=>array('value'=>'left','title'=>'Position Left'),
									'4'=>array('value'=>'bottom','title'=>'Position Bottom'),
									'5'=>array('value'=>'center','title'=>'Position Center'),
									
								);
								foreach( $options as $option ){ ?>
									<option <?php if($position_image_layout == $option['value']){echo 'selected';}?> value="<?php echo $option['value'];?>" class="position_image_layout"><?php echo $option['title'];?></option>
								<?php } ?>
                    </select>
					</div>
					<p> <?php _e('You can manage background image position in this area.','crunchpress');?> </p>
                  </li>
				  
                </ul>
                <ul class="panel-body recipe_class image_upload_options span4">
                  <li class="panel-input full-width">
				  <span class="panel-title">
                    <h3 for="image_repeat_layout">
                      <?php _e('SELECT BACKGROUND TYPE', 'crunchpress'); ?>
                    </h3>
                  </span>
                    <div class="combobox cp-select-wrap">
                      <select name="image_repeat_layout" class="image_repeat_layout" id="image_repeat_layout">
					  			<?php
								$value = '';
								$options = array(
									'1'=>array('value'=>'no-repeat','title'=>'No Repeat'),
									'2'=>array('value'=>'repeat-x','title'=>'Repeat Horizontal'),
									'3'=>array('value'=>'repeat-y','title'=>'Repeat Vertical'),
									'4'=>array('value'=>'repeat','title'=>'Repeat'),
								);
								foreach( $options as $option ){ ?>
							<option <?php if($image_repeat_layout == $option['value']){echo 'selected';}?> value="<?php echo $option['value'];?>" class="select_bg_patren"><?php echo $option['title'];?></option>
						<?php }?>
                      </select>
                    </div>
					<p> <?php _e('You can manage your image repeat whether its repeated horizontal verticle or both.','crunchpress');?> </p>
                  </li>
                </ul>
                <ul class="recipe_class image_upload_options span4">
                  
                  <li class="panel-radioimage panel-input full-width">
				  <span class="panel-title ">
                    <h3 for="image_attachment_layout">
                      <?php _e('Image Attachment', 'crunchpress'); ?>
                    </h3>
                  </span>
				  <div class="combobox cp-select-wrap">
				   <select name="image_attachment_layout" class="image_attachment_layout" id="image_attachment_layout">
						<?php 
						$value = '';
						$options = array(
							'1'=>array('value'=>'fixed','title'=>'Fixed'),
							'2'=>array('value'=>'scroll','title'=>'Scroll'),
						);
						foreach( $options as $option ){ ?>
							<option <?php if($image_attachment_layout == $option['value']){echo 'selected';}?> value="<?php echo $option['value'];?>" class="image_attachment_layout"><?php echo $option['title'];?></option>                   
						<?php } ?>
					</select>
					</div>
					<p> <?php _e('You can manage your background image attachment fixed or scroll.','crunchpress');?> </p>
                  </li>
				 
                </ul>
				</div>
              </li>
              <li id="hr_settings" class="logo_dimenstion">
				<div class="row-fluid">
					<ul class="panel-body recipe_class span6">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php _e('TOP CONTACT US FIELD', 'crunchpress'); ?>
								</h3>
							</span>
							<textarea name="contact_us_code" id="contact_us_code" ><?php echo ($contact_us_code == '')? esc_textarea($contact_us_code): esc_textarea($contact_us_code);?></textarea>
							<p><?php _e('Please add html or shortcodes for top contact us links.','crunchpress');?></p>
						</li>				 
					</ul>
					<ul class="panel-body recipe_class span6">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php _e('ADD BANNER CODE', 'crunchpress'); ?>
								</h3>
							</span>
							<textarea name="countd_event_category" id="countd_event_category" ><?php echo ($countd_event_category == '')? esc_textarea($countd_event_category): esc_textarea($countd_event_category);?></textarea>
							<p><?php _e('Please write CSS/HTML code for you theme if you want to put some extra code in css for styling purpose only.','crunchpress');?></p>
						</li>				 
					</ul>
				</div>	
				<div class="row-fluid">
					<ul class="panel-body recipe_class span6">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="header_css_code" >
									<?php _e('HEADER CODE', 'crunchpress'); ?>
								</h3>
							</span>
							<textarea name="header_css_code" id="header_css_code" ><?php echo ($header_css_code == '')? esc_textarea($header_css_code): esc_textarea($header_css_code);?></textarea>
							<p><?php _e('Please write css code for you theme if you want to put some extra code in css for styling purpose only.','crunchpress');?></p>
						</li>				 
					</ul>
					<ul class="panel-body recipe_class span6">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="google_webmaster_code" >
									<?php _e('GOOGLE WEBMASTER VERIFY CODE', 'crunchpress'); ?>
								</h3>
							</span>
							<textarea name="google_webmaster_code" id="google_webmaster_code" ><?php if($google_webmaster_code <> '') { echo esc_textarea($google_webmaster_code);}?></textarea>
							<p><?php _e('Please paste google, Bing, yahoo etc analytics code here to validate your site in webmaster.','crunchpress');?></p>
						</li> 
					</ul>    
				</div>
				<div class="row-fluid">
					<ul class="panel-body recipe_class span6">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 >
									<?php _e('TOP BAR', 'crunchpress'); ?>
								</h3>
							</span>
							<label for="topbutton_icon">
								<div class="checkbox-switch <?php echo ($topbutton_icon=='enable' || ($topbutton_icon=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; ?>"></div>
							</label>
							<input type="checkbox" name="topbutton_icon" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="topbutton_icon" id="topbutton_icon" class="checkbox-switch" value="enable" 
							<?php echo ($topbutton_icon=='enable' || ($topbutton_icon=='' && empty($default)))? 'checked': ''; ?>>
							<!--<p><?php _e('You can turn On/Off Top Bar. Note: Turning it off Search and Top Social Networking Icons will be activated.','crunchpress');?></p>-->
							<p><?php _e('You can turn On/Off Top Bar.','crunchpress');?></p>
						</li>
					</ul>
					<!--<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 >
									<?php _e('TOP CART', 'crunchpress'); ?>
								</h3>
							</span>
							<label for="topcart_icon">
								<div class="checkbox-switch <?php echo ($topcart_icon=='enable' || ($topcart_icon=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; ?>"></div>
							</label>
							<input type="checkbox" name="topcart_icon" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="topcart_icon" id="topcart_icon" class="checkbox-switch" value="enable" 
							<?php echo ($topcart_icon=='enable' || ($topcart_icon=='' && empty($default)))? 'checked': ''; ?>>
							<p><?php _e('Do you want to turn on cart button?.','crunchpress');?></p>
						</li>
					</ul>-->
					<ul class="panel-body recipe_class span6">
					  <li class="panel-input full-width">
						<span class="panel-title">
							<h3 for="" >
								<?php _e('TOP SOCIAL NETWORK ICONS', 'crunchpress'); ?>
							</h3>
						</span>
						<label for="topsocial_icon">
							<div class="checkbox-switch <?php echo ($topsocial_icon=='enable' || ($topsocial_icon=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
						</label>
						<input type="checkbox" name="topsocial_icon" class="checkbox-switch" value="disable" checked>
						<input type="checkbox" name="topsocial_icon" id="topsocial_icon" class="checkbox-switch" value="enable" <?php echo ($topsocial_icon=='enable' || ($topsocial_icon=='' && empty($default)))? 'checked': ''; ?>>
						<p><?php _e('You can turn On/Off Top social network icons from main menu.','crunchpress');?></p>
					  </li>
					</ul>
				</div>
              </li>
            <li id="ft_settings" class="logo_dimenstion">				
				<div class="row-fluid">
					<ul class="panel-body recipe_class span6">
					  <li class="panel-input full-width">
					  <span class="panel-title">
						<h3 for="" >
						  <?php _e('SOCIAL ICONS', 'crunchpress'); ?>
						</h3>
					  </span>
						<label for="social_networking">
						<div class="checkbox-switch <?php
									
									echo ($social_networking=='enable' || ($social_networking=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

								?>"></div>
						</label>
						<input type="checkbox" name="social_networking" class="checkbox-switch" value="disable" checked>
						<input type="checkbox" name="social_networking" id="social_networking" class="checkbox-switch" value="enable" <?php 
									
									echo ($social_networking=='enable' || ($social_networking=='' && empty($default)))? 'checked': ''; 
								
								?>>
								<div class="clear"></div>
							<p> <?php _e('You can turn On/Off footer social networking profile icons.','crunchpress');?></p>
					  </li>
					</ul>
					<ul class="panel-body recipe_class span6">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="copyright_code" >
									<?php _e('COPY RIGHT TEXT', 'crunchpress'); ?>
								</h3>
							</span>
							<input type="text" name="copyright_code" id="copyright_code" value="<?php echo ($copyright_code == '')? esc_html($copyright_code): esc_html($copyright_code);?>" />
							<div class="clear"></div>
							<p><?php _e('Please paste here your copy right text.','crunchpress');?></p>
						</li>
					</ul>
				</div>
				<div class="row-fluid">
					<ul class="recipe_class span4">
						<li class="panel-radioimage panel-input full-width">
							<span class="panel-title">
								<h3 for="">
								  <?php _e('FOOTER WIDGET LAYOUT', 'crunchpress'); ?>
								</h3>
							</span>
							<?php 
								$value = '';
								$options = array(
								'1'=>array('value'=>'footer-style1','image'=>'/framework/images/footer-style1.png'),
								'6'=>array('value'=>'footer-style6','image'=>'/framework/images/footer-style6.png'),
								);
								foreach( $options as $option ){ ?>
							<div class='radio-image-wrapper'>
								<label for="<?php echo $option['value']; ?>">
								  <img src=<?php echo CP_PATH_URL.$option['image']?> class="footer_col_layout" alt="footer_col_layout" />
								  <div id="check-list"></div>
								</label>
								<input type="radio" name="footer_col_layout" value="<?php echo $option['value']; ?>" id="<?php echo $option['value']; ?>" class="dd"
								<?php if($footer_col_layout == $option['value']){ echo 'checked';}?>>
							</div>
							<?php } ?>
							<div class="clear"></div>
							<p> <?php _e('Please select home page layout style.','crunchpress');?></p>
						</li>
					</ul>
				</div>
            </li>
              <li id="misc_settings">
				<div class="row-fluid">
					<ul class="panel-body recipe_class span6">
					  <li class="panel-input full-width">
					   <span class="panel-title">
						<h3 for="" >
						  <?php _e('BREADCRUMBS', 'crunchpress'); ?>
						</h3>
					  </span>
						<label for="breadcrumbs">
						<div class="checkbox-switch <?php
									
									echo ($breadcrumbs=='enable' || ($breadcrumbs=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

								?>"></div>
						</label>
						<input type="checkbox" name="breadcrumbs" class="checkbox-switch" value="disable" checked>
						<input type="checkbox" name="breadcrumbs" id="breadcrumbs" class="checkbox-switch" value="enable" <?php 
									
									if($breadcrumbs=='enable' ){echo '';} echo ($breadcrumbs=='enable' || ($breadcrumbs=='' && empty($default)))? 'checked': ''; 
								
								?>>
						<p> <?php _e('You can turn On/Off BreadCrumbs from Top of the page.','crunchpress');?></p>
					  </li>
					  
					</ul>
					<ul class="panel-body recipe_class span6">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="rtl_layout" >
									<?php _e('RTL LAYOUTS', 'crunchpress'); ?>
								</h3>
							</span>
							<label for="rtl_layout">
								<div class="checkbox-switch <?php echo ($rtl_layout=='enable' || ($rtl_layout=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
							</label>
							<input type="checkbox" name="rtl_layout" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="rtl_layout" id="rtl_layout" class="checkbox-switch" value="enable" <?php echo ($rtl_layout=='enable' || ($rtl_layout=='' && empty($default)))? 'checked': '';?>>
							<p> <?php _e('You can turn On/Off RTL Layout of website.','crunchpress');?> </p>
						</li>
					</ul>
					<!--<ul class="panel-body recipe_class span3">
					  
					  <li class="panel-input full-width">
					  <span class="panel-title">
						<h3 for="site_loader" >
						  <?php _e('TURN ON/OFF LOADER', 'crunchpress'); ?>
						</h3>
					  </span>
						<label for="site_loader">
						<div class="checkbox-switch <?php
									
									echo ($site_loader=='enable' || ($site_loader=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

								?>"></div>
						</label>
						<input type="checkbox" name="site_loader" class="checkbox-switch" value="disable" checked>
						<input type="checkbox" name="site_loader" id="site_loader" class="checkbox-switch" value="enable" <?php 
									
									echo ($site_loader=='enable' || ($site_loader=='' && empty($default)))? 'checked': ''; 
								
								?>>
								<p> <?php _e('You can turn On/Off site Loader of website.','crunchpress');?></p>
					  </li>
					  
					</ul>
					<ul class="panel-body recipe_class span3">
					  
					  <li class="panel-input full-width">
					  <span class="panel-title">
						<h3 for="element_loader" >
						  <?php _e('TURN ON/OFF ELEMENT LOAD ON SCROLL', 'crunchpress'); ?>
						</h3>
					  </span>
						<label for="element_loader">
						<div class="checkbox-switch <?php
									
									echo ($element_loader=='enable' || ($element_loader=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

								?>"></div>
						</label>
						<input type="checkbox" name="element_loader" class="checkbox-switch" value="disable" checked>
						<input type="checkbox" name="element_loader" id="element_loader" class="checkbox-switch" value="enable" <?php 
									
									echo ($element_loader=='enable' || ($element_loader=='' && empty($default)))? 'checked': ''; 
								
								?>>
								<p><?php _e('You can turn On/Off element Loader of website.','crunchpress');?></p>
					  </li>
					  
					</ul>-->
				</div>
              </li>
			  <li id="maintenance_mode_settings">
				<div class="row-fluid">
					<ul class="panel-body recipe_class span3">
						<li class="panel-input full-width">
						   <span class="panel-title">
							<h3 for="" >
							  <?php _e('Maintenance Mode', 'crunchpress'); ?>
							</h3>
						  </span>
							<label for="maintenance_mode">
							<div class="checkbox-switch <?php
										
										echo ($maintenance_mode=='enable' || ($maintenance_mode=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

									?>"></div>
							</label>
							<input type="checkbox" name="maintenance_mode" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="maintenance_mode" id="maintenance_mode" class="checkbox-switch" value="enable" 
							<?php if($maintenance_mode=='enable' ){echo '';} echo ($maintenance_mode=='enable' || ($maintenance_mode=='' && empty($default)))? 'checked': ''; ?>>
							<p><?php _e('You can turn On/Off Maintenance mode from here.','crunchpress');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span3">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php _e('Maintenance Title', 'crunchpress'); ?>
								</h3>
							</span>
							<input type="text" name="maintenace_title" id="maintenace_title" value="<?php echo ($maintenace_title == '')? esc_html($maintenace_title): esc_html($maintenace_title);?>" />
							<div class="clear"></div>
							<p><?php _e('Please add title on maintenance page.','crunchpress');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span3">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php _e('Countdown Time', 'crunchpress'); ?>
								</h3>
							</span>
							<input type="text" name="countdown_time" id="countdown_time" value="<?php echo ($countdown_time == '')? esc_html($countdown_time): esc_html($countdown_time);?>" />
							<div class="clear"></div>
							<p><?php _e('Please select time span when your site will be live and counter will countdown seconds to mints and days till that on maintenance page.','crunchpress');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span3">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php _e('Email', 'crunchpress'); ?>
								</h3>
							</span>
							<input type="text" name="email_mainte" id="email_mainte" value="<?php echo ($email_mainte == '')? esc_html($email_mainte): esc_html($email_mainte);?>" />
							<div class="clear"></div>
							<p><?php _e('Add email where you want to post subscriptions.','crunchpress');?></p>
						</li>
					</ul>
				</div>
				<div class="row-fluid">
					<ul class="panel-body recipe_class span8">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="mainte_description" >
									<?php _e('Description', 'crunchpress'); ?>
								</h3>
							</span>
							<textarea name="mainte_description" id="mainte_description" ><?php if($mainte_description <> '') { echo esc_textarea($mainte_description);}?></textarea>
							<p><?php _e('Please add description text for your website maintenance.','crunchpress');?></p>
						</li> 
					</ul>    
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
						   <span class="panel-title">
							<h3 for="" >
							  <?php _e('Social Icons', 'crunchpress'); ?>
							</h3>
						  </span>
							<label for="social_icons_mainte">
							<div class="checkbox-switch <?php
										
										echo ($social_icons_mainte=='enable' || ($social_icons_mainte=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

									?>"></div>
							</label>
							<input type="checkbox" name="social_icons_mainte" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="social_icons_mainte" id="social_icons_mainte" class="checkbox-switch" value="enable" 
							<?php if($social_icons_mainte=='enable' ){echo '';} echo ($social_icons_mainte=='enable' || ($social_icons_mainte=='' && empty($default)))? 'checked': ''; ?>>
							<p><?php _e('You can turn On/Off Maintenance mode social icons that are showing at bottom of page.','crunchpress');?></p>
						</li>
					</ul>
				</div>	
              </li>
              <?php if(!class_exists( 'Envato_WordPress_Theme_Upgrader' )){}else{?>
              <li id="envato_api" class="envato_api">
                <ul class="panel-body recipe_class">
                 
                  <li class="panel-input">
					   <span class="panel-title">
						<h3 for="tf_username" >
						  <?php _e('Username', 'crunchpress'); ?>
						</h3>
					  </span>
                    <input type="text" name="tf_username" id="tf_username" value="<?php echo ($tf_username == '')? esc_html($tf_username): esc_html($tf_username);?>" />
					<span><?php _e('Please enter your Theme Forest username.','crunchpress');?>  <br />
                    <p><?php _e('For example: denonstudio','crunchpress');?>  </p></span>
                  </li>
                  
                </ul>
                <ul class="panel-body recipe_class">
                  
                  <li class="panel-input">
				  <span class="panel-title">
                    <h3 for="tf_sec_api" >
                      <?php _e('API Key', 'crunchpress'); ?>
                    </h3>
                  </span>
                    <input type="text" name="tf_sec_api" id="tf_sec_api" value="<?php echo ($tf_sec_api == '')? esc_html($tf_sec_api): esc_html($tf_sec_api);?>" />
                  </li>
                  <span class="right-box-sec"> <?php _e('Please paste here your theme forest Secret API Key.','crunchpress');?>  <br />
                     <p><?php _e('For example: xxxxxxxav7hny3p1ptm7xxxxxxxx','crunchpress');?> <p></span>
                </ul>
              </li>
              <?php }?>
            </ul>
            <div class="clear"></div>
            <div class="panel-element-tail">
              <div class="tail-save-changes">
                <div class="loading-save-changes"></div>
                <input type="submit" value="<?php echo __('Save Changes','crunchpress') ?>">
                <input type="hidden" name="action" value="general_options">
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
