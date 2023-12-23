<?php

class User
{
    // $conn -> holds the connection , $id -> holds the id of the user .
    private $conn;
    private $id;

    public static function signup($username,$first_name, $last_name, $email_addr, $pass)
    {
        $conn = Database::getConnection();
        $options = [
            'cost' => 10,
        ];
        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);
        $sql = "INSERT INTO `_auth` (`username`,`first_name`, `last_name`, `email`, `password`)
        VALUES ('$username', '$first_name', '$last_name', '$email_addr', '$pass')";

        if ($conn->query($sql)) {
            $error = false;
        } else {
            $error = $conn->error;
        }

        return $error;
    }

    public static function login($email, $password)
    {
        // query to be passed
        $query = "SELECT * FROM `_auth` WHERE `email` = '$email'";
        // database connection
        $conn = Database::getConnection();
        // getting the results from the database
        $result = $conn->query($query);
        // checking the table for the email and password
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                return $row['id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function __construct($username)
    {
        if(!$this->conn){
            $this->conn = Database::getConnection();
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
        $query = "SELECT `id` FROM `_auth` WHERE `username`= '$username' LIMIT 1;";
        $result = $this->conn->query($query);
        if ($result->num_rows == 1) {
            $this->id = $result->fetch_assoc()["id"];
            // print_r($this->id);
        } else {
            throw new Exception("user doesn't found");
        }
    }

    // Using __call magic function to reduce the boiler plate codes -> getters and setters
    public function __call($name, $attributes){
        print("this is _call \n");
        // To get the property name without the get or set in the start
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        // To convert camelCase to Snake_Case and meke it lowerCase
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));

        if(substr($name, 0, 3) == "set"){
            return $this->_set_data($property, $attributes[0]);    
        } else if(substr($name, 0, 3) == "get"){
            return $this->_get_data($property);
        } else {
            throw new Exception("User::__call function : $name");
        }
    }

    public function _set_data($name, $value){
        if(!$this->conn){
            $conn = Database::getConnection();
        };
        print_r("name : $name value : $value");
        $query = "UPDATE `_users` SET `$name`='$value' WHERE `id`=$this->id;";
        if($this->conn->query($query)){
            return true;
        } else {
            return $this->conn->error;
        }
    }

    public function _get_data($name){
        if(!$this->conn){
            $conn = Database::getConnection();
        }
        $query = "SELECT $name FROM `_users` WHERE `id`='$this->id';";
        $result = $this->conn->query($query);
        if($result->num_rows){
            $row = $result->fetch_assoc();
            return $row[$name];
        } else {
            throw new Exception("User::_get_data -> cannot get the data.");
        }
    }







    // private function get_details_by_column($column)
    // {
    //     if(!$this->conn){
    //         $this->conn = Database::getConnection();
    //     }
    //     $query = "SELECT `$column` FROM `_users` WHERE `id` = $this->id";
    //     $result = $this->conn->query($query);
    //     if($result->num_rows) {
    //         return $result->fetch_assoc()["$column"];
    //     } else {
    //         return "somethig went wrong in the column !";
    //     }
    // }

    // private function save_db_details($column, $data)
    // {
    //     if (!$this->conn) {
    //         $this->conn = Database::getConnection();
    //     }
    //     $sql = "UPDATE `_users` SET `$column`='$data' WHERE `id`='$this->id';";
    //     if ($this->conn->query($sql)) {
    //         return "data saved to DB !!";
    //     } else {
    //         return $this->conn->error;
    //     }
    // }





    // Getters and setters 
    // public function setBio($bio)
    // {
    //     return $this->save_db_details("bio","$bio");
    // }

    // public function getBio()
    // {
    //     return $this->get_details_by_column("bio");
    // }

    // public function setAvatar($avatar)
    // {
    //     return $this->save_db_details("avatar","$avatar");
    // }

    // public function getAvatar()
    // {
    //     return $this->get_details_by_column("avatar");
    // }
    // public function setDOB($DOB){
    //     return $this->save_db_details("dob","$DOB");
    // }
    // public function getDOB(){
    //     return $this->get_details_by_column("dob");
    // }
    // public function getInsta(){
    //     return $this->get_details_by_column("instagram");
    // }
    // public function setInsta($insta){
    //     return $this->save_db_details("instagram","$insta");
    // }
}
