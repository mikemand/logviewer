<?php

return array(
    
    'base_url' => 'logviewer',
    'filters'  => array(
        'global' => array(),
        'view'   => array(),
        'delete' => array(),
    ),
    'log_dirs' => array('app' => storage_path().'/logs'),
    'per_page' => 10,
    'view'     => 'logviewer::viewer',
    
);