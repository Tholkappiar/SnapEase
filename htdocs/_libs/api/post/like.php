<?php

${basename(__FILE__, '.php')} = function () {
    if ($this->isAuthenticated() and $this->paramsExists(['post_id'])) {
        $user_id = Sessions::get('uid');
        $post_id = $this->_request['post_id'];

        $l = new Like();
        $is_liked = $l->isLiked($user_id, $post_id);

        if ($is_liked) {
            $l->deleteLike($user_id, $post_id);
        } else {
            $l->insertLike($user_id, $post_id);
        }

        $this->response($this->json([
            'liked' => !$is_liked
        ]), 200);
        } else {
        $this->response($this->json([
            'message' => "bad request"
        ]), 400);
    }
};
