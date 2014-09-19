<?
namespace arcane\wodo;

class Task
{
    private $parent;
    private $child;
    private $lambda;
    private $hash;
    public $view;
    public $request;
    public $response;

    public function Task($lambda, $parent = null)
    {
        $this->lambda = $lambda->bindTo($this);
        $this->hash = spl_object_hash($this->lambda);
        $this->parent = $parent;
        $this->view = new View();
    }

    public function call()
    {
        $f = $this->lambda;
        $root = null;
        if ($this->parent)
        {
            $this->parent->child = $this;
            $root = $this->parent->call();
        }
        $f();
        return $root ?: $this;
    }

    public function render()
    {
        $this->view->render($this->child);
    }

    public function getHash()
    {
        return $this->hash;
    }
}
