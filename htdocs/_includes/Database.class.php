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
