<?php
    /*
     * Plugin Name: Path Updater
     * Description: This plugin is used to update the files with less effort.
     * Author: Vishnu Jayan
    */

    /*
     * Function pupr_dislayUpdate
     * Usage : used to create a GUI form for entering the old and new URL
     * parameter : none
     * return : none
    */

    function pupr_form(){ 
         if( isset( $_POST['update'] ) ) {
            $old_path = $_POST['oldpath'];
            $new_path = $_POST['newpath'];
            $chk_meta = $_POST['chkmeta'];
            $chk_post = $_POST['chkpost'];
            $value_update = pupr_check( $old_path, $new_path, $chk_meta, $chk_post );
            if( $value_update ) {
              pupr_process( $old_path, $new_path, $chk_meta, $chk_post );

            }
              pupr_show_notice ($value_update);
        } 
?>
	
    <form name = "pathuploader" method = "post" action="#">
        <table>
            <tr>
                <td>Old URL</td>
                <td>&nbsp;:&nbsp;</td>
                <td><input type = "text" name = "oldpath" placeholder="Enter the old URL here" /></td>
            </tr>
            <tr>
                <td>New URL</td>
                <td>&nbsp;:&nbsp;</td>
                <td><input type = "text" name = "newpath" placeholder="Enter the new URL here" />
                </td>
            </tr>
            <tr>
                <td>Changes on</td>
                <td>&nbsp;:&nbsp;</td>
                <td>Post&nbsp;<input type = "checkbox" name = "chkpost" value = "post" />
                    Meta&nbsp;<input type = "checkbox" name = "chkmeta" value = "meta"  /></td>
            </tr>
            <tr>
                <td colspan = "3" align="center"><input type = "submit" name = "update" value = "Update" class ="button button-primary menu-save" /> </td>
            </tr>
        </table>
    </form>

<?php 
} 

    /*
     * Function pupr_pathUpdater
     * Usage : used to manage the plugin
     * parameter : none
     * return : none
    */

    function pupr_path_updater()
    {
        add_options_page('Path Updater', 'Update path', 'manage_options', 'pathupdater', 'pupr_form');
    }
    add_action('admin_menu', 'pupr_path_updater');

    /*
     * Function pupr_process
     * Usage : used to get the values from  GUI form and update the database
     * parameter : none
     * return :  boolean update
    */

    function pupr_process( $old_path, $new_path, $chk_meta, $chk_post ) {	
        if( ( !is_null( $chk_meta ) ) && ( is_null( $chk_post ) ) ) {
            //code for updating the meta table
            global $wpdb;
            $meta_table = $wpdb->prefix . 'postmeta';
            $query_meta = "UPDATE $meta_table SET meta_value = replace(meta_value,'$old_path', '$new_path')";
            $wpdb -> query($query_meta);

        } else if( ( is_null( $chk_meta ) ) && ( !is_null( $chk_post ) ) ) {
            //code for updating the post table
            global $wpdb;
            $post_table = $wpdb->prefix . 'posts';
            $query_post = "UPDATE $post_table SET post_content = replace(post_content, '$old_path', '$new_path')";
            $wpdb -> query($query_post);
        } else if( ( !is_null($chk_meta) ) && ( !is_null($chk_post) ) ) {
            //code for updating the both table
            global $wpdb;
            $meta_table = $wpdb->prefix . 'postmeta';
            $post_table = $wpdb->prefix . 'posts';
            $query_meta = "UPDATE $meta_table SET meta_value = replace(meta_value,'$old_path', '$new_path')";
            $query_post = "UPDATE $post_table SET post_content = replace(post_content,'$old_path', '$new_path')";
            $wpdb -> query($query_post);
            $wpdb -> query($query_meta);  
        }

    }

    /*
     * Function pupr_ShowNotice
     * Usage : Used to display the succes or failure  message on wordpress
     * parameters: boolean update
     * return :none
    */
    function pupr_show_notice($update) {   
       
        if ( "Path Updater" === get_admin_page_title()):
            if ( $update ) {
                ?>
                <div class = "updated" style="margin : 10px 50px 5px 2px; " >
                    <p><?php _e("Updated successfully", 'my-text-domain' );?></p>
                </div>
                <?php
            } else {  
                ?>
                <div class = "error" style="margin : 10px 50px 5px 2px; ">
                    <p><?php _e("Error occured: Enter valid URLs or Select any Option(s)", 'my-text-domain' );?></p>
                </div>
                <?php
            }
       endif;
    }

    /*
     * Function pupr_Check
     * Usage : Used to check the values entered is rigth or wrong
     * parameters: string oldpath, string newpath, string chkmeta,string chkpost
     * return :boolean
    */
    function pupr_check($old_path, $new_path ,$chk_meta ,$chk_post) {
        if(( "" === "$old_path" ) || (strcasecmp ( ( substr($old_path, 0, 4) ), 'http') !=0 )) {
            return false;
        }
        if( ( "" === "$new_path") || (strcasecmp( (substr( $new_path, 0, 4) ), 'http') != 0)) {
            return false;
        }
        if( ( "" == $chk_meta ) && ( "" == $chk_post ) ) {
            return false;
        }   
        return true;
    }