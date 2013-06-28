<?php

use Carbon\Carbon;
use Kmd\Logviewer\Logviewer;

Route::group(array('before' => 'logviewer.messages'), function ()
{
    Route::get('logviewer', function ()
    {
        $sapi = php_sapi_name();
        if (preg_match('/apache.*/', $sapi))
        {
            $sapi = 'apache';
        }
        $today = Carbon::today()->format('Y-m-d');
        
        if (Session::has('success') || Session::has('error'))
        {
            Session::reflash();
        }
        return Redirect::to('logviewer/' . $sapi . '/' . $today . '/all');
    });

    Route::get('logviewer/{sapi}/{date}/delete', function ($sapi, $date)
    {
        $logviewer = new Logviewer($sapi, $date);
        
        if ($logviewer->delete())
        {
			$today = Carbon::today()->format('Y-m-d');
            return Redirect::to('logviewer/'.$sapi.'/'.$today.'/all')->with('success', Lang::get('logviewer::logviewer.delete.success'));
        }
        else
        {
            return Redirect::to('logviewer/'.$sapi.'/'.$date.'/all')->with('error', Lang::get('logviewer::logviewer.delete.error'));
        }
    });

    Route::group(array('before' => 'logviewer.logs'), function ()
    {
        Route::get('logviewer/{sapi}/{date}/{level?}', function ($sapi, $date, $level = null)
        {
            if ($level === null)
            {
                $level = 'all';
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
});