
    <pre>
    <?


    class sessions{

        public static function ses_start(){
            session_start();
        }

        public static function ses_status(){
            return session_status();
        }

        public static function ses_destory(){
            session_destroy();
        }

        public static function ses_encode(){
            return session_encode();
        }

        public static function ses_decode($data){
            return session_decode($data);
        }




    }

    sessions::ses_start();

    $enc =  sessions::ses_encode();

    print_r($_SESSION['time']);
    if(isset($_SESSION['time'])){
        print("<br> time already exist !..... $_SESSION[time]");
    }else{
        $_SESSION['time'] = time();
        print("<br> printing new value -> $_SESSION[time]");
    }

    print "<br> this is the encoded string : $enc";

    $dec = sessions::ses_decode($enc);
    print "<br> this is the decoded string : $dec";

    print("<br> this is the status : " . sessions::ses_status());










    // print 'super gobal variables <br>';
    // print_r($_SERVER['DOCUMENT_ROOT']."<br>");

    // echo "GET method <br>";
    // print_r($_GET);

    // echo "POST method <br>";
    // print_r($_POST);

    // echo "COOKIE method <br>";
    // print_r($_COOKIE);

    // echo "FILES method <br>";
    // print_r($_FILES);

    // echo "GLOBALS method <br>";
    // // print_r($_GLOBALS);

    // echo "temp dir <br>";
    // echo sys_get_temp_dir();

    

?>
    </pre>
   