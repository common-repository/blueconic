<?php
/*
Plugin Name: BlueConic
Plugin URI: https://support.blueconic.com/hc/en-us/articles/207842249-BlueConic-Wordpress-Plugin
Description: Add BlueConic to your pages.
Version: 1.4
Author: BlueConic
Author URI: https://www.blueconic.com/
*/
  defined('ABSPATH') or die('No script kiddies please!');

  function blueconic_settings_init() {
    register_setting('pluginPage', 'blueconic_settings', 'sanitize_blueconic_settings');

    add_settings_section(
      'blueconic_pluginPage_section',
      __('General information', 'wordpress'),
      'blueconic_settings_section_callback',
      'pluginPage'
    );

    add_settings_field(
      'blueconic_servername',
      __('BlueConic server name or script URL', 'wordpress'),
      'blueconic_servername_render',
      'pluginPage',
      'blueconic_pluginPage_section'
    );
  }

  // Register the settings initialization
  add_action('admin_init', 'blueconic_settings_init');

  // The function that defines the plugin options UI
  function blueconic_add_admin_menu() {
    add_options_page('BlueConic Options', 'BlueConic', 'manage_options', 'blueconic', 'blueconic_options_page');
  }

  // Register the function that creates the plugin options UI
  add_action('admin_menu', 'blueconic_add_admin_menu');

  function blueconic_servername_render() {
    $options = get_option('blueconic_settings');
    echo '<input type="text" name="blueconic_settings[blueconic_servername]" value="' . $options['blueconic_servername'] . '" placeholder="yourserver.blueconic.net" class="regular-text">';
  }

  function blueconic_settings_section_callback() {
    echo __('This plugin will take care of adding the BlueConic script to all pages to use BlueConic with your website, as described <a href="https://support.blueconic.com/hc/en-us/articles/200469792-Placing-the-BlueConic-script-on-your-website-pages" target="_blank">here</a>. Please provide either the BlueConic server name, or the source URL for the script. This is typically something like "yourserver.blueconic.net" or "https://fs91.yourdomain.com/script.js".', 'wordpress');
  }

  function sanitize_blueconic_settings($blueconic_settings) {
    $servername = $blueconic_settings['blueconic_servername'];
    $servername = trim(strtolower($servername));
    $blueconic_settings['blueconic_servername'] = $servername;

    return $blueconic_settings;
  }

  // The function that defines the options UI page
  function blueconic_options_page() {
    if (!current_user_can('manage_options'))  {
      wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    echo '<div class="wrap">';
    echo '<h2>BlueConic Settings</h2>';
    echo '<p>Enter the name of your BlueConic server.</p>';
    echo '<form method="post" action="options.php">';

    // FIXME: Create the actual options page (register setting, add setting, blablabla)
    // See: https://codex.wordpress.org/Creating_Options_Pages
    settings_fields( 'pluginPage' );
    do_settings_sections( 'pluginPage' );
    submit_button();

    echo '</form>';
    echo '</div>';
  }

  // The function to determine whether a string starts with another string
  function bcStartsWith($haystack, $needle) { 
    return (substr($haystack, 0, strlen($needle)) === $needle); 
  } 

  // The function to determine whether a string ends with another string
  function bcEndsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" ||
      (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
  }

  // The hook function that will be called on construction the contents of the head tag
  function blueconic_javascript() {
    $blueconic_settings = get_option('blueconic_settings');
    $servername = $blueconic_settings['blueconic_servername'];

    if (isset($servername) && !empty($servername)) {
      if (bcStartsWith($servername, 'https://') && bcEndsWith($servername, '.js')) {
        // $servername contains a script URL
        $script_url = $servername;
        $script_servername = parse_url($script_url, PHP_URL_HOST);
      } elseif (bcEndsWith($servername, '.blueconic.com') ||
          (bcEndsWith($servername, '.blueconic.net') && !bcEndsWith($servername, '.sb.blueconic.net'))) {
        // $servername contains the hostname of a standard BlueConic tenant.
        $script_url = 'https://cdn.blueconic.net/' . substr($servername, 0, strlen($servername) - strlen('.blueconic.net')) . '.js';
        $script_servername = 'cdn.blueconic.net';
      } else {
        // $servername contains a custom hostname, therefore we can't reliably know the CDN script URL
        $script_url = 'https://' . $servername . '/frontend/static/javascript/blueconic/blueconic.min.js';
        $script_servername = $servername;
      }

      // Optimize per https://developer.mozilla.org/en-US/docs/Web/Performance/dns-prefetch
      echo '<link rel="preconnect" href="https://' . $script_servername . '" crossorigin>';
      echo '<link rel="dns-prefetch" href="https://' . $script_servername . '">';

      // Add the actual script tag
      echo '<script src="' . $script_url . '"></script>';
    }
  }

  // Register the hook to add BlueConic javascript to the head tag
  add_action('wp_head', 'blueconic_javascript', 0);

?>
