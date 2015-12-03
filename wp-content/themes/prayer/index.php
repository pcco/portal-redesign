<?php
/*
 * This file is used to generate main index page.
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

		@get_header();
		
		global $post,$post_id;
		?>
		
		<div class="contant">
			<?php if(!is_front_page()){?>
			<?php $breadcrumbs = get_themeoption_value('breadcrumbs','general_settings');
				if($breadcrumbs == 'enable'){ ?>
			<!--Inner Pages Heading Area Start-->
			<section class="inner-headding">
				<div class="container">
					<div class="row-fluid">
						<div class="span12">
							<?php
								
									echo cp_breadcrumbs();
								
							?>
						</div>
					</div>
				</div>
			</section>
			<!--Inner Pages Heading Area End--> 
			<?php }?>
			<?php }?>
			<div class="container">
				<!--MAIN CONTANT ARTICLE START-->
				<div class="main-content">
					<div class="single_content row-fluid">
						<div id="post-<?php the_ID(); ?>" class="blog_post_detail">
									<?php
									//Feature Sticky Post	
										if ( is_front_page() && cp_has_featured_posts() ) {
											// Include the featured content template.
											get_template_part( 'featured-content' );
										}
										$mask_html = '';
										$no_image_class = 'no-image';
									?>
									<?php while ( have_posts() ) : the_post();
										//If image exists print its mask
											$mask_html = '';
											$no_image_class = 'no-image';
											if(get_the_post_thumbnail($post_id, array(1170,350)) <> ''){
												$mask_html = '<div class="mask">
													<a href="'.get_permalink().'#comments" class="anchor"><span> </span> <i class="fa fa-comment"></i></a>
													<a href="'.get_permalink().'" class="anchor"> <i class="fa fa-link"></i></a>
												</div>';
												$no_image_class = 'image-exists';
											}	
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
															<?php the_tags('<li class="tagcloud"><i class="fa fa-tags"></i>','','</li>');?>
															<li class="tagcloud"><i class="fa fa-reorder"></i>
															<?php 
															$variable = wp_get_post_terms( $post->ID, 'category'); $counterr = 0;
															foreach($variable as $values){
																//if($counterr == 0){ echo 'Category:  ';}
																$counterr++;
																echo '<a href="'.get_term_link(intval($values->term_id),'category').'">'.$values->name.'</a>  ';}?>
															</li>
														</ul>						
													</div>
													<div class="span9 post_description"> 
														<h3><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></h3>
														<?php 
															the_content();				
															wp_link_pages( array(
																'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'rockon' ) . '</span>',
																'after'       => '</div>',
																'link_before' => '<span>',
																'link_after'  => '</span>',
															) );
														?>
													</div>
												</div>
											</div>
										</figure>
								<?php endwhile; pagination();?>
						</div>
					</div>
				</div>	
			</div>
		</div>	
<?php 
		//Reset all data now
		wp_reset_query();
		wp_reset_postdata();
			
		@get_footer();
}
 ?>