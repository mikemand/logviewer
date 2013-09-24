<?php namespace Kmd\Logviewer;
 
use Illuminate\Support\Facades\Facade;
 
class LogviewerFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'logviewer'; }
 
}