<?php

namespace arcane\orm;

trait TUser
{

  use Entity;

  public function init()
  {
    $this->attribute('id', 'int');
    $this->attribute('name', 'varchar');
    $this->attribute('email', 'varchar');
    $this->name('user');
  }


  public function setName($value)
  {
    $this->__attr['name']->value($value);
  }
  public function getName()
  {
    return $this->__attr['name'];
  }

  public function setEmail($value)
  {
    $this->__attr['email']->value($value);
  }
  public function getEmail()
  {
    return $this->__attr['email'];
  }

}