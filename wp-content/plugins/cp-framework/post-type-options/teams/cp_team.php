<?php
//Condition for Parent Class
if(class_exists('function_library')){
	
	add_action( 'plugins_loaded', 'team_fun_override' );
	function team_fun_override() {
		$team_class = new cp_team_class;
	}

	class cp_team_class extends function_library{
		public $team_array = array(
		
			'image_icon' =>array(

				'type'=> 'image',
				
				'name'=> 'aa',

				'hr'=> 'none',

				'description'=> "fa fa-group"),
			
			"top-bar-div33-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div33'),	

			'header'=>array(

				'title'=> 'TEAM HEADER TITLE',

				'name'=> 'page-option-item-team-header-title',

				'type'=> 'inputtext'),
				
			'category'=>array(

				'title'=>'CHOOSE CATEGORY',

				'name'=>'page-option-category-team',

				'options'=>array(),

				'type'=>'combobox_category',

				'hr'=> 'none',

				'description'=>'Choose the team category you want the members to be fetched.'),		
			
			'num_excerpt'=>array(

				'title'=>'NUMBER OF EXCERPT',

				'name'=>'page-option-item-team-excerpt',

				'type'=> 'inputtext',

				'default'=> 200,

				'description'=>'Number of words to show on team member.'),
				
			"top-bar-div33-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div33'),		
			
			"top-bar-div34-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div34'),	
			
			'pagination'=>array(

				'title'=>'ENABLE PAGINATION',

				'name'=>'page-option-item-team-pagination',

				'type'=> 'combobox',

				'options'=>array('0'=>'Wp-Default', '1'=>'Theme-Custom','2'=>'No-Pagination'),

				'hr'=> 'none',

				'description'=>'Pagination will only appear when the number of posts is greater than the number of fetched item in one page you can also select wordpress default pagination that can be added from settings.'),

			'num-fetch'=>array(					

				'title'=> 'NUM OF MEMBERS',

				'name'=> 'page-option-item-team-num-fetch',

				'type'=> 'inputtext',
				
				'class'=>'team-fetch-member',

				'default'=> 9,

				'description'=>'Set the number of team members to display on one page.'),
				
			"top-bar-div34-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div34'),			


		);
		
		
		public $team_size_array =  array('element1-1'=>'1/1');			
		
		public function page_builder_size_class(){
		global $div_size;
			$div_size['Our-Team'] = $this->team_size_array;	  
		}
		
		public function page_builder_element_class(){
		global $page_meta_boxes;
			$page_meta_boxes['Page Item']['name']['Our-Team'] = $this->team_array;
			//$page_meta_boxes['Page Item']['name']['Our-Team']['select_feature']['options'] = function_library::get_title_list_array( 'teams' );	
			$page_meta_boxes['Page Item']['name']['Our-Team']['category']['options'] = function_library::get_category_list_array( 'team-category' );

		}
		
		public function __construct(){
			add_action( 'init', array( $this, 'create_ourteam' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_team_option' ) );
			add_action( 'save_post', array( $this, 'save_team_option_meta' ) );
		}

		
		
		
		public function create_ourteam() {
			//$portfolio_translation = get_option(THEME_NAME_S.'_cp_portfolio_slug','portfolio');
			
			$labels = array(
				'name' => _x('Our Team', 'Our Team General Name', 'crunchpress'),
				'singular_name' => _x('Our Team', 'Event Singular Name', 'crunchpress'),
				'add_new' => _x('Add New', 'Add New Our Team Name', 'crunchpress'),
				'add_new_item' => __('Add New Our Team', 'crunchpress'),
				'edit_item' => __('Edit Our Team', 'crunchpress'),
				'new_item' => __('New Our Team', 'crunchpress'),
				'view_item' => __('View Our Team', 'crunchpress'),
				'search_items' => __('Search Our Team', 'crunchpress'),
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
				'menu_icon' => '',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'team' , $args);	

			register_taxonomy(
				"team-category", array("team"), array(
					"hierarchical" => true,
					"label" => "Team Categories", 
					"singular_label" => "Team Categories", 
					"rewrite" => true));
			register_taxonomy_for_object_type('team-category', 'team');			
		}
		
		
		
		public function add_team_option(){	
		
			add_meta_box('team-option', __('Our Team Options','crunchpress'), array($this,'add_our_team_element'),
				'team', 'normal', 'high');
				
		}
		public function add_our_team_element(){
			$team_social = '';
			$sidebar_team = '';
			$right_sidebar_team = '';
			$left_sidebar_team = '';
			$team_designation = '';
			$team_facebook = '';
			$team_linkedin = '';
			$team_twitter = '';
		
		
		
		foreach($_REQUEST as $keys=>$values){
			$$keys = $values;
		}
		global $post;
		

		$team_detail_xml = get_post_meta($post->ID, 'team_detail_xml', true);
		if($team_detail_xml <> ''){
			$cp_team_xml = new DOMDocument ();
			$cp_team_xml->loadXML ( $team_detail_xml );
			$team_social = function_library::find_xml_value($cp_team_xml->documentElement,'team_social');
			$sidebar_team = function_library::find_xml_value($cp_team_xml->documentElement,'sidebar_team');
			$left_sidebar_team = function_library::find_xml_value($cp_team_xml->documentElement,'left_sidebar_team');
			$right_sidebar_team = function_library::find_xml_value($cp_team_xml->documentElement,'right_sidebar_team');
			$team_designation = function_library::find_xml_value($cp_team_xml->documentElement,'team_designation');
			$team_facebook = function_library::find_xml_value($cp_team_xml->documentElement,'team_facebook');
			$team_linkedin = function_library::find_xml_value($cp_team_xml->documentElement,'team_linkedin');
			$team_twitter = function_library::find_xml_value($cp_team_xml->documentElement,'team_twitter');
		}
		?>
		<div class="event_options">
            <div class="op-gap">
				<ul class="panel-body recipe_class row-fluid">
					<li class="panel-input span12">
						<span class="panel-title">
							<h3 for="team_social" > <?php _e('SOCIAL NETWORKING', 'crunchpress'); ?> </h3>
						</span>	
						
						<label for="team_social"><div class="checkbox-switch <?php
						
						echo ($team_social=='enable' || ($team_social=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

					?>"></div></label>
					<input type="checkbox" name="team_social" class="checkbox-switch" value="disable" checked>
					<input type="checkbox" name="team_social" id="team_social" class="checkbox-switch" value="enable" <?php 
						
						echo ($team_social=='enable' || ($team_social=='' && empty($default)))? 'checked': ''; 
					
					?>>
					<p><?php _e('Turn On/Off Social Sharing on Team Detail.', 'crunchpress'); ?></p>
					</li>
					
				</ul>
				<div class="clear"></div>
				<?php echo function_library::show_sidebar($sidebar_team,'right_sidebar_team','left_sidebar_team',$right_sidebar_team,$left_sidebar_team);?>
				<div class="clear"></div>
				<div class="row-fluid">
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="team_designation" > <?php _e('DESIGNATION', 'crunchpress'); ?> </h3>
								</span>
								<input type="text" name="team_designation" id="team_designation" value="<?php if($team_designation <> ''){echo $team_designation;};?>" />
								<p><?php _e('Please Enter Here Designation of the person.', 'crunchpress'); ?></p>
							</li>
						</ul>
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="team_facebook" > <?php _e('Facebook Profile', 'crunchpress'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="team_facebook" id="team_facebook" value="<?php if($team_facebook <> ''){echo $team_facebook;};?>" />
							</li>
							<p><?php _e('Please Enter Url for social profile.', 'crunchpress'); ?></p>
						</ul>	                
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="team_linkedin" > <?php _e('Linked In Profile', 'crunchpress'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="team_linkedin" id="team_linkedin" value="<?php if($team_linkedin <> ''){echo $team_linkedin;};?>" />
							</li>
							<p><?php _e('Please Enter Url for social profile.', 'crunchpress'); ?></p>
						</ul>	
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="team_twitter" > <?php _e('Twitter Profile', 'crunchpress'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="team_twitter" id="team_twitter" value="<?php if($team_twitter <> ''){echo $team_twitter;};?>" />
							</li>
							<p><?php _e('Please Enter Url for social profile.', 'crunchpress'); ?></p>
						</ul>		                
					</div>
                </div>                		
				<input type="hidden" name="team_submit" value="teams"/>
				<div class="clear"></div>
			</div>	
        </div>
		<?php }
		
		public function save_team_option_meta($post_id){
			
			$team_social = '';
			$sidebars = '';
			$right_sidebar_team = '';
			$left_sidebar_team = '';
			$team_facebook = '';
			$team_linkedin = '';
			$team_twitter = '';
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($team_submit) AND $team_submit == 'teams'){
					$new_data = '<team_detail>';
					$new_data = $new_data . function_library::create_xml_tag('team_social',$team_social);
					$new_data = $new_data . function_library::create_xml_tag('sidebar_team',$sidebars);
					$new_data = $new_data . function_library::create_xml_tag('right_sidebar_team',$right_sidebar_team);
					$new_data = $new_data . function_library::create_xml_tag('left_sidebar_team',$left_sidebar_team);
					$new_data = $new_data . function_library::create_xml_tag('team_designation',$team_designation);
					$new_data = $new_data . function_library::create_xml_tag('team_facebook',$team_facebook);
					$new_data = $new_data . function_library::create_xml_tag('team_linkedin',$team_linkedin);
					$new_data = $new_data . function_library::create_xml_tag('team_twitter',$team_twitter);
					$new_data = $new_data . '</team_detail>';
			//Saving Sidebar and Social Sharing Settings as XML
			$old_data = get_post_meta($post_id, 'team_detail_xml',true);
			function_library::save_meta_data($post_id, $new_data, $old_data, 'team_detail_xml');
			
			}
		}
		
		// Print Event item
	function print_team_item($item_xml){

		wp_reset_query();
		global $paged,$sidebar,$team_div_size_num_class,$post,$counter;
		
		if(empty($paged)){
			$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
		}
			
		$category = find_xml_value($item_xml, 'category');
		// get the blog meta value		
		$header = find_xml_value($item_xml, 'header');
		$num_fetch = find_xml_value($item_xml, 'num-fetch');
		$num_excerpt = find_xml_value($item_xml, 'num_excerpt');
		
		if($category == '0'){
			//Post Query
			query_posts(
				array( 
				'post_type' => 'team',
				'posts_per_page' => $num_fetch,
				'paged'	=>	$paged,
				'orderby' => 'title',
				'order' => 'ASC' )
			);
		}else{
			//Post Query
			query_posts(
				array( 
				'post_type' => 'team',
				'posts_per_page' => $num_fetch,
				'paged'			=>	$paged,
				'tax_query' => array(
					array(
						'taxonomy' => 'team-category',
						'terms' => $category,
						'field' => 'term_id',
					)
				),
				'orderby' => 'title',
				'order' => 'ASC' )
			);
		}
		$counter_team = 0; ?>
				<div class="our-team">					
					<?php
					//Print Header
					if(!empty($header)){
						echo '<h2 class="h-style">' . $header . '</h2>';
					}
					//Start loop
					while( have_posts() ){
					the_post();	
					
					global $post;
						//Team Detail Other Elements
						$team_detail_xml = get_post_meta($post->ID, 'team_detail_xml', true);
						if($team_detail_xml <> ''){
							$cp_team_xml = new DOMDocument ();
							$cp_team_xml->loadXML ( $team_detail_xml );
							$team_designation = find_xml_value($cp_team_xml->documentElement,'team_designation');
							$team_facebook = find_xml_value($cp_team_xml->documentElement,'team_facebook');
							$team_linkedin = find_xml_value($cp_team_xml->documentElement,'team_linkedin');
							$team_twitter = find_xml_value($cp_team_xml->documentElement,'team_twitter');
						}
						//Line Break After Every Four Elements
						$first_class = '';
						$clear_div = '';
						if($counter_team % 4 == 0){$first_class = 'first'; $clear_div = '<div class="clear"></div>';}else{}$counter_team++;?> 
						<?php echo $clear_div;?>
						<div class="span3 <?php echo $first_class;?>">
							<div class="team-box">
								<?php
								//Thumbnail for Team Members
								$thumbnail_id = get_post_thumbnail_id( $post->ID );
								$thumbnail = wp_get_attachment_image_src( $thumbnail_id , array(350,350) );
								if($thumbnail[1].'x'.$thumbnail[2] == '350x350'){?>
									<div class="frame"><?php echo get_the_post_thumbnail($post->ID, array(350,350));?></div>
								<?php }?>
								<div class="text-box">
								  <h2><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h2>
								  <?php if($team_designation <> ''){ ?><strong class="title"><?php echo $team_designation;?></strong><?php }?>
								  <p><?php echo mb_substr(get_the_content(),0,$num_excerpt);?> </p>
								  <ul>
									<?php if(isset($team_facebook) AND $team_facebook <> ''){?>
										<li><a href="<?php echo $team_facebook;?>"><i class="fa fa-facebook"></i></a></li>
									<?php }?>
									<?php if(isset($team_twitter) AND $team_twitter <> ''){?>
										<li><a href="<?php echo $team_twitter;?>"><i class="fa fa-twitter"></i></a></li>
									<?php }?>
									<?php if(isset($team_linkedin) AND $team_linkedin <> ''){?>
										<li><a href="<?php echo $team_linkedin;?>"><i class="fa fa-linkedin"></i></a></li>
									<?php }?>
								  </ul>
								</div>
							  </div>							
						</div>
					<?php 


					}?>
				</div>
				<?php
		
	}// End Team Function for Frontend	
		
		
	}
}	