<<<<<<< HEAD
<?php
/**
 * Cart errors page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php wc_print_notices(); ?>

<p><?php _e( 'There are some issues with the items in your cart (shown above). Please go back to the cart page and resolve these issues before checking out.', 'woocommerce' ) ?></p>

<?php do_action( 'woocommerce_cart_has_errors' ); ?>

=======
<?php
/**
 * Cart errors page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php wc_print_notices(); ?>

<p><?php _e( 'There are some issues with the items in your cart (shown above). Please go back to the cart page and resolve these issues before checking out.', 'woocommerce' ) ?></p>

<?php do_action( 'woocommerce_cart_has_errors' ); ?>

>>>>>>> ed227fcd7fba396c647fab5258e5b0791b0bc4fe
<p><a class="button wc-backward" href="<?php echo get_permalink(wc_get_page_id( 'cart' ) ); ?>"><?php _e( 'Return To Cart', 'woocommerce' ) ?></a></p>