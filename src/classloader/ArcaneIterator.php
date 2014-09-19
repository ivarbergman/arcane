<?

namespace arcane\classloader;

use \arcane\meta\MetaClass;

class ArcaneIterator extends \FilterIterator
{
    public $classloader;
  public function __construct($classloader)
  {
        $this->classloader = $classloader;
        $dirs = array_values($this->classloader->getBaseDirs());

        $ap = new \AppendIterator();
        foreach ($dirs as $path)
        {
            $it = new \RecursiveDirectoryIterator($path);
            $it = new \RecursiveIteratorIterator($it);
            $ap->append($it);
        }
        parent::__construct($ap);

  }

  public function accept()
  {
        $c = parent::current();
        if ($c && preg_match('/^[A-Z].*\.php$/', $c->getBasename()))
        {
            return true;
        }
        return false;
    }
    
    public function current()
    {
        $i = $this->getInnerIterator();
        $f = parent::current();
        if ($f instanceof \SplFileInfo)
        {
            $file = $f->getPathname() ;
            $cl = $this->classloader->getClassname($file);

	    $m = new MetaClass($cl, $this->classloader);
            $m->file($f);
	    return $m;
        }
        return null;
    }
    
}
