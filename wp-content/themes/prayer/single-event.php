<<<<<<< HEAD
<?php get_header(); ?>
<?php if ( have_posts() ){ while (have_posts()){ the_post();
	global $post,$EM_Event;
	
	// Get Post Meta Elements detail 
	$event_social = '';
	$sidebar = '';
	$left_sidebar = '';
	$right_sidebar = '';
	$event_thumbnail = '';
	$video_url_type = '';
	$select_slider_type = '';
	$event_detail_xml = get_post_meta($post->ID, 'event_detail_xml', true);
	if($event_detail_xml <> ''){
		$cp_event_xml = new DOMDocument ();
		$cp_event_xml->loadXML ( $event_detail_xml );
		$event_social = find_xml_value($cp_event_xml->documentElement,'event_social');
		$sidebar = find_xml_value($cp_event_xml->documentElement,'sidebar_event');
		$left_sidebar = find_xml_value($cp_event_xml->documentElement,'left_sidebar_event');
		$right_sidebar = find_xml_value($cp_event_xml->documentElement,'right_sidebar_event');
		$event_thumbnail = find_xml_value($cp_event_xml->documentElement,'event_thumbnail');
		$video_url_type = find_xml_value($cp_event_xml->documentElement,'video_url_type');
		$select_slider_type = find_xml_value($cp_event_xml->documentElement,'select_slider_type');
	}
	
	
	$select_layout_cp = '';
	$color_scheme = '';
	$cp_general_settings = get_option('general_settings');
	if($cp_general_settings <> ''){
		$cp_logo = new DOMDocument ();
		$cp_logo->loadXML ( $cp_general_settings );
		$select_layout_cp = find_xml_value($cp_logo->documentElement,'select_layout_cp');
		$color_scheme = find_xml_value($cp_logo->documentElement,'color_scheme');
	}
	
	$sidebar_class = '';
	$content_class = '';
	
	//Get Sidebar for page
	$sidebar_class = sidebar_func($sidebar);
	//print_r($EM_Event);
	if(!empty($EM_Event->location_id->name)){
		$location_summary = "<b>" . $EM_Event->get_location()->name . "</b><br/>" . $EM_Event->get_location()->address . " - " . $EM_Event->get_location()->town;
	}
	?>
<?php if($EM_Event->get_location()->location_latitude <> 0 AND $EM_Event->get_location()->location_longitude <> 0){ ?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript">
		jQuery(function () {
			var map;
			var myLatLng = new google.maps.LatLng(<?php echo $EM_Event->get_location()->location_latitude;?>, <?php echo $EM_Event->get_location()->location_longitude;?>)
			//Initialize MAP
			var myOptions = {
				zoom: 13,
				center: myLatLng,
				disableDefaultUI: true,
				zoomControl: true,
				styles:[
					{
						stylers: [
							{ hue: '<?php echo $color_scheme;?>' },
							{ saturation: -10 },
						]
					}
				],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById('map_contact_1'),myOptions);
			//End Initialize MAP
			//Set Marker
			var marker = new google.maps.Marker({
			  position: map.getCenter(),
			  map: map
			});
			marker.getPosition();
			//End marker
			
			//Set info window
			var contentString = '<div id="content">'+
			  '<div id="siteNotice">'+
			  '<p><?php echo $EM_Event->event_name;?></p>'+
			  '<?php echo get_the_post_thumbnail($EM_Event->post_id, array(60,60));?>'+
			  '</div>'+
			  '<div id="bodyContent">'+
			  '<p><i class="fa fa-map-marker"></i>' +
			  '</p>'+
			  '</div>'+
			  '</div>';
			
			var infowindow = new google.maps.InfoWindow({
			content: contentString,
			position: myLatLng
			});
			var marker, i;
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					infowindow.open(map);
				}
			})(marker, i));
			
		});
	</script>
	<?php }	
	$header_style = '';
	$html_class_banner = '';
	$html_class = print_header_class($header_style);
	if($html_class <> ''){$html_class_banner = 'banner';}
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
    <div class="contant">
    	<div class="container">
             <!--BREADCRUMS START-->
            <div class="loc">
			   <?php
				//print_r($EM_Event);
				if(!empty($EM_Event->location_id->name)){
					$location_summary = "<b>" . $EM_Event->get_location()->name . "</b><br/>" . $EM_Event->get_location()->address . " - " . $EM_Event->get_location()->town;
				}
			   ?>
            </div>
            <!--BREADCRUMS END-->
            <!--MAIN CONTANT ARTICLE START-->
            <div class="main-content">
				<div class="single_content row-fluid">
					<?php
					if($sidebar == "left-sidebar" || $sidebar == "both-sidebar" || $sidebar == "both-sidebar-left"){?>
						<div id="block_first" class="sidebar <?php echo $sidebar_class[0];?>">
							<?php dynamic_sidebar( $left_sidebar ); ?>
						</div>
						<?php
					}
					if($sidebar == 'both-sidebar-left'){?>
					<div id="block_first_left" class="sidebar <?php echo $sidebar_class[0];?>">
						<?php dynamic_sidebar( $right_sidebar );?>
					</div>
					<?php } ?>
					<div id="post-<?php the_ID(); ?>" class="<?php echo $sidebar_class[1];?> em-cp-events">
						<div <?php post_class(); ?>>
							<div class="fram-holder row-fluid">
							<div class="left span3">
								<div class="date-box"> <strong class="day"><?php echo date('l',strtotime($EM_Event->start_date));?></strong> <strong class="date"><?php echo date('d',strtotime($EM_Event->start_date));?></strong> <strong class="mnt"><?php echo date('F',strtotime($EM_Event->start_date));?></strong> <strong class="year"><?php echo date('Y',strtotime($EM_Event->start_date));?></strong> </div>
								<ul>
								  <li><a href="<?php echo $EM_Event->guid;?>"><i class="fa fa-calendar"></i><?php _e('Start Time :','crunchpress');?><?php echo date(get_option('date_format'),strtotime($EM_Event->start_date));?></a></li>
								  <li><a href="<?php echo $EM_Event->guid;?>"><i class="fa fa-clock-o"></i><?php _e('End Time :','crunchpress');?><?php echo date(get_option('date_format'),strtotime($EM_Event->end_date));?></a></li>
								  <li><a href="<?php echo $EM_Event->guid;?>"><i class="fa fa-microphone"></i><?php echo get_the_author();?></a></li>
								  <li>
									<?php 
									$variable_category = wp_get_post_terms( $EM_Event->post_id, 'event-tags');
									$counterr = 0;
									foreach($variable_category as $values){
										if($counterr == 0){ echo '<i class="fa fa-tags"></i>';}
										$counterr++;
										echo '<a class="event-tag" href="'.get_term_link(intval($values->term_id),'event-tags').'">'.$values->name.'</a>  ';
									}
									?>
								  </li>
								  <li><a href="<?php echo $EM_Event->guid;?>"><i class="fa fa-map-marker"></i><?php if($EM_Event->location_id <> 0){ echo $EM_Event->get_location()->address; }else{_e('Location Disabled','crunchpress');}?></a></li>
								</ul>
								 <a class="btn-participate" href="<?php echo $EM_Event->guid;?>">
									<?php
										if(!empty($EM_Event->bookings)){
											if( $EM_Event->can_manage('manage_bookings','manage_others_bookings') && get_option('dbem_rsvp_enabled') == 1 && $EM_Event->rsvp == 1 ){
												?>
												<?php echo __("Bookings",'dbem'); ?> &ndash;
												<?php _e("Booked",'dbem'); ?>: <?php echo $EM_Event->get_bookings()->get_booked_spaces()."/".$EM_Event->get_spaces(); ?>
												<?php if( get_option('dbem_bookings_approval') == 1 ): ?>
													| <?php _e("Pending",'dbem') ?>: <?php echo $EM_Event->get_bookings()->get_pending_spaces(); ?>
												<?php endif;
											}
										}else{
											_e('No Bookings','crunchpress');
										}
									?></a>
							</div>
							<div class="event-frame span9"> <a href="<?php echo $EM_Event->guid;?>"><?php echo get_the_post_thumbnail($EM_Event->post_id, array(1170,350));?></a>
								<div class="map-row row-fluid">
								  <div class="event-detail-timer"> <strong class="title"><?php echo $EM_Event->event_name;?></strong>
									<div class="timer-outer">
									  <div class="defaultCountdown" id="count_<?php echo $EM_Event->post_id; ?>"></div>
									</div>
								  </div>
								  <div class="map-box">
									<div id="map_contact_1" class="map_canvas-2 active"></div>
								  </div>
								</div>
							</div>
							  <?php
							  //Get Date in Parts
								$event_year = date('Y',$EM_Event->start);
								$event_month = date('m',$EM_Event->start);
								$event_month_alpha = date('M',$EM_Event->start);
								$event_day = date('d',$EM_Event->start);
								
								//Change time format
								$event_start_time_count = date("G,i,s", strtotime($EM_Event->start_time));?>
								<script>
									jQuery(function () {
										var austDay = new Date();
										austDay = new Date(<?php echo $event_year;?>, <?php echo $event_month;?>-1, <?php echo $event_day;?>,<?php echo $event_start_time_count;?>)
										jQuery('#count_<?php echo $EM_Event->post_id; ?>').countdown({
										labels: ['<?php _e('YRS','crunchpress');?>', '<?php _e('MNTH','crunchpress');?>', '<?php _e('Weeks','crunchpress');?>', '<?php _e('Days','crunchpress');?>', '<?php _e('HRS','crunchpress');?>', '<?php _e('MIN','crunchpress');?>', '<?php _e('SEC','crunchpress');?>'],
										until: austDay
										});
										jQuery('#year').text(austDay.getFullYear());
									});                
								</script>
							</div>
							<?php 
							echo '<h4>'.get_the_title().'</h4>';
							//Fetching the Description from Database and Printing here
							$content = str_replace(']]>', ']]&gt;',$EM_Event->post_content); ?>
							<p> <?php echo do_shortcode($content); ?> </p>
							
						</div>
						<?php if($event_social == 'enable'){ ?>
						<div class="blog-detail">
							<div class="share-btn">
								<a class="share"><?php _e('Share Post','crunchpress');?></a>
								<?php include_social_shares();?>
							</div>
						</div>
						<?php }?>
						<!--DETAILED TEXT START-->
						<?php comments_template(); ?>
					</div>	
					
					<?php
					if($sidebar == "both-sidebar-right"){?>
						<div class="<?php echo $sidebar_class[0];?>">
							<?php dynamic_sidebar( $left_sidebar ); ?>
						</div>
						<?php
					}
					if($sidebar == 'both-sidebar-right' || $sidebar == "right-sidebar" || $sidebar == "both-sidebar"){?>
					<div class="<?php echo $sidebar_class[0];?>">
						<?php dynamic_sidebar( $right_sidebar );?>
					</div>
					<?php } ?>						   
				
			</div>
		</div>
	</div>
</div>
<?php 
	}
}

?>
<div class="clear"></div>
=======
<?php get_header(); ?>
<?php if ( have_posts() ){ while (have_posts()){ the_post();
	global $post,$EM_Event;
	
	// Get Post Meta Elements detail 
	$event_social = '';
	$sidebar = '';
	$left_sidebar = '';
	$right_sidebar = '';
	$event_thumbnail = '';
	$video_url_type = '';
	$select_slider_type = '';
	$event_detail_xml = get_post_meta($post->ID, 'event_detail_xml', true);
	if($event_detail_xml <> ''){
		$cp_event_xml = new DOMDocument ();
		$cp_event_xml->loadXML ( $event_detail_xml );
		$event_social = find_xml_value($cp_event_xml->documentElement,'event_social');
		$sidebar = find_xml_value($cp_event_xml->documentElement,'sidebar_event');
		$left_sidebar = find_xml_value($cp_event_xml->documentElement,'left_sidebar_event');
		$right_sidebar = find_xml_value($cp_event_xml->documentElement,'right_sidebar_event');
		$event_thumbnail = find_xml_value($cp_event_xml->documentElement,'event_thumbnail');
		$video_url_type = find_xml_value($cp_event_xml->documentElement,'video_url_type');
		$select_slider_type = find_xml_value($cp_event_xml->documentElement,'select_slider_type');
	}
	
	
	$select_layout_cp = '';
	$color_scheme = '';
	$cp_general_settings = get_option('general_settings');
	if($cp_general_settings <> ''){
		$cp_logo = new DOMDocument ();
		$cp_logo->loadXML ( $cp_general_settings );
		$select_layout_cp = find_xml_value($cp_logo->documentElement,'select_layout_cp');
		$color_scheme = find_xml_value($cp_logo->documentElement,'color_scheme');
	}
	
	$sidebar_class = '';
	$content_class = '';
	
	//Get Sidebar for page
	$sidebar_class = sidebar_func($sidebar);
	//print_r($EM_Event);
	if(!empty($EM_Event->location_id->name)){
		$location_summary = "<b>" . $EM_Event->get_location()->name . "</b><br/>" . $EM_Event->get_location()->address . " - " . $EM_Event->get_location()->town;
	}
	?>
<?php if($EM_Event->get_location()->location_latitude <> 0 AND $EM_Event->get_location()->location_longitude <> 0){ ?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript">
		jQuery(function () {
			var map;
			var myLatLng = new google.maps.LatLng(<?php echo $EM_Event->get_location()->location_latitude;?>, <?php echo $EM_Event->get_location()->location_longitude;?>)
			//Initialize MAP
			var myOptions = {
				zoom: 13,
				center: myLatLng,
				disableDefaultUI: true,
				zoomControl: true,
				styles:[
					{
						stylers: [
							{ hue: '<?php echo $color_scheme;?>' },
							{ saturation: -10 },
						]
					}
				],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById('map_contact_1'),myOptions);
			//End Initialize MAP
			//Set Marker
			var marker = new google.maps.Marker({
			  position: map.getCenter(),
			  map: map
			});
			marker.getPosition();
			//End marker
			
			//Set info window
			var contentString = '<div id="content">'+
			  '<div id="siteNotice">'+
			  '<p><?php echo $EM_Event->event_name;?></p>'+
			  '<?php echo get_the_post_thumbnail($EM_Event->post_id, array(60,60));?>'+
			  '</div>'+
			  '<div id="bodyContent">'+
			  '<p><i class="fa fa-map-marker"></i>' +
			  '</p>'+
			  '</div>'+
			  '</div>';
			
			var infowindow = new google.maps.InfoWindow({
			content: contentString,
			position: myLatLng
			});
			var marker, i;
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					infowindow.open(map);
				}
			})(marker, i));
			
		});
	</script>
	<?php }	
	$header_style = '';
	$html_class_banner = '';
	$html_class = print_header_class($header_style);
	if($html_class <> ''){$html_class_banner = 'banner';}
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
    <div class="contant">
    	<div class="container">
             <!--BREADCRUMS START-->
            <div class="loc">
			   <?php
				//print_r($EM_Event);
				if(!empty($EM_Event->location_id->name)){
					$location_summary = "<b>" . $EM_Event->get_location()->name . "</b><br/>" . $EM_Event->get_location()->address . " - " . $EM_Event->get_location()->town;
				}
			   ?>
            </div>
            <!--BREADCRUMS END-->
            <!--MAIN CONTANT ARTICLE START-->
            <div class="main-content">
				<div class="single_content row-fluid">
					<?php
					if($sidebar == "left-sidebar" || $sidebar == "both-sidebar" || $sidebar == "both-sidebar-left"){?>
						<div id="block_first" class="sidebar <?php echo $sidebar_class[0];?>">
							<?php dynamic_sidebar( $left_sidebar ); ?>
						</div>
						<?php
					}
					if($sidebar == 'both-sidebar-left'){?>
					<div id="block_first_left" class="sidebar <?php echo $sidebar_class[0];?>">
						<?php dynamic_sidebar( $right_sidebar );?>
					</div>
					<?php } ?>
					<div id="post-<?php the_ID(); ?>" class="<?php echo $sidebar_class[1];?> em-cp-events">
						<div <?php post_class(); ?>>
							<div class="fram-holder row-fluid">
							<div class="left span3">
								<div class="date-box"> <strong class="day"><?php echo date('l',strtotime($EM_Event->start_date));?></strong> <strong class="date"><?php echo date('d',strtotime($EM_Event->start_date));?></strong> <strong class="mnt"><?php echo date('F',strtotime($EM_Event->start_date));?></strong> <strong class="year"><?php echo date('Y',strtotime($EM_Event->start_date));?></strong> </div>
								<ul>
								  <li><a href="<?php echo $EM_Event->guid;?>"><i class="fa fa-calendar"></i><?php _e('Start Time :','crunchpress');?><?php echo date(get_option('date_format'),strtotime($EM_Event->start_date));?></a></li>
								  <li><a href="<?php echo $EM_Event->guid;?>"><i class="fa fa-clock-o"></i><?php _e('End Time :','crunchpress');?><?php echo date(get_option('date_format'),strtotime($EM_Event->end_date));?></a></li>
								  <li><a href="<?php echo $EM_Event->guid;?>"><i class="fa fa-microphone"></i><?php echo get_the_author();?></a></li>
								  <li>
									<?php 
									$variable_category = wp_get_post_terms( $EM_Event->post_id, 'event-tags');
									$counterr = 0;
									foreach($variable_category as $values){
										if($counterr == 0){ echo '<i class="fa fa-tags"></i>';}
										$counterr++;
										echo '<a class="event-tag" href="'.get_term_link(intval($values->term_id),'event-tags').'">'.$values->name.'</a>  ';
									}
									?>
								  </li>
								  <li><a href="<?php echo $EM_Event->guid;?>"><i class="fa fa-map-marker"></i><?php if($EM_Event->location_id <> 0){ echo $EM_Event->get_location()->address; }else{_e('Location Disabled','crunchpress');}?></a></li>
								</ul>
								 <a class="btn-participate" href="<?php echo $EM_Event->guid;?>">
									<?php
										if(!empty($EM_Event->bookings)){
											if( $EM_Event->can_manage('manage_bookings','manage_others_bookings') && get_option('dbem_rsvp_enabled') == 1 && $EM_Event->rsvp == 1 ){
												?>
												<?php echo __("Bookings",'dbem'); ?> &ndash;
												<?php _e("Booked",'dbem'); ?>: <?php echo $EM_Event->get_bookings()->get_booked_spaces()."/".$EM_Event->get_spaces(); ?>
												<?php if( get_option('dbem_bookings_approval') == 1 ): ?>
													| <?php _e("Pending",'dbem') ?>: <?php echo $EM_Event->get_bookings()->get_pending_spaces(); ?>
												<?php endif;
											}
										}else{
											_e('No Bookings','crunchpress');
										}
									?></a>
							</div>
							<div class="event-frame span9"> <a href="<?php echo $EM_Event->guid;?>"><?php echo get_the_post_thumbnail($EM_Event->post_id, array(1170,350));?></a>
								<div class="map-row row-fluid">
								  <div class="event-detail-timer"> <strong class="title"><?php echo $EM_Event->event_name;?></strong>
									<div class="timer-outer">
									  <div class="defaultCountdown" id="count_<?php echo $EM_Event->post_id; ?>"></div>
									</div>
								  </div>
								  <div class="map-box">
									<div id="map_contact_1" class="map_canvas-2 active"></div>
								  </div>
								</div>
							</div>
							  <?php
							  //Get Date in Parts
								$event_year = date('Y',$EM_Event->start);
								$event_month = date('m',$EM_Event->start);
								$event_month_alpha = date('M',$EM_Event->start);
								$event_day = date('d',$EM_Event->start);
								
								//Change time format
								$event_start_time_count = date("G,i,s", strtotime($EM_Event->start_time));?>
								<script>
									jQuery(function () {
										var austDay = new Date();
										austDay = new Date(<?php echo $event_year;?>, <?php echo $event_month;?>-1, <?php echo $event_day;?>,<?php echo $event_start_time_count;?>)
										jQuery('#count_<?php echo $EM_Event->post_id; ?>').countdown({
										labels: ['<?php _e('YRS','crunchpress');?>', '<?php _e('MNTH','crunchpress');?>', '<?php _e('Weeks','crunchpress');?>', '<?php _e('Days','crunchpress');?>', '<?php _e('HRS','crunchpress');?>', '<?php _e('MIN','crunchpress');?>', '<?php _e('SEC','crunchpress');?>'],
										until: austDay
										});
										jQuery('#year').text(austDay.getFullYear());
									});                
								</script>
							</div>
							<?php 
							echo '<h4>'.get_the_title().'</h4>';
							//Fetching the Description from Database and Printing here
							$content = str_replace(']]>', ']]&gt;',$EM_Event->post_content); ?>
							<p> <?php echo do_shortcode($content); ?> </p>
							
						</div>
						<?php if($event_social == 'enable'){ ?>
						<div class="blog-detail">
							<div class="share-btn">
								<a class="share"><?php _e('Share Post','crunchpress');?></a>
								<?php include_social_shares();?>
							</div>
						</div>
						<?php }?>
						<!--DETAILED TEXT START-->
						<?php comments_template(); ?>
					</div>	
					
					<?php
					if($sidebar == "both-sidebar-right"){?>
						<div class="<?php echo $sidebar_class[0];?>">
							<?php dynamic_sidebar( $left_sidebar ); ?>
						</div>
						<?php
					}
					if($sidebar == 'both-sidebar-right' || $sidebar == "right-sidebar" || $sidebar == "both-sidebar"){?>
					<div class="<?php echo $sidebar_class[0];?>">
						<?php dynamic_sidebar( $right_sidebar );?>
					</div>
					<?php } ?>						   
				
			</div>
		</div>
	</div>
</div>
<?php 
	}
}

?>
<div class="clear"></div>
>>>>>>> ed227fcd7fba396c647fab5258e5b0791b0bc4fe
<?php get_footer(); ?>