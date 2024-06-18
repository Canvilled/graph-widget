<?php

namespace GraphWidget;

use DateInterval;
use DateTime;
use Exception;
use WP_Error;

class Endpoints
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register']);
    }

    public function register()
    {
        register_rest_route('graph-widget/v1', '/data', [
            'methods' => 'GET',
            'callback' => [$this, 'get_data'],
            'permission_callback' => '__return_true',
            'args' => [
                'days' => [
                    'validate_callback' => function ($param) {
                        return is_numeric($param);
                    }
                ]
            ],
        ]);
    }

    /**
     * @throws Exception
     */
    public function get_data($request)
    {
        $days = $request->get_param('days');

        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $date = new DateTime();
            $date->sub(new DateInterval('P' . $i . 'D'));
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'users' => rand(0, 10000) // Random number of users between 0 and 10000
            ];
        }

        return $data;
    }
}