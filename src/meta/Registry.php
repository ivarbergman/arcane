<?php

namespace arcane\meta;

class Registry 
{

	protected $classes;
	
	public function __construct()
	{
		$this->classes = [];
	}

	public function addClass(MetaClass $class)
	{
		$classname = $class->getName();
		$this->classes[$classname] = $class;
	}

}