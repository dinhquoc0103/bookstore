<?php

    class IndexModel extends Model {

        public function __construct(){
            parent::__construct();
        }

        
        public function countItems($arrParams, $options = null){
            switch ($options){
                case 'total-users':
                    $sql = "SELECT COUNT(*) AS total_users FROM ".TB_USER;
                    $result = parent::singleSelect($sql);
                    return $result['total_users'];
                break;

                case 'total-orders':
                    $sql = "SELECT COUNT(*) AS total_orders FROM ".TB_ORDER;
                    $result = parent::singleSelect($sql);
                    return $result['total_orders'];
                break;

                case 'total-products':
                    $sql = "SELECT COUNT(*) AS total_products FROM ".TB_BOOK;
                    $result = parent::singleSelect($sql);
                    return $result['total_products'];
                break;

                case 'total-orders-completed':
                    $sql = "SELECT COUNT(*) AS total_orders_completed FROM ".TB_ORDER." WHERE status = 3";
                    $result = parent::singleSelect($sql);
                    return $result['total_orders_completed'];
                break;
            }
            
        }

        public function getInfoUser($arrParams, $options = null){
            
            $sql[] = "SELECT u.id, u.fullname, u.email, g.group_acp";
            $sql[] = "FROM " .TB_USER." AS u LEFT JOIN ".TB_GROUP." AS g ON  u.group_id = g.id ";
            $sql[] = "WHERE email = '".$arrParams['form']['email']."' AND password = '".md5($arrParams['form']['password'])."'";

            $sql = implode(' ', $sql); 
            return $this->singleSelect($sql);

           
        }
    }
?>
