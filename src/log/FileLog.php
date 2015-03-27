<?php

namespace arcane\log;

class FileLog implements Log
{

    use \arcane\config\DI;

    private $file = "/tmp/arcane.log";
    private $fp;
    private $level = 0;

    public function __construct($file = null)
    {
        if ($file)
        {
            $this->setFile($file);
        }
        else
        {
            $config = $this->config()->get('log');
            if ($config)
            {
                $this->loadConfig($config);
            }
        }
    }

    public function loadConfig($config)
    {
        if (isset($config['file']))
        {
            $this->setFile($config['file']);
        }
        if (isset($config['level']))
        {
            $this->setLevel($config['level']);
        }
    }

    public function setFile($file)
    {
        $this->close();
        $this->file = $file;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function log($mix)
    {
        $this->write($mix, E_USER_WARNING);
    }

    public function error($mix)
    {
        $this->write($mix, E_USER_ERROR);
    }

    public function dbg($mix)
    {
        $this->write($mix, E_USER_NOTICE);
    }

    public function pass($level)
    {
        return $level <= $this->level;
    }

    protected function write($mix, $level)
    {
        if ( ! $this->pass($level)) return ;

        $source = (new \Exception)->getTrace()[1];
        $out = $source['file'] . ' ' . $source['line'].' : ';
        $out .= $this->format($mix).PHP_EOL;
        $this->open();
        fwrite($this->fp, $out);
        fflush($this->fp);
        $this->close();

    }

    protected function isOpen()
    {
        if (!isset($this->fp) || !is_resource($this->fp))
        {
            return false;
        }
        $a = fstat($this->fp);
        return $a["nlink"] > 0;
    }

    protected function open()
    {
        if (!$this->isOpen())
        {
            $this->fp = fopen($this->file, "a");
        }
    }

    protected function close()
    {
        if ($this->isOpen())
        {
            fclose($this->fp);
            unset($this->fp);
        }
    }

    protected function format($mix)
    {
        return print_r($mix, true);
    }

}
