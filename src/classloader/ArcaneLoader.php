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
                return $al[0];
            }
        }
        return new self();

    }

    public function getPrefixes()
    {
        return $this->prefixes;
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

    /**
     * Load the mapped file for a namespace prefix and relative class.
     *
     * @param string $prefix The namespace prefix.
     * @param string $relative_class The relative class name.
     * @return mixed Boolean false if no mapped file can be loaded, or the
     * name of the mapped file that was loaded.
     */
    public function getNamespaceDir($ns)
    {
        // are there any base directories for this namespace prefix?
        if (isset($this->prefixes[$ns]) === false) {
            return false;
        }

        // look through base directories for this namespace prefix
        foreach ($this->prefixes[$ns] as $base_dir) {

            // replace the namespace prefix with the base directory,
            // replace namespace separators with directory separators
            // in the relative class name, append with .php
            return $base_dir;
        }

        return false;
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
