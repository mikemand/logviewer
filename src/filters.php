<?php

Route::filter('logviewer.logs', function () {
    $logs = array();
    if (!Lang::has('logviewer::logviewer.sapi')) {
        App::setLocale('en');
    }

    $dirs = Config::get('logviewer::log_dirs');

    // List daily files
    foreach (Lang::get('logviewer::logviewer.sapi') as $sapi => $human) {
        $logs[$sapi]['sapi'] = $human;

        $files = array();

        foreach ($dirs as $app => $dir) {
            $files[$app] = glob($dir.'/log-'.$sapi.'*', GLOB_BRACE);
            if (is_array($files[$app])) {
                $files[$app] = array_reverse($files[$app]);
                foreach ($files[$app] as &$file) {
                    $file = preg_replace('/.*(\d{4}-\d{2}-\d{2}).*/', '$1', basename($file));
                }
            } else {
                $files[$app] = array();
            }

            // List files from custom list
            if (strpos(php_sapi_name(), $sapi) !== false) {
                foreach (Config::get('logviewer::custom_files') as $f) {
                    if (file_exists($dir . '/' . $f) && !in_array(basename($f), $files[$app])) {
                        $files[$app][] = $f;
                    }
                }

                // List files from custom file filter
                foreach (Config::get('logviewer::custom_glob_filter') as $filter) {
                    $custom_files = glob($dir . '/' . $filter, GLOB_BRACE);

                    if (is_array($custom_files)) {
                        foreach ($custom_files as $f) {
                            if (file_exists($f) && !in_array(basename($f), $files[$app])) {
                                $files[$app][] = basename($f);
                            }
                        }
                    }
                }
            }
        }

        $logs[$sapi]['logs'] = $files;
    }

    View::share('logs', $logs);
});

Route::filter('logviewer.messages', function () {
    if (Session::has('success') || Session::has('error') || Session::has('info')) {
        View::share('has_messages', true);
    } else {
        View::share('has_messages', false);
    }
});
