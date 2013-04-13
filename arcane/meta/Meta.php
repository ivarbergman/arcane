<?php

namespace arcane\meta;

trait Meta
{
  public static function __class()
  {
    return static::__meta();
  }
  public static function __meta()
  {
    $m = ClassLoader::getMetaClass(get_called_class());
    return $m;
  }
  public static function __interfaces()
  {
    $m = static::__meta();    
    return $m->getInterfaceNames();
  }
  public static function __parent()
  {
    $m = static::__meta();
    return $m->getParentClass();
  }
  public static function __injected()
  {
    return [];
  }
  public static function __annotation()
  {
    return [];
  }
  public static function __methods()
  {
    $m = static::__meta();
    return $m->getMethods();
  }
  public static function __listeners()
  {
    return [];
  }
  public static function __events()
  {
    return [];
  }
  public static function __traits()
  {
    $m = static::__meta();    
    return $m->getTraitNames();
  }
  public static function __hash()
  {
    $m = static::__meta();
    return $m->getClassname().' hash '.$m->hash();
  }
  public static function __doc()
  {
    $m = static::__meta();
    return $m->getDoc();
  }
}
