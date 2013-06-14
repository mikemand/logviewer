<?php

class LogviewerTest extends PHPUnit_Framework_TestCase {
    
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