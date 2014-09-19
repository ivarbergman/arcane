<?php

namespace arcane\log;

class StdLog implements Log
{

  public function __construct()
  {
    
  }

  public function log($mix)
  {
    $this->write($mix, E_USER_WARNING);
  }

  public function error($mix)
  {
    $this->write($mix, E_USER_ERROR);
  }

  public function dbg($mix)
  {
    $this->write($mix, E_USER_NOTICE);
  }

  protected function write($mix, $level)
  {
    $out = $this->format($mix);
    trigger_error($out, $level);
  }

  protected function format($mix)
  {
    return print_r($mix, true);
  }

}
