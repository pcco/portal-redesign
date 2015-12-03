<?php
/*
 * This file is used to generate different page layouts set from backend.
 */
 
 	//Fetch the theme Option Values
	$maintenance_mode = get_themeoption_value('maintenance_mode','general_settings');
	$maintenace_title = get_themeoption_value('maintenace_title','general_settings');
	$countdown_time = get_themeoption_value('countdown_time','general_settings');
	$email_mainte = get_themeoption_value('email_mainte','general_settings');
	$mainte_description = get_themeoption_value('mainte_description','general_settings');
	$social_icons_mainte = get_themeoption_value('social_icons_mainte','general_settings');
	
	if($maintenance_mode <> 'disable'){
		//If Logged in then Remove Maintenance Page
		if ( is_user_logged_in() ) {
			$maintenance_mode = 'disable';
		} else {
			$maintenance_mode = 'enable';
		}
	}
	
	if($maintenance_mode == 'enable'){
		//Trigger the Maintenance Mode Function Here
		maintenance_mode_fun();
	}else{
 
get_header ();

	global $post,$post_id;
		$page_builder_full = get_post_meta ( $post->ID, "cp-show-full-layout", true );      
		if($page_builder_full == 'No'){
			$sidebar_class = '';
			$content_class = '';
			$sidebar = get_post_meta ( $post->ID, 'page-option-sidebar-template', true );
			$sidebar_class = sidebar_func($sidebar);
			$left_sidebar = get_post_meta ( $post->ID, "page-option-choose-left-sidebar", true );
			$right_sidebar = get_post_meta ( $post->ID, "page-option-choose-right-sidebar", true );
		}else{
			$sidebar_class = array('0'=>'no-sidebar','1'=>'1-sidebar',);
			$content_class = array();
			$sidebar = array();
			$left_sidebar = '';
			$right_sidebar = '';
		}	
		
		
		$slider_off = '';
		$slider_type = '';
		$slider_slide = '';
		$slider_height = '';
		
		//Fetch the data from page
		
		$slider_off = get_post_meta ( $post->ID, "page-option-top-slider-on", true );
		$slider_type = get_post_meta ( $post->ID, "page-option-top-slider-types", true );
		$slider_type_album = get_post_meta ( $post->ID, "page-option-top-slider-album", true );
		$page_builder_full = get_post_meta ( $post->ID, "cp-show-full-layout", true );
		$cp_page_title = get_post_meta ( $post->ID, "page-option-item-page-title", true );
	
		//If Slider Plugin Exist
		if(class_exists('cp_slider_class')){
			//Condition for Box Layout
				if($slider_off == 'Yes'){ 
					echo '<div class="banner_rock main-slider">';
						echo page_slider();
						if(class_exists('cp_album_class')){
							//if($slider_type <> 'Layer-Slider'){
								if($slider_type_album <> '786512'){ ?>
								<!--Now Playing Start-->
								<!--replace featured sermon with 最近讲道-->
								<section class="featured-sermon">
									<div class="container">
										<strong class="title"><?php _e('最近讲道','crunchpress');?></strong>
										<figure class="main-gallery-slider playlist-main-slider-cp">
											<?php echo cp_album_class::sermons_play_list($slider_type_album);
											if($slider_type_album <> ''){
											$slider_type_album = get_post($slider_type_album); 
											$sr_detail_xml = get_post_meta($slider_type_album->ID, 'sermons_detail_xml', true);
											if($sr_detail_xml <> ''){
												$cp_sr_xml = new DOMDocument ();
												$cp_sr_xml->loadXML ( $sr_detail_xml );
												$vid_id = find_xml_value($cp_sr_xml->documentElement,'video_url_type');
												$sc_id = find_xml_value($cp_sr_xml->documentElement,'soundcloud_url_type');
											}
											if($vid_id <> ''){ 
												wp_register_script('prettyPhoto', CP_PATH_URL.'/frontend/js/jquery.prettyphoto.js', false, '1.0', true);
												wp_enqueue_script('prettyPhoto');

												wp_register_script('cp-pscript', CP_PATH_URL.'/frontend/js/pretty_script.js', false, '1.0', true);
												wp_enqueue_script('cp-pscript');	
												
												wp_enqueue_style('prettyPhoto',CP_PATH_URL.'/frontend/css/prettyphoto.css');
											}
											?>
											<ul class="meta-info-sermons">
												<li><i class="fa fa-calendar"></i><?php echo date($slider_type_album->post_date,strtotime(get_option('date_format')));?></li>
												<?php if($vid_id <> ''){ ?><li><a data-rel="prettyphoto" href="<?php echo $vid_id;?>"><i class="fa fa-video-camera"></i><?php _e('Video','crunchpress');?></a></li><?php }?>
												<?php if($sc_id <> ''){ ?><li><a data-rel="prettyphoto" href="https://api.soundcloud.com/tracks/<?php echo $sc_id;?>"><i class="fa fa-soundcloud"></i><?php _e('SoundCloud','crunchpress');?></a></li><?php }?>
												<li><i class="fa fa-reorder"></i><?php _e('Category','crunchpress');?>
													<?php 
													$sr_category = wp_get_post_terms( $slider_type_album->ID, 'sermons-category'); $counterr = 0;
													foreach($sr_category as $values){
														//if($counterr == 0){ echo 'Category:  ';}
														$counterr++;
														echo '<a href="'.get_term_link(intval($values->term_id),'sermons-category').'">'.$values->name.'</a>  ';
													}?>
												</li>
											</ul>	
										<?php }?>											
										</figure>
									</div>
								</section>
								<!--Now Playing Ends-->
							<?php }
							//}
						}
					echo '</div>';	
				} //Slider Off			
		}	
	
	if($slider_off <> 'Yes'){ 
	$item_margin = '';
	$breadcrumbs = get_themeoption_value('breadcrumbs','general_settings'); 
	if($breadcrumbs == 'disable'){
		$item_margin = 'item_margin_top';
	}else{
		$item_margin = '';
	}
	?>
	<div class="clearfix clear"></div>
	<div class="contant <?php echo $item_margin;?>">
	<?php 
	if($breadcrumbs == 'enable'){ ?>
				<!--Inner Pages Heading Area Start-->
				<section class="inner-headding">
					<div class="container">
						<div class="row-fluid">
							<div class="span12">
								<h1><?php echo get_the_title();?></h1>
								<?php
									if(!is_front_page()){
										echo cp_breadcrumbs();
									}
								?>
							</div>
						</div>
					</div>
				</section>
				<!--Inner Pages Heading Area End--> 
			<?php }?>
		<?php }?>
		<div class="<?php if($page_builder_full <> 'Yes'){echo 'container';}else{echo 'full-width-content';}?>">
			<?php if($slider_off == 'No'){ ?>
				<?php if($page_builder_full == 'Yes'){echo '<div class="container">';}?>
					<?php if($cp_page_title <> ''){ ?><h2 class="h-style"><?php echo $cp_page_title;?></h2><?php }?>
				<?php if($page_builder_full == 'Yes'){echo '</div>';}?>	
			<?php }?>
            <!--BREADCRUMS END-->
            <!--MAIN CONTANT ARTICLE START-->
				<div class="main-content">
					<div class="page_content row-fluid">
						<?php
						if($sidebar == "left-sidebar" || $sidebar == "both-sidebar" || $sidebar == "both-sidebar-left"){ ?>
							<div id="block_first" class="sidebar side-bar <?php echo $sidebar_class[0];?>">
								<?php dynamic_sidebar( $left_sidebar ); ?>
							</div>
							<?php
						}
						if($sidebar == 'both-sidebar-left'){ ?>
						<div id="block_first_left" class="sidebar side-bar <?php echo $sidebar_class[0];?>">
							<?php dynamic_sidebar( $right_sidebar );?>
						</div>
						<?php } ?>
						<div id="block_content_first" class="<?php echo $sidebar_class[1];?>">
							<div class="row-fluid">
								<?php
								$cp_page_xml = get_post_meta($post->ID,'page-option-item-xml', true);		
									global $cp_item_row_size;
									$cp_item_row_size = 0;	
									$counter = 0;
									// Page Item Part
									if (! empty ( $cp_page_xml )) {
										$page_xml_val = new DOMDocument ();
										$page_xml_val->loadXML ( $cp_page_xml );
										foreach ( $page_xml_val->documentElement->childNodes as $item_xml ) {
											$counter++;
											switch ($item_xml->nodeName) {
												case 'Accordion' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm' );
													print_accordion_item ( $item_xml );
													echo '</article>';
													break;
												case 'Blog' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ));
													print_blog_item ( $item_xml );
													echo '</article>';
												break;
												case 'Timeline' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm news-slider-cp-new');
													print_latest_show_item ( $item_xml );
													echo '</article>';
													break;
												case 'Division_Start' :
													if($page_builder_full == 'Yes'){
														print_div_item ( $item_xml );
													}	
													break;	
												case 'Division_End' :
													if($page_builder_full == 'Yes'){
														print_div_end_item ( $item_xml );
													}	
													break;		
												case 'Events' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'event_calendar-cp mbtm');
													if(class_exists('EM_Events')){
														$cp_events_class = new cp_events_class;
														$cp_events_class->page_event_manager_plugin($item_xml);
													}
													echo '</article>';
													break;
												case 'Woo-Products' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm woo-produ-cp');
													if(class_exists("Woocommerce")){
														print_wooproduct_item ( $item_xml );
													}	
													echo '</article>';
												break;
												case 'Sermons-Gallery' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm sermons-gallery-cp');
													if(class_exists('cp_album_class')){
														$cp_album_class = new cp_album_class;
														$cp_album_class->print_gallery_sermons_item ( $item_xml );
													}
													echo '</article>';
												break;
												case 'Featured-News' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm feature-news-cp');
													print_featured_item ( $item_xml );
													echo '</article>';
												break;
												case 'Sermons' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm sermons-cp');
													if(class_exists('cp_album_class')){
														$cp_album_class = new cp_album_class;
														$cp_album_class->print_sermons_listing_item ( $item_xml );
													}
													echo '</article>';
												break;
												case 'Events-Counter' :
													if(class_exists('EM_Events')){
														print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm');
														$cp_events_class = new cp_events_class;
														$cp_events_class->print_count_events_item ( $item_xml );
														echo '</article>';
													}
												break;
												case 'Event-Calendar' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm event-calendar-cp');
													if(class_exists('EM_Events')){
														$cp_events_class = new cp_events_class;
														$cp_events_class->print_next_events_item ( $item_xml );
													}
													echo '</article>';
												break;
												case 'Single-Sermons' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm single-sermons-cp');
													if(class_exists('cp_album_class')){
														$cp_album_class = new cp_album_class;
														$cp_album_class->print_sermons_ofweek_item ( $item_xml );
													}
													echo '</article>';
													break;
												case 'Newest-Sermons' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm newest-sermons-cp');
													if(class_exists('cp_album_class')){
														$cp_album_class = new cp_album_class;
														$cp_album_class->print_newest_sermons_item ( $item_xml );
													}
													echo '</article>';
													break;													
												case 'Modern-Blog' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm');
													print_blog_modern_item ( $item_xml );
													echo '</article>';
													break;	
												case 'Sidebar' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm');
													print_sidebar_item ( $item_xml );
													echo '</article>';
													break;		
												case 'Pastors' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'pastors fadeIn cp_load mbtm');
													if(class_exists('cp_album_class')){
														$cp_album_class = new cp_album_class;
														$cp_album_class->print_pastor_item_item ( $item_xml );
													}
													echo '</article>';
													break;		
												case 'News' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm latest-news-cp');
													print_news_item ( $item_xml );
													echo '</article>';
													break;
												case 'Our-Team' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm our-team-cp');
													if(class_exists('cp_team_class')){
													$cp_team_class = new cp_team_class;
														$cp_team_class->print_team_item ( $item_xml );
													}
													echo '</article>';
													break;
												case 'Contact-Form' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ), 'mt0 fadeIn cp_load mbtm' );
													print_contact_form ( $item_xml );
													echo '</article>';
													break;
												case 'Column' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm column' );														
													print_column_item ( $item_xml );
													echo '</article>';
													break;
												case 'Services' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'feature fadeIn cp_load mbtm' );
													print_column_service ( $item_xml );
													echo '</article>';
													break;
												case 'Content' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ) ,'fadeIn cp_load mbtm content-cp');
													print_content_item ( $item_xml );
													echo '</article>';
													break;
												case 'Divider' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ), 'wrapper fadeIn cp_load' );
													print_divider ( $item_xml );
													echo '</article>';
													break;
												case 'Gallery' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'overflow_class mbtm');
													print_gallery_item ( $item_xml );
													echo '</article>';
													break;
												case 'Message-Box' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm' );
													print_message_box ( $item_xml );
													echo '</article>';
													break;
												case 'Slider' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ), 'containter_slider fadeIn cp_load mbtm' );
													print_slider_item ( $item_xml );
													echo '</article>';
													break;
												case 'Tab' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'fadeIn cp_load mbtm' );
													print_tab_item ( $item_xml );
													echo '</article>';
													break;
												case 'Testimonial' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm');
													if(class_exists('cp_testi_class')){
													$cp_testi_class = new cp_testi_class;
														$cp_testi_class->print_testimonial ( $item_xml );
													}
													echo '</article>';
													break;
												case 'Client-Slider' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm');
													if(class_exists('cp_testi_class')){
													$cp_testi_class = new cp_testi_class;
														$cp_testi_class->print_testimonial_slider ( $item_xml );
													}
													echo '</article>';
													break;	
												case 'Portfolio' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm');
													if(class_exists('cp_portfolio_class')){
													$cp_portfolio_class = new cp_portfolio_class;
														$cp_portfolio_class->print_port_item ( $item_xml );
													}
													echo '</article>';
													break;	
												case 'Crowd-Funding' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm');
													print_ignition_item($item_xml);
													echo '</article>';
													break;	
												case 'Feature-Projects' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm');
													//print_ignition_item($item_xml);
													echo '</article>';
													break;								
												case 'Toggle-Box' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm' );
													print_toggle_box_item ( $item_xml );
													echo '</article>';
													break;
												case 'DonateNow' :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm' );
													print_donate_item ( $item_xml );
													echo '</article>';
													break;	
												default :
													print_item_size ( find_xml_value ( $item_xml, 'size' ),'mbtm' );
													echo '</article>';
													break;
											}
										}
										//Content Area
										if($page_xml_val->documentElement->childNodes->length == 0){
											print_default_content_item();
										}										
									}else{
										print_default_content_item();
									}
							   ?>
							</div>
						</div>
						<?php
						wp_reset_query();
						wp_reset_postdata();
						global $post,$post_id;
						$page_builder_full = get_post_meta ( $post->ID, "cp-show-full-layout", true );      
						if($page_builder_full == 'No'){
							$sidebar_class = '';
							$content_class = '';
							$sidebar = get_post_meta ( $post->ID, 'page-option-sidebar-template', true );
							$sidebar_class = sidebar_func($sidebar);
							$left_sidebar = get_post_meta ( $post->ID, "page-option-choose-left-sidebar", true );
							$right_sidebar = get_post_meta ( $post->ID, "page-option-choose-right-sidebar", true );
						}else{
							$sidebar_class = array();
							$content_class = array();
							$sidebar = array();
							$left_sidebar = '';
							$right_sidebar = '';
						}	
						if($sidebar == "both-sidebar-right"){ ?>
							<div id="block_second" class="sidebar side-bar <?php echo $sidebar_class[0];?>">
								<?php dynamic_sidebar( $left_sidebar ); ?>
							</div>
							<?php
						}
						if($sidebar == 'both-sidebar-right' || $sidebar == "right-sidebar" || $sidebar == "both-sidebar"){ ?>
							<div id="block_second_right" class="sidebar side-bar <?php echo $sidebar_class[0];?>">
								<?php dynamic_sidebar( $right_sidebar );?>
							</div>
						<?php } ?>
					</div>
				</div>
		</div>
		<div class="clearfix clear"></div>
	</div>	
	<?php
		//Reset all data now
		wp_reset_query();
		wp_reset_postdata();
	?>
<div class="clear"></div>
<?php get_footer(); 

}
?>