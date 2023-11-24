<?php

function load_template($template_name){
    // print_r($template_name);
    include $_SERVER['DOCUMENT_ROOT'].("/SnapEase/_templates/_$template_name.php");
}

?>