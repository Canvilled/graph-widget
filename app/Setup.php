<?php

namespace GraphWidget;

class Setup
{
    function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_assets']);
    }

    function admin_enqueue_assets()
    {
        $asset_file = include( PLUGIN_DIR_PATH . 'resources/public/scripts.asset.php');
        wp_enqueue_style( 'graph-widget', PLUGIN_URL_PATH . 'resources/public/scripts.css', [], $asset_file['version']);
        wp_enqueue_script( 'graph-widget', PLUGIN_URL_PATH . 'resources/public/scripts.js', ['wp-element'],$asset_file['version'], true );
        wp_localize_script('graph-widget', 'graphWidget', [
            'restUrl' => esc_url_raw(rest_url('graph-widget/v1/data')),
        ]);
    }
}