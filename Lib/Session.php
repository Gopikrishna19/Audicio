<?php
    namespace Lib;
    class Session {
        public static function init() {
            if(session_id() == '' || !isset($_SESSION)) {
                session_start();
            }
        }
    
        public static function set($key, $value) {
            self::init();
            $_SESSION[$key] = $value;
        }
    
        public static function get($key) {
            self::init();
            if(isset($_SESSION[$key])) return $_SESSION[$key];
            return FALSE;            
        }
    
        public static function remove($key) {
            self::init();
            if(isset($_GLOBALS[_SESSION][$key]))
                unset($_GLOBALS[_SESSION][$key]);
        }
    
        public static function stop() {
            self::init();
            session_unset();
            session_destroy();            
        }
    }    
?>