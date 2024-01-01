<?php

include_once __DIR__ . "/../Traits/SqlGetterSetter.trait.php";

// including carbon namespace.
use Carbon\Carbon;

class Post
{
    // SqlGetterSetter - Trait
    use SqlGetterSetter;

    public static function registerPost($post_caption, $image_tmp)
    {
        $uid = Sessions::get('uid');
        if (is_file($image_tmp) and exif_imagetype($image_tmp) !== false) {
            //TODO: Update this image moving part.
            $image_name = md5($uid . time()) . image_type_to_extension(exif_imagetype($image_tmp));
            $image_path = get_config('upload_path') . $image_name;
            
            if (move_uploaded_file($image_tmp, $image_path)) {
                $image_uri = "/files/$image_name";
                $insert_command = "INSERT INTO `_posts` (`uid`, `multi_img`, `post_text`, `image_uri`, 
                `like`, `uploaded_time`) VALUES ('$uid', 0, '$post_caption', '$image_uri', '0', now());";

                $db = Database::getConnection();
                if ($db->query($insert_command)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public static function getAllPost() {
        $allPostQuery = "SELECT * FROM `_posts` ORDER BY `uploaded_time` DESC";
        $conn = Database::getConnection();
        $allPostResult = $conn->query($allPostQuery);
        if($allPostResult) {
            return iterator_to_array($allPostResult);
        }
    }

    public function __construct($uid)
    {
        $this->table = "_posts";
        $this->id = $uid;
    }
}
