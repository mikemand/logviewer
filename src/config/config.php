<?php

return array(

    'base_url'      => 'logviewer',
    'filters'       => array(
        'global'    => array(),
        'view'      => array(),
        'delete'    => array()
    ),
    'log_dirs'      => array('app' => storage_path().'/logs'),
    'log_order'     => 'desc', // Change to 'desc' for the latest entries first
    'per_page'      => 10,
    'view'          => 'logviewer::viewer',
    'p_view'        => 'pagination::slider',

    // Allow to use custom file list or custom file name filtering
    'custom_files'  => array(), // custom log files e.g. 'laravel.log'
    'custom_glob_filter' => array(), // custom filter for glob e.g. '*.log'
);
