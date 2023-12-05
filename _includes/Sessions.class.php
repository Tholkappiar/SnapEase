<?php

include_once("../_libs/load.php");

class Sessions
{   

    private $uid = null;

    // $conn -> holds the database connection
    private $conn = null;

    public function __construct()
    {

        /**
         * check for the database connection and connect to the database 
         */
        if (!$this->conn) {
            $this->conn = Database::getConnection();
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    // things to store -> uid , token , login time , ip , user agent , active
    public function authenticate($email, $password){
        if(!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $user = User::login($email, $password);
        if($user) {
            $this->uid = $user;
            $ip = $_SERVER["REMOTE_ADDR"];
            $user_agent = $_SERVER["HTTP_USER_AGENT"];
            $login_time = date("Y-m-d H:i:s", substr($_SERVER['REQUEST_TIME'], 0, 10));

            // creating the token using ip and user agent
            $token = md5($ip.$user_agent);
            
            $session_sql = "UPDATE `_session` SET `uid`='$this->uid',`token`='$token',`login_time`='$login_time',
                            `ip`='$ip',`user_agent`='$user_agent' WHERE `uid`='$this->uid';";
            // print_r($session_sql);
            if($this->conn->query($session_sql)) {
                $_SESSION['token'] = $token;
                return true;
            } else {
                throw new Exception("Sessions.class.php :: Insertion Error $this->conn");
            }
        }
    }

         /**
         * check the user 
         * 
         */
    public function authorize($email, $password){
        
        if(!$this->conn) {
            $this->conn = Database::getConnection();
        }

        $auth_sql = "SELECT `token` FROM `_session` WHERE `uid`='$this->uid';";
        $token_hash = $this->conn->query($auth_sql)->fetch_assoc()["token"];
        
        if($_SESSION['token'] == $token_hash) {
            print('valid token and authorized ... ! <br>');
        } else {
            // authenticate 
            $this->authenticate($email, $password);
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
