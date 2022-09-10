<?php

namespace Models;

use Config\Secure;


class User extends Generique {

    /**
     * @scheme VARCHAR(100) NOT NULL
     */
    public $firstname = "" ; 

     /**
     * @scheme VARCHAR(100) NOT NULL
     */
    public $lastname = "";

     /**
     * @scheme VARCHAR(100) NOT NULL UNIQUE
     */
    public $email = "";

     /**
     * @scheme VARCHAR(100) NOT NULL 
     */
    public $password = "" ;

    public function securePassword(){
        if ($this->email && $this->password){
            $this->password = sha1($this->email.Secure::$SALT.$this->password);
            return true; 
        }

        return false;
    }

    public function isPasswordUser($newPassword){
        $newHash = sha1($this->email.Secure::$SALT.$newPassword);
        return $newHash === $this->password;
    }

}
