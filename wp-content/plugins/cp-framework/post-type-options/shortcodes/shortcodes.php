<?php
if(class_exists('function_library')){
	
	class cp_shortcode extends function_library{
		
		public $div_start = array(
		
			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-minus"),
				
			"top-bar-div227-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div227'),				
			
			'select-type'=>array(

				'title'=>'Select Full Layout',

				'name'=>'page-option-item-full-width',

				'type'=> 'combobox',
				
				'default'=> 'Plain',

				'options'=>array('0'=>'Background Image', '1'=>'Background Color', '2'=>'Plain'),

				'hr'=> 'none',

				'description'=>'Select background type image color or plain without any background.'),	
				
			"image" => array(

				'title'=> 'Background Image',

				'name'=>'page-option-item-image-cp',
				
				'class'=> 'enable-image-class',

				'type'=>'upload',

				'description'=>'Select Background Image to show as parallax image.'),	
				
			"background-attachment" => array(

				'title'=> 'Background Attachment',

				'name'=>'page-option-position-bg-cp',

				'type'=> 'combobox',
				
				'options'=>array('0'=>'Scroll', '1'=>'Fixed'),
				
				'class'=> 'enable-image-class',
				
				'default' => 'Scroll',

				'description'=>'Select Backgrond Attachment.'),	
			
			"top-bar-div227-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div227'),	
			
			"top-bar-div228-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div228'),				
			
			"color" => array(

				'title'=> 'Background Color',

				'name'=>'page-option-item-color-cp',

				'type'=>'inputtext',
				
				'class'=> 'enable-color-class',
				
				'default' => '#000000',

				'description'=>'Select Background Image to show as parallax image.'),	
			
			"padding-top" => array(

				'title'=> 'Padding Top',

				'name'=>'page-option-padding-top-cp',

				'type'=>'inputtext',
				
				'class'=> 'enable-padding-class',
				
				'default' => '10px',

				'description'=>'Add Section Top Padding in Pixels.'),
			
			"padding-bottom" => array(

				'title'=> 'Padding Bottom',

				'name'=>'page-option-padding-bottom-cp',

				'type'=>'inputtext',
				
				'class'=> 'enable-padding-class',
				
				'default' => '10px',

				'description'=>'Add Section Bottom Padding in Pixels.'),	
			
			"top-bar-div228-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div228'),	
				

		);
		
		public $div_end = array(
		
		
			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-minus"),
				

		);
	
		public $service_variable = array(

			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-building"),
				
			"top-bar-div24-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div24'),
			
			"FontAwesome" => array(

				'title'=> 'Font Awesome Class',

				'name'=>'page-option-item-column-service-font',
				
				'class'=>'enable-font-class',

				'type'=>'inputtext',
				
				'default'=> 'fa fa-exclamation-circle',

				'description'=>'Add Font Awesome class name here for example this is the class code "fa fa-exclamation-circle" you can get this class from http://fortawesome.github.io/Font-Awesome/icons/'),
				
			'title'=>array(

				'title'=> 'TITLE',

				'name'=> 'page-option-item-column-service-title',

				'type'=> 'inputtext'),	
				
				
			'text'=>array(

				'title'=> 'Services Description',

				'name'=> 'page-option-cp-service-text',

				'type'=> 'textarea',
				
				'description'=>'You can place any text, html or shortcode here.',

				'hr'=> 'none'),		
				
			"top-bar-div24-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div24'),
			
			"top-bar-div25-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div25'),
			
			'service-layout'=>array(

				'title'=>'Select Service layout',

				'name'=>'page-option-item-service-layout',

				'type'=> 'combobox',
				
				'default'=> 'Layout 1',

				'options'=>array('0'=>'Layout 1', '1'=>'Layout 2'),

				'hr'=> 'none',

				'description'=>'Please select your desire services layout.'),	
				
			'morelink'=>array(

				'title'=>'Url',

				'name'=> 'page-option-item-column-service-link',
				
				'class'=> 'enable-image-class',
				
				'description'=>'Add Read more button.',

				'type'=> 'inputtext'),	
			
			"top-bar-div25-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div25'),

		);

				
		public $accordion_var = array(
		
		
			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-tasks"),
				
			"top-bar-div26-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div26'),	

			'header'=>array(

				'title'=> 'HEADER TITLE',

				'name'=> 'page-option-item-accordion-header-title',

				'type'=> 'inputtext'),

			'tab-item'=>array(

				'tab-num'=>'page-option-item-accordion-num',

				'title'=>'page-option-item-accordion-title',

				'caption'=>'page-option-item-accordion-content',

				'active'=>'',

				'hr'=>'none'),
			
			"top-bar-div26-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div26'),		

		);
		
		
		public $sidebar_section = array(
		
			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-list-alt"),
				
			"top-bar-div126-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div126'),

			'sidebar-layout-select'=>array(

				'title'=>'Select Widget Area',

				'name'=>'page-option-select-sidebar-layout',

				'type'=> 'combobox',

				'options'=>array(),

				'hr'=> 'none',

				'description'=>'Select Widget area from Dropdown it will fetch all available widget areas those available in Dashboard >  Appearance > Widget.'),
			
			"top-bar-div26-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div26'),		

		);


		public $column_var = array(
		
			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-columns"),
				
			"top-bar-div27-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div27'),	

			'column-text'=>array(

				'title'=> 'Column Text',

				'name'=> 'page-option-item-column-text',

				'type'=> 'textarea',
				
				'class'=> 'cp-full-width',
				
				'description'=>'Use Textarea for HTML and Shortcodes it will help you to manage the columns as well.',

				'hr'=> 'none'),
				
			"top-bar-div27-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div27'),	
			
			// "top-bar-div227-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div227'),	
			
			// 'full-width'=>array(

				// 'title'=>'Select Full Layout',

				// 'name'=>'page-option-item-full-width',

				// 'type'=> 'combobox',
				
				// 'default'=> 'Disable Full Layout',

				// 'options'=>array('0'=>'Background Image', '1'=>'Background Color', '2'=>'Disable Full Layout'),

				// 'hr'=> 'none',

				// 'description'=>'Enable/Disable full width view of element, select background color or Image also selecting disable full layout remain the same in same container.'),	
				
			// "image" => array(

				// 'title'=> 'Background Image',

				// 'name'=>'page-option-item-image-cp',
				
				// 'class'=> 'enable-image-class',

				// 'type'=>'upload',

				// 'description'=>'Select Background Image to show as parallax image.'),	
			
			// "color" => array(

				// 'title'=> 'Background Color',

				// 'name'=>'page-option-item-color-cp',

				// 'type'=>'inputtext',
				
				// 'class'=> 'enable-color-class',
				
				// 'default' => '#000000',

				// 'description'=>'Select Background Image to show as parallax image.'),	
			
			// "top-bar-div227-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div227'),

		);


		public $divider_var = array(
		
		
			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-minus"),
				
			"top-bar-div28-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div28'),		
			
			'hide-bottom-top'=>array(

				'title'=>'ENABLE / DISABLE BOTTOM TO TOP BUTTON',

				'name'=>'page-option-item-divider-bottom',

				'type'=> 'combobox',

				'options'=>array('0'=>'Yes', '1'=>'No'),

				'hr'=> 'none',

				'description'=>'Selecting Yes Bottom to top icon will appear selecting No it will disappear.'),
				
			"margin-top" => array(

				'title'=> 'MARGIN TOP',

				'name'=>'page-option-margin-top-cp',

				'type'=>'inputtext',
				
				'class'=> 'enable-margin-class',
				
				'default' => '10px',

				'description'=>'Add Section Top margin in Pixels.'),
			
			"margin-bottom" => array(

				'title'=> 'MARGIN BOTTOM',

				'name'=>'page-option-margin-bottom-cp',

				'type'=>'inputtext',
				
				'class'=> 'enable-margin-class',
				
				'default' => '10px',

				'description'=>'Add Section Bottom margin in Pixels.'),	
				
			"top-bar-div28-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div28'),
				

		);

		public $tab_variable = array(
		
		
			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-th"),	
				
			"top-bar-div29-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div29'),
		
			'tab-layout-select'=>array(

				'title'=>'Select Tab Layout',

				'name'=>'page-option-item-tab-layout',

				'type'=> 'combobox',

				'options'=>array('0'=>'Horizontal', '1'=>'Vertical'),

				'hr'=> 'none',

				'description'=>'Disable bottom to top text from divider.'),

			 'tab-widget'=>array(

				'title'=> 'Tab Widget Title',

				'name'=> 'page-option-item-tab-widget',

				'type'=> 'inputtext'),

			'tab-item'=>array(

				'tab-num'=>'page-option-item-tab-num',

				'title'=>'page-option-item-tab-title',

				'caption'=>'page-option-item-tab-content',

				'active'=>'',

				'hr'=>'none'),
				
			"top-bar-div29-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div29'),	

		);				

		public $toggle_box = array(

			'image_icon' =>array(

				'type'=> 'image','name'=> '',

				'hr'=> 'none',

				'description'=> "fa fa-list"),	

			"top-bar-div30-open" => array( 'name'=>'div_start','type'=>'open' ,'class'=>'row-fluid','id'=>'cp-top-bar-div30'),
			
			'header'=>array(

				'title'=> 'HEADER TITLE',

				'name'=> 'page-option-item-toggle-box-header-title',

				'type'=> 'inputtext'),

			'tab-item'=>array(

				'tab-num'=>'page-option-item-toggle-box-num',

				'title'=>'page-option-item-toggle-box-title',

				'caption'=>'page-option-item-toggle-box-content',

				'active'=>'page-option-item-toggle-box-active',

				'hr'=>'none'),
				
			"top-bar-div30-close" => array( 'name'=>'div_end','type'=>'close','id'=>'cp-top-bar-div30'),		

		);
	
		
		public $toggle_size_array = array(
			'element1-4'=>'1/4',

			'element1-3'=>'1/3',

			'element1-2'=>'1/2',

			'element2-3'=>'2/3',

			'element3-4'=>'3/4',

			'element1-1'=>'1/1');
		
		public $tab_size_array = array(
			'element1-4'=>'1/4',

			'element1-3'=>'1/3',

			'element1-2'=>'1/2',

			'element2-3'=>'2/3',

			'element3-4'=>'3/4',

			'element1-1'=>'1/1');	
		
		public $divider_size_array = array('element1-1'=>'1/1');
		
		public $div_start_size = array('element1-1'=>'1/1');
		public $div_end_size = array('element1-1'=>'1/1');
		
		public $column_size_array = array(
			'element1-4'=>'1/4',

			'element1-3'=>'1/3',

			'element1-2'=>'1/2',

			'element2-3'=>'2/3',

			'element3-4'=>'3/4',

			'element1-1'=>'1/1');
		
		public $accordion_size_array = array(
			'element1-4'=>'1/4',

			'element1-3'=>'1/3',

			'element1-2'=>'1/2',

			'element2-3'=>'2/3',

			'element3-4'=>'3/4',

			'element1-1'=>'1/1');
		
		public $sidebar_size_array = array(
			'element1-4'=>'1/4',

			'element1-3'=>'1/3',

			'element1-2'=>'1/2',

			'element2-3'=>'2/3',

			'element3-4'=>'3/4',

			'element1-1'=>'1/1');		
		
		public $service_size_array = array(
			'element1-4'=>'1/4',

			'element1-3'=>'1/3',

			'element1-2'=>'1/2',

			'element2-3'=>'2/3',

			'element3-4'=>'3/4',

			'element1-1'=>'1/1');	
			
		public function page_builder_size_class(){
		global $div_size;
			//$div_size['Toggle-Box'] = $this->toggle_size_array;	  
			$div_size['Tab'] = $this->tab_size_array;	  
			$div_size['Divider'] = $this->divider_size_array;	  
			$div_size['Column'] = $this->column_size_array;	  
			$div_size['Accordion'] = $this->accordion_size_array;	  
			$div_size['Services'] = $this->service_size_array;	 
			$div_size['Sidebar'] = $this->sidebar_size_array;
			$div_size['Division_Start'] = $this->div_start_size;
			$div_size['Division_End'] = $this->div_end_size;
		}
		
		
		public function page_builder_element_class(){
		global $page_meta_boxes;
			//$page_meta_boxes['Page Item']['name']['Toggle-Box'] = $this->toggle_box;
			$page_meta_boxes['Page Item']['name']['Tab'] = $this->tab_variable;
			$page_meta_boxes['Page Item']['name']['Divider'] = $this->divider_var;
			$page_meta_boxes['Page Item']['name']['Column'] = $this->column_var;
			$page_meta_boxes['Page Item']['name']['Accordion'] = $this->accordion_var;
			$page_meta_boxes['Page Item']['name']['Services'] = $this->service_variable;
			$page_meta_boxes['Page Item']['name']['Sidebar'] = $this->sidebar_section;
			$page_meta_boxes['Page Item']['name']['Sidebar']['sidebar-layout-select']['options'] = get_sidebar_name();
			$page_meta_boxes['Page Item']['name']['Division_Start'] = $this->div_start;
			$page_meta_boxes['Page Item']['name']['Division_End'] = $this->div_end;
		}
	
	}
	
	$cp_shortcode = new cp_shortcode;
}


?>