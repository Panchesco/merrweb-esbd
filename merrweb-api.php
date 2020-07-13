<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/panchesco
 * @since             1.0.0
 * @package           Merrweb-API
 *
 * @wordpress-plugin
 * Plugin Name:       Merriam Webster API
 * Plugin URI:        http://wp.local
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           v1.0.0
 * Author:            Richard Whitmer
 * Author URI:        https://github.com/panchesco
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       merrweb-api
 * Domain Path:       /languages
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

define('MERRWEBAPI_ENV','development');


class MerrWebAPI {
    
    var $options;
    var $version = '1.0.0';
    var $location = 'http://localhost:4000';
    var $enpoint;
    var $q;
    
    function __construct() {
        
        $this->options = get_option('merrweb_api_settings');
        
        if( isset($_REQUEST['q']) ) {
            $this->q = sanitize_text_field($_REQUEST['q']);
        }
        
        
    }

function merrweb_api_add_admin_menu(  ) { 

	add_options_page( 'Merriam-Webster API', 'Merriam-Webster API', 'manage_options', 'merrweb-api', [$this,'merrweb_api_options_page'] );

}


function merrweb_api_settings_init(  ) { 

	register_setting( 'merrweb-api', 'merrweb_api_settings' );

	add_settings_section(
		'merrweb_api_pluginPage_section', 
		__( 'Merriam-Webster API Key(s)', 'merrweb-api' ), 
		[$this,'merrweb_api_settings_section_callback'], 
		'merrweb-api'
	);

	add_settings_field( 
		'merrweb_api[api_key]', 
		__( 'API Key', 'merrweb-api' ), 
		[$this,'merrweb_api_api_key_render'], 
		'merrweb-api', 
		'merrweb_api_pluginPage_section' 
	);

}


function merrweb_api_api_key_render(  ) { 

	?>
	<input type='text' name='merrweb_api_settings[api_key]' value='<?php echo $this->options['api_key']; ?>'>
	<?php

}


function merrweb_api_settings_section_callback(  ) { 

	echo __( 'Enter your API keys', 'merrweb-api' );

}


function merrweb_api_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2>Merriam-Webster API</h2>

			<?php
			settings_fields( 'merrweb-api' );
			do_settings_sections( 'merrweb-api' );
			submit_button();
			?>

		</form>
		<?php
    
}	


    // -----------------------------------------------------------------------------	
    		
    function methods() {
        
    }
    
    // ----------------------------------------------------------------------------- 
    
    function search() {
        
        // Check nonce
        
        
        
    }
    
    
    // -----------------------------------------------------------------------------
    
    function app() {
        
        global $post;
        
        $data = array(
            '_wpnonce' => wp_create_nonce('merrweb_api'),
            'ajax_url' => site_url() . '/wp-admin/admin-ajax.php',
            'q' => '',
        );
        $html = '';
        
        if( ! has_shortcode( $post->post_content, 'merrweb-spanish') ) {
            return;
        }
        
        if(MERRWEBAPI_ENV == 'development') {

            
            // Localize data we'll use in the app.
            wp_register_script('merrweb-api-data', plugins_url() . '/merrweb-api/js/index.js',[],$this->version,false);
            wp_localize_script('merrweb-api-data','merrweb_api',$data);
            wp_enqueue_script('merrweb-api-data');
            
            // Call the scripts used by Vue
            wp_register_script('merrweb-api-chunk-vendors', $this->location . '/js/chunk-vendors.js',['merrweb-api-data'],$this->version,true);
			wp_register_script('merrweb-api-app', $this->location . '/js/app.js',['merrweb-api-chunk-vendors'],$this->version,true);
			wp_enqueue_script('merrweb-api-chunk-vendors');
			wp_enqueue_script('merrweb-api-app');
						
            
             $html.='
             <noscript>You will need to enable scripting for the short code to work</noscript>
             <div id="app"></div>';
            
        }
        
        
        
        return $html;
        
    }


} // End class

$MerrWebAPI = new MerrWebAPI();

add_action( 'admin_menu', [$MerrWebAPI,'merrweb_api_add_admin_menu'] );
add_action( 'admin_init', [$MerrWebAPI,'merrweb_api_settings_init'] );
add_action("wp_ajax_methods", [$MerrWebAPI,'dictionary_query']);
add_action("wp_ajax_nopriv_methods", [$MerrWebAPI,'dictionary_query']);
add_shortcode('merrweb-spanish',[$MerrWebAPI,'app']);

   

