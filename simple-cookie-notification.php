<?php
/*
  Plugin Name: GDPR Simple Notification
  Author URI: http://www.b4after.pl/
  Description: Plugin notice about privacy policy and about cookies
  Version: 1.3.1
  Author: BEFORE AFTER
  Text Domain: b4after_cookies
  Domain Path: /languages

  License: GPLv2
 */

if( !defined( 'ABSPATH' ) ){
    exit; // Exit if accessed directly.
}


//
//require_once(BA_COOKIES_PATH . 'libs/ba_cookie.php');
//require_once(BA_COOKIES_PATH . 'libs/ba_cookies_functions.php');

require_once( 'vendor/autoload.php' );

$requirements = new BeforeAfter\Cookies\Requirements( __( 'Simple Cookie Notification', 'b4after_cookies' ), [ 'php' => '5.4', ] );

/**
 * Run all the checks and check if requirements has been satisfied
 * If not - display the admin notice and exit from the file
 */
if( !$requirements->satisfied() ){
    
    add_action( 'admin_notices', [
        $requirements,
        'notice',
    ] );
    
    return;
}

class BA_simple_cookie_notification {
    
    public $version = '1.3.1';
    
    protected static $_instance = NULL;
    
    
    /**
     * Main Instance.
     *
     * Ensures only one instance of BASOS is loaded or can be loaded.
     *
     */
    public static function instance()
    {
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    public function __construct()
    {
        
        do_action( 'init_ba_pps' );
        
        $this->define_constants();
        
        $this->load_textdomain();
        
        $this->controller();
        
        
    }
    
    /**
     * Makes plugin translable
     */
    public function load_textdomain()
    {
        
        load_plugin_textdomain( 'b4after_cookies', FALSE, dirname( plugin_basename( __FILE__ ) ).'/languages/' );
    }
    
    
    /**
     * Define constants used in plugin
     */
    public function define_constants()
    {
        //define( 'BA_COOKIES_PATH', plugin_dir_path( __FILE__ ) );
        //define( 'BA_COOKIES_URL', plugin_dir_url(__FILE__) );
        
        
        define( 'BA_COOKIES_FILE', __FILE__ );
        
        define( 'BA_COOKIES_ABSPATH', dirname( __FILE__ ).'/' );
        
        define( 'BA_COOKIES_VERSION', $this->version );
        
        define( 'BA_COOKIES_PATH', plugin_dir_path( __FILE__ ) );
        
        define( 'BA_COOKIES_URL', plugin_dir_url( __FILE__ ) );
        
    }
    
    
    /**
     * Main controller file
     */
    private function controller()
    {
        add_action( 'plugins_loaded', [
            new BeforeAfter\Cookies\CookieSystem(),
            'start',
        ] );
        
    }
    
}

$CookieNotice = BA_simple_cookie_notification::instance();