<?php

namespace arcane\orm;

trait TStdOperator
{
  use TOperator;

  abstract function value();

  public function __eq($v)
  { 
    echo "__eq($v)".PHP_EOL;
    return $this->value() == $v;
  }
  public function __ne($v)
  { 
    return $this->value() != $v;
  }
  public function __lt($v)
  { 
    return $this->value() < $v;
  }
  public function __le($v)
  { 
    return $this->value() <= $v;
  }
  public function __gt($v)
  { 
    return $this->value() > $v;
  }
  public function __ge($v)
  { 
    return $this->value() >= $v;
  }
  public function __not($v)
  { 
    return $this->value() != $v;
  }
  public function __in($v)
  { 
    return array_search($v, $this->value());
  }
  public function __is($v)
  { 
    return $this->value() instanceof $v;
  }
  
}