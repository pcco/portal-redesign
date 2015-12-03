<<<<<<< HEAD
<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<span class="price"><?php echo $price_html; ?></span>
=======
<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<span class="price"><?php echo $price_html; ?></span>
>>>>>>> ed227fcd7fba396c647fab5258e5b0791b0bc4fe
<?php endif; ?>