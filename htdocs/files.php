<?php

ob_start();
include '_libs/load.php';
ob_end_clean();

// diabling the cache limiter because of the sessions usage.
session_cache_limiter('none');
header('Cache-control: max-age='.(60*60*24*365));
header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*365));
header_remove('Pragma');

$upload_path = get_config('upload_path');
$fname = $_GET['name'];
// echo $fname;
$image_path = $upload_path . $fname;
// echo $image_path;

//To prevent directory traversal vulnerablity
$image_path = str_replace('..', '', $image_path);

if (is_file($image_path)) {
    //TODO: Lot of security things to think about here
    header("Content-Type:".mime_content_type($image_path));
    header("Content-Length:".filesize($image_path));
    echo file_get_contents($image_path);
}
