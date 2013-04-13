<?php
namespace arcane\classloader;

class MReflectionClass extends \ReflectionClass
{

  protected $code;

  public function getCode()
  {
    if (!isset($this->code))
      {
	$fn = $this->getFileName();
	if (file_exists($fn))
	  {
	    $this->code = file_get_contents($fn);
	  }
      }
      
    return $this->code;      
  }

  public function getMethod(string $name)
  {

  }

  public function getMethods(string $name)
  {

  }

  public function getAnnotation()
  {

  }


}
