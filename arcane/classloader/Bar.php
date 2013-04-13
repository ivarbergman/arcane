<?php

namespace arcane\classloader;



/**
 * Document for the Foo class
 * @isMine true
 */
class Bar extends Foo
{

  use \arcane\meta\Meta;

/**
 * Document for the test method
 * @
 */
  public function bar($val)
  {
    return strtoupper($val.$val);
  }
}