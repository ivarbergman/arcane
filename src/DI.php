<?

namespace arcane;

class DI
{

    public static function classloader()
    {
        return classloader\ArcaneLoader::instance();
    }

    public static function di()
    {
        return di\DIMgr::instance();
    }

    public static function register($instance)
    {
        return self::di()->register($instance);
    }

    public static function find($interface, $targetClass = null)
    {
        return self::di()->find($interface, $targetClass);
    }

}
