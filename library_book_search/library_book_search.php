<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Library_book_search
 *
 * @wordpress-plugin
 * Plugin Name:       Library Book Search
 * Plugin URI:        #
 * Description:       Plugin​ ​is​ ​based​ ​on​ ​library​ ​book​ ​search​ ​which​ ​will​ ​be​ ​based​ ​on​ ​book​ ​name,​ ​author, publisher,​ ​price​ ​(​ ​use​ ​ranger​ ​),​ ​book​ ​rating.
 * Version:           1.0.0
 * Author:            Maulik Panchal
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       library_book_search
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-library_book_search-activator.php
 */
function activate_library_book_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-library_book_search-activator.php';
	Library_book_search_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-library_book_search-deactivator.php
 */
function deactivate_library_book_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-library_book_search-deactivator.php';
	Library_book_search_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_library_book_search' );
register_deactivation_hook( __FILE__, 'deactivate_library_book_search' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-library_book_search.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_library_book_search() {

	$plugin = new Library_book_search();
	$plugin->run();

}
run_library_book_search();
