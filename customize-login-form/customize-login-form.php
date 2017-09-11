<?php

/*
Plugin Name: Customize Login Form
Plugin URI: http://custom_login.com/
Description: Custom login plugin allows to chnage your admin login page.
Author: Jaikanth, vishnu.jn
Version: 1.0
License: GPL v3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Author URI: http://jvishnujayan.in/
Text-domain: login-form
*/

defined( 'ABSPATH' ) or die("Not kidding, this is plugin file");

include_once( plugin_dir_path( __FILE__ ) . 'includes/classes/class-menu-page.php');
class CustomizeLoginForm extends ClfMenuPages
{
  /**
   * Constructor
   */

  public function __construct() {
    add_action( 'admin_menu', array( $this, 'clf_backend_menu' ) );
    add_action( 'admin_menu', array( $this, 'clf_sub_menu_create') );
    add_action( 'admin_enqueue_scripts', array( $this, 'clf_load_login_script' ) );
    add_action( 'login_enqueue_scripts', array( $this, 'clf_script_style_load' ) );
    parent::__construct();
    $values = $this->clf_read_values( $this->elements );
  }

  /**
   * Adding menu and submenu in wordpress backend
   */

  public function clf_backend_menu() {
      add_menu_page(
       __( 'Customize Login Form', 'login-form' ), //menu page title
       __( 'Customize Login Form', 'login-form' ), //Menu tilte in the dashboard
       'manage_options', // Permission to access the menu
       'customize-login-form', // Menu slug
       array( $this, 'clf_mainpage'), // Callback function
       'dashicons-feedback', // Icon for the menu
       60 //Menu location
     );
  }
  /**
   * Create sub menu
   */

  public function clf_sub_menu_create() {
    $this->clf_menu_element_create( __( 'Login Page', 'login-form' ), 'login-page', 'clf_login_page_form' );
    $this->clf_menu_element_create( __( 'Logo', 'login-form' ), 'logo', 'clf_logo_form' );
    $this->clf_menu_element_create( __( 'Login Form', 'login-form' ), 'login-form', 'clf_login_form' );
    $this->clf_menu_element_create( __( 'Login Button', 'login-form' ), 'login-button', "clf_login_button_form" );
    $this->clf_menu_element_create( __( 'Error Message', 'login-form' ), 'error-message', 'clf_error_form' );
    $this->clf_menu_element_create( __( 'Update CSS', 'login-form' ), 'update-css', 'clf_update_css_form' );
  }
  /**
   * Create each menu items in backend
   * @param  string  $clf_menu_title    title of the sub menu
   * @param  string  $clf_menu_slug    Slug of the submenu
   * @param  string  $clf_function_name call back function for each function
   * */

  public function clf_menu_element_create( $clf_menu_title, $clf_menu_slug , $clf_function_name ) {
    add_submenu_page(
      'customize-login-form', //Parent slug
      __( 'Costomize Login Form', 'login-form' ), //Menu page title
      $clf_menu_title, // Menu title
      'manage_options', // Permission to access the menu
      $clf_menu_slug, // submenu slug
      array( $this, $clf_function_name ) //Callback function
    );
  }
  /**
   * Include essential styles and scripts
   */

  public function clf_load_login_script() {
      wp_enqueue_style( 'wp-color-picker' );
      wp_enqueue_media();
      wp_enqueue_script( 'clf_js', plugin_dir_url( __FILE__ ) . 'admin/js/main.js', array( 'wp-color-picker' ), false, true );
  }
  public function  clf_script_style_load() {
    if( file_exists( plugin_dir_path( __FILE__ ) . 'public/css/login-style.css' ) ) {

        wp_enqueue_style('login-style', plugin_dir_url( __FILE__ ) . 'public/css/login-style.css', array(), time() );
    }
  }
}

new CustomizeLoginForm();
