<?php

    class OrderModel extends Model {

        public function __construct(){
            parent::__construct();
            $this->setTable(TB_ORDER);
        }

        public function listItems($arrParams){
            $sql[] = "SELECT id, fullname, phone_number, email, address, order_code, total_price, status, created, modified";
            $sql[] = "FROM ".$this->table;
            $sql[] = "WHERE id > 0";

             // Search theo từ khóa dựa vào cột name
            if(isset($arrParams['keyword'])){
                Session::delete('keyword');
                if($arrParams['keyword'] != null){
                    $sql[] = "AND (order_code LIKE '%" . $arrParams['keyword'] . "%' OR email LIKE '%".$arrParams['keyword']."%')";
                    Session::set('keyword', $arrParams['keyword']);
                }
            }
            else{
                $keyword = Session::get('keyword');
                if($keyword != null){
                    $sql[] = "AND (order_code LIKE '%" . $keyword . "%' OR email LIKE '%".$keyword."%')";
                }
            }

            // Filter theo status
            if(isset($arrParams['filter_status'])){
                if(in_array($arrParams['filter_status'], [0,1,2,3])){
                    $sql[] = "AND status = " . $arrParams['filter_status'];
                } 
                Session::set('filter_status', $arrParams['filter_status']);
            }
            else{
                $filterStatus = Session::get('filter_status');
                if($filterStatus != null){
                    if(in_array($filterStatus, [0,1,2,3])){
                        $sql[] = "AND status = $filterStatus";
                    }
                }
            }

            $arrAccept = [
                '0' => 'asc-name', 
                '1' => 'desc-name',
                '2' => 'asc-sort_order',
                '3' => 'desc-sort_order',
                '4' => 'asc-created',
                '5' => 'desc-created',
                '6' => 'asc-modified',
                '7' => 'desc-modified',
                '8' => 'asc-id',
                '9' => 'desc-id',
            ];
            // // Sắp xếp theo
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


            $currentPage = $arrParams['paginationParams']['currentPage'];
            $totalItemsPerPage = $arrParams['paginationParams']['totalItemsPerPage'];
            $position = ($currentPage - 1) * $totalItemsPerPage ;
            if($totalItemsPerPage > 0){
                $sql[] = "LIMIT $position, $totalItemsPerPage";
            }

            $sql = implode(' ', $sql);

            return $this->select($sql);
        }


        public function changeStatus($arrParams){
            $data = [
                'status' => $arrParams['order_status'],
                'modified' => date('Y-m-d H:i:s', time())
            ];
            $where = "id = '".$arrParams['id']."'";
            $this->update($data, $where);
        }

        public function countItems($arrParams, $options = null){
            $sql[] = "SELECT COUNT(id) AS total_items";
            $sql[] = "FROM " . $this->table;
            $sql[] = "WHERE id > 0";

            // Search theo từ khóa dựa vào cột name
            if(isset($arrParams['keyword'])){
                Session::delete('keyword');
                if($arrParams['keyword'] != null){
                    $sql[] = "AND (order_code LIKE '%" . $arrParams['keyword'] . "%' OR email LIKE '%".$arrParams['keyword']."%')";
                    Session::set('keyword', $arrParams['keyword']);
                }
            }
            else{
                $keyword = Session::get('keyword');
                if($keyword != null){
                    $sql[] = "AND (order_code LIKE '%" . $keyword . "%' OR email LIKE '%".$keyword."%')";
                }
            }

            // Filter theo status
            if(isset($arrParams['filter_status'])){
                if(in_array($arrParams['filter_status'], [0,1,2,3])){
                    $sql[] = "AND status = " . $arrParams['filter_status'];
                } 
                Session::set('filter_status', $arrParams['filter_status']);
            }
            else{
                $filterStatus = Session::get('filter_status');
                if($filterStatus != null){
                    if(in_array($filterStatus, [0,1,2,3])){
                        $sql[] = "AND status = $filterStatus";
                    }
                }
            }
            
                
            $sql = implode(' ', $sql) ; 

            $result = $this->singleSelect($sql);
            return $result['total_items'];
        }

         // Xóa item
         public function deleteItem($arrParams, $options = null){
            if(!empty($arrParams['checkBoxId'])){
                if($options == 'order-detail'){
                    $this->setTable(TB_ORDER);
                }
                $where = $arrParams['checkBoxId']; 
                $quantity = $this->delete($where);

                Session::set('message', 'Xóa '.$quantity.' đơn hàng thành công!');
            }
            else{
                Session::set('messageError', 'Bạn chưa tick chọn đơn hàng nào!');
            }
        }

        public function listItemsInOrderDetail($arrParams){
            $sql[] = "SELECT id, name, image, price, sale_off, quantity, total_price ";
            $sql[] = "FROM ".TB_ORDER_DETAIL;
            $sql[] = "WHERE order_id = ".$arrParams['id'];
            $sql = implode($sql);
            return $this->select($sql);
        }
        
        
    }
?>
