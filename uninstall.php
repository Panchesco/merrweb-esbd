<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://github.com/panchesco/merrweb-esbd
 * @since      1.0.2
 *
 * @package    merrweb-esbd
 */

 // If uninstall not called from WordPress, then exit.
 if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
 }

 function merrweb_esbed_uninstall() {
		delete_option('merrweb_esbd_settings');
 }
	
 merrweb_esbed_uninstall();