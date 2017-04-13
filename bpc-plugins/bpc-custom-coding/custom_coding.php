<?php
/**
 * Plugin Name: BPC Custom Coding
 * Plugin URI:
 * Description: Custom js,css and file in bpc
 * Version: 1.0
 * Author: Jesus Erwin Suarez
 * Author URI:
 * License:
 */ 

define('bpc_cc_plugin_url', get_site_url() . '/wp-content/plugins/bpc-custom-coding/'); 



/**
 * Proper way to enqueue scripts and styles.
 */
function wpdocs_theme_name_scripts() {
	$customJsPath = bpc_cc_plugin_url. '/public/js/custom-coding.js';
	$customStylePath = bpc_cc_plugin_url . '/public/css/custom-coding.css'; 
    wp_enqueue_style( 'custom-coding-style', $customStylePath );
    wp_enqueue_script( 'custom-coding-js',  $customJsPath , array(), '1.0.0', true );
} 
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' ); 