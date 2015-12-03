<?php 
/*	
*	CrunchPress Albums Post Type
*	---------------------------------------------------------------------
* 	@version	1.0
* 	@author		CrunchPress
* 	@link		http://crunchpress.com
* 	@copyright	Copyright (c) CrunchPress
*	---------------------------------------------------------------------
*	This file Contain Custom post type
*	---------------------------------------------------------------------
*/

//Check if the Function Library Parent Class exists
if(class_exists('function_library')){

	//Calling Widget File
	include_once('cp_playlist_widget.php'); //Playlist Widget
	include_once('cp_feature_sermons_widget.php'); //Feature Sermons Widget
	include_once('cp_radio_widget.php'); //Radio Sermons

	//Sermons Extended Class Start
	class cp_album_class extends function_library{
	
		//Sermons Element Array Starts
		public $sermons_array =	array(
		
		
		'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-bank"),
					
			"top-bar-div17-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div17'),	

			'header'=>array(

				'title'=> 'SERMONS HEADER TITLE',

				'name'=> 'page-option-item-sermons-header-title',

				'type'=> 'inputtext'),
				
				
			'category'=>array(

				'title'=>'CHOOSE SERMONS CATEGORY',

				'name'=>'page-option-item-sermons-category',

				'options'=>array(),

				'type'=>'combobox_category',

				'hr'=> 'none',

				'description'=>'Choose the sermons category which sermons posts you want to fetched.'),
			
			'num-excerpt'=>array(					

				'title'=> 'LENGHT OF EXCERPT',

				'name'=> 'page-option-item-sermons-num-excerpt',

				'type'=> 'inputtext',

				'default'=> 100,

				'description'=>'Set the sermons description content character length.'),			
				
			"top-bar-div17-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div17'),	
			
			"top-bar-div18-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div18'),			
			
			'sermon_layout'=>array(

				'title'=>'SERMONS LAYOUT',

				'name'=>'page-option-item-sermons-layout',

				'type'=> 'combobox',

				'options'=>array('0'=>'Grid', '1'=>'Full View'),

				'hr'=> 'none',

				'description'=>'Select sermon layout from here, Grid, Or Full Layout.'),
				
			'pagination'=>array(

				'title'=>'ENABLE PAGINATION',

				'name'=>'page-option-item-sermons-pagination',

				'type'=> 'combobox',

				'options'=>array('0'=>'Wp-Default', '1'=>'Theme-Custom','2'=>'No-Pagination'),

				'hr'=> 'none',

				'description'=>'Pagination will only appear when the number of sermons posts is greater than the number of fetched item in one page you can also select wordpress default pagination that can be added from settings.'),
			
			'num-fetch'=>array(					

				'title'=> 'NUMBER OF SERMONS TO SHOW',

				'name'=> 'page-option-item-sermons-num-fetch',

				'type'=> 'inputtext',

				'default'=> 5,
				
				'class'=>'sermons-fetch-item',

				'description'=> 'Set the number of sermons you want to fetch on one page.'),	
				
			"top-bar-div18-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div18'),		

		);
		//Array for Songs of the Week to Print its Elemet in page Builder
		public $featured_pastors = array(
		
			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "icon-pastor"),
				
			"top-bar-div19-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div19'),

			'header'=>array(

				'title'=> 'HEADER TITLE',

				'name'=> 'page-option-featured-pastor-title',

				'type'=> 'inputtext'),
				
			'category'=>array(

				'title'=>'CHOOSE CATEGORY',

				'name'=>'page-option-featured-pastor-category',

				'options'=>array(),

				'type'=>'combobox_category',

				'hr'=> 'none',

				'description'=>'Choose the category you want the pastor/sermons to be fetched.'),

			"top-bar-div19-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div19'),
				
		);
		
		//Array for Newest Sermons to Print its Elemet in page Builder
		public $latest_sermons = array(
		
		'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-bank"),
				
			"top-bar-div20-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div20'),	

			'header'=>array(

				'title'=> 'SERMONS HEADER TITLE',

				'name'=> 'page-option-latest-sermon-title',

				'type'=> 'inputtext'),
				
			'category'=>array(

				'title'=>'CHOOSE CATEGORY',

				'name'=>'page-option-newest-sermon-category',

				'options'=>array(),

				'type'=>'combobox_category',

				'hr'=> 'none',

				'description'=>'Choose the category you want the latest sermons to be fetched.'),

			"top-bar-div20-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div20'),
		);
		
		//Array for Newest Sermons to Print its Elemet in page Builder
		public $pastor_gallery = array(
		
		'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "icon-sermons"),
				
			"top-bar-div120-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div120'),	

			'header'=>array(

				'title'=> 'PASTORS GALLERY HEADER TITLE',

				'name'=> 'page-option-gal-pastor-title',

				'type'=> 'inputtext'),
				
			'category'=>array(

				'title'=>'CHOOSE CATEGORY',

				'name'=>'page-option-gal-pastor-category',

				'options'=>array(),

				'type'=>'combobox_category',

				'hr'=> 'none',

				'description'=>'Choose the category you want the sermons/pastors to be fetched.'),
				
			'num-fetch'=>array(					

				'title'=> 'NUMBER OF SERMONS TO SHOW',

				'name'=> 'page-option-sermons-num-fetch',

				'type'=> 'inputtext',

				'default'=> 5,
				
				'class'=>'sermons-fetch-music',

				'description'=> 'Set the number of sermons you want to fetch on one page.'),		

			"top-bar-div120-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div120'),
		);
		
		
		//Array for Songs of the Week to Print its Elemet in page Builder
		public $sermons_of_week = array(
		
		
		'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "icon-sermons"),
				
			"top-bar-div21-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div21'),	

			'header'=>array(

				'title'=> 'HEADER TITLE',

				'name'=> 'page-option-sermons-title',

				'type'=> 'inputtext'),
				
			'song_title'=>array(

				'title'=>'CHOOSE SERMONS',

				'name'=>'page-option-sermons-category',

				'options'=>array(),

				'type'=>'combobox_post',

				'hr'=> 'none',

				'description'=>'Choose the sermons you want to be fetched.'),	
			
			"top-bar-div21-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div21'),	
		);
		//Sermons Element Array Ends
		
		
		//Size Elements Array Starts
		public $sermons_size_array = array('element1-1'=>'1/1');
			
		//Size Elements Array Starts
		public $sermons_newest_array = array('element1-1'=>'1/1',);
		
		public $pastors_size_array = array('element1-1'=>'1/1');	
		
		public $pastorgal_size_array = array('element2-3'=>'2/3','element1-1'=>'1/1');	
		
		public $sermons_song_size_array = array('element1-2'=>'1/2');	
		//Size Elements Array Ends
		
		//Adding Size Array to page Builder Element
		public function page_builder_size_class(){
		global $div_size;
			$div_size['Sermons'] = $this->sermons_size_array;	  
			//$div_size['Pastors'] = $this->pastors_size_array;	  
			//$div_size['Single-Sermon'] = $this->sermons_song_size_array;	
			//$div_size['Latest-Sermon'] = $this->sermons_newest_array;	
			//$div_size['Pastor-Gallery'] = $this->pastorgal_size_array;
		}
		
		//Adding Albums Element to Page Builder
		public function page_builder_element_class(){
		global $page_meta_boxes;
		  $page_meta_boxes['Page Item']['name']['Sermons'] = $this->sermons_array;
		  // $page_meta_boxes['Page Item']['name']['Pastors'] = $this->featured_pastors;
		  //$page_meta_boxes['Page Item']['name']['Latest-Sermon'] = $this->latest_sermons;
		  // $page_meta_boxes['Page Item']['name']['Pastor-Gallery'] = $this->pastor_gallery;
		  
		  
		  $page_meta_boxes['Page Item']['name']['Sermons']['category']['options'] = function_library::get_category_list_array( 'sermons-category' );
		  // $page_meta_boxes['Page Item']['name']['Pastors']['category']['options'] = function_library::get_category_list_array( 'sermons-category' );
		  //$page_meta_boxes['Page Item']['name']['Latest-Sermon']['category']['options'] = function_library::get_category_list_array( 'sermons-category' );
		  // $page_meta_boxes['Page Item']['name']['Pastor-Gallery']['category']['options'] = function_library::get_category_list_array( 'sermons-category' );
		  $page_meta_boxes['Top Slider Sermons']['options'] = function_library::get_title_list_array( 'sermons' );
		  
		  // $page_meta_boxes['Page Item']['name']['Single-Sermons'] = $this->sermons_of_week;
		  // $page_meta_boxes['Page Item']['name']['Single-Sermons']['sermons_title']['options'] = function_library::get_title_list_array( 'sermons' );
		}
		
		//Adding Add Action Hook Start of Class
		public function __construct(){
			add_action( 'init', array( $this, 'create_sermons' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_sermons_option' ) );
			add_action( 'save_post', array( $this, 'save_sermons_option_meta' ) );
			
			//Add Action Hook to Submit query
			add_action('wp_ajax_nopriv_post-like', array( $this, 'post_like'));
			add_action('wp_ajax_post-like', array( $this, 'post_like'));
			
			add_action('wp_ajax_nopriv_update_rating', array( $this, 'update_rating'));
			add_action('wp_ajax_update_rating', array( $this, 'update_rating'));
		}

		
		//Create Albums	
		public function create_sermons() {
			
			$labels = array(
				'name' => _x('Sermons', 'Sermons General Name', 'crunchpress'),
				'singular_name' => _x('Sermons Item', 'Sermons Singular Name', 'crunchpress'),
				'add_new' => _x('Add New', 'Add New Sermons Name', 'crunchpress'),
				'add_new_item' => __('Add New Sermons', 'crunchpress'),
				'edit_item' => __('Edit Sermons', 'crunchpress'),
				'new_item' => __('New Sermons', 'crunchpress'),
				'view_item' => __('View Sermons', 'crunchpress'),
				'search_items' => __('Search Sermons', 'crunchpress'),
				'not_found' =>  __('Nothing found', 'crunchpress'),
				'not_found_in_trash' => __('Nothing found in Trash', 'crunchpress'),
				'parent_item_colon' => ''
			);
			
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => 'dashicons-book',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'rewrite' => array('slug' => 'sermons', 'with_front' => false)
			  ); 
			  
			register_post_type( 'sermons' , $args);
			
			register_taxonomy(
				"sermons-category", array("sermons"), array(
					"hierarchical" => true,
					"label" => "Sermons Categories", 
					"singular_label" => "Sermons Categories", 
					"rewrite" => true));
			register_taxonomy_for_object_type('sermons-category', 'sermons');
			
			register_taxonomy(
				"sermons-tag", array("sermons"), array(
					"hierarchical" => false, 
					"label" => "Sermons Tag", 
					"singular_label" => "Sermons Tag", 
					"rewrite" => true));
			register_taxonomy_for_object_type('sermons-tag', 'sermons');
			
		}
		
		
		//Extra Field Area Added in Sermons
		public function add_sermons_option(){	
		
			add_meta_box('event-option', __('Sermons Options','crunchpress'), array($this,'add_sermons_option_element'),
				'sermons', 'normal', 'high');
				
		}

		//Sermons Extra Fields and Form
		public function add_sermons_option_element(){
		
			//Empty Variables
			$event_detail_xml = '';
			$event_social = '';
			$sidebar_event = '';
			$right_sidebar_event = '';
			$left_sidebar_event = '';
			$event_thumbnail = '';
			$video_url_type = '';
			$select_slider_type = '';
			$amazon_url_type = '';
			$itune_url_type = '';
			$soundcloud_url_type = '';
			
			//All Request Convert into Variable
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
			
			global $post,$post_id;
			//Fetching Sermons Detail extra field values
			$sermons_detail_xml = get_post_meta($post->ID, 'sermons_detail_xml', true);
			if($sermons_detail_xml <> ''){
				$cp_sermons_xml = new DOMDocument ();
				$cp_sermons_xml->loadXML ( $sermons_detail_xml );
				$event_social = find_xml_value($cp_sermons_xml->documentElement,'event_social');
				$sidebar_event = find_xml_value($cp_sermons_xml->documentElement,'sidebar_event');
				$left_sidebar_event = find_xml_value($cp_sermons_xml->documentElement,'left_sidebar_event');
				$right_sidebar_event = find_xml_value($cp_sermons_xml->documentElement,'right_sidebar_event');
				$video_url_type = find_xml_value($cp_sermons_xml->documentElement,'video_url_type');
				$soundcloud_url_type = find_xml_value($cp_sermons_xml->documentElement,'soundcloud_url_type');
			}
		?>
			<div class="event_options bootstrap_admin " id="event_backend_options" >
                <div class="op-gap"><!--my start -->
					<ul class="event_social_class recipe_class row-fluid">
						<li class="panel-input span12">
							<div>
								<h3 for="event_social" > <?php _e('SOCIAL NETWORKING', 'crunchpress'); ?> </h3>
							</div>	
							<label for="event_social"><div class="checkbox-switch <?php
							
							echo ($event_social=='enable' || ($event_social=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

						?>"></div></label>
						<input type="checkbox" name="event_social" class="checkbox-switch" value="disable" checked>
						<input type="checkbox" name="event_social" id="event_social" class="checkbox-switch" value="enable" <?php 
							
							echo ($event_social=='enable' || ($event_social=='' && empty($default)))? 'checked': ''; 
						
						?>>
						<p><?php _e('You can turn On/Off social sharing from event detail.','crunchpress'); ?></p>
						</li>
					</ul>
					<div class="clear"></div>
					<?php echo function_library::show_sidebar($sidebar_event,'right_sidebar_event','left_sidebar_event',$right_sidebar_event,$left_sidebar_event);?>
					<div class="clear"></div>
					<div class="row-fluid">
						<!--<ul class="recipe_class span4">
							<li class="panel-input">	
								<div class="panel-title">
									<h3 for="event_thumbnail"><?php _e('Select Type', 'crunchpress'); ?></h3>
								</div>
								<div class="combobox">
									<select name="event_thumbnail" id="event_thumbnail">
										<option class="Image" value="Image" <?php if( $event_thumbnail == 'Image' ){ echo 'selected'; }?>>Feature Image</option>
										<option class="Video" value="Video" <?php if( $event_thumbnail == 'Video' ){ echo 'selected'; }?>>Video</option>
										<option class="Slider" value="Slider" <?php if( $event_thumbnail == 'Slider' ){ echo 'selected'; }?>>Slider</option>
									</select>
								</div>
								<p><?php _e('Please select your post type of content.', 'crunchpress'); ?></p>
							</li>
						</ul>
						<ul class="video_class recipe_class span4">
							<li class="panel-input">
								<div class="panel-title">
									<label for="video_url_type" > <?php _e('Video URL', 'crunchpress'); ?> </label>
								</div>				
								<input type="text" name="video_url_type" id="video_url_type" value="<?php if($video_url_type <> ''){echo $video_url_type;};?>" />
								<p><?php _e('Please paste Youtube or Vimeo url.', 'crunchpress'); ?></p>
							</li>
						</ul>
						<ul class="select_slider_option recipe_class span4">
							<li class="panel-input">	
								<div class="panel-title">
									<label for="event_thumbnail"><?php _e('Select Images Slide', 'crunchpress'); ?></label>
								</div>
								<div class="combobox">
									<select name="select_slider_type" id="select_slider_type">
										<?php foreach( function_library::get_title_list_array('cp_slider') as $values){?>
											<option value="<?php echo $values->ID;?>" <?php if($select_slider_type == $values->ID){echo 'selected';}?>><?php echo $values->post_title;?></option>
										<?php }?>
									</select>
								</div>
								<p><?php _e('Please select slide to show in post.', 'crunchpress'); ?></p>
							</li>
						</ul>-->
					</div>
                </div><!--my end -->
				
				<ul class="recipe_class top-bg">
					<li><h2><?php _e('Sermon Video and SoundCloud URL', 'crunchpress'); ?></h2></li>
				</ul>
                
                <div class="op-gap row-fluid"><!--my start -->                
					<ul class="recipe_class span6">
						<li class="panel-input">
							<div class="panel-title">
								<h3 for="video_url_type" > <?php _e('Video', 'crunchpress'); ?> </h3>
							</div>
							<input type="text" name="video_url_type" id="video_url_type" value="<?php if($video_url_type <> ''){echo $video_url_type;};?>" />
							<p><?php _e('Please paste video URL here.', 'crunchpress'); ?></p>
						</li>
					</ul>
					<ul class="recipe_class span6">
						<li class="panel-input">
							<div class="panel-title">
								<h3 for="soundcloud_url_type" > <?php _e('Sound Cloud', 'crunchpress'); ?> </h3>
							</div>				
							<input type="text" name="soundcloud_url_type" id="soundcloud_url_type" value="<?php if($soundcloud_url_type <> ''){echo $soundcloud_url_type;};?>" />
							<p><?php _e('Please add sermons ID here For example https://api.soundcloud.com/tracks/142314548 add only numbers (142314548).', 'crunchpress'); ?></p>
						</li>
					</ul>
				</div> 
				<ul class="recipe_class top-bg">
					<li><h2><?php _e('Sermons', 'crunchpress'); ?></h2></li>
				</ul>
                <div class="op-gap add-music">
                
					<!--my start -->
					<ul class="recipe_class row-fluid">
						<li class="panel-title time-start span3">
							<h4><i class="icon-music"></i> <?php _e('Sermons Name', 'crunchpress'); ?></h4>
							<input type="text" class="" id="add-track-name" value="Add Track Name" rel="Add Track Name">
						</li>

						<li class="panel-title border_left time_end span3 op-upload">
							<h4><i class="icon-link"></i> <?php _e('Sermons URL', 'crunchpress'); ?></h4>
							<!--<input type="text" class="" id="add-track-title" value="Add Track URL" rel="Add Track URL">-->
							<input name="add-track-title" id="upload_image_text" class="clearme upload_image_text" type="text" value="Add Track URL" />
							<input class="upload_image_button" type="button" value="Add Track" />
						</li>

						<li class="panel-title border_left desc_start span3">
							<h4><i class="icon-file-text"></i> <?php _e('Lyrics', 'crunchpress'); ?></h4>
							<textarea id="add-track-desc" value="Enter Description here" rel="Enter description here" col="5"><?php _e('Add Lyrics Here','crunchpress');?></textarea>
						</li>

						<li class="panel-title border_left desc_start span2">
							<h4><i class="icon-download"></i> <?php _e('Download', 'crunchpress'); ?></h4>
							<div class="combobox">
								<select id="album_download">
									<option><?php _e('Yes','crunchpress');?></option>
									<option selected><?php _e('No','crunchpress');?></option>
								</select>
							</div>
						</li>

						<li class="panel-title border_left delete_btn span1">
							<h4><i class="icon-minus"></i> / <i class="icon-plus"></i> <?php _e('', 'crunchpress'); ?></h4>
							<div id="add-more-tracks" class="add-track-element"></div>
						</li>
					</ul>	
                
                
                
					<div class="clear"></div>
					<ul id="selected-element" class="selected-element nut_table_inner">
						<li class="default-element-item" id="element-item">
							<ul class="career_salary_class recipe_class row-fluid">
								<li class="panel-title span3">
									<input class="element-track-name" type="text" id="add-track-name" value="Add Track Name" rel="Add Track Name">
									<!--<span class="ingre-item-text"></span>-->
								</li>	
								<li class="panel-title border_left span3">
									<input id="upload_image_text" class="element-track-title upload_image_text" type="text" value="Add Track URL" />
									<input class="upload_image_button" type="button" value="Add Track" />
									<!--<input class="element-track-title" type="text" id="add-track-title" value="Add Track URL" rel="Add Track URL">-->
									<!--<span class="ingre-item-text"></span>-->
								</li>								
								<li class="panel-title border_left span3">
									<textarea class="element-track-desc" id="add-track-desc" rel="Add Lyrics Here" col="5"></textarea>
									<!--<span class="ingre-item-text"></span>-->
								</li>
								<li class="panel-title  border_left span2">
									<div class="combobox">
										<select class="element-track-download" id="album_download">
											<option><?php _e('Yes','crunchpress');?></option>
											<option selected><?php _e('No','crunchpress');?></option>
										</select>
									</div>
								</li>
								<li class="panel-title border_left span1"><span class="panel-delete-element"></span></li>
							</ul>
						</li>
                        
					<?php
						//Fetching All Tracks from Database
						$track_name_xml = get_post_meta($post->ID, 'track_name_xml', true);
						$track_url_xml = get_post_meta($post->ID, 'track_url_xml', true);
						$track_des_xml = get_post_meta($post->ID, 'track_des_xml', true);
						$track_down_xml = get_post_meta($post->ID, 'track_down_xml', true);
						
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
						
						//Track Description
						if($track_des_xml <> ''){	
							$ingre_des_xml = new DOMDocument();
							$ingre_des_xml->recover = TRUE;
							$ingre_des_xml->loadXML($track_des_xml);
							$children_des = $ingre_des_xml->documentElement->childNodes;
							
						}
						
						//Track Download Fetch
						if($track_down_xml <> ''){	
							$ingre_down_xml = new DOMDocument();
							$ingre_down_xml->recover = TRUE;
							$ingre_down_xml->loadXML($track_down_xml);
							$children_down = $ingre_down_xml->documentElement->childNodes;
							
						}
						
						//Combine Loop
						if($track_name_xml <> '' || $track_url_xml <> ''){
							$counter = 0;
							$nofields = $ingre_xml->documentElement->childNodes->length;
							for($i=0;$i<$nofields;$i++) { 
								$counter++;?>
								<li class="" style="display: block;">
									<ul class="career_salary_class recipe_class row-fluid">
										<li class="panel-title span3">
											<input class="" type="text" name="add-track-name[]" value="<?php echo $children_name->item($i)->nodeValue;?>">
										</li>	
										<li class="panel-title border_left span3">
											<input id="upload_image_text" class="element-track-title upload_image_text" type="text" name="add-track-title[]" value="<?php echo $children_title->item($i)->nodeValue;?>" />
											<input class="upload_image_button" type="button" value="Add Track" />
										</li>								
										<li class="panel-title border_left span3">
											<textarea class="element-item-desc" name="add-track-desc[]" col="5"><?php echo $children_des->item($i)->nodeValue;?></textarea>
										</li>
										<li class="panel-title border_left span2">
											<div class="combobox">
												<select name="album_download[]" id="album_download">
													<option <?php if($children_down->item($i)->nodeValue == 'Yes'){echo 'selected';}?>><?php _e('Yes','crunchpress');?></option>
													<option <?php if($children_down->item($i)->nodeValue == 'No'){echo 'selected';}?>><?php _e('No','crunchpress');?></option>
												</select>
											</div>
										</li>
										<li class="panel-title span1 border_left"><span class="panel-delete-element"></span></li>
									</ul>
								</li>
								<?php
							}
						} ?>
					</ul>
				</div>
				<div class="clear"></div>
				<input type="hidden" name="sermons_submit" value="sermons"/>
				<div class="clear"></div>
			</div>	
			<div class="clear"></div>
			
		<?php }
	
	//Save Album Function
	public function save_sermons_option_meta($post_id){
		
		//Empty Variables
		$event_social = '';
		$sidebars = '';
		$right_sidebar_event = '';
		$left_sidebar_event = '';
		$event_detail_xml = '';
		$amazon_url_type = '';
		$itune_url_type = '';
		$soundcloud_url_type = '';
		$event_thumbnail = '';
		$video_url_type = '';
		$select_slider_type = '';
		//Empty Variables

		//Fetch All Variables
		foreach($_REQUEST as $keys=>$values){
			$$keys = $values;
		}
		

		//Autosave
		if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
		//If Request Get Album Save these data
		if(isset($sermons_submit) AND $sermons_submit == 'sermons'){
			$new_data = '<sermon_detail>';
			$new_data = $new_data . function_library::create_xml_tag('event_social',$event_social);
			$new_data = $new_data . function_library::create_xml_tag('sidebar_event',$sidebars);
			$new_data = $new_data . function_library::create_xml_tag('right_sidebar_event',$right_sidebar_event);
			$new_data = $new_data . function_library::create_xml_tag('left_sidebar_event',$left_sidebar_event);
			$new_data = $new_data . function_library::create_xml_tag('video_url_type',$video_url_type);
			$new_data = $new_data . function_library::create_xml_tag('soundcloud_url_type',$soundcloud_url_type);
			$new_data = $new_data . '</sermon_detail>';
			//Saving Sidebar and Social Sharing Settings as XML
			$old_data = get_post_meta($post_id, 'sermons_detail_xml',true);
			function_library::save_meta_data($post_id, $new_data, $old_data, 'sermons_detail_xml');
		
			//Track Name
			$track_name_xml = '<add_track_xml>';
			if(isset($_POST['add-track-name'])){
				$track_name_item = $_POST['add-track-name'];
				if(isset($track_name_item)){
					foreach($track_name_item as $keys=>$values){
						$track_name_xml = $track_name_xml . function_library::create_xml_tag('track_name_xml',$values);
					}
				}
			}else{$track_name_xml = '<add_track_xml>';}
			$track_name_xml = $track_name_xml . '</add_track_xml>';
		
			//Save Post
			$old_data = get_post_meta($post_id, 'track_name_xml',true);
			function_library::save_meta_data($post_id, $track_name_xml, $old_data, 'track_name_xml');
			
			
			//Track URL
			$track_url_xml = '<add_url_xml>';
			if(isset($_POST['add-track-title'])){$track_url_item = $_POST['add-track-title'];
				if($track_url_item <> ' '){
					foreach($track_url_item as $keys=>$values){
						$track_url_xml = $track_url_xml . function_library::create_xml_tag('track_url_xml',$values);
					}
				}
			}else{$track_url_xml = '<add_url_xml>';}
			$track_url_xml = $track_url_xml . '</add_url_xml>';
		
			//Save Post
			$old_data = get_post_meta($post_id, 'track_url_xml',true);
			function_library::save_meta_data($post_id, $track_url_xml, $old_data, 'track_url_xml');
			
			//Track Description
			$track_des_xml = '<add_track_des_xml>';
			if(isset($_POST['add-track-desc'])){$track_des_item = $_POST['add-track-desc'];
				if($track_des_item <> ''){
					foreach($track_des_item as $keys=>$values){
						$track_des_xml = $track_des_xml . function_library::create_xml_tag('track_des_xml',$values);
					}
				}
			}else{$track_des_xml = '<add_track_des_xml>';}
			$track_des_xml = $track_des_xml . '</add_track_des_xml>';
		
			//Save Post
			$old_data = get_post_meta($post_id, 'track_des_xml',true);
			function_library::save_meta_data($post_id, $track_des_xml, $old_data, 'track_des_xml');
			
			
			//Track Download Button
			$track_down_xml = '<add_track_button_xml>';
			if(isset($_POST['album_download'])){$track_btn_item = $_POST['album_download'];
				if($track_btn_item <> ''){
					foreach($track_btn_item as $keys=>$values){
						$track_down_xml = $track_down_xml . function_library::create_xml_tag('track_down_xml',$values);
					}
				}
			}else{$track_down_xml = '<add_track_button_xml>';}
			$track_down_xml = $track_down_xml . '</add_track_button_xml>';
		
			//Save Post
			$old_data = get_post_meta($post_id, 'track_down_xml',true);
			function_library::save_meta_data($post_id, $track_down_xml, $old_data, 'track_down_xml');

		}
	}
		
	//Sermons of the Week Start
	public function print_sermons_latest_item($item_xml){ 
		global $counter;
		
		//Fetching the Values
		$header = find_xml_value($item_xml, 'header');
		$sermons_title = find_xml_value($item_xml, 'sermons_title');
		
		//Fetch All Tracks
		$track_name_xml = get_post_meta($sermons_id, 'track_name_xml', true);
		$track_url_xml = get_post_meta($sermons_id, 'track_url_xml', true);
		$track_des_xml = get_post_meta($sermons_id, 'track_des_xml', true);
		$track_down_xml = get_post_meta($sermons_id, 'track_down_xml', true);

		//Get elements by documentElement
		$track_name_array = $this->get_sermons_all_tracks($track_name_xml);
		$track_url_array = $this->get_sermons_all_tracks($track_url_xml);
		$track_lyrics_array = $this->get_sermons_all_tracks($track_des_xml);
		$track_download_array = $this->get_sermons_all_tracks($track_down_xml);

		
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
		
		//Track Description
		if($track_des_xml <> ''){	
			$ingre_des_xml = new DOMDocument();
			$ingre_des_xml->recover = TRUE;
			$ingre_des_xml->loadXML($track_des_xml);
			$children_des = $ingre_des_xml->documentElement->childNodes;
			
		}
		
		//Track Download Fetch
		if($track_down_xml <> ''){	
			$ingre_down_xml = new DOMDocument();
			$ingre_down_xml->recover = TRUE;
			$ingre_down_xml->loadXML($track_down_xml);
			$children_down = $ingre_down_xml->documentElement->childNodes;
			
		}
		
		//JPlayer Scripts
		wp_register_script('cp-jplayer', CP_PATH_URL.'/frontend/js/jquery.jplayer.min.js', false, '1.0', true);
		wp_enqueue_script('cp-jplayer');
		
		wp_register_script('cp-jplayer-playlist', CP_PATH_URL.'/frontend/js/jplayer.playlist.min.js', false, '1.0', true);
		wp_enqueue_script('cp-jplayer-playlist'); 
		$cp_album_class = new cp_album_class;
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				new jPlayerPlaylist({
					jPlayer: "#jquery_jplayer_<?php echo $counter.$sermons_title;?>",
					cssSelectorAncestor: "#jp_container_<?php echo $counter.$sermons_title;?>"
				}, [                       
					<?php 
					//Combine Loop
						$img_url_aa = 'http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png';
						if($track_name_xml <> '' || $track_url_xml <> ''){
							$counter_aa = 0;
							$nofields = $ingre_xml->documentElement->childNodes->length;
							for($i=0;$i<$nofields;$i++) {
								echo '{';
								echo 'title:"'.$children_name->item($i)->nodeValue.'",';
								echo 'Pastor:"'.$children_name->item($i)->nodeValue.'",';
								echo 'mp3:"'.$children_title->item($i)->nodeValue.'",';
								echo 'poster:"'.$img_url_aa.'"';
								echo '},';
							}
						}
					?>
				], {
					swfPath: "<?php echo CP_PATH_URL?>/frontend/js/Jplayer.swf",
					supplied: "mp3",
					wmode: "window"
				});
			});                                                     
		</script>
		<div class="weekly-songs jp_cp_default">
			<?php if($header <> ''){ ?><h2><?php echo $header;?></h2><?php }?>
			<?php if($sermons_title <> '786512'){ ?>
			<div class="weekly-songs-box">
				<figure class="span4 song-img-box">
					<?php 
					$size = array(275,290);
					echo get_the_post_thumbnail($post_id, $size);
					// $function_library = new function_library;
					// echo $function_library->cp_thumb_size($song_title,$size);
					?>
				</figure>
				<figure class="span8">
					<?php if($sermons_title <> '786512' || $sermons_title <> ''){ ?><h4><a href="<?php echo get_permalink($sermons_title);?>"><?php echo get_the_title($sermons_title);?></a></h4><?php }?>
					<span class="sub-title2">
					<?php
						//Album Description by ID
						if($sermons_title <> ''){
							$description = get_post($sermons_title);
							if(strlen($description->post_excerpt) < 270 AND strlen($description->post_excerpt) <> ''){
								echo $description->post_excerpt;
							}else{
								echo mb_substr($description->post_content,0,270);
							}
						}
					?>
					</span>
				</figure>
				<figure class="element1-1 player3 first">
					<div id="jquery_jplayer_<?php echo $counter.$sermons_title;?>" class="jp-jplayer"></div>
					<div id="jp_container_<?php echo $counter.$sermons_title;?>" class="jp-audio">
						<div class="jp-type-playlist">
							<div class="jp-gui jp-interface">
								<ul class="jp-toggles">
									<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><?php _e('shuffle','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><?php _e('shuffle off','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php _e('repeat','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php _e('repeat off','crunchpress');?></a></li>
								</ul>
								<i class="icon-volume-up pull-left"></i>
								<div class="jp-volume-bar">
									<div class="jp-volume-bar-value"></div>
								</div>
								<ul class="jp-controls">
									<li><a href="javascript:;" class="jp-previous" tabindex="1"><?php _e('previous','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-play" tabindex="1"><?php _e('play','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-pause" tabindex="1"><?php _e('pause','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-next" tabindex="1"><?php _e('next','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><?php _e('mute','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><?php _e('unmute','crunchpress');?></a></li>
									<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><?php _e('max volume','crunchpress');?></a></li>
								</ul>
								<div class="jp-progress">
									<div class="jp-seek-bar">
										<div class="jp-play-bar"></div>

									</div>
								</div>
							</div>
							<div class="jp-playlist">
								<ul>
									<li></li>
								</ul>
							</div>
						</div>
					</div>
				</figure>
			</div>
			<?php 
			//if no content Available else start
			}else{
				echo '<h2>Please Select Sermons/Pastors to fetch its detail.</h2>';
			} ?>
		</div>
	<?php
	}

	//Newest Album Section
	public function print_newest_sermons_item($item_xml){
		
		global $counter,$post,$post_id;
		
		$header = find_xml_value($item_xml, 'header');
		$category_sermons = find_xml_value($item_xml, 'category');
		//Bx Slider Script Calling
		wp_register_script('cp-bx-slider', CP_PATH_URL.'/frontend/js/bxslider.min.js', false, '1.0', true);
		wp_enqueue_script('cp-bx-slider');	
		wp_enqueue_style('cp-bx-slider',CP_PATH_URL.'/frontend/css/bxslider.css');?>
		<script type="text/JavaScript">
		jQuery(document).ready(function ($) {
			"use strict";
			if ($('#newest-<?php echo $counter?>').length) {
				$('#newest-<?php echo $counter?>').bxSlider({
					minSlides: 1,
					maxSlides: 1,
					auto:true
				});
			}
		});
		</script>
		<?php if($header <> ''){ ?><h2><?php echo $header;?></h2><?php }?>
		<div class="accordian-list">
			<Section id="newest-<?php echo $counter;?>">
				<?php
				query_posts(array( 
					'post_type' => 'sermons',
					'posts_per_page' => 5,
					'tax_query' => array(
						array(
							'taxonomy' => 'sermons-category',
							'terms' => $category_sermons,
							'field' => 'term_id',
						)
					),
					'orderby' => 'title',
					'order' => 'ASC' )
				);
				$counter_one = 0;
				while( have_posts() ){
					the_post();	?>
					<div class="slide">
						<a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post_id, array(350,350));?></a>
						<div class="img-cap">
							<h3><?php echo get_the_title();?></h3>
							<strong><?php //echo get_the_expert();?></strong>
						</div>
					</div>
				<?php } //End While loop ?>
			</Section>
		</div>
		<?php
	}
	

	//Newest Album Section
	public function print_gallery_sermons_item($item_xml){
		
		global $counter,$post,$post_id;
		
		$header = find_xml_value($item_xml, 'header');
		$category_sermons = find_xml_value($item_xml, 'category');
		$number_of_sermons = find_xml_value($item_xml, 'num-fetch');
	
		if($header <> ''){ ?>
			<div class="heading-bar2">
				<a>
					<i class="icon-music pull-left"></i>
				</a>
				<strong class="h-title">
					<?php echo $header;?>
				</strong>
				<a id="search-active" class="search_click"><i class="icon-search pull-right"></i></a>
				<div class="search_album page_404">
					<div class="search-header">
						<!--<h2><?php echo __('Search for Sermons or Track','crunchpress'); ?></h2>-->
						<form class="searchform-default" method="get" id="searchform-album" action="<?php  echo home_url(); ?>/">
							<input  name="s" value="<?php the_search_query(); ?>" placeholder="<?php echo __('Search for Sermons or Track','crunchpress'); ?>" autocomplete="off" type="text" class="text error-field">
							<button type="submit"><i class="icon-search"></i></button>
						</form>		 
					</div>
				</div>
			</div>
		<?php } ?>		
			<ul class="my-music-list row-fluid">
				<?php 
				//Number of Albums
				if($number_of_sermons == '' || $number_of_sermons == 0){$number_of_sermons = 5;}
				
				//Post Query
				query_posts(
					array( 
					'post_type' => 'sermons',
					'posts_per_page' => $number_of_sermons,
					'tax_query' => array(
						array(
							'taxonomy' => 'sermons-category',
							'terms' => $category_sermons,
							'field' => 'term_id',
						)
					),
					'orderby' => 'title',
					'order' => 'ASC' )
				);
				$counter_one = 0;
				while( have_posts() ){
					the_post();		
					global $post;
						$album_id = $post->ID;
						//Fetch All Tracks
						$track_name_xml = get_post_meta($album_id, 'track_name_xml', true);
						$track_url_xml = get_post_meta($album_id, 'track_url_xml', true);
						$track_des_xml = get_post_meta($album_id, 'track_des_xml', true);
						$track_down_xml = get_post_meta($album_id, 'track_down_xml', true);
						//Get elements by documentElement
						
						//Get elements by documentElement
						$track_name_array = $this->get_album_all_tracks($track_name_xml);
						$track_url_array = $this->get_album_all_tracks($track_url_xml);
						$track_lyrics_array = $this->get_album_all_tracks($track_des_xml);
						$track_download_array = $this->get_album_all_tracks($track_down_xml);
						
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
						
						//Track Description
						if($track_des_xml <> ''){	
							$ingre_des_xml = new DOMDocument();
							$ingre_des_xml->recover = TRUE;
							$ingre_des_xml->loadXML($track_des_xml);
							$children_des = $ingre_des_xml->documentElement->childNodes;
							
						}
						
						//Track Download Fetch
						if($track_down_xml <> ''){	
							$ingre_down_xml = new DOMDocument();
							$ingre_down_xml->recover = TRUE;
							$ingre_down_xml->loadXML($track_down_xml);
							$children_down = $ingre_down_xml->documentElement->childNodes;
							
						}
						
						//JPlayer Scripts
						wp_register_script('cp-jplayer', CP_PATH_URL.'/frontend/js/jquery.jplayer.min.js', false, '1.0', true);
						wp_enqueue_script('cp-jplayer');
						
						wp_register_script('cp-jplayer-playlist', CP_PATH_URL.'/frontend/js/jplayer.playlist.min.js', false, '1.0', true);
						wp_enqueue_script('cp-jplayer-playlist'); 
						
						wp_enqueue_style('cp-music-gallery',CP_PATH_URL.'/frontend/css/music_gallery_player.css');
						
						wp_enqueue_style('album-css-gallery',CP_PATH_URL.'/frontend/css/style_css_album.css');
						
						$cp_album_class = new cp_album_class;
						?>
						
						
					<li class="span4 <?php if($counter_one % 3  ==  0){ echo 'first';}$counter_one++;?>">
						<script type="text/JavaScript">
							jQuery(document).ready(function($) {
								new jPlayerPlaylist({
									jPlayer: "#jquery_jplayer_<?php echo $counter.$album_id;?>",
									cssSelectorAncestor: "#jp_container_<?php echo $counter.$album_id;?>"
								}, [                       
									<?php 
									//Combine Loop
										$img_url_aa = 'http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png';
										if($track_name_xml <> '' || $track_url_xml <> ''){
											$counter_aa = 0;
											$nofields = $ingre_xml->documentElement->childNodes->length;
											for($i=0;$i<$nofields;$i++) {
												echo '{';
												echo 'title:"'.$children_name->item($i)->nodeValue.'",';
												echo 'artist:"'.$children_name->item($i)->nodeValue.'",';
												echo 'mp3:"'.$children_title->item($i)->nodeValue.'",';
												echo 'poster:"'.$img_url_aa.'"';
												echo '},';
											}
										}
									?>
								], 
								{
									playlistOptions: {
										enableRemoveControls: false
									},
									swfPath: "<?php echo CP_PATH_URL?>/frontend/js/Jplayer.swf",
									supplied: "mp3",
									//supplied: "webmv, ogv, m4v, oga, mp3",
									smoothPlayBar: true,
									keyEnabled: true,
									audioFullScreen: true
								});
							});                                                     
						</script>
						
						<div class="flip-container">
							<div class="flipper">
								<div class="front">
									<?php echo get_the_post_thumbnail($album_id, array(570,300));?>
								</div>
								<div class="back" style="background:#121212;">
									<div class="music-detail">
										<a href="<?php echo get_permalink();?>"><em class="song-title"><?php echo get_the_title();?></em></a>
										<figure class="music-gallery">
											<div id="jp_container_<?php echo $counter.$album_id;?>" class="jp-video jp-video-270p">
												<div class="jp-type-playlist">
													<div id="jquery_jplayer_<?php echo $counter.$album_id;?>" class="jp-jplayer"></div>
													<div class="jp-gui">
														<div class="jp-video-play">
															<a href="javascript:;" class="jp-video-play-icon" tabindex="1"><?php _e('play','crunchpress');?></a>
														</div>
														<div class="jp-interface">
															<div class="jp-progress">
																<div class="jp-seek-bar">
																	<div class="jp-play-bar"></div>
																</div>
															</div>
															<div class="jp-current-time"></div>
															<div class="jp-duration"></div>
															<div class="jp-controls-holder">
																<ul class="jp-controls">
																	<li><a href="javascript:;" class="jp-play" tabindex="1"><?php _e('play','crunchpress');?></a></li>
																	<li><a href="javascript:;" class="jp-pause" tabindex="1"><?php _e('pause','crunchpress');?></a></li>
																	<li><a href="javascript:;" class="jp-stop" tabindex="1"><?php _e('stop','crunchpress');?></a></li>
																	<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><?php _e('mute','crunchpress');?></a></li>
																	<li>
																	<div class="jp-volume-bar">
																	<div class="jp-volume-bar-value"></div>
																</div>
																	</li>
																	<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><?php _e('unmute','crunchpress');?></a></li>
																	<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><?php _e('max volume','crunchpress');?></a></li>
																</ul>
																
																<ul class="jp-toggles">
																	<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php _e('repeat','crunchpress');?></a></li>
																	<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php _e('repeat off','crunchpress');?></a></li>
																</ul>
															</div>
															<div class="cp_title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></div>
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
														<span><?php _e('Update Required','crunchpress');?></span>
														<?php _e('To play the media you will need to either update your browser to a recent version or update your','crunchpress');?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php _e('Flash plugin','crunchpress');?></a>.
													</div>
												</div>
											</div>
										</figure>							
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php } //End While loop ?>
			</ul>
		<?php
	}	
		
		
		
	//Newest Album Section
	public function print_sermons_listing_item($item_xml){
		global $counter,$post,$post_id,$paged;
		$header = find_xml_value($item_xml, 'header');
		$category_sermons = find_xml_value($item_xml, 'category');
		
		$sermon_layout = find_xml_value($item_xml, 'sermon_layout');
		
		$num_excerpt = find_xml_value($item_xml, 'num-excerpt');
		
		//Pagination Variables
		$pagination = find_xml_value($item_xml, 'pagination');
		$num_fetch = find_xml_value($item_xml, 'num-fetch');
		
		if(empty($paged)){
			$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
		}
		
		//Pagination default wordpress
		if(find_xml_value($item_xml, "pagination") == 'Wp-Default'){
			$num_fetch = get_option('posts_per_page');
		}else if(find_xml_value($item_xml, "pagination") == 'Theme-Custom'){
			$num_fetch = find_xml_value($item_xml, 'num-fetch');
		}else{}
		
		// Header Title
		if(!empty($header)){echo '<h2 class="h-style">'.$header.'</h2>';} ?>
		<div class="sermon-page">
			<ul class="sermon-row row-fluid">
			<?php
			if($category_sermons == '0'){
				//Post Query
				query_posts(
					array( 
					'post_type' => 'sermons',
					'posts_per_page' => $num_fetch,
					'paged'	=>	$paged,
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}else{
				//Post Query
				query_posts(
					array( 
					'post_type' => 'sermons',
					'posts_per_page' => $num_fetch,
					'paged'			=>	$paged,
					'tax_query' => array(
						array(
							'taxonomy' => 'sermons-category',
							'terms' => $category_sermons,
							'field' => 'term_id',
						)
					),
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}
			$counter_one = 0;
			while( have_posts() ){
				the_post();					
				global $post;				
				
				//Fetching Sermons Detail extra field values
				$sermons_detail_xml = get_post_meta($post->ID, 'sermons_detail_xml', true);
				if($sermons_detail_xml <> ''){
					$cp_sermons_xml = new DOMDocument ();
					$cp_sermons_xml->loadXML ( $sermons_detail_xml );
					$event_social = find_xml_value($cp_sermons_xml->documentElement,'event_social');
					$sidebar_event = find_xml_value($cp_sermons_xml->documentElement,'sidebar_event');
					$left_sidebar_event = find_xml_value($cp_sermons_xml->documentElement,'left_sidebar_event');
					$right_sidebar_event = find_xml_value($cp_sermons_xml->documentElement,'right_sidebar_event');
					$video_url_type = find_xml_value($cp_sermons_xml->documentElement,'video_url_type');
					$soundcloud_url_type = find_xml_value($cp_sermons_xml->documentElement,'soundcloud_url_type');
				}
				if($counter_one % 3 == 0){$item_class = 'first'; $item_div = '<div class="clear"></div>';}else{$item_class = '';$item_div = '';}$counter_one++;
				if($sermon_layout == 'Grid'){ 
					//echo $item_div; ?>
					<li class="span4 <?php echo $item_class;?>">
						<div class="sermons-box sermons-box-grid">
							<div class="frame"> 
								<div class="img-hover-div">
									<a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post->ID, array(570,300));?></a>
									<div class="caption gallery-page">
										<div class="inner gallery">
										<?php 
											echo $video_url_type;
											if($video_url_type <> ''){ 
												wp_register_script('prettyPhoto', CP_PATH_URL.'/frontend/js/jquery.prettyphoto.js', false, '1.0', true);
												wp_enqueue_script('prettyPhoto');

												wp_register_script('cp-pscript', CP_PATH_URL.'/frontend/js/pretty_script.js', false, '1.0', true);
												wp_enqueue_script('cp-pscript');	
												
												wp_enqueue_style('prettyPhoto',CP_PATH_URL.'/frontend/css/prettyphoto.css');
											}
											$counter_track = 0;
											//Fetch All Tracks
											$track_name_xml = get_post_meta($post->ID, 'track_name_xml', true);
											$track_url_xml = get_post_meta($post->ID, 'track_url_xml', true);
											$track_des_xml = get_post_meta($post->ID, 'track_des_xml', true);
											$track_down_xml = get_post_meta($post->ID, 'track_down_xml', true);
											
											//Get elements by documentElement
											$track_name_array = $this->get_sermons_all_tracks($track_name_xml);
											$track_url_array = $this->get_sermons_all_tracks($track_url_xml);
											$track_lyrics_array = $this->get_sermons_all_tracks($track_des_xml);
											$track_download_array = $this->get_sermons_all_tracks($track_down_xml);
											//Combine Loop
											if($track_name_xml <> '' || $track_url_xml <> ''){
												$counter_track = 0;
												$nofields = $track_name_array->length;
												for($i=0;$i<1;$i++) { 
												$counter_track++; ?>
												<a class="cp-sermon-box-play"><i class="fa fa-music"></i></a> 
												<?php if($video_url_type <> ''){ ?><a data-rel="prettyphoto" href="<?php echo $video_url_type;?>"><i class="fa fa-video-camera"></i></a><?php }?>
												<?php if($soundcloud_url_type <> ''){ ?><a class="cp-play-box-soundrock" ><i class="fa fa-soundcloud"></i></a><?php }?>												
												<?php if($track_download_array->item($i)->nodeValue <> 'No'){ ?><a class="download" href="<?php echo $track_download_array->item($i)->nodeValue;?>"><i class="fa fa-arrow-circle-down"></i></a><?php }?>
											<?php }?>											  
										<?php }?>
										</div>
										<?php if($soundcloud_url_type <> ''){ ?>
											<div class="soundcloud-sermon-box">
												<?php echo do_shortcode('[soundcloud type="visual-embed" url="https://api.soundcloud.com/tracks/'.$soundcloud_url_type.'" color="#1e73be" auto_play="false" hide_related="true" show_artwork_or_visual="true" width="100%" height="200" iframe="true" /]');?>
											</div>
										<?php }?>
										<?php
												$counter_track = $post->ID.$counter;
												//Fetch All Tracks
												$track_name_xml = get_post_meta($post->ID, 'track_name_xml', true);
												$track_url_xml = get_post_meta($post->ID, 'track_url_xml', true);
												$track_des_xml = get_post_meta($post->ID, 'track_des_xml', true);
												$track_down_xml = get_post_meta($post->ID, 'track_down_xml', true);
												
												//Get elements by documentElement
												$track_name_array = $this->get_sermons_all_tracks($track_name_xml);
												$track_url_array = $this->get_sermons_all_tracks($track_url_xml);
												$track_lyrics_array = $this->get_sermons_all_tracks($track_des_xml);
												$track_download_array = $this->get_sermons_all_tracks($track_down_xml);
												
												//Jplayer Music Started	
												wp_register_script('cp-jplayer', CP_PATH_URL.'/frontend/js/jquery.jplayer.min.js', false, '1.0', true);
												wp_enqueue_script('cp-jplayer'); ?>
												<figure class="main-gallery-slider sermons-box-grid-cp">
													<div id="jp_container_<?php echo $counter_track;?>" class="jp-video jp-video-270p">
														<div class="jp-type-playlist">
															<div id="jquery_jplayer_<?php echo $counter_track;?>" class="jp-jplayer"></div>
															<div class="jp-gui">
																<div class="jp-video-play">
																	<a href="javascript:;" class="jp-video-play-icon" tabindex="1"><?php _e('play','crunchpress');?></a>
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
																<span><?php _e('Update Required','crunchpress');?></span>
																<?php _e('To play the media you will need to either update your browser to a recent version or update your','crunchpress');?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php _e('Flash plugin','crunchpress');?></a>.
															</div>
														</div>
													</div>
												</figure>
												<script type="text/javascript">
													//<![CDATA[
													jQuery(document).ready(function($){
														var stream = {
															<?php
																//Loop for Tracks
																if($track_name_xml <> '' || $track_url_xml <> ''){
																	$counter_track = $post->ID.$counter;
																	$nofields = 1;
																	for($i=0;$i<$nofields;$i++) {
																		$img_url_aa = 'http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png';
																		echo 'title:"'.$track_name_array->item($i)->nodeValue.'",';
																		echo 'pastor:"'.$track_name_array->item($i)->nodeValue.'",';
																		echo 'mp3:"'.$track_url_array->item($i)->nodeValue.'",';
																		echo 'poster:"'.$img_url_aa.'",';
																	}
																}
															?>
														},
														ready = false;
														$("#jquery_jplayer_<?php echo $counter_track;?>").jPlayer({
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
															cssSelectorAncestor: "#jp_container_<?php echo $counter_track;?>",
															swfPath: "<?php echo CP_PATH_URL?>/frontend/js/Jplayer.swf",
															supplied: "mp3",
															preload: "none",
															wmode: "window",
															keyEnabled: true
														});
														$('#jp_poster_0').remove();
														$('#jp_poster_1').remove();
														$('#jp_poster_2').remove();
														$('#jp_poster_3').remove();
														$('#jp_poster_4').remove();
														$('#jp_poster_5').remove();
														$('#jp_poster_6').remove();
														$('#jp_poster_7').remove();
														$('#jp_poster_8').remove();
														$('#jp_poster_9').remove();
														$('#jp_poster_10').remove();
														$('#jp_poster_11').remove();
														$('#jp_poster_12').remove();
														$('#jp_poster_13').remove();
														$('#jp_poster_14').remove();
													});
													//]]>
												</script>
									</div>
								</div>
								<div class="text-box">
									<h4><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h4>
									<p>
									<?php 
										//Excerpt Function for Listing
										echo mb_substr(get_the_content(),0,$num_excerpt);
									?>
									</p>
									<a href="<?php echo get_permalink();?>" class="readmore"><?php _e('Read More','crunchpress');?></a>
									<div class="detail-row">
										<ul class="gallery">
											<li><a href="<?php echo get_permalink();?>"><i class="fa fa-user"></i><?php echo get_the_author();?></a></li>
											<li><a  href="<?php echo get_permalink();?>"><i class="fa fa-calendar"></i><?php echo get_the_date();?></a></li>
											<li><?php
												//Get Post Comment 
												comments_popup_link( __('<i class="fa fa-comments-o"></i>0 Comment','crunchpress'),
												__('<i class="fa fa-comments-o"></i>1 Comment','crunchpress'),
												__('<i class="fa fa-comments-o"></i>% Comments','crunchpress'), '',
												__('<i class="fa fa-comments-o"></i>Comments are off','crunchpress') );										
											?></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php }else{?>
					<li class="sermon-listing">
						<div class="sermon-box row-fluid">
							<div class="frame span4"><a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post->ID, array(360,300));?></a></div>
							<div class="text-box span8">
								<h2><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h2>
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
								<div class="detail-row">
									<ul>
										<li><a href="<?php get_permalink();?>"><i class="fa fa-user"></i><?php echo get_the_author();?></a></li>
										<li><a href="<?php get_permalink();?>"><i class="fa fa-calendar"></i><?php echo get_the_date();?></a></li>
										<li><?php the_tags('<i class="fa fa-book"></i>','','');?></li>
										<li>		
											<?php
												//Get Post Comment 
												comments_popup_link( __('<i class="fa fa-comments-o"></i>0 Comment','crunchpress'),
												__('<i class="fa fa-comments-o"></i>1 Comment','crunchpress'),
												__('<i class="fa fa-comments-o"></i>% Comments','crunchpress'), '',
												__('<i class="fa fa-comments-o"></i>Comments are off','crunchpress') );										
											?>
										</li>
									</ul>
									<?php //include_social_shares();?>
								</div>
								<ul class="list-area-cp">
									<li class="auther-box-cp">
									<?php
										//Fetch All Tracks
										$track_name_xml = get_post_meta($post->ID, 'track_name_xml', true);
										$track_url_xml = get_post_meta($post->ID, 'track_url_xml', true);
										$track_des_xml = get_post_meta($post->ID, 'track_des_xml', true);
										$track_down_xml = get_post_meta($post->ID, 'track_down_xml', true);
										
										//Get elements by documentElement
										$track_name_array = $this->get_sermons_all_tracks($track_name_xml);
										$track_url_array = $this->get_sermons_all_tracks($track_url_xml);
										$track_lyrics_array = $this->get_sermons_all_tracks($track_des_xml);
										$track_download_array = $this->get_sermons_all_tracks($track_down_xml);
										
										//Empty Variables
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
										
										//Track Description
										if($track_des_xml <> ''){	
											$ingre_des_xml = new DOMDocument();
											$ingre_des_xml->recover = TRUE;
											$ingre_des_xml->loadXML($track_des_xml);
											$children_des = $ingre_des_xml->documentElement->childNodes;
										}
										
										//Track Download Fetch
										if($track_down_xml <> ''){	
											$ingre_down_xml = new DOMDocument();
											$ingre_down_xml->recover = TRUE;
											$ingre_down_xml->loadXML($track_down_xml);
											$children_down = $ingre_down_xml->documentElement->childNodes;
											
										}
										//Jplayer Scripts Classing After the Function Call
										//Combine Loop
										if($track_name_xml <> '' || $track_url_xml <> ''){
											$counter_track = 0;
											$nofields = $children_down->length;
											for($i=0;$i<1;$i++) { 
											$counter_track++; ?>
											<div class="sermons-list-box-cp">
												<div class="text-box-cp">
													<ul class="list-area gallery">
														<?php if($video_url_type <> ''){ ?><li><a data-rel="prettyphoto" href="<?php echo $video_url_type;?>"><i class="fa fa-video-camera"></i></a></li><?php }?>
														<li><a class="cp-play"><i class="fa fa-headphones"></i></a></li>
														<?php if($soundcloud_url_type <> ''){ ?><li><a class="cp-play-soundrock" ><i class="fa fa-soundcloud"></i></a></li><?php }?>
														<?php if($children_des->item($i)->nodeValue <> ''){ ?><li><a  class="lyrics download" href="<?php echo $children_des->item($i)->nodeValue;?>"><i class="fa fa-file-text"></i></a></li><?php }?>
														<?php if($children_down->item($i)->nodeValue <> 'No'){ ?><li><a class="download" href="<?php echo $children_title->item($i)->nodeValue;?>"><i class="fa fa-arrow-circle-down"></i></a></li><?php }?>
													</ul>
													<div id="lyrics_class-<?php echo $i.$counter.$post->ID;?>" class="hide lyrics_class"><?php echo $children_des->item($i)->nodeValue;?></div>
												</div>	
											</div>	
										<?php }?>											  
									<?php }?>
									</li>
								</ul>
							</div>
							<?php if($soundcloud_url_type <> ''){ ?>
								<div class="soundcloud-sermon">
									<?php echo do_shortcode('[soundcloud type="visual-embed" url="https://api.soundcloud.com/tracks/'.$soundcloud_url_type.'" color="#1e73be" auto_play="false" hide_related="true" show_artwork_or_visual="true" width="100%" height="200" iframe="true" /]');?>
								</div>
							<?php }?>
							<?php $counter_track = $post->ID.$counter;?>
							<figure class="main-gallery-slider cp-gallery-slider-list">
								<div id="jp_container_<?php echo $counter_track;?>" class="jp-video jp-video-270p">
									<div class="jp-type-playlist">
										<div id="jquery_jplayer_<?php echo $counter_track;?>" class="jp-jplayer"></div>
										<div class="jp-gui">
											<div class="jp-video-play">
												<a href="javascript:;" class="jp-video-play-icon" tabindex="1"><?php _e('play','crunchpress');?></a>
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
													<ul class="playlist-cp">
														<li><a class="show-playlist"><i class="fa fa-list"></i></a></li>
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
											<span><?php _e('Update Required','crunchpress');?></span>
											<?php _e('To play the media you will need to either update your browser to a recent version or update your','crunchpress');?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php _e('Flash plugin','crunchpress');?></a>.
										</div>
									</div>
								</div>
							</figure>
							<script type="text/JavaScript">
								//<![CDATA[
									jQuery(document).ready(function($) {
										new jPlayerPlaylist({
											jPlayer: "#jquery_jplayer_<?php echo $counter_track;?>",
											cssSelectorAncestor: "#jp_container_<?php echo $counter_track;?>"
										}, [                       
											<?php 
											//Combine Loop
											$img_url_aa = 'http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png';
												if($track_name_xml <> '' || $track_url_xml <> ''){
													$counter_aa = 0;
													$nofields = $ingre_xml->documentElement->childNodes->length;
													for($i=0;$i<$nofields;$i++) {
														echo '{';
														echo 'title:"'.$children_name->item($i)->nodeValue.'",';
														echo 'pastor:"'.$children_name->item($i)->nodeValue.'",';
														echo 'mp3:"'.$children_title->item($i)->nodeValue.'",';
														echo 'poster:"'.$img_url_aa.'",';
														echo '},';
													}
												}
											?>
										], 
										{
											playlistOptions: {
												enableRemoveControls: true
											},
											swfPath: "<?php echo CP_PATH_URL?>/frontend/js/Jplayer.swf",
											supplied: "mp3",
											//supplied: "webmv, ogv, m4v, oga, mp3",
											smoothPlayBar: true,
											keyEnabled: true,
											audioFullScreen: true
										});
									});      
								//]]>
							</script>
						</div>
					</li>
				<?php }?>
			<?php 
			} //End While loop ?>
			</ul>
		</div>
		<?php
		//Pagination
		if( find_xml_value($item_xml, "pagination") == "Theme-Custom" ){	
			pagination();
		}
	}
	
	
	//Get All Tracks
	public function get_sermons_all_tracks($track_xml){
			//Track Name
			if($track_xml <> ''){
				$ingre_xml = new DOMDocument();
				$ingre_xml->recover = TRUE;
				$ingre_xml->loadXML($track_xml);
				return $ingre_xml->documentElement->childNodes;
			}		
		}
	
	
	//Print Artist
	public function print_pastor_item_item($item_xml){
		global $counter;
		if(class_exists('cp_album_class')){
			
			$select_layout_cp = '';
			$cp_general_settings = get_option('general_settings');
			if($cp_general_settings <> ''){
				$cp_logo = new DOMDocument ();
				$cp_logo->loadXML ( $cp_general_settings );
				$select_layout_cp = find_xml_value($cp_logo->documentElement,'select_layout_cp');
			}
			
			//Initializing Class
			$cp_album_class = new cp_album_class;
			
			//Fetch values from Page Builder
			$header = find_xml_value($item_xml, 'header');
			$category = find_xml_value($item_xml, 'category');
			
			//bx Slider for Artists
			wp_register_script('cp-bx-slider', CP_PATH_URL.'/frontend/js/bxslider.min.js', false, '1.0', true);
			wp_enqueue_script('cp-bx-slider');	
			wp_enqueue_style('cp-bx-slider',CP_PATH_URL.'/frontend/css/bxslider.css');
			
			wp_register_script('cp-jplayer', CP_PATH_URL.'/frontend/js/jquery.jplayer.min.js', false, '1.0', true);
			wp_enqueue_script('cp-jplayer');		
			
			?>
			<script type="text/JavaScript">
			jQuery(document).ready(function ($) {
				if ($('#slide_element').length) {
					$('#slide_element').bxSlider({
						slideWidth: <?php if($select_layout_cp == 'full_layout'){echo '280';}else{echo '280';}?>,
						minSlides: 1,
						maxSlides: 4,
						slideMargin: <?php if($select_layout_cp == 'full_layout'){echo '17.5';}else{echo '17.5';}?>,
						pager:false,
						auto: true,
						tickerHover:true,
						onSliderLoad: function(){
						}
					});
				}
			});
			</script>
			<div class="featuder-row">
				<h2><?php echo $header;?></h2>
				<section id="slide_element" class="row-fluid slide_element">
					<?php
					if($category == 0){
						//Post Query
						query_posts(
							array( 
							'post_type' => 'sermons',
							'posts_per_page' => 10,
							'orderby' => 'title',
							'order' => 'ASC' )
						);
					
					}else{
						//Post Query
						query_posts(
							array( 
							'post_type' => 'sermons',
							'posts_per_page' => 10,
							'tax_query' => array(
								array(
									'taxonomy' => 'sermons-category',
									'terms' => $category,
									'field' => 'term_id',
								)
							),
							'orderby' => 'title',
							'order' => 'ASC' )
						);
					}
					while( have_posts() ){
					the_post();	
					global $post,$post_id;
					$sermons_id = $post->ID;
					//Fetch All Tracks
					$track_name_xml = get_post_meta($sermons_id, 'track_name_xml', true);
					$track_url_xml = get_post_meta($sermons_id, 'track_url_xml', true);
					$track_des_xml = get_post_meta($sermons_id, 'track_des_xml', true);
					$track_down_xml = get_post_meta($sermons_id, 'track_down_xml', true);
					
					//Get elements by documentElement
					$track_name_array = $this->get_sermons_all_tracks($track_name_xml);
					$track_url_array = $this->get_sermons_all_tracks($track_url_xml);
					$track_lyrics_array = $this->get_sermons_all_tracks($track_des_xml);
					$track_download_array = $this->get_sermons_all_tracks($track_down_xml);?>
					<div class="">
						<div class="item_caro">
							<script type="text/JavaScript">
								//<![CDATA[
								jQuery(document).ready(function($){
									var stream = {
										<?php
											//Loop for Tracks
											if($track_name_xml <> '' || $track_url_xml <> ''){
												$counter_track = 0;
												$nofields = 1;
												for($i=0;$i<$nofields;$i++) {
													$img_url_aa = 'http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png';
													echo 'title:"'.$track_name_array->item($i)->nodeValue.'",';
													echo 'pastor:"'.$track_name_array->item($i)->nodeValue.'",';
													echo 'mp3:"'.$track_url_array->item($i)->nodeValue.'",';
													echo 'poster:"'.$img_url_aa.'"';
												}
											}
										?>
									},
									ready = false;
									$("#jquery_jplayer_<?php echo $sermons_id.$counter;?>").jPlayer({
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
										cssSelectorAncestor: "#jp_container_<?php echo $sermons_id.$counter;?>",
										swfPath: "<?php echo CP_PATH_URL?>/frontend/js/Jplayer.swf",
										supplied: "mp3",
										preload: "none",
										wmode: "window",
										keyEnabled: true
									});									
								});
								//]]>
							</script>
							<div class="artist-box fadeInLeftBig cp_load">
								<div class="frame">
									<?php echo get_the_post_thumbnail($album_id, array(275,290));;?>
								</div>
								<strong class="title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></strong>
								<ul class="text-detail">
									<li class="headphone-icon"><span class="font-aw"><i class="icon-headphones"></i></span>
									<a><?php echo $track_name_array->length;?> <?php _e('Sermons','crunchpress');?></a></li>
									<li class="play-icon">
										<div id="jquery_jplayer_<?php echo $sermons_id.$counter;?>" class="cp_jp-jplayer"></div>
										<div id="jp_container_<?php echo $sermons_id.$counter;?>" class="cp_jp-audio-stream">
											<div class="jp-type-single">
												<div class="jp-gui cp_jp-interface">
													<ul class="cp_jp-controls">
														<li><a href="javascript:;" class="jp-play" tabindex="1"><?php _e('Listen','crunchpress');?></a></li>
														<li><a href="javascript:;" class="jp-pause" tabindex="1"><?php _e('Pause','crunchpress');?></a></li>
														<!--<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
														<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
														<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>-->
													</ul>
													<!--<div class="jp-volume-bar">
														<div class="jp-volume-bar-value"></div>
													</div>-->
												</div>
												<!--<div class="jp-title">
													<ul>
														<li>ABC Jazz</li>
													</ul>
												</div>-->
												<div class="jp-no-solution">
													<span><?php echo __('Update Required','crunchpress'); ?></span>
													<?php echo __('To play the media you will need to either update your browser to a recent version or update your','crunchpress'); ?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php echo __('Flash plugin','crunchpress'); ?></a>.
												</div>
											</div>
										</div>
									</li>
									<li class="like-icon">
										<?php 
										$cp_album_class = new cp_album_class;
									?>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php
					} ?>
				</section>
				<div class="border-line">&nbsp;<a id="no-album-active" class="hide-album"><?php echo __('Click Here','crunchpress'); ?></a></div>
			</div>	
			<?php
		}
	}
	
	
	//Music Play List Function Stars
	public static function sermons_play_list($album_title=''){
		global $counter;
		$sermons_title = $album_title;
		//Fetching the values from Track
		$track_name_xml = get_post_meta($sermons_title, 'track_name_xml', true);
		$track_url_xml = get_post_meta($sermons_title, 'track_url_xml', true);
		$track_des_xml = get_post_meta($sermons_title, 'track_des_xml', true);
		$track_down_xml = get_post_meta($sermons_title, 'track_down_xml', true);
		
		//Jplayer Scripts Classing After the Function Call
		wp_register_script('cp-jplayer', CP_PATH_URL.'/frontend/js/jquery.jplayer.min.js', false, '1.0', true);
		wp_enqueue_script('cp-jplayer');
		
		//Playlist Script
		wp_register_script('cp-jplayer-playlist', CP_PATH_URL.'/frontend/js/jplayer.playlist.min.js', false, '1.0', true);
		wp_enqueue_script('cp-jplayer-playlist');
		
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
		
		//Track Description
		if($track_des_xml <> ''){	
			$ingre_des_xml = new DOMDocument();
			$ingre_des_xml->recover = TRUE;
			$ingre_des_xml->loadXML($track_des_xml);
			$children_des = $ingre_des_xml->documentElement->childNodes;
			
		}
		
		//Track Download Fetch
		if($track_down_xml <> ''){	
			$ingre_down_xml = new DOMDocument();
			$ingre_down_xml->recover = TRUE;
			$ingre_down_xml->loadXML($track_down_xml);
			$children_down = $ingre_down_xml->documentElement->childNodes;
			
		} ?>

		<!--JPlayer Function Starts-->
		<script type="text/JavaScript">
			//Lets make it work
			jQuery(document).ready(function($) {
				new jPlayerPlaylist({
					jPlayer: "#jquery_jplayer_<?php echo $counter.$sermons_title;?>",
					cssSelectorAncestor: "#jp_container_<?php echo $counter.$sermons_title;?>"
				}, [                       
					<?php 
					//Combine Loop
					$img_url_aa = 'http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png';
						if($track_name_xml <> '' || $track_url_xml <> ''){
							$counter_aa = 0;
							$nofields = $ingre_xml->documentElement->childNodes->length;
							for($i=0;$i<$nofields;$i++) {
								echo '{';
								echo 'title:"'.$children_name->item($i)->nodeValue.'",';
								echo 'pastor:"'.$children_name->item($i)->nodeValue.'",';
								echo 'mp3:"'.$children_title->item($i)->nodeValue.'",';
								echo 'poster:"'.$img_url_aa.'",';
								echo '},';
							}
						}
					?>
				], 
				{
					playlistOptions: {
						enableRemoveControls: true
					},
					swfPath: "<?php echo CP_PATH_URL?>/frontend/js/Jplayer.swf",
					supplied: "mp3",
					//supplied: "webmv, ogv, m4v, oga, mp3",
					smoothPlayBar: true,
					keyEnabled: true,
					audioFullScreen: true
				});
			});                                                     
		</script>
		<h4><?php echo get_the_title($album_title);?></h4>
		<div id="jp_container_<?php echo $counter.$sermons_title;?>" class="jp-video jp-video-270p">
			<div class="jp-type-playlist">
				<div id="jquery_jplayer_<?php echo $counter.$sermons_title;?>" class="jp-jplayer"></div>
				<div class="jp-gui">
					<div class="jp-video-play">
						<a href="javascript:;" class="jp-video-play-icon" tabindex="1"><?php _e('play','crunchpress');?></a>
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
							<ul class="playlist-cp">
								<li><a class="show-playlist"><i class="fa fa-list"></i></a></li>
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
					<span><?php _e('Update Required','crunchpress');?></span>
					<?php _e('To play the media you will need to either update your browser to a recent version or update your','crunchpress');?> <a href="http://get.adobe.com/flashplayer/" target="_blank"><?php _e('Flash plugin','crunchpress');?></a>.
				</div>
			</div>
		</div>	
		<!--JPlayer Function Starts-->
		
	<?php } //End Music Play List
		
}
	
	
	
	// Fire the Code after Base Function	
	add_action( 'plugins_loaded', 'manage_albums_fun_override' );
	function manage_albums_fun_override() {
		
		$album_class = new cp_album_class;
	}	
}