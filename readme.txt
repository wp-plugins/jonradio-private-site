=== jonradio Private Site ===
Contributors: dgewirtz
Donate link: http://zatzlabs.com/plugins/
Tags: login, visibility, private, security, plugin, pages, page, posts, post
Requires at least: 3.0
Tested up to: 3.7
Stable tag: 2.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a Private Site visible only to your registered users.

== Description ==

Allows the Administrator to restrict a WordPress-based web site to viewing only by registered users who are logged on.

Any attempt to view any Page, Post or other part of the site will see anyone not logged on greeted by a WordPress login screen.  A Settings Page allows the Administrator to determine where Users will be automatically directed to each time that they login, a "Landing Location".

If you allow Self-Registration, where new Users can Register themselves, you will need to select the "Reveal User Registration Page" setting or new Users will be blocked from seeing the WordPress Registration screen (on WordPress Networks, turning off the Reveal User Registration Page setting on the "Main Site" will prevent Registration from all Sites).  For convenience, the WordPress Setting that controls Self-Registration of Users has been added to the Plugin's Settings page.

Another Setting allows the Private Site feature to be turned off.  When the plugin is installed and activated, the Private Site feature is set off by default, to allow the Administrator an opportunity to become familiarized with the plugin's features and to set the desired settings.  A warning that the site is not private appears after first activation of the plugin until the Administrator visits the plugin's Settings page.

There is also a Setting to make the Home Page visible on a Private Site.

If a WordPress Network is defined, the plugin can be activated individually for select sites.  Or Network Activated.  In either case, each site will have its own Settings page where the Private Site feature can be turned off (default) or on for just the one site, and a Landing Location defined for each site.

Login prompts are provided whenever a non-logged in user ("site visitor") attempts to access any URL controlled by WordPress on the web site.  This plugin does not control non-WordPress web pages, such as .html and .php files created by hand or by other software products.  Or images and other media and text files directly accessed by their URL, or from a browser's directory view, if available.

Yes, there are other plugins that hide some or all WordPress content for any site visitor who is not logged on.  But when I was searching for a solution for one of the web sites I support, I decided to "write my own" because I knew how it worked and felt comfortable that there would be no way for anyone not logged in to view the site, including Search Engines.

== Installation ==

This section describes how to install the *jonradio Private Site* plugin and get it working.

1. Use **Add Plugin** within the WordPress Admin panel to download and install this *jonradio Private Site* plugin from the WordPress.org plugin repository (preferred method).  Or download and unzip this plugin, then upload the `/jonradio-private-site/` directory to your WordPress web site's `/wp-content/plugins/` directory
1. Activate the *jonradio Private Site* plugin through the **Installed Plugins** Admin panel in WordPress.  If you have a WordPress Network ("Multisite"), you can either **Network Activate** this plugin, or Activate it individually on the sites where you wish to use it.
1. Go to the plugin's Settings page to make the Site **Private**, and set where the user ends up after logging in: the **Landing Location**.
1. If you allow Self-Registration, where new Users can set up their own User Name on your WordPress site or Network, you will want to select **Reveal User Registration Page** on the plugin's Settings page.

== Changelog ==

= 2.4.1 =
* Fix bug in URL matching for Root, where one URL has a trailing slash and the other does not

= 2.4 =
* Handle BuddyPress' redirection of Register URL in Reveal Registration

= 2.3 =
* Add Setting to Reveal Home Page on a Private Site
* Fixed Problems with wp_registration_url function in WordPress prior to Version 3.6

= 2.2 =
* Add the WordPress User Self-Registration field to the plugin's Settings page
* Add the Settings page to the User submenu of Admin panel, too

= 2.1 =
* Add a settings checkbox to reveal the Register page for User Self-Registration

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

= 2.4.1 =
Home Page better URL matching for Root Home Pages

= 2.4 =
Support BuddyPress

= 2.3 =
New Setting to display Home Page on a Private Site.

= 2.2 =
Display WordPress Self-Registration field on plugin Settings page.

= 2.1 =
Allow User Self-Registration by "revealing" the Register page to those not logged in.

= 2.0 =
Create a Settings page that defines where the user ends up after logging in

= 1.1 =
Should eliminate Modify Header errors due to conflict with other plugins

= 1.0 =
Production version, updated to meet WordPress Repository standards