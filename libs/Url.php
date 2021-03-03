<?php

    class Url {


        public static function createLink($module, $controller, $action, $params = null, $router = ''){
            if($router != ''){
                return ROOT_URL . $router;
            }
            else{
                // bookstore/index.php?module=admin&controller=group&action=index
                $url = ROOT_URL . "index.php?module=$module&controller=$controller&action=$action";
                if(!empty($params)){
                    foreach($params as $var => $value){
                        $url .= "&$var=$value";
                    }
                }
                return $url;
            }               
        }

        public static function redirect($module, $controller, $action, $params = null, $router = null){
            $link = self::createLink($module, $controller, $action, $params, $router);
            header('location: ' . $link);
            exit();    
        }
    }
?>