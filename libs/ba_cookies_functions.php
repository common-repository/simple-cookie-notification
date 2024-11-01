<?php
/**
 * Adds scripts and styles to front-end
 */
function ba_cookies_enqueue_scripts(){
	wp_enqueue_style( 'ba_cookies_css', BA_COOKIES_URL.'assets/ba_cookies_styles.css', [], '1.2' );
	wp_enqueue_script( 'ba_cookies_js', BA_COOKIES_URL.'assets/cookie.js', array( 'jquery' ), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'ba_cookies_enqueue_scripts' );

/**
 * Adds scripts and styles to admin area
 */
function ba_cookies_admin_enqueue_scripts(){
	wp_enqueue_style( 'ba_admin_cookies_css', BA_COOKIES_URL.'assets/ba_cookies_admin_styles.css', [], '1.2' );
	wp_enqueue_script( 'ba_admin_cookies_js', BA_COOKIES_URL.'assets/ba_cookies_admin_scripts.js', array( 'jquery' ), '1.0.0', true );


}

add_action( 'admin_enqueue_scripts', 'ba_cookies_admin_enqueue_scripts' );


