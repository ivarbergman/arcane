<?php

namespace arcane\meta;
use \SplFileInfo;
use \ReflectionParameter;

class MetaParameter implements \Serializable
{


  protected $method;
  protected $code;

  protected $doc;
  protected $name;


  public function __construct(MetaMethod $method)
  {
    $this->method = $method;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getDoc()
  {
    return $this->doc;
  }

  public function getName()
  {
    return $this->name;
  }


  public function analys(ReflectionParameter $p)
  {
    $this->name = $p->getName();
  }

  public function __toString()
  {
    return $this->getName();
  }

  public function export()
  {
    $str = sprintf('%s', $this->getName());
    return $str;
  }

  public function serialize()
  {
  }

  public function unserialize($str)
  {
  }

}