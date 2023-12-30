<pre>
<?php

include ("./_libs/load.php");


$image_tmp = $_FILES['post_image']['tmp_name'];
$text = $_POST['post_text'];
echo $image_tmp;
echo $text;
Post::registerPost($text, $image_tmp);


?>

</pre>



