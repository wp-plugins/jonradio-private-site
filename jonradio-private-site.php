<?php
/*
Plugin Name: jonradio Private Site
Plugin URI: http://zatzlabs.com/plugins/
Description: Creates a Private Site by allowing only those logged on to view the WordPress web site.  Settings select the initial destination after login.
Version: 2.2
Author: David Gewirtz
Author URI: http://zatzlabs.com/plugins/
License: GPLv2
*/

/*  Copyright 2013  jonradio  (email : info@zatz.com)

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

/*	Exit if .php file accessed directly
*/
if ( !defined( 'ABSPATH' ) ) exit;

global $jr_ps_path;
$jr_ps_path = plugin_dir_path( __FILE__ );
/**
 * Return Plugin's full directory path with trailing slash
 * 
 * Local XAMPP install might return:
 *	C:\xampp\htdocs\wpbeta\wp-content\plugins\jonradio-private-site/
 *
 */
function jr_ps_path() {
	global $jr_ps_path;
	return $jr_ps_path;
}

global $jr_ps_plugin_basename;
$jr_ps_plugin_basename = plugin_basename( __FILE__ );
/**
 * Return Plugin's Basename
 * 
 * For this plugin, it would be:
 *	jonradio-multiple-themes/jonradio-multiple-themes.php
 *
 */
function jr_ps_plugin_basename() {
	global $jr_ps_plugin_basename;
	return $jr_ps_plugin_basename;
}

if ( !function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

global $jr_ps_plugin_data;
$jr_ps_plugin_data = get_plugin_data( __FILE__ );
$jr_ps_plugin_data['slug'] = basename( dirname( __FILE__ ) );

/*	Detect initial activation or a change in plugin's Version number

	Sometimes special processing is required when the plugin is updated to a new version of the plugin.
	Also used in place of standard activation and new site creation exits provided by WordPress.
	Once that is complete, update the Version number in the plugin's Network-wide settings.
*/

if ( ( FALSE === ( $internal_settings = get_option( 'jr_ps_internal_settings' ) ) ) 
	|| empty( $internal_settings['version'] ) )
	{
	/*	Plugin is either:
		- updated from a version so old that Version was not yet stored in the plugin's settings, or
		- first use after install:
			- first time ever installed, or
			- installed previously and properly uninstalled (data deleted)
	*/

	$old_version = '0.1';
} else {
	$old_version = $internal_settings['version'];
}

$settings = get_option( 'jr_ps_settings' );
if ( empty( $settings ) ) {
	$settings = array(
		'private_site'        => FALSE,
		'reveal_registration' => FALSE,
		'landing'             => 'return',
		'specific_url'        => ''
	);
	/*	Add if Settings don't exist, re-initialize if they were empty.
	*/
	update_option( 'jr_ps_settings', $settings );
	/*	New install on this site, old version or corrupt settings
	*/
	$old_version = $jr_ps_plugin_data['Version'];
}

if ( version_compare( $old_version, $jr_ps_plugin_data['Version'], '!=' ) ) {
	/*	Create, if internal settings do not exist; update if they do exist
	*/
	$internal_settings['version'] = $jr_ps_plugin_data['Version'];
	if ( version_compare( $old_version, '2', '<' ) ) {
		/*	Previous versions turned Privacy on at Activation;
			Now it is a Setting on the Settings page,
			so warn Admin.
		*/
		$internal_settings['warning_privacy'] = TRUE;
	}
	update_option( 'jr_ps_internal_settings', $internal_settings );

	/*	Handle all Settings changes made in old plugin versions
	*/
	if ( version_compare( $old_version, '2.1', '<' ) ) {
		$settings['reveal_registration'] = FALSE;
	}
	update_option( 'jr_ps_settings', $settings );
}

if ( is_admin() ) {
	require_once( jr_ps_path() . 'includes/all-admin.php' );
	/* 	Support WordPress Version 3.0.x before is_network_admin() existed
	*/
	if ( function_exists( 'is_network_admin' ) && is_network_admin() ) {
		//	Network Admin pages in Network/Multisite install
		if ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( jr_ps_plugin_basename() ) ) {
			//	Network Admin Settings page for Plugin
			require_once( jr_ps_path() . 'includes/net-settings.php' );
		}
	} else {
		//	Regular (non-Network) Admin pages
		//	Settings page for Plugin
		require_once( jr_ps_path() . 'includes/admin-settings.php' );
	}
	//	All changes to all Admin-Installed Plugins pages
	require_once( jr_ps_path() . 'includes/installed-plugins.php' );
} else {
	//	Public WordPress content, i.e. - not Admin pages
	$reveal = FALSE;
	if ( ( TRUE === $settings['private_site'] ) && ( TRUE === $settings['reveal_registration'] ) ) {
		function jr_ps_match_register( $reg_url ) {
			return ( 0 === strcasecmp( $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], substr( $reg_url, 3 + strpos( $reg_url, '://' ) ) ) );
		}
		if ( jr_ps_match_register( wp_registration_url() ) ) {
			$reveal = TRUE;
		} else {
			if ( is_multisite() && jr_ps_match_register( get_site_url( 0, 'wp-signup.php' ) ) ) {
				$reveal = TRUE;
			}
		}
	}
	if ( FALSE === $reveal ) {	
		//	Private Site code
		require_once( jr_ps_path() . 'includes/public.php' );
	}
}

?>