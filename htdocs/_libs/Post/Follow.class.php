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
        $query = "SELECT `uid` FROM `_posts` WHERE `id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (isset($result) && $result) {
            return $result['uid'];
        } else {
            throw new Exception("post_to_id :: Follow.class.php " . $this->conn->error);
        }
    }


    public function follow_user($uid, $follower_id, $followed_id)
    {
        // Prepare the SELECT query to check if the user is already following
        $query = "SELECT COUNT(*) AS count FROM `followers` WHERE `uid`=? 
                AND `follower_user_id`=? AND `followed_user_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $uid, $follower_id, $followed_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $stmt->close();

        if ($count > 0) {
            return "Already following";
        } else {
            $unique_hash = md5($uid . $followed_id);

            // Prepare the INSERT query
            $query = "INSERT INTO `followers` (`uni_hash`,`uid`, `follower_user_id`, `followed_user_id`)
            VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("siii", $unique_hash, $uid, $follower_id, $followed_id);
            $stmt->execute();

            // Check if the insertion was successful
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                throw new Exception("follow_user :: Follow.class.php " . $this->conn->error);
            }
        }
    }


    public function unfollow_user($uid, $follower_id, $followed_id)
    {
        // Prepare the DELETE query
        $query = "DELETE FROM `followers` WHERE `uid`=? AND `follower_user_id`=? AND `followed_user_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $uid, $follower_id, $followed_id);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return false;
        } else {
            $stmt->close();
            throw new Exception("unfollow_user :: Follow.class.php " . $this->conn->error);
        }
    }



    public function isFollowing($uid, $follower_id, $followed_id){
        $query = "SELECT COUNT(*) AS count FROM `followers` WHERE `uid`=? 
                  AND `follower_user_id`=? AND `followed_user_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $uid, $follower_id, $followed_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
    
        $stmt->close();
        return $count;
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
        $query_followers = "SELECT COUNT(*) AS total_followers FROM `followers` WHERE `followed_user_id`=?";
        $stmt = $this->conn->prepare($query_followers);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result_followers = $stmt->get_result();
        $row_followers = $result_followers->fetch_assoc();
        $total_followers = $row_followers['total_followers'];
        
        $stmt->close();
        return $total_followers;
    }
    
    public function getTotalFollowing($uid) {
        $query_following = "SELECT COUNT(*) AS total_following FROM `followers` WHERE `follower_user_id`=?";
        $stmt = $this->conn->prepare($query_following);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result_following = $stmt->get_result();
        $row_following = $result_following->fetch_assoc();
        $total_following = $row_following['total_following'];
        
        $stmt->close();
        return $total_following;
    }
    

    public function getFollowers($uid)
    {   
        $followers = array();

        $query_followers = "SELECT `follower_user_id` FROM `followers` WHERE `followed_user_id`=?";
        $stmt = $this->conn->prepare($query_followers);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result_followers = $stmt->get_result();

        if ($result_followers->num_rows > 0) {
            while ($row = $result_followers->fetch_assoc()) {
                $followers[] = $row['follower_user_id'];
            }
        }

        $stmt->close();

        return $followers;
    }


    public function getFollowing($uid)
    {
        $following = array();

        $query_following = "SELECT `followed_user_id` FROM `followers` WHERE `follower_user_id`=?";
        $stmt = $this->conn->prepare($query_following);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result_following = $stmt->get_result();

        if ($result_following->num_rows > 0) {
            while ($row = $result_following->fetch_assoc()) {
                $following[] = $row['followed_user_id'];
            }
        }

        $stmt->close();

        return $following;
    }


    public function getUsername($uid)
    {
        $query_username = "SELECT `username` FROM `_auth` WHERE `id`=?";
        $stmt = $this->conn->prepare($query_username);
        $stmt->bind_param("i", $uid);
        $stmt->execute();
        $result_username = $stmt->get_result();

        if ($result_username->num_rows > 0) {
            $row = $result_username->fetch_assoc();
            return $row['username'];
        } else {
            return null; 
        }
        $stmt->close();
    }


    public function get_uid($username){
        $query = "SELECT `uid` FROM `_auth` WHERE `username`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result_uid = $stmt->get_result();
        if ($result_uid->num_rows > 0) {
            $row = $result_uid->fetch_assoc();
            return $row['uid'];
        } else {
            return null; 
        }
        $stmt->close();
    }
    
}
