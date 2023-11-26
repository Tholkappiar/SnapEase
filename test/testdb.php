<?php
    
    include_once("../_includes/Database.class.php");

    $conn = Database::getConnection();

    $sql = "INSERT INTO _signup (first_name, last_name, email, password)
    VALUES ('some', 'some', 'some', 'some')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    // print("hell ");
?>
