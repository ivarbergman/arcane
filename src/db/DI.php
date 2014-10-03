<?php

namespace arcane\db;

use \arcane\di\DIMgr;

trait DI
{
    use \arcane\di\DI;

  private static $db;
  public static function injectDb(Db $db)
  {
    self::$db = $db;
  }

  public static function db()
  {
    if (!isset(self::$db))
      {
	$dimgr = DIMgr::instance();
	$srv = $dimgr->find(Db::DINAME, __CLASS__);
	self::injectDb($srv);
      }
    return self::$db;
  }
}