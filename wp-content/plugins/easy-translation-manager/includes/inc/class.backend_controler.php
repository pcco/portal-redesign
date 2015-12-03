<?php
class easy_translation_manager_backend_controler {
	
	var $current_languashed = '';
	var $allow_post_meta = true;
	var $current_screen = '';
	var $count = 0;
	var $not_allow = array('_ajax_nonce','metakeyselect','metakeyinput','metavalue','_ajax_nonce-add-meta','advanced_view','comment_status','ping_status','add_comment_nonce','_ajax_fetch_list_nonce','post_name','post_author_override','post_mime_type','ID','post_parent','_wpnonce','_wp_http_referer','user_ID','action','originalaction','post_author','post_type','original_post_status','referredby','_wp_original_http_referer','post_ID','meta-box-order-nonce','closedpostboxesnonce','samplepermalinknonce','content','ETMCUSTOMSAVE','wp-preview','hidden_post_status','post_status','hidden_post_password','hidden_post_visibility','visibility','post_password','mm','jj','aa','hh','mn','ss','hidden_mm','cur_mm','hidden_jj','cur_jj','hidden_aa','cur_aa','hidden_hh','cur_hh','hidden_mn','cur_mn','original_publish','save','parent_id','page_template','menu_order','meta','post_category','newcategory','_ajax_nonce-add-category','tax_input','newtag','excerpt','trackback_url','post_excerpt','to_ping','current_featured','current_visibility','woocommerce_meta_nonce','ETMSAVE','ETMCUSTOMSAVE','ETMCUSTOMSAVESELECTOR','ect_tran_title','ect_tran_content','etm_content_excerpts','ETMCUSTORETURNLINK');
	function easy_translation_manager_backend_controler(){
		global $easy_translation_manager_plugin;
		if(!empty($_GET['ETMSAVE'])){
			$this->current_languashed = $_GET['ETMSAVE'];	
		}
		if(!empty($_POST['ETMSAVE'])){
			$this->current_languashed = $_POST['ETMSAVE'];	
		}
		if(!empty($_GET['ETMCUSTOMSAVE'])){
			$this->current_languashed = $_GET['ETMCUSTOMSAVE'];	
		}
		if(!empty($_POST['ETMCUSTOMSAVE'])){
			$this->current_languashed = $_POST['ETMCUSTOMSAVE'];	
		}

		if(!empty($this->current_languashed)){	
			if(!empty($_POST)){
				if(isset($_POST['post_title'])){
					$_POST['ect_tran_title'] = $_POST['post_title'];
					unset($_POST['post_title']);
				}
		
				if(isset($_POST['content'])){
					$_POST['ect_tran_content'] = $_POST['content'];	
					unset($_POST['content']);
				}	
				if(isset($_POST['post_content'])){
					$_POST['ect_tran_content'] = $_POST['post_content'];	
					unset($_POST['post_content']);
				}
				if(isset($_POST['excerpt'])){
					$_POST['etm_content_excerpts'] = $_POST['excerpt'];	
					unset($_POST['excerpt']);
				}				
				if(isset($_POST['post_excerpt'])){
					$_POST['etm_content_excerpts'] = $_POST['post_excerpt'];	
					unset($_POST['post_excerpt']);
				}		
			}
			
			add_filter( 'title_edit_pre', array(&$this,'get_title'), 999999, 2);
			add_filter( 'content_edit_pre', array(&$this,'get_content'),999999,2); 
	    	add_filter( 'excerpt_edit_pre',array(&$this,'post_the_excerpt'),0,2);
			add_filter( 'get_post_metadata', array(&$this,'get_metadata'), 1, 4 );
			
			add_filter( 'attachment_fields_to_edit', array(&$this,'wp_get_attachment_metadata'), 1, 4 );
			add_action( 'save_post', array(&$this,'save_post'),2 );
			add_filter('get_sample_permalink_html', array( &$this, 'perm'), '',4);
		}
		
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_box' ) );
		add_filter( 'manage_posts_columns' , array(&$this,'manage_posts_columns') );
		add_action( 'manage_posts_custom_column' , array(&$this,'manage_posts_custom_column'), 10, 2 );
		add_filter( 'manage_pages_columns' , array(&$this,'manage_posts_columns') );
		add_action( 'manage_pages_custom_column' , array(&$this,'manage_posts_custom_column'), 10, 2 );
			
		add_action('init',array(&$this,'init'));
		add_action( 'admin_notices', array(&$this,'my_admin_notice') );
	}
	
    

    function perm($return, $id, $new_title, $new_slug){
        global $post;
        
        $ret2 = preg_replace('/<span id="edit-slug-buttons">.*<\/span>/i', '<span id="edit-slug-buttons"><a class="button button-small" href="#" title="'.__('This feature is still under development for other languages than the default language.','etm').'" alt="'.__('This feature is still under development for other languages than the default language.','etm').'" disabled="disabled" onclick="return false" >'.__('edit').'</a></span>', $return);
        return $ret2;
    }
	
	
	/* ------------------------------- Metabox functioner ------------------------------- */
	/* ---------------------------------------------------------------------------------- */
	
	function add_meta_box(){
		if($this->current_screen('edit')){
			$post_types = get_post_types( '', 'names' ); 
			if(!empty($post_types)){
				foreach ( $post_types as $post_type ) {
					if($post_type != 'attachment'){
						add_meta_box('easy_translation_manager_lang','Enabled Languages',array(&$this,'metabox'),$post_type,'side','high');	
					}				
				}
			}
		}
	}	
	
	function metabox($post=0){
		global $easy_translation_manager_plugin,$wpdb;
		
		echo '<input type="hidden" name="ETMCUSTOMSAVE" value="'.$this->current_languashed.'">';
		echo '<input type="hidden" name="ETMCUSTORETURNLINK" value="'.etm_query_arg_add(array()).'">';


		$lang_list = etm_tools_retrive_languages_data(etm_tools_retrive_aktiv_languages(),true);
		if(!empty($this->current_languashed)){
			$lang_current = etm_tools_retrive_languages_data(array($this->current_languashed=>'2'),true);
		}
		 
		 
		echo '<div style="display: block; width: auto; text-align: center; margin-bottom: 20px; margin-top: 20px;">';
		
		if(!empty($lang_current)){
			$lang_current = $lang_current[0];
			
			$style_hide_content = array('#slugdiv','#postcustom','#postimagediv');
			$style_remove_objects = array('#commentsdiv','#trackbacksdiv','#revisionsdiv','#commentstatusdiv','#authordiv','#formatdiv','#tagsdiv-post_tag','#pageparentdiv');
			
			
			if(!empty($post->ID)){
				$taxonomy_names = get_object_taxonomies( get_post_type( $post->ID ));
	 			if(!empty($taxonomy_names)){
		 			foreach($taxonomy_names as $taxonomy_name){
			 			array_push($style_remove_objects, '#'.$taxonomy_name.'div');
			 		}
	 			}			
			}

			
			
			echo '<style>';
			foreach($style_hide_content as $tmp){
				echo $tmp.'.postbox .inside:before {content: "'.__('This feature is still under development for other languages than the default language.','etm').'";display: block;}';
				echo $tmp.'.postbox .inside a,'.$tmp.'.postbox .inside b,'.$tmp.'.postbox .inside div,'.$tmp.'.postbox .inside input,'.$tmp.'.postbox .inside select,'.$tmp.'.postbox .inside p,'.$tmp.'.postbox .inside label {display:none;}';
			}
			
			foreach($style_remove_objects as $tmp){
				echo $tmp.'.postbox div,'.$tmp.'.postbox h3 {display: none;}';
				echo $tmp.'.postbox {background:none;border: none;box-shadow: none;}';
				
			}
			
			echo '</style>';


			
			
			
			
			
			
			
			$current_is_translatet = false;
			
			
			if(!empty($post->ID)){
				$myrows = $wpdb->get_var( "SELECT RIGHT(meta_key,2) as translatet  FROM ".$wpdb->postmeta." WHERE post_id=".$post->ID." and (meta_key = 'ect_tran_content_".$this->current_languashed."' or meta_key = 'etm_content_excerpts_".$this->current_languashed."' or meta_key = 'ect_tran_title_".$this->current_languashed."') group by translatet");
				if(!empty($myrows)){
					$current_is_translatet = true;
				}
			}
			echo '<div style="font-size: 13px; margin-bottom: 5px;">'.__('Active','etm').'</div>';

			echo '<img class="icon_lang_'.$lang_current['code'].'" style="opacity:'.(!empty($current_is_translatet) == true ? '1.0':'0.5').';width: auto; height: 80px; display: block; margin-left: auto; margin-right: auto;" title="'.$lang_current['org_name'] . ' ('. $lang_current['english_name'] . ')" src="'.etm_tools_create_icons_url($lang_current['icon'],3).'"></a>';
			
		} else {
			echo '<div style="font-size: 13px; margin-bottom: -15px;">'.__('Select language to translate','etm').'</div>';
		}
		
		echo '</div>';
		echo $this->etm_tools_check_lang_createstring($lang_list,$this->current_languashed,$easy_translation_manager_plugin->curPageURL(),$post->ID);
		
		if(!empty($this->current_languashed)){
			echo '<div onclick="if(confirm(\'Are you sure that you want to delete all translations for current lang\')){window.open(\''.etm_query_arg_add(array('ETMDELETEPOST'=>$this->current_languashed)).'\',\'_self\');}" style="margin-top: 15px;width: 100%;" class="button">Delete Active Translation</div>';
			
echo '<a href="'.etm_query_arg_add(array('ETMSAVE'=>'')).'" style="width:100%;margin-top: 5px;" class="button button-primary">'.__('Back to default language','etm').'</a>';

			
			
			//echo '<div onclick="if(confirm(\'Are you sure that you want to delete all meta translations for current lang\')){window.open(\''.etm_query_arg_add(array('ETMDELETEPOSTMETA'=>$this->current_languashed)).'\',\'_self\');}" style="width: 100%; margin-top: 5px;" class="button">Delete Only Meta Translation</div>';	
		}


	}
	
	/* --------------------------------- List functioner -------------------------------- */
	/* ---------------------------------------------------------------------------------- */
		
	function manage_posts_custom_column( $column, $post_id ) {
		if ($column == 'etmlang'){
			$admin_url = admin_url('post.php?post='.$post_id.'&action=edit');
			$languashed = etm_tools_retrive_languages_data(etm_tools_retrive_aktiv_languages(),true);
			echo $this->etm_tools_check_lang_createstring($languashed,'',$admin_url,$post_id,24,'text-align: left');
		}
	}
	
	function manage_posts_columns( $columns ) {
		return array_merge( $columns, array( 'etmlang' => __( 'Active Languages', 'etm' ) ) );
	}
	
	/* ------------------------------ Controler functioner ------------------------------ */
	/* ---------------------------------------------------------------------------------- */
	
	function my_admin_notice() {
		if(!empty($_GET['ETMSTATUS'])){
		    ?>
		    <div class="updated">
		        <p><?php echo __( 'Translation has been deleted!', 'etm' ).' - '.$_GET['ETMSTATUS'] ?></p>
		    </div>
		    <?php
	    }
	}
	
	
	function init(){
		
		if(!empty($_GET['ETMDELETEPOSTMETA']) || !empty($_GET['ETMDELETEPOST'])){
			$return = 'Faild';
			if(!empty($_GET['ETMDELETEPOST'])) {
				$return_a = $this->removePostTranslation($_GET['ETMDELETEPOST']);
				$return_b = $this->removePostMetaTranslation($_GET['ETMDELETEPOST']);
				
				if(!empty($return_a) && !empty($return_b)){
					$return = 'Successful';
				}
			} else if(!empty($_GET['ETMDELETEPOSTMETA'])) {
				$return = $this->removePostMetaTranslation($_GET['ETMDELETEPOSTMETA']);
				
				if(!empty($return)){
					$return = 'Successful';
				}
			} 
			
			wp_redirect(etm_query_arg_add(array('ETMSTATUS'=>$return,'ETMSTATUSTYPE'=>(!empty($_GET['ETMDELETEPOSTMETA'])== true?'ETMDELETEPOSTMETA':'ETMDELETEPOST'))));
			die();		
		}		
	}
	
	function removePostTranslation($lang_id){
		global $post;
		if(empty($lang_id))return false;
		
		if(empty($post) && !empty($_GET['post'])){
			$post->ID = $_GET['post'];
		}
		
		delete_post_meta($post->ID, 'ect_tran_title_'.$lang_id);
		delete_post_meta($post->ID, 'ect_tran_content_'.$lang_id);
		delete_post_meta($post->ID, 'etm_content_excerpts_'.$lang_id);
		
		return true;			
		
	}
	
	function removePostMetaTranslation($lang_id){
		global $wpdb,$post;
		if(empty($lang_id))return false;
		
		if(empty($post) && !empty($_GET['post'])){
			$post->ID = $_GET['post'];
		}

		$myrows = $wpdb->get_results( "DELETE FROM ".$wpdb->postmeta." WHERE RIGHT(meta_key,3)='_".$lang_id."' and meta_key NOT IN ('ect_tran_title_'".$lang_id.",'ect_tran_content_'".$lang_id.",'etm_content_excerpts_'".$lang_id.") and post_id=".$post->ID );
		
		return true;	
		
	}
	
	function save_post($post_id){
		if(!empty($_POST)){
			$taxonomy_names = get_object_taxonomies( get_post_type( $post_id ));
 			if(!empty($taxonomy_names)){
	 			foreach($taxonomy_names as $taxonomy_name){
		 			array_push($this->not_allow, $taxonomy_name);
		 			array_push($this->not_allow, 'new'.$taxonomy_name);
		 			array_push($this->not_allow, $taxonomy_name.'_parent');
		 			array_push($this->not_allow, 'new'.$taxonomy_name.'_parent');
		 		}
 			}

 			global $post;
 			if(isset($_POST['ect_tran_title']) && $post->post_title != $_POST['ect_tran_title']){
 				update_post_meta($post_id, 'ect_tran_title_'.$this->current_languashed, $_POST['ect_tran_title']);
 			}
 			
 			if(isset($_POST['ect_tran_content']) && $post->post_content != $_POST['ect_tran_content']){
 				update_post_meta($post_id, 'ect_tran_content_'.$this->current_languashed, $_POST['ect_tran_content']);
 			}
 			
 			if(isset($_POST['etm_content_excerpts']) && $post->post_excerpt != $_POST['etm_content_excerpts']){
 				update_post_meta($post_id, 'etm_content_excerpts_'.$this->current_languashed, $_POST['etm_content_excerpts']);
 			}

			foreach($_POST as $t_key => $t_data){	
				if(!in_array($t_key, $this->not_allow) && substr($t_key,-3,1) != '_'){
					if($this->get_post_meta($post_id, $t_key, true) != $t_data){
						update_post_meta($post_id, $t_key.'_'.$this->current_languashed, $t_data);
					}	
				}
			}
		}
		
		wp_redirect(etm_query_arg_add(array('ETMSAVE'=>$this->current_languashed),$_POST['ETMCUSTORETURNLINK']));
		die();
		
	}
	
    function post_the_excerpt($content){
		global $post;
		
		$translatede_excerpt = $this->get_post_meta($post->ID, 'etm_content_excerpts_'.$this->current_languashed, true);
		
		if(!empty($translatede_excerpt) && $post->ID > 0){
			return $translatede_excerpt;
		} else {
			return $content;
		}  
    }	
    
    function get_post_meta($id=0,$key='',$single=true){
	    $this->allow_post_meta = false;
	    $tmp_return_data = get_post_meta($id,$key,$single);
	    $this->allow_post_meta = true;
	    return $tmp_return_data;
    }
     
	
	function get_metadata($metadata, $object_id = null, $meta_key = null, $single = null){
        if(!empty($this->allow_post_meta) && $meta_key != '_edit_lock' && $meta_key != '_edit_last' && substr($meta_key,0,4) != 'ect_' && substr($meta_key,0,4) != 'etm_'  && substr($meta_key,-3,1) != '_'){
    
           	$this->allow_post_meta = false;
           	$translations_body = '';
           	if(!empty($object_id) && !empty($meta_key) && !empty($this->current_languashed)){
				$translations_body = $this->get_post_meta($object_id,$meta_key."_".$this->current_languashed,true);
           	}
            if(!empty($translations_body)){
            
				$checked_test = @unserialize($translations_body);
				if ($checked_test !== false) {
				    $translations_body = $checked_test;
				}
            
            	if(is_array($translations_body)){
	            	$this->tmp_array_controle_tmp = $this->tmp_array_controle = array();
	            	$this->tmp_array_controle = $this->get_post_meta($object_id,$meta_key,true);
	            	
	            	if(is_array($this->tmp_array_controle)){
		            	$this->etm_g_boxes($translations_body);
	            	} else {
		            	$this->tmp_array_controle = $translations_body;
		            	$this->tmp_array_controle_tmp = $this->tmp_array_controle = array();
	            	}

	            	$translations_body_backup[0] = $this->tmp_array_controle;
            	} else {
	            	$translations_body_backup =  $translations_body;
            	}
                return $translations_body_backup;  
            }
        }
        $this->allow_post_meta = true;
        return $metadata;
    }

	
	function get_title( $content = '', $post_id = 0 ) {
		global $easy_translation_manager_plugin;
		$translatede_title = get_post_meta($post_id, 'ect_tran_title_'.$this->current_languashed,false);

		if(!empty($translatede_title) && is_array($translatede_title)){
			$content = $translatede_title[0];
		};
		
	  return $content;
	}
	
	function get_content( $content = '', $post_id = 0 ){
		global $easy_translation_manager_plugin;
		$translated_content = $this->get_post_meta($post_id, 'ect_tran_content_'.$this->current_languashed,false);
		
		if(!empty($translated_content) && is_array($translated_content)){
			$content = $translated_content[0];
		};
		
	  return $content;
	}
	
	/* -------------------------------- Extra functioner -------------------------------- */
	/* ---------------------------------------------------------------------------------- */
	
	function etm_tools_check_lang_createstring($languashed,
											   $tmp_current='',
											   $admin_url = '',
											   $post_id = '',
											   $img_size = 24,
											   $style='text-align: center')
	{
												   
		global $easy_translation_manager_plugin,$wpdb;
		$string_retun = '';
		$current_translatet = array();
		
		if(!empty($post_id)){
			$myrows = $wpdb->get_col( "SELECT RIGHT(meta_key,2) as translatet FROM ".$wpdb->postmeta." WHERE post_id=".$post_id." and (LEFT(meta_key,16) = 'ect_tran_content' or LEFT(meta_key, 20) = 'etm_content_excerpts' or LEFT(meta_key, 14) = 'ect_tran_title') group by translatet",0);
			
			if(!empty($myrows)){
				$current_translatet = array_flip($myrows);
				array_walk($current_translatet, function(&$value, $key) { $value = true; });
			}
		}

		$string_retun .= '<div style="'.$style.'">';
		foreach($languashed as $langedtemp){	
			if(empty($tmp_current) || $langedtemp['code'] != $tmp_current ){
				$tmpurl = etm_query_arg_add(array('ETMSAVE'=>$langedtemp['code']),$admin_url);
		    	$string_retun .= '<a href="'.$tmpurl.'" style="height: '.$img_size.'px; display: inline-block;"><img class="icon_lang_'.$langedtemp['code'].'" style="opacity:'.(!empty($current_translatet[$langedtemp['code']]) == true ? '1.0':'0.5').';cursor: pointer; display: inline-block; height: '.$img_size.'px; margin-right: 2px; margin-left: 2px; border-radius: 5px;" title="'.$langedtemp['org_name'] . ' ('. $langedtemp['english_name'] . ')" src="'.etm_tools_create_icons_url($langedtemp['icon'],1).'"></a>';
	    	}
		}
		$string_retun .= '</div>';
		return $string_retun;
	}
	
	function current_screen($check_page = 'edit'){
		if(empty($this->current_screen)){
			$this->current_screen = get_current_screen();
		}

		if(!empty($this->current_screen) && $this->current_screen->action == '' && $this->current_screen->base == 'post' && $check_page == 'edit'){
			return true;	
		}		
		return false;
	}	
}

if(is_admin()){
	global $easy_translation_manager_backend_controler;
	$easy_translation_manager_backend_controler = new easy_translation_manager_backend_controler();
}
