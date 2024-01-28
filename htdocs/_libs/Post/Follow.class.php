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

    public function getFollowers($uid)
    {
        $followers = array();

        $query_followers = "SELECT `follower_user_id` FROM `followers` WHERE `followed_user_id`='$uid';";
        $result_followers = $this->conn->query($query_followers);

        if ($result_followers->num_rows > 0) {
            while ($row = $result_followers->fetch_assoc()) {
                $followers[] = $row['follower_user_id'];
            }
        }

        return $followers;
    }

    public function getFollowing($uid)
    {
        $following = array();

        $query_following = "SELECT `followed_user_id` FROM `followers` WHERE `follower_user_id`='$uid';";
        $result_following = $this->conn->query($query_following);

        if ($result_following->num_rows > 0) {
            while ($row = $result_following->fetch_assoc()) {
                $following[] = $row['followed_user_id'];
            }
        }

        return $following;
    }

    public function getUsername($uid)
    {
        $query_username = "SELECT `username` FROM `_auth` WHERE `id`='$uid';";
        $result_username = $this->conn->query($query_username);

        if ($result_username->num_rows > 0) {
            $row = $result_username->fetch_assoc();
            return $row['username'];
        } else {
            // if there is no id
            return null; 
        }
    }

    public function get_uid($username){
        $query = "SELECT `uid` FROM `_auth` WHERE `username`='$username';";
        $result_uid = $this->conn->query($query);

        if ($result_uid->num_rows > 0) {
            $row = $result_uid->fetch_assoc();
            return $row['uid'];
        } else {
            return null; 
        }
    }
}
