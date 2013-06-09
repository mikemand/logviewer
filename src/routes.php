<?php

use \Carbon\Carbon;

Route::get('log/view', function()
{
    $today = Carbon::today()->format('Y-m-d');
    
    return Redirect::to('log/apache/'.$today.'/all');
});

Route::get('log/{type}/{date}/delete', function($type, $date)
{
    return 'I delete file nao k?';
});

Route::group(array('before' => 'logviewer.logs'), function()
{
    Route::get('log/{type}/{date}/{level?}', function($type, $date, $level = null)
    {
        if ($level === null)
        {
            return Redirect::to('log/' . $type . '/' . $date . '/all');
        }
        
        $empty = true;
        $log = array();
        
        $pattern = "/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}.*/";
        
        $log_levels = Lang::get('logviewer::logviewer.levels');
        
        $log_file = glob(storage_path() . '/logs/log-' . $type . '*-' . $date . '.txt');
        
        if ( ! empty($log_file))
        {
            $empty = false;
            $file = File::get($log_file[0]);
            
            preg_match_all($pattern, $file, $headings);
            $log_data = preg_split($pattern, $file);
            
            unset($log_data[0]);
            
            foreach ($headings as $h)
            {
                for ($i=0; $i < count($h); $i++)
                {
                    foreach ($log_levels as $level)
                    {
                        if (strpos(strtolower($h[$i]), strtolower('log.' . $level)))
                        {
                            $log[$i+1] = array('level' => $level, 'log' => $h[$i] . "\n" . $log_data[$i+1]);
                        }
                    }
                }
            }
        }
        else
        {
            $log['empty'] = array('level' => 'info', 'log' => 'No log for ' . $date);
        }
        
        unset($headings);
        unset($log_data);
        
        $page = Paginator::make($log, count($log), 10);
        
        return View::make('logviewer::viewer')->with('log', $page)->with('empty', $empty);
    });
});