<?php
/*
	Initiated when on the "public" web site,
	i.e. - not an Admin panel.
*/

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'login_init', 'jr_ps_login' );
add_action( 'wp', 'jr_ps_force_login' );

/**
 * Login Detection
 * 
 * Set a global variable, $jr_ps_is_login, whenever a login occurs 
 *
 * @return   NULL                Nothing is returned
 */
function jr_ps_login() {
	global $jr_ps_is_login;
	$jr_ps_is_login = TRUE;
}

/**
 * Present a login screen to anyone not logged in
 * 
 * Check for already logged in or just logged in.
 * Only called when is_admin() is FALSE
 *
 * @return   NULL                Nothing is returned
 */
function jr_ps_force_login() {
	global $jr_ps_is_login;
	if ( !is_user_logged_in() && !isset( $jr_ps_is_login ) ) {
		$settings = get_option( 'jr_ps_settings' );
		switch ( $settings['landing'] ) {
			case 'return':
				//	$_SERVER['HTTPS'] can be off in IIS
				if ( empty( $_SERVER['HTTPS'] ) || ( $_SERVER['HTTPS'] == 'off' ) ) {
					$http = 'http://';
				} else {
					$http = 'https://';
				}
				$after_login_url = $http . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				break;
			case 'home':
				$after_login_url = get_home_url();
				break;
			case 'admin':
				$after_login_url = get_admin_url();
				break;
			case 'url':
				$after_login_url = trim( $settings['specific_url'] );
				break;
		}
		//	Avoid situations where specific URL is requested, but URL is blank
		if ( !empty( $after_login_url ) ) {
			wp_redirect( wp_login_url( $after_login_url ) );
			exit;
		}
	}
}

?>