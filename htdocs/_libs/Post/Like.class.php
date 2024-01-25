<?php

class like{

    use SqlGetterSetter;

    public $id;
    public $table;
    public $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->table = 'likes';
    }

    // public function initialize(Post $post) {
    //     $userid = Sessions::get('uid');
    //     $postid = $post->getId();
    //     $this->id = md5($userid . $postid);
    //         $query_insert = "INSERT INTO `$this->table` (`id`,`uid`,`post_id`,`time`,`liker`) 
    //                          VALUES('$this->id','$userid','$postid',now(),$userid);";
    //         // print($query_insert);
            
    //         if($this->conn->query($query_insert)) {
    //             print('like inserted');
                
    //         } else {
    //             throw new Exception("Like :: insertion Error.");
    //         }
    // }

    public function isLiked($user_id, $post_id)
    {
        $query = "SELECT COUNT(*) as count FROM `likes` WHERE `uid`='$user_id' AND `post_id`='$post_id';";
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        } else {
            return false;
        }
    }

    public function insertLike($user_id, $post_id) {
        $id = md5($user_id . $post_id);
        $query = "INSERT INTO `likes` (`id`,`uid`, `post_id`, `time`, `liker`) VALUES ('$id','$user_id', '$post_id', NOW(), '$user_id');";
        $result = $this->conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteLike($user_id, $post_id) {
        $query = "DELETE FROM `likes` WHERE `uid`='$user_id' AND `post_id`='$post_id';";
        $result = $this->conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function toggleLike($user_id,$post_id)
    {
        $liked = $this->isLiked($user_id, $post_id);
    
        if ($liked) {
            $this->deleteLike($user_id, $post_id);
            return false; // Post unliked
        } else {
            $this->insertLike($user_id, $post_id);
            return true; // Post liked
        }
    }

    // return the liker id from each post  
    public function liker($post_id){
        $uid = Sessions::get("uid");
        $query = "SELECT * FROM `likes` WHERE `id`='$post_id' AND `liker`='$uid';";

        // print($query);
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
}

