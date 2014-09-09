<?php

namespace arcane\orm;

class Attribute
{
  use TConditionOp;

  private $name;
  private $type;
  private $value;
  private $entity;

  public function __construct($entity, $name, $type, $value = null)
  {
    $this->name = $name;
    $this->type = $type;
    $this->value = $value;
    $this->entity = $entity;
  }

  public function entity()
  {
    return $this->entity;
  }

  public function name()
  {
    return $this->name;
  }

  public function type()
  {
    return $this->type;
  }

  public function value($v = null)
  {
    if (isset($v))
      {
	$this->value = $v;
	return $this; 
      }
    return $this->value;
  }

  public function export()
  {
    return $this->name();
  }

  public function __toString()
  {
    return $this->name();
  }

  public function __set($name, $value)
  {
    echo "Attribute::__set($name, $value)".PHP_EOL;
    $m = "__$name";
    if (method_exists($this, $m))
      {
	$this->$m($value);
      }
  }


}