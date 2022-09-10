<?php

namespace Models;

use Core\Database;
use PDO;

class Generique {

    /**
     * @scheme INT PRIMARY KEY NOT NULL AUTO_INCREMENT
     */
    public $id = null;

    /**
     * @scheme DATE
     */
    public $createdAt = null;

    /**
     * @scheme DATE
     */
    public $updatedAt = null;

    
    /**
     * @scheme DATE
     */
    public $deletedAt = null;


    public function __construct(){
        if (!$this->createdAt) {
            $this->createdAt = date('Y-m-d');
            $this->updatedAt = date('Y-m-d');
        }
    }


    public function loadFrom($data){
        foreach ($this as $property => $value){
            if (isset($data[$property])) {
                $this->$property = $data[$property];
            }
        }
    }

    public function save(){

        // $this->updateAt = date('Y-m-d');  
        if ($this->id === null) {
            $this->id = self::insert($this);
            //return $this->id ? true : false;
            return !!$this->id;
        } else {
            return !!self::update($this);
        }
    }

    public static function find($params = []){
        $stmt = Database::connect()->prepare(Database::select(get_called_class(),$params));
        foreach ($params as $key => $value){
            $stmt->bindValue(":$key",$value);

        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS,get_called_class());
        }


    public static function findOne($params = []){
        $result = self::find($params);
        return count($result) === 1 ? $result[0] : null;
    }


    public static function insert($object){
        $db = Database::connect();
        $stmt = $db->prepare(Database::insert(get_called_class()));

        foreach ($object as $key => $value){
            $stmt->bindValue(":$key" ,$value);
        }

        return $stmt->execute() ? $db->lastInsertId() : var_dump($stmt->errorInfo());
    }

 public static function update ($object) {

        $stmt = Database::connect()->prepare(Database::update(get_called_class()));

        foreach($object as $key => $value){

            $stmt->bindValue(":$key", $value);

        }

        return $stmt->execute();

    }

    
    public static function delete($object, $params = []){
        $params = count($params) > 0 ? $params : [ "id" => $object->id ];
        $stmt = Database::connect()->prepare(Database::delete(get_called_class(),$params));
        foreach ($params as $key => $value){

            $stmt->bindValue(":$key", $value);

        }

        return $stmt->execute();


    }



}