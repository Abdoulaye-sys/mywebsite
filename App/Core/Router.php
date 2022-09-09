<?php

namespace Core;

class Router
{
    public static function redirect($uri){
        header("Location: $uri");
        exit;
    }
    /**
     * Permet de dispatcher les URL vers le controleur adéquate
     * Si il n'y a pas de controleur rediriger vers template 404
     * 
     * @return void
     */
    public static function dispatch(){
        $controllerName = "Controllers\\DefaultController";
        $methodName     = "index";
        $redirect = str_replace("/php_courses", "", $_SERVER["REDIRECT_URL"]);

        $url = explode("/",$redirect);
        if (count($url) == 2 && $url[1] !== ""){
            if (class_exists("Controllers\\".$url[1]."Controller")){
                $controllerName = "Controllers\\".$url[1]."Controller";
            } else if(method_exists("Controllers\\DefaultController",$url[1])){
                $methodName = $url[1];
            } else {
                $methodName = "error";
            }
        } elseif (count($url) == 3){
            if (class_exists("Controllers\\".$url[1]."Controller")){
                $controllerName = "Controllers\\".$url[1]."Controller";
            }
            if(method_exists("Controllers\\".$url[1]."Controller", $url[2])){
                $methodName = $url[2];
            } else{
                $controllerName = "Controllers\\DefaultController";
                $methodName = "error";
            }
        }
        call_user_func([$controllerName,$methodName]);
    }
}
