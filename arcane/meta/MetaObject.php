<?php

namespace arcane\meta;

class MetaObject
{

  protected $name;



  public function __construct($name)
  {
    $this->name = $name;
  }


  public function getName()
  {
    return $this->name;
  }
}