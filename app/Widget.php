<?php

namespace GraphWidget;

class Widget
{
    public function __construct()
    {
        add_action('wp_dashboard_setup', [$this, 'register']);
    }

    public function register()
    {
        wp_add_dashboard_widget('graph_widget', 'Graph Widget', [$this, 'render']);
    }

    public function render()
    {
        echo '<div id="graph_widget_render"></div>';
    }
}