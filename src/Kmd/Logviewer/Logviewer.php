<?php namespace Kmd\Logviewer;

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
        
        $log_levels = \Lang::get('logviewer::logviewer.levels');
        
        $log_file = glob(storage_path() . '/logs/log-' . $this->sapi . '*-' . $this->date . '.txt');
        
        if ( ! empty($log_file))
        {
            $this->empty = false;
            $file = \File::get($log_file[0]);
            
            // There has GOT to be a better way of doing this...
            preg_match_all($pattern, $file, $headings);
            if (empty($headings))
            {
                $this->empty = true;
                return $log;
            }
            $log_data = preg_split($pattern, $file);
            if (empty($log_data))
            {
                $this->empty = true;
                return $log;
            }
            
            unset($log_data[0]);
            
            foreach ($headings as $h)
            {
                if (empty($h))
                {
                    $this->empty = true;
                    return $log;
                }
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
        return 'I delete file nao, k?';
    }
    
}