<?

namespace arcane\wodo;


class Response
{

    public $_root;
    public $index;
    public $current;

    public function __construct()
    {
        $this->_root = new \StdClass();
        $this->current = $this->_root;
    }

    public function push($name, $data)
    {
        $obj = new \StdClass();
        foreach ($data as $key => $value)
        {
            $obj->{$key} = $value;
        }
        if (!$name)
        {
            $name = '_';
        }
        $this->index[$name] = $obj;
        $this->current->{$name} = $obj;
        $this->current = $obj;
    }

    public function parent($name)
    {
        return $this->index[$name];
    }

    public function getData()
    {
        return $this->_root;
    }

    public function json()
    {
        return json_encode($this->_root, JSON_PRETTY_PRINT);
    }
}
