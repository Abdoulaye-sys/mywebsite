<?php


namespace Core;


class Session {
    public static function start(){
        session_start();
    }

    public static function stop(){
        session_destroy();
    }
}
 
