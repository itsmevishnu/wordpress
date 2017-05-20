<?php
/**
 * Plugin Name: My test Plugin
 * Description: This is test plugin for learning oops method in plugin development
 * Version: 1.0.0
 * Author: Vishnu Jayan
 * Text Domain: my-test
 * License: GPL-2.0+
 */
defined( 'ABSPATH' ) or die("Not kidding, this is plugin file");

//create plugin class
class MyTestPlugin {
  protected $plugin_path;
  protected $plugin_url;


  public function __construct() {
       add_action( 'admin_menu', array($this, 'my_create_menu') );
       add_action( 'admin_init', array( $this, 'my_create_options') );
       add_action( 'init', array( $this, 'my_custom_post_status' ) );
  }
  public function my_custom_post_status () {
      $post_status = "payment";
      $args = ['label' => 'Payment', 'public' => true, ];
      register_post_status( $post_status, $args );
  }
  public static function my_create_menu() {
      add_menu_page( 'My Plugin Settings', //title of the page
       'My plugin Settings', //label for the menu
       'list_users',// permission for the menu
       'my_test_page', // slug name for the menu page.
       array($this, 'my_display_test_page') , //call back function
       'dashicons-products' // menu icon(string location)
      );
  }
  public static function my_display_test_page() {
      if ( !current_user_can( 'list_users' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
      }
      echo '<div class="wrap">';
      echo '<form method="post" action="options.php">';
      settings_fields('my_options'); //call the settings
      do_settings_sections( 'my_test_page' );
      submit_button(); // create a submit button with wordpress default style
      echo '</form>';
      echo "</div>";
  }

  public function my_create_options() {
      register_setting(
        'my_options', //option group name used in settings_fields().
        'my_plugin_settings',//option name,
        array( $this, 'my_sanitarize_fun' ) //the function check the errors and validation
      );
      add_settings_section(
        'my_settings_id', // ID
        'My plugin Settings', // Title
        array( $this, 'my_section_fun' ), // Callback
        'my_test_page' // Page
       );

       add_settings_field( 'num_id', 'Enter register number',array( $this, 'my_id_fun'),'my_test_page', 'my_settings_id' );
       add_settings_field( 'name_id', 'Enter Name',array( $this, 'my_name_fun'),'my_test_page', 'my_settings_id' );
    }

    public function my_section_fun() {
      echo "Enter the plugin setting properly";
    }
    public function my_sanitarize_fun () {

    }
    public function my_id_fun() {
      echo '<input type="text" name="num_id"/>';
    }
    public function my_name_fun() {
      echo '<input type="text" name="name_id"/>';
    }
}
new MyTestPlugin();
 ?>
