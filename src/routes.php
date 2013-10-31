<?php

use Carbon\Carbon;
use Kmd\Logviewer\Logviewer;

$filters = $this->app['config']['logviewer::filters.global'];

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
    Route::get($this->app['config']['logviewer::base_url'], function ()
    {
        $sapi = php_sapi_name();

        if (preg_match('/apache.*/', $sapi))
        {
            $sapi = 'apache';
        }

        $today = Carbon::today()->format('Y-m-d');
        
        $dirs = $this->app['config']['logviewer::log_dirs'];
        reset($dirs);
        
        $path = key($dirs);
        
        if (Session::has('success') || Session::has('error'))
        {
            Session::reflash();
        }

        return Redirect::to($this->app['config']['logviewer::base_url'] . '/' . $path . '/' . $sapi . '/' . $today . '/all');
    });

    $filters = $this->app['config']['logviewer::filters.delete'];

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

    Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function ()
    {
        Route::get($this->app['config']['logviewer::base_url'].'/{path}/{sapi}/{date}/delete', function ($path, $sapi, $date)
        {
            $logviewer = new Logviewer($path, $sapi, $date);
            
            if ($logviewer->delete())
            {
                $today = Carbon::today()->format('Y-m-d');
                return Redirect::to($this->app['config']['logviewer::base_url'] . '/' . $path . '/' . $sapi . '/' . $today .'/all')->with('success', Lang::get('logviewer::logviewer.delete.success'));
            }
            else
            {
                return Redirect::to($this->app['config']['logviewer::base_url'] . '/' . $path . '/' . $sapi . '/' . $date . '/all')->with('error', Lang::get('logviewer::logviewer.delete.error'));
            }
        });
    });

    $filters = $this->app['config']['logviewer::filters.view'];

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
        Route::get($this->app['config']['logviewer::base_url'].'/{path}/{sapi}/{date}/{level?}', function ($path, $sapi, $date, $level = null)
        {
            if (is_null($level) || !is_string($level))
            {
                $level = 'all';
            }
            
            $logviewer = new Logviewer($path, $sapi, $date, $level);
            
            $log = $logviewer->log();

            $levels = $logviewer->getLevels();
            
            $paginator = new \Illuminate\Pagination\Environment($this->app['request'], $this->app['view'], $this->app['translator']);

            $view = $this->app['config']['logviewer::pagination_view_name'];

            if (is_null($view) || !is_string($view))
            {
                $view = $app['config']['view.pagination'];
            }

            $paginator->setViewName($view);

            $per_page = $this->app['config']['logviewer::per_page'];

            if (is_null($per_page) || !is_int($per_page))
            {
                $per_page = 10;
            }

            $page = $paginator->make($log, count($log), $per_page);

            return View::make($this->app['config']['logviewer::view'])
               ->with('paginator', $page)
               ->with('log', (count($log) > $page->getPerPage() ? array_slice($log, $page->getFrom()-1, $page->getPerPage()) : $log))
               ->with('empty', $logviewer->isEmpty())
               ->with('date', $date)
               ->with('sapi', $this->app['translator']->get('logviewer::logviewer.sapi.' . $sapi))
               ->with('sapi_plain', $sapi)
               ->with('url', $this->app['config']['logviewer::base_url'])
               ->with('levels', $levels)
               ->with('path', $path);
        });
    });
});
