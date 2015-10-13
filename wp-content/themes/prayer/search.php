<?php
/*
 * This file is used to generate WordPress standard archive/category pages.
 */
get_header ();
	
	//Get Default Option for Archives, Category, Search.
	global $paged,$post,$sidebar,$blog_div_size_num_class,$counter,$wp_query;	
	$num_excerpt = '';
	$cp_default_settings = get_option('default_pages_settings');
	
	if($cp_default_settings != ''){
		$cp_default = new DOMDocument ();
		$cp_default->loadXML ( $cp_default_settings );
		$sidebar = find_xml_value($cp_default->documentElement,'sidebar_default');
		$right_sidebar = find_xml_value($cp_default->documentElement,'right_sidebar_default');
		$left_sidebar = find_xml_value($cp_default->documentElement,'left_sidebar_default');
		$num_excerpt = find_xml_value($cp_default->documentElement,'default_excerpt');
	}	
	//Get Default Excerpt
	if($num_excerpt == ''){$num_excerpt = 250;}
	
	if(empty($paged)){
		$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
	}
	
		
	$sidebar_class = '';
	$content_class = '';
	
	//Get Sidebar for page
	$sidebar_class = sidebar_func($sidebar);
	$header_style = '';
	
	$html_class_banner = '';
	$html_class = print_header_class($header_style);
	if($html_class <> ''){$html_class_banner = 'banner';} 	$item_margin = '';
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
    	<div class="container">
            <!--MAIN CONTANT ARTICLE START-->
            <div class="main-content">
            	
				
				<?php if (is_category()) { ?>
				<h2 class="h-style"><?php _e('Categories', 'crunchpress'); ?> <?php echo single_cat_title(); ?></h2><span class="border-line m-bottom"></span>
				<?php } elseif (is_day()) { ?>
					<h2 class="h-style"><?php _e('Archive for', 'crunchpress'); ?> 
					<?php echo get_the_date(get_option("time_format")); ?></h2><span class="border-line m-bottom"></span>
				<?php } elseif (is_month()) { ?>
					<h2 class="h-style"><?php _e('Archive for', 'crunchpress'); ?> <?php echo get_the_date(get_option("time_format")); ?></h2><span class="border-line m-bottom"></span>
				<?php } elseif (is_year()) { ?>
					<h2 class="h-style"><?php _e('Archive for', 'crunchpress'); ?> <?php echo get_the_date(get_option("time_format")); ?></h2><span class="border-line m-bottom"></span>
				<?php }elseif (is_search()) { ?>
					<h2 class="h-style"><?php _e('Search results for', 'crunchpress'); ?> : <?php echo get_search_query() ?></h2><span class="border-line m-bottom"></span>
				<?php } elseif (is_tag()) { ?>
					<h2 class="h-style"><?php _e('Tag Archives', 'crunchpress'); ?> : <?php echo single_tag_title('', true); ?></h2><span class="border-line m-bottom"></span>
				<?php }elseif (is_author()) { ?>
					<h2 class="h-style"><?php _e('Archive by Author', 'crunchpress'); ?></h2><span class="border-line m-bottom"></span>
				<?php }?>				
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
					<div id="<?php the_ID(); ?>" class="<?php echo $sidebar_class[1];?> blog_listing blog_post_detail cp-blog">
								<div <?php post_class(); ?>>
										<?php if (is_author()) { ?>
												<!--<h2 class="heading"><?php _e('Archive by Author', 'crunchpress'); ?></h2><span class="border-line m-bottom"></span>-->
											<?php 
											if ( have_posts() ) {
												the_post();?>
												<div class="clear"></div>
												<!--DETAILED TEXT END-->
												<div class="about-admin">
													<div class="thumb">
														<?php echo get_avatar(get_the_author_meta( 'ID' ));?>
													</div>
													<div class="text">
														<h4><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
																<?php the_author(); ?>
															</a>
														</h4>
														<p><?php echo mb_substr(get_the_author_meta( 'description' ),0,360);?></p>
														<div class="share-it">
															<h5><?php _e('Follow Me','crunchpress');?></h5>
															<?php 
																$facebook = get_the_author_meta('facebook');
																$twitter = get_the_author_meta('twitter');
																$gplus = get_the_author_meta('gplus');
																$linked = get_the_author_meta('linked');
																$skype = get_the_author_meta('skype');
															?>
															<?php if($facebook <> ''){ ?><a title="" data-toggle="tooltip" href="<?php echo $facebook;?>" data-original-title="facebook"><i class="fa fa-facebook"></i></a><?php }?>
															<?php if($twitter <> ''){ ?><a title="" data-toggle="tooltip" href="<?php echo $twitter;?>" data-original-title="Twitter"><i class="fa fa-twitter"></i></a><?php }?>
															<?php if($gplus <> ''){ ?><a title="" data-toggle="tooltip" href="<?php echo $gplus;?>" data-original-title="Google Plus"><i class="fa fa-google-plus"></i></a><?php }?>
															<?php if($linked <> ''){ ?><a title="" data-toggle="tooltip" href="<?php echo $linked;?>" data-original-title="Linkedin"><i class="fa fa-linkedin"></i></a><?php }?>
															<?php if($skype <> ''){ ?><a title="" data-toggle="tooltip" href="<?php echo $skype;?>" data-original-title="skype"><i class="fa fa-skype"></i></a><?php }?>
														</div>
													</div>
												</div>
												<div class="clear"></div>
											<?php
											} wp_reset_query();
										}
										if ( have_posts() ) : while ( have_posts() ) : the_post();
											//Image dimenstion
										global $post, $post_id;	
										$mask_html = '';
										$no_image_class = 'no-image';
										if(get_the_post_thumbnail($post_id, array(1170,350)) <> ''){
											$mask_html = '<div class="mask">
												<a href="'.get_permalink().'#comments" class="anchor"><span> </span> <i class="fa fa-comment"></i></a>
												<a href="'.get_permalink().'" class="anchor"> <i class="fa fa-link"></i></a>
											</div>';
											$no_image_class = 'image-exists';
										}	
										$arc_div_archive_listing_class = array("Full-Image" => array("index"=>"1", "class"=>"sixteen ", "size"=>array(1170,420), "size2"=>array(770, 400), "size3"=>array(570,300)));
										$item_type = 'Full-Image';
										$item_class = $arc_div_archive_listing_class[$item_type]['class'];
										$item_index = $arc_div_archive_listing_class[$item_type]['index'];		
										if( $sidebar == "no-sidebar" ){
											$item_size = $arc_div_archive_listing_class[$item_type]['size'];
										}else if ( $sidebar == "left-sidebar" || $sidebar == "right-sidebar" ){
											$item_size = $arc_div_archive_listing_class[$item_type]['size2'];
										}else{
											$item_size = $arc_div_archive_listing_class[$item_type]['size3'];
										}
										//print_r($item_size);
										?>
											<figure class="blog_item <?php echo $no_image_class;?>">
												<?php if(get_the_post_thumbnail($post_id, array(1170,350)) <> ''){?>
													<div class="gallery_img gallery_img-first">
														<?php echo get_the_post_thumbnail($post_id, array(1170,350));
														 echo $mask_html; ?>
													</div>  
												<?php }?>
												<div class="outer_lyr span12 first">
													<div class="row-fluid inner_lyr">
														<div class="span3 post_meta"> 
															<ul>
																<li class="date"> <i class="fa fa-time"></i>  <?php echo get_the_date(get_option("date_format"));?></li>
																<li class="author"><i class="fa fa-user"></i> <?php _e('by','crunchpress');?>   <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_link();?></a></li>
																<li class="commetns"> <i class="fa fa-comment"></i>  <?php comments_popup_link( __('0 Comment','crunchpress'),__('1 Comment','crunchpress'),__('% Comments','crunchpress'), '',__('Comments are off','crunchpress') );?></li>
																	<?php
																//Tags																
																	the_tags('<li class="tagcloud"><i class="fa fa-tags"></i>','','</li>');
																	$variable = wp_get_post_terms( $post->ID, 'category'); $counterr = 0;
																	if($variable <> ''){ ?>
																	<li class="categories-cp">
																		<i class="fa fa-reorder"></i>
																		<?php 
																		foreach($variable as $values){
																			//if($counterr == 0){ echo 'Category:  ';}
																			$counterr++;
																			echo '<a href="'.get_term_link(intval($values->term_id),"category").'">'.$values->name.'</a>  ';
																		}?>
																	</li>
																<?php } ?>
															</ul>						
														</div>
														<div class="span9 post_description"> 
															<h3><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h3>
															<p><?php echo substr(get_the_excerpt(),0, $num_excerpt);?></p>
															<br />
															<?php if(strlen(get_the_excerpt() > $num_excerpt)){?><a class="read_more" href="<?php echo get_permalink()?>"><em><?php echo __('Read More','crunchpress') ?></em></a><?php }?>
														</div>
													</div>
												</div>
											</figure>
											<?php 
										//End while
										endwhile; 
										//Condition Ends
										endif;
										//Pagination
										pagination();
									?>
									</div>
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
<div class="clear"></div>
<?php get_footer(); ?>