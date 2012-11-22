=== jonradio Private Site ===
Contributors: jonradio
Donate link: http://jonradio.com/plugins
Tags: login, visibility, private, security, plugin, pages, page, posts, post
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The WordPress site, including all Pages and Posts, will not be visible to visitors unless they have logged in with a valid Username and Password.

== Description ==

After this plugin is activated, and until it is deactivated or its main plugin file removed, site visitors will be forced to login before they will be able to see any content on the WordPress site.

If a WordPress Network is defined, the plugin can be activated individually for select sites.  Or Network Activated, in which case all sites in the Network will require user login before any content will become visible.

Login prompts are provided whenever a non-logged in user ("site visitor") attempts to access any URL controlled by WordPress on the web site.  This plugin does not control non-WordPress web pages, such as .html and .php files created by hand or by other software products.

Yes, there are other plugins that hide all WordPress content for any site visitor who is not logged on.  But when I was searching for a solution for one of the web sites I support, I decided to "write my own" because I knew how it worked and felt comfortable that there would be no way for anyone not logged in to view the site, including Search Engines.

== Installation ==

This section describes how to install the plugin and get it working.

1. Use "Add Plugin" within the WordPress Admin panel to download and install this plugin from the WordPress.org plugin repository (preferred method).  Or download and unzip this plugin, then upload the `/jonradio-private-site/` directory to your WordPress web site's `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress.  If you have a WordPress Network ("Multisite"), you can either Network Activate this plugin, or Activate it individually on the sites where you wish to use it.  Activating on individual sites within a Network avoids some of the confusion created by WordPress' hiding of Network Activated plugins on the Plugin menu of individual sites.

== Frequently Asked Questions ==

= Where is the Settings page? =

There are no Settings.  To make your site private, simply Activate the Plugin.  To make your site public, either Deactivate the Plugin or, if you are unable to Deactivate the Plugin, delete the wp-content/plugins/jonradio-private-site directory.

= In a WordPress Network (Multisite) installation, how do make only some sites Private? =

Do not Network Activate this plugin.  Instead, Activate it on each site individually, using the Admin panel for each site, not the Network Admin panel.

== Screenshots ==

1. Login Prompt site visitor will see when attempting to access web site

== Changelog ==

= 1.1 =
* Change Action Hook to 'wp' from 'wp_head' to avoid Modify Header errors when certain other plugins are present

= 1.0 =
* Add readme.txt and screenshots
* Add in-line documentation for php functions

== Upgrade Notice ==

= 1.1 =
Should eliminate Modify Header errors due to conflict with other plugins

= 1.0 =
Production version, updated to meet WordPress Repository standards