<?php

namespace arcane\orm;

trait TConditionOp
{
  use TOperator;

  private $cond = [];

  abstract function entity();
  abstract function value();

  private function addCondition($op, $v)
  {
    $this->entity()->condition($this, $op, $v);
  }

  public function __eq($v)
  { 
    $this->addCondition('eq', $v);
    return $this;
  }
  public function __ne($v)
  { 
    $this->addCondition('ne', $v);
    return $this;
  }
  public function __lt($v)
  { 
    $this->addCondition('lt', $v);
    return $this;
  }
  public function __le($v)
  { 
    $this->addCondition('le', $v);
    return $this;
  }
  public function __gt($v)
  { 
    $this->addCondition('gt', $v);
    return $this;
  }
  public function __ge($v)
  { 
    $this->addCondition('ge', $v);
    return $this;
  }
  public function __not($v)
  { 
    $this->addCondition('not', $v);
    return $this;
  }
  public function __in($v)
  { 
    $this->addCondition('in', $v);
    return $this;
  }
  public function __is($v)
  { 
    $this->addCondition('is', $v);
    return $this;
  }
  
}