<?php

namespace App;

use Helper\NotFoundException;
use Controller\MainController;

/**
 * Main Router
 */
class Main
{
    public function start()
    {
        session_start();

        //Routing
        $uri = $_SERVER['REQUEST_URI'];
        if(!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: '.$uri);
        }
        $params = explode('/', $_GET['p']);
        if($params[0] != ''){
            $controller = '\\Controller\\'.ucfirst(array_shift($params)).'Controller';
            if (!class_exists($controller)) {
                throw new NotFoundException("La page que vous recherchez est introuvable.");
            }
            $controller = new $controller();
            $action = (isset($params[0])) ? array_shift($params) : 'index';
            if (method_exists($controller, $action)){
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {              
                throw new NotFoundException("La page que vous recherchez est introuvable.");
            }
        } else {
            $controller = new MainController;
            $controller->index();
        }
    }
}