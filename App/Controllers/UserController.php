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
        if ( User::findOne(["email" => $_POST["email"]])) {
           Router::redirect("/php_courses/login");
        }

        $user = new User();
        $user->loadFrom($_POST); // Hydraté 
        $user->securePassword();
        $user->save();
        Router::redirect("/php_courses/login");

    }

    public static function login(){
        $user = User::findOne(["email" => $_POST["email"]]);
        if (!$user) {
            Router::redirect("/php_courses/register");
        } else if (!$user->isPasswordUser($_POST["password"])){
            Router::redirect("/php_courses/login");
        }

        $_SESSION['user'] =  $user;
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

    public static function updatePassword(){
        if ($_POST["newPassword"] =! $_POST["oldPassword"]) {
            Router::redirect("/php_courses/profil");
        }

        $_SESSION["user_bu"] = clone $_SESSION["user"]; 

        if($_SESSION["user"]->isPasswordUser($_POST["oldPassword"])){
            if($_SESSION["user"]->email != ($_POST["email"])){
            $_SESSION["user"]->email = $_POST["email"];
        }

        $_SESSION["user"]->password = $_POST["newPassword"];
        $_SESSION["user"]->securePassword();
        if(!$_SESSION["user"]->save()){
            $_SESSION["user"] = $_SESSION["user_bu"];
        }

        }

        unset($_SESSION["user_bu"]);
        Router::redirect("/php_courses/profil");

    }

    public static function remove(){ //soft delete
        User::delete($_SESSION["user"]);
        self::logout();
    }

    public static function disable(){ // hard delete
        $_SESSION["user"]->deleteAt = date('Y-m-d');
        $_SESSION["user"]->save();
        self::logout();
    }

    public static function logout(){
        unset($_SESSION['user']);
        Session::stop();
        Router::redirect("/php_courses");
        
    }


}