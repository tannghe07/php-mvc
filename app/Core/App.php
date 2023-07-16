<?php

class App{
    protected $controller = "UserController";
    protected $method = "login";
    protected $params = [];

    public function __construct()
    {
        $this->splitURL();
        $this->loadController();
    }

    private function splitURL(){
        $url = $_SERVER['QUERY_STRING'];

        if(!empty($url)){
            $url = trim($url, "/");
            $url = explode("/",$url);
            $this->controller = isset($url[0]) ? ucwords($url[0])."Controller":"HomeController";

            $this->method = isset($url[1]) ? $url[1] : "index";

            unset($url[0], $url[1]);

            $this->params = !empty($url) ? array_values($url):[];
        }
    }

    private function loadController(){
        if(class_exists($this->controller)){
            $controller = new $this->controller;
            if(method_exists($controller, $this->method)){
                call_user_func_array([$controller, $this->method], $this->params);
            }
            else{
                echo "method not exist";
            }
        }
        else{
            echo "this controller not exist";
        }
    }
}