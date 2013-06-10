<?php

Route::filter('logviewer.logs', function()
{
    $logs = array();
    $logs['apache']['sapi'] = 'Apache';
    $logs['apache']['logs'] = array_reverse(glob(storage_path().'/logs/log-apache*'));
    $logs['cli']['sapi'] = 'CLI (Artisan)';
    $logs['cli']['logs'] = array_reverse(glob(storage_path().'/logs/log-cli*'));
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    
    foreach ($logs['apache']['logs'] as &$file)
    {
        $file = preg_replace("/log-apache.+?-/", '', basename($file, '.txt'));
    }
    
    foreach ($logs['cli']['logs'] as &$file)
    {
        $file = preg_replace("/log-cli.+?/", '', basename($file, '.txt'));
    }
    
    View::share('logs', $logs);
});