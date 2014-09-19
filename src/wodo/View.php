<?
namespace arcane\wodo;


class View
{
    private $controller;
    private $template;
    private $data = array();
    private $js = array();
    private $css = array();

    use \arcane\log\DI;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function setTemplate($t)
    {
        $this->template = $t;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function add($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function js($url)
    {
        $this->js[$url] = true;
    }

    public function css($url)
    {
        $this->css[$url] = true;
    }

    public function data($array)
    {
        $this->data = $array;
    }

    public function render()
    {        
        if ($this->template)
        {
            $this->log()->dbg('view: ' . $this->template);
            $controller = $this->controller;
            extract($this->data);
            ob_start();
            require 'templates/'.$this->template;
            echo ob_get_clean();
        }
    }

    public function child($name = null)
    {        
        
        if ($name)
        {
            $this->controller->render($name);
        }
        else 
        {
            $this->controller->child->render();
        }
    }

    public function parent($name = null)
    {        
        
        if ($name)
        {
            $this->controller->render($name);
        }
        else 
        {
            $this->controller->child->render();
        }
    }

    public function url($part)
    {        
        return $part;
    }

}


