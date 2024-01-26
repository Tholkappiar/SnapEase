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

$f = new Follow();
// $result = $f->post_to_id(60);
// print_r($result);
$result = $f->follow_user(68,168,172);
print $result;

?>

</pre>



