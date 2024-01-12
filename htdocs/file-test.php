<pre>
<?php

include ("./_libs/load.php");


// print_r ($_FILES);
// Post::registerPost($text, $image_tmp);


$allPost = Post::getAllPost();

foreach($allPost as $post){
    // print_r($post);
    // print($_SERVER['DOCUMENT_ROOT']. "/_includes/API.class.php");
    $p = new Post($post['id']);
    // print($p->getPostText() . ", ");
    $l = new Like_class($p);
    // print_r($l);
    // print($l->getId() . ", ");

    $l->toggleLike();

}


?>

</pre>



