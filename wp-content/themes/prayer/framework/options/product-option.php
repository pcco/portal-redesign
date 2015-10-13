<?php

	/*	
	*	Crunchpress Portfolio Option File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		Crunchpress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) Crunchpress
	*	---------------------------------------------------------------------
	*	This file create and contains the portfolio post_type meta elements
	*	---------------------------------------------------------------------
	*/
	
	//FRONT END RECIPE LAYOUT
	$wooproduct_class = array("Full-Image" => array("index"=>"1", "class"=>"sixteen ", "size"=>array(1170,350), "size2"=>array(614,614), "size3"=>array(350,350)));

	
	// Print Recipe item
	function print_wooproduct_item($item_xml){
		global $paged,$sidebar,$wooproduct_class,$post,$wp_query,$counter;
		if(empty($paged)){
			$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
		}
		$sidebar_class = '';
		$layout_set_ajax = '';
		$item_type = 'Full-Image';
		// get the item class and size from array
		$item_class = $wooproduct_class[$item_type]['class'];
		$item_index = $wooproduct_class[$item_type]['index'];
		$full_content = find_xml_value($item_xml, 'show-full-news-post');
		if( $sidebar == "no-sidebar" ){
			$item_size = $wooproduct_class[$item_type]['size'];
			$sidebar_class = 'no_sidebar';
		}else if ( $sidebar == "left-sidebar" || $sidebar == "right-sidebar" ){
			$sidebar_class = 'one_sidebar';
			$item_size = $wooproduct_class[$item_type]['size2'];
		}else{
			$sidebar_class = 'two_sidebar';
			$item_size = $wooproduct_class[$item_type]['size3'];
		}
		
				
	// get the product meta value
	$header = find_xml_value($item_xml, 'header');
	$category = find_xml_value($item_xml, 'category');
	$num_fetch = find_xml_value($item_xml, 'num-fetch');
	$num_excerpt = find_xml_value($item_xml, 'num-excerpt');
	
	$select_layout_cp = '';
	$cp_general_settings = get_option('general_settings');
	if($cp_general_settings <> ''){
		$cp_logo = new DOMDocument ();
		$cp_logo->loadXML ( $cp_general_settings );
		$select_layout_cp = find_xml_value($cp_logo->documentElement,'select_layout_cp');
		
	}
	
	$show_filterable = find_xml_value($item_xml, 'filterable');
	$layout_select = find_xml_value($item_xml, 'layout_select');
	$pagination = find_xml_value($item_xml, 'pagination');
	
	
	
	
	
	//Theme Default Pagination
	if(find_xml_value($item_xml, "pagination") == 'Wp-Default'){
		$num_fetch = get_option('posts_per_page');
	}else if(find_xml_value($item_xml, "pagination") == 'Theme-Custom'){
		$num_fetch = find_xml_value($item_xml, 'num-fetch');
	}else{}
	$function_library = new function_library;
	if(class_exists("Woocommerce")){
		
	$quan = array();
	$quantity = '';
	$total = '';
	$currency = '';
	if($show_filterable == 'Yes' AND $layout_select == 'Grid'){
			if($category == '0'){
				query_posts(
					array( 
					'post_type' => 'product',
					'posts_per_page'			=> -1,
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}else{
				query_posts(
					array( 
					'post_type' => 'product',
					'posts_per_page'			=> -1,
					'paged'						=> $paged,
					//'ignore_sticky_posts' => true,
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'terms' => $category,
							'field' => 'term_id',
						)
					),
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}
		$counter_portfolio = 0;
	//Filterable Recipe Script start
	?>
	<script type="text/javascript">
		jQuery(window).load(function() {
			var filter_container = jQuery('#portfolio-item-holder-<?php echo $counter?>');

			filter_container.children().css('position','absolute');	
			filter_container.masonry({
				singleMode: true,
				itemSelector: '.portfolio-item:not(.hide)',
				animate: true,
				animationOptions:{ duration: 800, queue: false }
			});	
			jQuery(window).resize(function(){
				var temp_width =  filter_container.children().filter(':first').width() + 30;
				filter_container.masonry({
					columnWidth: temp_width,
					singleMode: true,
					itemSelector: '.portfolio-item:not(.hide)',
					animate: true,
					animationOptions:{ duration: 800, queue: false }
				});		
			});	
			jQuery('ul#portfolio-item-filter-<?php echo $counter?> a').click(function(e){	

				jQuery(this).addClass("active");
				jQuery(this).parents("li").siblings().children("a").removeClass("active");
				e.preventDefault();
				
				var select_filter = jQuery(this).attr('data-value');
				
				if( select_filter == "All" || jQuery(this).parent().index() == 0 ){		
					filter_container.children().each(function(){
						if( jQuery(this).hasClass('hide') ){
							jQuery(this).removeClass('hide');
							jQuery(this).fadeIn();
						}
					});
				}else{
					filter_container.children().not('.' + select_filter).each(function(){
						if( !jQuery(this).hasClass('hide') ){
							jQuery(this).addClass('hide');
							jQuery(this).fadeOut();
						}
					});
					filter_container.children('.' + select_filter).each(function(){
						if( jQuery(this).hasClass('hide') ){
							jQuery(this).removeClass('hide');
							jQuery(this).fadeIn();
						}
					});
				}
				
				filter_container.masonry();	
				
			});
		});
		</script>
		<figure class="page_title">
			<?php if($header <> ''){ ?>
				<div class="first">
					<h2><?php echo $header;?></h2>
				</div>
			<?php }
			
			?>			
			<div class="title_right">
				<div id="cart_dropdown" class="dropdown">
					<ul id="portfolio-item-filter-<?php echo $counter?>" class="category_list_filterable">
						<li><a data-value="all" class="cp-button active" href="#"><?php _e('All','crunchpress');?></a></li>
						<?php
						$categories = get_categories( array('child_of' => $category, 'taxonomy' => 'product_cat', 'hide_empty' => 0) );
						//$categories = get_the_terms( $post->ID, 'recipe-category' );								 
							if($categories <> ""){
								foreach($categories as $values){?>
								<li><a data-value="<?php echo $values->term_id;?>" class="cp-button" href="#"><?php echo $values->name;?></a></li>                                
							<?php
								}
							}?>                            						
					</ul>
				</div>
			</div>	
		</figure>
		<hr />
		<section class="product_view span12 first filterable-grid-style" id="product_grid">  
			<div id="portfolio-item-holder-<?php echo $counter?>" class="product_image_holder row grid-style">
				<?php
				$permalink_structure = get_option('permalink_structure');
				if($permalink_structure <> ''){
					$permalink_structure = '?';
				}else{
					$permalink_structure = '&';
				}
				$counter_product = 0;
				while( have_posts() ){
					the_post();	
					global $post,$post_id,$product,$product_url;
					$regular_price = get_post_meta($post->ID, '_regular_price', true);
					if($regular_price == ''){
						$regular_price = get_post_meta($post->ID, '_max_variation_regular_price', true);
					}
					$sale_price = get_post_meta($post->ID, '_sale_price', true);
					if($sale_price == ''){
						$sale_price = get_post_meta($post->ID, '_min_variation_sale_price', true);
					}
					$sku_num = get_post_meta($post->ID, '_sku', true);
					$currency = get_woocommerce_currency_symbol();
					 ?>
						
						
						<!--PRODUCT LIST ITEM START-->
						<div id="product-<?php echo $post->ID;?>" class="product-box all portfolio-item item alpha <?php $categories = get_the_terms( $post->ID, 'product_cat' );
							if($categories <> ''){
								foreach ( $categories as $category ) {
									echo $category->term_id." ";
								}
							}?>">
							<div class="frame"> <a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post_id, array(350,350));?></a>
								<div class="caption">
									<form enctype="multipart/form-data" method="post" class="cart" action="<?php echo get_permalink();?><?php echo $permalink_structure;?>add-to-cart=<?php echo $post->ID;?>">
										<!--<div class="quantity buttons_added"><input type="button" class="minus" value="-">
										<input type="number" class="input-text qty text" title="Qty" value="1" name="quantity" step="1">
										<input type="button" class="plus" value="+"></div>-->
										<button class="add_to_cart_button button product_type_simple added" data-quantity="1" data-product_sku="<?php echo $sku_num;?>" data-product_id="<?php echo $post->ID;?>" type="submit"><?php _e('Add to cart','crunchpress');?></button>
									</form>
									<div class="bottom-row woocommerce">
										<?php 
											if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
												return;

											$count   = $product->get_rating_count();
											$average = $product->get_average_rating();

											if ( $count > 0 ) : ?>

												<div class="woocommerce-product-rating" >
													<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
														<span class="rating-star-cp" style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
															<!--<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?>-->
														</span>
													</div>
													<!--<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $count, 'woocommerce' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?>)</a>-->
												</div>

											<?php endif; ?>
										<a href="<?php echo get_permalink();?>" class="like"><i class="fa fa-file-text-o"></i></a>
									</div>
								</div>
							</div>
						  <div class="bottom"> <strong class="title"><?php echo get_the_title();?></strong> <strong class="price"><?php echo $currency;?><?php if($sale_price <> ''){echo $sale_price;}else{echo $regular_price;}?></strong> </div>
						</div>
						<!--PRODUCT LIST ITEM END-->
						<?php
						$counter_product++;
				}//End While
			?>
			</div>	
		</section>
		<?php }else if($layout_select == 'Grid'){
			wp_reset_query();
			wp_reset_postdata();
			//Default Query For Grid
			if($category == '0'){
				query_posts(
					array( 
					'post_type' => 'product',
					'posts_per_page'			=> $num_fetch,
					'paged'						=> $paged,
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}else{
				query_posts(
					array( 
					'post_type' => 'product',
					'posts_per_page'			=> $num_fetch,
					'paged'						=> $paged,
					//'ignore_sticky_posts' => true,
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'terms' => $category,
							'field' => 'term_id',
						)
					),
					'orderby' => 'title',
					'post_status'=> 'publish',
					'order' => 'ASC' )
				);
			}
		
			
		?>
		<!--Cart Listing -->
		<?php if($header <> ''){ ?>
		<figure class="page_title">
			<div class="span8 first">
				<h2><?php echo $header;?></h2>
			</div>
			<?php if(!empty($woocommerce)){echo $woocommerce->messages[0];}?>
			<div class="span4 title_right">
			</div>
		</figure>
		<?php }?>
		<!--Cart Listing Ends-->
		
		<!--Grid View Start-->
		<section class="product_view" id="product_grid">  
			<div class="row-fluid grid-list-view product_image_holder grid-style">
				<?php
				$counter_product = 0;
				while( have_posts() ){
					the_post();	
					global $post,$post_id,$product,$product_url,$woocommerce;
					$permalink_structure = get_option('permalink_structure');
					if($permalink_structure <> ''){
						$permalink_structure = '?';
					}else{
						$permalink_structure = '&';
					}
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
					//print_r($woocommerce);
					
					if($counter_product % 3 == 0){ ?>
					<div class="clear clearfix"></div>
						<!--PRODUCT LIST ITEM START-->
						<div id="product-<?php echo $post->ID;?>" class="span4 first item">
							<div class="product-box">
								<div class="frame"> <a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post_id, array(350,350));?></a>
									<div class="caption">
										<form enctype="multipart/form-data" method="post" class="cart" action="<?php echo get_permalink();?><?php echo $permalink_structure;?>add-to-cart=<?php echo $post->ID;?>">
											<button class="add_to_cart_button button product_type_simple added" data-quantity="1" data-product_sku="<?php echo $sku_num;?>" data-product_id="<?php echo $post->ID;?>" type="submit"><?php _e('Add to cart','crunchpress');?></button>
										</form>
										<div class="bottom-row woocommerce">
										<?php 
											if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
												return;

											$count   = $product->get_rating_count();
											$average = $product->get_average_rating();

											if ( $count > 0 ) : ?>

												<div class="woocommerce-product-rating" >
													<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
														<span class="rating-star-cp" style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
															<!--<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?>-->
														</span>
													</div>
													<!--<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $count, 'woocommerce' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?>)</a>-->
												</div>

											<?php endif; ?>
											<a href="<?php echo get_permalink();?>" class="like"><i class="fa fa-file-text-o"></i></a>
										</div>
									</div>
								</div>
							  <div class="bottom"> <strong class="title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></strong> <strong class="price"><?php echo $currency;?><?php if($sale_price <> ''){echo $sale_price;}else{echo $regular_price;}?></strong> </div>
							</div>
						</div>
						<!--PRODUCT LIST ITEM END-->
					<?php }else{ ?>
						<!--PRODUCT LIST ITEM START-->
						<div id="product-<?php echo $post->ID;?>" class="span4 item">
							<div class="product-box">
								<div class="frame"> <a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post_id, array(350,350));?></a>
									<div class="caption">
										<form enctype="multipart/form-data" method="post" class="cart" action="<?php echo get_permalink();?><?php echo $permalink_structure;?>add-to-cart=<?php echo $post->ID;?>">
											<!--<div class="quantity buttons_added"><input type="button" class="minus" value="-">
											<input type="number" class="input-text qty text" title="Qty" value="1" name="quantity" step="1">
											<input type="button" class="plus" value="+"></div>-->
											<button class="add_to_cart_button button product_type_simple added" data-quantity="1" data-product_sku="<?php echo $sku_num;?>" data-product_id="<?php echo $post->ID;?>" type="submit"><?php _e('Add to cart','crunchpress');?></button>
										</form>
										<div class="bottom-row woocommerce">
										<?php 
											if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
												return;

											$count   = $product->get_rating_count();
											$average = $product->get_average_rating();

											if ( $count > 0 ) : ?>

												<div class="woocommerce-product-rating" >
													<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
														<span class="rating-star-cp" style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
															<!--<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?>-->
														</span>
													</div>
													<!--<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $count, 'woocommerce' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?>)</a>-->
												</div>

											<?php endif; ?>
											<a href="<?php echo get_permalink();?>" class="like"><i class="fa fa-file-text-o"></i></a>
										</div>
									</div>
								</div>
							  <div class="bottom"> <strong class="title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></strong> <strong class="price"><?php echo $currency;?><?php if($sale_price <> ''){echo $sale_price;}else{echo $regular_price;}?></strong> </div>
							</div>
						</div>
						<!--PRODUCT LIST ITEM END-->
					<?php } $counter_product++;
				}//End While ?>
			</div>	
		</section>
		<?php }else if($layout_select == 'Combine'){
			wp_reset_query();
			wp_reset_postdata();
			//Default Query to Fetch All Posts
			if($category == '0'){
				query_posts(
					array( 
					'post_type' 	=> 'product',
					'posts_per_page'=> $num_fetch,
					'paged'			=> $paged,
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}else{
				query_posts(
					array( 
					'post_type' => 'product',
					'posts_per_page'			=> $num_fetch,
					'paged'						=> $paged,
					//'ignore_sticky_posts' => true,
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'terms' => $category,
							'field' => 'term_id',
						)
					),
					'orderby' => 'title',
					'post_status'=> 'publish',
					'order' => 'ASC' )
				);
			}
			?>
			<?php if($header <> ''){ ?>
			<!--Cart Listing -->
			<figure class="page_title">
				<div class="span8 first">
					<h2><?php echo $header;?></h2>
				</div>
				<?php if(!empty($woocommerce)){echo $woocommerce->messages[0];}?>
				<div class="span4 title_right">
				</div>
			</figure>
			<!--Cart Listing Ends-->
			<?php }?>
			<div class="tabs">
				<figure class="span12 first">
					<!--<span class="short-pages">Items per page: <a href="#">5</a>   /  <a href="#"> 10 </a>  /  <a href="#"> 20 </a>  / <a href="#">  50 </a></span>-->
					<section class="grid-list-nav">
							<ul class="g-l-nav nav nav-tabs">
								<!--<li class="item-num"><?php echo $num_fetch;?> <?php _e('item(s)','crunchpress');?></li>-->
								<li><a class="grid_switch"  href="#product_grid"><i class="fa fa-th-large"></i><?php _e('Grid','crunchpress');?> </a></li>
								<li><a class="grid_switch"  href="#product_ful"><i class="fa fa-list"></i> <?php _e('List','crunchpress');?></a></li>
							</ul>
						<!--<figure class="span6">
							<?php if($header <> ''){ ?><h2 class="headings"><?php echo $header;?></h2><?php }?>
						</figure>-->
					</section>
				</figure>

				<!--Grid View Start-->
				<section class="product_view" id="product_grid">  
					<div class="grid-list-view product_image_holder row-fluid grid-style">
						<?php
						//tab Script
						wp_enqueue_script('jquery-ui-tabs');
						wp_register_script('cp-tabs-script', CP_PATH_URL.'/frontend/js/tabs_script.js', false, '1.0', true);
						wp_enqueue_script('cp-tabs-script');
						
						$counter_product = 0;
						while( have_posts() ){
							the_post();	
							global $post,$post_id,$product,$product_url,$woocommerce;
							$permalink_structure = get_option('permalink_structure');
							if($permalink_structure <> ''){
								$permalink_structure = '?';
							}else{
								$permalink_structure = '&';
							}
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
							if($counter_product % 3 == 0){ ?>								
								<div class="clear clearfix"></div>
							<div id="product-<?php echo $post->ID;?>" class="span4 first item">
								<div class="product-box">
									<div class="frame"> <a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post_id, array(350,350));?></a>
										<div class="caption">
											<form enctype="multipart/form-data" method="post" class="cart" action="<?php echo get_permalink();?><?php echo $permalink_structure;?>add-to-cart=<?php echo $post->ID;?>">
												<!--<div class="quantity buttons_added"><input type="button" class="minus" value="-">
												<input type="number" class="input-text qty text" title="Qty" value="1" name="quantity" step="1">
												<input type="button" class="plus" value="+"></div>-->
												<button class="add_to_cart_button button product_type_simple added" data-quantity="1" data-product_sku="<?php echo $sku_num;?>" data-product_id="<?php echo $post->ID;?>" type="submit"><?php _e('Add to cart','crunchpress');?></button>
											</form>
											<div class="bottom-row woocommerce">
											<?php 
												if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
													return;

												$count   = $product->get_rating_count();
												$average = $product->get_average_rating();

												if ( $count > 0 ) : ?>

													<div class="woocommerce-product-rating" >
														<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
															<span class="rating-star-cp" style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
																<!--<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?>-->
															</span>
														</div>
														<!--<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $count, 'woocommerce' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?>)</a>-->
													</div>

												<?php endif; ?>
												<a href="<?php echo get_permalink();?>" class="like"><i class="fa fa-file-text-o"></i></a>
											</div>
										</div>
									</div>
								  <div class="bottom"> <strong class="title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></strong> <strong class="price"><?php echo $currency;?><?php if($sale_price <> ''){echo $sale_price;}else{echo $regular_price;}?></strong> </div>
								</div>
							</div>
							<?php }else{ ?>
							<div id="product-<?php echo $post->ID;?>" class="span4 item">
								<div class="product-box">
									<div class="frame"> <a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post_id, array(350,350));?></a>
										<div class="caption">
											<form enctype="multipart/form-data" method="post" class="cart" action="<?php echo get_permalink();?><?php echo $permalink_structure;?>add-to-cart=<?php echo $post->ID;?>">
												<!--<div class="quantity buttons_added"><input type="button" class="minus" value="-">
												<input type="number" class="input-text qty text" title="Qty" value="1" name="quantity" step="1">
												<input type="button" class="plus" value="+"></div>-->
												<button class="add_to_cart_button button product_type_simple added" data-quantity="1" data-product_sku="<?php echo $sku_num;?>" data-product_id="<?php echo $post->ID;?>" type="submit"><?php _e('Add to cart','crunchpress');?></button>
											</form>
											<div class="bottom-row woocommerce">
											<?php 
												if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
													return;

												$count   = $product->get_rating_count();
												$average = $product->get_average_rating();

												if ( $count > 0 ) : ?>

													<div class="woocommerce-product-rating" >
														<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
															<span class="rating-star-cp" style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
																<!--<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?>-->
															</span>
														</div>
														<!--<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $count, 'woocommerce' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?>)</a>-->
													</div>

												<?php endif; ?>
												<a href="<?php echo get_permalink();?>" class="like"><i class="fa fa-file-text-o"></i></a>
											</div>
										</div>
									</div>
								  <div class="bottom"> <strong class="title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></strong> <strong class="price"><?php echo $currency;?><?php if($sale_price <> ''){echo $sale_price;}else{echo $regular_price;}?></strong> </div>
								</div>
							</div>
							<?php } $counter_product++;
						}//End While ?>
					</div>	
				</section>
				<!--Product Listing Full -->
				<div class="product_view list-style" id="product_ful">
					<?php
					$counter_product = 0;
					while( have_posts() ){
						the_post();	
						global $post,$post_id,$product,$product_url,$woocommerce;
						$regular_price = get_post_meta($post->ID, '_regular_price', true);
						if($regular_price == ''){
							$regular_price = get_post_meta($post->ID, '_max_variation_regular_price', true);
						}
						$sale_price = get_post_meta($post->ID, '_sale_price', true);
						if($sale_price == ''){
							$sale_price = get_post_meta($post->ID, '_min_variation_sale_price', true);
						}
						$currency = get_woocommerce_currency_symbol();
						?>
							<!--PRODUCT LIST ITEM START-->
							<div class="product_item_list">
								<figure>
									<a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post_id, $item_size);?></a>
									<form enctype="multipart/form-data" method="post" class="cart" action="<?php echo get_permalink();?><?php echo $permalink_structure;?>add-to-cart=<?php echo $post->ID;?>">
										<!--<div class="quantity buttons_added"><input type="button" class="minus" value="-">
										<input type="number" class="input-text qty text" title="Qty" value="1" name="quantity" step="1">
										<input type="button" class="plus" value="+"></div>-->
										<button class="add_to_cart_button button product_type_simple added" data-quantity="1" data-product_sku="<?php echo $sku_num;?>" data-product_id="<?php echo $post->ID;?>" type="submit"><?php _e('Add to cart','crunchpress');?></button>
									</form>
								</figure>
								<div class="text">
									<h3><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h3>
									<p><?php echo substr(strip_tags(get_the_content()),0,$num_excerpt);?></p>
									<h4><?php echo __('Price:','crunchpress'); ?> <?php echo $currency;?><?php if($sale_price <> ''){echo $sale_price;}else{echo $regular_price;}?></h4>
									<a href="<?php echo get_permalink();?>" class="wishlist"><?php _e('Read More','crunchpress');?></a>
								</div>
							</div>
							<!--PRODUCT LIST ITEM END-->
							<div class="clear"></div>
					<?php }?>
				</div>
				<!--Product Listing Full Ends-->
			</div>
			<?php  
		}else{ 
			wp_reset_query();
			wp_reset_postdata();
			if($category == '0'){
				query_posts(
					array( 
					'post_type' => 'product',
				'posts_per_page'			=> $num_fetch,
					'paged'						=> $paged,
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}else{
				query_posts(
					array( 
					'post_type' => 'product',
					'posts_per_page'			=> $num_fetch,
					'paged'						=> $paged,
					//'ignore_sticky_posts' => true,
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'terms' => $category,
							'field' => 'term_id',
						)
					),
					'orderby' => 'title',
					'post_status'=> 'publish',
					'order' => 'ASC' )
				);
			}
		?>
		<?php if($header <> ''){ ?>
		<figure class="page_title row-fluid">
			<div class="span12 first">
				<h2><?php echo $header;?></h2>
			</div>
		</figure>
		<?php }?>
		<div class="product_view list-style" id="product_ful">
				<?php
				$counter_product = 0;
				while( have_posts() ){
					the_post();	
					global $post,$post_id,$product,$product_url,$woocommerce;
					$permalink_structure = get_option('permalink_structure');
					if($permalink_structure <> ''){
						$permalink_structure = '?';
					}else{
						$permalink_structure = '&';
					}
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
					?>
					<!--PRODUCT LIST ITEM START-->
					<div class="woo-item">
						<figure>
							<a href="<?php echo get_permalink();?>"><?php echo get_the_post_thumbnail($post_id, array(1170,350));?></a>
							<form enctype="multipart/form-data" method="post" class="cart" action="<?php echo get_permalink();?><?php echo $permalink_structure;?>add-to-cart=<?php echo $post->ID;?>">
								<!--<div class="quantity buttons_added"><input type="button" class="minus" value="-">
								<input type="number" class="input-text qty text" title="Qty" value="1" name="quantity" step="1">
								<input type="button" class="plus" value="+"></div>-->
								<button class="add_to_cart_button button product_type_simple added" data-quantity="1" data-product_sku="<?php echo $sku_num;?>" data-product_id="<?php echo $post->ID;?>" type="submit"><?php _e('Add to cart','crunchpress');?></button>
							</form>
							
						</figure>
						<div class="text">
							<h3><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h3>
							<p><?php echo substr(strip_tags(get_the_content()),0,$num_excerpt);?></p>
							<h4><?php echo __('Price:','crunchpress'); ?> <?php echo $currency;?><?php if($sale_price <> ''){echo $sale_price;}else{echo $regular_price;}?></h4>
							<a href="<?php echo get_permalink();?>" class="wishlist"><?php _e('Read More','crunchpress');?></a>
						</div>
					</div>
					<!--PRODUCT LIST ITEM END-->
					<div class="clear"></div>
				<?php
				}//End While
			?>
			
		</div>
		<?php }?>
		<div class="clear"></div>
		<?php
		if( find_xml_value($item_xml, "pagination") == "Theme-Custom"){	
			pagination();
		}
	}		
}	


	 function get_cart() {
		return array_filter( (array) $this->cart_contents );
	}
	
	function get_remove_url( $cart_item_key ) {
		global $woocommerce;
		$cart_page_id = woocommerce_get_page_id('cart');
		if ($cart_page_id)
			return apply_filters( 'woocommerce_get_remove_url', wp_nonce_url( 'cart', add_query_arg( 'remove_item', $cart_item_key, get_permalink($cart_page_id) ) ) );
	}
	
	//$WC_Product =  new WC_Product;
	//global $post_id;
	
	
?>