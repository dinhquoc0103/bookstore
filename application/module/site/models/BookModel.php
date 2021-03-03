<?php

    class BookModel extends Model {

        public function __construct(){
           parent::__construct();
           $this->setTable(TB_BOOK);
        }

        // Add vào database
        public function listItems($arrParams, $options = null){
            $sql[] = "SELECT b.name, b.image, b.price, b.special, b.sale_off, b.id, b.category_id";
            $sql[] = "FROM ".$this->table." AS b, ".TB_CATEGORY." AS c";
            $sql[] = "WHERE b.category_id = c.id AND category_id = ".$arrParams['category_id']." AND b.status = 1 AND c.status = 1";

            // echo '<pre>';
            // print_r($_SESSION);
            $arrAccept = [
                '1' => 'asc-name', 
                '2' => 'desc-name',
            ];
            if(isset($arrParams['sort_by'])){
                $sortBy = array_search($arrParams['sort_by'], $arrAccept);
                if($sortBy != null){
                    $sortBy = explode('-', $arrAccept[$sortBy]);
                    $column = $sortBy[1];
                    $orderBy = $sortBy[0];
                    $sql[] = "ORDER BY $column $orderBy";
                    Session::set('sort_by', $arrParams['sort_by']);

                }
                else{
                    $sql[] = "ORDER BY id DESC";
                }
            }
            else{
                $sortBy = Session::get('sort_by');
                
                if(!empty($sortBy)){
                    $sortBy = explode('-', $sortBy);
                    $sql[] = "ORDER BY $sortBy[1] $sortBy[0]";
                }
                else{
                    $sql[] = "ORDER BY id DESC";
                }
            }
            
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


        // Đếm phần tử cho pagination
        public function countItems($arrParams, $options = null){
            $sql[] = "SELECT COUNT(id) AS total_items";
            $sql[] = "FROM " . $this->table;
            $sql[] = "WHERE category_id = ".$arrParams['category_id']." AND status = 1";

                
            $sql = implode(' ', $sql) ; 

            $result = $this->singleSelect($sql);
            return $result['total_items'];
        }

         // Đếm phần tử cho pagination
        public function getCategoryName($arrParams, $options = null){
            $sql[] = "SELECT name";
            $sql[] = "FROM " . TB_CATEGORY;
            $sql[] = "WHERE id = ".$arrParams['category_id'];

                
            $sql = implode(' ', $sql) ; 

            $result = $this->singleSelect($sql);
            return $result['name'];
        }

         // Lấy thông tin của 1 row book
        public function getInfoItem($arrParams, $options = null){
            $sql[] = "SELECT b.id, b.name, b.image, b.price, b.status, b.special, b.sale_off, b.description, b.category_id, c.name AS category_name, c.status AS category_status";
            $sql[] = "FROM " . $this->table." AS b LEFT JOIN ".TB_CATEGORY." AS c ON  b.category_id = c.id";
            $sql[] = "WHERE b.id = ".$arrParams['book_id'];
            $sql = implode(' ', $sql);

            return $this->singleSelect($sql);
        }

       
        public function listItemsRelate($arrParams, $options = null){
            // Lấy category_id của cuốn sách đang xem 
            $sqlCategoryId = "SELECT category_id FROM ".$this->table."WHERE id = ".$arrParams['book_id'];
            $result = $this->singleSelect($sqlCategoryId);

            // Truy vấn đến các cuốn sách có cùng category_id gọi là sách liên quan
            $sql = "SELECT id, name, image, price, special, sale_off FROM ".$this->table." WHERE category_id = ".$result['category_id']." AND id <> ".$arrParams['book_id']." ORDER BY id DESC";
            return $this->select($sql);
        }


         
       

    }
?>