<?php

class User
{
    private $conn;
    private $first_name;
    private $id;

    public static function signup($first_name, $last_name, $email_addr, $pass)
    {
        $conn = Database::getConnection();
        $options = [
            'cost' => 10,
        ];
        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);
        $sql = "INSERT INTO _auth (first_name, last_name, email, password)
        VALUES ('$first_name', '$last_name', '$email_addr', '$pass')";

        if (mysqli_query($conn, $sql)) {
            // echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }

    public static function login($email, $password)
    {

        // md5 hash for the password
        // $password = md5($password);
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
                session_start();
                return $row['password'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function __construct($first_name)
    {

        if(!$this->conn){
            $this->conn = Database::getConnection();
        }
        $query = "SELECT `id` FROM `_auth` WHERE `first_name`= '$first_name' LIMIT 1;";

        $result = $this->conn->query($query);
        if ($result->num_rows == 1) {
            $this->id = $result->fetch_assoc()["id"];
            print_r($this->id);
        } else {
            print_r("user not found");
        }
    }
    private function get_details_by_column($column)
    {
        if(!$this->conn){
            $this->conn = Database::getConnection();
        }
        $query = "SELECT `$column` FROM `_users` WHERE `id` = $this->id";
        $result = $this->conn->query($query);
        if($result->num_rows) {
            return $result->fetch_assoc()["$column"];
        } else {
            return "somethig went wrong in the column !";
        }
    }

    private function save_db_details($column, $data)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "UPDATE `_users` SET `$column`='$data' WHERE `id`='$this->id';";
        if ($this->conn->query($sql)) {
            return "data saved to DB !!";
        } else {
            return $this->conn->error;
        }
    }

    public function setBio($bio)
    {
        return $this->save_db_details("bio","$bio");
    }

    public function getBio()
    {
        return $this->get_details_by_column("bio");
    }

    public function setAvatar($avatar)
    {
        return $this->save_db_details("avatar","$avatar");
    }

    public function getAvatar()
    {
        return $this->get_details_by_column("avatar");
    }
    public function setDOB($DOB){
        return $this->save_db_details("dob","$DOB");
    }
    public function getDOB(){
        return $this->get_details_by_column("dob");
    }
    public function getInsta(){
        return $this->get_details_by_column("instagram");
    }
    public function setInsta($insta){
        return $this->save_db_details("instagram","$insta");
    }
}
