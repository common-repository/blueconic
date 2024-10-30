=== BlueConic ===
Contributors: blueconic
Tags: blueconic
Requires at least: 3.9
Tested up to: 5.8.1
Stable tag: 1.4
License: ASL 2.0
License URI: http://www.apache.org/licenses/LICENSE-2.0

Use BlueConic with your website.

== Description ==
*About BlueConic:* BlueConic is a Customer Data Platform that harnesses the data required to power the recognition of an individual at each interaction, and then synchronizes their intent across the marketing ecosystem. Click [here](https://www.blueconic.com/solutions) to learn more.

This plugin will place the [BlueConic JavaScript tag](https://support.blueconic.com/hc/en-us/articles/200469792) on all pages to allow you to work with BlueConic and collect data or interact with visitors.

== Installation ==
1. Open "Plugins > Add new" and upload the plugin "blueconic.zip". Alternatively, unpack "blueconic.zip" and upload "blueconic.php" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Open "Settings > BlueConic", enter your BlueConic server name or BlueConic script URL and save the changes.

== Frequently Asked Questions ==
= What is my BlueConic server name? =
Log in to your BlueConic server. The address bar contains your server name, among other things.
Copy the address, which will look something like the example below:

    https://server.blueconic.net/blueconic/static/pages/main.html

Your server name is the first part between the slashes, it contains dots and probably ends in ".blueconic.net". The servername in the example above is:

    server.blueconic.net

= The script tag does not appear in the page? =
You may need to empty all caches before the script tags start appearing on your pages.

If this doesn't help, the problem might lie in the theme that you are using. The plugin works by virtue of the "wp_head" filter being called. If this filter is not being used in the theme, nothing will be inserted. Ask the developer of your theme for assistance.

= How can I get BlueConic? =
That's easy! Just find the plan that is right for you at https://www.blueconic.com/pricing/. Or [contact us](https://www.blueconic.com/contact/).


== Changelog ==
= 1.4 =
* Allow entering a specific script URL.
* Tested up to WordPress 5.8.1.

= 1.3 =
* Optimize for DNS prefetching.
* Tested up to WordPress 5.6.

= 1.2 =
* Tested up to WordPress 5.3.2.

= 1.1 =
* Use unique function names.

= 1.0 =
* Initial release.
