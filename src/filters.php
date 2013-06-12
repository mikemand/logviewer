<?php

Route::filter('logviewer.logs', function()
{
    $logs = array();
    foreach (Lang::get('logviewer::logviewer.sapi') as $sapi => $human)
    {
        $logs[$sapi]['sapi'] = $human;
        $files = array_reverse(glob(storage_path().'/logs/log-'.$sapi.'*'));
        foreach ($files as &$file)
        {
            $file = preg_replace('/log-.+?-/', '', basename($file, '.txt'));
            // $file = preg_replace('/.*(\d{4}-\d{2}-\d{2}).*/', '$1', basename($file)); // Is this faster?
        }
        $logs[$sapi]['logs'] = $files;
    }
    
    View::share('logs', $logs);
});

Route::filter('logviewer.messages', function()
{
    if (Session::has('success') OR Session::has('error') OR Session::has('info'))
    {
        View::share('has_messages', true);
    }
    else
    {
        View::share('has_messages', false);
    }
});