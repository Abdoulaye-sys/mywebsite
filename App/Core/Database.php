<?php

namespace Core;

use PDO;
use ReflectionClass;

class Database {
    private static $instance = false;

    public static function connect(){
        if (!self::$instance){
            self::$instance = new PDO("mysql:host=127.0.0.1","root","");
            self::$instance->query("CREATE DATABASE IF NOT EXISTS `phpmvc`;");
            self::$instance->query("USE phpmvc;");
        }
        return self::$instance;
    }


    

    public static function createIfNotExist($namespace){

        $reflect = new ReflectionClass($namespace);
        $properties = [];


        foreach($reflect->getProperties() as $key => $value){
            $pattern = "/@scheme (.*)\n/";
            preg_match_all($pattern, $value->getDocComment(), $matches);
            $properties[] = $value->name. " ".$matches[1][0];
        }






        $sql = "CREATE TABLE IF NOT EXISTS `$namespace` ( ".join(",",$properties).") ";
        // CREATE TABLE IF NOT EXISTS `Models\User` {id, createdAt, updateAt, deletdAt }






        self::connect()->query($sql);
 
    }


    public static function select($namespace, $filter = []){
        self::createIfNotExist($namespace);

        $sql = " SELECT * FROM `$namespace` ";
        if (count($filter) > 0) {
            $count = 0;
            foreach ($filter as $key => $value){
                $sql .= $count === 0 ? " WHERE `$key` = :$key" : " AND `$key` = :$key" ;
                $count++;
            }
        }





        return $sql;
    }
    public static function insert($namespace){

        self::createIfNotExist($namespace);

        $sql = "INSERT INTO `$namespace` ";
        $reflect = new ReflectionClass($namespace);

        $propertyName = [];
        $propertyValues = [];
        foreach ($reflect->getProperties() as $key => $ReflectionProperty){
            $propertyName[] = "`".$ReflectionProperty->name."`";
            $propertyValues[] = ":".$ReflectionProperty->name;
        }

        $sql .= "(".join(",",$propertyName).") VALUES (".join(",",$propertyValues).");";
        // $sql = "INSERT INTO `models\todo`(`id`, `list`) VALUES ('$id','$list')";
        //INSERT INTO `Models\User` (`id`, `createdAt`, `updatedAt`, `deletedAt`) VALUES (:id, :createdAt, :updatedAt; deletedAt)

        return $sql;

    }

public static function update($namespace) {

        self::createIfnotExist($namespace);



        $sql = "UPDATE `$namespace` SET ";

        $reflect = new ReflectionClass($namespace);

        $property = [];

        foreach($reflect->getProperties() as $key=>$ReflectionProperty) {

            $property[] =  "`".$ReflectionProperty->name."` = :".$ReflectionProperty->name;

        }

        $sql .= join(",", $property). " WHERE `id` = :id" ;

        return $sql;

    }    public static function delete($namespace, $filter = []){
        self::createIfNotExist($namespace);

        $sql = " DELETE FROM `$namespace` ";
        if (count($filter) > 0){
            $count = 0;
            foreach ($filter as $key => $value){
                $sql .= $count === 0 ? "WHERE `$key` = :$key " : "AND `$key` = :$key";
                $count++;
            }
        }

        return $sql;


    }

}