<?php

include_once __DIR__ . ("/../_libs/Traits/SqlGetterSetter.trait.php");

class User
{

    use SqlGetterSetter;
    // $conn -> holds the connection , $id -> holds the id of the user .
    public $conn;
    public $id;
    public $data;

    public static function signup($username, $first_name, $last_name, $email_addr, $pass)
    {
        $conn = Database::getConnection();
        $options = [
            'cost' => 10,
        ];
        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);
        $stmt = $conn->prepare("INSERT INTO `_auth` (`username`, `first_name`, `last_name`, `email`, `password`)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $first_name, $last_name, $email_addr, $pass);
        if ($stmt->execute()) {
            $error = false;
        } else {
            $error = $stmt->error;
        }
        $stmt->close();
        return $error;
    }

    public static function login($email, $password)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM `_auth` WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
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
        $this->conn = Database::getConnection();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->table = "_auth";
        $query = "SELECT * FROM `_auth` WHERE `id`= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $this->data = $result->fetch_assoc();
            $this->id = $this->data["id"];
        } else {
            throw new Exception("User not found");
        }
        $stmt->close();
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
