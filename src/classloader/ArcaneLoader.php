<?php
namespace arcane\classloader;

use arcane\meta\MetaClass;


class ArcaneLoader extends Psr4AutoloaderClass
{


    private $cacheFile = '/tmp/cacheFile.dat';
    private $prefix;
    private $base_dir;

    private $mapClassToFile = [];
    private $mapFileToClass = [];
    private $mapMeta = [];

    /**
     * Creates a new <tt>SplClassLoader</tt> that loads classes of the
     * specified namespace.
     *
     * @param string $ns The namespace to use.
     */
    public function __construct()
    {

    }

    public static function instance()
    {
        $cls = spl_autoload_functions();
        foreach ($cls as $idx => $al)
        {
            if (is_array($al) && $al[0] instanceof ArcaneLoader)
            {
                //echo get_class($al[0]) .PHP_EOL;
                return $al[0];
            }
        }
        return new self();

    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function fileToClassname($file)
    {
        $s = preg_replace("/^{$this->base_dir}/");
    }

    public function getMetaClass($classname)
    {
        if ( ! isset($this->mapMeta[$classname]))
        {
            $this->mapMeta[$classname] = new MetaClass($classname, $this);
        }
        return $this->mapMeta[$classname];
    }

    public function getBaseDir()
    {
        return $this->base_dir;
    }


    public function register()
    {
        parent::register();
        $it = $this->iterator();        
        foreach ($it as $f)
        {
            $pathname = $f->file()->getPathname();
            $classname = $f->getName();
            $this->mapClassToFile[$classname] = $pathname;
            $this->mapFileToClass[$pathname] = $classname;
            $this->mapMeta[$classname] = new MetaClass($classname, $this);
        }
        return $this;
    }

    public function iterator()
    {
        $it = new ArcaneIterator($this);
        return $it;
    }


}
