<?php namespace Kmd\Logviewer;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Psr\Log\LogLevel;
use ReflectionClass;

class Logviewer {
    
    public $path;
    public $sapi;
    public $date;
    public $level;
    public $empty;
    
    /**
     * Logviewer constructor
     * 
     * @access public
     * @param string
     * @param string
     * @param string
     * @param string
     */
    public function __construct($app, $sapi, $date, $level = 'all')
    {
        $log_dirs = Config::get('logviewer::log_dirs');
        $this->path = $log_dirs[$app];
        $this->sapi = $sapi;
        $this->date = $date;
        $this->level = $level;
    }
    
    /**
     * check if log is empty
     * 
     * @access public
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->empty;
    }
    
    /**
     * open and parse log
     * 
     * @access public
     * @return array
     */
    public function log()
    {
        $this->empty = true;
        $log = array();
        
        $pattern = "/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}.*/";
        
        $log_levels = $this->getLevels();
        
        $log_file = glob($this->path . '/log-' . $this->sapi . '*-' . $this->date . '.txt');
        
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
    
    /**
     * delete log
     * 
     * @access public
     * @return boolean
     */
    public function delete()
    {
        $log_file = glob($this->path . '/log-' . $this->sapi . '*-' . $this->date . '.txt');
        
        if ( ! empty($log_file))
        {
            return File::delete($log_file[0]);
        }
    }
    
    /**
     * get log levels from psr/log
     * 
     * @access public
     * @return array
     */
    public function getLevels()
    {
        $class = new ReflectionClass(new LogLevel);
        return $constants = $class->getConstants();
    }
    
}