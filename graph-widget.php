<?php
/**
 * Graph Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Graph Widget
 * Description:       A widget that displays a graph.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Huy Nguyen
 * Text Domain:       graph-widget
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package           GraphWidget
 */

// Define path constants.
define( 'PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL_PATH', plugin_dir_url( __FILE__ ) );

// Check for composer autoload file and require it if it exists.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Function to autoload all files in a directory.
 *
 * @param string $dir Directory path.
 */
function autoload_all_files_in_directory( $dir ) {
	$dir = rtrim( $dir, '/' );  // Removing any accidental trailing slashes.

	foreach ( glob( "{$dir}/*.php" ) as $filename ) {
		require_once $filename;
	}
}

// Call the function for your 'app' directory.
autoload_all_files_in_directory( PLUGIN_DIR_PATH . 'app' );

// Initialize the Plugin Setup class.
if ( class_exists( 'GraphWidget\Setup' ) ) {
	new \GraphWidget\Setup( __FILE__ );
}

// Initialize the Widget class.
if ( class_exists( 'GraphWidget\Widget' ) ) {
	new \GraphWidget\Widget();
}

// Initialize the Endpoints class.
if ( class_exists( 'GraphWidget\endpoints' ) ) {
	new \GraphWidget\Endpoints();
}
