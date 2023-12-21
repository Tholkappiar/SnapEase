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
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
    
        $user = User::login($email, $password);
    
        if ($user) {
            $this->uid = $user;
            $ip = $this->getIP();
            $user_agent = $this->getUserAgent();
            $login_time = date("Y-m-d H:i:s", substr($this->getLoginTime(), 0, 10));
    
            // Creating the token using ip and user agent
            $token = md5($ip.$user_agent.$login_time);
            
            // Check if the session is already in the session table
            $check_sql_uid = "SELECT `login_time` FROM `_session` WHERE `uid`='$this->uid';";
            $check_result = $this->conn->query($check_sql_uid);
    
            if ($check_result->num_rows > 0) {

                // Update the existing record
                $update_sql = "UPDATE `_session` SET `token`='$token', `login_time`='$login_time', `ip`='$ip', `user_agent`='$user_agent' WHERE `uid`='$this->uid';";
                if ($this->conn->query($update_sql)) {
                    $_SESSION['token'] = $token;
                    return true;
                } else {
                    throw new Exception("Sessions.class.php :: Update Error " . mysqli_error($this->conn));
                }
            } else {
                // Inserting a new record into the table
                $session_sql = "INSERT INTO `_session` (`uid`, `token`, `login_time`, `ip`, `user_agent`)
                                VALUES ('$this->uid', '$token', '$login_time', '$ip', '$user_agent');";
    
                if ($this->conn->query($session_sql)) {
                    $_SESSION['token'] = $token;
                    return true;
                } else {
                    throw new Exception("Sessions.class.php :: Insertion Error " . mysqli_error($this->conn));
                }
            }
        }
        return false;
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
            return true;
        } else {
            // login and store the details in session 
            include_once ('../_pages/_login.php');
        }
    }

    /**
     * Returns the IP address of the user.
     * @return string
     */
    public function getIP()
    {
        return $_SERVER["REMOTE_ADDR"];
    }

    /**
     * Returns the Browser User-agent of the user.
     * @return string
     */
    public function getUserAgent()
    {
        return $_SERVER["HTTP_USER_AGENT"];
    }

    public function deactivate()
    {
    }

    /**
     * Returns the Login time of the user.
     * @return string
     */
    public function getLoginTime(){
        return $_SERVER['REQUEST_TIME'];
    }
}
