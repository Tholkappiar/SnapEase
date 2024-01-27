<?php

${basename(__FILE__, '.php')} = function () {

    $post_id = $this->_request['userId'];

    if ($this->isAuthenticated() and isset($post_id)) {

        $follow = new Follow();
        $follower_name = $follow->getUsername($post_id);
        
        // Return follower name as JSON
        $this->response($this->json([
            'message' => $follower_name
        ]), 200);
    } else {
        $this->response($this->json([
            'message' => "bad request"
        ]), 400);
    }
};

