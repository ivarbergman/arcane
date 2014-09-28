<?

namespace arcane;

class Config
{

    public static function di()
    {
        return di\DIMgr::get(config\Config::DINAME);
    }

    public static function get($ns, $key = null)
    {
        return self::di()->get($ns, $key);
    }

    public static function set($value, $ns, $key = null)
    {
        return self::di()->set($value, $ns, $key);
    }

    public static function hasNs($ns)
    {
        return self::di()->hasNs($ns);
    }

    public static function load($ns, $path)
    {
        return self::di()->load($ns, $path);
    }


}
