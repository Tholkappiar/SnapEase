<?php

function load_template($template_name)
{
    // print_r($template_name);
    include $_SERVER['DOCUMENT_ROOT'] . ("/SnapEase/_templates/_$template_name.php");
}

function validate_credentials($username, $password)
{
    return ($username == "admin") ? "login successful <br>" : "failed <br>";
}

function signup($first_name, $last_name, $email_addr, $pass)
{
    $servername = "mysql.selfmade.ninja:3306";
    $username = "SnapEase_Thols";
    $password = "thols@123";
    $dbname = "SnapEase_Thols_SnapEase";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO _signup (first_name, last_name, email, password)
    VALUES ('$first_name', '$last_name', '$email_addr', '$pass')";

    if (mysqli_query($conn, $sql)) {
        // echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
