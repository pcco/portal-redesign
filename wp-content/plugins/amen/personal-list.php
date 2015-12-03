<?php

add_action( 'wp_ajax_switch_fav', 'amen_switch_fav' );
add_action( 'wp_ajax_nopriv_switch_fav', 'amen_switch_fav' );

function amen_switch_fav() {
	global $amen_options;

	// get the submitted parameters
	$requestID = intval( str_replace( $amen_options['custom_id_name'] . '-', '', $_POST['requestID'] ) );
	$amen_action_class = $_POST['fav-class'];

	strpos( $amen_action_class, 'included-in-favs' ) ? amen_remove_fav( $requestID ) : amen_add_fav( $requestID );

	// generate the response
	$response = json_encode( array( 'success' => true, 'amenid' => strval($requestID) ) );

	// response output
	header( "Content-Type: application/json" );
	echo $response;

	// IMPORTANT: don't forget to "exit"
	exit;
}

function amen_add_fav( $requestID ) {
	global $wpdb, $amen_db_prefix;

	$request_table = $amen_db_prefix . "amen_requests";
	$fav_list = unserialize( $wpdb->get_var( "SELECT fav_list FROM $request_table WHERE id=$requestID" ) );

	'' == $fav_list ? $fav_list = array() : FALSE;

	$fav_list['fav'][ _get_amen_user_ID() ] = TRUE;

	$wpdb->update( $request_table, array( 'fav_list' => serialize( $fav_list ) ), array( 'id' => $requestID ), '%s' );
}

function amen_remove_fav( $requestID ) {
	global $wpdb, $amen_db_prefix;

	$request_table = $amen_db_prefix . "amen_requests";
	$fav_list = unserialize( $wpdb->get_var( "SELECT fav_list FROM $request_table WHERE id=$requestID" ) );

	unset( $fav_list['fav'][ _get_amen_user_ID() ] );

	$wpdb->update( $request_table, array( 'fav_list' => serialize( $fav_list ) ), array( 'id' => $requestID ), '%s' );
}