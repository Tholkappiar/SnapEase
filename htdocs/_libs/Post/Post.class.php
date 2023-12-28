<?php

include_once __DIR__ . "/../Traits/SqlGetterSetter.trait.php";

class Post{
   
    use SqlGetterSetter;

    public static function post($post_caption){
        $uid = Sessions::get('uid');

        //TODO: Update this image moving part.
        $image_name = md5($uid . time()) . "jpg";
        $image_path = "home/$(whoami)/snapease_post";

        $sql_query = "INSERT INTO `_posts` (`uid`, `post_text`, `img_uri`, `uploaded_time`)
        VALUES ('$uid', '$post_caption', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvEeEpQs9dF8tzPmK0UwrNpmW6vN8AHaqU-_VXRKe78w&s', now());
        ";

        $db = Database::getConnection();
        if($db->query($sql_query)){
            return new Post($uid);
        } else {
            return false;
        }
    }

    public function __construct($uid){
        $this->table = "_posts";
        $this->id = $uid;
    }

}