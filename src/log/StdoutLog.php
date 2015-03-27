<?php

namespace arcane\log;

class StdoutLog implements Log
{

  private $level = 0;

  public function __construct()
  {

  }

  public function setLevel($level)
  {
    $this->level = $level;
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

  public function pass($level)
  {
    return $level <= $this->level;
  }

  protected function write($mix, $level)
  {
    if ( ! $this->pass($level)) return ;

    $out = $this->format($mix);
    echo $out . PHP_EOL;
  }

  protected function format($mix)
  {
    return print_r($mix, true);
  }

}
