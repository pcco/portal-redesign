<?php

	// Ajax to include font infomation
	add_action('wp_ajax_nopriv_cp_color_bg', 'cp_color_bg');
	add_action('wp_ajax_cp_color_bg','cp_color_bg');
	function cp_color_bg($recieve_color='',$backend_on_off=''){
	
		global $html_new;
		if($backend_on_off <> 1){
			$recieve_color = $_POST['color'];
		}		
		/*
		================================================
						Create StyleSheet
		================================================
		*/
		$html_new .= '<style id="stylesheet">';
			
				/*
				================================================
							TEXT SELECTION COLOR 
				================================================
				*/

				$html_new .= '::selection {
					background: '.$recieve_color.'; /* Safari */
					color:#fff;
					}
				::-moz-selection {
					background: '.$recieve_color.'; /* Firefox */
					color:#fff;
				}';
				
				
				/*
				===============================================================
											BACKGROUND COLOR
				===============================================================
				*/
				$html_new .= '#pagination .page-numbers.current, .woocommerce-message, .timeline-frame-outer .caption, .color-1, .product-box .frame .caption:before, .product-box .bottom strong.price, .search-box a.crose, .products .added_to_cart, .fc-event-inner, div.jp-volume-bar-value, a.jp-play:hover, .reset_variations, .single_add_to_cart_button, .products .add_to_cart_button.product_type_variable, #active-btn-play, .form-row.form-row-last [type="submit"], .form-row.place-order [type="submit"], .shop_table tfoot, .woocommerce-info, .shipping_calculator button.button, .actions [type="submit"], .post-edit-link, .coming-soon .countdown_amount,.btn-style, .notify-input .share-it i, .grid-list-nav li.ui-tabs-active a, a.product_type_grouped, #portfolio-item-filter-1 li a, .topbar-search-input, .nav-bar-bg, #header, .logo-row, .topbar-search-input, .navbar-toggle, .featured-sermon, .sermons-box .frame .caption:before, .latest-event-box .frame .date, .latest-event-box .frame .inner-area:before, .timelines-box #bx-pager > a, .our-preachers-box, .donate-form ul li a:hover, .donate-form ul li:hover a:before, .donate-form ul li:hover .inner, .gallery-frame .caption:before, .grid .caption:before, .error-page, .location-form, .location-search-input, .location-form, .timeline-row .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .popular-sermons ul li:hover a.play, .upcoming-events ul li:hover .date-box, .date-box, .event-detail-timer, .date-box-01, .date-box-02, .event-listing-box .frame .caption:before, .news-listing .frame .detail-row, .post_meta ul li, .widget_search #searchsubmit, .page-links a, .post-password-form input[type="submit"], .tagcloud a, #cancel-comment-reply-link, .fc-header, .fc-day:hover, .widget-box:hover .btn-container a, #praybox input[type="submit"], .onsale, .product_view a.wishlist, .product_meta span a:hover, .page-numbers li a:hover, #product_ful .add_to_cart_button, #product_ful .added_to_cart, .timelines-box #bx-pager a.active, .timelines-box #bx-pager a.active:before, .timelines-box .bx-wrapper .bx-controls-direction a:hover, .sermon-box .text-box .list-area li a:hover, .woo_product .button.add_to_cart_button.product_type_simple, .single_content .topbar-social li:hover i, .team-content .topbar-social li:hover{
					background-color:'.$recieve_color.' !important;
				}';

				
				/*
				===============================================================
											TEXT COLOR
				===============================================================
				*/
				$html_new .= '.product-box .frame .caption .bottom-row a.like, .woo_product .star-rating span, .products .star-rating span, .woocommerce-product-rating .star-rating .rating-star-cp, #reply-title, .sidebar_section.widget h2, div.jp-type-playlist div.jp-playlist a.jp-playlist-current, .h-style, .welcome-box .holder h2 span.color, .widget-box .round .fa, .latest-sermons-box h3, .sermons-box:hover .text-box h4, .latest-event h3, .blog-posts h3, .news-timelines-box h3, .donation-page h2, .error-page .holder h2 span, .contact-page address strong.heading, .about-page h2, .church-services h3, .services-box:hover .fa, .services-box:hover h4, .accordtion-area h3, .tab-area .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .tab-area .nav-tabs > li > a:hover, .nav > li > a:hover, .timeline-row .nav > li > a:focus, .preachers h3, .other-project h3, .popular-sermons h3, .popular-sermons ul li:hover strong.title, .upcoming-events h3, .upcoming-events ul li:hover strong.title, .recent-post h3, .sidebar-latest-news h3, .categories-box h3, .flickr-photo h3, .tags-box h3, .auther-box h4, .comment-form h4, .prayer-wall h2, .prayer-wall-deatil a.count, .prayer-wall-deatil a:hover, .prayer-wall-deatil a:hover .fa, .prayer-wall ul li:hover .prayer-wall-box h3, .related-events h3, .event-listing ul li:hover .text-box h2, .comment-box h3, .news-listing h2, .news-listing h3, .sermon-page ul li:hover .text-box h2, figure.blog_item .gallery_img .mask a:hover, .related li h3, .woo_product li h3, .woo_product .span3 h3, #praybox tr.pb-datarow td a,  .shipping_calculator h2 a, .sidebar_section.widget_em_widget > ul > li:hover a, .sidebar-latest-news ul li:hover a, .sidebar-latest-news .text-box a.readmore:hover, .sermon-box .text-box a:hover, .event-listing-box .text-box h2 a:hover, .event-listing-box .text-box .detail-row a:hover, .product_view a:hover, .single_content .topbar-social li:hover a, .single_content .topbar-social li:hover span, .sermons-box .text-box a:hover, .sermons-box .text-box a.readmore:hover, .blog-posts-box .text-box .left a:hover, .blog-posts-box .text-box .right a.readmore:hover, .latest-news .text-box strong.title a:hover, .date-row a:hover, .latest-news a.readmore:hover, .event-listing-box .text-box a.readmore:hover{
					color:'.$recieve_color.';
				}';

				/*
				===============================================================
											BORDER COLOR
				===============================================================
				*/
				$html_new .= '.woocommerce-tabs ul.tabs li.active, .widget-box .round, .widget-box:hover a.btn-widget, .sermons-box .text-box a.readmore:before, .blog-posts-box .text-box .right a.readmore:before, .latest-news a.readmore:before, .services-box a.readmore:before, .services-box:hover .round-frame, .tab-area .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .tab-area .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .tab-area .nav-tabs > li > a:hover, .nav > li > a:hover, .nav > li > a:focus, .post-box .text-box .right a.readmore:before, .popular-sermons ul li:hover a.play, .recent-post .text-box a.readmore:before, .sidebar-latest-news .text-box a.readmore:before, .event-listing-box .text-box a.readmore:before, .tab-area .nav > li.ui-tabs-active > a, .sermon-box .text-box .list-area li a:hover{
					border-color:'.$recieve_color.';
				}';
				
				$html_new .= '.color-1:before{
					border-top-color:'.$recieve_color.';
				}';
				/*
				===============================================================
											HOVER COLOR
				===============================================================
				*/				
				$html_new .= '.widget-box:hover .round, .widget-box:hover a.btn-widget{
					background-color:'.$recieve_color.';
				}';
				/*
				===============================================================
											BOX SHADOW COLOR
				===============================================================
				*/	
				$html_new .= '.widget-box:hover a.btn-widget{
					box-shadow:'.$recieve_color.' !important;
				}';
				/*
				===============================================================
											BUTTON COLOR
				===============================================================
				*/	
				$html_new .= '.form-submit > input, .latest-event a.view-calender, .btn-submit-news, .donate-btn-submit, .pagination-all.pagination ul > .active > a, .pagination ul > .active > span, .pagination-all.pagination ul > li > a:hover, .pagination ul > li > a:focus, .pagination ul > .active > a, .pagination ul > .active > span, .error-search-btn, .detail-btn-sumbit2, .sidebar-btn-search, .comment-btn-sumbit, .fram-holder .left a.btn-participate{
					background-color:'.$recieve_color.';
				}';

		$html_new .= '</style>';
		
		//Color Picker Is Installed 
		if($backend_on_off <> 1){
			die(json_encode($html_new));
		}else{
			return $html_new;
		}
		
	}


	// Add Style to Frontend
	function add_font_code(){
		global $pagenow;
		
		//Style tag Start
		echo '<style type="text/css">';
			
			//Attach Background
			$select_bg_pat = get_themeoption_value('select_bg_pat','general_settings');
			$body_image = get_themeoption_value('body_image','general_settings');
			$image_repeat_layout = get_themeoption_value('image_repeat_layout','general_settings');
			$position_image_layout = get_themeoption_value('position_image_layout','general_settings');
			$image_attachment_layout = get_themeoption_value('image_attachment_layout','general_settings');
			
			 if($select_bg_pat == 'Background-Image'){
				$image_src_head = '';							
				if(!empty($body_image)){ 
					$image_src_head = wp_get_attachment_image_src( $body_image, 'full' );
					$image_src_head = (empty($image_src_head))? '': $image_src_head[0];
					$thumb_src_preview = wp_get_attachment_image_src( $body_image, 'full');
				}
				echo 'body{
				background-image:url('.$thumb_src_preview[0].');
				background-repeat:'.$image_repeat_layout.';
				background-position:'.$position_image_layout.';
				background-attachment:'.$image_attachment_layout.';
				background-size:cover; }';
			}else if($select_bg_pat == 'Background-Color'){ 
				$bg_scheme = get_themeoption_value('bg_scheme','general_settings');
				echo 'body{background:'.$bg_scheme.' !important;} .inner-pages h2 .txt-left{background:'.$bg_scheme.';}';
			}else if($select_bg_pat == 'Background-Patren'){
				$body_patren = get_themeoption_value('body_patren','general_settings');
				$color_patren = get_themeoption_value('color_patren','general_settings');
				//render Body Pattern
				if(!empty($body_patren)){
					$image_src_head = wp_get_attachment_image_src( $body_patren, 'full' );
					$image_src_head = (empty($image_src_head))? '': $image_src_head[0];
					$thumb_src_preview = wp_get_attachment_image_src( $body_patren, array(60,60));
					//Custom patterm
					if($thumb_src_preview[0] <> ''){ echo 'body{background:url('.$thumb_src_preview[0].') repeat !important;}'; }
				}else{ 
					$bg_scheme = get_themeoption_value('bg_scheme','general_settings');
					$color_patren = get_themeoption_value('color_patren','general_settings');
					//Default patterns
					echo 
					'body{background:'.$bg_scheme.' url('.CP_PATH_URL.$color_patren.') repeat;} 
					.inner-pages h2 .txt-left{background:'.$bg_scheme.' url('.CP_PATH_URL.$color_patren.') repeat;}'; 
				}
			}
			
			//Heading Variables
			$heading_h1 = get_themeoption_value('heading_h1','typography_settings');
			$heading_h2 = get_themeoption_value('heading_h2','typography_settings');
			$heading_h3 = get_themeoption_value('heading_h3','typography_settings');
			$heading_h4 = get_themeoption_value('heading_h4','typography_settings');
			$heading_h5 = get_themeoption_value('heading_h5','typography_settings');
			$heading_h6 = get_themeoption_value('heading_h6','typography_settings');
			
			//Render Heading sizes
			if($heading_h1 <> ''){ echo 'h1{ font-size:'.$heading_h1.'px !important; }'; }
			if($heading_h2 <> ''){ echo 'h2{ font-size:'.$heading_h2.'px !important; }'; }
			if($heading_h3 <> ''){ echo 'h3{ font-size:'.$heading_h3.'px !important; }'; }
			if($heading_h4 <> ''){ echo 'h4{ font-size:'.$heading_h4.'px !important; }'; }
			if($heading_h5 <> ''){ echo 'h5{ font-size:'.$heading_h5.'px !important; }'; }
			if($heading_h6 <> ''){ echo 'h6{ font-size:'.$heading_h6.'px !important; }'; }
			
			//Body Font Size
			$font_size_normal = get_themeoption_value('font_size_normal','typography_settings');
			if($font_size_normal <> ''){ echo 'body{font-size:'.$font_size_normal.'px !important;}'; }
			
			//Body Font Family
			$font_google_cp = '';
			$font_google = get_themeoption_value('font_google','typography_settings');
			$font_google_cp = str_replace("-", " ", $font_google);
			if($font_google <> 'Default'){ echo 'body, .heading-2 h5, .widget a, input, button, select, textarea, .pagination-all.pagination ul > li > a, .pagination ul > li > span, .latest-event-box .frame .caption .text-box p, .text-area ul li a strong{ font-family:"'.$font_google_cp.'" !important;}'; }else{ 
			echo '';
			}
			
			//Body Font Size
			$boxed_scheme = get_themeoption_value('boxed_scheme','general_settings');
			$select_layout_cp = get_themeoption_value('select_layout_cp','general_settings');
			if($select_layout_cp == 'box_layout'){ echo '.boxed{background:'.$boxed_scheme.';}'; }
			
			//Heading Font Family
			$font_google_heading = get_themeoption_value('font_google_heading','typography_settings');
			if($font_google_heading <> 'Default'){ echo ' .latest-event .view-calender, .btn-purchase, .btn-submit-news, strong.title, .text-area strong.title a, h1, h2, h3, h4, h5, h6{ font-family:"'.$font_google_heading.'" !important;}'; }else{ echo 'h1, h2, h3, h4, h5, h6{}';}
			
			//Menu Font Family
			$menu_font_google = get_themeoption_value('menu_font_google','typography_settings');
			if($menu_font_google <> 'Default'){ echo 'a.readmore, #nav li a, .navbar ul{font-family:"'.$menu_font_google.'" !important;}';}else{ echo '#nav{font:16px/56px "Noto Serif",serif;}';}
			
		echo '</style>';
		//Style Tag End
		
		
		$color_scheme = get_themeoption_value('color_scheme','general_settings');		
		$recieve_color = '';
		$recieve_an_color = '';
		$html_new = '';
		$backend_on_off = 1;
		//Color Scheme
		if($color_scheme <> ''){
			$recieve_color = $color_scheme;
			//$recieve_an_color = $color_anchor;
			echo cp_color_bg($recieve_color,$backend_on_off);
		}
	}

	//Add Style in Footer
	global $pagenow;
	if( $GLOBALS['pagenow'] != 'wp-login.php' ){
		if(!is_admin()){
			//for Frontend only
			add_action('wp_head', 'add_font_code');
		}
	}