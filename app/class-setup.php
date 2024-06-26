<?php
/**
 * This file includes the Setup class for the GraphWidget plugin
 *
 * @package GraphWidget
 */

namespace GraphWidget;

use DateInterval;
use DateTime;

/**
 * Setup class.
 *
 * This class has methods for setting up and tearing down the plugin, including registering scripts and creating necessary database tables.
 */
class Setup {
	/**
	 * Holds the path to the main plugin file.
	 *
	 * @var string
	 */
	private $main_file;

	/**
	 * This is the constructor function for the setup class.
	 *
	 * @param string $main_file Path to the main plugin file.
	 */
	public function __construct( $main_file ) {
		$this->main_file = $main_file;

		register_activation_hook( $this->main_file, array( $this, 'on_activation' ) );
		register_deactivation_hook( $this->main_file, array( $this, 'on_deactivation' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_assets' ) );
	}

	/**
	 * Function to enqueue necessary Javascript and CSS for our graph widget.
	 *
	 * This function is called upon 'admin_enqueue_scripts' action.
	 */
	public function admin_enqueue_assets() {
		$screen = get_current_screen();

		if ( 'dashboard' === $screen->base ) {
			$asset_file = include PLUGIN_DIR_PATH . 'resources/public/scripts.asset.php';

			wp_enqueue_style( 'graph-widget', PLUGIN_URL_PATH . 'resources/public/scripts.css', array(), $asset_file['version'] );
			wp_enqueue_script( 'graph-widget', PLUGIN_URL_PATH . 'resources/public/scripts.js', array( 'wp-element', 'wp-components', 'wp-api-fetch' ), $asset_file['version'], true );
			wp_localize_script( 'graph-widget', 'graphWidget', array( 'restUrl' => esc_url_raw( rest_url( 'graph-widget/v1/data' ) ) ) );
		}
	}

	/**
	 * Function to create necessary database tables upon plugin activation.
	 *
	 * This function is called upon 'register_activation_hook'.
	 */
	public function on_activation() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'graph_widget_data';

		// SQL to create table.
		$sql = $wpdb->prepare(
			'CREATE TABLE %i (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      date date NOT NULL,
      users mediumint(9) NOT NULL,
      PRIMARY KEY  (id)
    )',
			$table_name
		);

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		// Insert dummy data.
		for ( $i = 0; $i < 30; $i++ ) {
			$date = new DateTime();
			$date->sub( new DateInterval( 'P' . $i . 'D' ) );

			$wpdb->insert(
				$table_name,
				array(
					'date'  => $date->format( 'Y-m-d' ),
					'users' => wp_rand( 0, 10000 ),
				)
			);
		}
	}

	/**
	 * Function to delete the database table on plugin deactivation.
	 *
	 * This function is called upon 'register_deactivation_hook'.
	 */
	public function on_deactivation() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'graph_widget_data';

		// Check if the result is in the cache.
		$result = wp_cache_get( $table_name, 'graph_widget' );

		if ( false === $result ) {
			// If the result is not in the cache, execute the query and save the result to the cache.
			$result = $wpdb->query( $wpdb->prepare( 'DROP TABLE IF EXISTS %i', $table_name ) );
			wp_cache_set( $table_name, $result, 'graph_widget' );
		}

		return $result;
	}
}
