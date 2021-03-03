<?php

    class Session {

        // phương thức sử dụng để chạy trước tất cả các phương thức khác
        public static function init(){
           if(!isset($_SESSION)){
                session_start();
           }
        }

        public static function set($key, $value = null){
            $_SESSION[$key] = $value;
        }


        public static function get($key){
            if(isset($_SESSION[$key])) return $_SESSION[$key];
            else return '';
        }

        public static function delete($key){
            if(isset($_SESSION[$key])) unset($_SESSION[$key]);
        }

        public static function destroy(){
            session_unset();
        }
    }
?>