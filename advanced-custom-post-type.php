<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://profiles.wordpress.org/darshitrajyaguru97/
 * @since             1.0.0
 * @package           Advanced_Custom_Post_Type
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Custom Post Type
 * Plugin URI:        https://https://github.com/DarshitRajyaguru/advanced-custom-post-type-plugin.git
 * Description:       WordPress plugin that introduces a custom post type (CPT) with comprehensive features, including custom fields, taxonomies, a meta box with a text editor, administrative management, and versatile front-end display options.
 * Version:           1.0.0
 * Author:            Darshit
 * Author URI:        https://https://profiles.wordpress.org/darshitrajyaguru97//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-custom-post-type
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ADVANCED_CUSTOM_POST_TYPE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-custom-post-type-activator.php
 */
function activate_advanced_custom_post_type() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-custom-post-type-activator.php';
	Advanced_Custom_Post_Type_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-custom-post-type-deactivator.php
 */
function deactivate_advanced_custom_post_type() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-custom-post-type-deactivator.php';
	Advanced_Custom_Post_Type_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_advanced_custom_post_type' );
register_deactivation_hook( __FILE__, 'deactivate_advanced_custom_post_type' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-custom-post-type.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_advanced_custom_post_type() {

	$plugin = new Advanced_Custom_Post_Type();
	$plugin->run();

}
run_advanced_custom_post_type();
