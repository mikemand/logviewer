<?php

use Carbon\Carbon;
use Kmd\Logviewer\Logviewer;

$filters = Config::get('logviewer::filters.global');
if (isset($filters['before']))
{
    if ( ! is_array($filters['before']))
    {
        $filters['before'] = explode('|', $filters['before']);
    }
}
else
{
    $filters['before'] = array();
}
$filters['before'][] = 'logviewer.messages';
if (isset($filters['after']))
{
    if ( ! is_array($filters['after']))
    {
        $filters['after'] = explode('|', $filters['after']);
    }
}
else
{
    $filters['after'] = array();
}
Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function ()
{
    Route::get(Config::get('logviewer::base_url'), function ()
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
        return Redirect::to(Config::get('logviewer::base_url').'/' . $sapi . '/' . $today . '/all');
    });

    $filters = Config::get('logviewer::filters.delete');
    if (isset($filters['before']))
    {
        if ( ! is_array($filters['before']))
        {
            $filters['before'] = explode('|', $filters['before']);
        }
    }
    else
    {
        $filters['before'] = array();
    }
    if (isset($filters['after']))
    {
        if ( ! is_array($filters['after']))
        {
            $filters['after'] = explode('|', $filters['after']);
        }
    }
    else
    {
        $filters['after'] = array();
    }
    Route::get(Config::get('logviewer::base_url').'/{sapi}/{date}/delete', array('before' => $filters['before'], 'after' => $filters['after'], function ($sapi, $date)
    {
        $logviewer = new Logviewer($sapi, $date);
        
        if ($logviewer->delete())
        {
            $today = Carbon::today()->format('Y-m-d');
            return Redirect::to(Config::get('logviewer::base_url').'/'.$sapi.'/'.$today.'/all')->with('success', Lang::get('logviewer::logviewer.delete.success'));
        }
        else
        {
            return Redirect::to(Config::get('logviewer::base_url').'/'.$sapi.'/'.$date.'/all')->with('error', Lang::get('logviewer::logviewer.delete.error'));
        }
    }));

    $filters = Config::get('logviewer::filters.view');
    if (isset($filters['before']))
    {
        if ( ! is_array($filters['before']))
        {
            $filters['before'] = explode('|', $filters['before']);
        }
    }
    else
    {
        $filters['before'] = array();
    }
    $filters['before'][] = 'logviewer.logs';
    if (isset($filters['after']))
    {
        if ( ! is_array($filters['after']))
        {
            $filters['after'] = explode('|', $filters['after']);
        }
    }
    else
    {
        $filters['after'] = array();
    }
    Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function ()
    {
        Route::get(Config::get('logviewer::base_url').'/{sapi}/{date}/{level?}', function ($sapi, $date, $level = null)
        {
            if ($level === null)
            {
                $level = 'all';
            }
            
            $logviewer = new Logviewer($sapi, $date, $level);
            
            $log = $logviewer->log();

            $levels = $logviewer->getLevel();
            
            $page = Paginator::make($log, count($log), Config::get('logviewer::per_page', 10));
            
            return View::make('logviewer::viewer')
                       ->with('paginator', $page)
                       ->with('log', (count($log) > $page->getPerPage() ? array_slice($log, $page->getFrom(), $page->getPerPage()) : $log))
                       ->with('empty', $logviewer->isEmpty())
                       ->with('date', $date)
                       ->with('sapi', Lang::get('logviewer::logviewer.sapi.' . $sapi))
					   ->with('sapi_plain', $sapi)
					   ->with('url', Config::get('logviewer::base_url'))
                       ->with('levels', $levels);
        });
    });
});