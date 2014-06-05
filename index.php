<?php
/*
    Plugin Name: Google URL Shortener
    Plugin URI: http://www.ground6.com/wordpress-plugins/google-url-shortener/
    Description: Bring the power and reliable URL shortner from Goo.gl to your dashboard. This plugin will let you to create shortened URL from administrator dashboard. Each shortened URL will be updated daily and you can analyze it by total clicks, referrer sites, user browsers, operating system platforms and user countries.
    Version: 0.0.2
    Author: zourbuth
    Author URI: http://zourbuth.com
    License: GPL2

	Copyright 2014 zourbuth.com (email: zourbuth@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Exit if accessed directly
 * @since 0.0.1
 */
if ( ! defined( 'ABSPATH' ) )
	exit;

// Set constant variable
define( 'GOOGLULR', true );
define( 'GOOGLULR_VERSION', '0.0.2' );
define( 'GOOGLULR_SLUG', 'googlurl' );
define( 'GOOGLULR_TEXTDOMAIN', 'googlurl' );
define( 'GOOGLULR_DIR', plugin_dir_path( __FILE__ ) );
define( 'GOOGLULR_URL', plugin_dir_url( __FILE__ ) );


// Load the plugin
add_action( 'plugins_loaded', 'googlurl_plugin_loaded' );
				
				
/**
 * Initializes the plugin and it's features with the 'plugins_loaded' action
 * Creating custom constan variable and load necessary file for this plugin
 * Attach the widget on plugin load
 * @since 0.0.1
 */
function googlurl_plugin_loaded() {
	
	load_plugin_textdomain( 'googlurl', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	
	// Load files
	require_once( GOOGLULR_DIR . 'post-type.php' );
	require_once( GOOGLULR_DIR . 'utility.php' );
	
	// Prepare widgets
	add_action( 'widgets_init', 'googlurl_widgets_init' );
}


/**
 * Load widget files and register
 * @since 0.0.1
 */
function googlurl_widgets_init() {
	//require_once( GOOGLULR_DIR . 'widget.php' );	
	//register_widget( 'Super_Post_Widget' );
}
?>