<?php

/**
 * Plugin Name: GMT EDD Automatically Create User Accounts
 * Plugin URI: https://github.com/cferdinandi/gmt-edd-automatically-create-user-accounts/
 * GitHub Plugin URI: https://github.com/cferdinandi/gmt-edd-automatically-create-user-accounts/
 * Description: Automatically create a user account when someone buys a product with Easy Digital Downloads.
 * Version: 1.0.1
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * Text Domain: gmt_edd
 * License: GPLv3
 */


// Load plugin files
require_once( plugin_dir_path( __FILE__ ) . 'includes/metabox.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/users.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/settings.php' );