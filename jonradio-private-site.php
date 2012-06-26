<?php
/*
Plugin Name: jonradio Private Site
Plugin URI: http://jonradio.com/plugins/jonradio-private-site/
Description: Removes visibility of site, by forcing login before any content can be viewed.
Version: 1.1
Author: jonradio
Author URI: http://jonradio.com/plugins
License: GPLv2
*/

/*  Copyright 2012  jonradio  (email : info@jonradio.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

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
 * Check for Admin, already logged in, or just logged in
 *
 * @return   NULL                Nothing is returned
 */
function jr_ps_force_login() {
	global $jr_ps_is_login;
	if ( !is_user_logged_in() && !isset( $jr_ps_is_login ) && !is_admin() ) {
		auth_redirect();
	}
}

?>