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
 */

use GraphWidget\Endpoints;
use GraphWidget\Widget;
use GraphWidget\Setup;

define('PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ));
define('PLUGIN_URL_PATH', plugin_dir_url( __FILE__ ));

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if(class_exists('GraphWidget\Setup')) {
    new Setup();
}

if(class_exists('GraphWidget\Widget')) {
    new Widget();
}

if(class_exists('GraphWidget\Endpoints')) {
    new Endpoints();
}