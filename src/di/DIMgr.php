<?php

namespace arcane\di;

class DIMgr
{
    private $classloader;
    public static function instance($classloader = null)
    {
        if (!self::$instance)
        {
            if ( ! $classloader)
            {
                $classloader = \arcane\classloader\ArcaneLoader::instance();
            }
	    self::$instance = new static($classloader);
        }
        return self::$instance;
    }

    public function register($instance)
    {
        $classname = get_class($instance);

        $meta = $this->classloader->getMetaClass($classname);
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

    public static function get($interface)
    {
        $dim = self::instance();
        return $dim->find($interface);
    }

    private $map;
    private static $instance;
    private function __construct($classloader)
    {
        $this->map = [];
        $this->classloader = $classloader;
    }
    private function __clone() { }

}
