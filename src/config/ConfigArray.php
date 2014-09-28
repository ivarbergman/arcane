<?

namespace arcane\config;

class ConfigArray implements Config
{

    private $data = [];


    public function __construct($array)
    {
        if ($array)
        {
            $this->setArray($array);
        }
    }

    public function get($ns, $key = null)
    {
        if (is_null($key))
        {
            return @$this->data[$ns];
        }
        return @$this->data[$ns][$key];
    }

    public function set($value, $ns, $key = null)
    {
        if (is_null($key))
        {
            @$this->data[$ns] = $value;;
        }
        @$this->data[$ns][$key] = $value;
    }

    public function setArray($array)
    {
        foreach ($array as $ns => $values)
        {
            foreach ($values as $name => $value)
            {
                $this->set($value, $ns, $name);
            }
        }
    }

    public function load($ns, $path)
    {

        if (file_exists($path))
        {
            include($path);
            $this->data[$ns] = $config;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function hasNS($ns)
    {
        return isset($this->data[$ns]);
    }

}