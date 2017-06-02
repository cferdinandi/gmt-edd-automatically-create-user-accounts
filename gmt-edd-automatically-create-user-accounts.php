<?php

/**
 * Plugin Name: GMT EDD Automatically Create User Accounts
 * Plugin URI: https://github.com/cferdinandi/gmt-edd-automatically-create-user-accounts/
 * GitHub Plugin URI: https://github.com/cferdinandi/gmt-edd-automatically-create-user-accounts/
 * Description: Automatically create a user account when someone buys a product with Easy Digital Downloads.
 * Version: 2.1.0
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * Text Domain: gmt_edd
 * License: GPLv3
 */

// Define constants
define( 'GMT_EDD_CREATE_USER_VERSION', '2.1.0' );

// Load plugin files
// require_once( plugin_dir_path( __FILE__ ) . 'includes/metabox.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/users.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/settings.php' );


/**
 * Check the plugin version and make updates if needed
 */
function gmt_edd_create_user_check_version() {

	// Get plugin data
	$old_version = get_site_option( 'gmt_edd_create_user_version' );

	// Update plugin to current version number
	if ( empty( $old_version ) || version_compare( $old_version, GMT_EDD_CREATE_USER_VERSION, '<' ) ) {
		update_site_option( 'gmt_edd_create_user_version', GMT_EDD_CREATE_USER_VERSION );
	}

}
add_action( 'plugins_loaded', 'gmt_edd_create_user_check_version' );