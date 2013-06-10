<?php

use Psr\Log\LogLevel;

return [
    
    'delete' => 'Delete Current Log',
    'empty'  => 'No :sapi log available for :date.',
    'levels' => [
        'all' => 'all',
        'emergency' => LogLevel::EMERGENCY,
        'alert' => LogLevel::ALERT,
        'critical' => LogLevel::CRITICAL,
        'error' => LogLevel::ERROR,
        'warning' => LogLevel::WARNING,
        'notice' => LogLevel::NOTICE,
        'info' => LogLevel::INFO,
        'debug' => LogLevel::DEBUG,
    ],
    'sapi'   => [
        'apache' => 'Apache',
        'cli' => 'CLI'
    ],
    
];