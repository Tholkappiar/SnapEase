<?php

include_once("../_libs/load.php");

class Sessions
{   
    private $uid = null;
    // $conn -> holds the database connection
    private $conn = null;

    // check for the database connection and connect to the database 
    public function __construct()
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    // To login and store the session details 
    public function authenticate($email, $password){
        if(!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $user = User::login($email, $password);
        if($user) {
            $this->uid = $user;
            $ip = $_SERVER["REMOTE_ADDR"];
            $user_agent = $_SERVER["HTTP_USER_AGENT"];
            $login_time = date("Y-m-d h:i:s", substr($_SERVER['REQUEST_TIME'], 0, 10));

            // creating the token using ip and user agent
            $token = md5($ip.$user_agent.$login_time);
            
            // check if the session is already in the session table , if it is -> update , if not -> insert the data
            $check_sql_uid = "SELECT `uid` FROM `_session` WHERE `uid`='$this->uid';";
            $check_result = $this->conn->query($check_sql_uid);

            if($check_result->num_rows > 0) {
                print_r('Already logged in !');
            } else {
                // inserting the data into the table 
                $session_sql  = "INSERT INTO `_session` (`uid`, `token`, `login_time`, `ip`, `user_agent`)
                VALUES('$this->uid', '$token', '$login_time', '$ip', '$user_agent');";

                // print_r($this->uid);
                if($this->conn->query($session_sql)) {
                    $_SESSION['token'] = $token;
                    return true;
                } else {
                    throw new Exception("Sessions.class.php :: Insertion Error ". mysqli_error($this->conn));
                }
            }
        }
    }

    // To authorize the user using token hash 
    public function authorize(){
        
        if(!$this->conn) {
            $this->conn = Database::getConnection();
        }
        // get the token from the DB and compare with session token value
        $auth_sql = "SELECT `token` FROM `_session` WHERE `uid`='$this->uid';";
        $token_hash = $this->conn->query($auth_sql)->fetch_assoc()["token"];
        
        if($_SESSION['token'] == $token_hash) {
            print('valid token and authorized ... ! <br>');
        } else {
            // login and store the details in session 
            include ('../_pages/_login.php');
        }
    }

    public function getUser()
    {
        return new User("");
    }

    /**
     * Check if the validity of the session is within one hour, else it inactive.
     *
     * @return boolean
     */
    public function isValid()
    {
    }

    public function getIP()
    {
    }

    public function getUserAgent()
    {
    }

    public function deactivate()
    {
    }
}
