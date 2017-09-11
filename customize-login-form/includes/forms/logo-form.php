<?php
defined( 'ABSPATH' ) or die("Not kidding, You can not access directly");
$login_form_elements = [ 'clf_logo_image', 'clf_logo_top', 'clf_logo_right', 'clf_logo_bottom', 'clf_logo_left', 'clf_logo_title', 'clf_logo_link' ];
$saved_values = $this->clf_read_values( $login_form_elements );
if( isset( $_POST['submit'] ) ) {
  $this->clf_check_nounce();
  $login_form['clf_logo_image'] = sanitize_text_field( @$_POST['clf_logo_image'] );
  $login_form['clf_logo_top'] = sanitize_text_field( @$_POST['clf_logo_top'] );
  $login_form['clf_logo_right'] = sanitize_text_field( @$_POST['clf_logo_right'] );
  $login_form['clf_logo_bottom'] = sanitize_text_field( @$_POST['clf_logo_bottom'] );
  $login_form['clf_logo_left'] = sanitize_text_field( @$_POST['clf_logo_left'] );
  $login_form['clf_logo_title'] = sanitize_text_field( @$_POST['clf_logo_title'] );
  $login_form['clf_logo_link'] = sanitize_text_field( @$_POST['clf_logo_link'] );
  $this->clf_save_values( $login_form );
  $saved_values = $this->clf_read_values( $login_form_elements );
}
?>

<table class="form-table">
  <tbody>
    <tr>
      <th scope="row"><?php _e('Logo', 'login-form');?></th>
      <td>
        <img src="<?php echo $saved_values['clf_logo_image']; ?>" style="width:100px; height:100px;">
        <input type="hidden" id="clf_logo_image" name="clf_logo_image" value="<?php echo $saved_values['clf_logo_image']; ?>">
        <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'login-form' ); ?>" />
      </td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Position', 'login-form');?></th>
      <td>
          <input type="text" name="clf_logo_top" placeholder="Top" value="<?php echo $saved_values['clf_logo_top']; ?>">px
          <input type="text" name="clf_logo_right" placeholder="Right" value="<?php echo $saved_values['clf_logo_right']; ?>">px
          <input type="text" name="clf_logo_bottom" placeholder="Bottom" value="<?php echo $saved_values['clf_logo_bottom']; ?>">px
          <input type="text" name="clf_logo_left" placeholder="Left" value="<?php echo $saved_values['clf_logo_left']; ?>">px
      </td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Title', 'login-form');?></th>
      <td><input type="text" name="clf_logo_title" placeholder="Title of the logo" value="<?php echo $saved_values['clf_logo_title']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Logo link', 'login-form');?></th>
      <td><input type="text" name="clf_logo_link" placeholder="Link" value="<?php echo $saved_values['clf_logo_link']; ?>"></td>
    </tr>
  </tbody>
</table>
