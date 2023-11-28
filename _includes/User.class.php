<?php

class User
{
    public static function signup($first_name, $last_name, $email_addr, $pass)
    {
        $conn = Database::getConnection();
        $pass = md5($pass);
        $sql = "INSERT INTO _signup (first_name, last_name, email, password)
        VALUES ('$first_name', '$last_name', '$email_addr', '$pass')";

        if (mysqli_query($conn, $sql)) {
            // echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }

    public static function login($email, $password){

        // md5 hash for the password
        $password = md5($password);
        // query to be passed
        $query = "SELECT * FROM `_signup` WHERE `email` = '$email'";
        // database connection
        $conn = Database::getConnection();
        // getting the results from the database
        $result = $conn->query($query);
        // checking the table for the email and password
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if($row["password"] == $password) {
                return $password;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

}
