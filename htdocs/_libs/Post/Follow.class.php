<?php

class Follow
{

    public $conn = null;

    public function __construct()
    {
        if ($this->conn == null) {
            $this->conn = Database::getConnection();
        }
    }

    public function post_to_id($post_id)
    {
        $query = "SELECT `uid` FROM `_posts` WHERE `id`='$post_id';";
        // print $query;
        $result = $this->conn->query($query)->fetch_assoc();
        if (isset($result) && $result) {
            return $result['uid'];
        } else {
            throw new Exception("post_to_id ::Follow.class.php " . $this->conn->error);
        }
    }

    public function follow_user($uid, $follower_id, $followed_id)
    {

        $query = "SELECT COUNT(*) AS count FROM `followers` WHERE `uid`='$uid' 
                  AND `follower_user_id`='$follower_id' AND `followed_user_id`='$followed_id';";

        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        $count = $row['count'];

        if ($count > 0) {
            return "Already following";
        } else {
            $unique_hash = md5($uid . $followed_id);

            $query = "INSERT INTO `followers` (`uni_hash`,`uid`, `follower_user_id`, `followed_user_id`)
            VALUES ('$unique_hash','$uid', '$follower_id', '$followed_id');";

            $result = $this->conn->query($query);
            if ($result) {
                return true;
            } else {
                throw new Exception("follow_user :: Follow.class.php " . $this->conn->error);
            }
        }
    }

    public function unfollow_user($uid, $follower_id, $followed_id)
    {
        $query = "DELETE FROM `followers` WHERE `uid`='$uid' AND `follower_user_id`='$follower_id' 
                  AND `followed_user_id`='$followed_id';";
        $result = $this->conn->query($query);
        if ($result) {
            return false;
        } else {
            throw new Exception("unfollow_user :: Follow.class.php " . $this->conn->error);
        }
    }


    public function isFollowing($uid, $follower_id, $followed_id){
        $query = "SELECT COUNT(*) AS count FROM `followers` WHERE `uid`='$uid' 
                  AND `follower_user_id`='$follower_id' AND `followed_user_id`='$followed_id';";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        $count = $row['count'];
    
        return $count > 0;
    }

    public function toggleFollow($uid, $follower_id, $followed_id){

        $isFollowed = $this->isFollowing($uid, $follower_id, $followed_id);
    
        if($isFollowed > 0){
            $this->unfollow_user($uid, $follower_id, $followed_id);
            return true;
        } else {
            $this->follow_user($uid, $follower_id, $followed_id);
            return false;
        }
    }

    public function getTotalFollowers($uid) {
        $query_followers = "SELECT COUNT(*) AS total_followers FROM `followers` WHERE `followed_user_id`='$uid';";
        $result_followers = $this->conn->query($query_followers);
        $row_followers = $result_followers->fetch_assoc();
        $total_followers = $row_followers['total_followers'];
        
        return $total_followers;
    }
    
    public function getTotalFollowing($uid) {
        $query_following = "SELECT COUNT(*) AS total_following FROM `followers` WHERE `follower_user_id`='$uid';";
        $result_following = $this->conn->query($query_following);
        $row_following = $result_following->fetch_assoc();
        $total_following = $row_following['total_following'];
        
        return $total_following;
    }
    
}
