<?php
/** 
     * @author Roy Stone
     * @copyright roshi[www.themeforest.net/user/crunchpress]
     * @version 2013
     */

if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

require_once ABSPATH . 'wp-admin/includes/import.php';

$import_filepath = get_template_directory()."/framework/extensions/importer/dummy_data";
$errors = false;
if ( !class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
	{
		require_once($class_wp_importer);
	}
	else
	{
		$errors = true;
	}
}
if ( !class_exists( 'WP_Import' ) ) {
	$wp_importer = CP_FW. '/extensions/importer/wordpress-importer.php';
	if ( file_exists( $wp_importer ) )
	{
		require_once($wp_importer);
	}
	else
	{
		$errors = true;
	}
}

if($errors){
   echo "Errors while loading classes. Please use the standart wordpress importer."; 
}else{
    
    
	include_once('default_dummy_data.inc.php');
	if(!is_file($import_filepath.'_1.xml'))
	{
		echo "Problem with dummy data file. Please check the permisions of the xml file";
	}
	else
	{  
	   if(class_exists( 'WP_Import' )){
	       global $wp_version;
			$our_class = new themeple_dummy_data();
			$our_class->fetch_attachments = true;
			$our_class->import($import_filepath.'_1.xml');
		

$widget_text = array (
  2 => 
  array (
    'title' => 'About Church',
    'text' => 'Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi.',
    'filter' => false,
  ),
  3 => 
  array (
    'title' => '',
    'text' => ' <div class="footer-box-1">
					  <h4>Contact</h4>
					  <address>
					  <p>The Church Branch,<br>
						123 Lorem Ipsum Avenue, New York
						United States, 012345</p>
					  <ul>
						<li><i class="fa fa-phone"></i>0123 456 7890</li>
						<li><i class="fa fa-print"></i>0123 456 7890</li>
						<li><i class="fa fa-envelope-o"></i><a href="mailto:" class="email">info@prayer.com</a></li>
						<li><i class="fa fa-skype"></i>0123 456 7890</li>
					  </ul>
					  </address>
					</div>',
    'filter' => false,
  ),
  '_multiwidget' => 1,
);$widget_twitter_widget = array (
  2 => 
  array (
    'title' => 'Tweets',
    'consumer_key' => '1iUu8muQcbDfv4UAp58rXw',
    'consumer_secret' => 'am535ByNUMFFo8vHQtpkVpgdJz9QgcW4FpWaGDvH5Xw',
    'user_token' => '88209931-h16p4dNkvaXe0UQTRAx8zzPcWgl3L7rXj2XDOT5c2',
    'user_secret' => '3ugAtUwyrCcXK99xleZssr2OkiwVymoB2ceFwknYwLk',
    'username_widget' => 'crunchpress',
    'num_of_tweets' => '10',
  ),
  '_multiwidget' => 1,
);$widget_newsletter_widget = array (
  2 => 
  array (
    'title' => 'Stay with US',
    'show_name' => 'No',
    'news_letter_des' => 'Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit.',
  ),
  '_multiwidget' => 1,
);$widget_search = array (
  3 => 
  array (
    'title' => '',
  ),
  '_multiwidget' => 1,
);$widget_popular_post = array (
  2 => 
  array (
    'title' => 'Popular Posts',
    'get_cate_posts' => NULL,
    'nop' => '4',
  ),
  '_multiwidget' => 1,
);$widget_em_widget = array (
  2 => 
  array (
    'title' => 'Events',
    'limit' => '4',
    'scope' => 'future',
    'orderby' => 'event_start_date,event_start_time,event_name',
    'order' => 'ASC',
    'category' => '0',
    'format' => '#_EVENTLINK<ul><li>#_EVENTDATES</li><li>#_LOCATIONTOWN</li></ul>',
    'all_events_text' => 'all events',
    'no_events_text' => 'No events',
    'nolistwrap' => false,
    'all_events' => 0,
  ),
  3 => 
  array (
    'title' => 'Upcoming Events',
    'limit' => '5',
    'scope' => 'future',
    'orderby' => 'event_start_date,event_start_time,event_name',
    'order' => 'ASC',
    'category' => '0',
    'format' => '#_EVENTLINK<ul><li>#_EVENTDATES</li><li>#_LOCATIONTOWN</li></ul>',
    'all_events_text' => 'all events',
    'no_events_text' => 'No events',
    'nolistwrap' => false,
    'all_events' => 0,
  ),
  '_multiwidget' => 1,
);$widget_recent_news_show = array (
  2 => 
  array (
    'wid_class' => '',
    'title' => 'Latest News',
    'recent_post_category' => 'featured-image',
    'number_of_news' => '4',
  ),
  '_multiwidget' => 1,
);$widget_tag_cloud = array (
  2 => 
  array (
    'title' => 'Tag Cloud',
    'taxonomy' => 'post_tag',
  ),
  '_multiwidget' => 1,
);$widget_em_locations_widget = array (
  2 => 
  array (
    'title' => 'Event Locations',
    'limit' => '3',
    'scope' => 'future',
    'orderby' => 'event_start_date, event_start_time, location_name',
    'order' => 'ASC',
    'format' => '#_LOCATIONLINK<ul><li>#_LOCATIONADDRESS</li><li>#_LOCATIONTOWN</li></ul>',
  ),
  '_multiwidget' => 1,
);$sidebars_widgets=array (
  'wp_inactive_widgets' => 
  array (
  ),
  'sidebar-footer' => 
  array (
    0 => 'text-2',
    1 => 'twitter_widget-2',
    2 => 'newsletter_widget-2',
    3 => 'text-3',
  ),
  'sidebar-upper-footer' => 
  array (
  ),
  'custom-sidebar0' => 
  array (
    0 => 'search-3',
    1 => 'popular_post-2',
    2 => 'em_widget-2',
    3 => 'recent_news_show-2',
    4 => 'tag_cloud-2',
  ),
  'custom-sidebar1' => 
  array (
  ),
  'custom-sidebar2' => 
  array (
  ),
  'custom-sidebar3' => 
  array (
  ),
  'custom-sidebar4' => 
  array (
  ),
  'custom-sidebar5' => 
  array (
    0 => 'em_widget-3',
    1 => 'em_locations_widget-2',
  ),
  'array_version' => 3,
);$show_on_front = 'page';$page_on_front = '104';$theme_mods_prayer = array (
  0 => false,
  'nav_menu_locations' => 
  array (
    'top-menu' => 60,
  ),
);
			//Default Widgets
			save_option('sidebars_widgets','', $sidebars_widgets);	
			save_option('widget_text','', $widget_text);			
			save_option('widget_twitter_widget','', $widget_twitter_widget);			
			save_option('widget_newsletter_widget','', $widget_newsletter_widget);			
			save_option('widget_search','', $widget_search);		
			save_option('widget_popular_post','', $widget_popular_post);	
			save_option('widget_em_widget','', $widget_em_widget);	
			save_option('widget_recent_news_show','', $widget_recent_news_show);
			save_option('widget_tag_cloud','', $widget_tag_cloud);
			save_option('widget_em_locations_widget','', $widget_em_locations_widget);
			
			//Default Widgets
			save_option('show_on_front','', $show_on_front);
			save_option('page_on_front','', $page_on_front);
			save_option('theme_mods_prayer','', $theme_mods_prayer);			
		

        }
	}    
}


?>