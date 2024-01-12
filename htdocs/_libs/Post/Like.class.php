<?php

class Like_class{

    use SqlGetterSetter;

    public $id;
    public $table;
    public $conn;

    public function __construct(Post $post){
        $userid = Sessions::get('uid');
        $postid = $post->getId();
        // print($postid);
        $this->id = md5($userid . $postid);
        $this->conn = Database::getConnection();
        $this->table = 'likes';


        $query = "SELECT * FROM `$this->table` WHERE `id`='$this->id';";
        // print($query);
        $result = $this->conn->query($query);
        // print_r($result);
        if($result->num_rows==1){
                print_r($result->fetch_assoc());
        } else {
            $query_insert = "INSERT INTO `$this->table` (`id`,`uid`,`post_id`,`like`,`time`) 
                             VALUES('$this->id','$userid','$postid',0,now());";
            
            // print($query_insert);
            
            if($this->conn->query($query_insert)){
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


}

?>