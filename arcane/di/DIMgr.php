<?php

namespace arcane\di;

class DIMgr
{

  public static function instance()
  {
    if (!self::$instance)
      {
	self::$instance = new static();
      }
    return self::$instance;
  }

  public function register($instance)
  {
    $cl = ClassLoader::instance();
    echo "DIMgr register ".get_class($instance).PHP_EOL;
    foreach ($cl->meta->getInterfaces($instance) as $i)
      {
	echo "DIMgr register $i".PHP_EOL;
	$this->map[$i] = $instance;      
      }
    return $this;
  }

  public function find($interface, $targetClass = null)
  {
    if (isset($this->map[$interface]))
      {
	return $this->map[$interface];
      }  
  }

  private $map;
  private static $instance;
  private function __construct()
  {
    $this->map = [];
  }
  private function __clone() { }

}