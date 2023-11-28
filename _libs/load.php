<?php
    include_once("../_includes/Database.class.php");
    include_once("../_includes/User.class.php");

    session_start();
function load_template($template_name)
{
    // print_r($template_name);
    include $_SERVER['DOCUMENT_ROOT'] . ("/SnapEase/_templates/_$template_name.php");
}

function validate_credentials($username, $password)
{
    return ($username == "admin") ? "login successful <br>" : "failed <br>";
}


