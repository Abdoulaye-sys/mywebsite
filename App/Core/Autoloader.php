<?php 
namespace Core;

class Autoloader {

    /**
     * Permet d'enregistrer l'autoloader dans la mécanique de PHP par défault
     * @return void
     */

    public static function register(){
        spl_autoload_register([__CLASS__,'autoload']);
    }

    /**
     * Permet de charger un fichier et la class associer en fonction de son namespace
     * @param $className nom de la classe charger
     * @return void
     */

    public static function autoload($className){

        $filename = __DIR__. "/../" . str_replace("\\","/",$className) . '.php';
        if (file_exists($filename)){
            require_once($filename);
        }

}

}
