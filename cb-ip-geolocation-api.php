<?php 
/*
Plugin Name: CB IP Geolocation API
Plugin URI: https://github.com/hmbashar/cb-ip-geolocation-api
Description: CB IP Geolocation API
Version: 1.0
Author: MD Abul Bashar
Author URI: https://hmbashar.com
Text Domain: cbipgapi
Domain Path: /languages
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Prefix: cbipgapi
*/


//don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;


// Define constant for plugin file
define( 'CBIPGAPI_FILE', __FILE__ );

// Define constant for plugin directory path
define( 'CBIPGAPI_DIR', plugin_dir_path( CBIPGAPI_FILE ) );

// Define constant for plugin directory URL
define( 'CBIPGAPI_URL', plugin_dir_url( CBIPGAPI_FILE ) );



function cbipgapi_load_textdomain() {
    load_plugin_textdomain( 'cbipgapi', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'cbipgapi_load_textdomain' );


function cb_user_ip_location($atts) {
    $a = shortcode_atts( array(
        'country' => '',
        'city' => '',
    ), $atts );

    $ip = wp_remote_get( 'http://ip-api.com/json' );

    $ip_data = wp_remote_retrieve_body( $ip );

    $decodeData = json_decode( $ip_data );

    $result = '';
    if($a['country']) {
        $result = $decodeData->country;
    }

    if($a['city']) {
        $result = $decodeData->city;
    }

    return $result;
}

add_shortcode( 'cb_user_ip', 'cb_user_ip_location' );