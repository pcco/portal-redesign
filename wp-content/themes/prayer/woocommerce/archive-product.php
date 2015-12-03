<<<<<<< HEAD
<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<!--<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>-->

		<?php endif; ?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<li class="row woo_product">
					<?php 
					$counter_woo = 0;
					while ( have_posts() ) : the_post(); 
							global $product, $woocommerce_loop;
							$counter_woo++;
							if($counter_woo % 4 == 1){$class_cp = 'first'; echo $div_cp = '<div class="clear"></div>';}?>
							<div class="span3">
						
								<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

								<a href="<?php the_permalink(); ?>">

									<?php
										/**
										 * woocommerce_before_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_show_product_loop_sale_flash - 10
										 * @hooked woocommerce_template_loop_product_thumbnail - 10
										 */
										do_action( 'woocommerce_before_shop_loop_item_title' );
									?>

									<h3><?php the_title(); ?></h3>

									<?php
										/**
										 * woocommerce_after_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_template_loop_rating - 5
										 * @hooked woocommerce_template_loop_price - 10
										 */
										do_action( 'woocommerce_after_shop_loop_item_title' );
									?>

								</a>

								<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

							</div>

					<?php  endwhile; // end of the loop. ?>
				</li>
			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

=======
<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<!--<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>-->

		<?php endif; ?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<li class="row woo_product">
					<?php 
					$counter_woo = 0;
					while ( have_posts() ) : the_post(); 
							global $product, $woocommerce_loop;
							$counter_woo++;
							if($counter_woo % 4 == 1){$class_cp = 'first'; echo $div_cp = '<div class="clear"></div>';}?>
							<div class="span3">
						
								<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

								<a href="<?php the_permalink(); ?>">

									<?php
										/**
										 * woocommerce_before_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_show_product_loop_sale_flash - 10
										 * @hooked woocommerce_template_loop_product_thumbnail - 10
										 */
										do_action( 'woocommerce_before_shop_loop_item_title' );
									?>

									<h3><?php the_title(); ?></h3>

									<?php
										/**
										 * woocommerce_after_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_template_loop_rating - 5
										 * @hooked woocommerce_template_loop_price - 10
										 */
										do_action( 'woocommerce_after_shop_loop_item_title' );
									?>

								</a>

								<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

							</div>

					<?php  endwhile; // end of the loop. ?>
				</li>
			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

>>>>>>> ed227fcd7fba396c647fab5258e5b0791b0bc4fe
<?php get_footer( 'shop' ); ?>