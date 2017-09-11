<?php
defined( 'ABSPATH' ) or die("Not kidding, You can not access directly");
$error_form_elements = [ 'clf_user_err', 'clf_userpass_err', 'clf_useremail_err',
'clf_vibration', 'clf_err_bg_color', 'clf_err_font_color','clf_err_border_color',
'clf_err_border_style' ];
$saved_values = $this->clf_read_values( $error_form_elements );
if( isset( $_POST['submit'] ) ) {
  $this->clf_check_nounce();
  $error_form['clf_user_err'] = sanitize_text_field( @$_POST['clf_user_err'] );
  $error_form['clf_userpass_err'] =  sanitize_text_field( @$_POST['clf_userpass_err'] );
  $error_form['clf_useremail_err'] = sanitize_text_field( @$_POST['clf_useremail_err'] );
  $error_form['clf_vibration'] = ( 1 == sanitize_text_field( @$_POST['clf_vibration'] ) ) ? 1 : 0 ;
  $error_form['clf_err_bg_color'] = sanitize_text_field( @$_POST['clf_err_bg_color'] );
  $error_form['clf_err_font_color'] = sanitize_text_field( @$_POST['clf_err_font_color'] );
  $error_form['clf_err_border_color'] = sanitize_text_field( @$_POST['clf_err_border_color'] );
  $error_form['clf_err_border_style'] = sanitize_text_field( @$_POST['clf_err_border_style'] );
  $this->clf_save_values( $error_form );
  $saved_values = $this->clf_read_values( $error_form_elements );
}
?>

<table class="form-table">
  <tbody>
    <tr>
      <th scope="row"><?php _e('Invalid Username', 'login-form');?></th>
      <td><textarea name="clf_user_err" rows="8" cols="80"><?php echo $saved_values['clf_user_err']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Invalid Username or password', 'login-form');?></th>
      <td><textarea name="clf_userpass_err" rows="8" cols="80"><?php echo $saved_values['clf_userpass_err']; ?></textarea></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Vibration disable', 'login-form');?></th>
      <?php $checked = ( 1 == $saved_values['clf_vibration'] ) ? "checked" : ""; ?>
      <td><input type="checkbox" name="clf_vibration" value="1"  <?php echo $checked; ?>></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Error box Background', 'login-form');?></th>
      <td><input type="text" name="clf_err_bg_color" class="clf-color-field" value="<?php echo $saved_values['clf_err_bg_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Error box Text Color', 'login-form');?></th>
      <td><input type="text" name="clf_err_font_color" class="clf-color-field" value="<?php echo $saved_values['clf_err_font_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Error box Border Color', 'login-form');?></th>
      <td><input type="text" name="clf_err_border_color" class="clf-color-field" value="<?php echo $saved_values['clf_err_border_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Error box Border Style', 'login-form');?></th>
      <td>
        <select class="" name="clf_err_border_style">
          <?php $values = ['dotted' => 'Dotted',
          'dashed' => 'Dashed',
          'solid'  => 'Solid',
          'double' => 'Double',
          'groove' => 'Groove',
          'ridge' => 'Ridge',
          'inset' => 'Inset',
          'outset' => 'Outset',
          'none' => 'None',
          'hidden' => 'Hidden']; ?>
          <?php foreach ( $values as $key => $value ) : ?>
          <?php $selected = ( $key == $saved_values['clf_err_border_style'] ) ? "selected" : ""; ?>
          <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
          <?php endforeach; ?>
        </select>
      </td>
    </tr>
  </tbody>
</table>
