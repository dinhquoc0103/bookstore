<?php

    class IndexModel extends Model {

        public function __construct(){
            parent::__construct();
        }

        
        // public function getInfoUser($arrParams, $options = null){
           
        //     $sql[] = "SELECT u.fullname, u.email, g.group_acp";
        //     $sql[] = "FROM " .TB_USER." AS u, ".TB_GROUP." AS g";
        //     $sql[] = "WHERE u.group_id = g.id AND email = '".$arrParams['form']['email']."' AND password = '".md5($arrParams['form']['password'])."'";
        //     $sql = implode(' ', $sql);

        //     return $this->singleSelect($sql);
        // }

        public function getInfoUser($arrParams, $options = null){
            
            $sql[] = "SELECT u.id, u.fullname, u.email, g.group_acp";
            $sql[] = "FROM " .TB_USER." AS u LEFT JOIN ".TB_GROUP." AS g ON  u.group_id = g.id ";
            $sql[] = "WHERE email = '".$arrParams['form']['email']."' AND password = '".md5($arrParams['form']['password'])."'";

            $sql = implode(' ', $sql); 
            return $this->singleSelect($sql);

           
        }
    }
?>
