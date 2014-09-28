<?

namespace arcane;

class Log
{

    public static function di()
    {
        return di\DIMgr::get(log\Log::DINAME);
    }

    public static function dbg($mixed)
    {
        return self::di()->dbg($mixed);
    }

    public static function log($mixed)
    {
        return self::di()->log($mixed);
    }

}
