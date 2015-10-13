<?php

	/*	
	*	Crunchpress Function Registered File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		Crunchpress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) Crunchpress
	*	---------------------------------------------------------------------
	*	This file use to register the wordpress function to the framework,
	*	and also use filter to hook some necessary events.
	*	---------------------------------------------------------------------
	*/
	
	if (function_exists('register_sidebar')){	
	
		// default sidebar array
		$sidebar_attr = array(
			'name' => '',
			'description' => '',
			'before_widget' => '<div class="widget sidebar_section %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		);

			
		$footer_col_layout = '';
		$footer_col_layout = get_themeoption_value('footer_col_layout','general_settings');
		
		$sidebar_id = 0;
		$cp_sidebar = array();
		//Print Footer Widget Areas
		
		$cp_sidebar = array("Footer");
		
		//Home Page Layout		
		if($footer_col_layout == 'footer-style1'){
			
			foreach( $cp_sidebar as $sidebar_name ){
				$sidebar_attr['name'] = $sidebar_name;
				$sidebar_slug = strtolower(str_replace(' ','-',$sidebar_name));
				$sidebar_attr['id'] = 'sidebar-' . $sidebar_slug ;
				$sidebar_attr['before_widget'] = '<div class="span3"><div class="widget %2$s">' ;
				$sidebar_attr['after_widget'] = '</div></div>' ;
				$sidebar_attr['before_title'] = '<h2>' ;
				$sidebar_attr['after_title'] = '<span class="h-line"></span></h2>' ;
				$sidebar_attr['description'] = 'Please place widget here' ;				
				register_sidebar($sidebar_attr);
			}
		}else{
			
			foreach( $cp_sidebar as $sidebar_name ){
				$sidebar_attr['name'] = $sidebar_name;
				$sidebar_slug = strtolower(str_replace(' ','-',$sidebar_name));
				$sidebar_attr['id'] = 'sidebar-' . $sidebar_slug ;
				$sidebar_attr['before_widget'] = '<div class="span4 %2$s">' ;
				$sidebar_attr['after_widget'] = '</div>' ;
				$sidebar_attr['before_title'] = '<h2>';
				$sidebar_attr['after_title'] = '<span class="h-line"></span></h2>' ;
				$sidebar_attr['description'] = 'Please place widget here' ;
				register_sidebar($sidebar_attr);
			}
		}		
			
		
		//Footer Layout
		//$cp_sidebar_footer = array("Footer");
		
		//$sidebar_attr['before_title'] = '<h2 class="custom-sidebar-title footer-title-color cp-title">';
		// foreach( $cp_sidebar_footer as $sidebar_name ){
			// $sidebar_attr['name'] = $sidebar_name;
			// $sidebar_slug = strtolower(str_replace(' ','-',$sidebar_name));
			// $sidebar_attr['id'] = 'sidebar-' . $sidebar_slug ;
			// $sidebar_attr['before_widget'] = '<div class="span4 %2$s">' ;
			// $sidebar_attr['before_title'] = '<h4>' ;
			// $sidebar_attr['after_title'] = '<span class="h-line"></span></h4>' ;
			// $sidebar_attr['description'] = 'Please place widget here' ;
			// register_sidebar($sidebar_attr);
		// }
		$cp_sidebar = '';
		$cp_sidebar = get_option('sidebar_settings');
		//$sidebar_attr['before_title'] = '<h3>';
		
		if(!empty($cp_sidebar)){
			$xml = new DOMDocument();
			$xml->loadXML($cp_sidebar);
			foreach( $xml->documentElement->childNodes as $sidebar_name ){
				$sidebar_attr['name'] = $sidebar_name->nodeValue;
				$sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++ ;
				$sidebar_attr['before_widget'] = '<div class="widget sidebar_section %2$s">' ;
				$sidebar_attr['after_widget'] = '</div>' ;
				$sidebar_attr['before_title'] = '<h2>' ;
				$sidebar_attr['after_title'] = '</h2>' ;
				register_sidebar($sidebar_attr);
			}
		}
		
		
		
		
	}
	
	//Add Theme Support
	if(function_exists('add_theme_support')){
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list',) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array('aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery') );
		
		// enable featured image
		add_theme_support('post-thumbnails');
		
		// enable editor style
		add_editor_style('editor-style.css');
		
		// enable navigation menu
		add_theme_support('menus');
		register_nav_menus(array('top-menu' => 'Main Menu','header-menu'=>'Header Menu'));
	}
	
	// add filter to hook when user press "insert into post" to include the attachment id
	add_filter('media_send_to_editor', 'add_para_media_to_editor', 20, 2);
	function add_para_media_to_editor($html, $id){

		if(strpos($html, 'href')){
			$pos = strpos($html, '<a') + 2;
			$html = substr($html, 0, $pos) . ' attid="' . $id . '" ' . substr($html, $pos);
		}
		
		return $html ;
		
	}
	
	// enable theme to support the localization
	add_action('init', 'cp_word_translation');
	function cp_word_translation(){
		load_theme_textdomain( 'crunchpress', get_template_directory() . '/languages/' );		
	}

	// excerpt filter
	add_filter('excerpt_length','cp_excerpt_length');
	function cp_excerpt_length(){
		return 1000;
	}
	


	add_action('wp_footer', 'add_google_analytics_code');
	// Google Analytics
	function add_google_analytics_code(){
		$google_webmaster_code = '';
		//Get Options
		$cp_general_settings = get_option('general_settings');
		if($cp_general_settings <> ''){
			$cp_logo = new DOMDocument ();
			$cp_logo->loadXML ( $cp_general_settings );
			$google_webmaster_code = find_xml_value($cp_logo->documentElement,'google_webmaster_code');
			}
		echo $google_webmaster_code;
	
	}
	
	add_action('wp_footer', 'add_header_code');
	// Header Style or Script
	function add_header_code(){
		$header_css_code = '';
		//Get Options
		$cp_general_settings = get_option('general_settings');
		if($cp_general_settings <> ''){
			$cp_logo = new DOMDocument ();
			$cp_logo->loadXML ( $cp_general_settings );
			$header_css_code = find_xml_value($cp_logo->documentElement,'header_css_code');
		}
		echo $header_css_code;
	}
	
	add_action('wp_footer', 'add_typekit_code');
	// Google Analytics
	function add_typekit_code(){
		$embed_typekit_code = '';
		$cp_typography_settings = get_option('typography_settings');
		if($cp_typography_settings <> ''){
			$cp_typo = new DOMDocument ();
			$cp_typo->loadXML ( $cp_typography_settings );
			$embed_typekit_code = find_xml_value($cp_typo->documentElement,'embed_typekit_code');
		}
		echo $embed_typekit_code;
	
	}
	
	// Custom Post type Feed
	add_filter('request', 'myfeed_request');
	function myfeed_request($qv) {
		if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'portfolio');
		return $qv;
	}

	// Translate the wpml shortcode
	function webtreats_lang_test( $atts, $content = null ) {
		extract(shortcode_atts(array( 'lang' => '' ), $atts));
		
		$lang_active = ICL_LANGUAGE_CODE;
		
		if($lang == $lang_active){
			return $content;
		}
	}
	
	
	
	// Add Another theme support
	add_filter('widget_text', 'do_shortcode');
	add_theme_support( 'automatic-feed-links' );	
	
	if ( ! isset( $content_width ) ){ $content_width = 980; }
	
	// update the option if new value is exists and not equal to old one 
		function save_option($name, $old_value, $new_value){
		
			if(empty($new_value) && !empty($old_value)){
			
				if(!delete_option($name)){
				
					return false;
					
				}
				
			}else if($old_value != $new_value){
			
				if(!update_option($name, $new_value)){
				
					return false;
					
				}
				
			}
			
			return true;
			
		}
	
	
	//Add Newsletter Table
	function add_newsletter_table() {
		global $wpdb;
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."cp_newsletter` (
			  `name` varchar(100) NOT NULL,
			  `email` varchar(100) NOT NULL,
			  `ip` varchar(16) NOT NULL,
			  `date_time` datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");
	}
	
	
	/* Flush rewrite rules for custom post types. */
		global $pagenow, $wp_rewrite;
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){
			//$wp_rewrite->flush_rules();
			add_action('init', 'add_newsletter_table');	
			
		if(get_option('default_pages_settings') == ''){$default_pages_xml = "";save_option('default_pages_settings', get_option('default_pages_settings'),$default_pages_xml);}if(get_option('general_settings') == ''){$general_settings = "<general_settings><header_logo></header_logo><logo_width>198</logo_width><logo_height>32</logo_height><select_layout_cp>full_layout</select_layout_cp><color_scheme>#c83200</color_scheme><select_bg_pat>Background-Color</select_bg_pat><bg_scheme>#ffffff</bg_scheme><body_patren></body_patren><color_patren>/framework/images/pattern/pattern-5.png</color_patren><body_image></body_image><position_image_layout>top</position_image_layout><image_repeat_layout>no-repeat</image_repeat_layout><image_attachment_layout>fixed</image_attachment_layout><contact_us_code>&lt;strong class=&quot;ph&quot;&gt;&lt;i class=&quot;fa fa-phone&quot;&gt;&lt;/i&gt;(123) 456 7980&lt;/strong&gt; &lt;a class=&quot;email&quot; href=&quot;mailto:&quot;&gt;&lt;i class=&quot;fa fa-envelope&quot;&gt;&lt;/i&gt;info@prayer.com&lt;/a&gt;</contact_us_code><topcounter_circle>enable</topcounter_circle><countd_event_category>93</countd_event_category><header_css_code></header_css_code><google_webmaster_code></google_webmaster_code><topbutton_icon>enable</topbutton_icon><topcart_icon>enable</topcart_icon><topsocial_icon>enable</topsocial_icon><select_footer_cp></select_footer_cp><footer_style_apply></footer_style_apply><footer_upper_layout></footer_upper_layout><copyright_code>&lt;p&gt;Copyright © 2014 All Rights Reserved by  &lt;a class=&quot;color-1&quot; href=&quot;#&quot;&gt; CrunchPress.com&lt;/a&gt;&lt;/p&gt;</copyright_code><social_networking>enable</social_networking><top_count_header></top_count_header><footer_banner>&lt;article class=&quot;call-us bg-purple&quot;&gt;
        	&lt;div class=&quot;container&quot;&gt;
            	&lt;div class=&quot;row&quot;&gt;
                	&lt;div class=&quot;span6&quot;&gt;
                    	&lt;p&gt;&lt;i class=&quot;fa fa-phone&quot;&gt;&lt;/i&gt;call us!  toll free   &lt;span&gt;0800 - FUTURISTIK&lt;/span&gt;&lt;/p&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;span6&quot;&gt;
                    	&lt;p&gt;&lt;i class=&quot;fa fa-truck&quot;&gt;&lt;/i&gt;free shipping on orders over $100&lt;/p&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/article&gt;</footer_banner><footer_col_layout>footer-style1</footer_col_layout><breadcrumbs>enable</breadcrumbs><rtl_layout>disable</rtl_layout><site_loader>enable</site_loader><element_loader>enable</element_loader><maintenance_mode>disable</maintenance_mode><maintenace_title></maintenace_title><countdown_time></countdown_time><email_mainte></email_mainte><mainte_description></mainte_description><social_icons_mainte>enable</social_icons_mainte><tf_username></tf_username><tf_sec_api></tf_sec_api></general_settings>";save_option('general_settings', get_option('general_settings'),$general_settings);}if(get_option('typography_settings') == ''){$typography_settings = "<typography_settings><font_google>open-sans</font_google><font_size_normal></font_size_normal><font_google_heading>Default</font_google_heading><menu_font_google>Noto Serif</menu_font_google><heading_h1></heading_h1><heading_h2></heading_h2><heading_h3></heading_h3><heading_h4></heading_h4><heading_h5></heading_h5><heading_h6></heading_h6><embed_typekit_code></embed_typekit_code></typography_settings>";save_option('typography_settings', get_option('typography_settings'),$typography_settings);}if(get_option('slider_settings') == ''){$slider_settings = "<slider_settings><select_slider>bx_slider</select_slider><bx_slider_settings><slide_order_bx>slide</slide_order_bx><auto_play_bx>enable</auto_play_bx><pause_on_bx>enable</pause_on_bx><animation_speed_bx>1500</animation_speed_bx></bx_slider_settings></slider_settings>";save_option('slider_settings', get_option('slider_settings'),$slider_settings);}if(get_option('social_settings') == ''){$social_settings = "<social_settings><facebook_network>#</facebook_network><twitter_network>#</twitter_network><delicious_network>#</delicious_network><google_plus_network>#</google_plus_network><linked_in_network>#</linked_in_network><youtube_network>#</youtube_network><flickr_network>#</flickr_network><vimeo_network>#</vimeo_network><pinterest_network>#</pinterest_network><Instagram_network>#</Instagram_network><github_network>#</github_network><skype_network>#</skype_network><facebook_sharing>disable</facebook_sharing><twitter_sharing>enable</twitter_sharing><stumble_sharing>enable</stumble_sharing><delicious_sharing>disable</delicious_sharing><googleplus_sharing>enable</googleplus_sharing><digg_sharing>enable</digg_sharing><myspace_sharing>enable</myspace_sharing><reddit_sharing>enable</reddit_sharing></social_settings>";save_option('social_settings', get_option('social_settings'),$social_settings);}if(get_option('sidebar_settings') == ''){$sidebar_settings = "<sidebar_settings><sidebar_name>Right Sidebar</sidebar_name><sidebar_name>Left Sidebar</sidebar_name><sidebar_name>Dual Sidebar Left</sidebar_name><sidebar_name>Dual Sidebar Right</sidebar_name><sidebar_name>Contact Us Sidebar</sidebar_name><sidebar_name>Events Sidebar</sidebar_name></sidebar_settings>";save_option('sidebar_settings', get_option('sidebar_settings'),$sidebar_settings);}
		}

		//Custom background Support	
		$args = array(
			'default-color'          => '',
			'default-image'          => '',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		);

		//Custom Header Support	
		$defaults = array(
			'default-image'          => '',
			'random-default'         => false,
			'width'                  => 950,
			'height'                 => 200,
			'flex-height'            => false,
			'flex-width'             => false,
			'default-text-color'     => '',
			'header-text'            => true,
			'uploads'                => true,
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		);
		global $wp_version;
		if ( version_compare( $wp_version, '3.4', '>=' ) ){ 
			add_theme_support( 'custom-background', $args );
			add_theme_support( 'custom-header', $defaults );
		}
	
	
	
	// echo get_option('show_on_front');
	// $page_on_front = get_option('show_on_front');
	// if($page_on_front == 'posts'){
	
	// }else{
	
	// }
	function maintenance_mode(){
	
	
		// save_option('show_on_front','', $show_on_front);
		// save_option('page_on_front','', $page_on_front);
	}		
	
		function ajax_login(){

		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-login-nonce', 'security-login' );

		// Nonce is checked, get the POST data and sign user on
		$info = array();
		$info['user_login'] = $_POST['username'];
		$info['user_password'] = $_POST['password'];
		$info['remember'] = true;

		$user_signon = wp_signon( $info, false );
		if ( is_wp_error($user_signon) ){
			echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
		} else {
			echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, Now Redirecting...')));
		}

		die();
	}	
	
	function ajax_login_init(){

		wp_register_script('ajax-login-script', CP_PATH_URL.'/frontend/js/ajax-login-script.js', array('jquery') ); 
		wp_enqueue_script('ajax-login-script');

		wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'redirecturl' => home_url(),
			'loadingmessage' => __('Sending user info, please wait...','crunchpress')
		));

		// Enable the user with no privileges to run ajax_login() in AJAX
		add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
	}	
	
	// Execute the action only if the user isn't logged in
	if (!is_user_logged_in()) {
		add_action('init', 'ajax_login_init');		
	}
	
	
	
	
	
	function ajax_signup(){

		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-signup-nonce', 'security' );

		// Nonce is checked, get the POST data and sign user on
		foreach ($_REQUEST as $keys=>$values) {
			$$keys = $values;
		}
		$default_role = get_option('default_role');
		//$info = array();
		$nickname = $_POST['nickname'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$user_email = $_POST['user_email'];
		$user_pass = $_POST['user_pass'];

		$userdata = array(
			'user_login'    => $nickname,
			'first_name'  => $first_name,
			'last_name'  => $last_name,
			'user_email'  => $user_email,
			'user_pass'  => $user_pass,
			'role' => $default_role
		);
		$user_signup = wp_insert_user( $userdata );
		if ( is_wp_error($user_signup) ){
			echo json_encode(array('signup'=>false, 'message'=>__('Please verify the details you are providing.','crunchpress')));
		} else {
			echo json_encode(array('signup'=>true, 'message'=>__('Your request submitted successfully, Redirecting you to login page!','crunchpress')));
		}

		die();
	}	
	
	function ajax_signup_init(){

		wp_register_script('ajax-signup-script', CP_PATH_URL.'/frontend/js/ajax-signup-script.js', array('jquery') ); 
		wp_enqueue_script('ajax-signup-script');

		wp_localize_script( 'ajax-signup-script', 'ajax_signup_object', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'redirecturl' => home_url(),
			'loadingmessage' => __('Sending user info, please wait...','crunchpress')
		));
		
		// Enable the user with no privileges to run ajax_login() in AJAX
		add_action('wp_ajax_ajaxsignup', 'ajax_signup');
		add_action( 'wp_ajax_nopriv_ajaxsignup', 'ajax_signup' );
	}
	
	add_action('init', 'ajax_signup_init');		