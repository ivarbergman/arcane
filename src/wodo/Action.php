<?

namespace arcane\wodo;

class Action
{
    use \arcane\log\DI;

    private $parent;
    public $child;
    private $lambda;
    private $uri_expr;
    private $hash;
    private $id;
    public $view;
    public $request;
    public $response;
    public $sub;


    public function __construct($uri_expr, $lambda, $parent = null)
    {
        $this->lambda = $lambda->bindTo($this);
        $this->uri_expr = $uri_expr;
        $this->hash = spl_object_hash($this->lambda);
        $this->hash = md5($this->uri_expr);
        $this->parent = $parent;
        $this->view = new View($this);
        $this->sub = array();
    }

    public function Set($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function Id($value = null)
    {
        if ($value)
        {
            $this->id = $value;
            return $this;
        }
        return $this->id;
    }

    public function add($name, $func)
    {
        $c = new Action(null, $func);
        $c->Set($this->request, $this->response);
        $this->sub[$name] = $c;
    }

    public function run()
    {
        $f = $this->lambda;
        $args = $this->request->GetArgs();
        $root = null;
        $res = [];
        $parent = [];
        if ($this->parent)
        {
            $this->parent->child = $this;
            $this->parent->run();
        }

        if (isset($this->sub))
        {
            foreach ($this->sub as $name => $c)
            {
                $this->log()->dbg("sub controller : ".$name);
                $c->run();
            }
        }


        $data = call_user_func_array($f, $args);
        $this->response->push($this->Id(), $data);

        return $this->response;
    }

    public function render($name = null)
    {
        $this->log()->dbg('render: ' . $this->view->getTemplate());
        if ($name)
        {
            if (isset($this->sub[$name]))
            {
                $this->sub[$name]->render();
            }
        }
        else
        {
            $this->response->content = $this->view->render();
        }

        if ($this->parent)
        {
            $this->parent->render();
        }
    }


    public function parent($name = null)
    {

    }


    public function getHash()
    {
        return $this->hash;
    }
}
