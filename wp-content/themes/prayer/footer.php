<<<<<<< HEAD
<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package CrunchPress
 * @subpackage Rockon
 */
?>


<!-- Footer Area Start-->
  <footer id="footer">
    <div class="footer-section">
      <div class="container">
        <div class="row">
         <?php dynamic_sidebar('sidebar-footer'); ?>
        </div>
      </div>
    </div>
    <!--Footer Social Row Start-->
    <div class="footer-social">
      <div class="container">
        <?php		
			$social_networking = get_themeoption_value('social_networking','general_settings');
			if($social_networking == 'enable'){ 
				$facebook_network = get_themeoption_value('facebook_network','social_settings');
				$twitter_network = get_themeoption_value('twitter_network','social_settings');
				$delicious_network = get_themeoption_value('delicious_network','social_settings');
				$google_plus_network = get_themeoption_value('google_plus_network','social_settings');
				$linked_in_network = get_themeoption_value('linked_in_network','social_settings');
				$youtube_network = get_themeoption_value('youtube_network','social_settings');
				$flickr_network = get_themeoption_value('flickr_network','social_settings');
				$vimeo_network = get_themeoption_value('vimeo_network','social_settings');
				$pinterest_network = get_themeoption_value('pinterest_network','social_settings'); 
				$Instagram_network = get_themeoption_value('Instagram_network','social_settings'); 
				$github_network = get_themeoption_value('github_network','social_settings'); 
				$skype_network = get_themeoption_value('skype_network','social_settings'); ?>
				<ul class="header-social">
					<?php if($facebook_network <> ''){ ?><li><a class="social-color-1" href="<?php echo $facebook_network;?>"><i class="fa fa-facebook"></i></a></li><?php }?>
					<?php if($twitter_network <> ''){ ?><li><a class="social-color-2" href="<?php echo $twitter_network;?>"><i class="fa fa-twitter"></i></a></li><?php }?>
					<?php if($delicious_network <> ''){ ?><li><a class="social-color-3" href="<?php echo $delicious_network;?>"><i class="fa fa-delicious"></i></a></li><?php }?>
					<?php if($google_plus_network <> ''){ ?><li><a class="social-color-4" href="<?php echo $google_plus_network;?>"><i class="fa fa-google-plus"></i></a></li><?php }?>
					<?php if($linked_in_network <> ''){ ?><li><a class="social-color-5" href="<?php echo $linked_in_network;?>"><i class="fa fa-linkedin"></i></a></li><?php }?>
					<?php if($youtube_network <> ''){ ?><li><a class="social-color-6" href="<?php echo $youtube_network;?>"><i class="fa fa-youtube"></i></a></li><?php }?>
					<?php if($flickr_network <> ''){ ?><li><a class="social-color-1" href="<?php echo $flickr_network;?>"><i class="fa fa-flickr"></i></a></li><?php }?>
					<?php if($vimeo_network <> ''){ ?><li><a class="social-color-3" href="<?php echo $vimeo_network;?>"><i class="fa fa-vimeo-square"></i></a></li><?php }?>
					<?php if($pinterest_network <> ''){ ?><li><a class="social-color-4" href="<?php echo $pinterest_network;?>"><i class="fa fa-pinterest"></i></a></li><?php }?>
					<?php if($Instagram_network <> ''){ ?><li><a class="social-color-1" href="<?php echo $Instagram_network;?>"><i class="fa fa-instagram"></i></a></li><?php }?>
					<?php if($github_network <> ''){ ?><li><a class="social-color-6" href="<?php echo $github_network;?>"><i class="fa fa-github"></i></a></li><?php }?>
					<?php if($skype_network <> ''){ ?><li><a class="social-color-7" href="<?php echo $skype_network;?>"><i class="fa fa-skype"></i></a></li><?php }?>
				</ul>	
			<?php }?>
      </div>
    </div>
    <!--Footer Social Row End--> 
    <!-- Copyrights Section Start-->
    <div class="copyrights-section">
      <div class="container">
		<?php echo get_themeoption_value('copyright_code','general_settings');?>
	   </div>
    </div>
    <!-- Copyrights Section End--> 
  </footer>
  <!-- Footer Area End--> 
  <div class="clear"></div>
</div>
<!--Wrapper End--> 
<?php wp_footer();?>
</body>
=======
<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package CrunchPress
 * @subpackage Rockon
 */
?>


<!-- Footer Area Start-->
  <footer id="footer">
    <div class="footer-section">
      <div class="container">
        <div class="row">
         <?php dynamic_sidebar('sidebar-footer'); ?>
        </div>
      </div>
    </div>
    <!--Footer Social Row Start-->
    <div class="footer-social">
      <div class="container">
        <?php		
			$social_networking = get_themeoption_value('social_networking','general_settings');
			if($social_networking == 'enable'){ 
				$facebook_network = get_themeoption_value('facebook_network','social_settings');
				$twitter_network = get_themeoption_value('twitter_network','social_settings');
				$delicious_network = get_themeoption_value('delicious_network','social_settings');
				$google_plus_network = get_themeoption_value('google_plus_network','social_settings');
				$linked_in_network = get_themeoption_value('linked_in_network','social_settings');
				$youtube_network = get_themeoption_value('youtube_network','social_settings');
				$flickr_network = get_themeoption_value('flickr_network','social_settings');
				$vimeo_network = get_themeoption_value('vimeo_network','social_settings');
				$pinterest_network = get_themeoption_value('pinterest_network','social_settings'); 
				$Instagram_network = get_themeoption_value('Instagram_network','social_settings'); 
				$github_network = get_themeoption_value('github_network','social_settings'); 
				$skype_network = get_themeoption_value('skype_network','social_settings'); ?>
				<ul class="header-social">
					<?php if($facebook_network <> ''){ ?><li><a class="social-color-1" href="<?php echo $facebook_network;?>"><i class="fa fa-facebook"></i></a></li><?php }?>
					<?php if($twitter_network <> ''){ ?><li><a class="social-color-2" href="<?php echo $twitter_network;?>"><i class="fa fa-twitter"></i></a></li><?php }?>
					<?php if($delicious_network <> ''){ ?><li><a class="social-color-3" href="<?php echo $delicious_network;?>"><i class="fa fa-delicious"></i></a></li><?php }?>
					<?php if($google_plus_network <> ''){ ?><li><a class="social-color-4" href="<?php echo $google_plus_network;?>"><i class="fa fa-google-plus"></i></a></li><?php }?>
					<?php if($linked_in_network <> ''){ ?><li><a class="social-color-5" href="<?php echo $linked_in_network;?>"><i class="fa fa-linkedin"></i></a></li><?php }?>
					<?php if($youtube_network <> ''){ ?><li><a class="social-color-6" href="<?php echo $youtube_network;?>"><i class="fa fa-youtube"></i></a></li><?php }?>
					<?php if($flickr_network <> ''){ ?><li><a class="social-color-1" href="<?php echo $flickr_network;?>"><i class="fa fa-flickr"></i></a></li><?php }?>
					<?php if($vimeo_network <> ''){ ?><li><a class="social-color-3" href="<?php echo $vimeo_network;?>"><i class="fa fa-vimeo-square"></i></a></li><?php }?>
					<?php if($pinterest_network <> ''){ ?><li><a class="social-color-4" href="<?php echo $pinterest_network;?>"><i class="fa fa-pinterest"></i></a></li><?php }?>
					<?php if($Instagram_network <> ''){ ?><li><a class="social-color-1" href="<?php echo $Instagram_network;?>"><i class="fa fa-instagram"></i></a></li><?php }?>
					<?php if($github_network <> ''){ ?><li><a class="social-color-6" href="<?php echo $github_network;?>"><i class="fa fa-github"></i></a></li><?php }?>
					<?php if($skype_network <> ''){ ?><li><a class="social-color-7" href="<?php echo $skype_network;?>"><i class="fa fa-skype"></i></a></li><?php }?>
				</ul>	
			<?php }?>
      </div>
    </div>
    <!--Footer Social Row End--> 
    <!-- Copyrights Section Start-->
    <div class="copyrights-section">
      <div class="container">
		<?php echo get_themeoption_value('copyright_code','general_settings');?>
	   </div>
    </div>
    <!-- Copyrights Section End--> 
  </footer>
  <!-- Footer Area End--> 
  <div class="clear"></div>
</div>
<!--Wrapper End--> 
<?php wp_footer();?>
</body>
>>>>>>> ed227fcd7fba396c647fab5258e5b0791b0bc4fe
</html>