
    <pre>
    <?
    print 'super gobal variables <br>';
    print_r($_SERVER['DOCUMENT_ROOT']."<br>");

    echo "GET method <br>";
    print_r($_GET);

    echo "POST method <br>";
    print_r($_POST);

    echo "COOKIE method <br>";
    print_r($_COOKIE);

    echo "FILES method <br>";
    print_r($_FILES);

    echo "GLOBALS method <br>";
    // print_r($_GLOBALS);

    echo "temp dir <br>";
    echo sys_get_temp_dir();

?>
    </pre>
   