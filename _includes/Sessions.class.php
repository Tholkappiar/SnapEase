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
            $ip = $_SERVER["REMOTE_ADDR"];
            $user_agent = $_SERVER["HTTP_USER_AGENT"];
            $login_time = date("Y-m-d H:i:s", substr($_SERVER['REQUEST_TIME'], 0, 10));
    
            // Creating the token using ip and user agent
            $token = md5($ip.$user_agent.$login_time);
            
            // Check if the session is already in the session table
            $check_sql_uid = "SELECT `login_time` FROM `_session` WHERE `uid`='$this->uid';";
            $check_result = $this->conn->query($check_sql_uid);
    
            if ($check_result->num_rows > 0) {
                $row = $check_result->fetch_assoc();
                $last_login_time = strtotime($row['login_time']);
    
                // Check if 24 hours have passed since the last login
                if (time() - $last_login_time >= 24 * 60 * 60) {
                    // Update the existing record
                    $update_sql = "UPDATE `_session` SET `token`='$token', `login_time`='$login_time', `ip`='$ip', `user_agent`='$user_agent' WHERE `uid`='$this->uid';";
                    if ($this->conn->query($update_sql)) {
                        $_SESSION['token'] = $token;
                        return true;
                    } else {
                        throw new Exception("Sessions.class.php :: Update Error " . mysqli_error($this->conn));
                    }
                } else if ($this->authorize()){
                    print_r('Already logged in within 24 hours!');
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
