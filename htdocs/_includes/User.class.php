<?php

include_once __DIR__ . ("/../_libs/Traits/SqlGetterSetter.trait.php");

class User
{

    use SqlGetterSetter;
    // $conn -> holds the connection , $id -> holds the id of the user .
    public $conn;
    public $id;
    public $data;

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

    //TODO: change this from username to uid , to fetch all the info about the user.
    public function __construct($uid)
    {
        if(!$this->conn){
            $this->conn = Database::getConnection();
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
        $this->table = "_auth";
        $query = "SELECT * FROM `_auth` WHERE `id`= '$uid';";
        $response = $this->conn->query($query);
        if ($response->num_rows == 1) {
            $result = $response->fetch_assoc();
            $this->id = $result["id"];
            $this->data = $result;
            // print_r($this->data[]);
            // print_r($this->id);
        } else {
            throw new Exception("user doesn't found");
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
