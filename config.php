<?php
return [
    'statsd' => [
        'namespace' => 'rum',
        'host' => '127.0.0.1',
        'port' => 8125,
        'timeout' => 2 // Connection timeout in seconds
    ],
    'allowed_keys' => [
        // A comma separated list of allowed keys (as strings)
        // All other keys will be ignored
    ]
];
