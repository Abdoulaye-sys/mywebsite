<?php

namespace Controllers;
use Models\Todo;
use Core\Router;
use Core\Template;

class TodoController {

    public static function index(){
       Template::render('todo.html');

    }

    public static function add(){
        $LIST = $_POST['list'];
        $todo = new Todo();
        $todo->list = $LIST;
        $todo->loadFrom($_POST['list']); // Hydraté 
        Todo::insert($todo);
        $todo->save();
        Router::redirect("/php_courses/todo");        
    }

    public static function delete(){
        echo "bravo c'est supprimé";
    }

    public static function update(){
        echo "bravo c'est updated";
    }







}