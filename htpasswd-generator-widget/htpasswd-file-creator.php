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

class Htaccess extends WP_Widget {
  public function __construct(){
      parent::__construct( 'htaccess-widget', '.htaccess Modifier', array(
        'classname' => 'htaccess',
			  'description' => 'Widget to create .htpasswd for your server',
      ) );

     add_action( 'admin_menu', array( $this, 'htaccess_main_menu' ) );
     add_shortcode( 'htpasswd', array( $this, 'htaccess_shortcode' ) );
     add_action( 'wp_enqueue_scripts', array( $this, 'htaccess_load_js_css' ) );
     add_action( 'wp_ajax_nopriv_htaccess_ajax_submit', array( $this, 'htaccess_ajax_submit' ) );
     add_action( 'wp_ajax_htaccess_ajax_submit', array( $this, 'htaccess_ajax_submit' ) );
     add_action( 'widgets_init', array( $this, 'htaccess_register_widget' ) );
  }

  /**
   * Function used to create a simple menu in wordpress admin menu bar
   */

  public function htaccess_main_menu() {

    add_menu_page( '.htpasswd Generator', //title of the page
     'HTACCESS', //label for the menu
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
 * Display the form when shortcode included.
 * @return {[type] [description]
 */

  public function htaccess_shortcode() {
   $form =  '<form class="form-horizontal" method="post" action="">
      <fieldset>

      <!-- Form Name -->
      <legend>' . __( '.htpasswd Generator', 'vj-htaccess' ) . '</legend>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-12 control-label" for="header">' . __( 'Header', 'vj-htaccess' ) . '</label>
        <div class="col-md-12">
        <input id="header" name="header" type="text" placeholder="' . __( 'Header text', 'vj-htaccess' ) . '" class="form-control input-md" required="required">
        <span class="help-block"> ' . __( 'Header text', 'vj-htaccess' ) . ' </span>
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-12 control-label" for="path">' . __( 'Path', 'vj-htaccess' ) . '</label>
        <div class="col-md-12">
        <input id="path" name="path" type="text" placeholder=" ' .__( 'Path of the .htpasswd', 'vj-htaccess' ) . ' " class="form-control input-md" required="required">
        <span class="help-block">' . __( 'Enter the path of the .htpasswd file', 'vj-htaccess' ) . '</span>
        </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-12 control-label" for="username">' .__( 'Username', 'vj-htaccess' ) . '</label>
        <div class="col-md-12">
        <input id="username" name="username" type="text" placeholder="' .__( 'Username', 'vj-htaccess' ) . '" class="form-control input-md" required="required">
        <span class="help-block">' . __( 'Enter the username', 'vj-htaccess' ) . '</span>
        </div>
      </div>

      <!-- Password input-->
      <div class="form-group">
        <label class="col-md-12 control-label" for="password">' . __( 'Password', 'vj-htaccess' ) . '</label>
        <div class="col-md-12">
          <input id="password" name="password" type="password" placeholder="' . __( 'Password', 'vj-htaccess' ) . '" class="form-control input-md" required="required">
          <span class="help-block">' . __( 'Enter the password', 'vj-htaccess' ) . '</span>
        </div>
      </div>

      <!-- Button -->
      <div class="form-group">
        <label class="col-md-12 control-label" for="submit"></label>
        <div class="col-md-12">
          <input type="submit" id="submit" name="submit" class="btn btn-primary">
          <input type="reset" id="reset" name="submit" class="btn btn-primary">
        </div>
      </div>

      <!-- Textarea -->
      <div id="result">

      </div>

      </fieldset>
      </form>
      ';
    return $form;
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

  /**
   * Creating a widge
   */

  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
    echo $this->htaccess_shortcode();
    echo $args['after_widget'];
  }
  /**backend widget form*/
  public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
  public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
  public function htaccess_register_widget() {
    register_widget( get_class( $this ) );
}

}

new Htaccess();
