<?php get_header(); ?>
<?php if ( have_posts() ){ while (have_posts()){ the_post();
	global $post;
	
	// Get Post Meta Elements detail 
	$post_social = '';
	$sidebar = '';
	$right_sidebar = '';
	$left_sidebar = '';
	$thumbnail_types = '';
	
	$post_format = get_post_meta($post->ID, 'post_format', true);
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
	
	$select_layout_cp = '';
	$cp_general_settings = get_option('general_settings');
	if($cp_general_settings <> ''){
		$cp_logo = new DOMDocument ();
		$cp_logo->loadXML ( $cp_general_settings );
		$select_layout_cp = find_xml_value($cp_logo->documentElement,'select_layout_cp');
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
				<div class="single_content row-fluid">
					<?php
					if($sidebar == "left-sidebar" || $sidebar == "both-sidebar" || $sidebar == "both-sidebar-left"){?>
						<div id="block_first" class="sidebar side-bar <?php echo $sidebar_class[0];?>">
							<?php dynamic_sidebar( $left_sidebar ); ?>
						</div>
						<?php
					}
					if($sidebar == 'both-sidebar-left'){?>
					<div id="block_first_left" class="sidebar side-bar <?php echo $sidebar_class[0];?>">
						<?php dynamic_sidebar( $right_sidebar );?>
					</div>
					<?php } ?>
					<?php $image_size = array('1170','350');?>
					<!--Blog Detail Page Page Start-->
					<div id="<?php the_ID(); ?>" class="<?php echo $sidebar_class[1];?> blog-detail blog-detail-cp  <?php echo $thumbnail_types;?>">
						<div class="post-auther-box">
							<?php if(print_blog_thumbnail($post->ID,$image_size) <> ''){ ?><div class="frame"><?php echo print_blog_thumbnail($post->ID,$image_size);?></div><?php }?>
							<h2><?php echo get_the_title();?></h2>
							<div class="post-detail">
								<ul>
									<li><a href="<?php echo get_permalink();?>"><span><?php _e('By','crunchpress');?></span>: <?php echo get_the_author();?></a></li>
									<li><a href="<?php echo get_permalink();?>"><span><?php _e('Posted on:','crunchpress');?></span> <?php echo get_the_date(get_option('date_format'));?></a></li>
									<li>
										<?php
											//Get Post Comment 
											comments_popup_link( __('0 Comment','crunchpress'),
											__('1 Comment','crunchpress'),
											__('% Comments','crunchpress'), '',
											__('Comments are off','crunchpress') );										
										?>
									</li>
									<li><?php the_tags();?></li>
								</ul>
							</div>
							<?php the_content();?>
						</div>
						<?php if($post_social == 'enable'){ ?>
						<div class="share-btn">
							<a class="share"><?php _e('Share Post','crunchpress');?></a>
							<?php include_social_shares();?>
						</div>
						<?php }?>
						<div class="auther-box">
							<h4><?php _e('About Author','crunchpress');?></h4>
							<div class="frame"><a href="<?php echo get_permalink();?>"><?php echo get_avatar(get_the_author_meta( 'ID' ));?></a></div>
							<div class="text-box">
								<strong class="title"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></strong>
								<p><?php echo mb_substr(get_the_author_meta( 'description' ),0,360);?></p>
							</div>
						</div>
						<?php comments_template(); ?>						
					</div>	
					
					<!--Blog Detail Page Page End--> 
					<?php
					if($sidebar == "both-sidebar-right"){?>
						<div class="<?php echo $sidebar_class[0];?> side-bar">
							<?php dynamic_sidebar( $left_sidebar ); ?>
						</div>
						<?php
					}
					if($sidebar == 'both-sidebar-right' || $sidebar == "right-sidebar" || $sidebar == "both-sidebar"){?>
					<div class="<?php echo $sidebar_class[0];?> side-bar">
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
<?php get_footer(); ?>