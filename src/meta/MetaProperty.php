<?php

namespace arcane\meta;
use \SplFileInfo;
use \ReflectionParameter;

class MetaProperty implements \Serializable
{


  protected $class;

  protected $doc;
  protected $name;
  protected $modifiers;


  public function __construct(MetaClass $class)
  {
    $this->class = $class;
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


  public function analys(ReflectionProperty $p)
  {
    $this->name = $p->getName();
    $this->doc = $p->getDocComment();
    $this->modifiers = $p->getModifiers();
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
    return serialize([$this->hash,$this->name, $this->code,$this->methods]);
  }

  public function unserialize($str)
  {
    list($pathname, $this->hash,$this->name, $this->code,$this->methods ) = unserialize($str);    
    $this->file = new SplFileInfo($pathname);
  }

}