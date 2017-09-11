<?php
  defined( 'ABSPATH' ) or die("Not kidding, You can not access directly");
  if( isset( $_POST['submit'] ) ) {
    $this->clf_create_css( );
  }
?>
<div class="wrap">
  <form method="post" action="#">
    <div class="">
      <h2><?php _e('You have to update css for view the changes', 'login-form'); ?></h2>
    </div>
    <input id="update-css" name="submit" type="submit" class="button button-primary" value="<?php _e( 'Update CSS', 'login-form' ); ?>" />
  </form>
</div>
