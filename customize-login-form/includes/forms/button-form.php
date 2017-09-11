<?php
defined( 'ABSPATH' ) or die("Not kidding, You can not access directly");
$button_form_elements = [ 'clf_btn_color', 'clf_btn_text_color', 'clf_hover_color', 'clf_button_size'];
$saved_values = $this->clf_read_values( $button_form_elements );
if( isset( $_POST['submit'] ) ) {
  $this->clf_check_nounce();
  $button_form['clf_btn_color'] = sanitize_text_field( @$_POST['clf_btn_color'] );
  $button_form['clf_btn_text_color'] =  sanitize_text_field( @$_POST['clf_btn_text_color'] );
  $button_form['clf_hover_color'] = sanitize_text_field( @$_POST['clf_hover_color'] );
  $button_form['clf_button_size'] = sanitize_text_field( @$_POST['clf_button_size'] );
  $this->clf_save_values( $button_form );
  $saved_values = $this->clf_read_values( $button_form_elements );
}
?>

<table class="form-table">
  <tbody>
    <tr>
      <th scope="row"><?php _e('Button Color', 'login-form');?></th>
      <td><input type="text" name="clf_btn_color" class="clf-color-field" value="<?php echo $saved_values['clf_btn_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Text Color', 'login-form');?></th>
      <td><input type="text" name="clf_btn_text_color" class="clf-color-field" value="<?php echo $saved_values['clf_btn_text_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Button Hover Color', 'login-form');?></th>
      <td><input type="text" name="clf_hover_color" class="clf-color-field" value="<?php echo $saved_values['clf_hover_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Button Size', 'login-form');?></th>
      <td>
        <select class="" name="clf_button_size">
          <?php $values = [1=>'One',2=>'Two', 3=>'Three',4=>'Four']; ?>
          <?php foreach ( $values as $key => $value ) : ?>
          <?php $selected = ( $key == $saved_values['clf_button_size'] ) ? "selected" : ""; ?>
          <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
          <?php endforeach; ?>
        </select>
      </td>
    </tr>
  </tbody>
</table>
