<?php
/*
Plugin Name: Amen
Plugin URI: http://wmpl.org/blogs/vandercar/wp/
Description: Prayer request management with counter. Alternatively, can be used as custom tweet platform.
Version: 3.3.1
Author: Joshua Vandercar
Author URI: http://wmpl.org/blogs/vandercar
*/
?>
<?php
/*  === Amen ===
    Copyright 2012 World Mission Prayer League (wmpl.org)
    Revision of Pray With Us by Brendan Ribera

    Permission is hereby granted, free of charge, to any person obtaining
    a copy of this software and associated documentation files (the
    "Software"), to deal in the Software without restriction, including
    without limitation the rights to use, copy, modify, merge, publish,
    distribute, sublicense, and/or sell copies of the Software, and to
    permit persons to whom the Software is furnished to do so, subject to
    the following conditions:

    The above copyright notice and this permission notice shall be
    included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
    LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
    OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
    WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

/**************************************
* INITIALIZE SETTINGS AND INCLUDES
**************************************/

define( 'AMEN_VERSION', '3.3.1' );
define( 'AMEN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'AMEN_DIR', plugin_dir_path( __FILE__ ) );

global $wpdb;

global $amen_plugin_name;
$amen_plugin_name = 'Amen';
global $amen_prefix;
$amen_prefix = 'amen_';

global $amen_options;
$amen_options = get_option( 'amen_settings' );

isset( $amen_options['custom_db_prefix'] ) ? FALSE : $amen_options['custom_db_prefix'] = FALSE;
global $amen_db_prefix;
    $amen_db_prefix = ( '' == $amen_options['custom_db_prefix'] || ! $amen_options['custom_db_prefix'] ) ? $wpdb->prefix : $amen_options['custom_db_prefix'];

global $amen_session;
$amen_session = NULL;
global $amen_user;
$amen_user = NULL;

is_admin() ? require_once dirname( __FILE__ ) . '/setup.php' : FALSE;
is_admin() ? require_once dirname( __FILE__ ) . '/admin.php' : FALSE;
is_admin() ? require_once dirname( __FILE__ ) . '/class-form.php' : FALSE;
include_once dirname( __FILE__ ) . '/personal-list.php';
include_once dirname( __FILE__ ) . '/amen-submit-prayer.php';
include_once dirname( __FILE__ ) . '/amen-list-requests.php';
require_once dirname( __FILE__ ) . '/db.php';
include_once dirname( __FILE__ ) . '/crons.php';

// require_once ABSPATH . WPINC . '/post-template.php';
// require_once ABSPATH . WPINC . '/pluggable.php';

add_action( 'wp_head', 'cssjs' );

function cssjs() {
    wp_register_script( 'amen.js', AMEN_PLUGIN_URL . 'amen.js', array('jquery'), AMEN_VERSION );
    wp_enqueue_script( 'amen.js' );
    wp_localize_script( 'amen.js', 'Amen', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

// check if options set
isset( $amen_options['allow_public_requests'] ) ? FALSE : $amen_options['allow_public_requests'] = FALSE;
isset( $amen_options['privatize_prayers'] ) ? FALSE : $amen_options['privatize_prayers'] = FALSE;
isset( $amen_options['moderate_public_requests'] ) ? FALSE : $amen_options['moderate_public_requests'] = FALSE;
isset( $amen_options['moderate_all_requests'] ) ? FALSE : $amen_options['moderate_all_requests'] = FALSE;
isset( $amen_options['email_approval_notification_to'] ) ? FALSE : $amen_options['email_approval_notification_to'] = FALSE;
isset( $amen_options['disable_approval_notification'] ) ? FALSE : $amen_options['disable_approval_notification'] = FALSE;
isset( $amen_options['submission_title'] ) ? FALSE : $amen_options['submission_title'] = FALSE;
isset( $amen_options['submission_note'] ) ? FALSE : $amen_options['submission_note'] = FALSE;
isset( $amen_options['submission_button_text'] ) ? FALSE : $amen_options['submission_button_text'] = FALSE;
isset( $amen_options['enable_submit_count'] ) ? FALSE : $amen_options['enable_submit_count'] = FALSE;
isset( $amen_options['tweet_public_requests'] ) ? FALSE : $amen_options['tweet_public_requests'] = FALSE;
isset( $amen_options['tweet_via'] ) ? FALSE : $amen_options['tweet_via'] = FALSE;
isset( $amen_options['custom_hashtag'] ) ? FALSE : $amen_options['custom_hashtag'] = FALSE;
isset( $amen_options['hashtag_in_button'] ) ? FALSE : $amen_options['hashtag_in_button'] = FALSE;
isset( $amen_options['prepend_name_to_tweet'] ) ? FALSE : $amen_options['prepend_name_to_tweet'] = FALSE;
isset( $amen_options['custom_id_name'] ) ? FALSE : $amen_options['custom_id_name'] = FALSE;
isset( $amen_options['enable_digest'] ) ? FALSE : $amen_options['enable_digest'] = FALSE;
isset( $amen_options['notif_from_name'] ) ? FALSE : $amen_options['notif_from_name'] = FALSE;
isset( $amen_options['notif_from_email'] ) ? FALSE : $amen_options['notif_from_email'] = FALSE;
isset( $amen_options['notif_subject'] ) ? FALSE : $amen_options['notif_subject'] = FALSE;
isset( $amen_options['notif_message'] ) ? FALSE : $amen_options['notif_message'] = FALSE;
isset( $amen_options['management_url'] ) ? FALSE : $amen_options['management_url'] = FALSE;
isset( $amen_options['keep_db_tables'] ) ? FALSE : $amen_options['keep_db_tables'] = FALSE;
isset( $amen_options['keep_db_options'] ) ? FALSE : $amen_options['keep_db_options'] = FALSE;
isset( $amen_options['disable_public_management'] ) ? FALSE : $amen_options['disable_public_management'] = FALSE;
isset( $amen_options['allowed_users'] ) ? FALSE : $amen_options['allowed_users'] = FALSE;
isset( $amen_options['allowed_pages'] ) ? FALSE : $amen_options['allowed_pages'] = array();

/**************************************
* FILTER SETTINGS
**************************************/

function _adump( $var = '' ) {
    echo '<br /><pre>';
    var_dump( $var ) . '<br />';
    echo '</pre>';
}

function _get_amen_user_ID() {
    global $amen_user;

    if ( is_user_logged_in() ) {
        return wp_get_current_user()->ID;
    } else {
        return $amen_user;
    }
}
?>
