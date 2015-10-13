<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php bloginfo('name'); ?><?php wp_title( ' - ', true, 'left' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php $layout_class = ''; $select_layout_cp = ''; $select_layout_cp = get_themeoption_value('select_layout_cp','general_settings'); if($select_layout_cp == 'boxed_layout'){$layout_class = 'boxed_v_cp';} ?>
<body id="home" <?php body_class($layout_class); ?>>
<div class="wrapper" id="page">
	<!--Header Start-->
	<header id="header"> 
		 <!--LOGIN BOX START-->
		<div id="signin" class="modal hide fade" tabindex="-1" role="dialog"  aria-hidden="true">
			<?php if (is_user_logged_in()) { ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h3><?php _e('You are logged in','crunchpress');?></h3>
				</div>
				<div class="modal-body">
					<p><?php _e('For logout click on following logout link.','crunchpress');?></p>
				</div>
				<div class="modal-footer">
					//<a class="btn-style login_button" href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout','crunchpress');?></a>
				</div>
			<?php } else { ?>
			<form id="login" action="login" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h3><?php _e('SIGN IN','crunchpress');?></h3>
				</div>
				<div class="modal-body">
					<label for="username"><?php _e('User Name','crunchpress');?></label>
					<input name="username" id="username" type="text" class="input-block-level">
					
					<label for="password"><?php _e('Password','crunchpress');?></label>
					<input name="password" id="password" type="password" class="input-block-level">
					
					//<a class="lost" href="<?php echo wp_lostpassword_url(); ?>"><?php _e('Lost your password?','crunchpress');?></a>
				</div>
				<div class="modal-footer">
					<p class="status"></p>
					<input class="btn-style" type="submit" value="<?php _e('Sign In','crunchpress');?>" name="submit">
				</div>
				<?php wp_nonce_field( 'ajax-login-nonce', 'security-login' ); ?>
			</form> 
			<?php }?>
		</div>
		<!--LOGIN BOX END-->
		<!--SIGN UP BOX START-->
		<div id="signup" class="modal hide fade" tabindex="-1" role="dialog"  aria-hidden="true">
			<?php
			$users_can_register = get_option('users_can_register');
			if($users_can_register <> 1){ ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h3><?php _e('Sign up not allowed by admin.','crunchpress');?></h3>
				</div>
				<div class="modal-body">
					<p><?php _e('Please content admin for registration.','crunchpress');?></p>
				</div>
				<div class="modal-footer">
					
				</div>
			<?php }else{ ?>
			<form id="sing-up" action="signup" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h3><?php _e('SIGN UP','crunchpress');?></h3>
				</div>
				<div class="modal-body">
					<label><?php _e('First Name','crunchpress');?></label>
					<input name="first_name" id="first_name" type="text" class="input-block-level">
					
					<label><?php _e('Last Name','crunchpress');?></label>
					<input name="last_name" id="last_name" type="text" class="input-block-level">
					
					<label><?php _e('Email Address','crunchpress');?></label>
					<input name="user_email" id="user_email" type="text" class="input-block-level">
					
					<label><?php _e('Username','crunchpress');?></label>
					<input name="nickname" id="nickname" type="text" class="input-block-level">
					
					<label><?php _e('Password','crunchpress');?></label>
					<input name="user_pass" id="user_pass" type="password" class="input-block-level">	
					
					<?php wp_nonce_field( 'ajax-signup-nonce', 'security' ); ?>
				</div>
				<div class="modal-footer">
					<p class="status"></p>
					<input class="btn-style" type="submit" value="<?php _e('Sign Up','crunchpress');?>" name="submit">
				</div>
			</form>	
			<?php }?>
		</div>
		<!--SIGN UP BOX END-->
	  <?php	$topbutton_icon =  get_themeoption_value('topbutton_icon','general_settings');
	  if($topbutton_icon == 'enable'){ ?>
		<!--Head Topbar Start-->
		<div class="head-topbar">
		  <div class="container holder">
			<div class="left"> <?php echo get_themeoption_value('contact_us_code','general_settings');?></div>
			<div class="right">
			 <?php 
				$topsocial_icon = get_themeoption_value('topsocial_icon','general_settings');
				if($topsocial_icon == 'enable'){ 
					$facebook_network = get_themeoption_value('facebook_network','social_settings');
					//$twitter_network = get_themeoption_value('twitter_network','social_settings');
					//$delicious_network = get_themeoption_value('delicious_network','social_settings');
					//$google_plus_network = get_themeoption_value('google_plus_network','social_settings');
					//$linked_in_network = get_themeoption_value('linked_in_network','social_settings');
					//$youtube_network = get_themeoption_value('youtube_network','social_settings');
					//$flickr_network = get_themeoption_value('flickr_network','social_settings');
					//$vimeo_network = get_themeoption_value('vimeo_network','social_settings');
					//$pinterest_network = get_themeoption_value('pinterest_network','social_settings'); 
					//$Instagram_network = get_themeoption_value('Instagram_network','social_settings'); 
					//$github_network = get_themeoption_value('github_network','social_settings'); 
					//$skype_network = get_themeoption_value('skype_network','social_settings'); ?>
					<ul class="topbar-social">
						<?php if($facebook_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Facebook" href="<?php echo $facebook_network;?>"><i class="fa fa-facebook"></i></a></li><?php }?>
						<?php if($twitter_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Twitter" href="<?php echo $twitter_network;?>"><i class="fa fa-twitter"></i></a></li><?php }?>
						<?php if($delicious_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Delicious" href="<?php echo $delicious_network;?>"><i class="fa fa-delicious"></i></a></li><?php }?>
						<?php if($google_plus_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Google Plus" href="<?php echo $google_plus_network;?>"><i class="fa fa-google-plus"></i></a></li><?php }?>
						<?php if($linked_in_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Linked In" href="<?php echo $linked_in_network;?>"><i class="fa fa-linkedin"></i></a></li><?php }?>
						<?php if($youtube_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Youtube" href="<?php echo $youtube_network;?>"><i class="fa fa-youtube"></i></a></li><?php }?>
						<?php if($flickr_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Flickr" href="<?php echo $flickr_network;?>"><i class="fa fa-flickr"></i></a></li><?php }?>
						<?php if($vimeo_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Vimeo" href="<?php echo $vimeo_network;?>"><i class="fa fa-vimeo-square"></i></a></li><?php }?>
						<?php if($pinterest_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Pinterest" href="<?php echo $pinterest_network;?>"><i class="fa fa-pinterest"></i></a></li><?php }?>
						<?php if($Instagram_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Instagram" href="<?php echo $Instagram_network;?>"><i class="fa fa-instagram"></i></a></li><?php }?>
						<?php if($github_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Github" href="<?php echo $github_network;?>"><i class="fa fa-github"></i></a></li><?php }?>
						<?php if($skype_network <> ''){ ?><li><a data-placement="bottom" data-toggle='tooltip' title="Skype" href="<?php echo $skype_network;?>"><i class="fa fa-skype"></i></a></li><?php }?>
					</ul>	
				<?php }?>
					<ul class="top-small-icon pull-right">
						<li><a data-placement="bottom" data-toggle='tooltip' title="Search" id="active-btn-multi" href="#" class="btn-search"><i class="fa fa-search"></i></a></li>
						<?php if (is_user_logged_in()) { ?>
							<li><a data-placement="bottom" data-rel='tooltip' title="Sign-Out" href="<?php echo wp_logout_url( home_url() ); ?>" class="btn-login"><i class="fa fa-user"></i></a></li>
						<?php }else{ ?>
							<li><a data-placement="bottom" data-rel='tooltip' title="Sign-Up" href="#signup" data-toggle="modal" class="btn-login"><i class="fa fa-user"></i></a></li>
							<li><a data-placement="bottom" data-rel='tooltip' title="Sign-In" href="#signin" data-toggle="modal" class="btn-login"><i class="fa fa-sign-in"></i></a></li>
						<?php } ?>
						<?php 
						//WooCommerce
						if(class_exists("Woocommerce")){
							$topcart_icon = get_themeoption_value('topcart_icon','general_settings');
							if($topcart_icon == 'enable'){
							global $post,$post_id,$product,$woocommerce;	
							$currency = get_woocommerce_currency_symbol();?>
							<li class="cart-item"><a data-placement="bottom" data-toggle='tooltip' title="Shopping" class="btn-login"><i class="fa fa-shopping-cart"></i></a>
							<?php if($woocommerce->cart->cart_contents_count <> 0){ ?>
									<div class="widget_shopping_cart_content"></div>
								<?php }else{ ?>
									<div class="widget_shopping_cart_content"></div>
								<?php }?>
							</li>
							<?php } ?>
						<?php }else{ ?>
						<li>&nbsp;</li>
						<?php } ?>
					</ul>
				</div>
				<form method="get" action="<?php  echo home_url(); ?>/" id="search-box-form" class="search-box">
				  <input name="s" type="text" class="topbar-search-input" placeholder="Search for..." value="<?php the_search_query(); ?>">
				  <button value="" class="topbar-btn-search"><i class="fa fa-search"></i></button>
				  <a href="#" class="crose"><i class="fa fa-times"></i></a>
				</form>
		  </div>
		</div>
		<!--Head Topbar End--> 
		<?php }?>
		
		<!--Logo Row Star-->
		<!-- <div class="logo-row">
			<div class="container">
				<strong class="logo">
				<?php 
					$header_logo = get_themeoption_value('header_logo','general_settings');
					$logo_width = get_themeoption_value('logo_width','general_settings');
					$logo_height = get_themeoption_value('logo_height','general_settings');
					//Print Logo
					$image_src = '';
					if(!empty($header_logo)){ 
						$image_src = wp_get_attachment_image_src( $header_logo, 'full' );
						$image_src = (empty($image_src))? '': $image_src[0];			
					}?>
					<a href="<?php echo home_url(); ?>">
						<img class="logo_img" width="<?php if($logo_width == '' or $logo_width == ' '){ echo '200'; }else{echo $logo_width;}?>" height="<?php if($logo_height == '' or $logo_height == ' '){ echo '200'; }else{echo $logo_height;}?>" src="<?php if($image_src <> ''){echo $image_src;}else{echo CP_PATH_URL.'/images/logo.png';}?>" alt="<?php echo bloginfo( 'name' )?>">
					</a>
				</strong>
				<?php 
				$topcounter_circle = get_themeoption_value('topcounter_circle','general_settings');
				$countd_event_category = get_themeoption_value('countd_event_category','general_settings');
				$color_scheme = get_themeoption_value('color_scheme','general_settings');
				if(class_exists('CP_Shortcodes')){
					if($topcounter_circle == 'enable'){
						echo '<div class="top-time-counter">';
							echo '<h5>'.__('Next Event in:','crunchpress').'</h5>';
							echo do_shortcode('[event_counter event_id="'.$countd_event_category.'" color="#ffffff" unfilled_color="#812000" filled_color="#ffffff" width="500" height="120"][/event_counter]');
						echo '</div>';
					}
				}?> 
			</div>
		</div> -->
		<!--Logo Row End--> 
		
	   <!--Navbar Start-->
		<div class="nav-bar-bg">
			<div class="container">
				<div class="navbar margin-none">
					<button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="nav-collapse collapse">
					<strong class="logo">
				<?php 
					$header_logo = get_themeoption_value('header_logo','general_settings');
					$logo_width = get_themeoption_value('logo_width','general_settings');
					$logo_height = get_themeoption_value('logo_height','general_settings');
					//Print Logo
					$image_src = '';
					if(!empty($header_logo)){ 
						$image_src = wp_get_attachment_image_src( $header_logo, 'full' );
						$image_src = (empty($image_src))? '': $image_src[0];			
					}?>
					<a href="<?php echo home_url(); ?>">
						<img class="logo_img" width="<?php if($logo_width == '' or $logo_width == ' '){ echo '200'; }else{echo $logo_width;}?>" height="<?php if($logo_height == '' or $logo_height == ' '){ echo '200'; }else{echo $logo_height;}?>" src="<?php if($image_src <> ''){echo $image_src;}else{echo CP_PATH_URL.'/images/logo.png';}?>" alt="<?php echo bloginfo( 'name' )?>">
					</a>
				</strong>
						<?php 
						// Menu parameters		
						$defaults = array(
						'theme_location'  => 'top-menu',
						'menu'            => '', 
						'container'       => '', 
						'container_class' => 'menu-{menu slug}-container', 
						'container_id'    => 'navbar',
						'menu_class'      => '', 
						'menu_id'         => 'nav',
						'echo'            => true,
						'fallback_cb'     => '',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => '',);				
						if(has_nav_menu('top-menu')){ ?>
							<div id="navbar" class="navbar">
								<?php wp_nav_menu( $defaults);?>
							</div>
						<?php }else{
							$args = array(
							'sort_column' => 'menu_order, post_title',
							'menu_class'  => 'nav',
							'include'     => '',
							'exclude'     => '',
							'echo'        => true,
							'show_home'   => false,
							'menu'            => '', 
							'container'       => '', 
							'link_before' => '',
							'link_after'  => '' );?>
							<div id="nav">
								<?php wp_page_menu( $args ); ?>                
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>	
		<!--Navbar End--> 
	</header>
	<!--Header End--> 
  