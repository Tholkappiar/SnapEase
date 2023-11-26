
    <pre>
    <?
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

    class Mic{
        private $brand;
        private $color;

        public function getBrand(){
            return $this->brand;
        }
        public function setBrand($brandName){
            $this->brand = $brandName;
        }

        public function setColor($color){
            $this->color = $color;
        }
        public function getColor(){
            return $this->color;
        }

        public function __construct($color,$brandName) {
           $this->color = $color;
           $this->brand = $brandName;

           print("this is a brand $color");
        }

    }

?>
    </pre>
   