<?php
/**************************************
* ADD WEEKLY INTERVAL TO CRONS
**************************************/

function amen_add_weekly( $schedules ) {
	// Adds once weekly to the existing schedules.
	$schedules['weekly'] = array(
		'interval' => 604800,
		'display' => __( 'Weekly' )
	);
	return $schedules;
}
add_filter( 'cron_schedules', 'amen_add_weekly' );

/**************************************
* SCHEDULE CRON ON ACTIVATION
**************************************/

function amen_schedule_crons() {
	wp_schedule_event( time(), 'weekly', 'amenemailprayers' );
}
register_activation_hook( AMEN_DIR . 'amen.php', 'amen_schedule_crons' );

/**************************************
* UNSCHEDULE CRON ON DEACTIVATION
**************************************/

function amen_unschedule_crons() {
	$crons = _get_cron_array();
	foreach ( $crons as $time => $cron_data ) {
		foreach ($cron_data as $cron_event => $data) {
			'amenemailprayers' == $cron_event ? wp_unschedule_event( $time, $cron_event ) : FALSE;
		}
	}
}
register_deactivation_hook( AMEN_DIR . 'amen.php', 'amen_unschedule_crons' );

/**************************************
* EMAIL DIGEST WHEN WEEKLY CRON RUNS
**************************************/

function amen_email_prayers() {
	global $amen_options;

	// check if digest mailing is enabled
	if ( $amen_options['enable_digest'] ) {
		global $wpdb, $amen_db_prefix;
		
		// set notification period
		$notify_period = date( 'Y-m-d h:i:s', strtotime( '-1 week' ) );
		
		// get new prayers from notification period
		$weekly_prayers = $wpdb->get_results( "SELECT request_id FROM {$amen_db_prefix}amen_prayers WHERE prayer_date>'$notify_period' GROUP BY request_id" );
		
		// setup array for gathering prayers to requester
		$prayers_by_poster = array();

		// for each prayer
		foreach( $weekly_prayers as $prayer ) {
			$request_id = $prayer->request_id;

			// get request data for the prayer
			$prayer_request = $wpdb->get_row( "SELECT prayer_item,prayer_updated,urgency,active,privacy,created_by,twitter_handle,email,notify FROM {$amen_db_prefix}amen_requests WHERE id=$request_id" );
			$notify = $prayer_request->notify;

			// check if notification set for request
			if ( 1 == $notify ) {
				// get new prayers and total prayers for request 
				$new_prayers = count( $wpdb->get_results( "SELECT id FROM {$amen_db_prefix}amen_prayers WHERE prayer_date>'$notify_period' AND request_id=$request_id"));
				$all_prayers = count( $wpdb->get_results( "SELECT id FROM {$amen_db_prefix}amen_prayers WHERE request_id=$request_id"));
				
				// setup array for the request
				$email = $prayer_request->email;
				$prayers_by_poster[ $email ][ $request_id ] = array(
					'email' => $email,
					'twitter_handle' => $prayer_request->twitter_handle,
					'loop' => '',
					'id' => $request_id,
					'request' => $prayer_request->prayer_item,
					'update' => $prayer_request->prayer_updated,
					'urgency' => $prayer_request->urgency,
					'active' => $prayer_request->active,
					'privacy' => $prayer_request->privacy,
					'newprayers' => $new_prayers,
					'totalprayers' => $all_prayers,
					'url' => 'none' == $amen_options['management_url'] ? '' : get_permalink( $amen_options['management_url'] ) . '#' . $amen_options['custom_id_name'] . '-' . $request_id,
					'site_name' => get_option( 'blogname' ),
					'site_url' => get_option( 'siteurl' ),
					);
			}
		}

		// assemble email per requester
		foreach ($prayers_by_poster as $email => $request_id) {

			// set request loop
			$request_loop = '';
			// filter and assemble loop
			foreach ( $request_id as $request ) {
				$amen_filtered_options = _atif( $amen_options, $request );
				$request_loop .= $amen_filtered_options['notif_request_loop'];
			}

			// assign loop to requester
			$prayers_by_poster[ $email ][ $request[ 'id' ] ][ 'loop' ] = $request_loop;

			$clean_data = $prayers_by_poster[ $email ][ $request[ 'id' ] ];

			$email_subject = $amen_options['notif_subject'];
			$amen_filtered_options = _atif( $amen_options, $clean_data );
			$email_message = $amen_filtered_options['notif_message'];
			$amen_options['wmpl_link'] ? $email_message .= '<br /><span style="font-style:normal;font-size:50%;clear:both;">Online prayer journal provided by <a href="http://wmpl.org">World Mission Prayer League</a></span>' : FALSE;
			$from_name = '' != $amen_options['notif_from_name'] ? $amen_options['notif_from_name'] : get_option( 'blogname' );
			$from_email = '' != $amen_options['notif_from_email'] ? $amen_options['notif_from_email'] : get_option( 'admin_email' );
			$header = 'From: ' . $from_name . ' <' . $from_email . '>';

			// set email to html
			add_filter( 'wp_mail_content_type', 'amen_set_html_content_type' );
			// send mail
			$mymail = wp_mail( $email, $email_subject, wpautop( $email_message, TRUE ), $header );

			// unset the loop
			unset( $request_loop );
			remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		}
	}
}
add_action( 'amenemailprayers', 'amen_email_prayers' );

function amen_set_html_content_type() {
	return 'text/html';
}

/**************************************
* FILTER SETTINGS
**************************************/

function _atif( $amen_options, $data ) {

	$searchArray = array(
		'{{USER-EMAIL}}',
		'{{DISPLAY-NAME}}',
		'{{POST}}',
		'{{UPDATE}}',
		'{{NEW}}',
		'{{TOTAL}}',
		'{{MANAGE-URL}}',
		'{{LOOP}}',
		'{{SITE-NAME}}',
		'{{SITE-URL}}',
		'\n',
		'\r',
		);
	$replaceArray = array(
		$data['email'],
		$data['twitter_handle'],
		$data['request'],
		$data['update'],
		$data['newprayers'],
		$data['totalprayers'],
		$data['url'],
		$data['loop'],
		$data['site_name'],
		$data['site_url'],
		);

	if ( !is_array( $amen_options ) ) {
		return str_replace( $searchArray, $replaceArray, $amen_options );
	}
	
	$newArray = array();
	
	foreach ( $amen_options as $key => $value ) {
		$newArray[ $key ] = _atif( $value, $data );
	}

	return $newArray;
}