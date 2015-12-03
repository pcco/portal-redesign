<?php
/*	
*	CrunchPress Shortcodes
*	---------------------------------------------------------------------
* 	@version	1.0
*   @ Package   Shortcode
* 	@author		CrunchPress
* 	@link		http://crunchpress.com
* 	@copyright	Copyright (c) CrunchPress
*	---------------------------------------------------------------------
*	This file manage to embed the shortcodes to each page
*	based on the content of that page.
*	---------------------------------------------------------------------
*/
	
	//Call Script only at Frontend
	if(!is_admin()){
		add_action('wp_enqueue_scripts','register_short_code');
	}
	
	function register_short_code(){
		//Calling the Css File for Shortcodes
		wp_enqueue_style('cp-shortcode',CP_PATH_URL.'/frontend/shortcodes/shortcode.css');
	}
	
	//add_shortcode('frame', 'cp_frame_shortcode');
	add_shortcode('alert', 'cp_message_box_shortcode');
	
	add_shortcode('toggle_box', 'cp_toggle_box_shortcode');
	add_shortcode('toggle_item', 'cp_toggle_item_shortcode');
	
	add_shortcode('tab', 'cp_tab_shortcode');
	add_shortcode('tab_item', 'cp_tab_item_shortcode');
	
	
	add_shortcode('backtop', 'cp_divider_shortcode');
	
	add_shortcode('heading', 'cp_heading_shortcode');
	
	//add_shortcode('font-awesome', 'cp_button_fontawesome');
	add_shortcode('list', 'cp_list_shortcode');
	add_shortcode('social', 'cp_social_shortcode');
	add_shortcode('code', 'cp_code_shortcode');
	add_shortcode('slider', 'cp_slider_shortcode');			
	add_shortcode('slide', 'cp_slide_shortcode');			
	add_shortcode('column', 'cp_column_shortcode');
	add_shortcode('acc_item', 'cp_acc_item_shortcode');
	add_shortcode('accordion', 'cp_accordion_shortcode');
	add_shortcode('dropcap', 'cp_dropcap_shortcode');
	add_shortcode('quote', 'cp_quote_shortcode');
	add_shortcode('youtube', 'cp_youtube_shortcode');
	add_shortcode('vimeo', 'cp_vimeo_shortcode');
	add_shortcode('sidebar', 'cp_widget_bar_shortcode');
	add_shortcode('map', 'cp_map_shortcode');
	add_shortcode('person', 'cp_person_shortcode');
	add_shortcode('testimonials', 'cp_testimonials_shortcode');
	add_shortcode('testimonial', 'cp_testi_shortcode');
	add_shortcode('counter_circle', 'cp_progress_shortcode');
	add_shortcode('progress_bar', 'cp_progress_bar_shortcode');			
	add_shortcode('blog', 'cp_blog_shortcode');
	add_shortcode('fullwidth', 'cp_fullwidth_shortcode');
	add_shortcode('flexslider', 'cp_flexslider_shortcode');
	
	add_shortcode('lightbox', 'cp_lightbox_shortcode');
	add_shortcode('3dbutton', 'cp_3dbutton_shortcode');			
	add_shortcode('soundcloud', 'cp_soundcloud_shortcode');		
	add_shortcode('content_box', 'cp_content_box_shortcode');	
	add_shortcode('pricing_table', 'cp_pricing_table_shortcode');
	add_shortcode('pricing_header', 'cp_pricing_header_shortcode');
	add_shortcode('pricing_price', 'cp_pricing_price_shortcode');
	add_shortcode('pricing_column', 'cp_pricing_column_shortcode');
	add_shortcode('pricing_row', 'cp_pricing_row_shortcode');
	add_shortcode('pricing_footer', 'cp_pricing_footer_shortcode');
	add_shortcode('title', 'cp_title_shortcode');
	add_shortcode('button', 'cp_buttons_shortcode');
	add_shortcode('metro_button', 'cp_metro_shortcode');
	add_shortcode('counters_circle', 'cp_counters_circle_shortcode');
	add_shortcode('iconset', 'cp_iconset_shortcode');
	add_shortcode('services', 'cp_services_shortcode');
	add_shortcode('imageframe', 'cp_imageframe_shortcode');
	add_shortcode('separator', 'cp_separator_shortcode');
	add_shortcode('tooltip', 'cp_tooltip_shortcode');
	add_shortcode('recent_projects', 'cp_recent_projects_shortcode');
	add_shortcode('products_slider', 'cp_products_slider_shortcode');			
	add_shortcode('images', 'cp_images_shortcode');
	add_shortcode('fontawesome', 'cp_fontawesome_shortcode');
	add_shortcode('text', 'cp_text_shortcode');
	add_shortcode('highlight', 'cp_highlight_shortcode');
	add_shortcode('event_counter', 'cp_event_counter_shortcode');
	add_shortcode('event_counter_box', 'cp_event_counter_box_shortcode');
	
	add_shortcode('checklist', 'cp_checklist_shortcode');
	add_shortcode('recent_posts', 'cp_recent_post_shortcode');
	add_filter('the_content', 'fix_shortcodes');
	
	
	
	function fix_shortcodes($content){   
		$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
		);
		$content = strtr($content, $array);
		return $content;
	}
	
	//Code HighLighter
	function cp_code_shortcode($atts, $content = null)
	{
	
		$hilighter = "<div class='cp-code'>";
		$hilighter = $hilighter . $content;
		$hilighter = $hilighter . "</div>";
		return $hilighter;
	}
	
	
	function cp_separator_shortcode($atts,$content = null){
		extract(shortcode_atts(array(
			'style' => '',
			'size' => '1px',
			'margin_top_bottom' => '',
			'color' => '',
			
		), $atts));
		return '<div class="cp-separator" style="clear:both;width:100%;display:inline-block;margin:'.$margin_top_bottom.' 0px;border:'.$size.' '.$style.' '.$color.'"></div>';
	}
	
	function cp_heading_shortcode($atts,$content = null){
		extract(shortcode_atts(array(
			'align' => '',
			'title' => '',
			'size' => 'h4',
			'description' => '',
			
		), $atts));
		
		$heading_html = '<div class="our-team" style="text-align:'.$align.'"><'.$size.'>'.$title.'<small>'.$description.'</small></'.$size.'></div>';
		return $heading_html;
	
	}
	
	//event counter
	function cp_event_counter_shortcode($atts,$content = null){
		$event_html = '';
		static $event_counter = 1;
		$event_counter++;
		extract(shortcode_atts(array(
			'title' => '',
			'event_id' => '',			
			'animation' => 'ticks',
			'color' => '#ffffff',
			'unfilled_color' => '#FFFFFF',
			'filled_color' => '#99CCFF',
			'width' => '500px',
			'height' => '150px',
			'circle_width_filled' => '.6',
			'circle_width_unfilled' => '0.04',
			
		), $atts));
		
	
		//Select Single Events
		if(class_exists('EM_Events')){
			wp_register_script('cp-timecircles', CP_PATH_URL.'/frontend/shortcodes/timecircles.js', false, '1.0', true);
			wp_enqueue_script('cp-timecircles');
			wp_enqueue_style('cp-timecircles',CP_PATH_URL.'/frontend/shortcodes/timecircles.css');
			$order = 'DESC';
			$limit = 5;//Default limit
			$offset = '';
			$rowno = 0;
			$event_count = 0;
			if($event_id <> ''){
				$EM_Event = em_get_event($event_id,'post_id');
				//print_r($EM_Event);
				if(isset($EM_Event)){
					$style = "";
					$today = date ( "Y-m-d" );
					//$location_summary = "<b>" . $EM_Event->get_location()->name . "</b> - " . $EM_Event->get_location()->address;
					//echo $event->start;
					$event_month_alpha = date('M',$EM_Event->start);
					$event_day = date('d',$EM_Event->start);					
					
					
					//Get Date in Parts
					$event_year = date('Y',$EM_Event->start);
					$event_month = date('m',$EM_Event->start);
					$event_month_alpha = date('M',$EM_Event->start);
					$event_day = date('d',$EM_Event->start);
					
					// $hour = date('H',$EM_Event->start_time);
					// $min = date('i',$EM_Event->start_time);
					// $sec = date('s',$EM_Event->start_time);
					$month = date('m',$EM_Event->start);
					$day = date('d',$EM_Event->start);
					$year = date('Y',$EM_Event->start);

					$start_date_time = date ( "Y-m-d", $EM_Event->start);
					
					$hour_current = date('H');
					$min_current = date('i');
					$sec_current = date('s');
					$month_current = date('m');
					$day_current = date('d');
					$year_current = date('Y');

					//$start_date_time = mktime($hour, $min, $sec, $month, $day, $year);
					
					//$current = mktime();
					if($today < $start_date_time){
						$event_html = '<div class="circle-time"><script>jQuery(document).ready(function($){  
						$("#countdown-'.$event_counter.'").TimeCircles({
							"animation": "'.$animation.'",
							
							"bg_width": "'.$circle_width_filled.'",
							"fg_width": "'.$circle_width_unfilled.'",
							text_size: 0.08,
							"circle_bg_color": "'.$unfilled_color.'",
							"time": {
								"Days": {
									"text": "'.__('Days','crunchpress').'",
									"color": "'.$filled_color.'",
									"show": true
								},
								"Hours": {					
									"text": "'.__('Hours','crunchpress').'",
									"color": "'.$filled_color.'",
									"show": true
								},
								"Minutes": {
									"text": "'.__('Minutes','crunchpress').'",
									"color": "'.$filled_color.'",
									"show": true
								},
								"Seconds": {					
									"text": "'.__('Seconds','crunchpress').'",
									"color": "'.$filled_color.'",
									"show": true
								}
							}
						}); });</script>
						<div class="event-timer">
							<div id="countdown-'.$event_counter.'" data-date="'.$year.'-'.$month.'-'.$day.' 00:00:00" style="width: '.$width.'px; height: '.$height.'px; padding: 0px; box-sizing: border-box;color:'.$color.';"></div>
						</div></div>';											
					}else{
						$event_html = '<h5>There is no upcoming event in current date to show.</h5>';
					}	
				}
			}	
		}
		
		return $event_html;
	
	}
	
	//CountDown Boxed
	function cp_event_counter_box_shortcode($atts,$content = null){
		global $counter;
		//Fetch parameters
		extract(shortcode_atts(array(
			'event_id' => '',
			
		), $atts));
		
		$event_counter_html = '';
		
		static $event_counter_box = 1;
		$event_counter_box++;
		
		$order = 'DESC';
		$limit = 5;//Default limit
		$offset = '';
		$rowno = 0;
		$event_count = 0;
		//Select Single Events
		if(class_exists('EM_Events')){
		
			$EM_Event = em_get_event($event_id,'post_id');
				$localised_start_date = date_i18n(get_option('dbem_date_format'), $EM_Event->start);
				$localised_end_date = date_i18n(get_option('dbem_date_format'), $EM_Event->end);
				
				$style = "";
				$today = date ( "Y-m-d" );
				$location_summary = "<b>" . $EM_Event->get_location()->name . "</b> - " . $EM_Event->get_location()->address;
				
				if ($EM_Event->start_date < $today && $EM_Event->end_date < $today){
					$class .= " past";
				}
				//Check pending approval events
				if ( !$EM_Event->status ){
					$class .= " pending";
				}	
				//echo $event->start;
				$event_month_alpha = date('M',$EM_Event->start);
				$event_day = date('d',$EM_Event->start);
				$event_element_id = $counter.$EM_Event->event_id;
				
				
				//Get Date in Parts
				$event_year = date('Y',$EM_Event->start);
				$event_month = date('m',$EM_Event->start);
				$event_month_alpha = date('M',$EM_Event->start);
				$event_day = date('d',$EM_Event->start);
				
				//Change time format
				$event_start_time =  date('g,i,s',strtotime($EM_Event->start_time));		

				$hour = date('H',strtotime($EM_Event->start_time));		
				$min = date('i',strtotime($EM_Event->start_time));		
				$sec = date('s',strtotime($EM_Event->start_time));		
				$month = date('m',$EM_Event->start);		
				$day = date('d',$EM_Event->start);		
				$year = date('Y',$EM_Event->start);


				$hour_end = date('H',strtotime($EM_Event->end_time));
				$min_end = date('i',strtotime($EM_Event->end_time));
				$sec_end = date('s',strtotime($EM_Event->end_time));
				$month_end = date('m',$EM_Event->end);
				$day_end = date('d',$EM_Event->end);
				$year_end = date('Y',$EM_Event->end);

				// wp_register_script('cp-countdown', CP_PATH_URL.'/frontend/shortcodes/jquery_countdown.js', false, '1.0', true);
				// wp_enqueue_script('cp-countdown'); 
				// wp_enqueue_style('cp-countdown',CP_PATH_URL.'/frontend/shortcodes/jquery_countdown.css');
				
		
				$event_counter_html = '<div class="counter-box"><script>
					jQuery(function () {
						var austDay = new Date();
						austDay = new Date('.$year.', '.$month.'-1, '.$day.','.$hour.','.$min.');
						jQuery("#countdown-box-'.$event_counter_box.'").countdown({
						labels: ["'. __('Years','crunchpress').'", "'. __("Months","crunchpress").'", "'. __("Weeks","crunchpress").'", "'. __("Days","crunchpress").'", "'. __("Hours","crunchpress").'", "'. __("Minutes","crunchpress").'", "'. __("Seconds","crunchpress").'"],
						until: austDay
						});
						jQuery("#year").text(austDay.getFullYear());
					});                
				</script>
				<div id="countdown-box-'.$event_counter_box.'" class="defaultCountdown"></div>
				</div>
				';										
		}
	
	return $event_counter_html;
	
	}
	
	//Full width shortcode start
	function cp_fullwidth_shortcode($atts,$content = null){
		//Fetch parameters
		extract(shortcode_atts(array(
			'color' => '',
			'textalign' => '',
			'backgroundcolor' => '',
			'backgroundimage' => '',
			'backgroundrepeat' => '',
			'backgroundposition' => '',
			'backgroundattachment' => '',
			'bordersize' => '',
			'bordercolor' => '',
			'paddingtop' => '',
			'paddingbottom' => '',
			
		), $atts));
		// HTML for Full width shortcode
		return '<div style="float:left;width:100%;padding-top:'.$paddingtop.';text-align:'.$textalign.';padding-bottom:'.$paddingbottom.';background-repeat:'.$backgroundrepeat.';background-color:'.$backgroundcolor.';background-image:url('.$backgroundimage.');background-attachment:'.$backgroundattachment.';background-position:'.$backgroundposition.';color:'.$color.'" class="full-width"><div class="container">'.do_shortcode($content).'</div></div>';
	
	}
	// Iconset shortcode start
	function cp_iconset_shortcode($atts,$content = null){
			//HTML Markup
			return '<div class="ic-boxes">
				'.do_shortcode($content).'
			</div>';
	}
	
	//Image Frame ShortCode Start
	function cp_imageframe_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'style' => '',
			'bordercolor' => '',
			'bordersize' => '',
			'stylecolor' => '',			
			'align' => '',
			
		), $atts));
		// HTML Markup
		return '<div style="border:" class="imageframe">'.do_shortcode($content).'</div>';
	
	}
	//Checklist ShortCode Start
	function cp_checklist_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'icon' => 'check',
			'iconcolor' => '',		
		), $atts));
				
		$icon_aw = get_fontawesome_code($icon);
		
		// Counter for checklist
		static $counter_checklist = 1;
		$counter_checklist++;		
		//HTML Markup
		return '<div class="list-style-cp-'.$counter_checklist.' list-style cp-list-style"><style scoped>.list-style-cp-'.$counter_checklist.' li:before{color:'.$iconcolor.';content:"'.$icon_aw.'"}</style>
		'.$content.'
		</div>';
	
	}
	// Services ShortCode Start
	function cp_services_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'layout' => '',
			'icon' => '',
			'title' => '',
			'excerpt_words' => '',			
			'link' => '',
			'linktext' => '',
			
		), $atts));
		//HTML Markup
		$html = '
		<div class="servic-box2 '.$layout.'">
			<div class="ic-box"><i class="fa '.$icon.'"></i></div>
			<h4>'.$title.'</h4>
			<p>'.$content.'</p>
			<a href="'.$link.'">'.$linktext.'</a>
		</div>';
		
		return $html;
	
	}
	
	//Recent Projects ShortCode Start
	function cp_recent_projects_shortcode($atts,$content = null){
		// Fetch Parameters
		extract(shortcode_atts(array(
			'layout' => '',
			'filters' => '',
			'cat_id' => 'empty',
			'number_posts' => '',
			'excerpt_words' => '',			
			
		), $atts));
		// If Empty
		if($cat_id == 'empty'){
			query_posts(array( 
				'post_type' => 'portfolio',
				'showposts' => $number_posts,
				'orderby' => 'title',
				'order' => 'ASC' )
			);
		}			
		//Counter
		static $counter_port = 1;
		$counter_port++;
		$html_port = '';
		// Js Script For Portfolio
		$html_script = '';
				$html_script = '<script type="text/javascript">
				jQuery(window).load(function() {
					var filter_container = jQuery("#portfolio-item-holder-'.$counter_port.'");

					filter_container.children().css("position","absolute");	
					filter_container.masonry({
						singleMode: true,
						itemSelector: ".portfolio-item:not(.hide)",
						animate: true,
						animationOptions:{ duration: 800, queue: false }
					});	
					jQuery(window).resize(function(){
						var temp_width =  filter_container.children().filter(":first").width() + 30;
						filter_container.masonry({
							columnWidth: temp_width,
							singleMode: true,
							itemSelector: ".portfolio-item:not(.hide)",
							animate: true,
							animationOptions:{ duration: 800, queue: false }
						});		
					});	
					jQuery("ul#portfolio-item-filter-'.$counter_port.' a").click(function(e){	

						jQuery(this).addClass("active");
						jQuery(this).parents("li").siblings().children("a").removeClass("active");
						e.preventDefault();
						
						var select_filter = jQuery(this).attr("data-value");
						
						if( select_filter == "All" || jQuery(this).parent().index() == 0 ){		
							filter_container.children().each(function(){
								if( jQuery(this).hasClass("hide") ){
									jQuery(this).removeClass("hide");
									jQuery(this).fadeIn();
								}
							});
						}else{
							filter_container.children().not("." + select_filter).each(function(){
								if( !jQuery(this).hasClass("hide") ){
									jQuery(this).addClass("hide");
									jQuery(this).fadeOut();
								}
							});
							filter_container.children("." + select_filter).each(function(){
								if( jQuery(this).hasClass("hide") ){
									jQuery(this).removeClass("hide");
									jQuery(this).fadeIn();
								}
							});
						}
						
						filter_container.masonry();	
						
					});
				});
				</script>';
			//Code Snippet for Grid
			if($layout == 'grid-with-filters'){
			wp_register_script('filterable', CP_PATH_URL.'/frontend/shortcodes/jquery-filterable.js', false, '1.0', true);
				wp_enqueue_script('filterable');
				$html_port = $html_script.'<ul id="portfolio-item-filter-'.$counter_port.'" class="category_list_filterable">
					<li><a data-value="all" class="gdl-button active">'. __("All","crunchpress").'</a></li>
					';
					$categories = get_categories( array('child_of' => $cat_id, 'taxonomy' => 'portfolio-category', 'hide_empty' => 0) );
					//$categories = get_the_terms( $post->ID, 'recipe-category' );								 
						if($categories <> ""){
							foreach($categories as $values){
							$html_port .= '<li><a data-value="'.$values->term_id.'" class="gdl-button">'.$values->name.'</a></li>';
						
							}
						}
						// Clear Div
					$html_port .= '<div class="clear"></div>
				</ul>';
				$html_port .= '
                <div class="portfolio-list">
                	<ul id="portfolio-item-holder-'.$counter_port.'" class="portfolio-row">';
				
					// If Empty
					query_posts(array( 
						'post_type' => 'portfolio',
						'showposts' => -1,
						'tax_query' => array(
							array(
								'taxonomy' => 'portfolio-category',
								'terms' => $cat_id,
								'field' => 'term_id',
							)
						),
						'orderby' => 'title',
						'order' => 'ASC' )
					);
					//Team Counter
					$counter_team = 0; 
					while( have_posts() ){
						the_post();
						global $post;
						//Fetching All Tracks from Database
						$track_name_xml = get_post_meta($post->ID, 'add_project_xml', true);
						$track_url_xml = get_post_meta($post->ID, 'add_project_field_xml', true);
						
						//Empty Variables
						//$album_download = '';
						$children = '';
						$children_title = '';

						//Track Name
						if($track_name_xml <> ''){
							$ingre_xml = new DOMDocument();
							$ingre_xml->recover = TRUE;
							$ingre_xml->loadXML($track_name_xml);
							$children_name = $ingre_xml->documentElement->childNodes;
						}		
						
						//Track URL
						if($track_url_xml <> ''){	
							$ingre_title_xml = new DOMDocument();
							$ingre_title_xml->recover = TRUE;
							$ingre_title_xml->loadXML($track_url_xml);
							$children_title = $ingre_title_xml->documentElement->childNodes;
						} 
						//Style Rule
						$port_class = '';
						if($counter_team % 4 == 0){$port_class= 'first';}else{$post_class = 'no-class';}$counter_team++;
						
						$html_port .= '<li class="all portfolio-item portfolio-item-cp alpha'; 
						$categories = get_the_terms( $post->ID, 'portfolio-category' );
						//Loop
						if($categories <> ''){
							foreach ( $categories as $category ) {
								$html_port .= ' '.$category->term_id." ";
							}
						}
						//HTML for Portfolio
						$html_port .= '">';
						$html_port .= '<div class="portfolio-wrapper">
								<div class="thumb">
									'.get_the_post_thumbnail($post->ID, array(614,614)).'
									<div class="caption">
										<h5>'.get_the_title().'</h5>
										<p>'. substr(get_the_content(),0,200).'</p>
									</div>
								</div>
								<div class="text">';
									if($track_name_xml <> '' || $track_url_xml <> ''){
										$counter = 0;
										$nofields = $ingre_xml->documentElement->childNodes->length;
										for($i=0;$i<1;$i++) { 
											$counter++;
											$html_port .= '<h5>'.$children_name->item($i)->nodeValue.'</h5>
															<p>'.$children_title->item($i)->nodeValue.'</p>';
											
										}
									}	// Permalink	
									$html_port .= '<a href="'.get_permalink().'" class="view-project">'.__('View Project','crunchpress').'</a>
								</div>
							</div>
						</li>';
					}
				$html_port .= '</ul>
				</div>';	
			}else{
			//Reset all data
			wp_reset_query();
			wp_reset_postdata();
			$span3_grid = '';
			//For Carousel
			if($layout == 'carousel'){
				wp_register_script('cp-bx-slider', CP_PATH_URL.'/frontend/shortcodes/bxslider.min.js', false, '1.0', true);
				wp_enqueue_script('cp-bx-slider');	
				wp_enqueue_style('cp-bx-slider',CP_PATH_URL.'/frontend/shortcodes/bxslider.css');
				$html_port = '<script type="text/javascript">jQuery(document).ready(function ($) { $("#slider-'.$counter_port.'").bxSlider({minSlides: 3,maxSlides: 4,  slideWidth: 285,slideMargin: 10});});</script>';
			}else if($layout == 'grid'){$span3_grid = 'span3';}
			$html_port .= '
                <div class="portfolio-list">
                	<ul id="slider-'.$counter_port.'" class="row-fluid">';
				
					// If Empty
					query_posts(array( 
						'post_type' => 'portfolio',
						'showposts' => $number_posts,
						'tax_query' => array(
							array(
								'taxonomy' => 'portfolio-category',
								'terms' => $cat_id,
								'field' => 'term_id',
							)
						),
						'orderby' => 'title',
						'order' => 'ASC' )
					);
					
					$counter_team = 0; 
					while( have_posts() ){
						the_post();
						global $post;
						//Fetching All Tracks from Database
						$track_name_xml = get_post_meta($post->ID, 'add_project_xml', true);
						$track_url_xml = get_post_meta($post->ID, 'add_project_field_xml', true);
						
						//Empty Variables
						//$album_download = '';
						$children = '';
						$children_title = '';

						//Track Name
						if($track_name_xml <> ''){
							$ingre_xml = new DOMDocument();
							$ingre_xml->recover = TRUE;
							$ingre_xml->loadXML($track_name_xml);
							$children_name = $ingre_xml->documentElement->childNodes;
						}		
						
						//Track URL
						if($track_url_xml <> ''){	
							$ingre_title_xml = new DOMDocument();
							$ingre_title_xml->recover = TRUE;
							$ingre_title_xml->loadXML($track_url_xml);
							$children_title = $ingre_title_xml->documentElement->childNodes;
						} 
						//Style Rule
						$port_class = '';
						if($counter_team % 4 == 0){$port_class= 'first';}else{$post_class = 'no-class';}$counter_team++;
						
						$html_port .= '<li class=" '.$span3_grid.' '.$port_class.' all portfolio-item item alpha'; 
						$categories = get_the_terms( $post->ID, 'portfolio-category' );
						if($categories <> ''){
							foreach ( $categories as $category ) {
								$html_port .= ' '.$category->term_id." ";
							}
						}
						//HTML Markup
						$html_port .= '">';
						$html_port .= '<div class="portfolio-wrapper">
								<div class="thumb">
									'.get_the_post_thumbnail($post->ID, array(614,614)).'
									<div class="caption">
										<h5>'.get_the_title().'</h5>
										<p>'. substr(get_the_content(),0,200).'</p>
									</div>
								</div>
								<div class="text">';
									if($track_name_xml <> '' || $track_url_xml <> ''){
										$counter = 0;
										$nofields = $ingre_xml->documentElement->childNodes->length;
										for($i=0;$i<1;$i++) { 
											$counter++;
											$html_port .= '<h5>'.$children_name->item($i)->nodeValue.'</h5>
															<p>'.$children_title->item($i)->nodeValue.'</p>';
											
										}
									}	// Permalink	
									$html_port .= '<a href="'.get_permalink().'" class="view-project">'.__('View Project','crunchpress').'</a>
								</div>
							</div>
						</li>';
					}
				$html_port .= '</ul>
				</div>';	
			}
			//Reset Query and all Data
		wp_reset_query();
		wp_reset_postdata();
		
		return $html_port;
	}
	//Product Slider ShortCode Start
	function cp_products_slider_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'cat_id' => '',
			'number_posts' => '',			
			'show_price' => '',
			'show_buttons' => '',			
			
		), $atts));
		//Counter For Product
		static $counter_product = 1;
		$counter_product++;
		//Calling Required Files
		wp_register_script('cp-bx-slider', CP_PATH_URL.'/frontend/shortcodes/bxslider.min.js', false, '1.0', true);
		wp_enqueue_script('cp-bx-slider');	
		wp_enqueue_style('cp-bx-slider',CP_PATH_URL.'/frontend/shortcodes/bxslider.css');
		$html_product = '<script type="text/javascript">jQuery(document).ready(function ($) { $("#product-'.$counter_product.'").bxSlider({minSlides: 3,maxSlides: 4,  slideWidth: 285,slideMargin: 10});});</script>';
		// HTML Markup
		$html_product .= '<section class="product_view" id="product_grid">  
						<ul id="product-'.$counter_product.'" class="row-fluid grid-list-view product_image_holder grid-style">';
                
			// If Empty
			query_posts(array( 
				'post_type' => 'product',
				'showposts' => $number_posts,
				'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'terms' => $cat_id,
						'field' => 'term_id',
					)
				),
				'orderby' => 'title',
				'order' => 'ASC' )
			);
			//Team Counter
			$counter_team = 0; 
			while( have_posts() ){
				the_post();
				global $post;
				//Permalink Structure
					global $post,$post_id,$product,$product_url,$woocommerce;
					$permalink_structure = get_option('permalink_structure');
					if($permalink_structure <> ''){
						$permalink_structure = '?';
					}else{
						$permalink_structure = '&';
					}// Pricing Structure
					$regular_price = get_post_meta($post->ID, '_regular_price', true);
					if($regular_price == ''){
						$regular_price = get_post_meta($post->ID, '_max_variation_regular_price', true);
					}
					$sale_price = get_post_meta($post->ID, '_sale_price', true);
					$sku_num = get_post_meta($post->ID, '_sku', true);
					
					if($sale_price == ''){
						$sale_price = get_post_meta($post->ID, '_min_variation_sale_price', true);
					}
					$currency = get_woocommerce_currency_symbol();
					//Show Buttons
					if($show_buttons == 'yes'){
						$show_button = '
						<a href="#" class="basket"><form enctype="multipart/form-data" method="post" class="cart" action="'.get_permalink().$permalink_structure.'add-to-cart='.$post->ID.'">
							<!--<div class="quantity buttons_added"><input type="button" class="minus" value="-">
							<input type="number" class="input-text qty text" title="Qty" value="1" name="quantity" step="1">
							<input type="button" class="plus" value="+"></div>-->
							<button class="add_to_cart_button button product_type_simple added" data-quantity="1" data-product_sku="'.$sku_num.'" data-product_id="'.$post->ID.'" type="submit">'. __("Add to cart","crunchpress").'</button>
						</form>
						</a>
						<a href="'.get_permalink().'" class="wishlist">'.__('Read More','crunchpress').'</a>';
					}else{
						$show_button = '';
					}
					
					//Show price
					if($show_price == 'yes'){
						$show_price_html = '<h4>'. __("Price:","crunchpress").' '.$currency . $regular_price.'</h4>';
					}else{
						$show_price_html = '';
					}
				//HTML Markup For Products
				$html_product .= '<li id="product-'.$post->ID.'" class="span3 first item">
					<figure>
						'.get_the_post_thumbnail($post_id, array(504,504)).'
						'.$show_button.'
					</figure>
					<div class="text">
						<h3>'.get_the_title().'</h3>
						'.$show_price_html.'
					</div>
				</li>';
			}
		$html_product .= '</ul>
		</div>';
			//Reset Query and Post All Data
		wp_reset_query();
		wp_reset_postdata();
		return $html_product;
	
	}
	
	//FontAwesome ShortCode Start
	function cp_fontawesome_shortcode($atts,$content = null){
		//Counter
		static $counter_font_awesome = 1;
		$counter_font_awesome++;
		$html = '';
		$circle = '';
		//Fetch Parameters
		extract(shortcode_atts(array(
			'icon' => '',
			'circle' => '',			
			'iconcolor' => '',
			'circlecolor' => '',
			'circlebordercolor' => '',
			
		), $atts));
		$no_circle_box = '';
		//Empty check Conditions
		if($circlebordercolor == ''){$circlebordercolor = 'transparent';}
		if($circlecolor == ''){$circlecolor = 'transparent';}
		if($circle == 'yes'){$circle = 'border-radius:100%;';}else if($circle == 'no'){$circle = 'border-radius:0';}else{$circle = 'border-radius:0';$no_circle_box = 'yes';}
		//if not empty
		if($icon <> ''){
			$html .= '<div class="cp-fontaw-con">';
			if($no_circle_box <> 'yes'){
				$html .= '<style scoped>.cp-color-fontaw-'.$counter_font_awesome.' i{'.$circle.';border-color:'.$circlebordercolor.';background-color:'.$circlecolor.';color:'.$iconcolor.';}</style>';
				$icon_class = 'ic-circle';
			}else{
				$icon_class = '';
				$html .= '';
			}
			$html .= '<span class="cp-color-fontaw-'.$counter_font_awesome.'"><i class="fa  '.$icon_class.' '.$icon.'"></i></span>';
			$html .= '</div>';
		}
		//HTML Markup End
		return $html;
	
	}
	//Text ShortCode Start
	function cp_text_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'align' => '',
		), $atts));
			//HTML Markup
			$html = '';
			$html .= '<p class="cp-paragraph" style="text-align:'.$align.'">';
			$html .= do_shortcode($content);
			$html .= '</p>';
		
		return $html;
	
	}	
	
	//Simple Buttons
	function cp_buttons_shortcode($atts,$content = null){
		//Counter Button
		static $counter_brn = 1;
		$counter_brn++;
		//Fetch Parameters
		extract(shortcode_atts(array(
			'icon' => '',
			'size' => '',
			'backgroundcolor' => '',
			'color' => '',			
			'link' => '',

		), $atts));
		//HTML Markup
		return '
		<div class="btn-container">
		<style scoped>.cp-color-'.$counter_brn.'{background-color:'.$backgroundcolor.';color:'.$color.';}</style>
		<a href="'.$link.'" class="cp-btn-normal '.$size.' cp-color-'.$counter_brn.'"><i class="fa '.$icon.'"></i>'.do_shortcode($content).'</a></div>';
	
	}
	
	//Team Shortcode
	function cp_person_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'type' => 'default',
			'name' => '',
			'picture' => '',
			'title' => '',
			'facebook' => '',
			'twitter' => '',
			'linkedin' => '',
			'dribbble' => '',
			'link' => '',
			
		), $atts));
		//HTML Markup
		$html_team = '';
		
		$facebook = '<li><a href="'.$facebook.'"><i class="fa fa-facebook"></i></a></li>';
		$twitter = '<li><a href="'.$twitter.'"><i class="fa fa-twitter"></i></a></li>';
		$linkedin = '<li><a href="'.$linkedin.'"><i class="fa fa-google-plus"></i></a></li>';
		$dribbble = '<li><a href="'.$dribbble.'"><i class="fa fa-dribbble"></i></a></li>';
		//Default Check Condition
		if($type == 'default'){
			//HTML Markup For Default
			$html_team =  '
			<div class="team-members '.$type.'">
				<div class="thumb">
					<a href="'.$link.'"><img alt="" src="'.$picture.'"><i class="fa fa-plus-circle"></i></a>
				</div>
				<div class="text">
					<h4>'.$name.'</h4>
					<p>'.$title.'</p>
					<ul class="social">
						'.$facebook.$twitter.$linkedin.$dribbble.'
					</ul>
					<p>'.$content.'</p>
				</div>
			</div>';
		}else{
		//Team Boxed And Team Circled
			$html_team =  '
			<div class="'.$type.'">
				<div class="cp-thumb">
					<a href="'.$link.'">
						<img alt="'.$title.'" src="'.$picture.'">
					</a>
				</div>
				<div class="cp-social-icons">
					<ul>
						'.$facebook.$twitter.$linkedin.$dribbble.'
					</ul>
				</div>
				<div class="cp-text">
						<h4>'.$name.'</h4>
						<p>'.$title.'</p>
						<p>'.$content.'</p>
				</div>
			</div>';
		}
		
		return $html_team;
	}
	
	//Pricing Table ShortCode Start
	function cp_pricing_table_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(			
			'backgroundcolor' => '',
			'bordercolor' => '',
			'dividercolor' => '',
			
		), $atts));	
		static $counter_price = 1;
		$counter_price++;
		//HTML Markup
		return '<style scoped>#pricing-'.$counter_price.' .price-table{background-color:'.$backgroundcolor.'}#pricing-'.$counter_price.' .price-table .table-body ul li a{border-color:'.$dividercolor.'}#pricing-'.$counter_price.' .price-table .cp_price_table{border:1px solid '.$bordercolor.'}</style><div class="pricing"><div id="price-table" class="price-table">'.do_shortcode($content).'</div></div>';
	
	}
	
	//Pricing Table Column ShortCode Start
	function cp_pricing_header_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'title' => '',	
			// 'currency' => '',
			// 'price' => '',			
			// 'time' => '',
		), $atts));
		//HTML Markup
		return '<div class="cp_price_table"><div class="table-header">
			<div class="pull-left">
				<h3>'.$title.'</h3>
			</div>'.do_shortcode($content).'</div>';
	}
	
	//Pricing Table Price ShortCode Start
	function cp_pricing_price_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'currency' => '',
			'price' => '',
			'time' => '',			
		), $atts));
		//HTML Markup
		return '<div class="pull-right">
				<h2>'.$currency.$price.'<span>/'.$time.'</span></h2>
			</div>';
	}
	
	//Pricing Table Col Start
	function cp_pricing_column_shortcode($atts,$content = null){
		return '<div class="table-body"><ul>'.do_shortcode($content).'</ul></div></div>';
	}
	
	//Pricing Table Row start
	function cp_pricing_row_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'link' => '',			
		), $atts));
		return '<li class="cp-table-row"><a href="'.$link.'">'.do_shortcode($content).'</a></li>';
	}
	
	//Pricing Table Footer Shortcode
	function cp_pricing_footer_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'link' => '',
		), $atts));
		//HTML Markup
		return '<a class="btn-style" href="'.$link.'">'.do_shortcode($content).'</a>';
	}
	
	
	//Testimonials ShortCode Start
	function cp_testimonials_shortcode($atts,$content = null){
		//Counter
		static $counter_testimonial = 1;
		$counter_testimonial++;
		$html_testimonial = '';
		//Calling Required Files
		wp_register_script('cp-bx-slider', CP_PATH_URL.'/frontend/shortcodes/bxslider.min.js', false, '1.0', true);
		wp_enqueue_script('cp-bx-slider');	
		wp_enqueue_style('cp-bx-slider',CP_PATH_URL.'/frontend/shortcodes/bxslider.css');
		//Js Script and HTML Markup
		$html_testimonial .= '<script type="text/javascript">jQuery(document).ready(function($){$("#test_slider'.$counter_testimonial.'").bxSlider({mode: "fade",hideControlOnEnd: true,easing: "swing",auto: "auto"});});</script>';
		$html_testimonial .= '<div class="faq-testimonials">
			<ul id="test_slider'.$counter_testimonial.'" class="">
				'.do_shortcode($content).'
			</ul>
		</div>';
		
		return $html_testimonial;
	
	}
	
	//Single Testimonial ShortCode Start
	function cp_testi_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'type' => '',
			'backgroundcolor' => '',
			'name' => '',
			'picture' => '',
			'company' => '',
			'link' => '',
			'target' => '',
			
		), $atts));
		//HTML Markup  For Default
		$html_testi = '';
		if($type == 'default'){
			$picture = '<div class="thumb">
					<a href="'.$link.'"><img src="'.$picture.'" alt="'.$name.'"></a>
				</div>';
			$html_testi .= '<div class="faq-testimonials"><div>
				'.$picture.'
				<div class="text">
					<i class="fa fa-quote-left"></i>
					<p>'.do_shortcode($content).'</p>
					<a target="'.$target.'" href="'.$link.'">'.$name.'<small>'.$company.'</small></a>
				</div>
				
			</div></div>';
			//HTML Markup For Custom Style
		}else if($type == 'custom-style'){
			$html_testi .= '<div class="client-style-1">
				<div class="cp-text" style="background-color:'.$backgroundcolor.'">
					<p>'.do_shortcode($content).'</p>
				</div>
				<div class="cp-profile">
					<div class="cp-thumb"><img src="'.$picture.'" alt="'.$name.'"></div>
					<h5>'.$name.'</h5>
					<p>'.$company.'</p>
				</div>
			</div>';
			//HTML For Thumbnail
		}else{
			$picture = '<div class="thumb"><a href="'.$link.'"><img src="'.$picture.'" alt="'.$name.'"></a></div>';
			$html_testi .= ' <li>
				'.$picture.'
				<div class="text">
					<i class="fa fa-quote-left"></i>
					<p>'.do_shortcode($content).'</p>
					<a target="'.$target.'" href="'.$link.'">'.$name.'<small>'.$company.'</small></a>
				</div>
				
			</li>';
		}
		return $html_testi;
	
	}
	
	//Recent Post Shortcode Start
	function cp_recent_post_shortcode($atts,$content = null){
		
		if(empty($paged)){
			$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
		}
		
		$html = '';
		//Fetch Parameters
		extract(shortcode_atts(array(
			'layout' => '',
			'columns' => '',
			'number_posts' => '',
			'cat_id' => '',
			'thumbnail' => '',
			'title' => '',
			'post_meta' => '',
			'excerpt' => '',
			'excerpt_words' => '',
			
		), $atts));
		//layout Selection
		if($columns == '1-4'){$post_wrapper = 'row-fluid';}
		$recent_html = '<div class="cp-post '.$post_wrapper.'">';
		
		// If Empty
		query_posts(array( 
			'post_type' => 'post',
			'paged' => $paged,
			'posts_per_page' => $number_posts,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'terms' => $cat_id,
					'field' => 'term_id',
				)
			),
			'orderby' => 'title',
			'order' => 'DESC' )
		);
		$thumbnail_html = '';
		$counter_post = 0;
		while( have_posts() ){
			the_post();
			global $post,$post_id;
			//Post Variables
			$popular_post = get_post_meta($post->ID,'popular_post_views_count',true);
			if($post_id <> ''){
				//$cp_post_class = get_post_class( 'aa', $post_id )[4];
			}
			if($popular_post <> ''){ $popular_post_html = '<li><a href="'.get_permalink().'"><i class="fa fa-heart"></i> '.$popular_post.'</a></li>';}
			//if thumbnail exists
			if($thumbnail == 'yes'){$thumbnail_html = get_the_post_thumbnail($post->ID, array(614,614));$thumbnail_size = get_the_post_thumbnail($post->ID, array(1170,350));}
			if($excerpt == 'yes'){$excerpt_html = strip_tags(substr(get_the_content(),0,$excerpt_words));}
			if($meta == 'yes'){
				$meta_html = '<div class="cp-comments-area">
					<div class="row-fluid">
						<div class="span8">
							<ul class="cp-categories">';
								$variable_category = wp_get_post_terms( $post->ID, 'category');
								$counterr = 0;
								//Loop 
								foreach($variable_category as $values){
									if($counterr == 0){$meta_html .= '<li>Category:  </li>';}
									$counterr++;
									$meta_html .= '<li><a href="'.get_term_link(intval($values->term_id),'category').'">'.$values->name.'</a></li>';
								}
								$meta_html .= '
							</ul>
							
							<ul class="cp-post-detail">
								<li><a href="'.get_permalink().'"><i class="fa fa-clock-o"></i> '.get_the_date().'</a></li>
								'.$popular_post_html.'
							</ul>
						</div>
						<div class="span4">
							<div class="type-icon post-type-bar"><i class="fa fa-file-text-o"></i></div>
						</div>
					</div>
				</div>';
			}
			//Layout Selection Condition For Post
			if($columns == '1-1'){
				//Layout of post
				if($layout == 'default'){
				$recent_html .= '
				<div class="cp-post-type '.$cp_post_class.' '.$layout.'">
					<figure>'.$thumbnail_size.'</figure>
					<div class="cp-post-desc">
						<h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2>
						'.$meta_html.'
						<div class="cp-text">
							<p>'.$excerpt_html.'</p>
							<a href="'.get_permalink().'" class="cp-btn-normal pink"><i class="fa fa-arrow-right"></i>'.__('Read More','crunchpress').'</a>
						</div>
					</div>
				</div>';
				// Layout Selection for Thumbnails-on-side
				}else if($layout == 'thumbnails-on-side'){
					$recent_html .= '
						<div class="cp-post-type '.$cp_post_class.' '.$layout.'">
							<div class="row-fluid">
								<div class="span4"><figure>'.$thumbnail_html.'</figure></div>
								<div class="span8">
									<div class="cp-post-desc">
									<h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2>
										'.$meta_html.'
										<div class="cp-text">
											<p>'.$excerpt_html.'</p>
											<a href="'.get_permalink().'" class="cp-btn-normal pink"><i class="fa fa-arrow-right"></i>'.__('Read More','crunchpress').'</a>
										</div>
									</div>
								</div>
							</div>
						</div>';
						
				}else{
					$recent_html .= '';
				}
			}else{
				if($layout == 'default'){
					if($counter_post % 3 == 0){$post_class = 'first';$post_clear = '<div class="clear"></div>';}else{$post_class = '';$post_clear = '';}$counter_post++;
					$recent_html .= $post_clear.'<div class="span4 '.$post_class.' '.$layout.'">
						<div class="cp-post">
							<figure>'.$thumbnail_html.'</figure>
							<div class="cp-text">
								<h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2>
								<ul class="cp-categories">
									<li><a href="'.get_permalink().'">'.get_the_author().'</a></li>
									<li>';
										$variable_category = wp_get_post_terms( $post->ID, 'category');
										$counterr = 0;
										foreach($variable_category as $values){
											if($counterr == 0){ $meta_html .= '<li>Category:  </li>'; }
											$counterr++;
											$recent_html .= '<li><a href="'.get_term_link(intval($values->term_id),'category').'">'.$values->name.'</a></li>';
										}
									$recent_html .= '</li>
								</ul>
								<ul class="cp-post-detail">
									<li><a href="'.get_permalink().'"><i class="fa fa-clock-o"></i>'.get_the_date().'</a></li>
									'.$popular_post_html.'
								</ul>
							</div>
						</div>
					</div>';
					
				}else{
					$recent_html .= '<h3> Please change the layout there is no 1-4 layout for thumbnails-on-side</h3>';
				}			
			}
		}
		$recent_html .= '<div class="cp_load fadeIn">
			'.pagination().'
		</div>';
		$recent_html .= '</div>';
		
		return $recent_html;
		wp_reset_postdata();

	}
	
	//Content Boxes ShortCode Start
	function cp_content_box_shortcode($atts,$content = null){
		$html = '';
		//Fetch Parameters
		extract(shortcode_atts(array(
			'color' => '#ffffff',
			'backgroundcolor' => '#C33C4A',
			'title' => '',
			'icon' => '',
			
		), $atts));
		static $counter_box = 1;
		$counter_box++;
		//HTML Markup
		return '<style scoped>.cp-box-color-'.$counter_box.'{color:'.$color.' !important;}.cp-box-background-'.$counter_box.'{background:'.$backgroundcolor.'}</style><div class="cp-box-background-'.$counter_box.' cp-contant-box-1 cp-box-color-'.$counter_box.'"><h4 class="cp-box-color-'.$counter_box.'"><i class="fa '.$icon.'"></i>'.$title.'</h4>
		<div class="cp-text cp-box-background-'.$counter_box.' cp-box-color-'.$counter_box.'">
			'.do_shortcode($content).'
		</div></div>';
	}
	
	//3d Buttons ShortCode Start
	function cp_3dbutton_shortcode($atts,$content = null){
		//Counter
		static $counter_3d = 1;
		$counter_3d++;
		$html = '';
		//Fetch parameters
		extract(shortcode_atts(array(
			'icon' => '',
			'size' => '',
			'backgroundcolor' => '',
			'target' => '_blank',
			'textcolor' => '',
			'link' => '',
			
		), $atts));
		//$html = '<a style="background-color:'.$backgroundcolor.';color:'.$color.'">'.do_shortcode($content).'</a>';
		
		//HTML Markup
		$html = '
		<div class="btn-container">
		<style scoped>.cp-color3d-'.$counter_3d.'{background-color:'.$backgroundcolor.';color:'.$textcolor.';}</style>
		<a target="'.$target.'" href="'.$link.'" class="cp-btn '.$size.' cp-color3d-'.$counter_3d.'"><i class="fa '.$icon.'"></i>'.$content.'</a></div>';
		
		return $html;
	
	}
	
	//Image Carousel ShortCode Start
	function cp_images_shortcode($atts,$content = null){
		//Counter
		static $counter_images = 1;
		$counter_images++;
		//Fetch Parameters
		extract(shortcode_atts(array(
			'lightbox' => '',
			'gallery_id' => '',
			
		), $atts));
		//HTML Markup
		$html = '';
		//Lightbox is on
		if($lightbox == 'Yes'){
		//Calling Required Files
			wp_register_script('prettyPhoto', CP_PATH_URL.'/frontend/shortcodes/jquery.prettyphoto.js', false, '1.0', true);
			wp_enqueue_script('prettyPhoto');

			wp_register_script('cp-pscript', CP_PATH_URL.'/frontend/shortcodes/pretty_script.js', false, '1.0', true);
			wp_enqueue_script('cp-pscript');	
			
			wp_enqueue_style('prettyPhoto',CP_PATH_URL.'/frontend/shortcodes/prettyphoto.css');
		}
		wp_register_script('cp-jcaro', CP_PATH_URL.'/frontend/shortcodes/jquery.jcarousel.min.js', false, '1.0', true);
		wp_enqueue_script('cp-jcaro');	
		// Js Script
		$html .=  '<script> jQuery(document).ready(function($){ $("#mycarousel-'.$counter_images.'").jcarousel({wrap: "circular"}); }); </script>';
			if($gallery_id <> ''){
				$slider_xml_string = get_post_meta($gallery_id,'post-option-gallery-xml', true);
				//print_r($slider_xml_string);
				$slider_xml_dom = new DOMDocument();
				if( !empty( $slider_xml_string ) ){
					$slider_xml_dom->loadXML($slider_xml_string);					
						$children = $slider_xml_dom->documentElement->childNodes;
						$length = $slider_xml_dom->documentElement->childNodes->length;
						//Getting Values in Variables
						$html .=  '<ul id="mycarousel-'.$counter_images.'" class="jcarousel-skin-tango">';
						for($i=0;$i<$length;$i++) { 
							$thumbnail_id = find_xml_value($children->item($i), 'image');
							$title = find_xml_value($children->item($i), 'title');
							$caption = find_xml_value($children->item($i), 'caption');
							$link_type = find_xml_value($children->item($i), 'linktype');
							$video = find_xml_value($children->item($i), 'video');
							//$link = find_xml_value($children->item($i), 'link');
							
							$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
							//Images
							$image_full = wp_get_attachment_image_src($thumbnail_id, 'full');
							$image_thumb = wp_get_attachment_image_src($thumbnail_id, array(614,614));
							$link = find_xml_value( $children->item($i), 'link');
							
							$html .= '<li><a href="'.$image_full[0].'" data-rel="prettyPhoto[gallery1]"><img src="'.$image_thumb[0].'" alt="" /></a></li>';
          
						}
					$html .= '</ul>';	
				}
			}	
		
		return $html;
	
	}
	
	//Metro Buttons
	function cp_metro_shortcode($atts,$content = null){
		//Counter
		static $counter_metro = 1;
		$counter_metro++;
		$html = '';
		//Fetch Parameters
		extract(shortcode_atts(array(
			'icon' => '',
			'size' => '',
			'backgroundcolor' => '',
			'textcolor' => '',
			'link' => '',
			
		), $atts));
		
		//$html = '<a style="background-color:'.$backgroundcolor.';color:'.$color.'">'.do_shortcode($content).'</a>';
		//HTML Markup
		$html = '
		<div class="btn-container cp-metro-style">
		<style scoped>.cp-color-metro-'.$counter_metro.'{background-color:'.$backgroundcolor.';color:'.$textcolor.';}</style>
		<a href="'.$link.'" class="cp-btn-metro '.$size.' cp-color-metro-'.$counter_metro.'"><i class="fa '.$icon.'"></i>'.$content.'</a></div>';
		
		return $html;
	
	}
	
	//SoundCloud ShortCode Start
	function cp_soundcloud_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'type' => '',
			'width' => '',
			'height' => '',
			'url' => '',			
			'color' => '',
			'auto_play' => '',
			'hide_related' =>'',
			'show_artwork_or_visual' => '',
			
		), $atts));
		
		//Classic Embed HTML Markup
		if($type == "classic-embed"){
			return '<iframe width="'.$width.'" height="'.$height.'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.urlencode($url).'&amp;color='.$color.'&amp;auto_play='.$auto_play.'&amp;hide_related='.$hide_related.'&amp;show_artwork='.$show_artwork_or_visual.'"></iframe>';
		}else{
		//Visual Embed HTML Markup
			return '<iframe width="'.$width.'" height="'.$height.'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.urlencode($url).'&amp;auto_play='.$auto_play.'&amp;hide_related='.$hide_related.'&amp;visual='.$show_artwork_or_visual.'"></iframe>';
		}	
	}
	
	//Counter Circle ShortCode Start
	function cp_counters_circle_shortcode($atts,$content = null){
		
		return '<div class="skills">'.do_shortcode($content).'</div>';
	}
	 
	//Progress Circle / Counter Circle Shortcode start
	function cp_progress_shortcode($atts,$content = null){
		//fetch parameters
		extract(shortcode_atts(array(
			'filledcolor' => '#000000',
			'unfilledcolor' => '#ffffff',
			'percent' => '10',
			
		), $atts));
			//define count for progress circle
			static $counter_progress = 1;
			$counter_progress++;
			
			
		//HTML Markup For Progress circle
		$html_pro = " <div class='skill-inner'>
			<script type='text/javascript'>
				jQuery(document).ready(function($) {
					if($('#progress_bar-".$counter_progress."').length){
						var trackcolor = $('#progress_bar-".$counter_progress."').attr('data-trackcolor');
						var barcolor = $('#progress_bar-".$counter_progress."').attr('data-barcolor');
						if(!trackcolor.length){var trackcolor = '';}
						if(!barcolor.length){var barcolor = '';}
						$('#progress_bar-".$counter_progress."').easyPieChart({
							animate: 1000,
							barColor: barcolor,
							trackColor: trackcolor,
							onStep: function() {
								
							}
						});
					};
				});
			</script>
		<div class='chart'>
			<div id='progress_bar-".$counter_progress."' data-trackcolor='".$unfilledcolor."' data-barcolor='".$filledcolor."' class='percentage' data-percent='".$percent."'><span>".$percent."</span>%</div>
			<div class='label'>".do_shortcode($content)."</div>
		</div></div>";
	
		return $html_pro;
		
	}
	
	//Lightbox shortcode
	function cp_lightbox_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'title' => '',
			'href' => '#',			
			'src' => '',
			'align' => '',
			'margin' => '',
			
			
		), $atts));
		//$gallery_post = get_posts(array('posts_per_page' => 1, 'post_type' => 'gallery', 'name'=>$gallery_page, 'numberposts'=> 2));
		
		//Calling the Required Files
		wp_register_script('prettyPhoto', CP_PATH_URL.'/frontend/shortcodes/jquery.prettyphoto.js', false, '1.0', true);
		wp_enqueue_script('prettyPhoto');

		wp_register_script('cp-pscript', CP_PATH_URL.'/frontend/shortcodes/pretty_script.js', false, '1.0', true);
		wp_enqueue_script('cp-pscript');	
		
		return $html = '<a style="margin:'.$margin.';float:'.$align.'" title="'.$title.'" href="'.$href.'" data-rel="prettyPhoto"><img src="'.$src.'" alt="'.$title.'" /></a>';
	
	}
	//Title ShortCode Start
	function cp_title_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'size' => '',
			
		), $atts));
		//HTML Markup
		return '<'.$size.' class="cp-heading-full">'.do_shortcode($content).'</'.$size.'>';
	
	}
	
	//Progress Bar Shortcode Start
	function cp_progress_bar_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'percentage' => '',
			'type' => 'progress-info',			
			
		), $atts));
			//HTML Markup
			$html_bar = '<div class="cp-progressbar"><h5>'.$content.'</h5>
				<div class="progress '.$type.'">
					<div class="bar" style="width: '.$percentage.'%"></div>
				</div></div>';
				
		return $html_bar;
	
	}
		
	//Google maps
	function cp_map_shortcode($atts){
			//Counter
			static $counter_map = 1;
			$counter_map++;
		//Fetch Parameters
		extract(shortcode_atts(array(
			'latitude' => '',
			'longitude' => '',
			'maptype' => 'terrain',
			'width' => '100%',
			'height' => '400px',
			'zoom' => '14',
			
		

		), $atts));
		
			// ROADMAP (normal, default 2D map)
			// SATELLITE (photographic map)
			// HYBRID (photographic map + roads and city names)
			// TERRAIN (map with mountains, rivers, etc.)
		//Wordpress Code
		$select_layout_cp = '';
		$color_scheme = '';
		$cp_general_settings = get_option('general_settings');
		if($cp_general_settings <> ''){
			$cp_logo = new DOMDocument ();
			$cp_logo->loadXML ( $cp_general_settings );
			$select_layout_cp = find_xml_value($cp_logo->documentElement,'select_layout_cp');
			$color_scheme = find_xml_value($cp_logo->documentElement,'color_scheme');
		}
		//Js Script For Map
		$html = '<div class="cp-map-containter"><script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>';
		$html .= "<script type='text/javascript'>
		jQuery(document).ready(function($) {			
			var map;
			var myLatLng = new google.maps.LatLng(".$latitude.",".$longitude.")
			//Initialize MAP
			var myOptions = {
				zoom: ".$zoom.",
				center: myLatLng,
				disableDefaultUI: true,
				zoomControl: true,
				styles:[
					{
						stylers: [
							{ hue: '". $color_scheme."' },
							{ saturation: -10 },
						]
					}
				],
				scrollwheel: false,
				navigationControl: false,
				mapTypeControl: true,
				scaleControl: false,
				draggable: true,
				mapTypeId: google.maps.MapTypeId.".$maptype."
			};
			map = new google.maps.Map(document.getElementById('map_canvas-".$counter_map."'),myOptions);
			//End Initialize MAP
			//Set Marker
			var marker = new google.maps.Marker({
			  position: map.getCenter(),
			  map: map
			});
			marker.getPosition();
			//End marker
			
			//Set info window
			var infowindow = new google.maps.InfoWindow({
				content: '',
				position: myLatLng
			});
			infowindow.open(map);
		});
		</script>";
		//HTML Markup
		$html .= '<div style="width:'.$width.';height:'.$height.';" id="map_canvas-'.$counter_map.'" class="map_canvas"></div></div>';
		
		return $html;
	}
		
	// Slider ShortCode Start
	function cp_slider_shortcode($atts,$content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			'width' => '100%',
			'height' => '350px',
		), $atts));
		
		static $counter_slider_id = 1;
		$counter_slider_id++;
		
		//HTML Markup
		$cp_html_slider = '';
		$short_code_id = 'slider-'.$counter_slider_id;
				
		//Calling the Script and required files
	
		$cp_html_slider = '<script type="text/javascript">jQuery(document).ready(function ($) { $("#slider-'.$counter_slider_id.'").bxSlider({video: true,useCSS: false});});</script>';
		$cp_html_slider .= '<div class="short_slider"><ul style="width:'.$width.';height:'.$height.'" id="'.$short_code_id.'">'.do_shortcode($content);		
		$cp_html_slider .= '</ul></div>';
		
		//Slider XML Check Condition Ends
		return $cp_html_slider;
	}
	
	function cp_slide_shortcode($atts ,$content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			'type' => '',
			'link' => '',
			'target' => '',
			'lightbox' => '',
		), $atts));
		

		if($type == 'image'){
			$html_slider = '<li><a href="'.$link.'" target="'.$target.'"><img alt="slider" src="'.$content.'" /></a></li>';
		}else{
			$html_slider = '<li>'.do_shortcode($content).'</li>';
		}
		
		
		//Slider XML Check Condition Ends
		return $html_slider;
	}
	
	
	
	
	//ToolTip ShortCode Start
	function cp_tooltip_shortcode($atts,$content = null){
		//Fetch parameters
		extract(shortcode_atts(array(
			'title' => '',			
		), $atts));	
		//HTML Markup
		return '<span class="cp-tooltip-wrapper"><a href="#" data-toggle="tooltip" title="'.$title.'" class="cp-tooltip">'.do_shortcode($content).'</a></span>';
	
	}
	//Siderbar Shortcode Start
	function cp_widget_bar_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			"name" => ''
		), $atts));
		echo '<div class="row">';
			dynamic_sidebar( $name );
		echo '</div>';
	}
	
	//Siderbar Shortcode Start
	function cp_flexslider_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			"layout" => '',
			"excerpt" => '',
			"category" => '',
			"limit" => '',
			"id" => '',
			"lightbox" => ''
			
		), $atts));
		
	}
	
		
	// 1/2, 1/3, 1/4 etc Column Layout ShortCode Start
	function cp_column_shortcode($atts, $content = null)
	{
			//Fetch Parameters
			extract(shortcode_atts(array(
			"col" => '1/1'
		), $atts));
		//Switch For Selecting the Layout
		switch ($col) {
			case '1/4':
				return '<div class="shortcode1-4">' . do_shortcode($content) . '</div>';
			case '1/3':
				return '<div class="shortcode1-3">' . do_shortcode($content) . '</div>';
			case '1/2':
				return '<div class="shortcode1-2">' . do_shortcode($content) . '</div>';
			case '2/3':
				return '<div class="shortcode2-3">' . do_shortcode($content) . '</div>';
			case '3/4':
				return '<div class="shortcode3-4">' . do_shortcode($content) . '</div>';
			default:
			case '1/1':
				return '<div class="shortcode1">' . do_shortcode($content) . '</div>';
		}
	}
	
	// Accordion ShortCode Start
	function cp_accordion_shortcode($atts, $content = null)
	{
		//Calling The Required Files and Script
		wp_enqueue_script('jquery-ui-accordion');
		// wp_register_script('cp-accordian-script', CP_PATH_URL.'/frontend/shortcodes/accordian_script.js', false, '1.0', true);
		// wp_enqueue_script('cp-accordian-script');
		
		static $counter_accordion = 1;
		$counter_accordion++;
		
		//HTML Markup
		$accordion = "
					<script>
						jQuery(document).ready(function($) {
							$('#accordion_cp-".$counter_accordion."').accordion({
								collapsible: true
							});
						});
					</script><div id='accordion_cp-".$counter_accordion."' class='accordion_cp acc-list2'>";
		$accordion = $accordion . do_shortcode($content);
		$accordion = $accordion . "</div>";
		return $accordion;
	}
	
	//Accordion ITEM Shortcode Start
	function cp_acc_item_shortcode($atts, $content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			"title" => ''
		), $atts));
		//HTML Markup For ITEMS IN Accordion
		$acc_item = "";
		$acc_item = $acc_item . "<h3 class='accordion-heading'><a class='accordion-toggle'>";
		$acc_item = $acc_item . $title . "</a></h3>";
		$acc_item = $acc_item . "<div><p>" . do_shortcode($content) . "</p></div>";
		//$acc_item = $acc_item . "</div>";
		return $acc_item;
	}

	
	// shortcode for toggle box
	function cp_toggle_box_shortcode($atts, $content = null)
	{
		wp_enqueue_script('jquery-ui-accordion');
		wp_register_script('cp-accordian-script', CP_PATH_URL.'/frontend/shortcodes/accordian_script.js', false, '1.0', true);
		wp_enqueue_script('cp-accordian-script');
		$toggle_box = "<div class='accordion'>";
		$toggle_box = $toggle_box . do_shortcode($content);
		$toggle_box = $toggle_box . "</div>";
		return $toggle_box;
	}
	
	//Toggle Shortcode
	function cp_toggle_item_shortcode($atts, $content = null)
	{
		extract(shortcode_atts(array(
			"title" => '',
			"active" => 'false'
		), $atts));
		$active      = ($active == "true") ? " active" : '';
		$toggle_item = "<li class='cp-divider'>";
		$toggle_item = $toggle_item . "<h3 class='accordion-heading'><a href=''>";
		$toggle_item = $toggle_item . "<span class='toggle-box-head-image" . $active . "'></span>";
		$toggle_item = $toggle_item . $title . "</a></h3>";
		$toggle_item = $toggle_item . "<p class='toggle-box-content" . $active . "'>" . do_shortcode($content) . "</p>";
		$toggle_item = $toggle_item . "</li>";
		return $toggle_item;
	}
	
	// shortcode for tab
	//$cp_tab_array = array();
	
	//Tabs ShortCode Start
	function cp_tab_shortcode($atts, $content = null)
	{
		global $cp_tab_array,$counter;
		$cp_tab_array = array();
		do_shortcode($content);
		$num = sizeOf($cp_tab_array);
		//Calling Required Files And Scripts
		wp_enqueue_script('jquery-ui-tabs');
		wp_register_script('cp-tabs-script', CP_PATH_URL.'/frontend/shortcodes/tabs_script.js', false, '1.0', true);
		wp_enqueue_script('cp-tabs-script');
		//Loop For Horizontal Tabls
		$tab = "<div id='horizontal-tabss' class='tabs tabs-widget'><ul class='cp-divider nav nav-tabs'>";
		for ($i = 0; $i < $num; $i++) {
			$active = ($i == 0) ? 'active' : '';
			$tab_id = str_replace(' ', '-', $cp_tab_array[$i]["title"]);
			$tab    = $tab . '<li><a href="#' . $tab_id.$i . '" class=" ';
			$tab    = $tab . $active . '" >' . $cp_tab_array[$i]["title"] . '</a></li>';
		}
		$tab = $tab . "</ul>";
		// Tab Content
		$tab = $tab . "<ul class='contents tab-content'>";
		for ($i = 0; $i < $num; $i++) {
			$active = ($i == 0) ? 'active' : '';
			$tab_id = str_replace(' ', '-', $cp_tab_array[$i]["title"]);
			$tab    = $tab . '<li id="' . $tab_id.$i . '" class="tabscontent">';
			$tab    = $tab . $cp_tab_array[$i]["content"] . '</li>';
		}
		$tab = $tab . "</ul></div>";
		return $tab;
	}
	
	//Tab ITEM Shortcode Start
	function cp_tab_item_shortcode($atts, $content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			"title" => ''
		), $atts));
		global $cp_tab_array;
			$cp_tab_array[] = array(
			"title" => $title,
			"content" => do_shortcode($content)
		);
	}
	
	// Separator Shortcode Start
	function cp_divider_shortcode($atts)
	{
	//Calling Required Files and Scripts
	wp_register_script('cp-top-script', CP_PATH_URL.'/frontend/shortcodes/jquery.scrollTo-min.js', false, '1.0', true);
	wp_enqueue_script('cp-top-script');
		extract(shortcode_atts(array(
			"scroll_text" => ''
		), $atts));
		//HTML Markup
		$divider = '<div class="divider"><div class="scroll-top"><a href="">Back To Top</a>';
		$divider = $divider . $scroll_text . '</div></div>';
		return $divider;
	}
	
	
	//Youtube ShortCode Start
	function cp_youtube_shortcode($atts, $content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			"height" => '',
			"width" => ''
		), $atts));
		//HTML MarkUp
		preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $content, $id);
		
		$youtube = '<div style="max-width:' . $width .'" >';
		$youtube = $youtube . '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent" width="' . $width . '" height="' . $height . '" ></iframe>';
		$youtube = $youtube . '</div>';
		return $youtube;
	}
	
	
	//Vimeo ShortCode Start
	function cp_vimeo_shortcode($atts, $content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			"height" => '',
			"width" => ''
		), $atts));
		$id = array('1'=>'55');
		//fetch_vimeo_id("https://vimeo.com/donialiechti/stranded");
		preg_match('/http:\/\/vimeo.com\/(\d+)$/', $content, $id);
		
		$vimeo = '<div style="max-width:' . $width . '" >';
		$vimeo = $vimeo . '<iframe src="http://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" ></iframe>';
		$vimeo = $vimeo . '</div>';
		return $vimeo;
	}
	
	// Button ShortCode Start
	function cp_button_shortcode($atts, $content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			"color" => '',
			"size" => 'large',
			"link" => '#',
			'target' => '_self'
		), $atts));
		//HTML Markup
		$button_border = '';
		if (!empty($background)) {
			$button_border = '#' . hexDarker(substr($background, 1), 5);
		}
		return '<a href="' . $link . '" target="' . $target . '" class="cp-button shortcode-' . $size . '-button" style="background-color:' . $color . '; ">' . $content . '</a>';
	}
	

	// function cp_button_fontawesome(){
	
		// extract(shortcode_atts(array(
			// "color" => '',
			// "type" => '',
			// "font_size" => '',
			// "src" => '#',
			// 'target' => '_self'
		// ), $atts));
		// $button_border = '';
		// if (!empty($background)) {
			// $button_border = '#' . hexDarker(substr($background, 1), 5);
		// }
		// return '<a href="' . $src . '"><button class="button-style"><i style="color:'.$color.';font:'.$font_size.'" class="'.$type.'"></i></button></a>';
	// }
	
	
	function cp_list_shortcode($atts, $content = null)
	{
		extract(shortcode_atts(array(
			"type" => 'check'
		), $atts));
		return '<div class="shortcode-list shortcode-list-' . $type . '">' . $content . '</div>';
	}
	
	//Social Icons
	function cp_social_shortcode($atts, $content = null)
	{
		extract(shortcode_atts(array(        
			"size" => 'large',
			"src" => '#',
			"type"=> 'facebook',
		), $atts));
			$social = '<div class="space_btwn socialicons" class="">';
			$social = $social . '<a title="'.$content.'" href="'.$src.'" class="'.$size.' social_active '.$type.'" id=""><span class="da-animate da-slideFromLeft"></span></a></div>';
		return $social;
	}
	
	//BlockQuotes
	function cp_quote_shortcode($atts, $content = null)
	{
		extract(shortcode_atts(array(
			"style" => 'quote-box-2',
			"image" => 'default',
		), $atts));
		if($style == 'quote-box-2'){
			return '<div class="quote-box-2">
				<blockquote> <i class="icon-quote-left"></i>
				  <p>'.$content.' <i class="icon-quote-right"></i></p>
				</blockquote>
			</div>';
		}else if($style == 'quote-box'){
		return '<div class="quote-box">
					<blockquote class="quote"> <i class="icon-quote-right"></i>
						 <p>'.$content.'</p>
					</blockquote>
				</div>';
		}else if($style == 'quote-box-1'){
		
		if($image <> 'default'){$image = '<div class="quote-frame"><img src="'.$image.'" alt=""/></div>';}else{$image = '';}
		return '<div class="quote-row">'.$image.'
		<blockquote> <i class="icon-quote-left"></i>
		  <p>'.$content.'</p>
		</blockquote>
	  </div>';
		}else{
			echo 'Please Add STYLE (quote-box , quote-row , quote-box-2)';
		}
		//return '<div class="blockquote-style quote-' . $align . '" style="color:' . $color . '">' . $content . '</div>';
	}
	
	//ShortCode For Blog Start
	function cp_blog_shortcode($atts, $content = null)
	{
		wp_reset_query();
		wp_reset_postdata();
		
		//Fetch parameters
		extract(shortcode_atts(array(
			"number_posts" => '',
			"cat_id" => '',
			"title" => '',								
			"excerpt_words" => '',
			"pagination" => '',				
		), $atts));			
		query_posts(array( 
			'post_type' => 'portfolio',
			'showposts' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolio-category',
					'terms' => $cat_id,
					'field' => 'term_id',
				)
			),
			'orderby' => 'title',
			'order' => 'ASC' )
		);
		
		wp_reset_query();
		wp_reset_postdata();
		
		//return $blog_item_html;
		
	}
	
	function cp_portfolio_shortcode($atts, $content = null)
	{
		extract(shortcode_atts(array(
			"number_posts" => '',
			"cat_id" => '',
			"title" => '',								
			"excerpt_words" => '',
			"pagination" => '',				
		), $atts));			
			query_posts(array( 
				'post_type' => 'portfolio',
				'showposts' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'portfolio-category',
						'terms' => $cat_id,
						'field' => 'term_id',
					)
				),
				'orderby' => 'title',
				'order' => 'ASC' )
			);
			while( have_posts() ){
			the_post();
			//Fetching All Tracks from Database
			$track_name_xml = get_post_meta($post->ID, 'add_project_xml', true);
			$track_url_xml = get_post_meta($post->ID, 'add_project_field_xml', true);
			
			//Empty Variables
			//$album_download = '';
			$children = '';
			$children_title = '';

			//Track Name
			if($track_name_xml <> ''){
				$ingre_xml = new DOMDocument();
				$ingre_xml->recover = TRUE;
				$ingre_xml->loadXML($track_name_xml);
				$children_name = $ingre_xml->documentElement->childNodes;
			}		
			
			//Track URL
			if($track_url_xml <> ''){	
				$ingre_title_xml = new DOMDocument();
				$ingre_title_xml->recover = TRUE;
				$ingre_title_xml->loadXML($track_url_xml);
				$children_title = $ingre_title_xml->documentElement->childNodes;
			} 
			$port_class = '';
			if($counter_team % 4 == 0){$port_class= 'first';}else{$post_class = 'no-class';}$counter_team++; ?>
				<!--LIST ITEM START-->
				<li class="span3 <?php echo $port_class;?>">
					<div class="portfolio-wrapper">
						<div class="thumb">
							<?php echo get_the_post_thumbnail($post->ID, array(614,614));?>
							<div class="caption">
								<h5><?php echo get_the_title();?></h5>
								<p><?php 
									$variable_category = wp_get_post_terms( $post->ID, 'portfolio-category');
									$counterr = 0;
									foreach($variable_category as $values){														
										$counterr++;
										echo '<a class="portfolio-tag" href="'.get_term_link(intval($values->term_id),'portfolio-category').'">'.$values->name.'</a>  ';}
									?>
								</p>
								<div class="rating">
									<span>?</span><span>?</span><span>?</span><span>?</span><span>?</span>
								</div>
								<p><?php echo substr(get_the_content(),0,200);?></p>
							</div>
						</div>
						<div class="text">
							<?php
							//Combine Loop
							if($track_name_xml <> '' || $track_url_xml <> ''){
								$counter = 0;
								$nofields = $ingre_xml->documentElement->childNodes->length;
								for($i=0;$i<1;$i++) { 
									$counter++;
									echo '<h5>'.$children_name->item($i)->nodeValue.'</h5>';
									echo '<p>'.$children_title->item($i)->nodeValue.'</p>';
								}
							}		
							?>
							<a href="<?php echo get_permalink();?>" class="view-project"><?php _e('View Project','');?></a>
						</div>
					</div>
				</li>
				<!--LIST ITEM START-->
			<?php
			}
		
		return $port_item_html;
	}
	
	
	//DropCap ShortCode Start
	function cp_dropcap_shortcode($atts, $content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			"color" => '',				
		), $atts));
		static $dropcap = 0;
		$dropcap++;
		//HTML MarkUp
		return '<style scoped>#cp-dropcap-'.$dropcap.'{color:'.$color.';}</style><span id="cp-dropcap-'.$dropcap.'" class="cp-dropcap">' . $content . '</span>';
	}
	
	//Highlight ShortCode Start
	function cp_highlight_shortcode($atts, $content = null)
	{
		//Fetch Parameters
		extract(shortcode_atts(array(
			"color" => '',				
		), $atts));
		static $highlight = 0;
		$highlight++;
		//HTML MarkUp
		return '<style scoped>.highlight-'.$highlight.'{background-color:'.$color.'}</style><mark class="cp-highlight highlight-'.$highlight.'">' . $content . '</mark>';
	}
	
	
	
	//Alert Box ShortCode Start
	function cp_message_box_shortcode($atts, $content = null)
	{
	//Fetch Parameters
		extract(shortcode_atts(array(				
			'icon' => '',
			'color_light' => '',
			'color_dark' => '',
		), $atts));
		static $counter_alert = 1;
		$counter_alert++;
		
		//HTML Markup 
		$message_box = '<style scoped>#alert-'.$counter_alert.':before{content:"'.get_fontawesome_code($icon).'";} 
		#alert-'.$counter_alert.' .close{content:"\f00d";}
		#alert-'.$counter_alert.'{
			background: '.$color_light.';
			background: -webkit-gradient(linear, 0 0, 0 bottom, from('.$color_light.'), to('.$color_dark.'));
			background: -webkit-linear-gradient('.$color_light.', '.$color_dark.');
			background: -moz-linear-gradient('.$color_light.', '.$color_dark.');
			background: -ms-linear-gradient('.$color_light.', '.$color_dark.');
			background: -o-linear-gradient('.$color_light.', '.$color_dark.');
			background: linear-gradient('.$color_light.', '.$color_dark.');
		}</style><div id="alert-'.$counter_alert.'" class="alert error"><button data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>';
		$message_box = $message_box . '<p class="pull-left">' . $content . '</p>';
		$message_box = $message_box . '</div>';
		return $message_box;
	}
		
		
	function get_fontawesome_code($icon_code = ''){
		// Fontawesome icons list
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$fontawesome_path = CP_TINYMCE_DIR . '/css/font-awesome.css';
		if( file_exists( $fontawesome_path ) ) {
			@$subject = file_get_contents($fontawesome_path);
		}

		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

		foreach($matches as $match){
			//$icons[$match[1]] = $match[2];
			if($match[1] == $icon_code){
				$icon_code = $match[2];
			}
		}
		return $icon_code;
	}