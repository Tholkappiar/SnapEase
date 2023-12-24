<?php

include_once(__DIR__. "/../_libs/load.php");

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
    public function authenticate($email, $password, $fingerprint){
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
    
        $user = User::login($email, $password);
    
        if ($user) {
            $this->uid = $user;
            $ip = $this->getIP();
            $user_agent = $this->getUserAgent();
            $login_time = date("Y-m-d H:i:s", substr($this->getLoginTime(), 0, 10));
    
            // Creating the token using FingerPrint js.
            $token = $fingerprint;
            
            if ( $this->isSessionExists() and $this->isActive()) {
                if ($this->updateSession($token,$login_time,$ip,$user_agent)) {
                    $_SESSION['token'] = $token;
                    return true;
                } else {
                    throw new Exception("Sessions.class.php :: Update Error " . mysqli_error($this->conn));
                }
            }  else {
                if ($this->insertSession($token, $login_time, $ip, $user_agent)) {
                    $_SESSION['token'] = $token;
                    return true;
                } else {
                    throw new Exception("Sessions.class.php :: Insertion Error " . mysqli_error($this->conn));
                }
            }
            if (!$this->isActive()) {
                print_r("The Requested Account is Deactivated ! Please Contact Support.");
            }
        }
        return false;
    }
    

    // To authorize the user using token hash 
    public function authorize(){
        
        if(!$this->conn) {
            $this->conn = Database::getConnection();
        }

        $token_hash = $this->getToken();
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

    /**
     * Returns the Login time of the user.
     * @return string
     */
    public function getLoginTime(){
        return $_SERVER['REQUEST_TIME'];
    }

    // Check if the session is already in the session table
    public function isSessionExists(){
        $check_sql_uid = "SELECT `token` FROM `_session` WHERE `uid`='$this->uid';";
        $check_result = $this->conn->query($check_sql_uid);
        return $check_result->num_rows > 0;
    }

     /**
     * Returns the boolean based on the Account Active Status.
     * @return boolean
     */
    public function isActive(){
        $is_active_sql = "SELECT `active` FROM `_session` WHERE `uid`='$this->uid';";
        $active_result  = $this->conn->query($is_active_sql)->fetch_assoc();
        return $active_result['active']==1?true:false;
    }

     // Update the existing record
     public function updateSession($token, $login_time, $ip, $user_agent){
        $update_sql = "UPDATE `_session` SET `token`='$token', `login_time`='$login_time', 
                      `ip`='$ip', `user_agent`='$user_agent' WHERE `uid`='$this->uid';";

        if($this->conn->query($update_sql)){
            return true;
        } else {
            throw new Exception("Sessions.class.php :: in updateSession " . mysqli_error($this->conn));
        }
    }

    // Inserting a new record into the table
    public function insertSession($token, $login_time, $ip, $user_agent){
        $session_sql = "INSERT INTO `_session` (`uid`, `token`, `login_time`, `ip`, `user_agent`)
                        VALUES ('$this->uid', '$token', '$login_time', '$ip', '$user_agent');";
        if ($this->conn->query($session_sql)) {
            return true;
        } else {
            throw new Exception("Sessions.class.php :: in insertSession " . mysqli_error($this->conn));
        }
    }

    // To get the token for the user.
    public function getToken(){
        $auth_sql = "SELECT `token` FROM `_session` WHERE `uid`='$this->uid';";
        $result = $this->conn->query($auth_sql)->fetch_assoc()["token"];
        if($result) {
            return $result;
        } else {
            throw new Exception("Sessions.class.php :: in getToken " . mysqli_error($this->conn));
        }
    }

    // To Deactivate the Account. Needs the uid.
    public function deactivate()
    {
        $deactivate_sql = "UPDATE `_session` SET `active`='0' WHERE `uid`='$this->uid';";
        if ($this->conn->query($deactivate_sql)) {
            print("The Account is Deactivated !");
        }
    }  
}
