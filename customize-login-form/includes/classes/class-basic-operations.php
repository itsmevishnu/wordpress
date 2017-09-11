<?php defined( 'ABSPATH' ) or die("Not kidding, You can not access directly");

class ClfBasicOperations
{
  public function __construct() {
    add_filter( 'login_headerurl', array( $this, 'clf_change_login_url') );
    add_filter( 'login_headertitle', array( $this, 'clf_change_tilte' ) );
    add_action( 'login_head', array($this, 'clf_remove_shaking' ) );
    add_filter( 'login_errors', array( $this, 'clf_change_login_error') );
  }

  protected $elements = [ 'clf_btn_color', 'clf_btn_text_color', 'clf_hover_color', 'clf_button_size',
  'clf_user_err', 'clf_userpass_err', 'clf_useremail_err',
  'clf_vibration', 'clf_err_bg_color', 'clf_err_font_color','clf_err_border_color',
  'clf_err_border_style', 'clf_form_bg_color', 'clf_text_bg_color', 'clf_form_text_color', 'clf_form_top',
  'clf_form_right', 'clf_form_bottom', 'clf_form_left', 'clf_form_width', 'clf_form_height', 'clf_form_border_color',
  'clf_form_border_style', 'clf_need_bg_image', 'clf_bg_image', 'clf_bg_color', 'clf_font_color', 'clf_font',
  'clf_lost_pass_link', 'clf_back_link','clf_logo_image', 'clf_logo_top', 'clf_logo_right',
  'clf_logo_bottom', 'clf_logo_left', 'clf_logo_title', 'clf_logo_link'];

  /**
   * Save the values to the database
   * @param  array  $values get all the value as an array
   */

  public function clf_save_values ( $values = [] ) {
    if( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
    }
    foreach ( $values as $key => $value ) {
      $updated = update_option( $key, $value );
    }
    $msg = __( "Saved successfully !, Please Update CSS to make your changes in login form", 'login-form' );
    $this->clf_show_admin_message( $msg );
  }
  /**
   * Read the values from the database
   * @param  [type]  $keys pass the keys
   */

  public function clf_read_values( $keys ) {
    foreach ( $keys as $key ) {
      $saved_values[$key] = get_option( $key );
    }
    return $saved_values;
  }
  /**
   * show success message
   */

  public function clf_show_admin_message( $msg ) {
    if( ! current_user_can( 'manage_options' ) ) {
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
    }
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>' . $msg . '</p>';
    echo '</div>';
  }
  /**
   * Create a new css file
   */

  public function clf_create_css() {
    if( ! current_user_can( 'manage_options' ) ) {
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'login-form' ) );
    }
    $this->clf_show_admin_message( __( 'Updated successfully, ', 'login-form' ) );
    $saved_values = $this->clf_read_values( $this->elements );
    if ( 1 == $saved_values['clf_need_bg_image'] ) {
      $css =  "body.login {
        background-image: url('" . wp_make_link_relative( $saved_values['clf_bg_image'] ) . "');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
      }\n";
    } else {
    $css =  "body.login {
        background-color: ". $saved_values['clf_bg_color'].";
      }\n";
    }
    $css .= ".login label {
      font-size: 12px;
      color: " . $saved_values['clf_font_color']. ";
      " . $saved_values['clf_font']  . "
    }\n";
    if ( 1 == $saved_values['clf_lost_pass_link'] ) {
      $css .= "p#nav {
          display: none;
        }\n";
    }
    if( 1 == $saved_values['clf_back_link'] ) {
      $css .= "p#backtoblog {
        display: none;
      }\n";
    }
    $css .= ".login h1 a {
      background-image: url('" . wp_make_link_relative( $saved_values['clf_logo_image'] ) . "');
    }\n";
    $css .= ".login input[type='text'],.login input[type='password']{
        background-color: " . $saved_values['clf_text_bg_color'] . ";
        color:" . $saved_values['clf_form_text_color'] . ";
        border-color:#FF3300;
       -webkit-border-radius: 4px;
    }\n";
   $css .= ".login form{
        margin:0px,0px;
        position: relative;
        padding: 26px 24px 46px;
        font-weight: 400;
        overflow: auto;
        background-color:" . $saved_values['clf_form_bg_color'] . ";
        border-style: " . $saved_values['clf_form_border_style'] . ";
        border-color: " . $saved_values['clf_form_border_style'] . ";
      }\n";
  $css .= ".login .button-primary{
        background:" .$saved_values['clf_btn_color'] . ";
        border-color:" .$saved_values['clf_btn_color'] . ";
        color:" .$saved_values['clf_btn_text_color'] . ";
      }\n
    .login .button-primary:hover {
        background:" .$saved_values['clf_hover_color'] . ";
        border-color:" .$saved_values['clf_hover_color'] . ";
        color:" .$saved_values['clf_btn_text_color'] . ";
      }\n";
  $css .= ".login #login_error, .login .message {
        border-color: " . $saved_values['clf_err_border_color'] . ";
        border-style: " . $saved_values['clf_err_border_style'] . ";
        background-color:" . $saved_values['clf_err_bg_color'] . ";
        color:" . $saved_values['clf_err_font_color'] . ";
      }\n";
    $css .= "#login{
      margin-top: " . $saved_values['clf_form_top'] . "px;
      margin-right: " . $saved_values['clf_form_right'] . "px;
      margin-bottom: " . $saved_values['clf_form_bottom'] . "px;
      margin-left: " . $saved_values['clf_form_left'] . "px;
    }\n";

      file_put_contents( plugin_dir_path( __FILE__ ) . '../../public/css/login-style.css', $css);
  }

  public function clf_change_login_url() {
    $saved_values = $this->clf_read_values( $this->elements );
    return $saved_values['clf_logo_link'];
  }

  public function clf_change_tilte() {
    $saved_values = $this->clf_read_values( $this->elements );
    return $saved_values['clf_logo_title'];
  }
  public function clf_remove_shaking() {
    $saved_values = $this->clf_read_values( $this->elements );
    if( 1 == $saved_values['clf_vibration'] ) {
      remove_action('login_head', 'wp_shake_js', 12);
    }
  }
  public function clf_change_login_error( $error ) {
    global $errors;
    $saved_values = $this->clf_read_values( $this->elements );

    $err_codes = $errors->get_error_codes();
    if ( in_array( 'invalid_username', $err_codes ) ) {
		    $error = $saved_values['clf_user_err'];
	  }
    if ( in_array( 'incorrect_password', $err_codes ) ) {
 		   $error = $saved_values['clf_userpass_err'];
 	  }
    return $error;
  }
}
