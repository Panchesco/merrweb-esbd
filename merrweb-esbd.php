<?php
/**
 * @link              https://github.com/panchesco/merrweb-esbd.git
 * @since             1.0.0
 * @package           merrweb-esbd
 *
 * @wordpress-plugin
 * Plugin Name:       Spanish-English Dictionary
 * Plugin URI:        https://github.com/panchesco/merrweb-esbd.git
 * Description:       A shortcode for adding a bilingual Spanish-English dictionary to a post or page.
 * Version:           1.0.0
 * Author:            Richard Whitmer
 * Author URI:        https://github.com/panchesco
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       merrweb-esbd
 * Domain Path:       /languages
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

class MerrWebEsbd {
    
    var $dist_url = 'http://localhost:4000'; // Set this to dev server URL if in development; otherwise, leave it blank.
    var $options = array(	'api_key' => '',
    						'placeholder' => 'Word to translate',
    						'loadingId' => 'loading-status',
    						'loadingClass' => 'loading',
    						'resultsMsg' => 'We found %d definitions for %s.',
    						'noResultsMsg' => 'Nothing found for %s. Some suggestions:',
    						'btnTxt' => 'Define');
    var $version = '1.0.0';
    var $enpoint;
    var $q;
    var $slug = 'merrweb-esbd';
    var $nonce;
    
    function __construct() {
	    
	    $this->version = time();
	    
	    // If $this->dist_url is null, we're in production
	    if( $this->dist_url == null ) {
	    	$this->dist_url = plugins_url() . '/merrweb-esbd/vue/dist'; // Production
	    } 
	    	        
		$settings = get_option('merrweb_esbd_settings');
        
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

function merrweb_esbd_add_admin_menu(  ) { 

	add_options_page( 'Merriam-Webster Bilingual Dictionary', 'Merriam-Webster Bilingual Dictionary', 'manage_options', $this->slug, [$this,'merrweb_esbd_options_page'] );

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

	function merrweb_esbd_add_settings_link( $links ) {
		
	    $settings_link = '<a href="options-general.php?page=merrweb-esbd">' . __( 'Settings' ) . '</a>';
	    array_push( $links, $settings_link );
	  	return $links;
	}

// ----------------------------------------------------------------------------- 


function merrweb_esbd_settings_init(  ) { 

	register_setting( 'merrweb-esbd', 'merrweb_esbd_settings' );
	
			add_settings_section(
		'merrweb_esbd_branding_section', 
		'', 
		[$this,'merrweb_esbd_branding_section_callback'], 
		'merrweb-esbd'
	);

	add_settings_section(
		'merrweb_esbd_section', 
		__( 'API Key Required', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_settings_section_callback'], 
		'merrweb-esbd'
	);
	


	add_settings_field( 
		'merrweb_esbd[api_key]', 
		__( 'Spanish-English  Dictionary API Key', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_api_key_render'], 
		'merrweb-esbd', 
		'merrweb_esbd_section' 
	);
	
	add_settings_section(
		'merrweb_esbd_shortcode_section', 
		__( 'Shortcode Options', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_shortcode_section_callback'], 
		'merrweb-esbd'
	);
	
	add_settings_field( 
		'merrweb_esbd[placeholder]', 
		__( 'Search Input Placeholder Text', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_placeholder_render'], 
		'merrweb-esbd', 
		'merrweb_esbd_shortcode_section' 
	);
	
	add_settings_field( 
		'merrweb_esbd[btnTxt]', 
		__( 'Button Text', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_btnTxt_render'], 
		'merrweb-esbd', 
		'merrweb_esbd_shortcode_section' 
	);
	
	add_settings_field( 
		'merrweb_esbd[loadingId]', 
		__( 'Loading Element ID', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_loadingId_render'], 
		'merrweb-esbd', 
		'merrweb_esbd_shortcode_section' 
	);
	
	add_settings_field( 
		'merrweb_esbd[loadingClass]', 
		__( 'Loading Element Class', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_loadingClass_render'], 
		'merrweb-esbd', 
		'merrweb_esbd_shortcode_section' 
	);
	
	add_settings_field( 
		'merrweb_esbd[resultsMsg]', 
		__( 'Results message', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_resultsMsg_render'], 
		'merrweb-esbd', 
		'merrweb_esbd_shortcode_section' 
	);
	
	add_settings_field( 
		'merrweb_esbd[noResultsMsg]', 
		__( 'No results message', 'merrweb-esbd' ), 
		[$this,'merrweb_esbd_noResultsMsg_render'], 
		'merrweb-esbd', 
		'merrweb_esbd_shortcode_section' 
	);
	


}

// ----------------------------------------------------------------------------- 


function merrweb_esbd_api_key_render(  ) { 
	?>
	<input type='text' name='merrweb_esbd_settings[api_key]' value='<?php echo $this->options['api_key']; ?>'><hr>
	<?php
}

// ----------------------------------------------------------------------------- 

function merrweb_esbd_placeholder_render(  ) { 

	?>
	<input type='text' name='merrweb_esbd_settings[placeholder]' value='<?php echo $this->options['placeholder']; ?>'>
	<?php

}

// ----------------------------------------------------------------------------- 

function merrweb_esbd_btnTxt_render(  ) { 

	?>
	<input type='text' name='merrweb_esbd_settings[btnTxt]' value='<?php echo $this->options['btnTxt']; ?>'>
	<?php

}

// ----------------------------------------------------------------------------- 

function merrweb_esbd_loadingId_render(  ) { 

	?>
	<input type='text' name='merrweb_esbd_settings[loadingId]' value='<?php echo $this->options['loadingId']; ?>'>
	<?php

}

// ----------------------------------------------------------------------------- 


function merrweb_esbd_loadingClass_render(  ) { 

	?>
	<input type='text' name='merrweb_esbd_settings[loadingClass]' value='<?php echo $this->options['loadingClass']; ?>'>
	<?php

}

// ----------------------------------------------------------------------------- 


function merrweb_esbd_noResultsMsg_render(  ) { 

	?>
	<textarea name='merrweb_esbd_settings[noResultsMsg]'><?php echo $this->options['noResultsMsg']; ?></textarea>
	<?php

}

// ----------------------------------------------------------------------------- 

function merrweb_esbd_resultsMsg_render(  ) { 

	?>
	<textarea name='merrweb_esbd_settings[resultsMsg]'><?php echo $this->options['resultsMsg']; ?></textarea>
	<?php

}

// -----------------------------------------------------------------------------


function merrweb_esbd_settings_section_callback(  ) { 


	$html= '<p>To use this plugin, you\'ll need an API key for the Merriam-Webster\'s Spanish-English Dictionary API.<br>
	If you don\'t already have one, you can create a free account in the <a href="https://www.dictionaryapi.com/register/index">Merriam-Webster Developer Center.</a><br>Request a key for the Spanish-English Dictionary.
	Once you receive the key, return to this page and add it here.</p>';
	

	
	echo $html;

}

// ----------------------------------------------------------------------------- 


function merrweb_esbd_shortcode_section_callback(  ) { 

	echo __( 'Customize rendered form elements and messaging.', 'merrweb-esbd' );

}

// ----------------------------------------------------------------------------- 

function merrweb_esbd_branding_section_callback() {
	?>
	<div class="merrweb-esbd-branding">
				<div>
				<a href="https://www.merriam-webster.com/"><img src="<?php echo plugins_url(); ?>/merrweb-esbd/images/MWLogo.png" alt="Merriam-Webster" style="Courtesy Merriam-Webster Inc." /></a>
				</div>
				<div>
				API Courtesy <a href="https://www.merriam-webster.com/">Merriam-Webster Inc.</a>
				</div>
	</div>
	<?php
}

// -----------------------------------------------------------------------------  

function merrweb_esbd_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2>Spanish-English Dictionary</h2>

			<?php
			settings_fields( 'merrweb-esbd' );
			do_settings_sections( 'merrweb-esbd' );
			submit_button();
			?>
			
		</form>
		<?php
    
}	

// -----------------------------------------------------------------------------	
    
    function search() {
        
        // Verify nonce.
        if( wp_verify_nonce($this->nonce,'merrweb_esbd') === false) {
	        
	        
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
	    $str .= '?key=' . trim($this->options['api_key']);
	    
	    return $str;
    }
    
// -----------------------------------------------------------------------------
    
    function app() {
        
        global $post;
        
        $html = '';
        
        $data = array(
	        'url' => site_url() . '/wp-admin/admin-ajax.php',
            '_wpnonce' => wp_create_nonce('merrweb_esbd'),
            'q' => '',
            'action' => 'search',
            'per_page' => 25,
            'page' => 1,
            'slug' => $this->slug,
            'loadingId' => $this->options['loadingId'],
            'loadingClass' => $this->options['loadingClass'],
            'noResultsMsg' => __($this->options['noResultsMsg']),
            'resultsMsg' => __($this->options['resultsMsg']),
            'placeholder' => __($this->options['placeholder']),
            'logoSrc' => plugins_url() . '/merrweb-esbd/images/MWLogo.png',
            'logoAlt' => 'Merriam-Webster',
            'logoHref' => 'https://www.merriam-webster.com/',
            'btnTxt' => __($this->options['btnTxt']),
            'dist' => plugins_url() . 'whatever'
        );

        if( ! has_shortcode( $post->post_content, 'merrweb-spanish-english') ) {
            return;
        }
        
	    // If this is a production distribution, register and enqueue styles.
		if( $this->does_url_exist( $this->dist_url . '/css/app.css',FALSE, NULL, 0, 1 ) ) {
	     wp_register_style('merrweb-esbd-css', $this->dist_url . '/css/app.css',[],$this->version,false);
		 wp_enqueue_style('merrweb-esbd-css');
		}

        // Localize data we'll use in the app.
        wp_register_script('merrweb-esbd-data', plugins_url() . '/merrweb-esbd/js/index.js',[],$this->version,false);
        wp_localize_script('merrweb-esbd-data','merrweb_esbd',$data);
        wp_enqueue_script('merrweb-esbd-data');
        
        // Call the scripts used by Vue
        wp_register_script('merrweb-esbd-chunk-vendors', $this->dist_url . '/js/chunk-vendors.js',['merrweb-esbd-data'],$this->version,true);
		wp_register_script('merrweb-esbd-app', $this->dist_url . '/js/app.js',['merrweb-esbd-chunk-vendors'],$this->version,true);
		wp_enqueue_script('merrweb-esbd-chunk-vendors');
		wp_enqueue_script('merrweb-esbd-app');
   
        $html.='
             <noscript>You will need to enable scripting for the short code to work</noscript>
             <div id="app"></div>
            ';
            
        return $html;
        
    }
    
 // ----------------------------------------------------------------------------- 
 
 function admin_styles() {
	 
	 if( is_admin() && $_GET['page'] == 'merrweb-esbd') {
		 wp_register_style('merrweb-esbd-admin-css', plugins_url() . '/merrweb-esbd/css/styles.css',[],$this->version);
		 wp_enqueue_style('merrweb-esbd-admin-css');
	 }
 }


} // End class

$MerrWebEsbd = new MerrWebEsbd();
add_filter( "plugin_action_links_" . plugin_basename(__FILE__), [$MerrWebEsbd,'merrweb_esbd_add_settings_link'] );
add_action( 'admin_menu', [$MerrWebEsbd,'merrweb_esbd_add_admin_menu'] );
add_action( 'admin_init', [$MerrWebEsbd,'merrweb_esbd_settings_init'] );
add_action( 'admin_enqueue_scripts', [$MerrWebEsbd,'admin_styles'] );
add_action("wp_ajax_search", [$MerrWebEsbd,'search']);
add_action("wp_ajax_nopriv_search", [$MerrWebEsbd,'search']);
add_shortcode('merrweb-spanish-english',[$MerrWebEsbd,'app']);


   

