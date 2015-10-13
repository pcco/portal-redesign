<?php

	/*
	*	CrunchPress Blog Item File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file contains the function that can print each blog item in 
	*	different conditions.
	*	---------------------------------------------------------------------
	*/
	
	// size is when no sidebar, side2 is use when 1 sidebar, side 3 is use when 3 sidebar
	if( $cp_is_responsive ){
		$blog_div_listing_num_class = array(
			"Full-Image" => array("index"=>"1", "class"=>"sixteen ", "size"=>array(1170,350), "size2"=>array(770, 265), "size3"=>array(570,300)),
			"Small-Thumbnail" => array("index"=>"2", "class"=>"sixteen", "size"=>array(175,155), "size2"=>array(175,155), "size3"=>array(175,155)));
	}	
	
	// Print blog item
	function print_blog_item($item_xml){ ?>
		<div class="blog-listing-content">
		<?php
		global $paged,$post,$sidebar,$blog_div_listing_num_class,$counter,$post_id;
		
		if(empty($paged)){
			$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
		}
		
		// Post Per Page Default
		$get_default_nop = get_option('posts_per_page');
		
		// get the blog meta value		
		$header = find_xml_value($item_xml, 'header');
		$num_fetch = find_xml_value($item_xml, 'num-fetch');
		$num_excerpt = find_xml_value($item_xml, 'num-excerpt');
		$category = find_xml_value($item_xml, 'category');
		$layout_select = find_xml_value($item_xml, 'layout_select');
		

		
		//Pagination default wordpress
		if(find_xml_value($item_xml, "pagination") == 'Wp-Default'){
			$num_fetch = get_option('posts_per_page');
		}else if(find_xml_value($item_xml, "pagination") == 'Theme-Custom'){
			$num_fetch = find_xml_value($item_xml, 'num-fetch');
		}else{}
		
		
		// print header
		if(!empty($header)){ ?>
				<h2 class="h-style"><?php echo $header;?></h2>
		<?php
		}
		echo '<div class="blog_listing row-fluid">';
		$counter_blog = 0;
		// Get Post From Database
		if($category <> '0'){
			query_posts(array( 
				'post_type' 		=> 'post',
				'posts_per_page'	=> $num_fetch,
				'paged'				=> $paged,
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'terms' => $category,
						'field' => 'term_id',
					)
				),
				'orderby' => 'title',
				'order' => 'ASC' )
			);
		}else{
			query_posts(array( 
				'post_type' => 'post',
				'paged'				=> $paged,
				'posts_per_page' => $num_fetch,
				'orderby' => 'title',
				'order' => 'ASC' )
			);
		
		
		}
		while( have_posts() ){
			the_post();
			global $post, $post_id;
			
			// Get Post Meta Elements detail 
			$post_social = '';
			$sidebar = '';
			$right_sidebar = '';
			$left_sidebar = '';
			$thumbnail_types = '';
			
			$post_format = get_post_meta($post->ID, 'post_format', true);
			$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);
			if($post_detail_xml <> ''){
				$cp_post_xml = new DOMDocument ();
				$cp_post_xml->loadXML ( $post_detail_xml );
				$post_social = find_xml_value($cp_post_xml->documentElement,'post_social');
				$sidebar = find_xml_value($cp_post_xml->documentElement,'sidebar_post');
				$right_sidebar = find_xml_value($cp_post_xml->documentElement,'right_sidebar_post');
				$left_sidebar = find_xml_value($cp_post_xml->documentElement,'left_sidebar_post');
				$thumbnail_types = find_xml_value($cp_post_xml->documentElement,'post_thumbnail');
				$video_url_type = find_xml_value($cp_post_xml->documentElement,'video_url_type');
				$select_slider_type = find_xml_value($cp_post_xml->documentElement,'select_slider_type');	
				$audio_url_type = find_xml_value($cp_post_xml->documentElement,'audio_url_type');	
				
			}
			
			// get the item class and size from array
			$item_type = 'Full-Image';
			$item_class = $blog_div_listing_num_class[$item_type]['class'];
			$item_index = $blog_div_listing_num_class[$item_type]['index'];
			if( $sidebar == "no-sidebar" ){
				$item_size = $blog_div_listing_num_class[$item_type]['size'];
			}else if ( $sidebar == "left-sidebar" || $sidebar == "right-sidebar" ){
				$item_size = $blog_div_listing_num_class[$item_type]['size2'];
			}else{
				$item_size = $blog_div_listing_num_class[$item_type]['size3'];
				$item_class = 'both_sidebar_class';
			} 
			
			
			if($thumbnail_types == 'Image'){
				$mask_html = '';
				$no_image_class = 'no-image';
				$image_size = array(1170,350);
			}else if($thumbnail_types == 'Slider'){
				$mask_html = '';
				$no_image_class = '';
				$image_size = array(1170,350);
			}else if($thumbnail_types == 'Video'){
				$mask_html = '';
				$no_image_class = '';
				$image_size = array(1170,350);
			}else{
				$mask_html = '';
				$no_image_class = 'no-image';
				$image_size = array(1170,350);
			}
			$thumbnail_id = get_post_thumbnail_id( $post->ID );
			$image_thumb = wp_get_attachment_image_src($thumbnail_id, array(1170,350));
			if($image_thumb[1] == '1600'){
				$mask_html = '<div class="mask">
					<a href="'.get_permalink().'#comments" class="anchor"><span> </span> <i class="fa fa-comment"></i></a>
					<a href="'.get_permalink().'" class="anchor"> <i class="fa fa-link"></i></a>
				</div>';
				$no_image_class = 'image-exists';
			}	
			if($counter_blog % 2 == 0 ){
				if($layout_select == 'Half Width'){$item_class = 'span6 first';}else{$item_class = 'post-box';}
				$item_div_clear = '<div class="clear"></div>';
				
			}else{
				if($layout_select == 'Half Width'){$item_class = 'span6';}else{$item_class = 'post-box';}
				$item_div_clear = '';
			}$counter_blog++;
			echo $item_div_clear;
			$counter_track = $counter.$post->ID; ?>
			<!--BLOG LIST ITEM START-->
			<div <?php post_class($item_class); ?>>
				<div class="blog-posts-box">
					<div class="frame"><?php echo print_blog_thumbnail($post->ID,$image_size);?></div>
					<div class="text-box">
						<div class="<?php if($layout_select == 'Half Width'){echo 'span6';}else{echo 'span4';}?>">
							<div class="left">
								<strong class="title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></strong>
								<ul>
									<li><a href="<?php echo get_permalink();?>"><?php _e('By:','crunchpress');?> <?php echo get_the_author();?></a></li>
									<li><a href="<?php echo get_permalink();?>"><?php _e('Posted on:','crunchpress');?> <?php echo get_the_date(get_option('date_format'));?></a></li>
									<li><?php
									//Get Post Comment 
									comments_popup_link( __('0 Comment','crunchpress'),
									__('1 Comment','crunchpress'),
									__('% Comments','crunchpress'), '',
									__('Comments are off','crunchpress') );
									
									?></li>
									<li class="post_tags"><?php the_tags('','','');?></li>
								</ul>
							</div>
						</div>
						<div class="right <?php if($layout_select == 'Half Width'){echo 'span6';}else{echo 'span8';}?>">
							<p>
							<?php 
							//Excerpt Function for Listing
							if(strlen(get_the_excerpt()) < $num_excerpt){
								echo strip_tags(get_the_excerpt());
							}else{
								echo strip_tags(mb_substr(get_the_content(),0,$num_excerpt));
							}
							?>
							</p>
							<?php if(strlen(get_the_excerpt() > $num_excerpt)){?> <a href="<?php echo get_permalink();?>" class="readmore"><?php echo __('Read More','crunchpress') ?></a><?php }?>
						</div>
					</div>
				</div>
			</div>	
			<!--BLOG LIST ITEM END-->
		<?php
		}//end while
		echo '</div>';
			echo '<div class="cp_load fadeIn">';
			if( find_xml_value($item_xml, "pagination") == "Theme-Custom" ){	
				pagination();
			}
			echo '</div>';
			?>
		</div>
		<?php
		wp_reset_query(); 
		wp_reset_postdata(); 		
	}	
	
	
	// Print blog item
	function print_blog_modern_item($item_xml){
		global $paged,$post,$sidebar,$blog_div_listing_num_class,$counter,$post_id;
		
		if(empty($paged)){
			$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
		}
		
		// Post Per Page Default
		$get_default_nop = get_option('posts_per_page');
		
		// get the blog meta value		
		$header = find_xml_value($item_xml, 'header');
		$num_fetch = find_xml_value($item_xml, 'num-fetch');
		$select_feature = find_xml_value($item_xml, 'select_feature');
		$category = find_xml_value($item_xml, 'category');
		
		//Pagination default wordpress
		if(find_xml_value($item_xml, "pagination") == 'Wp-Default'){
			$num_fetch = get_option('posts_per_page');
		}else if(find_xml_value($item_xml, "pagination") == 'Theme-Custom'){
			$num_fetch = find_xml_value($item_xml, 'num-fetch');
		}else{}
		
		
		// print header
		if(!empty($header)){ ?>
		<figure class="page_titlen feature_story">
			<div class="span12 first">
				<h2><?php echo $header;?></h2>
			</div>
		</figure>
		<?php
		}
		

		//If feature Post selected
		if($select_feature <> '786512'){ 
			$thumbnail_types = '';
			$post_detail_xml = get_post_meta($select_feature, 'post_detail_xml', true);
			if($post_detail_xml <> ''){
				$cp_post_xml = new DOMDocument ();
				$cp_post_xml->loadXML ( $post_detail_xml );
				$thumbnail_types = find_xml_value($cp_post_xml->documentElement,'post_thumbnail');
				$video_url_type = find_xml_value($cp_post_xml->documentElement,'video_url_type');
				$select_slider_type = find_xml_value($cp_post_xml->documentElement,'select_slider_type');				
			}
			if($thumbnail_types == 'Image'){ ?>
				<ul class="featured-story">
					<li class="span12 featured-slider">
						<?php echo get_the_post_thumbnail($select_feature, array(1170,350));?>
						<div class="post-slide-cap">
							<span class="post-type"><?php get_the_date(get_option('date_format'));?><i class="fa fa-camera"></i></span>
							<strong class="f-post-title"><a href="<?php echo get_permalink($select_feature);?>"><mark><?php echo get_the_title($select_feature)?></mark></a></strong>
						</div>
					</li>
				</ul>
			<?php
			}else{ ?>
				<ul class="featured-story">
					<li class="span12 featured-slider">
						<?php echo print_blog_modern_thumbnail($select_feature,array(1170,350));?>
						<div class="post-slide-cap">
							<span class="post-type"><?php get_the_date(get_option('date_format'));?><i class="fa fa-camera"></i></span>
							<strong class="f-post-title"><a href="<?php echo get_permalink($select_feature);?>"><mark><?php echo get_the_title($select_feature)?></mark></a></strong>
						</div>
					</li>
				</ul>
			<?php
			}
			
			//Arguments for loop
			query_posts(array(
				'posts_per_page'			=> $num_fetch,
				'paged'						=> $paged,
				'category_name'				=> $category,
				'post_type'					=> 'post',
				'post_status'				=> 'publish',
				'order'						=> 'DESC',
				'post__not_in' => array($select_feature)
			));
		}else{
			query_posts(array(
				'posts_per_page'			=> $num_fetch,
				'paged'						=> $paged,
				'category_name'				=> $category,
				'post_type'					=> 'post',
				'post_status'				=> 'publish',
				'order'						=> 'DESC',
			));
		}
		echo '<ul class="featured-story">';
		$counter_post = 0;
		while( have_posts() ){
			the_post();
			global $post, $post_id;
			
			//Get post parameters
			$thumbnail_types = '';
			$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);
			if($post_detail_xml <> ''){
				$cp_post_xml = new DOMDocument ();
				$cp_post_xml->loadXML ( $post_detail_xml );
				$thumbnail_types = find_xml_value($cp_post_xml->documentElement,'post_thumbnail');
				$video_url_type = find_xml_value($cp_post_xml->documentElement,'video_url_type');
				$select_slider_type = find_xml_value($cp_post_xml->documentElement,'select_slider_type');				
			}
			// get the item class and size from array
			$item_type = 'Full-Image';
			$item_class = $blog_div_listing_num_class[$item_type]['class'];
			$item_index = $blog_div_listing_num_class[$item_type]['index'];
			if( $sidebar == "no-sidebar" ){
				$item_size = array(150,150);
			}else if ( $sidebar == "left-sidebar" || $sidebar == "right-sidebar" ){
				$item_size = array(150,150);
			}else{
				$item_size = array(150,150);
				$item_class = 'both_sidebar_class';
			} 
			//Slider Settings
			if($select_slider_type <> 'Slider'){
				//Every Third
				if($counter_post % 3 == 0 ){ ?>	 
					<li class="span4 first"> 
						<?php echo print_blog_modern_thumbnail($post->ID, $item_size);?>
						<div class="post-slide-cap modern-dec">
							<span class="post-type"><?php get_the_date(get_option('date_format'));?><i class="fa fa-camera"></i></span>
							<strong class="f-post-title"><a href="<?php echo get_permalink();?>"><mark><?php echo get_the_title()?></mark></a></strong>
						</div>
					</li>
				<?php }else{ ?>
					<li class="span4"> 
						<?php echo print_blog_modern_thumbnail($post->ID, $item_size);?>
						<div class="post-slide-cap modern-dec">
							<span class="post-type"><?php get_the_date(get_option('date_format'));?><i class="fa fa-camera"></i></span>
							<strong class="f-post-title"><a href="<?php echo get_permalink();?>"><mark><?php echo get_the_title()?></mark></a></strong>
						</div>
					</li>
				<?php } $counter_post++;
			}
			
		}//end while
		echo '</ul>';	
		wp_reset_query(); 
		wp_reset_postdata(); 		
	}	
	
	
	function print_blog_thumbnail( $post_id, $item_size ){
		global $counter;
		//Get Post Meta Options
		$img_html = '';
		$thumbnail_types = '';
		$video_url_type = '';
		$select_slider_type = '';
		$post_detail_xml = get_post_meta($post_id, 'post_detail_xml', true);
		if($post_detail_xml <> ''){
			$cp_post_xml = new DOMDocument ();
			$cp_post_xml->loadXML ( $post_detail_xml );
			$thumbnail_types = find_xml_value($cp_post_xml->documentElement,'post_thumbnail');
			$audio_url_type = find_xml_value($cp_post_xml->documentElement,'audio_url_type');
			$video_url_type = find_xml_value($cp_post_xml->documentElement,'video_url_type');
			$select_slider_type = find_xml_value($cp_post_xml->documentElement,'select_slider_type');			
			//Print Image
			if( $thumbnail_types == "Image" || empty($thumbnail_types) ){
				if(get_the_post_thumbnail($post_id, $item_size) <> ''){
					$img_html = '<div class="post_featured_image thumbnail_image">';
					$img_html = $img_html . get_the_post_thumbnail($post_id, $item_size);
					$img_html = $img_html . '</div>';
				}
				//echo '<div class="mask"><a href="'.get_permalink().'"#comments" class="anchor"><span> </span> <i class="fa fa-comment"></i></a><a href="'. get_permalink().'" class="anchor"> <i class="fa fa-link"></i></a></div>';
			}else if( $thumbnail_types == "Video" ){
				//Print Video
				if($video_url_type <> ''){
					$img_html = '<div class="post_featured_image thumbnail_image">';
					$img_html = $img_html . '<div class="blog-thumbnail-video">';
					//echo cp_get_width($item_size);
					if(cp_get_width($item_size) == '175'){
						$img_html = $img_html . get_video($video_url_type, cp_get_width($item_size), cp_get_height($item_size));
					}else{
						$img_html = $img_html . get_video($video_url_type, '100%', cp_get_height($item_size));
					}
					$img_html = $img_html . '</div></div>';
				}
			}else if ( $thumbnail_types == "Slider" ){
				//Print Slider
				$slider_xml = get_post_meta( intval($select_slider_type), 'cp-slider-xml', true); 				
				if($slider_xml <> ''){
					$slider_xml_dom = new DOMDocument();
					$slider_xml_dom->loadXML($slider_xml);
					$slider_name='bxslider'.$counter.$post_id;				
					
					//Included Anything Slider Script/Style
					wp_register_script('cp-bx-slider', CP_PATH_URL.'/frontend/js/bxslider.min.js', false, '1.0', true);
					wp_enqueue_script('cp-bx-slider');	
					wp_enqueue_style('cp-bx-slider',CP_PATH_URL.'/frontend/css/bxslider.css');
					//Inline Style for Slider Width
					if(cp_get_width($item_size) == '175'){
						$img_html = "<style>#'". $slider_name."'{width:'".cp_get_width($item_size)."'px;height:'".cp_get_height($item_size)."'px;float:left;}</style>";
					}else{
						$img_html = "<style>#'". $slider_name."'{width:100%;height:350px;float:left;}</style>";
					}
					$img_html = '<div class="post_featured_image thumbnail_image">';
					$img_html = $img_html . print_bx_slider($slider_xml_dom->documentElement, $item_size,$slider_name);
					$img_html = $img_html . '</div>';
				}
			}else if($thumbnail_types == "Audio"){ 
				$counter_track=$counter.$post_id;	
				if($audio_url_type <> '' ){
				//Jplayer Scripts Classing After the Function Call
				wp_register_script('cp-jplayer', CP_PATH_URL.'/frontend/js/jquery.jplayer.min.js', false, '1.0', true);
				wp_enqueue_script('cp-jplayer');
					//Jplayer Music Started	
					$img_html .= '<div class="audio_player song-list">
						<figure class="main-gallery-slider default-player-style">
							<div id="jp_container_'.$counter_track.'" class="jp-video jp-video-270p">
								<div class="jp-type-playlist">
									<div id="jquery_jplayer_'.$counter_track.'" class="jp-jplayer"></div>
									<div class="jp-gui">
										<div class="jp-video-play">
											<a href="javascript:;" class="jp-video-play-icon" tabindex="1"><?php __("play","crunchpress");?></a>
										</div>
										<div class="jp-interface">
											<div class="jp-controls-holder">
												<ul class="jp-controls">
													<li><a href="javascript:;" class="jp-previous" tabindex="1"></a></li>
													<li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
													<li><a href="javascript:;" class="jp-pause" tabindex="1"></a></li>
													<li><a href="javascript:;" class="jp-next" tabindex="1"></a></li>
													
												</ul>
												<div class="jp-progress">
													<div class="jp-seek-bar">
														<div class="jp-play-bar"></div>
													</div>
												</div>
												<ul class="volume-control">
													<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"></a></li>
													<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"></a></li>
													<li class="jp-volume-bar"><div class="jp-volume-bar-value"></div></li>
													<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"></a></li>
												</ul>
												<ul class="jp-toggles">
													<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"></a></li>
													<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"></a></li>
												</ul>
											</div>
											<div class="jp-title">
												<ul>
													<li></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="jp-playlist">
										<ul>
											<!-- The method Playlist.displayPlaylist() uses this unordered list -->
											<li></li>
										</ul>
									</div>
									<div class="jp-no-solution">
										<span><?php __("Update Required","crunchpress");?></span>
										'. __("To play the media you will need to either update your browser to a recent version or update your","crunchpress").' '. __("Flash plugin","crunchpress").'.
									</div>
								</div>
							</div>
						</figure>
						<script type="text/javascript">
							//<![CDATA[
							jQuery(document).ready(function($){
								var stream = {
									
									title:"'.get_the_title().'",
									mp3:"'.$audio_url_type.'",
									poster:"http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png",
								},
								ready = false;
								$("#jquery_jplayer_'.$counter_track.'").jPlayer({
									ready: function (event) {
										ready = true;
										$(this).jPlayer("setMedia", stream);
									},
									pause: function() {
										$(this).jPlayer("clearMedia");
									},
									error: function(event) {
										if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
											// Setup the media stream again and play it.
											$(this).jPlayer("setMedia", stream).jPlayer("play");
										}
									},
									cssSelectorAncestor: "#jp_container_'.$counter_track.'",
									swfPath: "'.CP_PATH_URL.'/frontend/js/Jplayer.swf",
									supplied: "mp3",
									preload: "none",
									wmode: "window",
									keyEnabled: true
								});
							});
							//]]>
						</script>
						</div>
						';
				} // No MP3 Song
			}
		}
		return $img_html;
	}
	
	
	// print the blog thumbnail
	function print_blog_modern_thumbnail( $post_id, $item_size ){
		global $counter;
		//Get Post Meta Options
		$img_html = '';
		$thumbnail_types = '';
		$video_url_type = '';
		$select_slider_type = '';
		$post_detail_xml = get_post_meta($post_id, 'post_detail_xml', true);
		if($post_detail_xml <> ''){
			$cp_post_xml = new DOMDocument ();
			$cp_post_xml->loadXML ( $post_detail_xml );
			$thumbnail_types = find_xml_value($cp_post_xml->documentElement,'post_thumbnail');
			$video_url_type = find_xml_value($cp_post_xml->documentElement,'video_url_type');
			$select_slider_type = find_xml_value($cp_post_xml->documentElement,'select_slider_type');			
			//Print Image
			if( $thumbnail_types == "Image" || empty($thumbnail_types) ){
				if(get_the_post_thumbnail($post_id, $item_size) <> ''){
					$img_html = '<div class="post_featured_image thumbnail_image">';
					$img_html = $img_html . get_the_post_thumbnail($post_id, $item_size);
					$img_html = $img_html . '</div>';
				}
				//echo '<div class="mask"><a href="'.get_permalink().'"#comments" class="anchor"><span> </span> <i class="fa fa-comment"></i></a><a href="'. get_permalink().'" class="anchor"> <i class="fa fa-link"></i></a></div>';
			}else if( $thumbnail_types == "Video" ){
				//Print Video
				if($video_url_type <> ''){
					$img_html = '<div class="post_featured_image thumbnail_image">';
					$img_html = $img_html . '<div class="blog-thumbnail-video">';
					//echo cp_get_width($item_size);
					if(cp_get_width($item_size) == '175'){
						$img_html = $img_html . get_video($video_url_type, cp_get_width($item_size), cp_get_height($item_size));
					}else{
						$img_html = $img_html . get_video($video_url_type, '100%', cp_get_height($item_size));
					}
					$img_html = $img_html . '</div></div>';
				}
			}else if ( $thumbnail_types == "Slider" ){
				//Print Slider
				$slider_xml = get_post_meta( intval($select_slider_type), 'cp-slider-xml', true); 				
				if($slider_xml <> ''){
					$slider_xml_dom = new DOMDocument();
					$slider_xml_dom->loadXML($slider_xml);
					$slider_name='bxslider'.$counter.$post_id;				
					//Included Anything Slider Script/Style
					wp_register_script('cp-bx-slider', CP_PATH_URL.'/frontend/js/bxslider.min.js', false, '1.0', true);
					wp_enqueue_script('cp-bx-slider');	
					wp_enqueue_style('cp-bx-slider',CP_PATH_URL.'/frontend/css/bxslider.css');
					if(cp_get_width($item_size) == '175'){
						$img_html = "<style>#'". $slider_name."'{width:'".cp_get_width($item_size)."'px;height:'".cp_get_height($item_size)."'px;float:left;}</style>";
					}else{
						$img_html = "<style>#'". $slider_name."'{width:100%;height:350px;float:left;}</style>";
					}
					$img_html = '<div class="post_featured_image thumbnail_image">';
					$img_html = $img_html . print_bx_post_slider($slider_xml_dom->documentElement, $item_size,$slider_name);
					$img_html = $img_html . '</div>';
				}
			}else if($thumbnail_types == "Audio"){ 
				if(get_the_post_thumbnail($post_id, $item_size) <> ''){
					$img_html = '<div class="post_featured_image thumbnail_image">';
					$img_html = $img_html . get_the_post_thumbnail($post_id, $item_size);
					$img_html = $img_html . '</div>';
				}
			}
		}
		return $img_html;
	}
	
	//Print News on Frontpage
	function print_news_item($item_xml){

		global $paged,$post,$sidebar,$blog_div_listing_num_class,$post_id,$counter;
		echo '<div id="news-content-'.$counter.'">';
		
		
		if(empty($paged)){
			$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
		}
		
		//Get Thumbnail Options
		$thumbnail_types = '';
		$post_detail_xml = get_post_meta($post_id, 'post_detail_xml', true);
		if($post_detail_xml <> ''){
			$cp_post_xml = new DOMDocument ();
			$cp_post_xml->loadXML ( $post_detail_xml );
			$thumbnail_types = find_xml_value($cp_post_xml->documentElement,'post_thumbnail');
		}
				
		// get the blog meta value		
		$header = find_xml_value($item_xml, 'header');
		$num_fetch = find_xml_value($item_xml, 'num-fetch');
		$num_excerpt = find_xml_value($item_xml, 'num-excerpt');
		$news_layout = find_xml_value($item_xml, 'news-layout');
		
		$category = find_xml_value($item_xml, 'category');
		
		// print header
		if(!empty($header)){
			echo '<h2 class="h-style">' . $header . '</h2>';
		}
		
		//Pagination default wordpress
		if(find_xml_value($item_xml, "pagination") == 'Wp-Default'){
			$num_fetch = get_option('posts_per_page');
		}else if(find_xml_value($item_xml, "pagination") == 'Theme-Custom'){
			$num_fetch = find_xml_value($item_xml, 'num-fetch');
		}else{}
		
		if($category == '0'){
			//Popular Post 
			query_posts(
				array( 
				'post_type' => 'post',
				'paged'				=> $paged,
				'posts_per_page' => $num_fetch,
				//'ignore_sticky_posts' => true,
				'orderby' => 'title',
				'order' => 'ASC' )
			);
		}else{
			//Popular Post 
			query_posts(
				array( 
				'post_type' => 'post',
				'posts_per_page' => $num_fetch,
				'paged'				=> $paged,
				//'ignore_sticky_posts' => true,
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'terms' => $category,
						'field' => 'term_id',
					)
				),
				'orderby' => 'title',
				'order' => 'ASC' )
			);
		}
		
		$counter_news = 0;
		while( have_posts() ){
			the_post();
			$counter_news++;
			global $post, $post_id;
		//Print All post from News
		
			  // get the item class and size from array
			$item_type = 'Full-Image';
			$item_class = $blog_div_listing_num_class[$item_type]['class'];
			$item_index = $blog_div_listing_num_class[$item_type]['index'];
			if( $sidebar == "no-sidebar" ){
				$item_size = $blog_div_listing_num_class[$item_type]['size'];
			}else if ( $sidebar == "left-sidebar" || $sidebar == "right-sidebar" ){
				$item_size = $blog_div_listing_num_class[$item_type]['size2'];
			}else{
				$item_size = $blog_div_listing_num_class[$item_type]['size3'];
				$item_class = 'both_sidebar_class';
			}
			if($news_layout == 'Short Layout'){ ?>
			<div class="latest-news row-fluid">
				<div class="frame span6"><?php echo print_blog_thumbnail( $post->ID, array(360,300) );?></div>
				<div class="text-box span6">
					<strong class="title"><a href="<?php echo get_permalink();?>"><?php if(strlen(get_the_title()) > 23){ echo substr(get_the_title(),0,23).'...' ;}else{echo get_the_title();}?></a></strong>
					<div class="date-row">
						<a href="<?php echo get_permalink();?>" class="link"><i class="fa fa-calendar"></i><?php echo get_the_date(get_option("date_format"));?></a>
						<?php comments_popup_link( __('<i class="fa fa-comments-o"></i> 0 Comment','crunchpress'),__('<i class="fa fa-comments-o"></i> 1 Comment','crunchpress'),__('<i class="fa fa-comments-o"></i> % Comments','crunchpress'), '',__('<i class="fa fa-comments-o"></i> Comments are off','crunchpress') );?>
					</div>
					<p><?php echo substr(get_the_excerpt(),0, $num_excerpt);?></p>
					<?php if(strlen(get_the_excerpt() > $num_excerpt)){?> <a href="<?php echo get_permalink();?>" class="readmore"><?php echo __('Read More','crunchpress') ?></a><?php }?>
				</div>
			</div> 
			<?php }else{ ?>
			<div class="latest-news row-fluid">
				<div class="frame span4"><?php echo print_blog_thumbnail( $post->ID, array(360,300) );?></div>
				<div class="text-box span8">
					<strong class="title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></strong>
					<div class="date-row">
						<a href="<?php echo get_permalink();?>" class="link"><i class="fa fa-calendar"></i><?php echo get_the_date(get_option("date_format"));?></a>
						<div class="post_tags"><?php the_tags('<i class="fa fa-pencil"></i>','','');?></div>
						<?php comments_popup_link( __('<i class="fa fa-comments-o"></i> 0 Comment','crunchpress'),__('<i class="fa fa-comments-o"></i> 1 Comment','crunchpress'),__('<i class="fa fa-comments-o"></i> % Comments','crunchpress'), '',__('<i class="fa fa-comments-o"></i> Comments are off','crunchpress') );?>
					</div>
					<p><?php echo substr(get_the_excerpt(),0, $num_excerpt);?></p>
					<?php if(strlen(get_the_excerpt() > $num_excerpt)){?> <a href="<?php echo get_permalink();?>" class="readmore"><?php echo __('Read More','crunchpress') ?></a><?php }?>
				</div>
			</div> 
		<?php
			}
		}//end while
			if( find_xml_value($item_xml, "pagination") == "Theme-Custom" ){	
				pagination();
			}
		echo '</div>';
		echo '<span id="loader"></span>';
		
	
	}	
	
	
	//Latest Show For DJ
	function print_latest_show_item($item_xml){
		global $post,$counter;
		
		//Fetch elements data from database
		$header = find_xml_value($item_xml, 'header');
		$category = find_xml_value($item_xml, 'category');
		$num_excerpt = find_xml_value($item_xml, 'num-excerpt');
		
		//Condition for Header
		if($header <> ''){ echo '<h2 class="h-style">'.$header.'</h2>';} ?>
		<script type="text/javascript">
		jQuery(document).ready(function ($) {
			"use strict";
			if ($('#news-<?php echo $counter?>').length) {
				$('#news-<?php echo $counter?>').bxSlider({
					minSlides: 1,
					maxSlides: 1,
					auto:true,
					mode:'fade',
					pagerCustom: '#bx-pager'
				});
			}
		});
		</script>
			<div class="timelines-box">
			<?php
					if($category == '0'){
					//Popular Post 
						query_posts(
							array( 
							'post_type' => 'post',
							'posts_per_page' => 3,
							//'ignore_sticky_posts' => true,
							'orderby' => 'title',
							'order' => 'ASC' )
						);
					
					}else{
						//Popular Post 
						query_posts(
							array( 
							'post_type' => 'post',
							'posts_per_page' => 3,
							//'ignore_sticky_posts' => true,
							'tax_query' => array(
								array(
									'taxonomy' => 'category',
									'terms' => $category,
									'field' => 'term_id',
								)
							),
							'orderby' => 'title',
							'order' => 'ASC' )
						);
					}
			?>
				<ul class="text-parent-cp" id="bx-pager">
				<?php 
					$counter_news = 0;
					while ( have_posts() ) { 
						the_post();
						global $post,$post_id;?>
							<li><a data-slide-index="<?php echo $counter_news;?>"><?php echo get_the_title();?></a></li>
					<?php 
						$counter_news++;
					}
						
					?>
				</ul>
				<ul id="news-<?php echo $counter?>" class="timelines-slider post-list">
					<?php
					while ( have_posts() ) { 
						the_post();
						global $post,$post_id;
						//Post Extra Information
						$thumbnail_types = '';
						$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);
						if($post_detail_xml <> ''){
							$cp_post_xml = new DOMDocument ();
							$cp_post_xml->loadXML ( $post_detail_xml );
							$thumbnail_types = find_xml_value($cp_post_xml->documentElement,'post_thumbnail');
							$video_url_type = find_xml_value($cp_post_xml->documentElement,'video_url_type');
							$select_slider_type = find_xml_value($cp_post_xml->documentElement,'select_slider_type');				
						}
						$width_class_first = '';
						$thumbnail_id = get_post_thumbnail_id( $post->ID );
						$thumbnail = wp_get_attachment_image_src( $thumbnail_id , array(1600,900) );?>
						<li>
							<?php if($thumbnail[1].'x'.$thumbnail[2] == '1600x900'){ ?><figure><?php echo get_the_post_thumbnail($post->ID, array(1600,900));?></figure>
							<div class="caption">
								<p><?php echo mb_substr(get_the_content(),0,$num_excerpt);?></p>
							</div>
							<?php }?>
						</li>
					<?php }
						wp_reset_query();
						wp_reset_postdata();
					?>	
				</ul>
				
			</div>
		<?php
	}
	
	
	//Latest Show For DJ
	function print_featured_item($item_xml){
		global $post,$counter;
		
		//Fetch elements data from database
		$header = find_xml_value($item_xml, 'header');
		$category = find_xml_value($item_xml, 'category');
		$number_posts = find_xml_value($item_xml, 'number-of-posts');
		
		//Condition for Header
		if($header <> ''){ echo '<h2 class="h-style">'.$header.'</h2>';} ?>
		<?php
		//Bx Slider Script Calling
		wp_register_script('cp-bx-slider', CP_PATH_URL.'/frontend/js/bxslider.min.js', false, '1.0', true);
		wp_enqueue_script('cp-bx-slider');	
		wp_enqueue_style('cp-bx-slider',CP_PATH_URL.'/frontend/css/bxslider.css');?>
		<script type="text/javascript">
		jQuery(document).ready(function ($) {
			"use strict";
			if ($('#feature-<?php echo $counter?>').length) {
				$('#feature-<?php echo $counter?>').bxSlider({
					minSlides: 1,
					maxSlides: 1,
					auto:true,
					mode:'fade',
					pagerCustom: '#bx-pager'
				});
			}
		});
		</script>			
				<ul id="feature-<?php echo $counter?>" class="news-listing">
					<?php
					if($category == '0'){
					//Popular Post 
						query_posts(
							array( 
							'post_type' => 'post',
							'posts_per_page' => 3,
							//'ignore_sticky_posts' => true,
							'orderby' => 'title',
							'order' => 'ASC' )
						);
					
					}else{
						//Popular Post 
						query_posts(
							array( 
							'post_type' => 'post',
							'posts_per_page' => 3,
							//'ignore_sticky_posts' => true,
							'tax_query' => array(
								array(
									'taxonomy' => 'category',
									'terms' => $category,
									'field' => 'term_id',
								)
							),
							'orderby' => 'title',
							'order' => 'ASC' )
						);
					}
					while ( have_posts() ) { 
						the_post();
						global $post,$post_id;
						//Post Extra Information
						$thumbnail_types = '';
						$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);
						if($post_detail_xml <> ''){
							$cp_post_xml = new DOMDocument ();
							$cp_post_xml->loadXML ( $post_detail_xml );
							$thumbnail_types = find_xml_value($cp_post_xml->documentElement,'post_thumbnail');
							$video_url_type = find_xml_value($cp_post_xml->documentElement,'video_url_type');
							$select_slider_type = find_xml_value($cp_post_xml->documentElement,'select_slider_type');				
						}
						$width_class_first = '';
						$thumbnail_id = get_post_thumbnail_id( $post->ID );
						$thumbnail = wp_get_attachment_image_src( $thumbnail_id , array(1170,350) );?>
						<li class="frame">
							<?php echo get_the_post_thumbnail($post->ID, array(1170,350));?>
							<div class="detail-row">
								<a href="<?php echo get_permalink();?>"><i class="fa fa-calendar"></i><?php echo get_the_date();?></a> <?php the_tags('<i class="fa fa-pencil"></i>','','');?><?php comments_popup_link( __('<i class="fa fa-comments-o"></i> 0 Comment','crunchpress'),__('<i class="fa fa-comments-o"></i> 1 Comment','crunchpress'),__('<i class="fa fa-comments-o"></i> % Comments','crunchpress'), '',__('<i class="fa fa-comments-o"></i> Comments are off','crunchpress') );?>
							</div>
							<div class="caption"> <strong class="title"><?php echo get_the_title();?></strong>
							<p><?php echo mb_substr(get_the_content(),0,150);?></p>
							</div>
						</li>
					<?php } ?>	
				</ul>
		<?php
	}