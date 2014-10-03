<?php

namespace arcane\orm;

trait TEntity
{

  private $conditions = [];
  private $isRecord = false;

  public function feed($values)
  {
      if (is_array($values) && count($values))
      {
          foreach ($values as $name => $value)
          {
              $this->___set($name, $value);
          }
      }
  }

  public function export()
  {
    $str = "Export: ".PHP_EOL;
    foreach ($this->__attr as $a)
      {
	$str .= $a->export().PHP_EOL;
      }
    $str .= "Conditions: ".PHP_EOL;
    foreach ($this->conditions as $c)
      {
	$str .= $c->export().PHP_EOL;
      }
    return $str;
  }

  public function __isRecord()
  {
      return $this->isRecord;
  }
  public function __attribute($var)
  {
      if (is_string($var))
      {
          return $this->__attr[$var];
      }
      if ($var instanceof Attribute)
      {
          $this->__attr[$var->name] = $var;
          return $this->__attr[$var->name];
      }
      return $this;
  }

  public function __condition($lh, $op, $rh)
  {
    $this->conditions[] = new Condition($lh, $op, $rh);
  }

  public function __set($name, $value)
  {
    return $this->___set($name, $value);
  }
  public function ___set($name, $value)
  {
    $m = "set$name";
    if (method_exists($this, $m))
      {
          return $this->$m($value);
      }
    return $this->__attribute($name)->set($value);
  }

  public function __get($name)
  {
      return $this->___get($name);
  }
  public function ___get($name)
  {
    $m = "get$name";
    if (method_exists($this, $m))
      {
          return $this->$m();
      }
    return $this->__attribute($name)->get();
  }

  protected $__attr;
  protected $__col;
  protected $__pk;
  protected $__rel;
  protected $__rev;


}