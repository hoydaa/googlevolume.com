<?php

function logLine($message) {
  echo "[".date('d/m/Y H:i:s'). "] " . $message."\n";
}

class StopWatch 
{
    private $start;
    private $end;
    
    public function start()
    {
        $this->start = time();
    }
    
    public function end()
    {
        $this->end = time();
    }
    
    public function getTime()
    {
        return $this->end-$this->start;
    }
    
}