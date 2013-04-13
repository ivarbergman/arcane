<?php

namespace arcane\log;

class FileLog extends \arcane\di\DIService implements Log
{

  private $file;
  private $fp;

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
    fwrite($this->fp, $out);
    fflush($this->fp);
  }

  protected function isOpen()
  {
    if (!is_resource($this->fp))
      {
	return false;
      }
    $a = fstat($this->fp);
    return $a["nlink"] > 0;
  }

  protected function open()
  {
    if (!$this->isOpen())
      {
	$this->fp = fopen($this->file, "a");
      } 
  }

  protected function close()
  {
    if ($this->isOpen())
      {
	fclose($this->fp);
	unset($this->fp);
      }
  }

  protected function format($mix)
  {
    return print_r($mix, true);
  }

}
