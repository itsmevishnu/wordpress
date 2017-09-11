<?php
defined( 'ABSPATH' ) or die("Not kidding, You can not access directly");
$login_page_elements = [ 'clf_need_bg_image', 'clf_bg_image', 'clf_bg_color', 'clf_font_color', 'clf_font',
'clf_lost_pass_link', 'clf_back_link' ];
$saved_values = $this->clf_read_values( $login_page_elements );
if( isset( $_POST['submit'] ) ) {
  $this->clf_check_nounce();
  $login_page['clf_need_bg_image'] = sanitize_text_field( @$_POST['clf_need_bg_image'] );
  $login_page['clf_need_bg_image'] = ( 1 == sanitize_text_field( @$_POST['clf_need_bg_image'] ) ) ? 1 : 0 ;
  $login_page['clf_bg_image'] = sanitize_text_field( @$_POST['clf_bg_image'] );
  $login_page['clf_bg_color'] = sanitize_text_field( @$_POST['clf_bg_color'] );
  $login_page['clf_font_color'] = sanitize_text_field( @$_POST['clf_font_color'] );
  $login_page['clf_font'] = sanitize_text_field( @$_POST['clf_font'] );
  $login_page['clf_lost_pass_link'] = ( 1 == sanitize_text_field( @$_POST['clf_lost_pass_link'] ) ) ? 1 : 0 ;
  $login_page['clf_back_link'] = ( 1 ==sanitize_text_field(  @$_POST['clf_back_link'] ) ) ? 1 : 0 ;
  $this->clf_save_values( $login_page );
  $saved_values = $this->clf_read_values( $login_page_elements );
}
?>

<table class="form-table">
  <tbody>
    <tr>
      <th scope="row"><?php _e('Set image as background', 'login-form');?></th>

      <?php $checked = ( 1 == $saved_values['clf_need_bg_image'] ) ? "checked" : ""; ?>
      <td><input type="checkbox" name="clf_need_bg_image" value="1" class="clf-need-image" <?php echo $checked; ?>></td>
    </tr>
    <tr class="bg-image">
      <th scope="row"><?php _e('Back ground Image', 'login-form');?></th>
      <td>
        <img id="clf_bg_image_preview" src="<?php echo $saved_values['clf_bg_image']; ?>" style="width:100px; height:100px;" />
        <input id="clf_bg_image" type="hidden" name="clf_bg_image" class="clf-bg-image" value="<?php echo $saved_values['clf_bg_image']; ?>">
        <input id="upload_bg_image_button" type="button" class="button" value="<?php _e( 'Upload Backgorund image', 'login-form' ); ?>" />

      </td>
    </tr>
    <tr class="bg-color">
      <th scope="row"><?php _e('Back ground Colour', 'login-form');?></th>
      <td><input type="text" name="clf_bg_color" class="clf-color-field" value="<?php echo $saved_values['clf_bg_color']; ?>" class="clf-bg-color"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Text Colour', 'login-form');?></th>
      <td><input type="text" name="clf_font_color" value="<?php echo $saved_values['clf_font_color']; ?>" class="clf-color-field"></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Font', 'login-form');?></th>
      <td><select class="" name="clf_font">
        <?php $values = [ "Andale Mono" => "font-family:andale mono,monospace" ,"Arial" => "font-family:arial,helvetica,sans-serif" ,
                        "Arial Black" => "font-family:arial black,sans-serif" ,"Book Antiqua" => "font-family:book antiqua,palatino,serif" ,
                        "Comic Sans MS" => "font-family:comic sans ms,sans-serif" ,"Courier New" => "font-family:courier new,courier,monospace" ,
                        "Georgia" => "font-family:georgia,palatino,serif" ,"Helvetica" => "font-family:helvetica,arial,sans-serif" ,
                        "Impact" => "font-family:impact,sans-serif" ,"Symbol" => "font-family:symbol" ,"Tahoma" => "font-family:tahoma,arial,helvetica,sans-serif" ,
                        "Terminal" => "font-family:terminal,monaco,monospace" ,"Times New Roman" => "font-family:times new roman,times,serif" ,
                        "Trebuchet MS" => "font-family:trebuchet ms,geneva,sans-serif" ,"Verdana" => "font-family:verdana,geneva,sans-serif" ]; ?>
        <?php foreach ( $values as $key => $value ) : ?>
        <?php $selected = ( $value == $saved_values['clf_font'] ) ? "selected" : ""; ?>
        <option style="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
        <?php endforeach; ?>
      </select></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Remove the lost password link', 'login-form');?></th>
      <?php $checked = ( 1 == $saved_values['clf_lost_pass_link'] ) ? "checked" : ""; ?>
      <td><input type="checkbox" name="clf_lost_pass_link" value="1"  <?php echo $checked; ?>></td>
    </tr>
    <tr>
      <th scope="row"><?php _e('Remove the back to link', 'login-form');?></th>
      <?php $checked = ( 1 == $saved_values['clf_back_link'] ) ? "checked" : ""; ?>
      <td><input type="checkbox" name="clf_back_link" value="1" class="clf-need-image" <?php echo $checked; ?>></td>
    </tr>
  </tbody>
</table>
