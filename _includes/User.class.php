<?php

class User
{
    public static function signup($first_name, $last_name, $email_addr, $pass)
    {
        $conn = Database::getConnection();

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
        
    }

}
