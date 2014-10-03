<?php

namespace arcane\log;

use \arcane\di\DIMgr;

trait DI
{
    use \arcane\di\DI;

    private static $log;
    public static function injectLog(Log $log)
    {
        self::$log = $log;
    }

    public static function log()
    {
        if (!isset(self::$log))
        {
	    $dimgr = DIMgr::instance();
	    $srv = $dimgr->find(Log::DINAME, __CLASS__);
	    self::injectLog($srv);
        }
        return self::$log;
    }
}
