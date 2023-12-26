<?php

class Sessions {

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function unset() {
        session_unset();
    }

    public static function destory() {
        session_destroy();
    }

    public static function start() {
        session_start();
    }

    public static function delete($key) {
        unset($_SESSION[$key]);
    }

    public static function isset($key) {
        return isset($_SESSION[$key]);
    }

    public static function get($key) {
        return $_SESSION[$key];
    }
    
    public static function status(){
        return session_status() == PHP_SESSION_NONE ? false : true; 
    }
}