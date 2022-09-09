<?php

namespace Controllers;
use Models\User;
use Core\Router;
Use Core\Session;

class UserController {

    //localhost\User

    public static function index(){
        var_dump(User::find([ "id" => 1]));
    }

    public static function register(){
        if (User::findOne(["email" => $_POST["email"]])) {
           Router::redirect("/php_courses/login");
        }

        $user = new User();
        $user->loadFrom($_POST); // Hydraté 
        $user->save();
    }

    public static function login(){
        $user = User::findOne(["email" => $_POST["email"]]);
        if (!$user) {
            Router::redirect("/php_courses/register");
        } else if ($user->password != $_POST["password"]){
            Router::redirect("/php_courses/login");
        }

        $_SESSION['user'] = $user;
        Router::redirect("/php_courses");
    }

    public static function profil(){

        $_SESSION["user_bu"] = clone ($_SESSION["user"]);
        

        $_SESSION["user"]->loadFrom($_POST);
        

        if(!$_SESSION["user"]->save()){
            
            $_SESSION["user"] = $_SESSION["user_bu"];
        }

        unset($_SESSION["user_bu"]);
        Router::redirect("/php_courses/profil");

    }

    public static function logout(){
        unset($_SESSION['user']);
        Session::stop();
        Router::redirect("/php_courses");
        
    }


}