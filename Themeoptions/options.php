<?php
/*
 * Custom page theme option created by Vishnu Jayan
 *  */
/*
 * -------------------------------------------------------------------------------------------------
 * function for adding the new menuitem in appearance menu
 * --------------------------------------------------------------------------------------------------------
 */
function mymenu() {
    add_theme_page( 'Custom Theme Options', 'Custom Theme Options', 'administrator', 'custom_theme_option', 'display_theme_option_form' );
}

add_action( 'admin_menu', 'mymenu' ); //Adding my menu function to the main menu
/*
 * --------------------------------------------------------------------------------------
 * Function for adding the form to that menu item 'Custom theme options'
 * -------------------------------------------------------------------------------------
 */

function display_theme_option_form() {
   ?>
    <div class = "wrap">
        <h2>Custom Theme Template</h2>
        <form method = "post" action = "options.php" enctype="multipart/form-data" >
            <?php settings_fields( 'custom_theme_option' );?>
            <?php do_settings_sections( __FILE__ ); ?>
            <input name="Submit" type="submit" class="button-primary" value="Save Changes" />
        </form>
    <div id="display_div"></div>
    </div>
    <?php
}
/*
 * ------------------------------------------------------------------------------------------
 * Register section and different fields
 * ------------------------------------------------------------------------------------------
 */
add_action( 'admin_init', 'register_mysetting' ); //Registering function with admin init hook.
    
function register_mysetting() {
    register_setting( 'custom_theme_option', 'custom_theme_option', 'validate_options' );
//register sections 
    add_settings_section( 'header_settings_id', 'Header Settings', 'header_settings', __FILE__ );
    add_settings_section( 'sidebar_settings_id', 'Sidebar Settings', 'sidebar_settings', __FILE__ );
    add_settings_section( 'general_settings_id', 'General Settings', 'general_settings', __FILE__ );
    add_settings_section( 'footer_settings_id', 'Footer Settings', 'footer_settings', __FILE__ );

//register fields
    add_settings_field( 'name_id', 'Name', 'get_name', __FILE__, 'header_settings_id'  );
    add_settings_field( 'gender_id', 'Gender', 'get_gender', __FILE__, 'header_settings_id' );
    add_settings_field( 'address', 'Address', 'get_address', __FILE__, 'sidebar_settings_id' );
    add_settings_field( 'country_id', 'Country', 'get_country', __FILE__, 'sidebar_settings_id' );
    add_settings_field( 'education_id', 'Education', 'get_education', __FILE__, 'general_settings_id' );
    add_settings_field( 'profile_id', 'Extra Details', 'get_extra_detail', __FILE__, 'general_settings_id' );
    add_settings_field( 'image_id', 'Profile Picture', 'get_image', __FILE__, 'footer_settings_id' );

}
function header_settings() {}

function sidebar_settings() {}

function footer_settings() {}

function general_settings() {}

function validate_options($custom_theme_option) {
    return $custom_theme_option;
}

function _s_sample_radio_buttons() {
    $sample_radio_buttons = array(
    'male' => array(
    'value' => 'male',
    'label' => 'Male'
    ),
    'female' => array(
    'value' => 'female',
    'label' =>  'Female'
    ));

    return apply_filters( '_s_sample_radio_buttons', $sample_radio_buttons );
}

/*
 * ----------------------------------------------------------------------------------------------
 * Function for reading Values
 * ----------------------------------------------------------------------------------------------
 */
function get_name() {
    $options = get_option( 'custom_theme_option' );
    echo "<input name='custom_theme_option[name_id]' type='text' value='{$options['name_id']}' />";
}

/*Select entered gender information*/
function get_gender() {
    $options = get_option( 'custom_theme_option' );
   foreach ( _s_sample_radio_buttons() as $button ) {
                ?>
                <div class="layout">
                <label class="description">
                <input type="radio" name="custom_theme_option[radiobutton]" value="<?php echo esc_attr( $button['value'] ); ?>" <?php checked( $options['radiobutton'], $button['value'] ); ?> />
                <?php echo $button['label']; ?>
                </label>
                </div>
                <?php
                }
}
/*Read address entered*/
function get_address() {
    $options = get_option( 'custom_theme_option' );
    ?>
    <textarea name="custom_theme_option[address]" cols="40" rows="5"><?php echo $options['address'] ?></textarea>
    <?php

}

/*Reads the contry choosed from the list*/
function get_country() {
    $options = get_option( 'custom_theme_option' );?>
    <label>Choose any Country: </label>
    <select name="custom_theme_option[country_id]" >
      <option value="India" <?php selected( $options['country_id'], 'India' ); ?>>India</option>
      <option value="China" <?php selected( $options['country_id'], 'India' ); ?>>China</option>
      <option value="USA" <?php selected( $options['country_id'], 'USA' ); ?>>USA</option>
      <option value="UK" <?php selected( $options['country_id'], 'UK' ); ?>>UK</option>
      <option value="UAE" <?php selected( $options['country_id'], 'UAE' ); ?>>UAE</option>
      <option value="France" <?php selected( $options['country_id'], 'France' ); ?>>France</option>
    </select>
    <?php
}

/*Reads education information*/
function get_education() {
    $options = get_option( 'custom_theme_option' );?>
    <input type="checkbox" name="custom_theme_option[undergraduate]" value="checkbox1_value" <?php if ( isset ( $options['undergraduate'] ) ) checked( $options['undergraduate'], 'checkbox1_value' ); ?>>Undergraduate 
    <input type="checkbox" name="custom_theme_option[postgraduate]" value="checkbox2_value" <?php if ( isset ( $options['postgraduate'] ) ) checked( $options['postgraduate'], 'checkbox2_value' ); ?>>Postgraduate 
    <?php
}

/*Reads extra details entered*/
function get_extra_detail() {
    $options = get_option( 'custom_theme_option' );
     wp_editor( $options['profile_id'], 'custom_theme_option[profile_id]','custom_theme_option[profile_id]', array( 'textarea_name' => 'content', 'media_buttons' => true) ); 

}
 
/*Reads the image uploaded*/
function get_image() {
    $options = get_option( 'custom_theme_option' );
     //image_uploader();
    ?>
    <div class='uploader'>
        <input type = 'text' name = "custom_theme_option[image_id]" id = "image_name" value = "<?php echo $options['image_id'];?>" />
        <input class = "button-primary" name = '_upld_files_button' id = "upload_button" value = 'Upload' />
        <span style = "float:right"> <img src = "<?php echo $options['image_id']?>" id ="img_prv"></span>
    </div>


    <?php
}
    
add_action( 'admin_enqueue_scripts', 'image_uploader' );// adding image upload scripts 

/*Includes image uploading files*/
function image_uploader() {
      wp_enqueue_media();
      $path=get_template_directory_uri().'/js/imageuploader.js';
      wp_register_script( 'imguploader', $path,array( 'jquery' ),false,true );
      wp_enqueue_script( 'imguploader' );

     ?>

      <?php
}

?>
