<?php
/**
 * @package Password Reset
 * @version 1.0.0
 */
/*
Plugin Name: Password Reset
Plugin URI: https://www.getuwired.com
Description: This plugin allows you to skip the loggin box when resetting your password. It also adds a Manual Account Management section to change user passwords as an admin.
Author: Robert Brown
Version: 1.0.0
Requires at least: 4.4.0
*/


add_action( 'after_password_reset', function( $user, $new_pass ) {	
	
    $creds = array(
        'user_login'    => $user->data->user_login,
        'user_password' => $new_pass,
        'remember'      => true
    );
 
    $user = wp_signon( $creds, false );
 
    if ( is_wp_error( $user ) ) {
        echo $user->get_error_message();
    }

	wp_redirect( 'https://uidp.org/members-resource-center/' );
	exit;

}, 10, 2 );



function extra_profile_fields( $user ) {
   
	if( is_admin() ){ ?>
    <h3><?php _e('Manual Account Management'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="password">Set New Customer Password</label></th>
            <td>
            <input type="text" name="guw_password" id="guw_password" value="" class="regular-text" /><br />
            <span class="description">Enter the new password. Must be longer than 3 characters.</span>
            </td>
        </tr>
    </table>
<?php

	}//End is_admin()
}

add_action( 'edit_user_profile', 'extra_profile_fields', 10 );



function save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
	
	if( $_POST['guw_password'] && strlen($_POST['guw_password']) >= 3 ){
		wp_set_password( $_POST['guw_password'], $user_id );
	}
	
}

add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );


// disable random password
add_filter( 'random_password', 'itsg_disable_random_password', 10, 2 );

function itsg_disable_random_password( $password ) {
    $action = isset( $_GET['action'] ) ? $_GET['action'] : '';
    if ( 'wp-login.php' === $GLOBALS['pagenow'] && ( 'rp' == $action  || 'resetpass' == $action ) ) {
        return '';
    }
    return $password;
}

add_action( 'login_enqueue_scripts', 'guw_login_enqueue_scripts', 10 );
function rb_login_enqueue_scripts() {
   
    $action = isset( $_GET['action'] ) ? $_GET['action'] : '';
    if ( 'wp-login.php' === $GLOBALS['pagenow'] && ( 'rp' == $action  || 'resetpass' == $action ) ) {
        wp_enqueue_script( 'rb_input_placeholder.js', plugin_dir_url( __FILE__ ) . '/js/rb_input_placeholder.js', array( 'jquery' ), 1.0 );
    }
   
}