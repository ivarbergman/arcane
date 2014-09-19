<?

namespace arcane\wodo;

class Router
{

    use \arcane\log\DI;

    private $root = null;
    private $index = array();
    private $map = array();
    private $current = null;
    private $request = null;
    private $response = null;


    public function __construct()
    {
        $this->response = new Response();
        $this->request = new Request();
    }

    public function controller($func)
    {
        $controller = new Action(null, $func);
        $controller->Set($this->request, $this->response);
        return $controller;
    }

    public function get($uri, $func)
    {
        $args = func_get_args();
        $uri = array_shift($args);
        $id = array_shift($args);
        if (!is_string($id))
        {
            array_unshift($args, $id);
            $id = preg_replace("/[^a-z_-]/", "", $uri);
        }
        $parent = null;
        foreach ($args as $task)
        {
            $controller = null;
            if (($task instanceof \Closure))
            {
                $controller = new Action($uri, $task, $parent);
                $controller->Set($this->request, $this->response);
                $controller->Id($id);
                $this->map[$uri] = $controller;
            }
            else if (is_object($task) && ($task instanceof Action))
            {
                $controller = $task;
            }
            if ($controller)
            {
                if (!isset($this->index[$controller->getHash()]))
                {
                    $this->index[$controller->getHash()] = $controller;
                }

                if (!$parent)
                {
                    $this->root = $controller;
                }

                $parent = $controller;
            }
        }
        return $parent;
    }

    public function dbg()
    {
        print_r($this->root);
        print_r($this->index);
    }

    public function func()
    {
        return $this->current;
    }

    public function run()
    {
        $uri = $this->request->path;
        $controller = null;
        $matches = array();
        if (isset($this->map[$uri]))
        {
            $controller = $this->map[$uri];
        }
        else
        {
            foreach ($this->map as $uri_expr => $t)
            {
                if ($this->request->Check($uri_expr))
                {
                    $controller = $t;
                }
            }
        }

        if ($controller)
        {
            $controller->run();
            $this->log()->dbg($this->response->getData());
            $this->log()->dbg($this->response->json());

            //$root->render();
        }
        else
        {
            echo "no run for: $uri";
        }
    }
}
