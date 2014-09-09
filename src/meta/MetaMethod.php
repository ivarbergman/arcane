<?php

namespace arcane\meta;
use \SplFileInfo;
use \ReflectionMethod;

class MetaMethod implements \Serializable
{


  protected $class;
  protected $code;

  protected $doc;
  protected $name;
  protected $modifiers;
  protected $parameters;


  public function __construct(MetaClass $class)
  {
    $this->class = $class;
  }

  public function getClass()
  {
    return $this->class;
  }

  public function getDoc()
  {
    return $this->doc;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getParameters()
  {
    return $this->parameters;
  }

  public function getParameterNames()
  {
    return array_keys($this->getParameters());
  }

  public function getModifiers()
  {
    return $this->modifiers;
  }


  public function analys(ReflectionMethod $m)
  {
    $this->doc = $m->getDocComment();
    $this->name = $m->getName();
    $this->parameters = [];
    $this->modifiers = $m->getModifiers();

    foreach ($m->getParameters() as $p)
      {
	$mp = new MetaParameter($this);
	$mp->analys($p);
	$this->parameters[$mp->getName()] = $mp;
      }
  }

  public function __toString()
  {
    return $this->getName();
  }

  public function export()
  {
    $pp = [];
    foreach ($this->getParameters() as $p)
      {
	$pp[] = $p->export();
      }
    $str = '';
    if ($d = $this->getDoc())
      {
	$str .= "\t".str_replace("\n","\n\t", $d)."\n";
      }
    $str .= sprintf("\t%s function %s(%s)", 
		   implode(' ', \Reflection::getModifierNames($this->getModifiers())), 
		   $this->getName(), 
		   implode($pp,', '));
    return $str;
  }

  public function serialize()
  {
  }

  public function unserialize($str)
  {
  }

}