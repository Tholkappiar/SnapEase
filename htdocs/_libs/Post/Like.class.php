<?

class Like {
    use SqlGetterSetter;

    public $id;
    public $table;
    public $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
        $this->table = 'likes';
    }

    public function isLiked($user_id, $post_id) {
        $query = "SELECT COUNT(*) AS count FROM `likes` WHERE `uid`=? AND `post_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function insertLike($user_id, $post_id) {
        $id = md5($user_id . $post_id);
        $query = "INSERT INTO `likes` (`id`, `uid`, `post_id`, `time`, `liker`) VALUES (?, ?, ?, NOW(), ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("siii", $id, $user_id, $post_id, $user_id);
        return $stmt->execute();
    }

    public function deleteLike($user_id, $post_id) {
        $query = "DELETE FROM `likes` WHERE `uid`=? AND `post_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $post_id);
        return $stmt->execute();
    }

    public function liker($post_id) {
        $uid = Sessions::get("uid");
        $query = "SELECT * FROM `likes` WHERE `id`=? AND `liker`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $post_id, $uid);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>