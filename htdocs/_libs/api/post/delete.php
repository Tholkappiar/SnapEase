<?php

// https://domain/api/posts/delete

// use SqlGetterSetter;

${basename(__FILE__, '.php')} = function () {
    if ($this->isAuthenticated() and $this->paramsExists(['id'])) {
        $p = new Post($this->_request['id']);
        $p->table = '_posts';

        $this->response($this->json([
            'message'=>$p->delete()
        ]), 200);
    } else {
        $this->response($this->json([
            'message'=>"bad request"
        ]), 400);
    }



    // $this->response($this->json([
    //             'message'=>"this is nice"
    //         ]), 200);
    // print $this->isAuthenticated();
};
// echo "this is thols";