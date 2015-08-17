<?php
return [
    'statsd' => [
        'namespace' => 'rum',
        'host' => 'collectd',
        'port' => 8125,
        'timeout' => 1.0 // Connection timeout in seconds
    ],
    // If you installed beacon in a subdirectory of your server,
    // specify it here. Otherwise it would be part of your metric name
    // Leave empty if you installed beacon in your server root
    'virtualroot' => '',
    'allowed_keys' => [
        // A comma separated list of allowed keys (as strings)
        // All other keys will be ignored
    ]
];
