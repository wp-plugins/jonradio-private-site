=== jonradio Private Site ===
Contributors: dgewirtz
Donate link: http://zatzlabs.com/plugins/
Tags: login, visibility, private, security, plugin, pages, page, posts, post
Requires at least: 3.0
Tested up to: 3.6
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a Private Site visible only to your registered users.

== Description ==

Allows the Administrator to restrict a WordPress-based web site to viewing only by registered users who are logged on.

Any attempt to view any Page, Post or other part of the site will see anyone not logged on greeted by a WordPress login screen.  A Settings Page allows the Administrator to determine where Users will be automatically directed to each time that they login, a "Landing Location".

A Setting also allows the Private Site feature to be turned off.  When the plugin is installed and activated, the Private Site feature is set off by default, to allow the Administrator an opportunity to become familiarized with the plugin's features and to set the desired settings.  A warning that the site is not private appears after first activation of the plugin until the Administrator visits the plugin's Settings page.

If a WordPress Network is defined, the plugin can be activated individually for select sites.  Or Network Activated.  In either case, each site will have its own Settings page where the Private Site feature can be turned off (default) or on for just the one site, and a Landing Location defined for each site.

Login prompts are provided whenever a non-logged in user ("site visitor") attempts to access any URL controlled by WordPress on the web site.  This plugin does not control non-WordPress web pages, such as .html and .php files created by hand or by other software products.  Or images and other media and text files directly accessed by their URL, or from a browser's directory view, if available.

Yes, there are other plugins that hide some or all WordPress content for any site visitor who is not logged on.  But when I was searching for a solution for one of the web sites I support, I decided to "write my own" because I knew how it worked and felt comfortable that there would be no way for anyone not logged in to view the site, including Search Engines.

== Installation ==

This section describes how to install the plugin and get it working.

1. Use "Add Plugin" within the WordPress Admin panel to download and install this plugin from the WordPress.org plugin repository (preferred method).  Or download and unzip this plugin, then upload the `/jonradio-private-site/` directory to your WordPress web site's `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress.  If you have a WordPress Network ("Multisite"), you can either Network Activate this plugin, or Activate it individually on the sites where you wish to use it.
1. Go the Settings page to make the Site Private, and set where the user ends up after logging in.

== Changelog ==

= 2.0 =
* Add Settings page, specifying Landing Location and turning Private Site off and on
* Warning for new default of OFF for Private Site until Settings are first viewed
* Add Networking Settings information page
* Track plugin version number in internal settings
* Replace WordPress Activation/Deactivation hooks with Version checking code from jonradio Multiple Themes
* Add Plugin entry on individual sites when plugin is Network Activated, and Settings link on all Plugin entries

= 1.1 =
* Change Action Hook to 'wp' from 'wp_head' to avoid Modify Header errors when certain other plugins are present

= 1.0 =
* Add readme.txt and screenshots
* Add in-line documentation for php functions

== Upgrade Notice ==

= 2.0 =
Create a Settings page that defines where the user ends up after logging in

= 1.1 =
Should eliminate Modify Header errors due to conflict with other plugins

= 1.0 =
Production version, updated to meet WordPress Repository standards