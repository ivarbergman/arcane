<?

namespace arcane;

class DB
{

    public static function di()
    {
        return di\DIMgr::get(db\DB::DINAME);
    }

    public static function execute($mixed)
    {
        $args  = func_get_args();
        $di = self::di();
        return call_user_func_array(array($di, "execute"), $args);
    }

    public static function batch($mixed)
    {
        $args  = func_get_args();
        $di = self::di();
        return call_user_func_array(array($di, "batch"), $args);
    }

    public static function get($mixed)
    {
        $args  = func_get_args();
        $di = self::di();
        return call_user_func_array(array($di, "get"), $args);
    }

    public static function fetch($mixed)
    {
        $args  = func_get_args();
        $di = self::di();
        return call_user_func_array(array($di, "fetch"), $args);
    }

    public static function fetchAll($mixed)
    {
        $args  = func_get_args();
        $di = self::di();
        return call_user_func_array(array($di, "fetchAll"), $args);
    }

    public static function uuid()
    {
        return self::di()->uuid();
    }

    public static function lastInsertId()
    {
        return self::di()->lastInsertId();
    }


}
