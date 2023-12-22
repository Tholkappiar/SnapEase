<?php
include_once("../_includes/User.class.php");
include_once("../_includes/Database.class.php");
include_once("../_includes/Sessions.class.php");

session_start();

global $__site_config;
$__site_config_path = dirname(is_link($_SERVER['DOCUMENT_ROOT']) ? readlink($_SERVER['DOCUMENT_ROOT']) : $_SERVER['DOCUMENT_ROOT']) . '/db.json';
$__site_config = file_get_contents($__site_config_path);


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
    include $_SERVER['DOCUMENT_ROOT'] . ("/_templates/_$template_name.php");
}

function validate_credentials($username, $password)
{
    return ($username == "admin") ? "login successful <br>" : "failed <br>";
}
?>

<script>
    // Initialize the agent once at web application startup.
    // Alternatively initialize as early on the page as possible.
    const fpPromise = import('https://fpjscdn.net/v3/BaXd1iRTR8DXxRUTjGHh')
        .then(FingerprintJS => FingerprintJS.load())

    // Analyze the visitor when necessary.
    fpPromise
        .then(fp => fp.get())
        .then(result => {
            const visitorId = result.visitorId;
            // console.log(visitorId);
            document.getElementById('fingerprint').value = visitorId;
        })

    // console.log(result.requestId, "visitor : " + result.visitorId))
</script>