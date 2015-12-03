<?php

require_once dirname( __FILE__ ) . '/db.php';

/**************************************
* ADD ADMIN MENU ITEM
**************************************/

function load_amen_menu() {
	add_menu_page( 'Manage Prayer Requests', 'Amen', 'edit_posts', 'amen-manage-requests', 'amen_manage_requests_admin', plugin_dir_url( __FILE__ ) . 'amen.png', 37 );
}
add_action( 'admin_menu', 'load_amen_menu' );

/**************************************
* ADD SETTINGS MENU ITEM
**************************************/

function amen_add_options_link() {
	add_submenu_page( 'amen-manage-requests', 'Amen Settings', 'Amen Settings', 'manage_options', 'amen-options', 'amen_options_page');
}
add_action('admin_menu', 'amen_add_options_link');

/**************************************
* REGISTER AMEN SETTINGS
**************************************/

function amen_register_settings() {
	register_setting('amen_settings_group', 'amen_settings');
}
add_action('admin_init', 'amen_register_settings');

/**************************************
* DISPLAY ADMIN OPTIONS
**************************************/

function amen_options_page() {
	global $amen_options;
	global $wpdb;

	// QUERY AVAILABLE PAGES
	$amen_all_pages = $wpdb->get_results( 
		"
		SELECT ID, post_title
		FROM $wpdb->posts
		WHERE post_type = 'page'
		ORDER BY post_title ASC
		"
	);

	$amen_page_array_w_empty['none'] = '';
	foreach ($amen_all_pages as $amen_page) {
		$amen_page_array[ $amen_page->ID ] = $amen_page->post_title;
		$amen_page_array_w_empty[ $amen_page->ID ] = $amen_page->post_title;
	}

	// Set arguments for settings fields
	$amen_settings_args = array(
		'form_properties' => array(
			'type' => 'table',
			),
		'form_fields' => array(
			'privacy' => array(
				'head' => 'Privacy & Moderation',
				'fieldset' => array(
					'allow_public_requests' => array(
						'displayType' => 'checkbox',
						'label'       => 'Enable Public Posting',
						'description' => '(display request form for public visitors%Bnote: public posters will lost management rights if their cookies are cleared)',
						'id'          => 'amen_settings[allow_public_requests]',
						'value'       => $amen_options['allow_public_requests'],
						),
					'disable_public_management' => array(
						'displayType' => 'checkbox',
						'label'       => 'Disable Public Management',
						'description' => '(disable the management form for publicly submitted requests)',
						'id'          => 'amen_settings[disable_public_management]',
						'value'       => $amen_options['disable_public_management'],
						),
					'privatize_prayers' => array(
						'displayType' => 'checkbox',
						'label'       => 'Enable Private Posting',
						'description' => '(allows user to privatize prayers for visibility only to logged-in users %B privilege retained by admin)',
						'id'          => 'amen_settings[privatize_prayers]',
						'value'       => $amen_options['privatize_prayers'],
						),
					'super_privatize_prayers' => array(
						'displayType' => 'single-select',
						'label'       => 'Enable Personal Posting',
						'description' => '(allow posting to personal prayer journal%Bposts need no approval%Bvisible only to poster)',
						'id'          => 'amen_settings[super_privatize_prayers]',
						'options'     => array(	'disabled' => 'Disabled', 'users' => 'Members Only', 'all' => 'All Visitors' ),
						'selected'    => $amen_options['super_privatize_prayers'],
						),
					'moderate_public_requests' => array(
						'displayType' => 'checkbox',
						'label'       => 'Moderate Public Posts',
						'description' => '(require approval for all public posts & updates)',
						'id'          => 'amen_settings[moderate_public_requests]',
						'value'       => $amen_options['moderate_public_requests'],
						),
					'moderate_all_requests' => array(
						'displayType' => 'checkbox',
						'label'       => 'Moderate All Posts',
						'description' => '(require approval for all posts & updates)',
						'id'          => 'amen_settings[moderate_all_requests]',
						'value'       => $amen_options['moderate_all_requests'],
						),
					'disable_approval_notification' => array(
						'displayType' => 'checkbox',
						'label'       => 'Disable Approval Notifications',
						'id'          => 'amen_settings[disable_approval_notification]',
						'value'       => $amen_options['disable_approval_notification'],
						),
					'email_approval_notification_to' => array(
						'displayType' => 'text',
						'label'       => 'Send Approval Notifications To',
						'description' => '(comma-separated list of emails%S%B%Suser accounts related to these emails will be allowed approval privilege)',
						'id'          => 'amen_settings[email_approval_notification_to]',
						'value'       => $amen_options['email_approval_notification_to'],
						'width'       => '30em',
						'order'       => '%L%F%N%D',
						),
					)
				),
			'form' => array(
				'head' => 'Submission & Management',
				'fieldset' => array(
					'submission_title' => array(
						'displayType' => 'text',
						'label'       => 'Title for Submission Form',
						'id'          => 'amen_settings[submission_title]',
						'value'       => $amen_options['submission_title'],
						),
					'submission_note' => array(
						'displayType' => 'text',
						'label'       => 'Note Displayed Below Submission Form',
						'id'          => 'amen_settings[submission_note]',
						'value'       => $amen_options['submission_note'],
						'width'       => '40em',
						),
					'submission_button' => array(
						'displayType' => 'text',
						'label'       => 'Button Text for Submission Form',
						'id'          => 'amen_settings[submission_button_text]',
						'value'       => $amen_options['submission_button_text'],
						'width'       => '10em',
						),
					'management_title' => array(
						'displayType' => 'text',
						'label'       => 'Title for Management Form',
						'id'          => 'amen_settings[management_title]',
						'value'       => $amen_options['management_title'],
						),
					'author_display' => array(
						'displayType' => 'single-select',
						'label'       => 'Display Author As',
						'id'          => 'amen_settings[author_display]',
						'options'     => array(	'none' => 'Do Not Display',	'username' => 'Username', 'displayname' => 'Display Name' ),
						'selected'    => $amen_options['author_display'],
						),
					'public_user' => array(
						'displayType' => 'text',
						'label'       => 'Default Name for Public User',
						'description' => '(only used if name was not provided during submission)',
						'id'          => 'amen_settings[public_user]',
						'value'       => $amen_options['public_user'],
						'width'       => '10em',
						),
					'show_date' => array(
						'displayType' => 'checkbox',
						'label'       => 'Display Date of Request/Update',
						'id'          => 'amen_settings[show_date]',
						'value'       => $amen_options['show_date'],
						),
					)
				),
			'counter' => array(
				'head' => 'Counter Customization',
				'fieldset' => array(
					'enable_submit_count' => array(
						'displayType' => 'checkbox',
						'label'       => 'Enable Javascript Counter',
						'description' => "<strong>The following fields accept:</strong> Count Display: {count}, {count-1}, {count+1} %B Add 's' for count > one: {s} %B Add 's' for count = one: {1s}",
						'id'          => 'amen_settings[enable_submit_count]',
						'value'       => $amen_options['enable_submit_count'],
						'order'       => '%F%L%N%D%N',
						),
					'submit_text' => array(
						'displayType' => 'text',
						'label'       => 'Counter Submission Text',
						'description' => '(clickable text)',
						'id'          => 'amen_settings[submit_text]',
						'value'       => $amen_options['submit_text'],
						'width'       => '10em',
						),
					'submitted_state_one' => array(
						'displayType' => 'text',
						'label'       => 'State One Text',
						'description' => '(if user is not included in the count)',
						'id'          => 'amen_settings[submitted_state_one]',
						'value'       => $amen_options['submitted_state_one'],
						),
					'submitted_state_two' => array(
						'displayType' => 'text',
						'label'       => 'State Two Text',
						'description' => '(if user is only one included in the count)',
						'id'          => 'amen_settings[submitted_state_two]',
						'value'       => $amen_options['submitted_state_two'],
						),
					'submitted_state_three' => array(
						'displayType' => 'text',
						'label'       => 'State Three Text',
						'description' => '(if user is included with others in the count)',
						'id'          => 'amen_settings[submitted_state_three]',
						'value'       => $amen_options['submitted_state_three'],
						),
					)
				),
			'twitter' => array(
				'head' => 'Tweeting',
				'fieldset' => array(
					'tweet_public_requests' => array(
						'displayType' => 'checkbox',
						'label'       => 'Enable Tweeting',
						'description' => '(only public requests will be tweetable %B privilege retained by admin)',
						'id'          => 'amen_settings[tweet_public_requests]',
						'value'       => $amen_options['tweet_public_requests'],
						),
					'tweet_via' => array(
						'displayType' => 'text',
						'label'       => 'Tweet Via',
						'description' => '(exclude @)',
						'placeholder' => 'ex. prayerleague',
						'id'          => 'amen_settings[tweet_via]',
						'value'       => $amen_options['tweet_via'],
						'order'       => '%L%D%F%S%B%S',
						'width'       => '8em',
						),
					'custom_hashtag' => array(
						'displayType' => 'text',
						'label'       => 'Add Hashtag',
						'description' => '(exclude #)',
						'id'          => 'amen_settings[custom_hashtag]',
						'value'       => $amen_options['custom_hashtag'],
						'order'       => '%L%D%F%N',
						'width'       => '8em',
						),
					'tweet_type' => array(
						'displayType' => 'single-select',
						'label'       => 'Tweet Type',
						'id'          => 'amen_settings[tweet_type]',
						'selected'    => $amen_options['tweet_type'],
						'options'     => array( 'share_count' => 'Share Button w/ Counter (shares URL)', 'hashtag' => 'Standalone Tweet (may include hashtag in button)' ),
						'order'       => '%L%F%S%B%S',
						),
					'hashtag_in_button' => array(
						'displayType' => 'checkbox',
						'label'       => 'Show Hashtag in Tweet Button',
						'id'          => 'amen_settings[hashtag_in_button]',
						'value'       => $amen_options['hashtag_in_button'],
						),
					'prepend_name_to_tweet' => array(
						'displayType' => 'checkbox',
						'label'       => 'Prepend Display Name to Tweet',
						'id'          => 'amen_settings[prepend_name_to_tweet]',
						'value'       => $amen_options['prepend_name_to_tweet'],
						),
					'custom_id_name' => array(
						'displayType' => 'text',
						'label'       => 'Assigned Name for ID Parameter',
						'description' => '(this parameter is shown in URLs in order to locate entries)',
						'id'          => 'amen_settings[custom_id_name]',
						'value'       => $amen_options['custom_id_name'],
						'width'       => '8em',
						),
					)
				),
			'digest' => array(
				'head' => 'Weekly Prayer Notification',
				'fieldset' => array(
					'digest_interval' => array(
						'displayType' => 'checkbox',
						'label'       => 'Enable Weekly Notification of New Prayers for Posted Requests',
						'description' => '(a single email will be sent to each address having active requests and new prayers within the past week)',
						'id'          => 'amen_settings[enable_digest]',
						'value'       => $amen_options['enable_digest'],
						'order'       => '%F%L%N%D%N%N',
						),
					'notif_from_name' => array(
						'displayType' => 'text',
						'label'       => 'From:',
						'description' => '(name)',
						'id'          => 'amen_settings[notif_from_name]',
						'value'       => $amen_options['notif_from_name'],
						'order'       => '%L%D%F',
						'width'       => '12em',
						),
					'notif_from_email' => array(
						'displayType' => 'text',
						'label'       => '',
						'description' => '(email)',
						'id'          => 'amen_settings[notif_from_email]',
						'value'       => $amen_options['notif_from_email'],
						'order'       => '%D%F%N',
						'width'       => '15em',
						),
					'notif_subject' => array(
						'displayType' => 'text',
						'label'       => 'Subject:',
						'description' => '(subject for digest email)',
						'id'          => 'amen_settings[notif_subject]',
						'value'       => $amen_options['notif_subject'],
						'order'       => '%L%F%D%N%N',
						),
					'notif_message' => array(
						'displayType' => 'editor',
						'label'       => 'Message:',
						'description' => 'This field accepts:%N%BDisplay Name: {{DISPLAY-NAME}}%N%BUser Email: {{USER-EMAIL}}%N%BLoop of Requests: {{LOOP}}%N%BSite Name: {{SITE-NAME}}%N%BSite URL: {{SITE-URL}}',
						'id'          => 'amen_settings[notif_message]',
						'value'       => $amen_options['notif_message'],
						'order'       => '%L%N%D%N%F%N',
						),
					'notif_request_loop' => array(
						'displayType' => 'editor',
						'label'       => 'Request Loop for Message',
						'description' => 'This field accepts:%N%BPost: {{POST}}%N%BUpdate: {{UPDATE}}%N%BNumber of New Prayers: {{NEW}}%N%BTotal Number of Prayers: {{TOTAL}}%N%BURL to Manage Request: {{MANAGE-URL}}',
						'id'          => 'amen_settings[notif_request_loop]',
						'value'       => $amen_options['notif_request_loop'],
						'order'       => '%L%N%D%N%F%N',
						),
					'management_url' => array(
						'displayType' => 'single-select',
						'label'       => 'Management Page',
						'description' => '(for use of {{MANAGE-URL}} above)',
						'id'          => 'amen_settings[management_url]',
						'selected'    => $amen_options['management_url'],
						'options'     => $amen_page_array_w_empty,
						'order'       => '%L%F%D%N',
						'width'       => '25em',
						),
					'wmpl_link' => array(
						'displayType' => 'checkbox',
						'label'       => 'Append following to notification emails: ',
						'description' => '<span style="font-style:normal;font-size:8px;">Online prayer journal provided by <a href="http://wmpl.org">World Mission Prayer League</a></span>',
						'id'          => 'amen_settings[wmpl_link]',
						'value'    => $amen_options['wmpl_link'],
						'options'     => $amen_page_array_w_empty,
						'order'       => '%F%L%D%N',
						'width'       => '25em',
						),
					)
				),
			'database' => array(
				'head' => 'Database',
				'fieldset' => array(
					'keep_db_tables' => array(
						'displayType' => 'checkbox',
						'label'       => 'Keep Plugin Tables on Removal of Amen Plugin',
						'id'          => 'amen_settings[keep_db_tables]',
						'value'       => $amen_options['keep_db_tables'],
						),
					'keep_db_options' => array(
						'displayType' => 'checkbox',
						'label'       => 'Keep Plugin Options on Removal of Amen Plugin',
						'id'          => 'amen_settings[keep_db_options]',
						'value'       => $amen_options['keep_db_options'],
						),
					'custom_db_prefix' => array(
						'displayType' => 'text',
						'label'       => 'Custom Database Table Prefix',
						'description' => '(allows use of a different amen table %B integration for multisite)',
						'id'          => 'amen_settings[custom_db_prefix]',
						'value'       => $amen_options['custom_db_prefix'],
						'order'       => '%L%F%D%N',
						'width'       => '5em',
						),
					)
				),
			'page_tags' => array(
				'head' => 'Page Tagging',
				'fieldset' => array(
					'allowed_users' => array(
						'displayType' => 'textarea',
						'label'       => 'Users Allowed to Post to Pages',
						'description' => '(comma-separated list of usernames %B privilege retained by admin)',
						'id'          => 'amen_settings[allowed_users]',
						'value'       => $amen_options['allowed_users'],
						'order'       => '%L%N%D%N%F%N',
						'rows'        => '3',
						'columns'     => '50',
						),
					'allowed_pages' => array(
						'displayType' => 'multi-select',
						'label'       => 'Taggable Pages',
						'description' => '(note: shortcode of form [amen page="3"] must exist in page content)',
						'id'          => 'amen_settings[allowed_pages]',
						'value'     => $amen_options['allowed_pages'],
						'options'     => $amen_page_array,
						'order'       => '%L%D%N%F%N',
						),
					)
				),
			)
		);

	ob_start();  // Begin display of page content

	$amen_settings_form = new Amen_Form( $amen_settings_args );  // Create new form ?>

	<div class="wrap">
		<h2>Amen Settings</h2>
 
		<form method="post" action="options.php"><?php
 			settings_fields('amen_settings_group'); ?>
 			<div style="font-size:90%;float:left;width:60%">
 				<br />
 				<?php $amen_settings_form->menu(); ?><br />
 				<h4>Setup Steps</h4>
 				<ol>
 					<li>Insert these shortcodes on pages of your site.<br />
 					[amen]&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;lists prayer requests<br />
 					[amen type="manage"]&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;displays submission form and management list<br />
 					[amen type="bookmarked"]&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;list prayers bookmarked by user<br />
 					[amen type="personal"]&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;list prayers of current user<br />
 					</li>
 					<li>Select 'Management Page' in Weekly Email Digest section below.</li>
 					<li>Use custom shortcodes throughout site (documentation found <a href="http://wmpl.org/blogs/vandercar/wp/amen">here</a>).</li>
 					<li>Pray.</li>
 				</ol>
 			</div>


			<div style="border: solid 1px #222D23;background:#ECECEC;padding:7px;font-size:75%;margin-top:5px;float:right;width:39em;">
				<strong>Amen</strong> was developed by Joshua Vandercar of <a href="http://wmpl.org">World Mission Prayer League</a>.<br /><br />
				<span style="font-size:11px;font-style:italic;">Then he said to his disciples, "The harvest is plentiful, but the laborers are few; therefore pray earnestly to the Lord of the harvest to send out laborers into his harvest." - <a href="http://bible.us/59/mat.9.37-38.esv" target="_blank">Matthew 9:37-38</a></span><br /><br />
				We are a praying “league”, a community of men and women who are committed to prayer as a key methodology for advancing the Gospel of Christ. Prayer is the working method of our mission.<br /><br />
				Consider downloading <a href="http://wordpress.org/plugins/truth">Truth</a>, which auto-generates YouVersion links for Biblical scripture references (see above link).
			</div> <?php

			$amen_settings_form->display();  // Display form fields ?>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Options', 'amen_domain'); ?>" />
			</p>
		</form>
	</div><?php
	
	echo ob_get_clean();
}

//function amen_reset_crons() {
//	global $amen_options;

//	wp_clear_scheduled_hook( 'amenemailprayers' );
//	amen_schedule_crons( time(), $amen_options['digest_interval'] );
//}
//add_action( 'updated_option_amen_settings', 'amen_reset_crons', 10, 3 );

?>