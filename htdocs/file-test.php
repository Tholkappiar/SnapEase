<pre>
<?php

// include ("./_libs/load.php");


// print_r ($_FILES);
// Post::registerPost($text, $image_tmp);


// $allPost = Post::getAllPost();

// foreach($allPost as $post){
//     // print_r($post);
//     // print($_SERVER['DOCUMENT_ROOT']. "/_includes/API.class.php");
//     $p = new Post($post['id']);
//     // print($p->getPostText() . ", ");
//     $l = new Like_class($p);
//     // print_r($l);
//     // print($l->getId() . ", ");

//     $l->toggleLike();

// }

include ("./_libs/load.php");


class YourClass {
    use SqlGetterSetter;

    // Set the necessary properties
    public $id; // Assuming you have an id property in your class
    public $conn; // Assuming you have a connection property in your class
    // Set your table name

    // Constructor or other methods if needed
}

$a = new YourClass();
$a->table = 'thols';
$a->delete();



?>

</pre>



