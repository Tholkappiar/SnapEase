<?php
require __DIR__ . '/../vendor/autoload.php';
include_once($_SERVER['DOCUMENT_ROOT']. "_includes/User.class.php");
include_once($_SERVER['DOCUMENT_ROOT']. "_includes/Database.class.php");
include_once($_SERVER['DOCUMENT_ROOT']. "_includes/UserSessions.class.php");
include_once($_SERVER['DOCUMENT_ROOT']. "_includes/Sessions.class.php");
include_once($_SERVER['DOCUMENT_ROOT']. "_includes/WEBAPI.class.php");
include_once($_SERVER['DOCUMENT_ROOT']. "_libs/Post/Post.class.php");
include_once($_SERVER['DOCUMENT_ROOT']. "_includes/REST.class.php");
include_once($_SERVER['DOCUMENT_ROOT']. "_includes/API.class.php");
include_once($_SERVER['DOCUMENT_ROOT']. "_libs/Post/Like.class.php");

session_cache_limiter('none');
session_start();


$webapi = new WEBAPI();

// To get the DB configs
function get_config($key, $default = null)
{
    global $__site_config;

    $array = json_decode($__site_config, true);
    if (isset($array[$key])) {
        return $array[$key];
    } else {
        return $default;
    }
}

function load_template($template_name)
{
    // print_r($template_name);
    include $_SERVER['DOCUMENT_ROOT'] . ("_templates/_$template_name.php");
}

function validate_credentials($username, $password)
{
    return ($username == "admin") ? "login successful <br>" : "failed <br>";
}
?>