<?php

namespace arcane\meta;
use \SplFileInfo;
use \ReflectionClass;
use \arcane\classloader\ArcaneLoader;

class MetaClass implements \Serializable
{

    protected $hash;
    protected $name;
    protected $file;
    protected $reflection;

    protected $code;

    protected $methods;
    protected $interfaces;
    protected $parentclass;
    protected $doc;


    public function __construct($name)
    {
        $this->name = $name;
        $this->analys();
    }

    public function newInstance()
    {
        if (class_exists($this->name))
        {
            $r = new ReflectionClass($this->name);
            $args = func_get_args();
            $obj = $r->newInstanceArgs($args);
            return $obj;
        }
        return null;
    }

    public function newInstanceArgs($args)
    {
        if (class_exists($this->name))
        {
            $r = new ReflectionClass($this->name);
            $obj = $r->newInstanceArgs($args);
            return $obj;
        }
        return null;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMethod(string $name)
    {
        return $this->methods[$name];
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getMethodNames()
    {
        return array_keys($this->getMethods());
    }

    public function getParentClass()
    {
        return $this->parentclass;
    }

    public function getInterfaces()
    {
        return $this->interfaces;
    }

    public function getInterfaceNames()
    {
        $names = [];
        foreach ($this->interfaces as $i)
        {
            $names[] = $i;
        }
        return $names;
    }

    public function getTraitNames()
    {
        $names = [];
        foreach ($this->traits as $t)
        {
            $names[] = $t;
        }
        return $names;
    }


    public function getDoc()
    {
        return $this->doc;
    }

    public function hasInterface($interface)
    {
        $names = [];
        foreach ($this->interfaces as $i)
        {
            if ($i == $interface)
            {
                return true;
            }
        }
        return false;
    }

    public function hash()
    {
        if ($f = $this->file())
        {
            $ct = $f->getCTime();
            $size = $f->getSize();
            return md5($this->name.$size.$ct);
        }
    }

    public function file($file = null)
    {
        if ($file)
        {
            $this->file = $file;
            return ;
        }
        if (isset($this->file))
        {
            return $this->file;
        }
        $cl = $this->classloader();
        if ($cl)
        {
            $path = $cl->hasClass($this->name);
            if (!file_exists($path))
            {
                return false;
            }
            $this->file = new \SplFileInfo($path);
            return $this->file;
        }
    }

    public function reflection()
    {
        if (!isset($this->reflection))
        {
            $this->reflection = new \ReflectionClass($this->name);
        }
        return $this->reflection;
    }


    public function classloader()
    {
        $cls = spl_autoload_functions();
        //print_r($cls);
        foreach ($cls as $idx => $al)
        {
            if (is_array($al) && $al[0] instanceof ArcaneLoader)
            {
                $cl = $al[0];
                if ($cl->hasClass($this->name))
                {
 		    //echo get_class($cl) ." knows " . $this->name;
                    return $cl;
                }
            }
        }
        //echo "No classloader found for {$this->name}".PHP_EOL;
        return null;
    }


    private function analys()
    {
        $rc = $this->reflection();

        if ($f = $this->file())
        {
            $obj = $f->openFile();
            while (!$obj->eof()) {
                $this->code .= $obj->fgets();
            }
        }

        $this->methods = [];
        $methods = $rc->getMethods();
        foreach ($methods as $m)
        {
            $mm = new MetaMethod($this);
            $mm->analys($m);
            $this->methods[$mm->getName()] = $mm;
        }

        $this->interfaces = [];
        $interfaces = $rc->getInterfaceNames();
        foreach ($interfaces as $i)
        {
            $this->interfaces[] = $i;
        }

        $this->traits = [];
        $traits = $rc->getTraitNames();
        foreach ($traits as $t)
        {
            $this->traits[] = $t;
        }

        $pc = $rc->getParentClass();
        if ($pc)
        {
            $this->parentclass = new MetaClass($pc->getname());
        }
        $this->doc = $rc->getDocComment();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function export()
    {
        $str = sprintf('class %s', $this->getName());
        foreach ($this->getMethods() as $m)
        {
            $str .= PHP_EOL.$m->export();
        }
        $str .= PHP_EOL;
        return $str;
    }


    public function serialize()
    {
        $pathname = $this->file->getPathname();
        return serialize([$pathname, $this->hash,$this->name, $this->methods]);
        return serialize([$pathname, $this->hash,$this->name, $this->code,$this->methods]);
    }

    public function unserialize($str)
    {
        list($pathname, $this->hash,$this->name, $this->code,$this->methods ) = unserialize($str);
        list($pathname, $this->hash,$this->name, $this->methods ) = unserialize($str);
        $this->file = new SplFileInfo($pathname);
    }

}
