<?php

namespace arcane\fs;

class FS
{

  public $root;

  public function __construct($root)
  {
    if (!file_exists($root))
      {
	mkdir($root);
      }
    $this->root = realpath($root);
  }

  public function prepare_dir($file)
  {
    $dir = pathinfo($file, PATHINFO_DIRNAME);
    $dir = preg_split("/\//", $dir);

    $path = $this->root;
    while($p = array_shift($dir))
      {
	$path = $this->build_abs_path($path, $p);
	if (!file_exists($path))
	  {
	    mkdir($path);
	  }
      }

  }

  public function md5()
  {
    $files = $this->find(array('.*'));
    $str = '';
    foreach ($files as $f)
      {
	$f = $this->file_path($f);
	$str .= filemtime($f).filesize($f).$f;
      }
    return md5($str);
  }

  public function file_path($file)
  {
    $path = $this->build_abs_path($this->root, $file);
    return $path;
  }

  public function file_exists($file)
  {
    $path = $this->file_path($file);
    return file_exists($path);
  }

  public function file_content($file, $content = null)
  {
    $path = $this->build_abs_path($this->root, $file);
    $result = null;
    if (func_num_args() == 2)
      {
	$this->prepare_dir($file);
	$result = file_put_contents($path, $content);
      }
    else
      {
	if (file_exists($path))
	  {
	    $result = file_get_contents($path);
	  }
      }
    return $result;
  }

  public function find($ext = null, $dir = null, &$files = null)
  {
    if (is_null($ext))
      {
	$ext = array('php', 'html');
      }

    if (is_null($dir))
      {
	$dir = $this->root;
      }

    $pattern = implode($ext, '|');

    if (is_null($files))
      {
	$files = array();
      }

    $items = glob($dir . '/*');
    foreach ($items as $file)
      {
	if (is_dir($file)) 
	  {
	    $this->find($ext, $file, $files);
	  }
	else
	  {
	    if (preg_match("/($pattern)$/", $file))
	      {
		$files[] = trim(substr($file, strlen($this->root)),'/');
	      }
	  }
      }
    return $files;
  }

  public function build_path($args)
  {
    $args = func_get_args();
    $result = array();
    foreach ($args as $i => $a)
      {
	$result[$i] = trim($a, '/');
      }
    return implode($result, '/');
  }

  public function build_abs_path($args)
  {
    $args = func_get_args();
    $result = array();
    foreach ($args as $i => $a)
      {
	$result[$i] = trim($a, '/');
      }
    return '/'.implode($result, '/');
  }

  public function __toString()
  {
    return $this->root;
  }

  public static function build_ns($args)
  {
    $args = func_get_args();
    $result = array();
    foreach ($args as $i => $a)
      {
	$a = trim($a, '\\');
	if ($a)
	  {
	    $result[$i] = $a;
	  }
      }
    $result = implode($result, '\\');
    return $result;
  }

  public static function split_name($name)
  {
    return preg_split('/[\\\.\/]/', $name, null, PREG_SPLIT_NO_EMPTY);
  }

  public static function file_to_classname($file)
  {
    return self::dir_to_ns(preg_replace('/\.[a-z]+$/','', $file));
  }

  public static function dir_to_ns($dir)
  {
    return str_replace('/','\\', $dir);
  }

  public static function ns_to_dir($ns)
  {
    return str_replace('\\','/', $ns);
  }

  public static function build_dir($args)
  {
    $args = func_get_args();
    $result = array();
    foreach ($args as $i => $a)
      {
	$result[$i] = trim($a, '/');
      }
    return implode($result, '/');
  }

}