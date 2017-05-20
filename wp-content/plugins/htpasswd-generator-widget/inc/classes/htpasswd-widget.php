<?php

class HtpasswdWidget extends WP_Widget {
  use HtpasswdTrait;
  public function __construct() {
    parent::__construct( 'htaccess-widget', '.htaccess Modifier', array(
      'classname' => 'htaccess',
      'description' => 'Widget to create .htpasswd for your server',
    ) );
    add_action( 'widgets_init', array( $this, 'htaccess_register_widget' ) );
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

		echo '<p>';
		echo "<label for= " .  esc_attr( $this->get_field_id( 'title' ) )  . " > ".  esc_attr_e( 'Title:', 'text_domain' ) . "</label>";
		echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value=" ' . esc_attr( $title ). '">';
		echo '</p>';
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
