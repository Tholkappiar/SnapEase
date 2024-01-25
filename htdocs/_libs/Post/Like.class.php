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

    public function initialize(Post $post) {
        $userid = Sessions::get('uid');
        $postid = $post->getId();
        $this->id = md5($userid . $postid);

        $query = "SELECT * FROM `$this->table` WHERE `id`='$this->id';";
        $result = $this->conn->query($query);

        if($result->num_rows == 1) {
            print_r($result->fetch_assoc());
        } else {
            $query_insert = "INSERT INTO `$this->table` (`id`,`uid`,`post_id`,`time`,`liker`) 
                             VALUES('$this->id','$userid','$postid',now(),$userid);";
            print($query_insert);
            
            if($this->conn->query($query_insert)) {
                print('like inserted');
            } else {
                throw new Exception("Like :: insertion Error.");
            }
        }
    }

    public function toggleLike()
    {
        $liked = $this->getLike();
        // print($liked);
        if(boolval($liked) == true){
            $this->setLike(0);
        } else {
            $this->setLike(1);
        }
    }
    public function isLiked()
    {
        return ($this->getLike()); // TODO: like column replaced with liker(id - who likes the post)
    }

    // return the liker id from each post  
    public function liker($id){
        $query = "SELECT `liker` FROM `likes` WHERE `id`='$id';";
        // print($query);
        $result = $this->conn->query($query);
    
        if ($result && $result->num_rows > 0) {
            // Fetch the result as an associative array
            $row = $result->fetch_assoc();
            // Return the value of 'liker' if it exists, otherwise return false
            return isset($row['liker']) ? $row['liker'] : false;
        } else {
            // Handle case where query fails or no rows returned
            return false;
        }
    }
    
}

