<?php

$amen_options = get_option( 'amen_settings' );

! $amen_options['keep_db_tables'] ? amen_remove_tables() : FALSE;

if ( ! $amen_options['keep_amen_options'] ) {
	delete_option( 'amen_settings' );
	delete_option( 'amen_version' );
}

function amen_remove_tables() {
	global $wpdb;

	$wpdb->query("DROP TABLE {$wpdb->prefix}amen_requests");
	$wpdb->query("DROP TABLE {$wpdb->prefix}amen_prayers");
}