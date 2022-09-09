<?php

namespace Models;


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
}