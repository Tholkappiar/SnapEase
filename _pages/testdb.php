<?php
    $servername = "mysql.selfmade.ninja:3306";
    $username = "SnapEase_Thols";
    $password = "thols@123";
    $dbname = "SnapEase_Thols_SnapEase";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO _signup (first_name, last_name, email, password)
    VALUES ('some', 'some', 'some', 'some')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
