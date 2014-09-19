<?php

namespace arcane\wodo;

class Request
{

    use \arcane\log\DI;

    public $path;
    public $uri;
    public function __construct()
    {
        $this->uri = @$_SERVER['PATH_INFO'] ?: @$_SERVER['argv'][1];
        $parts = parse_url($this->uri);
        $this->user = $parts['user'];
        $this->password = $parts['pass'];
        $this->host = $parts['host'];
        $this->path = $parts['path'];
    }

    public function Check($uri_expr)
    {
        $path = array();
        $result = preg_match("|^{$uri_expr}$|", $this->path, $path);
        if ($result && count($path) > count($this->path))
        {
            $this->path = $path;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    public function GetArgs()
    {
        $result = array();

        if ($this->path)
        {
            foreach ($this->path as $i => $value)
            {
                if (!is_numeric($i))
                {
                    $result[$i] = $value;
                }
            }
        }
        return $result;
    }

}
