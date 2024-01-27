<?php

${basename(__FILE__, '.php')} = function () {
    if ($this->isAuthenticated() and $this->paramsExists(['post_id'])) {

        $post_id = $this->_request['post_id'];
        $follow = new Follow();
        $followed_user_id = $follow->post_to_id($post_id);
        $uid = Sessions::get('uid');

        $follow = new Follow();
        $message = $follow->toggleFollow($uid, $uid, $followed_user_id);

        $this->response($this->json([
            'message' => $message
        ]), 200);
    } else {
        $this->response($this->json([
            'message' => "bad request"
        ]), 400);
    }
};
