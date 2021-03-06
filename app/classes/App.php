<?php

namespace MVC\Classes;

class App
{
    public $path = '';
    public $route = 'route';
    
    protected $container;
    protected $controller = 'Error';
    protected $method = 'index';
    protected $params = array();

    public function __construct(Container $container) 
    {
        $this->container = $container;
    }

    public function router() 
    {

        $route = $this->route;

        if (isset($_GET[$route ])) {
            return $url = explode('/', filter_var(rtrim($_GET[$route], '/'), FILTER_SANITIZE_URL));
        }
    }

    public function run()
    {
        $request = $this->router();

        if (file_exists($this->path . ucfirst($request[0]) . 'Controller.php')) {
            $this->controller = ucfirst($request[0]) . 'Controller';
            unset($request[0]);
        } else {
            $this->controller = $this->controller . 'Controller';
        }

        require_once $this->path . $this->controller . '.php';
        $this->controller = new $this->controller($this->container);

        if (isset($request[1])) {
            if (method_exists($this->controller, $request [1])) {
                $this->method = $request[1];
                unset($request[1]);
            }
        }

        $this->params = $request ? array_values($request) : array();

        return call_user_func_array(array($this->controller, $this->method), $this->params);
    }

}