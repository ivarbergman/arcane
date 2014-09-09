<?php
namespace arcane\classloader;


use arcane\meta\Meta;
use arcane\meta\MetaMethod;
use arcane\meta\MetaProperty;
use arcane\meta\MetaAnnotation;
use arcane\meta\MetaObject;
use arcane\meta\Registry;
use arcane\meta\MetaClass;
use arcane\meta\MetaParameter;


class ClassIterator extends \FilterIterator
{

  protected $classloader;
  public $ns;
  public $nsDepth;

  public function __construct($classloader)
  {

    $this->classloader = $classloader;
    $it = new \RecursiveDirectoryIterator($this->classloader->getRootPath());
    $it = new \RecursiveIteratorIterator($it);

    parent::__construct($it);
    $this->ns = $this->classloader->getNamespace();
    $this->nsDepth = count(preg_split('/[\\\]/', $this->ns, null, PREG_SPLIT_NO_EMPTY));
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
    $c = parent::current();
    if ($c instanceof \SplFileInfo)
      {
	    $file = substr($c->getPathname(),0, -1*(strlen($c->getExtension())+1));
	$depth = $i->getDepth() + $this->nsDepth+1;
	$n = preg_split('/[\/]/',$file);
	$n = array_slice($n, count($n)-$depth);
	$classname = implode($n,'\\');
	$m = new MetaClass($classname, $this->classloader);
	return $m;
      }
    return null;
  }

}
