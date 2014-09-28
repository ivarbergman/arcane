<?php

namespace arcane\config;

use \arcane\di\DIMgr;

trait DI
{
    use \arcane\di\DI;

    private static $config;
    public static function injectConfig(Config $config)
    {
        self::$config = $config;
    }

    public function config()
    {
        if (!isset(self::$config))
        {
	    $dimgr = DIMgr::instance();
	    $srv = $dimgr->find(Config::DINAME, __CLASS__);
	    self::injectConfig($srv);
        }
        return self::$config;
    }
}
