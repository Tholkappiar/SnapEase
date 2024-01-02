<?php

class Sessions
{

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function unset()
    {
        session_unset();
    }

    public static function destory()
    {
        session_destroy();
    }

    public static function start()
    {
        session_start();
    }

    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public static function isset($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }

    public static function status()
    {
        return session_status() == PHP_SESSION_NONE ? false : true;
    }

    public static function load_template($template_name)
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . ("_templates/$template_name.php");
        if(file_exists($file)) {
            include $file;
        } else {
            Sessions::load_template('_error');
        }
    }

    public static function renderPage() {
        Sessions::load_template('_master');
    }

    public static function current_script() {
        $file = (basename($_SERVER['SCRIPT_NAME'], ".php" ));
        Sessions::load_template($file);
    }

    public static function isAuthenticated(){
        $user_sessions = new UserSessions();
        if(Sessions::isset('uid')){
            return Sessions::get('token') == $user_sessions->getToken();
        }
        return false;
    }

    public static function loginRedirect() {
        if(!Sessions::isAuthenticated()) {
            Sessions::set('_redirect',$_SERVER['REQUEST_URI']);
            header("Location: /login.php");
        }
    }

    // Check the user is the owner of the post.
    public static function isOwner($uid){
        return $uid == Sessions::get('uid');
    }
}
