<?php
/**
 * The template for displaying featured content
 *
 * @package CrunchPress
 * @subpackage Rockon
 */
?>

<div id="featured-content" class="featured-content cp-blog">
	<div class="featured-content-inner cp-blog">
	<?php
		/**
		 * Fires before the Twenty Fourteen featured content.
		 *
		 * @since Twenty Fourteen 1.0
		 */
		//do_action( 'twentyfourteen_featured_posts_before' );
		
		$thumbnail_types = '';
		$counter_posts = 1;
		$featured_posts = cp_get_featured_posts();
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post ); 
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
			}
			
				$mask_html = '';
				$no_image_class = 'no-image';
				if(get_the_post_thumbnail($post->ID, array(1170,350)) <> ''){
					$mask_html = '<div class="mask">
						<a href="'.get_permalink().'#comments" class="anchor"><span> </span> <i class="fa fa-comment"></i></a>
						<a href="'.get_permalink().'" class="anchor"> <i class="fa fa-link"></i></a>
					</div>';
					$no_image_class = 'image-exists';
				}			
			?>
				<figure class="blog_item <?php echo $no_image_class;?>">
					<?php if(get_the_post_thumbnail($post->ID, array(1170,350)) <> ''){?>
						<div class="gallery_img gallery_img-first">
							<?php echo get_the_post_thumbnail($post_id, array(1170,350));
							 echo $mask_html; ?>
						</div>  
					<?php }?>
					<div class="outer_lyr span12 first">
						<div class="row-fluid inner_lyr">
							<div class="span3 post_meta"> 
								<ul>
									<li class="date"> <i class="fa fa-calendar"></i>  <?php echo get_the_date(get_option("date_format"));?></li>
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
			<?php
		endforeach;
		
		/**
		 * Fires after the Twenty Fourteen featured content.
		 *
		 * @since Twenty Fourteen 1.0
		 */
		//do_action( 'twentyfourteen_featured_posts_after' );

		wp_reset_postdata();
	?>
	</div><!-- .featured-content-inner -->
</div><!-- #featured-content .featured-content -->
