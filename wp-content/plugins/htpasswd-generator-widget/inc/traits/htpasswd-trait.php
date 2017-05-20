<?php

trait HtpasswdTrait {
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
          <input id="header" name="header" type="text" placeholder="' . __( 'Header text', 'vj-htaccess' ) . '" class="form-control input-md" required="required" />
          <span class="help-block"> ' . __( 'Header text', 'vj-htaccess' ) . ' </span>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="path">' . __( 'Path', 'vj-htaccess' ) . '</label>
          <div class="col-md-12">
          <input id="path" name="path" type="text" placeholder=" ' .__( 'Path of the .htpasswd', 'vj-htaccess' ) . ' " class="form-control input-md" required="required" />
          <span class="help-block">' . __( 'Enter the path of the .htpasswd file', 'vj-htaccess' ) . '</span>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="username">' .__( 'Username', 'vj-htaccess' ) . '</label>
          <div class="col-md-12">
          <input id="username" name="username" type="text" placeholder="' .__( 'Username', 'vj-htaccess' ) . '" class="form-control input-md" required="required" />
          <span class="help-block">' . __( 'Enter the username', 'vj-htaccess' ) . '</span>
          </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="password">' . __( 'Password', 'vj-htaccess' ) . '</label>
          <div class="col-md-12">
            <input id="password" name="password" type="password" placeholder="' . __( 'Password', 'vj-htaccess' ) . '" class="form-control input-md" required="required" />
            <span class="help-block">' . __( 'Enter the password', 'vj-htaccess' ) . '</span>
          </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-12 control-label" for="submit"></label>
          <div class="col-md-12">
            <input type="submit" id="submit" name="submit" class="btn btn-primary" />
            <input type="reset" id="reset" name="submit" class="btn btn-primary" />
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

}
