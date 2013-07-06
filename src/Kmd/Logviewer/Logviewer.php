<?php namespace Kmd\Logviewer;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Psr\Log\LogLevel;
use ReflectionClass;

class Logviewer {
    
    public $sapi;
    public $date;
    public $level;
    public $empty;
    
    public function __construct($sapi, $date, $level = 'all')
    {
        $this->sapi = $sapi;
        $this->date = $date;
        $this->level = $level;
    }
    
    public function isEmpty()
    {
        return $this->empty;
    }
    
    public function log()
    {
        $this->empty = true;
        $log = array();
        
        $pattern = "/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}.*/";
        
        $log_levels = Lang::get('logviewer::logviewer.levels');
        
        $log_file = glob(storage_path() . '/logs/log-' . $this->sapi . '*-' . $this->date . '.txt');
        
        if ( ! empty($log_file))
        {
            $this->empty = false;
            $file = File::get($log_file[0]);
            
            // There has GOT to be a better way of doing this...
            preg_match_all($pattern, $file, $headings);
            $log_data = preg_split($pattern, $file);
            
            unset($log_data[0]); // Always seems to be empty...
            
            foreach ($headings as $h)
            {
                for ($i=0; $i < count($h); $i++)
                {
                    foreach ($log_levels as $ll)
                    {
                        if ($this->level == $ll OR $this->level == 'all')
                        {
                            if (strpos(strtolower($h[$i]), strtolower('log.' . $ll)))
                            {
                                $log[$i+1] = array('level' => $ll, 'header' => $h[$i], 'stack' => $log_data[$i+1]);
                            }
                        }
                    }
                }
            }
        }
        
        unset($headings);
        unset($log_data);
        
        return $log;
    }
    
    public function delete()
    {
        $log_file = glob(storage_path() . '/logs/log-' . $this->sapi . '*-' . $this->date . '.txt');
        
        if ( ! empty($log_file))
        {
            return File::delete($log_file[0]);
        }
    }

    public function getLevel()
    {
        $class = new ReflectionClass(new LogLevel);
        return $constants = $class->getConstants();
    }
    
}