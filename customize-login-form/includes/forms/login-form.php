<?php
defined( 'ABSPATH' ) or die("Not kidding, You can not access directly");
$login_form_elements = [ 'clf_form_bg_color', 'clf_text_bg_color', 'clf_form_text_color', 'clf_form_top',
'clf_form_right', 'clf_form_bottom', 'clf_form_left', 'clf_form_width', 'clf_form_height', 'clf_form_border_color',
'clf_form_border_style' ];
$saved_values = $this->clf_read_values( $login_form_elements );
if( isset( $_POST['submit'] ) ) {
  $this->clf_check_nounce();
  $login_form['clf_form_bg_color'] = sanitize_text_field( @$_POST['clf_form_bg_color'] );
  $login_form['clf_text_bg_color'] = sanitize_text_field( @$_POST['clf_text_bg_color'] );
  $login_form['clf_form_text_color'] = sanitize_text_field( @$_POST['clf_form_text_color'] );
  $login_form['clf_form_top'] = sanitize_text_field( @$_POST['clf_form_top'] );
  $login_form['clf_form_right'] = sanitize_text_field( @$_POST['clf_form_right'] );
  $login_form['clf_form_bottom'] = sanitize_text_field( @$_POST['clf_form_bottom'] );
  $login_form['clf_form_left'] = sanitize_text_field( @$_POST['clf_form_left'] );
  $login_form['clf_form_width'] = sanitize_text_field( @$_POST['clf_form_width'] );
  $login_form['clf_form_height'] = sanitize_text_field( @$_POST['clf_form_height'] );
  $login_form['clf_form_border_color'] = sanitize_text_field( @$_POST['clf_form_border_color'] );
  $login_form['clf_form_border_style'] = sanitize_text_field( @$_POST['clf_form_border_style'] );
  $this->clf_save_values( $login_form );
  $saved_values = $this->clf_read_values( $login_form_elements );
}
?>

<table class="form-table">
  <tbody>
    <tr>
      <th scope="row"><?php _e('Form background Color', 'login-form');?></th>
      <td><input type="text" name="clf_form_bg_color" class="clf-color-field" value="<?php echo $saved_values['clf_form_bg_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Textbox background Color', 'login-form');?></th>
      <td><input type="text" name="clf_text_bg_color" class="clf-color-field" value="<?php echo $saved_values['clf_text_bg_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Text Color', 'login-form');?></th>
      <td><input type="text" name="clf_form_text_color" class="clf-color-field" value="<?php echo $saved_values['clf_form_text_color']; ?>" ></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Position of Form', 'login-form');?></th>
      <td>
          <input type="text" name="clf_form_top" placeholder="Top" value="<?php echo $saved_values['clf_form_top']; ?>">px
          <input type="text" name="clf_form_right" placeholder="Right" value="<?php echo $saved_values['clf_form_right']; ?>">px
          <input type="text" name="clf_form_bottom" placeholder="Bottom" value="<?php echo $saved_values['clf_form_bottom']; ?>">px
          <input type="text" name="clf_form_left" placeholder="Left" value="<?php echo $saved_values['clf_form_left']; ?>">px
      </td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Size of form', 'login-form');?></th>
      <td>
          <input type="text" name="clf_form_width" placeholder="Width" value="<?php echo $saved_values['clf_form_width']; ?>">px
          <input type="text" name="clf_form_height" placeholder="Height" value="<?php echo $saved_values['clf_form_height']; ?>">px
      </td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Form Border Color', 'login-form');?></th>
      <td><input type="text" name="clf_form_border_color" class="clf-color-field" value="<?php echo $saved_values['clf_form_border_color']; ?>"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Form Border Style', 'login-form');?></th>
      <td>
        <select class="" name="clf_form_border_style">
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
          <?php $selected = ( $key == $saved_values['clf_form_border_style'] ) ? "selected" : ""; ?>
          <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
          <?php endforeach; ?>
        </select>
      </td>
    </tr>
  </tbody>
</table>
