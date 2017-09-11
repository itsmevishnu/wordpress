<?php
defined( 'ABSPATH' ) or die("Not kidding, You can not access directly");

include_once( plugin_dir_path( __FILE__ ) . 'class-basic-operations.php');

class ClfMenuPages extends ClfBasicOperations
{
  public function __construct() {
      parent::__construct();
  }

  /**
   * Main page options
   */
  public function clf_mainpage() {
    if( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
    }
    include_once(  plugin_dir_path( __FILE__ ) . '../forms/home-page.php' );
  }
  /**
   * Login page customization page
   */

  public function clf_login_page_form() {
    if( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
      }
      $this->clf_form_init( "login-page" );
  }
  /**
   * Login logo customization page
   */

  public function clf_logo_form() {
    if( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
      }
      $this->clf_form_init( "logo-form" );
  }
  /**
   * Login form customization page
   */

  public function clf_login_form() {
    if( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
      }
      $this->clf_form_init( "login-form" );
  }
  /**
   * Login button customization page
   */

  public function clf_login_button_form() {
    if( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
      }
      $this->clf_form_init( "button-form" );
  }
  /**
   * Login error customization page
   */

  public function clf_error_form() {
    if( ! current_user_can( 'manage_options' ) ) {
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
    }
    $this->clf_form_init( "error-form" );
  }
  public function clf_update_css_form() {
    if( ! current_user_can( 'manage_options' ) ) {
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
    }
    include_once(  plugin_dir_path( __FILE__ ) . '../forms/update-css.php' );
  }

  /**
   * Create a functions to initialize the form in menu pages.
   */

  public function clf_form_init ( $name ) {
    $filepath = plugin_dir_path( __FILE__ );
    echo '<div class="wrap">';
    echo '<form method="post" action="#">';
    switch ( $name ) {
      case 'login-page':
        include_once(  $filepath . '../forms/' . $name . '.php' );
      break;
      case 'logo-form':
        include_once( $filepath . '../forms/' . $name . '.php' );
      break;
      case 'login-form':
        include_once( $filepath . '../forms/' . $name . '.php' );
      break;
      case 'error-form':
        include_once( $filepath . '../forms/' . $name .'.php' );
      break;
      case 'button-form':
        include_once( $filepath . '../forms/' . $name .'.php' );
      break;
      default:
        wp_die( "Unknown error occured", 'login-fom' ,array( 'back_link' => true ));
      break;
    }
    wp_nonce_field('submit_form');
    submit_button(); // create a submit button with wordpress default style
    echo '</form>';
    echo "</div>";
  }
  public function clf_check_nounce() {
    if ( ! check_admin_referer('submit_form') ) {
      wp_die( __('Some security error occured!','login-form'),
             __('Security Error','login-form'),
             array('back_link' => get_admin_url())
           );
    };
  }
}
