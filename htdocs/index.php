<?php

include ('./_libs/load.php');

if(isset($_GET['logout'])) {
    if(Sessions::isset('token')){
        $user = new UserSessions();
        if($user->removeSession()){
            echo "Session removed from the DB.";
        }
    }
    Sessions::destory();
    header("Location: /");
    die();
} else {
    Sessions::renderPage();
}
