<?php

function amen_call_post_processing() {
	isset( $_POST['amen-nonce'] ) ? amen_process_post_data( $_POST['amen-nonce'] ) : FALSE;
}
add_action( 'init', 'amen_call_post_processing' );

/**************************************
* RENDERS SHORTCODE CALLED FROM ADMIN PAGE
**************************************/

function amen_manage_requests_admin() {
	$the_amen = array(
		'author' => '',
		'page' => '',
		'recent' => '',
		'header' => '',
		'title' => '',
		'count' => '',
		'random' => '',
		'type' => 'manage',
		'id' => '',
		'noid' => '',
		'exclude' => 'tweet',
		'submit' => '',
		'state1' => '',
		'state2' => '',
		'state3' => '',
		);
	echo amen_list_requests( $the_amen );
}

/**************************************
* ADD SHORTCODE FOR LISTING REQUESTS
**************************************/

function amen_list_requests( $amen_atts ) {
	global $amen_options;
	extract( shortcode_atts( array(
		'author' => '',
		'page' => '',
		'recent' => '',
		'header' => '',
		'title' => '',
		'count' => '',
		'random' => '',
		'type' => 'list',
		'id' => '',
		'noid' => '',
		'exclude' => '',
		'submit' => '',
		'state1' => '',
		'state2' => '',
		'state3' => '',
	), $amen_atts ) );

	// DEFINE SHORTCODE ARG ARRAY
	$the_amen = array(
		'author' => ' ' . $author,
		'page' => $page,
		'recent' => $recent,
		'header' => $header,
		'count' => $count,
		'random' => $random,
		'type' => $type,
		'id' => $id,
		'noid' => $noid,
		'exclude' => ' ' . $exclude,
		'submit' => $submit,
		'state1' => $state1,
		'state2' => $state2,
		'state3' => $state3,
		);
	'' == $header ? $the_amen['header'] = $title : FALSE;
	$the_amen['submit'] = '' == $the_amen['submit'] ? $amen_options['submit_text'] : $the_amen['submit'];
	$the_amen['state1'] = '' == $the_amen['state1'] ? $amen_options['submitted_state_one'] : $the_amen['state1'];
	$the_amen['state2'] = '' == $the_amen['state2'] ? $amen_options['submitted_state_two'] : $the_amen['state2'];
	$the_amen['state3'] = '' == $the_amen['state3'] ? $amen_options['submitted_state_three'] : $the_amen['state3'];
	$the_amen['recent'] = $count;
	$the_amen['type'] = $type;
	$the_amen['id'] = $id;

	$amen_request_list = amen_query_requests( $the_amen );
	return $amen_request_list;
	unset( $the_amen );
}
add_shortcode( 'amen', 'amen_list_requests' );

function amen_query_requests( $the_amen ) {
	global $amen_session, $amen_options, $post, $amen_user, $user_email, $wpdb;

	// show management form?
	$amen_show_management = ( 'manage' == $the_amen['type'] && ( is_user_logged_in() || ( $amen_options['allow_public_requests'] && !$amen_options['disable_public_management'] ) ) ) ? TRUE : FALSE;
	// begin buffer for display
	ob_start();

/**************************************
* INCLUDE TWEET BUTTON JAVASCRIPT
**************************************/

	if ( !( strpos( $the_amen['exclude'], 'tweet' ) > 0 ) && $amen_options['tweet_public_requests'] ) {
		echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	}

	// set twitter handle
	if ( is_user_logged_in() ) {
		$display_name = wp_get_current_user()->display_name;
	} else {
		$display_name = isset( $_POST['display_name'] ) ? $_POST['display_name'] : '';
	}
	if ( is_user_logged_in() ) {
		$email = $user_email;
	} else {
		$email = isset( $_POST['amenemail'] ) ? $_POST['amenemail'] : '';
	}

/**************************************
* DISPLAY SUBMISSION FORM
**************************************/
?>
		<div class="wrap"> <?php
			// show only for type=manage and logged-in users or public (if enabled)
			if ( 'manage' == $the_amen['type'] && ( is_user_logged_in() || ( $amen_options['allow_public_requests'] ) ) ) {
				// include header on admin page
				echo is_admin() ? '<h2>Manage Prayer Requests</h2>' : '';
?>
				<script type="text/javascript">
					var PWUactuallyDelete = function(el) {
						return confirm("Do you really want to delete this request?")
					}
				</script>
<?php
				// show form title
				if ( isset( $amen_options['submission_title'] ) ) {
?>
					<span style="font-size:16px;font-weight:bold;"><?php echo $amen_options['submission_title']; ?></span>
<?php
				}
				// show current author
				if ( is_user_logged_in() ) {
					switch ( $amen_options['author_display'] ) {
							case 'none':
								$amen_author_display = '';
								break;
							case 'username':
								$amen_author_display = ' (' . wp_get_current_user()->user_login . ')';
								break;
							case 'displayname':
								$amen_author_display = ' (' . wp_get_current_user()->display_name . ')';
								break;
							default:
								$amen_author_display = '';
								break;
					}
				} else {
					$amen_author_display = '' != $amen_options['public_user'] ? ' (' . $amen_options['public_user'] . ')' : '';
				}
				echo $amen_author_display; 

				// begin form display ?>
				<form action="#manage-my-prayer-requests" method="POST" class="amen-submission">
					<input type="text" id="prayer_item" name="prayer_item" style="width:75%;margin-bottom:7px;" placeholder="Add your prayer here." tabindex="1" />
					<?php wp_nonce_field('amen-submission-nonce','amen-nonce'); ?>
					<input type="submit" value="<?php echo $amen_options['submission_button_text']; ?>" style="display:inline-block;float:right;" tabindex="5" /><br /> <?php
					// show privacy only if enabled and logged in
					if ( ( $amen_options['privatize_prayers'] || current_user_can( 'delete_users' ) ) && is_user_logged_in() ) { ?>
						<nobr><label for="privacy">Visibility: </label>
						<select id="privacy" name="privacy" tabindex="2" >
							<option value="0">Public</option>
							<option value="1">Members</option> <?php
							if ( 'users' == $amen_options['super_privatize_prayers'] || 'all' == $amen_options['super_privatize_prayers'] ) { ?>
								<option value="2">Only Me</option>
							<?php } ?>
						</select></nobr> <?php
					} elseif ( 'all' == $amen_options['super_privatize_prayers'] ) {
						?>
						<nobr><label for="privacy">Visibility: </label>
						<select id="privacy" name="privacy" tabindex="2" >
							<option value="0">Public</option>
							<option value="2">Only Me</option>
						</select></nobr> <?php
					}
					// show urgency ?>
					<nobr><label for="urgency">Urgency: </label>
					<select id="urgency" name="urgency" tabindex="3" >
						<option value="0">Standard</option>
						<option value="1">Important!</option>
					</select></nobr> <?php
					// show page tag if allowed user
					if ( ! (strpos( $amen_options['allowed_users'], wp_get_current_user()->user_login ) === FALSE) || current_user_can( 'delete_users' ) ) { ?>
						<nobr><label for="praying_tag">Tag: </label>
						<select id="praying_tag" name="praying_tag" tabindex="4" >
							<option value=""></option> <?php
							foreach ( $amen_options['allowed_pages'] as $allowed_page => $allowed ) {
								if ( isset( $allowed['checked'] ) ) { ?>
									<option value="<?php echo $allowed_page; ?>"><?php echo $allowed['displayValue']; ?></option> <?php
								}
							} ?>
						</select></nobr> <?php
					}
					// show name & email fields to public users
					// set hidden email field for users
					if ( ! is_user_logged_in() ) { ?>
						<nobr><input type="text" id="display_name" name="display_name" placeholder="Name (optional)" style="width:17%"/></nobr>
						<nobr><input type="text" id="amenemail" name="amenemail" placeholder="Email for Notifications" style="width:27%"/></nobr> <?php
					} else { ?>
						<input type="hidden" id="amenemail" name="amenemail" value="<?php echo wp_get_current_user()->email; ?>" /> <?php
					} 
					// show notification checkbox ?>
					<nobr><input type="checkbox" id="notify" name="notify" value="1" checked="checked" /><label for="notify">Notify Weekly When Others Pray for My Request</label></nobr>
				</form>
				<br /> <?php
				// show submission note
				if ( isset( $amen_options['submission_note'] ) ) { ?>
					<span style="font-size:11px;"><?php echo $amen_options['submission_note']; ?></span> <?php
				}
			}

			// retrieve requests for list or management
			switch ( $the_amen['type'] ) {
				case 'list':
					$requests = amen_get_active_requests( $amen_session, $the_amen );
					break;
				case 'manage':
					$requests = amen_get_manageable_requests( $amen_session, $the_amen );
					break;
				case 'bookmarked':
					$requests = amen_get_fav_requests( $amen_session );
					break;
				case 'personal':
					$requests = amen_get_personal_requests( $amen_session, $the_amen );
			}

			// begin display of requests
			$i = 0;
			// determine whether request is to be shown from author and page parameters
			foreach ( $requests as $r ) {
				// if author and page parameters are set
				if ( ' ' != $the_amen['author'] && '' != $the_amen['page'] ) {
					// if request is in author and page, then include
					if ( strpos( $the_amen['author'], get_userdata( $r->created_by )->user_login ) > 0 && ( '' != $r->praying_tag && $r->praying_tag == $the_amen['page'] ) ) {
						$amen_list_this_request = TRUE;
					} else { $amen_list_this_request = FALSE; }
				} 
				// if author is set and page is not
				elseif ( ' ' != $the_amen['author'] && '' == $the_amen['page'] ) {
					// if request is in author, then include
					if ( strpos( $the_amen['author'], get_userdata( $r->created_by )->user_login ) > 0 ) {
						$amen_list_this_request = TRUE;
					} else { $amen_list_this_request = FALSE; }
				}
				// if page is set and author is not
				elseif ( ' ' == $the_amen['author'] && '' != $the_amen['page'] ) {
					// if request is in page, then include
					if ( '' != $r->praying_tag && $r->praying_tag == $the_amen['page'] ) {
						$amen_list_this_request = TRUE;
					} else { $amen_list_this_request = FALSE; }
				}
				// if author and page not set, then include request
				elseif ( ' ' == $the_amen['author'] && '' == $the_amen['page'] ) {
					$amen_list_this_request = TRUE;
				}
				// else, don't include - is this needed?
				else {
					$amen_list_this_request = FALSE;
				}

				// if request is included, check other parameters (could be optimized with above code)
				if ( $amen_list_this_request ) {
					// if recent is not set or still serving recently requested
					if ( '' == $the_amen['recent'] || $i < intval( $the_amen['recent'] ) ) {
						// set options to true or false
						$praying = intval($r->praying) == 1;
						$active = intval($r->active) == 1;
						$urgent = intval($r->urgency) == 1;
						$private = intval($r->privacy) == 1;
						$super_private = intval($r->privacy) == 2;
						$approved = intval($r->approved) == 1;
						$notify = intval($r->notify) == 1;
						//$faved = isset($r->faved) ? TRUE : FALSE;

						// set classes
						$cssClasses = 'amen-wrap';
						$cssClasses .= ' amen-' . $r->id;
						
						// check if user is in fav list
						$fav = unserialize( $r->fav_list );
						'' == $fav ? $fav = array() : FALSE;
						if ( isset( $fav['fav'] ) ) {
							foreach ( $fav['fav'] as $favuser => $status ) {
								if ( _get_amen_user_ID() == $favuser ) {
									$cssClasses .= ' included-in-favs';
								}
							}
						}

						!$active ? $cssClasses .= $cssClasses .= ' amen-inactive' : '';
						!$urgent ? $cssClasses .= '' : $cssClasses .= ' amen-urgent';
						1 == $r->privacy ? $cssClasses .= ' amen-private' : $cssClasses .= '';
						2 == $r->privacy ? $cssClasses .= ' super-private' : $cssClasses .= '';
						$approved ? $cssClasses .= '' : $cssClasses .= ' amen-not-approved';

						// show header, if shortcode parameter set
						if ($i == 0 && '' != $the_amen['header']) { amen_header( $the_amen['header'] ); }

						// include anchor to request, then begin display
						?>
						<a name="<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>"></a>
						<div class="<?php echo $cssClasses ?>">
							<div class="amen-inner-wrap"> <?php
								// set author display
								$public_author = '' == $r->twitter_handle ? $amen_options['public_user'] : $r->twitter_handle;
								switch ( $amen_options['author_display'] ) {
									case 'none':
										if ( current_user_can( 'delete_users' ) ) {
											$amen_author_display = get_userdata( $r->created_by ) ? get_userdata( $r->created_by )->user_login : $public_author;
											$amen_author_display .= ( get_userdata( $r->created_by ) && $amen_show_management ) ? ' (' . get_userdata( $r->created_by )->display_name . ')' : FALSE;
											$amen_author_display .= ': ';
										} else {
											$amen_author_display = '';
										}
										break;
									case 'username':
										// if author exclusion not set in shortcode
										if ( !( strpos( $the_amen['exclude'], 'author' ) > 0 ) ) {
											$amen_author_display = get_userdata( $r->created_by ) ? get_userdata( $r->created_by )->user_login : $public_author;
											if ( current_user_can( 'delete_users' ) ) {
												$amen_author_display .= ( get_userdata( $r->created_by ) && $amen_show_management ) ? ' (' . get_userdata( $r->created_by )->display_name . ')' : FALSE;
											}
											$amen_author_display .= ': ';
										}
										break;
									case 'displayname':
										// if author exclusion not set in shortcode
										if ( !( strpos( $the_amen['exclude'], 'author' ) > 0 ) ) {
											$amen_author_display = get_userdata( $r->created_by ) ? get_userdata( $r->created_by )->display_name : $public_author;
											if ( current_user_can( 'delete_users' ) ) {
												$amen_author_display .= ( get_userdata( $r->created_by ) && $amen_show_management ) ? ' (' . get_userdata( $r->created_by )->user_login . ')' : FALSE;
											}
											$amen_author_display .= ': ';
										}
										break;
									default:
										$amen_author_display = '';
										break;
								}	
								// set id for admin on management page
								if ( current_user_can( 'delete_users' ) && $amen_show_management ) { $amen_id = '<strong>[Amen-ID: ' . $r->id . '] '; } else { $amen_id = ''; }
								// set status on management page
								if ( $amen_show_management ) {
									$amen_id .= $private || $super_private ? '<span style="color:#A00;">Privately ' : '<span style="color:#070;">Publicly ';
									$amen_id .= $active ? 'Active</span></strong>' : 'Inactive</span></strong>';
									$amen_id .= $notify ? ' <nobr><span style="font-size:80%;font-variant:italic;">(Notifying <a href="mailto:' . $r->email . '" target="_blank">' . $r->email . '</a>)</span></nobr><br />' : ' <nobr><span style="font-size:80%;font-variant:italic;">(Notifications Disabled)</span></nobr><br />';
								}
								// show id, author, and item
								echo '<div class="pray-request">' . $amen_id . $amen_author_display . $r->prayer_item;
								// show toggle forms on management page
								if ( $amen_show_management ) { ?>
									<br />
									<form action="#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>" method="POST"> <?php
										// if not requested to edit post show the Edit Request button
										$editRequest = isset( $_POST['editRequest'] ) ? isset( $_POST['editRequest'] ) : '';
										if ( $r->id != $editRequest ) { ?>
											<input type="submit" value="Edit Request" class="amen-small-button" />
											<input type='hidden' name='editRequest' value='<?php echo $r->id ?>' /> <?php
										// if requested to edit post, show the edit form
										} elseif ( isset( $_POST['editRequest'] ) && $r->id == $_POST['editRequest'] ) { ?>
											<input type="submit" value="Submit Edit" class="amen-small-button" />
											<?php wp_nonce_field('amen-edit-nonce','amen-nonce'); ?>
											<input type='hidden' name='editRequest' value='<?php echo $r->id ?>' />
											<input type="text" id="request_edit" name="request_edit" style="width:80%;margin-bottom:7px;" value="<?php echo $r->prayer_item; ?>" /> <?php
										} ?>
									</form> <?php
								}
								echo '</div>';
								// if date enabled
								if ( ( isset( $amen_options['show_date'] ) && ! strpos( $the_amen['exclude'], 'date' ) ) || $amen_show_management ) {
									echo '<div class="praying">';
									echo date( get_option('date_format'), strtotime($r->created_at) );
									echo '</div>';
								}
								// if counter enabled and not excluded by shortcode
								if ( !( strpos( $the_amen['exclude'], 'counter' ) > 0 ) && $amen_options['enable_submit_count'] && $r->approved ) {
									echo '<div class="praying">';
									// if already praying, show this
									if ( $praying ) {
										echo count_contents($r->count, $praying, $the_amen);
									}
									// if not praying, show this
									else {
										echo count_contents($r->count, $praying, $the_amen);
										echo ' &ndash; ';
										echo '<a href="#" class="amenButton" onclick="return false;" id="' . $r->id . '" data-amen-submit="' . $the_amen['submit'] . '" data-amen-state1="' . $the_amen['state1'] . '" data-amen-state2="' . $the_amen['state2'] . '" data-amen-state3="' . $the_amen['state3'] . '">' . amen_set_display($r->count, $the_amen['submit']) . '</a>';
									}
									echo '</div>';
								}
								// if not yet approved, show this (restricted to author elsewhere)
								if ( !$r->approved ) {
									echo '<div class="praying"><strong>Pending Approval</strong></div>';
								}
								// if tweet enabled, not excluded by shortcode, and post not private and approved
								elseif ( !( strpos( $the_amen['exclude'], 'tweet' ) > 0 ) && !$r->privacy && $r->approved && $amen_options['tweet_public_requests'] ) {
									echo '<div class="praying">';
									$amen_add_name = $amen_options['prepend_name_to_tweet'] ? $amen_author_display : '';
									if ( 'hashtag' == $amen_options['tweet_type'] ) {
										$amen_options['hashtag_in_button'] ? $amen_display_hashtag = '?button_hashtag=' . $amen_options['custom_hashtag'] : $amen_display_hashtag = '';
										$amen_options['custom_hashtag'] ? $amen_custom_hashtag = ' #' . $amen_options['custom_hashtag'] : $amen_custom_hashtag = '';
										echo '<a href="https://twitter.com/intent/tweet' . $amen_display_hashtag . '" class="twitter-hashtag-button" data-lang="en" data-text="' . $amen_add_name . $r->prayer_item . '" data-via="'. $amen_options['tweet_via'] . '" data-hashtags="' . $amen_options['custom_hashtag'] . '" data-align="right">Tweet' . $amen_custom_hashtag . '</a>';
									} elseif ( 'share_count' == $amen_options['tweet_type'] ) {
										echo '<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-count="horizontal" data-url="' . get_permalink( $post->ID );
										echo !strpos( get_permalink(), '?' ) ? '?' : '&';
										echo $amen_options['custom_id_name'] . '=' . $r->id . '" data-text="' . $amen_add_name . $r->prayer_item . '" data-via="'. $amen_options['tweet_via'] . '" data-hashtags="Amen" data-align="right">Tweet</a>';
									}
									echo '</div>';
								}
								// if private, show this
								elseif ( 1 == $r->privacy ) {
									echo '<div class="praying"><strong>Visibility: Members</strong></div>';
								} elseif ( 2 == $r->privacy ) {
									echo '<div class="praying"><strong>Visibility: Only Me</strong></div>';
								}
								echo '</div>';
								// show update
								if ( '' != $r->prayer_updated ) {
									echo '<div class="amen-update">';
									if ( isset( $amen_options['show_date'] ) && ! strpos( $the_amen['exclude'], 'date' ) ) {
										echo '<div class="praying">';
										echo date( get_option('date_format'), strtotime($r->updated_at) );
										echo '</div>';
									}
									echo '<em>' . $r->prayer_updated . '</em></div>';
								}
								// if allowed to author and management page
								if ( $amen_show_management ) {
									global $user_email; ?>
									<div>
										<span style='font-size:10px;float:right;'> <?php
											// allowed to tag by page, show pages tagged
											if ( !( strpos( $amen_options['allowed_users'], wp_get_current_user()->user_login ) === FALSE ) || current_user_can( 'delete_users' ) ) {
												$tagged_pages = $wpdb->get_results( 
													"
													SELECT meta_value, post_id 
													FROM $wpdb->postmeta
													WHERE meta_key = 'praying'
													"
												);
												foreach ( $tagged_pages as $tagged_page ) {
													if ( $tagged_page->meta_value == get_userdata( $r->created_by )->user_login ) {
													echo get_the_title( $tagged_page->post_id ) . ', ';
													}
												}
												echo $r->praying_tag ? '<i> On Pages: ' . get_the_title( $r->praying_tag ) . '</i> | ' : '';
											} ?>
										</span>

										<?php // show update form ?>
										<form action="#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>" method="POST"><nobr>
											<input type="text" id="prayer_update" name="prayer_update" style="width:80%;margin-bottom:7px;" placeholder="Add an update to (or change the update for) this prayer request." />
											<input type='hidden' name='updateRequest' value='<?php echo $r->id ?>' />
											<?php wp_nonce_field('amen-update-nonce','amen-nonce'); ?>
											<input type="submit" value="Post Update" /></nobr>
										</form><br /> <?php 
										// show privatization toggle for users and admin
										if ( is_user_logged_in() || current_user_can( 'delete_users' ) ) {
											if ( $private ) {
												if ( 'disabled' != $amen_options['super_privatize_prayers'] || $amen_options['privatize_prayers'] ) { ?>
													<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
														<input type='hidden' name='toggleTo' value='deprivatize' />
														<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
														<input type='submit' value='Make Public' />
													</form> <?php
												}
												if ( 'disabled' != $amen_options['super_privatize_prayers'] && _get_amen_user_ID() == $r->created_by ) { ?> |
													<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
														<input type='hidden' name='toggleTo' value='superprivatize' />
														<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
														<input type='submit' value='Make Super Private' />
													</form> <?php
												}
											} elseif ( $super_private ) {
												if ( 'disabled' != $amen_options['super_privatize_prayers'] || $amen_options['privatize_prayers'] ) { ?>
													<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
														<input type='hidden' name='toggleTo' value='deprivatize' />
														<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
														<input type='submit' value='Make Public' />
													</form> <?php
												}
												if ( $amen_options['privatize_prayers'] ) { ?> | 
													<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
														<input type='hidden' name='toggleTo' value='privatize' />
														<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
														<input type='submit' value='Make Private' />
													</form> <?php
												}
											} else {
												if ( $amen_options['privatize_prayers'] ) { ?>
													<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
														<input type='hidden' name='toggleTo' value='privatize' />
														<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
														<input type='submit' value='Make Private' />
													</form> <?php
												}
												if ( 'disabled' != $amen_options['super_privatize_prayers'] && _get_amen_user_ID() == $r->created_by ) { ?> |
													<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
														<input type='hidden' name='toggleTo' value='superprivatize' />
														<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
														<input type='submit' value='Make Super Private' />
													</form> <?php
												}
											} 
										} else {
											if ( $super_private && 'all' == $amen_options['super_privatize_prayers'] ) { ?>
													<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
														<input type='hidden' name='toggleTo' value='deprivatize' />
														<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
														<input type='submit' value='Make Public' />
													</form> <?php
											} elseif ( 'all' == $amen_options['super_privatize_prayers'] ) { ?>
													<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='togglePrivacy' value='<?php echo $r->id ?>' />
														<input type='hidden' name='toggleTo' value='superprivatize' />
														<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
														<input type='submit' value='Make Super Private' />
													</form> <?php
											}
										} ?> | <?php
										// show urgency toggle ?>
										<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='toggleUrgency' value='<?php echo $r->id ?>' />
											<?php if ( $urgent ) { ?>
												<input type='hidden' name='toggleTo' value='deurgentize' />
												<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
												<input type='submit' value='Set As Not Urgent' />
											<?php } else { ?>
												<input type='hidden' name='toggleTo' value='urgentize' />
												<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
												<input type='submit' value='Set As Urgent' />
											<?php } ?>
										</form> |
										<?php // show active toggle ?>
										<form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='toggleRequest' value='<?php echo $r->id ?>' />
											<?php if ( $active ) { ?>
												<input type='hidden' name='toggleTo' value='deactivate' />
												<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
												<input type='submit' value='Deactivate' />
											<?php } else { ?>
												<input type='hidden' name='toggleTo' value='activate' />
												<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
												<input type='submit' value='Activate' />
											<?php } ?>
										</form>	<?php
										// show approve toggle for admin and user account of set notification email
										$notification_emails = ' ' . $amen_options['email_approval_notification_to'];
										if ( !$approved && ( current_user_can( 'delete_users' ) || strpos( $amen_options['email_approval_notification_to'], $user_email > 0 ) ) ) { ?>
										| <form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='toggleApproval' value='<?php echo $r->id ?>' />
											<input type='hidden' name='toggleTo' value='approve' />
											<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
											<input type='submit' value='Approve' />
										</form> <?php
										} 
										// show notification toggle ?>
										| <form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST'><input type='hidden' name='toggleNotification' value='<?php echo $r->id ?>' />
											<?php if ( $notify ) { ?>
												<input type='hidden' name='toggleTo' value='denotifize' />
												<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
												<input type='submit' value='Disable Notifications' />
											<?php } else { ?>
												<input type='hidden' name='toggleTo' value='notifize' />
												<?php wp_nonce_field('amen-toggle-nonce','amen-nonce'); ?>
												<input type='submit' value='Enable Notifications' />
											<?php } ?>
										</form> <?php
										// show delete button ?>
										| <form action='#<?php echo $amen_options['custom_id_name']; ?>-<?php echo $r->id ?>' method='POST' onsubmit='return PWUactuallyDelete(this);'><input type='hidden' name='deleteRequest' value='<?php echo $r->id ?>' />
										<?php wp_nonce_field('amen-delete-nonce','amen-nonce'); ?>
										<input type='submit' value='Delete' />
										</form>
									</div> <?php
								} ?>
							</div> <?php
					}
				// advance to next request item
				$i++;
				}
			} ?>
		</div> <?php

	// get buffer	
	$amen_buffer = ob_get_clean();

	// return content to shortcode
	return $amen_buffer;
}

function amen_focus() {
global $amen_options;
?>
	
	<script type="text/javascript" language="javascript">
		window.onload=amen_moveWindow; 
		function amen_getID(name){
			if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search)) {
				return decodeURIComponent(name[1]);
			} else {
				return '';
			}
		}
		function amen_moveWindow(){
			var AmenID = amen_getID('<?php echo $amen_options['custom_id_name']; ?>');
			if ( '' != AmenID ) {
				window.location.hash='<?php echo $amen_options['custom_id_name']; ?>-'+AmenID;
			}
		}
	</script>
<?php
}
add_action( 'wp_footer', 'amen_focus' );

function amen_header( $amen_header_text ) {
	?>
	<div class="amen-header">
		<div style="padding:10px 0px 10px 20px;float:left;"><?php echo $amen_header_text; ?></div>
	</div>
	<?php
}

function amen_action_from_email() {
	global $amen_options, $user_email;


	if ( is_user_logged_in() && ( current_user_can('delete_users') || strpos( $amen_options['email_approval_notification_to'], $user_email > 0 ) ) && isset( $_GET['amen-action'] ) ) {
		if ( 'approve' == $_GET['amen-action'] ) {
			amen_approve_request( $_GET[ $amen_options['custom_id_name'] ] );
		} elseif ( 'delete' == $_GET['amen-action'] ) {
			amen_delete_request( $_GET[ $amen_options['custom_id_name'] ] );
		}
	}
}
add_action( 'init', 'amen_action_from_email' );

/**************************************
* DISPLAY COUNT FOR REQUEST
**************************************/

function count_contents($count, $praying = 0, $the_amen) {
	global $amen_options;

	$count = intval($count);
	$state_one = '' == $the_amen['state1'] ? $amen_options['submitted_state_one'] : $the_amen['state1'];
	$state_two = '' == $the_amen['state2'] ? $amen_options['submitted_state_two'] : $the_amen['state2'];
	$state_three = '' == $the_amen['state3'] ? $amen_options['submitted_state_three'] : $the_amen['state3'];
	if ( !$praying ) { $amen_final_text = amen_set_display( $count, $state_one ); return $amen_final_text; }
	elseif ( $count == '1' && $praying ) { $amen_final_text = amen_set_display( $count, $state_two ); return $amen_final_text; }
	else { $amen_final_text = amen_set_display( $count, $state_three ); return $amen_final_text; }
}

function amen_set_display( $count, $amen_text ) {
	$amen_text = str_replace( '{count}', $count, $amen_text);
	$amen_text = str_replace( '{count-1}', $count - 1, $amen_text);
	$amen_text = str_replace( '{count+1}', $count + 1, $amen_text);
	( $count > 1 || $count == 0 ) ? $amen_text = str_replace( '{s}', 's', $amen_text ) : $amen_text = str_replace( '{s}', '', $amen_text );
	$count == 1 ? $amen_text = str_replace( '{1s}', 's', $amen_text ) : $amen_text = str_replace( '{1s}', '', $amen_text );
	return $amen_text;
	unset($amen_text);
}

/**************************************
* PROCESS POSTED DATA
**************************************/
function amen_process_post_data( $amen_nonce ) {
	global $user_email, $amen_user;


	// set twitter handle
	if ( is_user_logged_in() ) {
		$display_name = wp_get_current_user()->display_name;
	} else {
		$display_name = isset( $_POST['display_name'] ) ? $_POST['display_name'] : '';
	}
	if ( is_user_logged_in() ) {
		$email = $user_email;
	} else {
		$email = isset( $_POST['amenemail'] ) ? $_POST['amenemail'] : '';
	}

	// call update db functions on form post
	if ( isset($_POST['prayer_item']) && !empty($_POST['prayer_item']) && wp_verify_nonce( $amen_nonce, 'amen-submission-nonce' ) ) {
		amen_create_request($_POST['prayer_item'], $_POST['urgency'], $_POST['privacy'], $_POST['praying_tag'], $amen_user, $display_name, $email, $_POST['notify'] );
	} else if ( isset($_POST['toggleUrgency']) && !empty($_POST['toggleUrgency']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) && wp_verify_nonce( $amen_nonce, 'amen-toggle-nonce') ) {
		if ( $_POST['toggleTo'] == 'urgentize' ) {
			amen_urgentize_request(intval($_POST['toggleUrgency']));
		} else {
			amen_deurgentize_request(intval($_POST['toggleUrgency']));
		}
	} else if ( isset($_POST['toggleNotification']) && !empty($_POST['toggleNotification']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) && wp_verify_nonce( $amen_nonce, 'amen-toggle-nonce') ) {
		if ( $_POST['toggleTo'] == 'notifize' ) {
			amen_notifize_request(intval($_POST['toggleNotification']));
		} else {
			amen_denotifize_request(intval($_POST['toggleNotification']));
		}
	} else if ( isset($_POST['toggleRequest']) && !empty($_POST['toggleRequest']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) && wp_verify_nonce( $amen_nonce, 'amen-toggle-nonce') ) {
		if ( $_POST['toggleTo'] == 'activate' ) {
			amen_activate_request(intval($_POST['toggleRequest']));
		} else { 
			amen_deactivate_request(intval($_POST['toggleRequest']));
		}
	} else if ( isset($_POST['togglePrivacy']) && !empty($_POST['togglePrivacy']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) && wp_verify_nonce( $amen_nonce, 'amen-toggle-nonce') ) {
		if ( $_POST['toggleTo'] == 'privatize' ) {
			amen_privatize_request(intval($_POST['togglePrivacy']));
		} elseif ( $_POST['toggleTo'] == 'superprivatize' ) {
			amen_superprivatize_request(intval($_POST['togglePrivacy']));
		} else {
			amen_deprivatize_request(intval($_POST['togglePrivacy']));
		}
	} else if ( isset($_POST['toggleApproval']) && !empty($_POST['toggleApproval']) && isset($_POST['toggleTo']) && !empty($_POST['toggleTo']) && wp_verify_nonce( $amen_nonce, 'amen-toggle-nonce') ) {
		if ( $_POST['toggleTo'] == 'approve' ) {
			amen_approve_request(intval($_POST['toggleApproval']));
		} 
	} else if ( isset($_POST['prayer_update']) && !empty( $_POST['prayer_update'] ) && wp_verify_nonce( $amen_nonce, 'amen-update-nonce') ) {
		amen_update_request( intval($_POST['updateRequest']), $_POST['prayer_update'] );
	} else if ( isset($_POST['request_edit']) && !empty( $_POST['request_edit'] ) && wp_verify_nonce( $amen_nonce, 'amen-edit-nonce') ) {
		amen_edit_request( intval($_POST['editRequest']), $_POST['request_edit'] );
	} else if ( isset($_POST['deleteRequest']) && !empty($_POST['deleteRequest']) && wp_verify_nonce( $amen_nonce, 'amen-delete-nonce') ) {
		amen_delete_request( intval($_POST['deleteRequest'] ) );
	}
}
?>