<?php
/*-----------------------------------------------------------------------------------*/
/*	Default Options
/*-----------------------------------------------------------------------------------*/

// Number of posts array
function cp_shortcodes_range ( $range, $all = true, $default = false, $range_start = 1 ) {
	if($all) {
		$number_of_posts['-1'] = 'All';
	}

	if($default) {
		$number_of_posts[''] = 'Default';
	}

	foreach(range($range_start, $range) as $number) {
		$number_of_posts[$number] = $number;
	}

	return $number_of_posts;
}

// Taxonomies
function cp_shortcodes_categories ( $taxonomy, $empty_choice = false ) {
	if($empty_choice == true) {
		$post_categories[''] = 'Default';
	}

	$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy);

	if( ! array_key_exists('errors', $get_categories) ) {
		if( $get_categories && is_array($get_categories) ) {
			foreach ( $get_categories as $cat ) {
				$post_categories[$cat->slug] = $cat->name;
			}
		}

		if(isset($post_categories)) {
			return $post_categories;
		}
	}
}

// return the title list of each post_type
function get_title_list_index( $post_type ){
	
	$posts_title = array();
	$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
	
	foreach ($posts as $post) {
		$posts_title[$post->ID] = $post->post_title;
	}
	
	return $posts_title;

}

//Fetch Categories
function get_category_list_index( $category_name, $parent='' ){
	
	if( empty($parent) ){ 
		$category_list = array();
		$get_category = get_categories( array( 'taxonomy' => $category_name	));
		if($get_category <> ''){
			foreach( $get_category as $category ){
				if(isset($category)){
					$category_list[$category->term_id] = $category->name;
				}
			}
		}
			
		return $category_list;
		
	}else{
		//$category_list = array( '0' =>'All');
		$parent_id = get_term_by('name', $parent, $category_name);
		$get_category = get_categories( array( 'taxonomy' => $category_name, 'child_of' => $parent_id->term_id	));
		$category_list = array( '0' => $parent );
		if($get_category <> ''){
			foreach( $get_category as $category ){
				if(isset($category)){
					$category_list[$category->term_id] = $category->name;
				}
			}
		}
			
		return $category_list;		
	
	}
}

$choices = array('yes' => 'Yes', 'no' => 'No');
$reverse_choices = array('no' => 'No', 'yes' => 'Yes');
$dec_numbers = array('0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1' );



//Default wordpress post category
$category = get_category_list_index('category');
//WooCommerce taxonomy
if(class_exists('Woocommerce')){
	$product_cat = get_category_list_index('product_cat');
}else{
	$product_cat = array();
}
//Check Main Function is exist
if(class_exists('function_library')){
	$team_category = get_category_list_index('team-category');
	$testimonial_category = get_category_list_index('testimonial-category');
	//$portfolio_category = get_category_list_index('portfolio-category');
}else{
	$team_category = array();
	$testimonial_category = array();
	$portfolio_category = array();
}
if(class_exists('EM_Events')){
	$event_name = get_title_list_index('event');
}

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path = CP_TINYMCE_DIR . '/css/font-awesome.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	$icons[$match[1]] = $match[2];
}

$checklist_icons = array ( 'icon-check' => '\f00c', 'icon-star' => '\f006', 'icon-angle-right' => '\f105', 'icon-asterisk' => '\f069', 'icon-remove' => '\f00d', 'icon-plus' => '\f067' );

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);

/*-----------------------------------------------------------------------------------*/
/*	Alert
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'crunchpress'),
			'desc' => __('Click an icon to select, click again to deselect', 'crunchpress'),
			'options' => $icons
		),
		
		'color_light' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Gradient Color', 'crunchpress'),
			'desc' => 'Set color tune of alert background! Gradient Alert Light Color'
		),
		
		'color_dark' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Gradient Color', 'crunchpress'),
			'desc' => 'Set color tune of alert background! Gradient Alert Dark Color'
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Alert Content', 'crunchpress' ),
			'desc' => __( 'Insert the alert\'s content', 'crunchpress' ),
		),
	),
	'shortcode'=>'[alert icon="{{icon}}" color_light="{{color_light}}" color_dark="{{color_dark}}" ]{{content}}[/alert]',
	'popup_title' => __( 'Alert Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Blog
/*-----------------------------------------------------------------------------------*/
$cp_shortcodes['blog'] = array(
	'no_preview' => true,
	'params' => array(

		'number_posts' => array(
			'type' => 'select',
			'label' => __( 'Number of Posts', 'crunchpress' ),
			'desc' => __( 'Select number of posts per page', 'crunchpress' ),
			'options' => cp_shortcodes_range( 25, true, true )
		),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'crunchpress' ),
			'desc' => __( 'Select name of category you want to fetch, and in shortcode it will paste id of selected category', 'crunchpress' ),
			'options' => $category,
		),
		
		'title' => array(
			'std' => 'Blog Title',
			'type' => 'text',
			'label' => __('Blog Title', 'crunchpress'),
			'desc' => __('Header or Blog Title of the listing.', 'crunchpress')
		),
		
		'thumbnail' => array(
			'type' => 'select',
			'label' => __( 'Thumbnail', 'crunchpress' ),
			'desc' => __( 'Yes or No', 'crunchpress' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			
			)
		),
				
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of excerpt words', 'crunchpress'),
			'desc' => __('50words to 250words', 'crunchpress')
		),
			
		'paging' => array(
			'type' => 'select',
			'label' => __( 'Pagination', 'crunchpress' ),
			'desc' => __( 'Yes or No', 'crunchpress' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			
			)
		
		),
	),
	'shortcode'=>'[blog number_posts="{{number_posts}}" cat_id="{{cat_id}}" title="{{title}}" thumbnail="{{thumbnail}}" excerpt_words="{{excerpt_words}}" paging="{{paging}}"][/blog]',
	'popup_title' => __( 'Blog Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Headline
/*-----------------------------------------------------------------------------------*/
$cp_shortcodes['heading'] = array(
	'no_preview' => true,
	'params' => array(
		
		'align' => array(
			'type' => 'select',
			'label' => __( 'Alignment', 'crunchpress' ),
			'desc' => __( 'Left, Right, Center', 'crunchpress' ),
			'options' => array(
				'left' => 'Left',
				'right' => 'Right',
				'center' => 'Center',
			)
		),
		
		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Add Title', 'crunchpress'),
			'desc' => __('Add title for element here.', 'crunchpress')
		),
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'crunchpress' ),
			'desc' => __( 'Select Heading Size', 'crunchpress' ),
			'options' => array(
				'h1' => 'H1',
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4',
				'h5' => 'H5',
				'h6' => 'H6',
			)
		),
		
		'description' => array(
			'std' => 'Description Or Sub Text',
			'type' => 'text',
			'label' => __('Sub Heading or Description', 'crunchpress'),
			'desc' => __('Add short sub heading or description under heading.', 'crunchpress')
		),
		
	),
	'shortcode'=>'[heading align="{{align}}" title="{{title}}" size="{{size}}" description="{{description}}"][/heading]',
	'popup_title' => __( 'Element Header and Sub Text', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Checklist
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['checklist'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select CheckList Icon', 'crunchpress'),
			'desc' => __('Click an icon to select, click again to deselect', 'crunchpress'),
			'options' => $icons
		),
		
		'iconcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Icon Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
	),	
	'shortcode'=>'[checklist icon="{{icon}}" iconcolor="{{iconcolor}}"]&lt;ul&gt;{{child_shortcode}}&lt;/ul&gt;[/checklist]',
	'popup_title' => __( 'Checklist Shortcode', 'crunchpress' ),
	
	'child_shortcode' => array(
		'params' => array(		
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Content', 'crunchpress' ),
				'desc' => __( '', 'crunchpress' ),
			),
		),
		'shortcode' => '&lt;li&gt;{{content}}&lt;/li&gt;',
		'clone_button' => __('Add List Item', 'crunchpress')
	),
);

/*-----------------------------------------------------------------------------------*/
/*	Button
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['buttons'] = array(
	'no_preview' => true,
	'params' => array(

		
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'crunchpress'),
			'desc' => __('Click an icon to select, click again to deselect', 'crunchpress'),
			'options' => $icons
		),
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'crunchpress' ),
			'desc' => __( 'Select button size', 'crunchpress' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		
		'target' => array(
			'type' => 'select',
			'label' => __( 'target', 'crunchpress' ),
			'desc' => __( '_self, _blank', 'crunchpress' ),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank',
			
			),
		),
			
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'crunchpress'),
			'desc' => __('Add the button\'s url ex: http://example.com', 'crunchpress')
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Alert Content', 'crunchpress' ),
			'desc' => __( 'Insert the alert\'s content', 'crunchpress' ),
		),
	),
	'shortcode'=>'[button icon="{{icon}}" size="{{size}}" backgroundcolor="{{backgroundcolor}}" color="{{color}}" target="{{target}}" link="{{link}}"]{{content}}[/button]',
	'popup_title' => __( 'Button Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Text
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['text'] = array(
	'no_preview' => true,
	'params' => array(
	
		'align' => array(
			'type' => 'select',
			'label' => __( 'Test Align', 'crunchpress' ),
			'desc' => __( 'left , right , center , justify', 'crunchpress' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'justify' => 'justify',
			
			)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert the content', 'crunchpress' ),
		),
	),
	'shortcode'=>'[text align="{{align}}"]{{content}}[/text]',
	'popup_title' => __( 'Text Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	IconSet -> skipped
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Event Circle Counter
/*-----------------------------------------------------------------------------------*/
$cp_shortcodes['event_circle_counter'] = array(
	'no_preview' => true,
	'params' => array(
	
		'event_id' => array(
			'type' => 'select',
			'label' => __( 'Event Name', 'crunchpress' ),
			'desc' =>  __( 'Select event name to fetch its id.', 'crunchpress' ),
			'options' => $event_name
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'crunchpress'),
			'desc' => 'Selcet Text Color'
		),
		'unfilled_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Unfilled Color', 'crunchpress'),
			'desc' => 'Select The Unfilled Color In Event Circle'
		),
		
		'filled_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Filled Color', 'crunchpress'),
			'desc' => 'Select The Filled Color In Event Circle'
		),
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Width in Number', 'crunchpress'),
			'desc' => __('e.g 500', 'crunchpress')
		),
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Height in Number', 'crunchpress'),
			'desc' => __('e.g 350', 'crunchpress')
		),
		
		'circle_width_filled' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Circle Width of Filled Event Circle', 'crunchpress'),
			'desc' => __('e.g 1.2 ', 'crunchpress')
		),
		
		'circle_width_unfilled' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Circle Width of UnFilled Event Circle', 'crunchpress'),
			'desc' => __('e.g 0.01 to 0.1 ', 'crunchpress')
		),
		
	
	),
	'shortcode'=>'[event_counter event_id="{{event_id}}" color="{{color}}" unfilled_color="{{unfilled_color}}" filled_color="{{filled_color}}" circle_width_filled="{{circle_width_filled}}" circle_width_unfilled="{{circle_width_unfilled}}" width="{{width}}" height="{{height}}"][/event_counter]',
	'popup_title' => __( 'Event Counter Shortcode', 'crunchpress' )
);


/*-----------------------------------------------------------------------------------*/
/*	Event Counter Box
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['event_counter_box'] = array(
	'no_preview' => true,
	'params' => array(

		'event_id' => array(
			'type' => 'select',
			'label' => __( 'Event Name', 'crunchpress' ),
			'desc' =>  __( 'Select event name to fetch its id.', 'crunchpress' ),
			'options' => $event_name
		),
		
	),
	'shortcode'=>'[event_counter_box event_id="{{event_id}}"][/event_counter_box]',
	'popup_title' => __( 'Event Counter box Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Content Box
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['content_box'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'crunchpress'),
		),
		
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'crunchpress'),
			'desc' => __('Click an icon to select, click again to deselect', 'crunchpress'),
			'options' => $icons
		),
		
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color for text', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Content Box Content', 'crunchpress' ),
		),
		
		
	),
	'shortcode'=>'[content_box title="{{title}}" icon="{{icon}}" backgroundcolor="{{backgroundcolor}}" color="{{color}}"]{{content}}[/content_box]',
	'popup_title' => __( 'Content Box Shortcode', 'crunchpress' )
);
/*-----------------------------------------------------------------------------------*/
/*	Counters Circle
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['columns'] = array(
	'no_preview' => true,
	'params' => array(
		'col' => array(
			'type' => 'select',
			'label' => __( 'Column', 'crunchpress' ),
			'desc' =>  __( 'Choose column width from dropdown.', 'crunchpress' ),
			'options' => array(
				'1/1' => 'Full Column',
				'1/2' => 'Half Column',
				'1/3' => 'One Third Column',
				'1/4' => 'One Forth Column',
				'2/3' => 'Two Third Column',
				'3/4' => 'Three Forth Column',
			)
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( '', 'crunchpress' ),
		),
		
	),
	
	'shortcode'=>'[column col="{{col}}"]{{content}}[/column]',
	'popup_title' => __( 'Counters Circle Shortcode', 'crunchpress' ),
);


/*-----------------------------------------------------------------------------------*/
/*	Counters Circle
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['counters_circle'] = array(
	'no_preview' => true,
	'params' => array(
		/*
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( '', 'crunchpress' ),
		),*/
	),
	
	
	'shortcode'=>'[counters_circle]{{child_shortcode}}[/counters_circle]',
	'popup_title' => __( 'Counters Circle Shortcode', 'crunchpress' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
		'filledcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Filled Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
			),
		'unfilledcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('UnFilled Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
			),
		'percent' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Percent in Number', 'crunchpress'),
			'desc' => __('0 To 100', 'crunchpress')
			),
			
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( '', 'crunchpress' ),
			),
		),

		'shortcode'=>'[counter_circle filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}" percent="{{percent}}"]{{content}}[/counter_circle]',
		'clone_button' => __('Add Counter Circle', 'crunchpress')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	DropCap
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params' => array(

		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Filled Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
			),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Word to DropCap', 'crunchpress' ),
		),
	),
	'shortcode'=>'[dropcap color="{{color}}"]{{content}}[/dropcap]',
	'popup_title' => __( 'DropCap Shortcode', 'crunchpress' )
);
	
/*-----------------------------------------------------------------------------------*/
/*	Full Width
/*-----------------------------------------------------------------------------------*/

$cp_shortcodes['full_width'] = array(
	'no_preview' => true,
	'params' => array(

		'textalign' => array(
			'type' => 'select',
			'label' => __( 'Test Align', 'crunchpress' ),
			'desc' => __( 'left , right , center , justify', 'crunchpress' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'justify' => 'justify',
			
			)
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color of text', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
			
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),

		'backgroundimage' => array(
				'type' => 'uploader',
				'label' => __('Background Image', 'crunchpress'),
				'desc' => __('Upload the Background image', 'crunchpress'),
			),
		
		'backgroundrepeat' => array(
			'type' => 'select',
			'label' => __( 'Background Repeat', 'crunchpress' ),
			'desc' => __( 'no-repeat, repeat', 'crunchpress' ),
			'options' => array(
				'repeat' => 'repeat',
				'no-repeat' => 'no-repeat',
			)
		),
		
		'backgroundposition' => array(
			'type' => 'select',
			'label' => __( 'Background Position', 'crunchpress' ),
			'desc' => __( 'left , right , top , bottom', 'crunchpress' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'top' => 'top',
				'bottom' => 'bottom',
			
			)
		),
		'backgroundattachment' => array(
			'type' => 'select',
			'label' => __( 'Background Attachment', 'crunchpress' ),
			'desc' => __( 'scroll, fixed', 'crunchpress' ),
			'options' => array(
				'scroll' => 'scroll',
				'fixed' => 'fixed',
			)
		),

		'bordersize' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Size of Border', 'crunchpress'),
			'desc' => __('From 1px to 10px', 'crunchpress')
		),
		
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Border Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		
		'paddingtop' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Padding Top in pixels', 'crunchpress'),
			'desc' => __('from 1px to 100px', 'crunchpress')
		),
		
		'paddingbottom' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Padding Bottom in pixels', 'crunchpress'),
			'desc' => __('from 1px to 100px', 'crunchpress')
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert content', 'crunchpress' ),
		),
	),
	
	'shortcode'=>'[fullwidth textalign="{{textalign}}" color="{{color}}" backgroundcolor="{{backgroundcolor}}" backgroundimage="{{backgroundimage}}" backgroundrepeat="{{backgroundrepeat}}" backgroundposition="{{backgroundposition}}" backgroundattachment="{{backgroundattachment}}" bordersize="{{bordersize}}" bordercolor="{{bordercolor}}" paddingtop="{{paddingtop}}" paddingbottom="{{paddingbottom}}"]{{content}}[/fullwidth]',
	'popup_title' => __( 'Full_width Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Flex Slider
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['flexslider'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __( 'Select Layout', 'crunchpress' ),
			'desc' => __( 'Select the type of Layout', 'crunchpress' ),
			'options' => array(
				'posts' => 'posts',
				'posts-with-excerpt' => 'posts-with-excerpt',
				'attachments' => 'attachments',
			)
		),
		'excerpt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Excerpt Length', 'crunchpress'),
			'desc' => __('From 250 to Onwards', 'crunchpress')
		),
		
		'category' => array(
			'type' => 'select',
			'label' => __( 'Category', 'crunchpress' ),
			'desc' => __( 'Select the Category For FlexSlider', 'crunchpress' ),
			'options' => array(
				'cat-1' => 'Category',
				'cat-2' => 'Category',
				'cat-3' => 'Category',
			)
		),
		
		'limit' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Select the Limit', 'crunchpress'),
			'desc' => __('3 to onwards', 'crunchpress')
		),
		
		'id' => array(
			'type' => 'select',
			'label' => __( 'ID', 'crunchpress' ),
			'desc' => __( 'Select the ID', 'crunchpress' ),
			'options' => array(
				'id-1' => 'id',
				'id-2' => 'id',
				'id-3' => 'id',
			)
		),
		
		'lightbox' => array(
			'type' => 'select',
			'label' => __( 'Light Box', 'crunchpress' ),
			'desc' => __( 'Lightbox Yes, or No(only works with attachments layout)', 'crunchpress' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			)
		),
		
		
	),
	'shortcode'=>'[flexslider layout="{{layout}}" excerpt="{{excerpt}}" category="{{category}}" limit="{{limit}}" id="{{id}}" lightbox="{{lightbox}}"][/flexslider]',
	'popup_title' => __( 'FlexSlider Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Font Awesome
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['fontawesome'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'crunchpress'),
			'desc' => __('Click an icon to select, click again to deselect', 'crunchpress'),
			'options' => $icons
		),
		
		'circle' => array(
			'type' => 'select',
			'label' => __( 'Circle', 'crunchpress' ),
			'desc' => __( 'Font required in circle', 'crunchpress' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			)
		),
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Select The Size', 'crunchpress' ),
			'desc' => __( 'Select the size of the icon', 'crunchpress' ),
			'options' => array(
				'large' => 'large',
				'medium' => 'medium',
				'small' => 'small'
			)
		),
		'iconcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Icon Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		
		'circlecolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Circle Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		
		'circlebordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Circle Border Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
	),
	'shortcode'=>'[fontawesome icon="{{icon}}" circle="{{circle}}" size="{{size}}" iconcolor="{{iconcolor}}" circlecolor="{{circlecolor}}" circlebordercolor="{{circlebordercolor}}"]',
	'popup_title' => __( 'FontAwesome Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Google Map
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['google_map'] = array(
	'no_preview' => true,
	'params' => array(
		'latitude' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Latitude of your desired location', 'crunchpress'),
			'desc' => __('Add the Latitude example : eiffel tower latitude  (48.8582)', 'crunchpress')
		),
		
		'longitude' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Longitude of your desired location', 'crunchpress'),
			'desc' => __('Add the Latitude example : eiffel tower longitude (2.2945)', 'crunchpress')
		),
		
		'maptype' => array(
			'type' => 'select',
			'label' => __( 'Select type of the map', 'crunchpress' ),
			'desc' => __( 'Select Type of the map to display', 'crunchpress' ),
			'options' => array(
				'ROADMAP' => 'Roadmap',
				'SATELLITE' => 'Satellite',
				'HYBRID' => 'Hybrid',
				'TERRAIN'=> 'Terrain',
			)
		),
		
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Width of the map', 'crunchpress'),
			'desc' => __('Width of the map in pixel or percentage e.g 500px, 100% ', 'crunchpress')
		),
		
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Height of the map', 'crunchpress'),
			'desc' => __('Height of the map in pixel or percentage e.g 500px, 100% ', 'crunchpress')
		),
		'zoom' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Zoom of the map', 'crunchpress'),
			'desc' => __('set zoom level of the map e.g 14 ', 'crunchpress')
		),

	),
	'shortcode'=>'[map latitude="{{latitude}}" longitude="{{longitude}}" maptype="{{maptype}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}"][/map]',
	'popup_title' => __( 'Google_Map Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Highlight
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['highlight'] = array(
	'no_preview' => true,
	'params' => array(
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content to be highlighted', 'crunchpress' ),
			'desc' => __( 'Insert content to highlight', 'crunchpress' ),
		),
	),
	'shortcode'=>'[highlight color="{{color}}"]{{content}}[/highlight]',
	'popup_title' => __( 'Highlight Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Sidebar
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['sidebar'] = array(
	'no_preview' => true,
	'params' => array(
		
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('select Name', 'crunchpress'),
			'desc' => __('Select the name of the sidebar e.g Footer ', 'crunchpress')
		),
		
	),
	'shortcode'=>'[sidebar name="{{name}}"]',
	'popup_title' => __( 'Sidebar Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Image Frame
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['image_frame'] = array(
	'no_preview' => true,
	'params' => array(
	
		'style' => array(
			'type' => 'select',
			'label' => __( 'Select Style', 'crunchpress' ),
			'desc' => __( 'Select Style of the image frame', 'crunchpress' ),
			'options' => array(
				'border' => 'border',
				'glow' => 'glow',
				'border' => 'border',
				'dropshadow' => 'dropshadow',
				'bottomshadow'=> 'bordershadow'
			)
		),
		
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Border Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'bordersize' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Select Border Size', 'crunchpress'),
			'desc' => __('Select size of the border e.g 1px to 10px ', 'crunchpress')
		),
		'stylecolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Style Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'align' => array(
			'type' => 'select',
			'label' => __( 'Select Alignment', 'crunchpress' ),
			'desc' => __( 'left , right , top , bottom', 'crunchpress' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'top' => 'top',
				'bottom' => 'bottom',
			
			)
		),
		'content' => array(
				'type' => 'uploader',
				'label' => __('Select Image', 'crunchpress'),
				'desc' => __('Upload the image', 'crunchpress'),
				'alt' => __('Image Description', 'crunchpress'),
			),	
	),
	'shortcode'=>'[imageframe style="{{style}}" bordercolor="{{bordercolor}}" bordersize="{{bordersize}}" stylecolor="{{stylecolor}}" align="{{align}}"]{{content}}[/imageframe]',
	'popup_title' => __( 'Image_frame Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Images Carousel
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['image_carousel'] = array(
	'no_preview' => true,
	'params' => array(
	
		'lightbox' => array(
			'type' => 'select',
			'label' => __( 'Lightbox', 'crunchpress' ),
			'desc' => __( 'Yes or No', 'crunchpress' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			
			)
		),
		'gallery_id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Select Gallery Id', 'crunchpress'),
			'desc' => __('Select the id of the gallery ', 'crunchpress')
		),
		
	),
	'shortcode'=>'[images lightbox="{{lightbox}}" gallery_id="{{gallery_id}}"][/images]',
	'popup_title' => __( 'Images_Carousel Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Lightbox
/*-----------------------------------------------------------------------------------*/	

$cp_shortcodes['lightbox'] = array(
	'no_preview' => true,
	'params' => array(
	
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Select Title', 'crunchpress'),
			'desc' => __('Select the title of the Lightbox ', 'crunchpress')
		),
		
		'href' => array(
			'type' => 'uploader',
			'label' => __('Select Full Image', 'crunchpress'),
			'desc' => __('Upload large image this image will shown in lightbox.', 'crunchpress'),
		),
		
		'src' => array(
			'type' => 'uploader',
			'label' => __('Small Thumbnail', 'crunchpress'),
			'desc' => __('Upload small thumbnail that will appear as small image.', 'crunchpress'),
		),
		
		'margin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Margin', 'crunchpress'),
			'desc' => __('Give Margin e.g 1px to 25px', 'crunchpress')
		),
		'align' => array(
			'type' => 'select',
			'label' => __( 'Select Alignment', 'crunchpress' ),
			'desc' => __( 'left , right , center, none', 'crunchpress' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'none' => 'none',			
			)
		)
	),
	'shortcode'=>'[lightbox title="{{title}}" href="{{href}}" src="{{src}}" margin="{{margin}}" align="{{align}}"][/lightbox]',
	'popup_title' => __( 'Lightbox Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Circle
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['progress_circle'] = array(
	'no_preview' => true,
	'params' => array(

		'value' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Value', 'crunchpress'),
			'desc' => __('Give value from 0 to 100', 'crunchpress')
		),
		
		'filledcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Filled Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'unfilledcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select UnFilled Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert the content', 'crunchpress' ),
		),
	),
	'shortcode'=>'[counter_circle value="{{value}}" filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}"]{{content}}[/counter_circle]',
	'popup_title' => __( 'Progress Circle Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Bar
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['progress_bar'] = array(
	'no_preview' => true,
	'params' => array(

		'percentage' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Percentage', 'crunchpress'),
			'desc' => __('Give percentage from 0 to 100', 'crunchpress')
		),
	
		'type' => array(
			'type' => 'select',
			'label' => __( 'Select Type', 'crunchpress' ),
			'desc' => __( 'Select the type of Progress Bar', 'crunchpress' ),
			'options' => array(
				'progress-info' => 'progress-info',
				'progress-success' => 'progress-success',
				'progress-warning' => 'progress-warning',
				'progress-danger' => 'progress-danger',
			)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert the content', 'crunchpress' ),
		),	
	),
	'shortcode'=>'[progress_bar percentage="{{percentage}}" type="{{type}}"]{{content}}[/progress_bar]',
	'popup_title' => __( 'Progress Bar Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Person
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['person'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Select Type', 'crunchpress' ),
			'desc' => __( 'Select the type of Person', 'crunchpress' ),
			'options' => array(
				'default' => 'default',
				'team-boxed' => 'team-boxed',
				'team-circle' => 'team-circle',
			)
		),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Name of the Person', 'crunchpress'),
			'desc' => __('e.g John Doe', 'crunchpress')
		),
		'picture' => array(
				'type' => 'uploader',
				'label' => __('Image of the person', 'crunchpress'),
				'desc' => __('Upload the Person image', 'crunchpress'),
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Designation', 'crunchpress'),
			'desc' => __('e.g Developer', 'crunchpress')
		),
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Facebook URL', 'crunchpress'),
			'desc' => __('Add the facebook address ex: http://facebook.com', 'crunchpress')
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Twitter URL', 'crunchpress'),
			'desc' => __('Add the twitter address ex: http://twitter.com', 'crunchpress')
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('LinkedIn URL', 'crunchpress'),
			'desc' => __('Add the LinkedIn address ex: http://linkedin.com', 'crunchpress')
		),
		'dribbble' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Dribbble URL', 'crunchpress'),
			'desc' => __('Add the Dribbble address ex: http://dribbble.com', 'crunchpress')
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL', 'crunchpress'),
			'desc' => __('Add the url ex: http://example.com', 'crunchpress')
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert the content', 'crunchpress' ),
		),	

	),
	'shortcode'=>'[person type="{{type}}" name="{{name}}" picture="{{picture}}" title="{{title}}" facebook="{{facebook}}" twitter="{{twitter}}" linkedin="{{linkedin}}" dribbble="{{dribbble}}" link="{{link}}"]{{content}}[/person]',
	'popup_title' => __( 'Person  Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	3D Button
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['3D_button'] = array(
	'no_preview' => true,
	'params' => array(
		
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'crunchpress'),
			'desc' => __('Click an icon to select, click again to deselect', 'crunchpress'),
			'options' => $icons
		),
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'crunchpress' ),
			'desc' => __( 'Select button size', 'crunchpress' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL Here', 'crunchpress'),
			'desc' => __('Add the url ex: http://example.com', 'crunchpress')
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Text Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Select Target', 'crunchpress' ),
			'desc' => __( '_blank or _self', 'crunchpress' ),
			'options' => array(
				'_blank' => '_blank',
				'_self' => '_self',
				
			)
		),
		'content' => array(
			'std' => 'Your Button Text Goes Here',
			'type' => 'textarea',
			'label' => __( 'Button Text', 'crunchpress' ),
			'desc' => __( 'Insert the Button Text', 'crunchpress' ),
		),	
		
	),
	'shortcode'=>'[3dbutton icon="{{icon}}" size="{{size}}" link="{{link}}" backgroundcolor="{{backgroundcolor}}" target="{{target}}" textcolor="{{textcolor}}"]{{content}}[/3dbutton]',
	'popup_title' => __( '3D Button  Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Metro Button
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['metro_button'] = array(
	'no_preview' => true,
	'params' => array(
	
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'crunchpress'),
			'desc' => __('Click an icon to select, click again to deselect', 'crunchpress'),
			'options' => $icons
		),
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'crunchpress' ),
			'desc' => __( 'Select button size', 'crunchpress' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL Here', 'crunchpress'),
			'desc' => __('Add the url ex: http://example.com', 'crunchpress')
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Select Target', 'crunchpress' ),
			'desc' => __( '_blank or _self', 'crunchpress' ),
			'options' => array(
				'_blank' => '_blank',
				'_self' => '_self',
			
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Text Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'content' => array(
			'std' => 'Your Button Text Goes Here',
			'type' => 'textarea',
			'label' => __( 'Button Text', 'crunchpress' ),
			'desc' => __( 'Insert the Button Text', 'crunchpress' ),
		),	
		
	),
	'shortcode'=>'[metro_button icon="{{icon}}" size="{{size}}" link="{{link}}" target="{{target}}" backgroundcolor="{{backgroundcolor}}" textcolor="{{textcolor}}"]{{content}}[/metro_button]',
	'popup_title' => __( 'Metro_Button  Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Pricing Table
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['pricing_table'] = array(
	'no_preview' => true,
	'params' => array(

		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Border Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'dividercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Divider Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'columns' => array(
			'type' => 'select_col',
			'label' => __('Number of Columns', 'crunchpress'),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'&lt;br /&gt;[column col=&quot;1/1&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;' => '1 Column',				
				'&lt;br /&gt;[column col=&quot;1/2&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/2&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;' => '2 Column',
				'&lt;br /&gt;[column col=&quot;1/3&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/3&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/3&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;' => '3 Column',
				'&lt;br /&gt;[column col=&quot;1/4&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/4&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/4&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/4&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;' => '4 Column',
			)
		)
	),
	'shortcode' => '[pricing_table backgroundcolor="{{backgroundcolor}}" bordercolor="{{bordercolor}}" dividercolor="{{dividercolor}}"]{{columns}}[/pricing_table]',
	'popup_title' => __( 'Pricing Table Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Projects
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['recent_projects'] = array(
	'no_preview' => true,
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __( 'Alert Type', 'crunchpress' ),
			'desc' => __( 'Select the type of alert message', 'crunchpress' ),
			'options' => array(
				'carousel' => 'carousel',
				'grid-with-filters' => 'grid-with-filters',
				'grid' => 'grid',
			)
		),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select The Category ID', 'crunchpress' ),
			'desc' =>  __( 'Choose the category ID', 'crunchpress' ),
			'options' => $choices
		),
		'number_posts' => array(
			'type' => 'select',
			'label' => __( 'Number of Posts', 'crunchpress' ),
			'desc' => __( 'Select number of posts per page', 'crunchpress' ),
			'options' => cp_shortcodes_range( 25, true, true )
		),
		
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Excerpt Words', 'crunchpress'),
			'desc' => __('Select the number of excerpt words', 'crunchpress')
		),
		
	),
	'shortcode'=>'[recent_projects layout="{{layout}}" cat_id="{{cat_id}}" number_posts="{{number_posts}}" excerpt_words="{{excerpt_words}}"][/recent_projects]',
	'popup_title' => __( 'Recent Projects  Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Services
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['services'] = array(
	'no_preview' => true,
	'params' => array(
	
		'layout' => array(
			'type' => 'select',
			'label' => __( 'Select the layout Type', 'crunchpress' ),
			'desc' => __( 'Select the type of alert message', 'crunchpress' ),
			'options' => array(
				'circle-icon-top' => 'circle-icon-top',
				'box-icon-top' => 'box-icon-top',
				'box-icon-left' => 'box-icon-left',
				'circle-icon-left' => 'circle-icon-left',
			)
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'crunchpress'),
			'desc' => __('Click an icon to select, click again to deselect', 'crunchpress'),
			'options' => $icons
		),
		
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Text', 'crunchpress'),
			'desc' => __('Add the title', 'crunchpress')
		),
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Excerpt Words', 'crunchpress'),
			'desc' => __('Select the number of excerpt words', 'crunchpress')
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link', 'crunchpress'),
			'desc' => __('Add the url ex: http://example.com', 'crunchpress')
		),
		'linktext' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link Text Words', 'crunchpress'),
			'desc' => __('Read More Text', 'crunchpress')
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert the content', 'crunchpress' ),
		),
	),
	'shortcode'=>'[services layout="{{layout}}" icon="{{icon}}" title="{{title}}" excerpt_words="{{excerpt_words}}" link="{{link}}" linktext="{{linktext}}"]{{content}}[/services]',
	'popup_title' => __( 'Services Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Posts
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['recent_posts'] = array(
	'no_preview' => true,
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __( 'Select Layout', 'crunchpress' ),
			'desc' => __( 'Select the layout option', 'crunchpress' ),
			'options' => array(
				'default' => 'Default',
				'thumbnails-on-side' => 'Thumbnails-on-side',
			)
		),
		'columns' => array(
			'type' => 'select',
			'label' => __( 'Select Column', 'crunchpress' ),
			'desc' => __( 'Select the column option', 'crunchpress' ),
			'options' => array(
				'1-1' => '1-1',
				'1-4' => '1-4',
			)
		),
		
		'number_posts' => array(
			'type' => 'select',
			'label' => __( 'Number of Posts', 'crunchpress' ),
			'desc' => __( 'Select number of posts', 'crunchpress' ),
			'options' => cp_shortcodes_range( 25, true, true )
		),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Categories', 'crunchpress' ),
			'desc' => __( 'Select a category or leave blank for all', 'crunchpress' ),
			'options' => $category
		),
		
		'thumbnail' => array(
			'type' => 'select',
			'label' => __( 'Thumbnail', 'crunchpress' ),
			'desc' => __( 'Yes or No', 'crunchpress' ),
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No',
			
			)
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Text', 'crunchpress'),
			'desc' => __('Add Title Here', 'crunchpress')
		),
		'post_meta' => array(
			'type' => 'select',
			'label' => __( 'Post Meta', 'crunchpress' ),
			'desc' => __( 'Yes or No (Author, comments, date etc.)', 'crunchpress' ),
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No',
			
			)
		),
		'excerpt' => array(
			'type' => 'select',
			'label' => __( 'Show Excerpt', 'crunchpress' ),
			'desc' => __( 'Yes or No', 'crunchpress' ),
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No',
			
			)
		),
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of Characters', 'crunchpress'),
			'desc' => __('Add number of characters eg. 100 to 400', 'crunchpress')
		),
		
	),
	'shortcode'=>'[recent_posts layout="{{layout}}" columns="{{columns}}" number_posts="{{number_posts}}" cat_id="{{cat_id}}" thumbnail="{{thumbnail}}" title="{{title}}" post_meta="{{post_meta}}" excerpt="{{excerpt}}" excerpt_words="{{excerpt_words}}"][/recent_posts]',
	'popup_title' => __( 'Recent Posts Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	SoundCloud
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['sound-cloud'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Type of Embed', 'crunchpress' ),
			'desc' => __( 'Select the type of Embed', 'crunchpress' ),
			'options' => array(
				'visual-embed' => 'Visual Embed',
				'classic-embed' => 'Classic Embed',
			)
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL of Sound Cloud', 'crunchpress'),
			'desc' => __('Add the url example: https://api.soundcloud.com/tracks/142314548', 'crunchpress')
		),
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'auto_play' => array(
			'type' => 'select',
			'label' => __( 'AutoPlay', 'crunchpress' ),
			'desc' => __( 'True or False', 'crunchpress' ),
			'options' => array(
				'true' => 'true',
				'false' => 'false',
			
			)
		),
		'hide_related' => array(
			'type' => 'select',
			'label' => __( 'Hide Related', 'crunchpress' ),
			'desc' => __( 'True or False', 'crunchpress' ),
			'options' => array(
				'true' => 'true',
				'false' => 'false',
			
			)
		),
		'show_artwork_or_visual' => array(
			'type' => 'select',
			'label' => __( 'Show Artwork or Visual', 'crunchpress' ),
			'desc' => __( 'True or False', 'crunchpress' ),
			'options' => array(
				'true' => 'true',
				'false' => 'false',
			
			)
		),
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Set Width', 'crunchpress'),
			'desc' => __('Set The Width in percent e.g 100%', 'crunchpress')
		),
		
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Set Height', 'crunchpress'),
			'desc' => __('Set The Height e.g 150px', 'crunchpress')
		),
		
		'iframe' => array(
			'type' => 'select',
			'label' => __( 'Use Iframe', 'crunchpress' ),
			'desc' => __( 'True or False', 'crunchpress' ),
			'options' => array(
				'true' => 'true',
				'false' => 'false',
			
			)
		),

	),
	'shortcode'=>'[soundcloud type="{{type}}" url="{{url}}" color="{{color}}" auto_play="{{auto_play}}" hide_related="{{hide_related}}" show_artwork_or_visual="{{show_artwork_or_visual}}" width="{{width}}" height="{{height}}" iframe="{{iframe}}" /]',
	'popup_title' => __( 'SoundCloud Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Slider
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['slider'] = array(
	'no_preview' => true,
	'params' => array(

		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Set Width', 'crunchpress'),
			'desc' => __('Set The Width in percent e.g 100%', 'crunchpress')
		),
		
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Set Height', 'crunchpress'),
			'desc' => __('Set The Height e.g 150px', 'crunchpress')
		),

	),
	'shortcode'=>'[slider width="{{width}}" height="{{height}}"]{{child_shortcode}}[/slider]',
	'popup_title' => __( 'Slider Shortcode', 'crunchpress' ),
	'child_shortcode' => array(
		'params' => array(
		
			'slider_type' => array(
				'type' => 'select',
				'label' => __( 'Select Type', 'crunchpress' ),
				'desc' => __( 'Select the type of slider eg. image, video(Selecting Video link options as well as light box will be deactivate)', 'crunchpress' ),
				'options' => array(
					'image' => 'Image',
					'video' => 'Video',
				)
			),
			
			'image_url' => array(
				'type' => 'uploader',
				'label' => __('Upload Image', 'crunchpress'),
				'desc' => __('Upload the slider image', 'crunchpress'),
			),
			
			'image_target' => array(
				'type' => 'select',
				'label' => __( 'Select Target', 'crunchpress' ),
				'desc' => __( '_blank or _self (work only with image!)', 'crunchpress' ),
				'options' => array(
					'_blank' => '_blank',
					'_self' => '_self',
				
				)
			),
			'image_lightbox' => array(
				'type' => 'select',
				'label' => __( 'Select Link Type', 'crunchpress' ),
				'desc' => __( 'Select the type of image to open in lightbox or link to anyother target (work only with image!)', 'crunchpress' ),
				'options' => array(
					'yes' => 'Yes',
					'no' => 'No',
				)
			),
			
			'image_content' => array(
				'type' => 'uploader',
				'label' => __('Upload Image', 'crunchpress'),
				'desc' => __('Upload the slider image', 'crunchpress'),
			),
						
			'video_content' => array(
				'std' => 'Your Shortcode Goes Here',
				'type' => 'textarea',
				'label' => __( 'Add Shortcode Here', 'crunchpress' ),
				'desc' => __( 'Add Video here', 'crunchpress' ),
			),
		),

		'shortcode'=> '[slide type="{{type}}" link="{{image_url}}" target="{{image_target}}" lightbox="{{image_lightbox}}"]{{content}}[/slide]',
		'clone_button' => __('Add Another Slide', 'crunchpress')
	)
		
);

/*-----------------------------------------------------------------------------------*/
/*	Separator
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['separator'] = array(
	'no_preview' => true,
	'params' => array(

		'margin_top_bottom' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Margin From Top and Bottom', 'crunchpress'),
			'desc' => __('Give number from 20px to 50px', 'crunchpress')
		),
		
		'size' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add size of separator', 'crunchpress'),
			'desc' => __('Give number from 1px to 10px', 'crunchpress')
		),
		
		'style' => array(
			'type' => 'select',
			'label' => __( 'Select The Style', 'crunchpress' ),
			'desc' => __( 'Select the style of seperator', 'crunchpress' ),
			'options' => array(
				'none' => 'none',
				'solid' => 'solid',
				'double' => 'double',
				'dashed' => 'dashed',
				'dotted' => 'dotted',
				'ridge' => 'ridge',
			)
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
	),
	'shortcode'=>'[separator margin_top_bottom="{{margin_top_bottom}}" size ="{{size}}" style="{{style}}" color="{{color}}"]',
	'popup_title' => __( 'Separator Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['tabs'] = array(
	'no_preview' => true,
	'params' => array(

	),
	//'shortcode'=>'[tab]<br>[tab_item title="ITEM_TITLE"]ADD_CONTENT_HERE[/tab_item]<br>[tab_item title="ITEM_TITLE"]ADD_CONTENT_HERE[/tab_item]<br>[tab_item title="ITEM_TITLE"]ADD_CONTENT_HERE[/tab_item]<br>[/tab]<br /> <br />',
	'shortcode'=>'[tab]{{child_shortcode}}[/tab]',
	'popup_title' => __( 'Tabs Shortcode', 'crunchpress' ),
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
		
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Set Title', 'crunchpress'),
				'desc' => __('Item Title', 'crunchpress')
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Your Item Content Here', 'crunchpress' ),
				'desc' => __( 'Item Content', 'crunchpress' ),
			),
		),

		'shortcode'=> '[tab_item title="{{title}}"]{{content}}[/tab_item]',
		'clone_button' => __('Add Another Tab', 'crunchpress')
	)
);


/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['accordion'] = array(
	'no_preview' => true,
	'params' => array(
		
	),
	
	'shortcode'=> '[accordion]{{child_shortcode}}[/accordion]',
	'popup_title' => __( 'accordion Shortcode', 'crunchpress' ),
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Item 1',
				'type' => 'text',
				'label' => __('Set Title', 'crunchpress'),
				'desc' => __('Item Title', 'crunchpress')
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Your Item Content Here', 'crunchpress' ),
				'desc' => __( 'Item Content', 'crunchpress' ),
			),
		),
		'shortcode'=>'[acc_item title="{{title}}"]{{content}}[/acc_item]',
		'clone_button' => __('Add Another Accordian Tab', 'crunchpress')
			
	),
	
);

/*-----------------------------------------------------------------------------------*/
/*	Testimonials
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['testimonials'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __( 'Select Type', 'crunchpress' ),
			'desc' => __( 'Select testimonial type from dropdown.', 'crunchpress' ),
			'options' => array(
				'slider' => 'Testimonial Slider',
				'grid' => 'Testimonial Grid',
			
				)
		),
	),
	//'shortcode'=>'[testimonials]<br />[testimonial name="John Doe" picture="image path" company="My Company" link="" target=""]"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consec tetur, adipisci velit, sed quia non numquam eius modi tempora incidunt utis labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minimas veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur slores amet untras vel illum qui."[/testimonial]<br />[testimonial name="John Doe" picture="image path" company="My Company" link="" target=""]"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consec tetur, adipisci velit, sed quia non numquam eius modi tempora incidunt utis labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minimas veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur slores amet untras vel illum qui."[/testimonial]<br />[/testimonials]',
	
	'shortcode'=>'[testimonials type="{{type}}"]{{child_shortcode}}[/testimonials]',
	'popup_title' => __( 'Testimonials Shortcode', 'crunchpress' ),
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'name' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Name of person', 'crunchpress'),
				'desc' => __('Add Name', 'crunchpress')
			),
			'picture' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Image Path', 'crunchpress'),
				'desc' => __('Add Image Path  ex: http://example.com', 'crunchpress')
			),
			'company' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Company Name', 'crunchpress'),
				'desc' => __('Add Company Name Here', 'crunchpress')
			),
			'link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Image link', 'crunchpress'),
				'desc' => __('Add Image link here  ex: http://example.com', 'crunchpress')
			),
			
			'target' => array(
				'type' => 'select',
				'label' => __( 'Select Target', 'crunchpress' ),
				'desc' => __( '_blank or _self', 'crunchpress' ),
				'options' => array(
					'_blank' => '_blank',
					'_self' => '_self',
				
				)
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Content', 'crunchpress' ),
				'desc' => __( 'Insert the content', 'crunchpress' ),
			),
		),

		'shortcode'=> '[testimonial name="{{name}}" picture="{{picture}}" company="{{company}}" link="{{link}}" target="{{target}}"]{{content}}[/testimonial]',
		'clone_button' => __('Add Testimonial', 'crunchpress')
	),
);

/*-----------------------------------------------------------------------------------*/
/*	Testimonial
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['testimonial'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Select the type', 'crunchpress' ),
			'desc' => __( 'Select the type of alert message', 'crunchpress' ),
			'options' => array(
				'default' => 'default',
				'custom-style' => 'custom-style',
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'crunchpress'),
			'desc' => 'Leave blank for default'
		),
		'name' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Name of person', 'crunchpress'),
				'desc' => __('Add Name', 'crunchpress')
		),
		'picture' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Image Path', 'crunchpress'),
			'desc' => __('Add Image Path  ex: http://example.com', 'crunchpress')
		),
		'company' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Company Name', 'crunchpress'),
			'desc' => __('Add Company Name Here', 'crunchpress')
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Image link', 'crunchpress'),
			'desc' => __('Add Image link here  ex: http://example.com', 'crunchpress')
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Select Target', 'crunchpress' ),
			'desc' => __( '_blank or _self', 'crunchpress' ),
			'options' => array(
				'_blank' => '_blank',
				'_self' => '_self',
			
			)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert the content', 'crunchpress' ),
		),
		
	),
	
	'shortcode'=>'[testimonial type="{{type}}" backgroundcolor="{{backgroundcolor}}" name="{{name}}" picture="{{picture}}" company="{{company}}" link="{{link}}" target="{{target}}"]{{content}}[/testimonial]',
	'popup_title' => __( 'Testimonial Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Title
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['title'] = array(
	'no_preview' => true,
	'params' => array(

		'size' => array(
			'type' => 'select',
			'label' => __( 'Heading Size', 'crunchpress' ),
			'desc' => __( 'Select the Heading', 'crunchpress' ),
			'options' => array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
			)
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert the content', 'crunchpress' ),
		),
	),
	'shortcode'=>'[title size="{{size}}"]{{content}}[/title]',
	'popup_title' => __( 'Title Shortcode', 'crunchpress' )
);


/*-----------------------------------------------------------------------------------*/
/*	Tooltip
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Text for Tooltip', 'crunchpress'),
			'desc' => __('Text to appear as tooltip', 'crunchpress')
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'crunchpress' ),
			'desc' => __( 'Insert the content', 'crunchpress' ),
		),
	),
	'shortcode'=>'[tooltip title="{{title}}"]{{content}}[/tooltip]',
	'popup_title' => __( 'Tooltip Shortcode', 'crunchpress' )
);


/*-----------------------------------------------------------------------------------*/
/*	Table
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['table'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __('Type', 'crunchpress'),
			'desc' => __('Select the table style', 'crunchpress'),
			'options' => array(
				'1' => 'Style 1',
				'2' => 'Style 2',
			)
		),
		'columns' => array(
			'type' => 'select',
			'label' => __('Number of Columns', 'crunchpress'),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'1' => '1 Column',
				'2' => '2 Columns',
				'3' => '3 Columns',
				'4' => '4 Columns'
			)
		)
	),
	'shortcode' => '',
	'popup_title' => __( 'Table Shortcode', 'crunchpress' )
);
/*-----------------------------------------------------------------------------------*/
/*	Vimeo
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['vimeo'] = array(
	'no_preview' => true,
	'params' => array(

		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Width Here', 'crunchpress'),
			'desc' => __('Add the Width for your video ex: 600px', 'crunchpress')
		),
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add height Here', 'crunchpress'),
			'desc' => __('Add the height for your video ex: 350px', 'crunchpress')
		),
		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Video URL', 'crunchpress'),
			'desc' => __('Add the Video url ex: http://vimeo.com/93120068', 'crunchpress')
		),
		
	),
	'shortcode'=>'[vimeo width="{{width}}" height="{{height}}"]{{content}}[/vimeo]',
	'popup_title' => __( 'Vimeo Shortcode', 'crunchpress' )
);


/*-----------------------------------------------------------------------------------*/
/*	Woo Products
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['woo_products'] = array(
	'no_preview' => true,
	'params' => array(

		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select the ID', 'crunchpress' ),
			'desc' =>  __( 'Choose to Category ID', 'crunchpress' ),
			'options' => $product_cat
		),
		
		'number_posts' => array(
			'type' => 'select',
			'label' => __( 'Number of posts to show', 'crunchpress' ),
			'desc' => __( 'Select number of posts', 'crunchpress' ),
			'options' => cp_shortcodes_range( 25, true, true )
		),
		
		'show_price' => array(
			'type' => 'select',
			'label' => __( 'Show Price', 'crunchpress' ),
			'desc' => __( 'Yes or No', 'crunchpress' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			)
		),
		'show_buttons' => array(
			'type' => 'select',
			'label' => __( 'Show Buttons', 'crunchpress' ),
			'desc' => __( 'Yes or No', 'crunchpress' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			)
		),
	),
	'shortcode'=>'[products_slider cat_id="{{cat_id}}" number_posts="{{number_posts}}" show_price="{{show_price}}" show_buttons="{{show_buttons}}"]',
	'popup_title' => __( 'Woo_Products Shortcode', 'crunchpress' )
);

/*-----------------------------------------------------------------------------------*/
/*	Youtube
/*-----------------------------------------------------------------------------------*/	
$cp_shortcodes['youtube'] = array(
	'no_preview' => true,
	'params' => array(

		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add width of the video', 'crunchpress'),
			'desc' => __('Add the width example : 600px', 'crunchpress')
		),
		
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add height of the video', 'crunchpress'),
			'desc' => __('Add the height example : 350px', 'crunchpress')
		),
		
		'content' => array(
			'std' => 'Enter URL here',
			'type' => 'text',
			'label' => __( 'Youtube URL', 'crunchpress' ),
			'desc' => __( 'Insert the url', 'crunchpress' ),
		),
	),
	'shortcode'=>'[youtube width="{{width}}" height="{{height}}"]{{content}}[/youtube]',
	'popup_title' => __( 'youtube Shortcode', 'crunchpress' )
);
