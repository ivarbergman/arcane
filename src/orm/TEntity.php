<?php

namespace arcane\orm;

trait TEntity
{

  private $conditions = [];

  public function save() {}
  public function insert() {}
  public function update() {}
  public function delete() {}
  public function feed() {}

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

  private function attribute($name, $type)
  {
    $this->$name = new Attribute($this, $name,$type);
    $this->__attr[$name] = $this->$name;
  }

  public function condition($lh, $op, $rh)
  {
    $this->conditions[] = new Condition($lh, $op, $rh);
  }

  public function __set($name, $value)
  {
    echo "__set($name, $value)".PHP_EOL;
    $m = "set$name";
    if (method_exists($this, "set$name"))
      {
	$this->$m($value);
      }
  }

  public function __get($name)
  {
    echo "__get($name)".PHP_EOL;
    return $this->$name;
  }

  protected $__attr;
  protected $__col;
  protected $__pk;
  protected $__rel;
  protected $__rev;


}