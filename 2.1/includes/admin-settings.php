<?php
/*
	Initiated when in the Admin panels.
	Used to create the Settings page for the plugin.
*/

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

require_once( jr_ps_path() . 'includes/functions-admin.php' );

add_action( 'admin_menu', 'jr_ps_admin_hook' );
//	Runs just before admin_init (below)

/**
 * Add Admin Menu item for plugin
 * 
 * Plugin needs its own Page in the Settings section of the Admin menu.
 *
 */
function jr_ps_admin_hook() {
	//  Add Settings Page for this Plugin
	global $jr_ps_plugin_data;
	add_options_page( $jr_ps_plugin_data['Name'], 'Private Site', 'manage_options', 'jr_ps_settings', 'jr_ps_settings_page' );
}

/**
 * Settings page for plugin
 * 
 * Display and Process Settings page for this plugin.
 *
 */
function jr_ps_settings_page() {
	global $jr_ps_plugin_data;
	add_thickbox();
	echo '<div class="wrap">';
	screen_icon( 'plugins' );
	echo '<h2>' . $jr_ps_plugin_data['Name'] . '</h2><h3>Overview</h3><p>';
	$settings = get_option( 'jr_ps_settings' );
	if ( $settings['private_site'] ) {
		echo 'This';
	} else {
		echo 'If you click the <b>Private Site</b> checkbox below, this';
	}
	?>		
	Plugin creates a Private Site,
	by ensuring that site visitors login
	before viewing your web site.
	The only things visible to anyone not logged in, including Search Engines, are:
	<ul>
	<li> &raquo; Your site's WordPress Login page;</li>
	<li> &raquo; Any non-WordPress components of your web site, such as HTML, PHP, ASP or other non-WordPress web page files;</li>
	<li> &raquo; Images and other media and text files, but only when accessed directly by their URL, 
	or from a browser's directory view, if available.</li> 
	</ul>
	Other means are available to hide most, if not all, of the files mentioned above.
	</p>
	<p>
	To see your site, each visitor will need to be registered as a User on your WordPress site.
	They will also have to enter their Username and Password on the WordPress login screen. 
	</p>
	<p>
	You can choose what they see after they login by selecting a <b>Landing Location</b> in the section below.
	</p>
	<form action="options.php" method="POST">
	<?php		
	//	Plugin Settings are displayed and entered here:
	settings_fields( 'jr_ps_settings' );
	do_settings_sections( 'jr_ps_settings_page' );
	echo '<p><input name="save" type="submit" value="Save Changes" class="button-primary" /></p></form>';
	
	/*	Turn off Warning about Private Site defaulting to OFF
		once Admin has seen Settings page.
	*/
	$internal_settings = get_option( 'jr_ps_internal_settings' );
	if ( isset( $internal_settings['warning_privacy'] ) ) {
		unset( $internal_settings['warning_privacy'] );
		update_option( 'jr_ps_internal_settings', $internal_settings );
	}
}

add_action( 'admin_init', 'jr_ps_admin_init' );

/**
 * Register and define the settings
 * 
 * Everything to be stored and/or can be set by the user
 *
 */
function jr_ps_admin_init() {
	register_setting( 'jr_ps_settings', 'jr_ps_settings', 'jr_ps_validate_settings' );
	add_settings_section( 'jr_ps_private_settings_section', 
		'Make Site Private', 
		'jr_ps_private_settings_expl', 
		'jr_ps_settings_page' 
	);
	add_settings_field( 'private_site', 
		'Private Site', 
		'jr_ps_echo_private_site', 
		'jr_ps_settings_page', 
		'jr_ps_private_settings_section' 
	);
	add_settings_section( 'jr_ps_self_registration_section', 
		'Allow Self-Registration', 
		'jr_ps_self_registration_expl', 
		'jr_ps_settings_page' 
	);
	add_settings_field( 'reveal_registration', 
		'Reveal User Registration Page', 
		'jr_ps_echo_reveal_registration', 
		'jr_ps_settings_page', 
		'jr_ps_self_registration_section' 
	);
	add_settings_section( 'jr_ps_landing_settings_section', 
		'Landing Location', 
		'jr_ps_landing_settings_expl', 
		'jr_ps_settings_page' 
	);
	add_settings_field( 'landing', 
		'Where to after Login?', 
		'jr_ps_echo_landing', 
		'jr_ps_settings_page', 
		'jr_ps_landing_settings_section' 
	);
	add_settings_field( 'specific_url', 
		'Specific URL', 
		'jr_ps_echo_specific_url', 
		'jr_ps_settings_page', 
		'jr_ps_landing_settings_section' 
	);
}

/**
 * Section text for Section1
 * 
 * Display an explanation of this Section
 *
 */
function jr_ps_private_settings_expl() {
	?>
	<p>
	You will only have a Private Site if the checkbox just below is checked.
	This allows you to disable the Private Site functionality
	without deactivating the Plugin.
	</p>
	<?php
}

function jr_ps_echo_private_site() {
	$settings = get_option( 'jr_ps_settings' );
	echo '<input type="checkbox" id="private_site" name="jr_ps_settings[private_site]" value="true"';
	if ( $settings['private_site'] ) {
		echo ' checked="checked"';
	}
	echo ' />';
}

/**
 * Section text for Section2
 * 
 * Display an explanation of this Section
 *
 */
function jr_ps_self_registration_expl() {
	?>
	<p>
	If you want Users to be able to Register themselves,
	please check the checkbox below
	or the Registration page will be blocked by this plugin
	when you select Private Site above.
	(You must also select <b>Membership</b> in <b>General Settings</b> or, for Multi-Site, <b>Allow New Registrations</b> in <b>Network Settings</b>)
	</p>
	<?php
}

function jr_ps_echo_reveal_registration() {
	$settings = get_option( 'jr_ps_settings' );
	echo '<input type="checkbox" id="reveal_registration" name="jr_ps_settings[reveal_registration]" value="true"';
	if ( $settings['reveal_registration'] ) {
		echo ' checked="checked"';
	}
	echo ' />';
}

/**
 * Section text for Section3
 * 
 * Display an explanation of this Section
 *
 */
function jr_ps_landing_settings_expl() {
	?>
	<p>
	What do you want your visitors to see immediately after they login?
	For most Private Sites, the default
	<b>Return to same URL</b>
	setting works best,
	as it takes visitors to where they would have been had they already been logged on when they clicked a link or entered a URL,
	just as if they hit the browser's Back button twice and then the Refresh button after logging in.
	</p>
	<p>
	<b>Specific URL</b> only applies when <b>Go to specific URL</b> is selected.
	</p>
	<?php
}

function jr_ps_echo_landing() {
	$settings = get_option( 'jr_ps_settings' );
	$first = TRUE;
	foreach ( array(
		'return' => 'Return to same URL',
	    'home'   => 'Go to Site Home',
	    'admin'  => 'Go to WordPress Admin Dashboard',
	    'url'    => 'Go to Specific URL'
		) as $val => $desc ) {
		if ( $first ) {
			$first = FALSE;
		} else {
			echo '<br />';
		}
		echo '<input type="radio" id="landing" name="jr_ps_settings[landing]" ';
		if ( $settings['landing'] == $val ) {
			echo 'checked="checked"';
		}
		echo ' value="' . $val . '" /> ' . $desc;
	}
}

function jr_ps_echo_specific_url() {
	$settings = get_option( 'jr_ps_settings' );
	echo '<input type="text" id="specific_url" name="jr_ps_settings[specific_url]" size="100" maxlength="256" value="';
	echo esc_url( $settings['specific_url'] ) . '" />';
}

function jr_ps_validate_settings( $input ) {
	$valid = array();
	$settings = get_option( 'jr_ps_settings' );
	
	if ( array_key_exists( 'private_site', $input ) && ( $input['private_site'] === 'true' ) ) {
		$valid['private_site'] = TRUE;
	} else {
		$valid['private_site'] = FALSE;
	}
	
	if ( array_key_exists( 'reveal_registration', $input ) && ( $input['reveal_registration'] === 'true' ) ) {
		$valid['reveal_registration'] = TRUE;
	} else {
		$valid['reveal_registration'] = FALSE;
	}
	
	$valid['landing'] = $input['landing'];
	
	if ( trim( $input['specific_url'] ) ) {
		if ( jr_ps_site_url( $input['specific_url'] ) ) {
			/*	If URL is input without http:// or https://, then add it based on the Site URL.
			*/
			$parse_url = parse_url( $input['specific_url'] );
			if ( is_array( $parse_url ) && array_key_exists( 'scheme', $parse_url ) && in_array( strtolower( $parse_url['scheme'] ), array( 'http', 'https' ) ) ) {
				$url = $input['specific_url'];
			} else {
				$parse_url = parse_url( get_home_url() );
				$url = $parse_url['scheme'] . '://' . $input['specific_url'];
			}
			$valid['specific_url'] = esc_url_raw( $url, array( 'http', 'https' ) );
		} else {
			/*	Reset to previous URL value and generate an error message.
			*/
			$valid['specific_url'] = $settings['specific_url'];
			add_settings_error(
				'jr_ps_settings',
				'jr_ps_urlerror',
				'Error in URL.  It must point to someplace on this WordPress web site<br /><code>'
					. sanitize_text_field( $input['specific_url'] ) . '</code>',
				'error'
			);
		}
	} else {
		$valid['specific_url'] = '';
		if ( 'url' === $input['landing'] ) {
			add_settings_error(
				'jr_ps_settings',
				'jr_ps_nourlerror',
				'Error in Landing Location: <i>Go to Specific URL</i> selected but no URL specified.',
				'error'
			);
		}
	}
	
	return $valid;
}
	
?>