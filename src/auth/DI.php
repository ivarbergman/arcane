<?php

namespace arcane\auth;

use \arcane\di\DIMgr;

trait DI  
{
  use \arcane\di\DITrait;

  private static $auth;
  public static function injectAuth(Auth $auth)
  {
    self::$auth = $auth;
  }

  public function auth()
  {
    if (!isset(self::$auth))
      {
	$dimgr = DIMgr::instance();
	$srv = $dimgr->find(Auth::DINAME, __CLASS__);
	self::injectAuth($srv);
      }
    return self::$auth;
  }
}