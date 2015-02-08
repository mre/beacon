<?php
return [
    'statsd' => [
        'namespace' => 'rum',
        'escape_char' => '_',
        'host' => '127.0.0.1',
        'port' => 8125,
        'timeout' => 2 // Connection timeout in seconds
    ],
    'send_keys' => [
        // For more info see
        // https://developer.mozilla.org/en-US/docs/Navigation_timing
        'nt_con', // Connection
        'nt_dns', // DNS lookup
        'nt_domcomp', // DOM complete
        'nt_domcontloaded', // DOM content loaded
        'nt_domint', // DOM interactive
        'nt_domloading', // DOM loading
        'nt_fet', // Fetch
        'nt_load', // LoadEvent
        'nt_nav', // Navigation start
        'nt_nav_type', // Navigation type
        'nt_red_cnt', // Redirect count
        'nt_red', // Redirect
        'nt_req', // Request
        'nt_res', // First byte time
        'nt_unload', // Unload event
        'u', // Original requested url
        'v', // Boomerang version
        // Add optional custom parameters here
        'page_id'
    ]
];

