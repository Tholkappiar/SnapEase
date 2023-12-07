<pre>
<?php


include_once("../_includes/Sessions.class.php");

$obj1 = new Sessions();

print_r("auth : " . $obj1->authenticate('test@gmail.com','test'));

print($_SESSION['token']);

// print_r($obj1->authorize());

// print_r($_SERVER);





// include_once("../_includes/User.class.php");
// include_once("../_libs/load.php");
// $user1 = User::signup('test2','test2','test2','test2@gmail.com','test');
// $user = User::login('test@gmail.com','test');    
//     print_r($user);

   
?>
</pre>