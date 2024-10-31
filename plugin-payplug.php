<?php

/*
Plugin Name: PayPlug Payments
Description: Accept payments from your WordPress site via PayPlug payment gateway.
Version: 1.8.1
Author URI: Kulka Nicolas, Aubert Mathieu
Text Domain: payplug
Domain Path: languages
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'PAYPLUG_VERSION', '1.8.1' );
define( 'PAYPLUG_FOLDER', 'payplug' );

define( 'PAYPLUG_URL', plugin_dir_url( __FILE__ ) );
define( 'PAYPLUG_DIR', plugin_dir_path( __FILE__ ) );

// Function for easy load files
function _payplug_load_files( $dir, $files, $prefix = '' ) {
	foreach ( $files as $file ) {
		if ( is_file( $dir . $prefix . $file . ".php" ) ) {
			require_once( $dir . $prefix . $file . ".php" );
		}
	}
}

// Plugin client classes
_payplug_load_files( PAYPLUG_DIR . 'classes/', array( 'plugin', 'widget' ) );

add_action( 'plugins_loaded', 'init_payplug_plugin' );
function init_payplug_plugin() {
	// Load client
	new PAYPLUG_Plugin();
	new PAYPLUG_Plugin_Widget();

	load_plugin_textdomain( 'payplug', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( 'PAYPLUG_Plugin', '_payplug_plugin_action_links' ) );
register_activation_hook( plugin_basename( __FILE__ ), array( 'PAYPLUG_Plugin', 'activate' ) );
