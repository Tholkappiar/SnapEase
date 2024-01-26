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
                return "Followed successfully";
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
            return "Unfollowed successfully";
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
            return "Unfollowed successfully";
        } else {
            $this->follow_user($uid, $follower_id, $followed_id);
            return "Followed successfully";
        }
    }
    
}
