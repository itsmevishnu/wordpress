<?php
/*
*Plugin Name:Email Cart Details
*Description:This is a plugin used to send email to given email address
*Author:Vishnu Jayan
*/

/*
 * Check if WooCommerce is active
 */

function mme_check_active() {
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // Put your plugin code here
		add_menu_page( 'Email Cart Details', 'Email Cart Details', 'administrator', 'emailcartdetails', 'mme_display_form', plugin_dir_url(__FILE__).'images/Email-icon.png','20.5');

	} else {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		echo '<style>div#message.updated{ display: none; }</style>';
		$error_no_woocommerce = 'Sorry, WooCommerce does not found, Please activate woocommerce plugin';
		mme_error_notice($error_no_woocommerce);
	}

}
/*
---------------------------------------------------------------------
mme_success_notice is function used to display the success message
Arg : none
Return : none
*/
function mme_success_notice(){
	$msg = "Email Id saved successfully";
	?>
	 <div class="updated" style="margin:5px 2px 2px">
        <p><?php _e( $msg, 'my-text-domain' ); ?></p>
    </div>
	<?

}
/*
---------------------------------------------------------
mme_addemail: function used to add the mail to the option table
Arg : String email
rerturn :  none
---------------------------------------------------------
*/
function mme_addemail($email) {
	$option_name = "custom_emails";
	if ( get_option( $option_name ) !== false ) {

    	// The option already exists, so we just update it.
    	update_option( $option_name, $email );
	} else {

	    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
	    $deprecated = null;
	    $autoload = 'no';
	    add_option( $option_name, $email, $deprecated, $autoload );
	}
}
/*
---------------------------------------------------------------
mme_checkemail function: used to check the email is correct or not
Args : String email id
return : boolean
---------------------------------------------------------------
*/
function mme_checkemail( $email ) {
	$match = preg_match( '/^[A-z0-9_\-.]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email );
	if(!$match){
		$error_msg = 'Invalid E-mail address';
		mme_error_notice( $error_msg );
		return false;
		}
	return true;
}
/*
----------------------------------------------------------------
mme_error_notice function shows wordpress error
Args : string The error message to be show
Return: null
-----------------------------------------------------------------
*/
function mme_error_notice( $error ) {
    ?>
    <div class="error" style="margin:5px 2px 2px">
        <p><?php _e( $error, 'my-text-domain' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_menu', 'mme_check_active' );

/*
-------------------------------------------------------------------------
Function mme_display_form
Used to display the forms of the plugin
Args: none
Return: none
-------------------------------------------------------------------------
*/
function mme_display_form() {
	if( isset($_POST['send']) ) {
		$emailstring = $_POST['emails'];
		$emails = explode( ',', $emailstring );
		//print_r($emails);
		foreach($emails as $email){
			$iserror = mme_checkemail( $email );
		}
			if($iserror) {
			mme_addemail( $emailstring );
			mme_success_notice();
		}
	}
	?>
	<form method="POST" name="mailform" action="#">
		<style>
			div{
				margin-left:15px;
				margin-top: 10px;
			}
			
			div#metavalue{
  			width : 50%;
  
			}
		</style>
		<div>Enter the Email address</div>
		<div><input type = "text" id ="metavalue" name="emails" /></div>
		<div class = "buttons">
			<input type="submit" value="Save" name="send" class="button button-primary button-large"/>
			<input type="reset" value="Cancel" name="cancel"/>
		</div>

	</form>
	<?php
}
add_action( 'woocommerce_before_checkout_form', 'mme_send_mail' );
/*
-------------------------------------------------------------------------
function mme_send_mail used to send all the information to given email
Args : none
Return :  none
--------------------------------------------------------------------------
*/
function mme_send_mail(){
	global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    //print_r( $items );
    $msg = "Description\n";
    $msg .= "------------------------------------------------------------\n";
    $msg .= "Name\t\tQuantity\tAmount\tNetamount\n";
    $msg .= "------------------------------------------------------------\n";
    foreach( $items as $item ) {
        $_product = $item[ 'data' ]->post;
        $msg  .= $_product->post_title."\t\t".$item['quantity'];
        $price = get_post_meta( $item['product_id'] , '_price', true );
        $msg  .= "\t\t".$price;
        $msg .= "\t\t".$item['line_total'];
        $msg .="\n";
    }
    $totalamount = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
    $msg .= "\n------------------------------------------------------------\n";
    $msg .= "Total amount\t:".$totalamount;
	  $to   = explode( ',', get_option( 'custom_emails' ) );
	  $subject = "Acknowledgement";
	  wp_mail( $to, $subject, $msg );
}
