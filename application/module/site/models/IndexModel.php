<?php

    class IndexModel extends Model {

        public function __construct(){
            parent::__construct();
        }

        public function listItems($arrParams, $options){
            switch ($options){
                case 'featured':
                    $sql[] = "SELECT id, name, image, price, sale_off, special";
                    $sql[] = "FROM ".TB_BOOK;
                    $sql[] = "WHERE status = 1 AND special = 1";
                    $sql = implode(' ', $sql);
                    return $this->select($sql);
                break;
                case 'discount-over-50':
                    $sql[] = "SELECT id, name, image, price, sale_off, special";
                    $sql[] = "FROM ".TB_BOOK;
                    $sql[] = "WHERE status = 1 AND sale_off >= 50";
                    $sql = implode(' ', $sql);
                    return $this->select($sql);
                break;
                case 'new-arrival':
                    $sql[] = "SELECT id, name, image, price, sale_off, special";
                    $sql[] = "FROM ".TB_BOOK;
                    $sql[] = "WHERE status = 1";
                    $sql[] = "ORDER BY id DESC";
                    $sql[] = "LIMIT 0, 6";
                    $sql = implode(' ', $sql);
                    return $this->select($sql);
                break;

            }
        }

        public function saveItem($arrParams, $options){
            switch ($options){
                case 'register-user':
                    $this->setTable(TB_USER);
                    $arrParams['form']['register_date'] = date('Y-m-d', time());
                    $arrParams['form']['password'] = md5($arrParams['form']['password'] );
                    
                    $data = $arrParams['form'];
                    $typeInsert = '1_row';
                    $this->insert($data, $typeInsert);
        
                    return $this->lastRowID();
                break;

            }
        }
        
        public function activeAccount($arrParams, $options = null){
            $id = $arrParams['user_id'];
            $activeCode = $arrParams['active_code'];

            $data = ['status' => 1, 'active_code' => 1];
            $where = "id = '$id' AND active_code = '$activeCode'";
            $this->update($data, $where);
        }

        public function getInfoUser($arrParams, $options = null){
            $sql[] = "SELECT u.id, u.fullname, u.email, g.group_acp";
            $sql[] = "FROM " .TB_USER." AS u LEFT JOIN ".TB_GROUP." AS g ON  u.group_id = g.id ";
            $sql[] = "WHERE email = '".$arrParams['form']['email']."' AND password = '".md5($arrParams['form']['password'])."'";

            $sql = implode(' ', $sql); 
            return $this->singleSelect($sql);

           
        }

        public function listItemsSearch($arrParams, $options = null){
            $sql[] = "SELECT id, name, image, price, special, sale_off";
            $sql[] = "FROM ".TB_BOOK;
            $sql[] = "WHERE name LIKE '%".$arrParams['keyword']."%'";

             // Pagination
            $currentPage = $arrParams['paginationParams']['currentPage'];
            $totalItemsPerPage = $arrParams['paginationParams']['totalItemsPerPage'];
            $position = ($currentPage - 1) * $totalItemsPerPage ;
            if($totalItemsPerPage > 0){
                $sql[] = "LIMIT $position, $totalItemsPerPage";
            }
            
            $sql = implode(' ', $sql);
            return $this->select($sql);
        }

        // đếm cho pagination
        public function countItems($arrParams, $options = null){
            $sql[] = "SELECT COUNT(id) AS total_items";
            $sql[] = "FROM ".TB_BOOK;
            $sql[] = "WHERE name LIKE '%".$arrParams['keyword']."%'";

                
            $sql = implode(' ', $sql) ; 

            $result = $this->singleSelect($sql);
            return $result['total_items'];
        }
      
    }
?>
