<?php

namespace Controllers;

use Core\Template;

class DefaultController {
    public static function index(){
        Template::render('index.html');
    }

    public static function login(){
        Template::render('login.html');
    }

    public static function register(){
        Template::render('register.html');
    }


    public static function error(){
        Template::render('error.html');
    }

    public static function profil(){
        Template::render('profil.html');
    }

    
    public static function todo(){
        Template::render('todo.html');
    }

    public static function logout(){
        UserController::logout();
    }

    



}