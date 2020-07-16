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
 * Plugin URI:        https://github.com/panchesco/merrweb-api
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
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

class MerrWebAPI {
    
    var $options = array(	'api_key' => '',
    						'placeholder' => '',
    						'loadingId' => 'loading-status',
    						'loadingClass' => 'loading',
    						'resultsMsg' => 'We found these results:',
    						'noResultsMsg' => 'Nothing found for %s. Some suggestions:');
    var $version = '1.0.0';
    var $dist_url = 'http://localhost:4000'; // Set this to dev server URL if in development; otherwise, leave it blank.
    var $enpoint;
    var $q;
    var $slug = 'merrweb-api';
    var $nonce;
    
    function __construct() {
	    
	    $this->version = time();
	    
	    // If $this->dist_url is null, we're in production
	    if( $this->dist_url == null ) {
	    	$this->dist_url = plugins_url() . '/merrweb-api/vue/dist'; // Production
	    } 
	    	        
		$settings = get_option('merrweb_api_settings');
        
        if( $settings !== false ) {
        	foreach( $settings as $key => $option ) {
	        	$this->options[$key] = $option; 
        	}
        }

        if( isset($_REQUEST['q']) ) {
            $this->q = sanitize_text_field($_REQUEST['q']);
        }
        
        if( isset($_REQUEST['_wpnonce']) ) {
        	$this->nonce = sanitize_text_field($_REQUEST['_wpnonce']);
        }

    }

function merrweb_api_add_admin_menu(  ) { 

	add_options_page( 'Merriam-Webster API', 'Merriam-Webster API', 'manage_options', $this->slug, [$this,'merrweb_api_options_page'] );

}

// ----------------------------------------------------------------------------- 

	function does_url_exist($url) {
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_exec($ch);
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	    if ($code == 200) {
	        $status = true;
	    } else {
	        $status = false;
	    }
	    curl_close($ch);
	    return $status;
	}

// ----------------------------------------------------------------------------- 

	function merrweb_api_add_settings_link( $links ) {
		
	    $settings_link = '<a href="options-general.php?page=merrweb-api">' . __( 'Settings' ) . '</a>';
	    array_push( $links, $settings_link );
	  	return $links;
	}

// ----------------------------------------------------------------------------- 


function merrweb_api_settings_init(  ) { 

	register_setting( 'merrweb-api', 'merrweb_api_settings' );

	add_settings_section(
		'merrweb_api_section', 
		__( 'Merriam-Webster API Key(s)', 'merrweb-api' ), 
		[$this,'merrweb_api_settings_section_callback'], 
		'merrweb-api'
	);

	add_settings_field( 
		'merrweb_api[api_key]', 
		__( 'API Key', 'merrweb-api' ), 
		[$this,'merrweb_api_api_key_render'], 
		'merrweb-api', 
		'merrweb_api_section' 
	);
	
	add_settings_field( 
		'merrweb_api[placeholder]', 
		__( 'Search Input Placeholder Text', 'merrweb-api' ), 
		[$this,'merrweb_api_placeholder_render'], 
		'merrweb-api', 
		'merrweb_api_section' 
	);
	
	add_settings_field( 
		'merrweb_api[loadingId]', 
		__( 'Loading Element ID', 'merrweb-api' ), 
		[$this,'merrweb_api_loadingId_render'], 
		'merrweb-api', 
		'merrweb_api_section' 
	);
	
	add_settings_field( 
		'merrweb_api[loadingClass]', 
		__( 'Loading Element Class', 'merrweb-api' ), 
		[$this,'merrweb_api_loadingClass_render'], 
		'merrweb-api', 
		'merrweb_api_section' 
	);
	
	add_settings_field( 
		'merrweb_api[resultsMsg]', 
		__( 'Results message', 'merrweb-api' ), 
		[$this,'merrweb_api_resultsMsg_render'], 
		'merrweb-api', 
		'merrweb_api_section' 
	);
	
	add_settings_field( 
		'merrweb_api[noResultsMsg]', 
		__( 'No results message', 'merrweb-api' ), 
		[$this,'merrweb_api_noResultsMsg_render'], 
		'merrweb-api', 
		'merrweb_api_section' 
	);

}

// ----------------------------------------------------------------------------- 


function merrweb_api_api_key_render(  ) { 

	?>
	<input type='text' name='merrweb_api_settings[api_key]' value='<?php echo $this->options['api_key']; ?>'>
	<?php

}

// ----------------------------------------------------------------------------- 

function merrweb_api_placeholder_render(  ) { 

	?>
	<input type='text' name='merrweb_api_settings[placeholder]' value='<?php echo $this->options['placeholder']; ?>'>
	<?php

}

// ----------------------------------------------------------------------------- 

function merrweb_api_loadingId_render(  ) { 

	?>
	<input type='text' name='merrweb_api_settings[loadingId]' value='<?php echo $this->options['loadingId']; ?>'>
	<?php

}

// ----------------------------------------------------------------------------- 


function merrweb_api_loadingClass_render(  ) { 

	?>
	<input type='text' name='merrweb_api_settings[loadingClass]' value='<?php echo $this->options['loadingClass']; ?>'>
	<?php

}

// ----------------------------------------------------------------------------- 


function merrweb_api_noResultsMsg_render(  ) { 

	?>
	<textarea name='merrweb_api_settings[noResultsMsg]'><?php echo $this->options['noResultsMsg']; ?></textarea>
	<?php

}

// ----------------------------------------------------------------------------- 

function merrweb_api_resultsMsg_render(  ) { 

	?>
	<textarea name='merrweb_api_settings[resultsMsg]'><?php echo $this->options['resultsMsg']; ?></textarea>
	<?php

}

// -----------------------------------------------------------------------------


function merrweb_api_settings_section_callback(  ) { 

	echo __( 'Enter your API keys', 'merrweb-api' );

}

// ----------------------------------------------------------------------------- 


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
        
        // Verify nonce.
        if( wp_verify_nonce($this->nonce,'merrweb_api') === false) {
	        
	        
	        	$data = array(	'error' => 'error',
	        				'error_description' => __('The submitted form is not valid or has expired. Please reload this page and try again.'));
	        				
				$response = json_encode($data);
        
        	} else {
             
				$this->endpoint = $this->endpoint($this->q);
				$response = file_get_contents($this->endpoint);
			}
        
        print $response;
        
        wp_die();
 
    }
    
// -----------------------------------------------------------------------------
    
    function endpoint($q) {
	    
	    $str = 'https://www.dictionaryapi.com/api/v3/references/spanish/json/';
	    $str .= $this->q;
	    $str .= '?key=' . urlencode($this->options['api_key']);
	    
	    return $str;
    }
    
// -----------------------------------------------------------------------------
    
    function app() {
        
        global $post;
        
        $html = '';
        
        $data = array(
	        'url' => site_url() . '/wp-admin/admin-ajax.php',
	        'headers' => "'Accept' : 'application:json',
				    	  'Content-Type' : 'application/json;charset=UTF-8'",
            '_wpnonce' => wp_create_nonce('merrweb_api'),
            'q' => '',
            'action' => 'search',
            'per_page' => 25,
            'page' => 1,
            'slug' => $this->slug,
            'loadingId' => $this->options['loadingId'],
            'loadingClass' => $this->options['loadingClass'],
            'noResultsMsg' => __($this->options['noResultsMsg']),
            'resultsMsg' => __($this->options['resultsMsg']),
            'placeholder' => __($this->options['placeholder'])
        );

        if( ! has_shortcode( $post->post_content, 'merrweb-spanish') ) {
            return;
        }
        
	    // If this is a production distribution, register and enqueue styles.
		if( $this->does_url_exist( $this->dist_url . '/css/app.css',FALSE, NULL, 0, 1 ) ) {
	     wp_register_style('merrweb-api-css', $this->dist_url . '/css/app.css',[],$this->version,false);
		 wp_enqueue_style('merrweb-api-css');
		}

        // Localize data we'll use in the app.
        wp_register_script('merrweb-api-data', plugins_url() . '/merrweb-api/js/index.js',[],$this->version,false);
        wp_localize_script('merrweb-api-data','merrweb_api',$data);
        wp_enqueue_script('merrweb-api-data');
        
        // Call the scripts used by Vue
        wp_register_script('merrweb-api-chunk-vendors', $this->dist_url . '/js/chunk-vendors.js',['merrweb-api-data'],$this->version,true);
		wp_register_script('merrweb-api-app', $this->dist_url . '/js/app.js',['merrweb-api-chunk-vendors'],$this->version,true);
		wp_enqueue_script('merrweb-api-chunk-vendors');
		wp_enqueue_script('merrweb-api-app');
   
        
        $html.='
             <noscript>You will need to enable scripting for the short code to work</noscript>
             <div id="app"></div>
            ';
            
        return $html;
        
    }
    
 // ----------------------------------------------------------------------------- 


} // End class

$MerrWebAPI = new MerrWebAPI();
add_filter( "plugin_action_links_" . plugin_basename(__FILE__), [$MerrWebAPI,'merrweb_api_add_settings_link'] );
add_action( 'admin_menu', [$MerrWebAPI,'merrweb_api_add_admin_menu'] );
add_action( 'admin_init', [$MerrWebAPI,'merrweb_api_settings_init'] );
add_action("wp_ajax_search", [$MerrWebAPI,'search']);
add_action("wp_ajax_nopriv_search", [$MerrWebAPI,'search']);
add_shortcode('merrweb-spanish',[$MerrWebAPI,'app']);


   

