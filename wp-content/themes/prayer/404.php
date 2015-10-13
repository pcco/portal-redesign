<?php
	/*
	 * This file will generate 404 error page.
	 */	
get_header(); 


//Get Theme Options for Page Layout
$select_layout_cp = '';
$cp_general_settings = get_option('general_settings');
if($cp_general_settings <> ''){
	$cp_logo = new DOMDocument ();
	$cp_logo->loadXML ( $cp_general_settings );
	$select_layout_cp = find_xml_value($cp_logo->documentElement,'select_layout_cp');
}
?>

  <div id="main"> 
  	<?php $item_margin = '';
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
				<h1><?php _e('404 Page Not Found!','crunchpress');?></h1>
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
    <!--404 Page Start-->
    <section class="error-page">
      <div class="container">
        <div class="holder">
          <h2><?php _e('404','crunchpress');?><span>!</span></h2>
          <div class="error-heading">
            <h3><?php _e('Page Not Found!','crunchpress');?></h3>
          </div>
          <strong class="title"><?php _e('It seems we can not find what you are looking for.','crunchpress');?></strong>
			<form class="search error-form" method="get" id="searchform-four-o-four" action="<?php  echo home_url(); ?>/">
				<input  name="s" value="<?php the_search_query(); ?>" placeholder="Search Here" autocomplete="off" type="text" class="text error-field">
				<button class="error-search-btn" type="submit"><i class="fa fa-search"></i></button>
			</form>		
        </div>
      </div>
    </section>
    <!--404 Page End--> 
  </div>
  <!-- Main End--> 


<?php get_footer();?>
