<?php

// https://domain/api/posts/delete
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

${basename(__FILE__, '.php')} = function () {
    $result = [
        "success" => false,
        "message" => "Invalid request",
        "id" => $_POST['id']
    ];
    $this->response($this->json($result), 200);
};
// echo "this is thols";