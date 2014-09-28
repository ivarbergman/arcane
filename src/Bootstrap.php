<?

namespace arcane
{

    class Bootstrap
    {

        public static function run()
        {

        }

    }

}

namespace {

    if ( ! class_exists('Arc'))
    {
        class Arc
        {

            public static function dbg($mixed)
            {
                $dimgr = \arcane\di\DIMgr::instance();
                $log = $dimgr->find(\arcane\log\Log::DINAME);
                $log->dbg($mixed);
            }

            public static function classloader()
            {
                $cl = \arcane\classloader\ArcaneLoader::instance();
                return $cl;
            }

            public static function di()
            {
                $cl = self::classloader();
                return \arcane\di\DIMgr::instance($cl);
            }

        }
    }

}
