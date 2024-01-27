<?php

${basename(__FILE__, '.php')} = function () {

    $uid = Sessions::get('uid');
    if ($this->isAuthenticated() and isset($uid)) {

        $follow = new Follow();
        $total_followers = $follow->getTotalFollowers($uid);
        
        $this->response($this->json([
            'message'=>"$total_followers"
        ]), 200);
    } else {
        $this->response($this->json([
            'message'=>"bad request"
        ]), 400);
    }
};
