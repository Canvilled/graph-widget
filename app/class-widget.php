<?php
/**
 * This is the namespace for the GraphWidget
 *
 * @package GraphWidget
 */

namespace GraphWidget;

/**
 * Class Widget
 *
 * This class defines the methods related to the WordPress widget.
 */
class Widget {

	/**
	 * Widget constructor.
	 *
	 * When it is instantiated, it adds an action to WordPress
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'register' ) );
	}

	/**
	 * This method is used to register the widget with WordPress
	 */
	public function register() {
		wp_add_dashboard_widget( 'graph_widget', 'Graph Widget', array( $this, 'render' ) );
	}

	/**
	 * This function is used to render the widget and its content
	 */
	public function render() {
		echo '<div id="graph_widget_render"></div>';
	}
}
