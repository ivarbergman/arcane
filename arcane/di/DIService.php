<?php

namespace arcane\di;

class DIService
{

  public static function diBind()
  {
    echo "DIService::diBind".PHP_EOL;
    $class = get_called_class();
    echo "DIService::diBind $class".PHP_EOL;
    $instance = new $class();
    $dimgr = DIMgr::instance();
    $dimgr->register($instance);
  }

}