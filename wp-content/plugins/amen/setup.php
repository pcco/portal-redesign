<?php

/**************************************
* CREATE OR UPDATE DATABASE AND OPTIONS
**************************************/

function amen_install () {
	global $wpdb;
	global $amen_options;
	$amen_version = get_option( 'amen_version', '' );

	if( $amen_version != AMEN_VERSION || '' == $amen_version ) {
		// set tables in database
		$request_table = $wpdb->prefix . "amen_requests";
		$prayers_table = $wpdb->prefix . "amen_prayers";
		$sql = "
			CREATE TABLE $request_table (
				id mediumint(11) NOT NULL AUTO_INCREMENT,
				prayer_item longtext NOT NULL,
				prayer_updated longtext NOT NULL,
				urgency TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
				active TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
				privacy TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
				approved TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
				notify TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
				created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				created_by varchar(255) NOT NULL,
				twitter_handle varchar(255) NOT NULL,
				email varchar(255) NOT NULL,
				praying_tag varchar(255) NOT NULL,
				updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				fav_list longtext DEFAULT NULL,
				PRIMARY KEY id (id)
			) CHARACTER SET utf8 COLLATE utf8_general_ci;
			CREATE TABLE $prayers_table (
				id mediumint(11) NOT NULL AUTO_INCREMENT,  
				session_id varchar(255) NOT NULL,
				request_id mediumint(11) NOT NULL,
				prayer_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				PRIMARY KEY id (id)
			) CHARACTER SET utf8 COLLATE utf8_general_ci;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);

		$wpdb->query("ALTER TABLE {$wpdb->prefix}amen_requests CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE {$wpdb->prefix}amen_prayers CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci");

		// set options
		update_option( 'amen_version', AMEN_VERSION );

		if ( FALSE == get_option( 'amen_settings' ) ) {
			$amen_settings = array(
				// privacy & moderation
				'allow_public_requests' => FALSE,
				'disable_public_management' => FALSE,
				'privatize_prayers' => TRUE,
				'super_privatize_prayers' => 'disabled',
				'moderate_public_requests' => TRUE,
				'moderate_all_requests' => FALSE,
				'email_approval_notification_to' => '',
				'disable_approval_notification' => FALSE,
				// submission & management form
				'submission_title' => 'Submit New Prayer Request',
				'submission_note' => 'Please note: Public requests require approval.',
				'submission_button_text' => 'Submit Request',
				'management_title' => 'Manage Prayer Requests',
				'author_display' => 'displayname',
				'public_user' => 'Public User',
				'show_date' => FALSE,
				// counter
				'enable_submit_count' => TRUE,
				'submit_text' => 'Pray Now.',
				'submitted_state_one' => '{count} praying.',
				'submitted_state_two' => 'Amen. You are praying.',
				'submitted_state_three' => 'Amen. You and {count-1} other{s} are praying.',
				// twitter
				'tweet_public_requests' => TRUE,
				'tweet_via' => '',
				'custom_hashtag' => 'Amen',
				'tweet_type' => 'hashtag',
				'hashtag_in_button' => TRUE,
				'prepend_name_to_tweet' => FALSE,
				'custom_id_name' => 'AmenID',
				// email digest
				'enable_digest' => FALSE,
				//'digest_interval' => 'weekly',
				'notif_from_name' => get_option( 'blogname' ),
				'notif_from_email' => get_option( 'admin_email' ),
				'notif_subject' => 'Amen: Weekly Prayer Digest',
				'notif_message' => '<strong>Hello, {{DISPLAY-NAME}}! We are together in prayer.</strong>

{{LOOP}}
<strong>To the only God, our Savior, through Jesus Christ our Lord, be glory, majesty, dominion, and authority, before all time and now and forever. Amen. - Jude 25</strong>

<div style="font-size:50%;">You are receiving this message because you requested notifications after having submitted a prayer request at <a href="{{SITE-URL}}">{{SITE-NAME}}</a>. Visit the site to manage your requests.</div>',
				'notif_request_loop' => '<div style="width:700px;border-bottom:2px solid #222D23;"></div>
<div style="width:700px;overflow-x:auto;overflow-y:hidden;">
	<div style="width:700px;">
		<div style="float:left;background:#B6C0B8;padding:5px 10px;text-align:center;width:50px;margin-bottom:7px;">NEW<br />
			<span style="font-size: 150%;">{{NEW}}</span>
		</div>
		<div style="float:left;background:#B6C0B8;padding:5px 10px;text-align:center;width:50px;">TOTAL<br />
			<span style="font-size:150%;">{{TOTAL}}</span>
		</div>
		<div style="padding:5px 10px;float:left;width:540px;">{{POST}}

		Update: {{UPDATE}}
		</div>
	</div>
</div>',
				'management_url' => '',
				'keep_db_tables' => FALSE,
				'keep_db_options' => FALSE,
				'custom_db_prefix' => '',
				'allowed_users' => '',
				'allowed_pages' => array(),
			);
			update_option( 'amen_settings', $amen_settings );
		} else {
			amen_updater();
		}
	}
}
register_activation_hook( __FILE__, 'amen_install' );

/**************************************
* CHECKS FOR INSTALL OF UPDATE
**************************************/

function amen_update_check() {
	$amen_version = get_option( 'amen_version', '' );

	if( $amen_version != AMEN_VERSION ) {
		amen_install();
	}
}
add_action( 'plugins_loaded', 'amen_update_check' );

/**************************************
* CHECKS FOR INSTALL OF UPDATE
**************************************/

function amen_updater() {
	global $amen_options, $wpdb;

	// write new settings for 3.0.1

	! isset( $amen_options['custom_id_name'] ) ? $amen_options['custom_id_name'] = 'AmenID' : FALSE;
	! isset( $amen_options['notif_from_name'] ) ? $amen_options['notif_from_name'] = get_option( 'blogname' ) : FALSE;
	! isset( $amen_options['notif_from_email'] ) ? $amen_options['notif_from_email'] = get_option( 'admin_email' ) : FALSE;
	! isset( $amen_options['notif_subject'] ) ? $amen_options['notif_subject'] = 'Amen: Praying With You' : FALSE;
	! isset( $amen_options['notif_message'] ) ? $amen_options['notif_message'] = '<strong>Hello, {{DISPLAY-NAME}}! We are together in prayer.</strong>

{{LOOP}}
<strong>To the only God, our Savior, through Jesus Christ our Lord, be glory, majesty, dominion, and authority, before all time and now and forever. Amen. - Jude 25</strong>

<div style="font-size:50%;">You are receiving this message because you requested notifications after having submitted a prayer request at <a href="{{SITE-URL}}">{{SITE-NAME}}</a>. Visit the site to manage your requests.</div>' : FALSE;
	! isset( $amen_options['notif_request_loop'] ) ? $amen_options['notif_request_loop'] = '<div style="width:700px;border-bottom:2px solid #222D23;margin-bottom:7px;"></div>
<div style="width:700px;overflow-x:auto;overflow-y:hidden;">
	<div style="width:700px;">
		<div style="float:left;background:#B6C0B8;padding:5px 10px;text-align:center;width:50px;">NEW<br />
			<span style="font-size: 150%;">{{NEW}}</span>
		</div>
		<div style="float:left;background:#B6C0B8;padding:5px 10px;text-align:center;width:50px;">TOTAL<br />
			<span style="font-size:150%;">{{TOTAL}}</span>
		</div>
		<div style="padding:5px 10px;float:left;width:540px;">{{POST}}

		Update: {{UPDATE}}
		</div>
	</div>
</div>' : FALSE;
	! isset( $amen_options['management_url'] ) ? $amen_options['management_url'] = 'none' : FALSE;
	! isset( $amen_options['super_privatize_prayers'] ) ? $amen_options['super_privatize_prayers'] = 'disabled' : FALSE;
	! isset( $amen_options['show_date'] ) ? $amen_options['show_date'] = FALSE : FALSE;
	! isset( $amen_options['disable_public_management'] ) ? $amen_options['disable_public_management'] = FALSE : FALSE;
	update_option( 'amen_settings', $amen_options );
} ?>