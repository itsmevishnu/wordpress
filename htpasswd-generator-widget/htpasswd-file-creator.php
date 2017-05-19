<?php
/**
 * Plugin Name:  .htpasswd Generator Widget
 * Description: Create .htpasswd using a widget or shortcode
 * Version: 1.0.0
 * Plugin URI:
 * Author: Vishnu Jayan
 * Author URI: vishnujayan.in
 * Text Domain: vj-htaccess
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Tags: widgets, change .htaccess
 */

defined( 'ABSPATH' ) or die( "Don't play with me, I am a plugin");

require_once( plugin_dir_path( __FILE__ ) . 'inc/traits/htpasswd-trait.php');
require_once( plugin_dir_path( __FILE__ ) . 'inc/classes/htpasswd-widget.php');

class Htaccess {
  use HtpasswdTrait;
  public function __construct(){
    add_action( 'admin_menu', array( $this, 'htaccess_main_menu' ) );
    add_shortcode( 'htpasswd', array( $this, 'htaccess_shortcode' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'htaccess_load_js_css' ) );
    add_action( 'wp_ajax_nopriv_htaccess_ajax_submit', array( $this, 'htaccess_ajax_submit' ) );
    add_action( 'wp_ajax_htaccess_ajax_submit', array( $this, 'htaccess_ajax_submit' ) );
  }

  /**
   * Function used to create a simple menu in wordpress admin menu bar
   */

  public function htaccess_main_menu() {

    add_menu_page( '.htpasswd Generator', //title of the page
     '.htpasswd Generator', //label for the menu
     'list_users',// permission for the menu
     'htaccess-help', // slug name for the menu page.
     array($this, 'htaccess_display_page' ) , //call back function
     'dashicons-admin-generic' // menu icon(string location)
    );
  }

/**
 * Display the help message after installing the plugin
 * @return {[type] [description]
 */

  public function htaccess_display_page() {
    if( ! current_user_can( 'list_users' ) ) wp_die( __( "Don't make me fool!", 'vj-htaccess' ) );
    _e( 'Please use [htpasswd] shotcode to display the form in anywhere you like or use our widget inside your sidebar', 'vj-htaccess' );
  }


  /**
 * Include the js and css files
 */

 public function htaccess_load_js_css() {
    wp_enqueue_style( 'bootstrap', plugins_url( 'public/css/bootstrap.css', __FILE__ ), array(), 1, 'all' );
    wp_enqueue_script( 'app-js',  plugins_url( 'public/js/app.js', __FILE__ ), array(), 1, true );
    wp_localize_script( 'app-js', 'Htaccess', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
  }

  public function htaccess_ajax_submit() {
    parse_str( $_POST["formdata"], $htacces_para_array );
    $passowrd = md5( $htacces_para_array['password'] );
    $htaccess_message  = "<p>Add these lines to your .htaccess file<br><br><code>";
    $htaccess_message .= "AuthName {$htacces_para_array['header']}<br>";
    $htaccess_message .= "AuthUserFile {$htacces_para_array['path']}<br>";
    $htaccess_message .= "Require valid-user<br>";
    $htaccess_message .= "AuthType Basic<br>";
    $htaccess_message .= "</code></p>";
    //
    $htaccess_message .= "<p>Copy this line to your .htpasswd file<br><br>";
    $htaccess_message .= "<code>{$htacces_para_array['username']}:{$passowrd}";
    $htaccess_message .= "</code></p>";
    wp_send_json( $htaccess_message );
  }
}

new Htaccess();

new HtpasswdWidget();
