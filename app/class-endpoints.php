<?php
/**
 * Class Endpoints
 *
 * @package GraphWidget
 */

namespace GraphWidget;

use DateInterval;
use DateTime;
use Exception;

/**
 * Class Endpoints
 */
class Endpoints {

	/**
	 * Endpoints constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register' ) );
	}

	/**
	 * Register REST route.
	 */
	public function register() {
		register_rest_route(
			'graph-widget/v1',
			'/data',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_data' ),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
				'args'                => array(
					'days' => array(
						'validate_callback' => function ( $param ) {
							return is_numeric( $param );
						},
						'description'       => __( 'Number of days to fetch data for', 'graph-widget' ),
					),
				),
			)
		);
	}

	/**
	 * Get data.
	 *
	 * @param mixed $request Request Parameter.
	 *
	 * @throws Exception If an error occurs.
	 *
	 * @return array
	 */
	public function get_data( $request ) {
		global $wpdb;

		$days       = $request->get_param( 'days' );
		$table_name = esc_sql( $wpdb->prefix . 'graph_widget_data' );
		$data       = array();

		for ( $i = 0; $i < $days; $i++ ) {
			$date = new DateTime();
			$date->sub( new DateInterval( 'P' . $i . 'D' ) );
			$formatted_date = $date->format( 'Y-m-d' );
			$users          = $wpdb->get_var(
				$wpdb->remove_placeholder_escape(
					$wpdb->prepare( 'SELECT users FROM %i WHERE date = %s', $table_name, $formatted_date )
				)
			);
			$data[]         = array(
				'date'  => $formatted_date,
				'users' => $users,
			);
		}

		return $data;
	}
}
