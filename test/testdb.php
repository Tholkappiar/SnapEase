<?php
    
    // database connection

    include_once("../_includes/Database.class.php");

    // $conn = Database::getConnection();

    // $sql = "INSERT INTO _auth (first_name, last_name, email, password)
    // VALUES ('some', 'some', 'some', 'some')";

    // if (mysqli_query($conn, $sql)) {
    //     echo "New record created successfully";
    // } else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    // }

    // mysqli_close($conn);
    
    // print("hell ");
    include_once("../_includes/User.class.php");
    // include_once("../_includes/Database.class.php");

    $obj1 = new User("test1");
    
    // $obj1->save_db_details("instagram","this is insta bio");
    print_r($obj1->getBio());

?>
