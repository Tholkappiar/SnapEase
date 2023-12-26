<?php


class Database
{
    // $conn - which holds the connection
    public static $conn = null;

    public static function getConnection()
    {
        /**  --------------- used for single mysql connection rather than having multiple connections-----------
         *   check if the there is a connection else 
         *   if not create a new connection and return that , if already connected with the
         *   mysql server return the previous connection !
         */
        if (Database::$conn == null) {
            // mysql connectiontion: Connection refused in /var/www/html/snapease/htdocs/_includes/Database.class.php:24\nStack trace:\n#0 /var/www/html/snapease/htdocs/_includes/Database.class.php(24): mysqli->__construct()\n#1 /var/www/html/snapease/htdocs/_includes/User.class.php(11): Database::getConnection()\n#2 /var/www/html/snapease/htdocs/_templates/_signup.php(10): User::signup()\n#3 /var/www/html/snapease/htdocs/_libs/load.php(28): include('...')\n#4 /var/www/html/snapease/htdocs/_pages/_signup.php(7): load_template()\n#5 {main}\n  thrown in /var/www/html/snapease/htdocs/_includes/Database.class.php on line 24, referer: http://localhost/_pages/_signup.php
            $servername = get_config("servername");
            $username = get_config("username");
            $password = get_config("password");
            $dbname = get_config("dbname");

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                Database::$conn = $conn;
                // print ($conn);
                return Database::$conn;
            }
        } else {
            // return the previous connection
            return Database::$conn;
        }
    }
}
