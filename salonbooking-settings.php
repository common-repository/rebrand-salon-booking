<?php
namespace BZSALON;

define('BZSALON_BASE_DIR', 	dirname(__FILE__) . '/');
define('BZSALON_PRODUCT_ID',   'BZSB');
define('BZSALON_VERSION',   	'1.0');
define('BZSALON_DIR_PATH', plugin_dir_path( __DIR__ ));
define('BZSALON_PLUGIN_FILE', 'rebrand-salon-booking/rebrand-salon-booking.php');   //Main base file
define('BZSALON_PRO_PLUGIN_FILE', 'salon-booking-plugin-pro/salon.php');   //Main PRO base file

class BZRebrandSalonBookingSettings {
		
		public $pageslug 	   = 'salon_rebrand';
	
		static public $rebranding = array();
		static public $redefaultData = array();
	
		public function init() {
		
			$blog_id = get_current_blog_id();
			
			self::$redefaultData = array(
				'plugin_name'       	=> '',
				'plugin_desc'       	=> '',
				'plugin_author'     	=> '',
				'plugin_uri'        	=> '',
				
			);
        
			
			if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			} 
	if ( is_plugin_active( 'blitz-rebrand-salon-booking-pro/blitz-rebrand-salon-booking-pro.php' ) ) {
			
			deactivate_plugins( plugin_basename(__FILE__) );
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'Plugin could not be activated, either deactivate the Lite version or Pro version', 'simplewlv' ). '</p>';
			die($error_message); 
		 
			return;
		}
			
			$this->bzsalon_activation_hooks();
		}
		
	
		
		/**
		 * Init Hooks
		*/
		public function bzsalon_activation_hooks() {
		
			global $blog_id;
	
			add_filter( 'gettext', 					array($this, 'bzsalon_update_label'), 20, 3 );
			add_filter( 'all_plugins', 				array($this, 'bzsalon_plugin_branding'), 10, 1 );
			add_action( 'admin_menu',				array($this, 'bzsalon_menu'), 100 );
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzsalon_adminloadStyles'));
			add_action( 'admin_init',				array($this, 'bzsalon_save_settings'));			
	        add_action( 'admin_head', 				array($this, 'bzsalon_branding_scripts_styles') );
	        if(is_multisite()){
				if( $blog_id == 1 ) {
					switch_to_blog($blog_id);
						add_filter('screen_settings',			array($this, 'bzsalon_hide_rebrand_from_menu'), 20, 2);	
					restore_current_blog();
				}
			} else {
				add_filter('screen_settings',			array($this, 'bzsalon_hide_rebrand_from_menu'), 20, 2);
			}
			
		}
		
	
	
	
			
		/**
		 * Add screen option to hide/show rebrand options
		*/
		public function bzsalon_hide_rebrand_from_menu($saloncurrent, $screen) {

			$rebranding = $this->bzsalon_get_rebranding();

			$saloncurrent .= '<fieldset class="admin_ui_menu"> <legend> Rebrand - '.$rebranding['plugin_name'].' </legend><p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>';

			if($this->bzsalon_getOption( 'rebrand_salon_screen_option','' )){
				
				$cartflows_screen_option = $this->bzsalon_getOption( 'rebrand_salon_screen_option',''); 
				
				if($cartflows_screen_option=='show'){

					$saloncurrent .= __('Hide the "','bzsalon').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzsalon') .$hide;
					$saloncurrent .= '<style>#adminmenu .toplevel_page_salon_forms a[href="admin.php?page='.$this->pageslug.'"]{display:block;}</style>';
				} else {
					$saloncurrent .= __('Show the "','bzsalon').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzsalon') .$show;
					$saloncurrent .= '<style>#adminmenu .toplevel_page_salon_forms a[href="admin.php?page='.$this->pageslug.'"]{display:none;}</style>';
				}		
				
			} else {
					$saloncurrent .= __('Hide the "','bzsalon').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzsalon') .$hide;
					$saloncurrent .= '<style>#adminmenu .toplevel_page_salon_forms a[href="admin.php?page='.$this->pageslug.'"]{display:block;}</style>';
			}	

			$saloncurrent .=' <br/><br/> </fieldset>' ;
			
			return $saloncurrent;
		}
		
		
		
				
		
		/**
		* Loads admin styles & scripts
		*/
		public function bzsalon_adminloadStyles(){
			
			if(isset($_REQUEST['page'])){
				
				if($_REQUEST['page'] == $this->pageslug){
				
				    wp_register_style( 'bzsalon_css', plugins_url('assets/css/bzsalon-main.css', __FILE__) );
					wp_enqueue_style( 'bzsalon_css' );
					
					wp_register_script( 'bzsalon_js', plugins_url('assets/js/bzsalon-main-settings.js', __FILE__ ), '', '', true );
					wp_enqueue_script( 'bzsalon_js' );
					
				}
			}
		}	
		
		
		
		
	   public function bzsalon_get_rebranding() {
			
			if ( ! is_array( self::$rebranding ) || empty( self::$rebranding ) ) {
				if(is_multisite()){
					switch_to_blog(1);
						self::$rebranding = get_option( 'salonbooking_rebrand');
					restore_current_blog();
				} else {
					self::$rebranding = get_option( 'salonbooking_rebrand');	
				}
			}
			return self::$rebranding;
		}
		
		
		
	    /**
		 * Render branding fields.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function bzsalon_render_fields() {
			
			$branding = get_option( 'salonbooking_rebrand');
			include BZSALON_BASE_DIR . 'admin/bzsalon-settings-rebranding.php';
		}
		
		
		
		/**
		 * Admin Menu
		*/
		public function bzsalon_menu() {
			
			global $menu, $blog_id;
			global $submenu;	
			
		    $admin_label = __('Rebrand', 'bzsalon');
			$rebranding = $this->bzsalon_get_rebranding();
			
			if ( current_user_can( 'manage_options' ) ) {

				$title = $admin_label;
				$cap   = 'manage_options';
				$slug  = $this->pageslug;
				$func  = array($this, 'bzsalon_render');
									
				if( is_multisite() ) {
					if( $blog_id == 1 ) { 
						add_submenu_page( 'salon', $title, $title, $cap, $slug, $func );
					}
				} else {
					add_submenu_page( 'salon', $title, $title, $cap, $slug, $func );
				}
			}	
			
			//~ echo '<pre/>';
			//~ print_r($submenu);
				
			foreach($menu as $custommenusK => $custommenusv ) {
				if( $custommenusK == '100' ) {
					if( isset($rebranding['plugin_name']) && $rebranding['plugin_name'] != '' ) {
						$menu[$custommenusK][0] = $rebranding['plugin_name']; //change menu Label
					}
							
				}
			}
			return $menu;
		}
		
			
		
		/**
		 * Renders to fields
		*/
		public function bzsalon_render() {
			$this->bzsalon_render_fields();
		}
		
	
		
		/**
		 * Save the field settings
		*/
		public function bzsalon_save_settings() {
			
			if ( ! isset( $_POST['salon_wl_nonce'] ) || ! wp_verify_nonce( $_POST['salon_wl_nonce'], 'salon_wl_nonce' ) ) {
				return;
			}

			if ( ! isset( $_POST['salon_submit'] ) ) {
				return;
			}
			$this->bzsalon_update_branding();
		}
		
		
		
		
		/**
		 * Include scripts & styles
		*/
		public function bzsalon_branding_scripts_styles() {
			
			global $blog_id;
			
			if ( ! is_user_logged_in() ) {
				return; 
			}
			$rebranding = $this->bzsalon_get_rebranding();
			
			//~ echo '<pre/>';
			//~ print_r($rebranding);
			
			
			echo '<style id="salon-wl-admin-style">';
			include BZSALON_BASE_DIR . 'admin/bzsalon-style.css.php';
			echo '</style>';
			
			//~ echo '<script id="salon-wl-admin-script">';
			//~ include BZSALON_BASE_DIR . 'admin/bzsalon-script.js.php';
			//~ echo '</script>';
			
		}	  
	
	

		/**
		 * Update branding
		*/
	    public function bzsalon_update_branding() {
			
			if ( ! isset($_POST['salon_wl_nonce']) ) {
				return;
			}   
			

			$data = array(
			
				'plugin_name'       => isset( $_POST['salon_wl_plugin_name'] ) ? sanitize_text_field( $_POST['salon_wl_plugin_name'] ) : '',
				
				'plugin_desc'       => isset( $_POST['salon_wl_plugin_desc'] ) ? sanitize_text_field( $_POST['salon_wl_plugin_desc'] ) : '',
				
				'plugin_author'     => isset( $_POST['salon_wl_plugin_author'] ) ? sanitize_text_field( $_POST['salon_wl_plugin_author'] ) : '',
				
				'plugin_uri'        => isset( $_POST['salon_wl_plugin_uri'] ) ? sanitize_text_field( $_POST['salon_wl_plugin_uri'] ) : '',
				
			);
				
			update_option( 'salonbooking_rebrand', $data );
		}
    
    
     
  
  
		
		/**
		 * change plugin meta
		*/  
        public function bzsalon_plugin_branding( $all_plugins ) {
			
			
			if (  ! isset( $all_plugins['salon-booking-system/salon.php'] ) ) {
				return $all_plugins;
			}
		
			$rebranding = $this->bzsalon_get_rebranding();
			
			$all_plugins['salon-booking-system/salon.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['salon-booking-system/salon.php']['Name'];
			
			$all_plugins['salon-booking-system/salon.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['salon-booking-system/salon.php']['PluginURI'];
			
			$all_plugins['salon-booking-system/salon.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['salon-booking-system/salon.php']['Description'];
			
			$all_plugins['salon-booking-system/salon.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['salon-booking-system/salon.php']['Author'];
			
			$all_plugins['salon-booking-system/salon.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['salon-booking-system/salon.php']['AuthorURI'];
			
			$all_plugins['salon-booking-system/salon.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['salon-booking-system/salon.php']['Title'];
			
			$all_plugins['salon-booking-system/salon.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['salon-booking-system/salon.php']['AuthorName'];
			
			
			if(is_plugin_active(BZSALON_PRO_PLUGIN_FILE)){
				
				$all_plugins['salon-booking-plugin-pro/salon.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['salon-booking-plugin-pro/salon.php']['Name'];
				
				$all_plugins['salon-booking-plugin-pro/salon.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['salon-booking-plugin-pro/salon.php']['PluginURI'];
				
				$all_plugins['salon-booking-plugin-pro/salon.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['salon-booking-plugin-pro/salon.php']['Description'];
				
				$all_plugins['salon-booking-plugin-pro/salon.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['salon-booking-plugin-pro/salon.php']['Author'];
				
				$all_plugins['salon-booking-plugin-pro/salon.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['salon-booking-plugin-pro/salon.php']['AuthorURI'];
				
				$all_plugins['salon-booking-plugin-pro/salon.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['salon-booking-plugin-pro/salon.php']['Title'];
				
				$all_plugins['salon-booking-plugin-pro/salon.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['salon-booking-plugin-pro/salon.php']['AuthorName'];
								
			}
			
			return $all_plugins;
			
		}
	
    	
	
		   
		/**
		 * update plugin label
		*/
		public function bzsalon_update_label( $translated_text, $untranslated_text, $domain ) {
			
			$rebranding = $this->bzsalon_get_rebranding();
			
			$bzsalon_new_text = $translated_text;
			$bzsalon_name = isset( $rebranding['plugin_name'] ) && ! empty( $rebranding['plugin_name'] ) ? $rebranding['plugin_name'] : '';
			
			$bzwhitelabel_assistants = isset( $rebranding['whitelabel_assistants'] ) && ! empty( $rebranding['whitelabel_assistants'] ) ? $rebranding['whitelabel_assistants'] : '';		
			
			$bzwhitelabel_assistant = isset( $rebranding['whitelabel_assistant'] ) && ! empty( $rebranding['whitelabel_assistant'] ) ? $rebranding['whitelabel_assistant'] : '';
			
			if ( ! empty( $bzsalon_name ) ) {
				$bzsalon_new_text = str_replace( array( 'Salon','salon','SALON','Salon Booking'), $rebranding['plugin_name'], $bzsalon_new_text );
			}
			
			if ( ! empty( $bzwhitelabel_assistants ) ) {
				$bzsalon_new_text = str_replace( array( 'Assistants','assistants'), $rebranding['whitelabel_assistants'], $bzsalon_new_text );
			}
			
			if ( ! empty( $bzwhitelabel_assistant ) ) {
				$bzsalon_new_text = str_replace( array( 'Assistant','assistant'), $rebranding['whitelabel_assistant'], $bzsalon_new_text );
			}
			
			return $bzsalon_new_text;
		}
	
	
	
		
		   
		/**
		 * update options
		*/
		public function bzsalon_updateOption($key,$value) {
			if(is_multisite()){
				return  update_site_option($key,$value);
			}else{
				return update_option($key,$value);
			}
		}
		
		
	
		
		   
		/**
		 * get options
		*/	
		public function bzsalon_getOption($key,$default=False) {
			if(is_multisite()){
				switch_to_blog(1);
				$value = get_site_option($key,$default);
				restore_current_blog();
			}else{
				$value = get_option($key,$default);
			}
			return $value;
		}

		
	
} //end Class
