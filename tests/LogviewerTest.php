<?php

use Kmd\Logviewer\Logviewer;

class LogviewerTest extends PHPUnit_Framework_TestCase {
    
    public $logviewer;
    
    public function setUp()
    {
        $this->logviewer = new Logviewer('app', 'cgi-fcgi', '2013-06-01');
        
        parent::setUp();
    }
    
    public function tearDown()
    {
        $this->logviewer = null;
    }
    
    public function testLogLevels()
    {
        $levels = array(
            'EMERGENCY' => 'emergency',
            'ALERT' => 'alert',
            'CRITICAL' => 'critical',
            'ERROR' => 'error',
            'WARNING' => 'warning',
            'NOTICE' => 'notice',
            'INFO' => 'info',
            'DEBUG' => 'debug',
        );
        
        $psr = $this->logviewer->getLevels();
        
        $this->assertEquals(count($levels), count($psr));
        
        $this->assertEquals($levels, $psr);
    }
    
    public function testLogAggregationRegex()
    {
        $date = '2013-06-01';
        
        $pattern = '/.*(\d{4}-\d{2}-\d{2}).*/';
        
        $files = array(
            '/path/to/laravel/app/storage/logs/log-cli-2013-06-01.txt',
            '/path/to/laravel/app/storage/logs/log-apache2handler-2013-06-01.txt',
            '/path/to/laravel/app/storage/logs/log-apache2filter-2013-06-01.txt',
            '/path/to/laravel/app/storage/logs/log-apache-2013-06-01.txt',
            '/path/to/laravel/app/storage/logs/log-cgi-fcgi-2013-06-01.txt',
        );
        
        foreach ($files as &$file)
        {
            $file = preg_replace($pattern, '$1', basename($file));
            $this->assertEquals($file, $date);
        }
    }
    
}