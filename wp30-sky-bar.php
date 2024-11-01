<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.terrytsang.com
 * @since             1.0.0
 * @package           WP30_Sky_Bar
 *
 * @wordpress-plugin
 * Plugin Name:       WP30 Sky Bar
 * Plugin URI:        www.terrytsang.com/wp30/sky-bar
 * Description:       A top bar for your message channel
 * Version:           1.0.0
 * Author:            Terry Tsang
 * Author URI:        www.terrytsang.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp30-sky-bar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP30_SKY_BAR_VERSION', '1.0.0' );

if ( !defined( 'WP30_SKY_BAR_PLUGIN_DIR') )
    define( 'WP30_SKY_BAR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if ( !defined( 'WP30_SKY_BAR_PLUGIN_URL') )
    define( 'WP30_SKY_BAR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( !defined( 'WP30_SKY_BAR_PLUGIN_BASE') )
    define( 'WP30_SKY_BAR_PLUGIN_BASE', plugin_basename(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp30-sky-bar-activator.php
 */
function activate_wp30_sky_bar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp30-sky-bar-activator.php';
	WP30_Sky_Bar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp30-sky-bar-deactivator.php
 */
function deactivate_wp30_sky_bar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp30-sky-bar-deactivator.php';
	WP30_Sky_Bar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp30_sky_bar' );
register_deactivation_hook( __FILE__, 'deactivate_wp30_sky_bar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp30-sky-bar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp30_sky_bar() {

	$plugin = new WP30_Sky_Bar();
	$plugin->run();

}
run_wp30_sky_bar();