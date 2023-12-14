<pre>
<?php


include_once("../_includes/Sessions.class.php");

// $obj1 = new Sessions();

// print_r("auth : " . $obj1->authenticate('test@gmail.com','test'));

// print($_SESSION['token']);

date_default_timezone_set('UTC');
$db_time = strtotime("2023-12-08 12:36:11");
// current time in epoch - 1702565499 , in timestamp - 2023-12-14 14:51:39
$diff = time() - $db_time;
//diff gives -> 526675 , and 24 hours seconds -> 86400
print($diff ." " . 24*60*60);

// print_r($obj1->authorize());

// print_r($_SERVER);





// include_once("../_includes/User.class.php");
// include_once("../_libs/load.php");
// $user1 = User::signup('test2','test2','test2','test2@gmail.com','test');
// $user = User::login('test@gmail.com','test');    
//     print_r($user);

   
?>
</pre>