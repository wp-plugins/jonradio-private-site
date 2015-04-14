<?php
/*	jonradio Common Functions,
	intended for use in more than one jonradio plugin,
	and others are encouraged to use for their own purposes.
	See details below license.
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

/*	Concept and Usage
	Each function name is prefixed with jr_v followed by a Version Number (integer) then another underscore
	then the function name.
	Each function is preceded by a check for previous existence,
	so that multiple plugins can use the same function without generating duplicate function definition errors.
	By incorporating the Version Number into the function name, there is no danger of a plugin using the wrong version.
	Standard usage is to have all these functions stored in each plugin's folder as /includes/common-functions.php
	Each function has its own Version Number, which only increases when the function actually changes;
	which means that common-functions.php will normally include many different version numbers in its functions;
	i.e. - the version number applies independently to each function, not to the common-functions.php file as a whole.
*/

//	Exit if .php file accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Do two URLs point at the same location on a web site?
 * 
 * Preps URL, if string
 *
 * @param    string/array  $url1	URL to compare, a string, or an array in special format created by companion function
 * @param    string/array  $url2	URL to compare, a string, or an array in special format created by companion function
 * @return   bool					bool TRUE if both URLs point to the same place (page, etc.); FALSE otherwise
 */
if ( !function_exists( 'jr_v1_same_url' ) ) {
	function jr_v1_same_url( $url1, $url2 ) {
		if ( !is_array( $url1 ) ) {
			$url1 = jr_v1_prep_url( $url1 );
		}
		if ( !is_array( $url2 ) ) {
			$url2 = jr_v1_prep_url( $url2 );
		}
		return ( $url1 == $url2 );
	}
}

/**
 * Standardize a URL into an array of values that can be accurately compared with another
 * 
 * Preps URL, by removing any UTF Left-to-right Mark (LRM), usually found as a suffix, 
 * translating the URL to lower-case, removing prefix http[s]//:[www.], 
 * any embedded index.php and any trailing slash or #bookmark,
 * and breaks up ?keyword=value queries into array elements.
 *
 * @param    string  $url	URL to create an array from, in special format for accurate comparison
 * @return   array			array of standardized attributes of the URL
 */
if ( !function_exists( 'jr_v1_prep_url' ) ) {
	function jr_v1_prep_url( $url ) {
		/*	Handle troublesome %E2%80%8E UTF Left-to-right Mark (LRM) suffix first.
		*/
		if ( FALSE === stripos( $url, '%E2%80%8E' ) ) {
			if ( FALSE === stripos( rawurlencode( $url ), '%E2%80%8E' ) ) {
				$url_clean = $url;
			} else {
				$url_clean = rawurldecode( str_ireplace( '%E2%80%8E', '', rawurlencode( $url ) ) );
			}
		} else {
			$url_clean = str_ireplace( '%E2%80%8E', '', $url );
		}
		$url_clean = trim( $url_clean );
		
		/*	parse_url(), especially before php Version 5.4.7,
			has a history of problems when Scheme is not present,
			especially for LocalHost as a Host,
			so add a prefix of http:// if :// is not found
		*/
		if ( FALSE === strpos( $url_clean, '://' ) ) {
			$url_clean = "http://$url_clean";
		}
		
		$parse_array = parse_url( mb_strtolower( $url_clean ) );
		/*	Get rid of URL components that do not matter to us in our comparison of URLs
		*/
		foreach ( array( 'scheme', 'port', 'user', 'pass', 'fragment' ) as $component ) {
			unset ( $parse_array[$component] );
		}
		/*	Remove www. from host
		*/
		if ( 'www.' === substr( $parse_array['host'], 0, 4 ) ) {
			$parse_array['host'] = substr( $parse_array['host'], 4 );
		}
		if ( isset( $parse_array['path'] ) ) {
			/*	Remove any index.php occurences in path, since these can be spurious in IIS
				and perhaps other environments.
			*/
			$parse_array['path'] = str_replace( 'index.php', '', $parse_array['path'] );
			/*	Remove leading and trailing slashes from path
			*/
			$parse_array['path'] = trim( $parse_array['path'], "/\\" );
			/*	Remove an empty Path component, or it won't array-match
			*/
			if ( empty( $parse_array['path'] ) ) {
				unset( $parse_array['path'] );
			}
		}
		/*	Take /?keyword=value&keyword=value URL query parameters
			and break them up into array( keyword => value, keyword => value )
		*/
		if ( isset( $parse_array['query'] ) ) {
			$parms = explode( '&', $parse_array['query'] );
			$parse_array['query'] = array();
			foreach( $parms as $parm ) {
				$split = explode( '=', $parm );
				$parse_array['query'][$split[0]] = $split[1];
			}
		}
		return $parse_array;
	}
}

/**
 * Sanitize a URL
 * 
 * Preps URL, by removing any UTF Left-to-right Mark (LRM), usually found as a suffix, 
 * and then checks if URL is blank.
 *
 * @param    string  $url	URL
 * @return   string/bool	Sanitized URL; bool FALSE if invalid URL;
 *							zero length string if URL not specified
 */
if ( !function_exists( 'jr_v1_sanitize_url' ) ) {
	function jr_v1_sanitize_url( $url ) {
		/*	Handle troublesome %E2%80%8E UTF Left-to-right Mark (LRM) suffix first.
		*/
		if ( FALSE === stripos( $url, '%E2%80%8E' ) ) {
			if ( FALSE === stripos( rawurlencode( $url ), '%E2%80%8E' ) ) {
				$url_clean = $url;
			} else {
				$url_clean = rawurldecode( str_ireplace( '%E2%80%8E', '', rawurlencode( $url ) ) );
			}
		} else {
			$url_clean = str_ireplace( '%E2%80%8E', '', $url );
		}
		$url_clean = trim( $url_clean );
		if ( empty( $url_clean ) ) {
			return '';
		}
		/*	Add a prefix of http:// if :// is not found
			and be sure scheme is http: or https:
		*/
		if ( FALSE === strpos( $url_clean, '://' ) ) {
			if ( is_ssl()
				|| ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) 
					&& $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) ) {
				$s = 's';
			} else {
				$s = '';
			}
			$url_clean = "http$s://$url_clean";
		} else {
			if ( !in_array( strtolower( parse_url( $url_clean, PHP_URL_SCHEME ) ), array( 'http', 'https' ) ) ) {
				return FALSE;
			}
		}
		return $url_clean;
	}
}

?>