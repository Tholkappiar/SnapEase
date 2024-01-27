<?php


${basename(__FILE__, '.php')} = function () {

    $uid = Sessions::get('uid');
    if ($this->isAuthenticated() and isset($uid)) {

        $follow = new Follow();
        $following_list = $follow->getFollowing($uid);
        
        // Return followers list as JSON
        $this->response($this->json([
            'message' => $following_list 
        ]), 200);
    } else {
        $this->response($this->json([
            'message' => "bad request"
        ]), 400);
    }
};

