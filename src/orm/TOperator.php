<?php

namespace arcane\orm;

trait TOperator
{

  abstract function __eq($v);
  abstract function __ne($v);
  abstract function __lt($v);
  abstract function __le($v);
  abstract function __gt($v);
  abstract function __ge($v);
  abstract function __not($v);
  abstract function __in($v);
  abstract function __is($v);
  
}