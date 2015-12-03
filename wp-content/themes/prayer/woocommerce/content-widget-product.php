<<<<<<< HEAD
<?php global $product; ?>
<li>
	<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_image(); ?>
		<?php echo $product->get_title(); ?>
	</a>
	<?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
	<?php echo $product->get_price_html(); ?>
=======
<?php global $product; ?>
<li>
	<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_image(); ?>
		<?php echo $product->get_title(); ?>
	</a>
	<?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
	<?php echo $product->get_price_html(); ?>
>>>>>>> ed227fcd7fba396c647fab5258e5b0791b0bc4fe
</li>