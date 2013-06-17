<?php

use Psr\Log\LogLevel;

return array(
    
    'delete' => array(
        'error' => 'There was an error while deleting the log.',
        'success' => 'Log deleted successfully!',
        'text' => 'Delete Current Log',
    ),
    'empty_file'  => ':sapi log for :date appears to be empty. Did you manually delete the contents?',
    'levels' => array(
        'all' => 'all',
        'emergency' => LogLevel::EMERGENCY,
        'alert' => LogLevel::ALERT,
        'critical' => LogLevel::CRITICAL,
        'error' => LogLevel::ERROR,
        'warning' => LogLevel::WARNING,
        'notice' => LogLevel::NOTICE,
        'info' => LogLevel::INFO,
        'debug' => LogLevel::DEBUG,
    ),
    'no_log'  => 'No :sapi log available for :date.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'cli' => 'CLI',
    ),
    
);
