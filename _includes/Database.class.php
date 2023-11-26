<?php


class Database
{
    // $conn - which holds the connection status
    public static $conn = null;

    public static function getConnection()
    {
        /**  --------------- used for single mysql connection rather than having multiple connections-----------
         *   check if the there is a connection else 
         *   if not create a new connection and return that , if already connected with the
         *   mysql server return the previous connection !
        */
        if (Database::$conn == null) {
            // mysql connection
            $servername = "mysql.selfmade.ninja:3306";
            $username = "SnapEase_Thols";
            $password = "thols@123";
            $dbname = "SnapEase_Thols_SnapEase";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
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
