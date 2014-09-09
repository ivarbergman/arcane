<?php

namespace arcane\di;

class DIMgr
{

    public static function instance()
    {
        if (!self::$instance)
        {
	    self::$instance = new static();
        }
        return self::$instance;
    }

    public function register($cl, $instance)
    {
        $classname = get_class($instance);
        $meta = \arcane\classloader\ClassLoader::getMetaClass($classname);
        if (!$meta)
        {
            throw new \Exception("Could not find Meta class fro $classname");
        }
        foreach ($meta->getInterfaces($classname) as $i)
        {
            $this->map[$i] = $instance;
        }
        return $this;
    }

    public function find($interface, $targetClass = null)
    {
        if (isset($this->map[$interface]))
        {
	    return $this->map[$interface];
        }
    }

    private $map;
    private static $instance;
    private function __construct()
    {
        $this->map = [];
    }
    private function __clone() { }

}
