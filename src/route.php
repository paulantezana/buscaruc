<?php

class Router
{
    private $group;
    private $controller;
    private $method;
    private $param;

    public function __construct()
    {
        $this->matchRoute();
    }

    private function matchRoute()
    {
        $url = explode('/', URL);

        if(preg_match('/^\/admin/', URL)){
            if(isset($_SESSION[SESS_KEY]) && isset($_SESSION[SESS_USER])){
                $this->method = !empty($url[3]) ? $url[3] : 'home';
                $this->controller = !empty($url[2]) ? $url[2] : 'Home';
                $this->group = 'admin/';
            } else {
                if (strtolower($_SERVER['HTTP_ACCEPT']) == 'application/json') {
                    http_response_code(403);
                    die();
                } else {
                    $this->method = 'login';
                    $this->controller = 'User';
                }
            }

        // Suport OLD API ===== START
        } else if(URL === '/consultas/api.php') { // Solor para dar soporte a las antiguas versiones
            $this->group = 'api/';
            $this->controller = 'Api0';
            $this->method = 'oldApi';
        } else if(URL === '/consultas/dni.php') { // Solor para dar soporte a las antiguas versiones
            $this->group = 'api/';
            $this->controller = 'Api0';
            $this->method = 'oldApiDni';
        // Suport OLD API ===== END
        } else if (preg_match('/^\/api\/v1/', URL)){
            $url = '/' . trim(preg_replace('/^\/api\/v1/', '', URL), '/');
            $this->group = 'api/';
            $this->controller = 'Api1';
            $this->method = trim($url, '/');
        } else {
            $this->method = !empty($url[2]) ? $url[2] : 'home';
            $this->controller = !empty($url[1]) ? $url[1] : 'Page';
        }

        $this->controller = ucwords($this->controller) . 'Controller';
        if (!is_file(CONTROLLER_PATH . "/{$this->group}{$this->controller}.php")) {
            $this->group = '';
            $this->controller = 'PageController';
            $this->method = 'error404';
        }

        require_once(CONTROLLER_PATH . "/{$this->group}{$this->controller}.php");
        if (!method_exists($this->controller, $this->method)) {
            $this->controller = 'PageController';
            $this->method = 'error404';
            require_once(CONTROLLER_PATH . "/{$this->controller}.php");
        }
    }

    public function run()
    {
        $database = new Database();
        $controller = new $this->controller($database->getConnection());
        $method = $this->method;
        $controller->$method($this->param);
    }
}
