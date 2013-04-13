<?php

namespace arcane\classloader;

/**
 * Document for the Foo class
 * @isMine true
 */
class Foo implements \Serializable
{
  private $v;
  use \arcane\meta\Meta;

/**
 * Document for the test method
 * @is false
 */
  public function test()
  {

  }

/**
 * Document for the test method
 * @
 */
  public function bar($val)
  {
    return $val.$val;
  }

  public function serialize()
  {
    return serialize([$this->v]);
  }

  public function unserialize($str)
  {
    list($this->v ) = unserialize($str);    
  }

}