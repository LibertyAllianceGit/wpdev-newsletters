<?php
/*
Plugin Name: WP Developers | Newsletter
Plugin URI: http://wpdevelopers.com
Description: Set up newsletter templates quickly, easily and painlessly.
Version: 1.2.2
Author: Tyler Johnson
Author URI: http://tylerjohnsondesign.com/
Copyright: Tyler Johnson
Text Domain: wpdevnews
Copyright 2017 WP Developers. All Rights Reserved.
*/

/**
Disallow Direct Access to Plugin File
**/
if(!defined('WPINC')) { die; }

/**
Updates
**/
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/LibertyAllianceGit/wpdev-newsletters',
	__FILE__,
	'wpdev-newsletters'
);

/**
Constants
**/
define('WPDEVNEWS_BASE_VERSION', '1.2.2');
define('WPDEVNEWS_BASE_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('WPDEVNEWS_BASE_URI', trailingslashit(plugin_dir_url(__FILE__)));

/**
Includes
**/

// Functions
//require_once(WPDEVNEWS_BASE_PATH . 'includes/functions.php');

// Email Builder
if(is_admin()) {
    //require_once(WPDEVNEWS_BASE_PATH . 'includes/email-builder.php');
}

// Front End
//require_once(WPDEVNEWS_BASE_PATH . 'includes/front-end.php');
require_once(WPDEVNEWS_BASE_PATH . 'shortcodes/form-shortcodes.php');

// Admin Settings
require_once(WPDEVNEWS_BASE_PATH . 'admin/settings.php');

/**
Allow Shortcodes in Widgets
**/
add_filter('widget_text','do_shortcode');