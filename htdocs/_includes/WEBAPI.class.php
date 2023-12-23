<?php

class WEBAPI {
    public function __construct(){
        
        global $__site_config;
        // $__site_config_path = dirname(is_link($_SERVER['DOCUMENT_ROOT']) ? readlink($_SERVER['DOCUMENT_ROOT']) : $_SERVER['DOCUMENT_ROOT']) . '/db.json';
        // $__site_config = file_get_contents($__site_config_path);

        $__site_config_path = __DIR__ . ("/../../project/db.json");
        $__site_config = file_get_contents($__site_config_path);
    }

    public function innitiateSession() {
        // session_start();
    }
}
