<?php

function load_template($template_name){
    // print_r($template_name);
    include __DIR__.("/../_templates/$template_name.php");
}

?>