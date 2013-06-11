<?php

use \Carbon\Carbon;
use Kmd\Logviewer\Logviewer;

Route::get('logviewer', function()
{
    $today = Carbon::today()->format('Y-m-d');
    
    return Redirect::to('logviewer/apache/'.$today.'/all');
});

Route::get('logviewer/{sapi}/{date}/delete', function($sapi, $date)
{
    $logviewer = new Logviewer($sapi, $date);
    
    return $logviewer->delete();
});

Route::group(array('before' => 'logviewer.logs'), function()
{
    Route::get('logviewer/{sapi}/{date}/{level?}', function($sapi, $date, $level = null)
    {
        if ($level === null)
        {
            return Redirect::to('logviewer/' . $sapi . '/' . $date . '/all');
        }
        
        $logviewer = new Logviewer($sapi, $date, $level);
        
        $log = $logviewer->log();
        
        $page = Paginator::make($log, count($log), Config::get('logviewer::per_page', 10));
        
        return View::make('logviewer::viewer')
                   ->with('paginator', $page)
                   ->with('log', (count($log) > $page->getPerPage() ? array_slice($log, $page->getFrom(), $page->getPerPage()) : $log))
                   ->with('empty', $logviewer->isEmpty())
                   ->with('date', $date)
                   ->with('sapi', Lang::get('logviewer::logviewer.sapi.' . $sapi));
    });
});