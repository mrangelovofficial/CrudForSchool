<?php

class App
{
    private $controller         =   'HomeController';
    private $controllerClass    =   null;
    private $method             =   'index';
    private $params             =   [];
    private $controllerExt      =   'Controller';

    public function __construct()
    {
        //Get URL
        $url    =   $this->parseUrl();

        //Check if controller exist and set it 
        $controllerURL  =   '../app/controllers/'.$url[0].$this->controllerExt.'.php';
        if( file_exists($controllerURL) )
        {
            $this->controller   =   $url[0].$this->controllerExt;
            unset($url[0]);
        }

        //Require and Set the Controller
        $controllerDefaultURL   =   '../app/controllers/'.$this->controller.'.php';
        require_once $controllerDefaultURL;
        
        $this->controllerClass  =    new $this->controller;

        if(isset($url[1]))
        {
            if(method_exists( $this->controllerClass, $url[1] ))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controllerClass, $this->method], $this->params); 
    }


    private function parseUrl()
    {
        if( isset( $_GET['url'] ) )
        {
            $trim = rtrim($_GET['url'], '/');
            $sanitize = filter_var($trim, FILTER_SANITIZE_URL);
            return $url = explode('/',$sanitize);
        }
    }
}