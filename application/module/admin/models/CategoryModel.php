<?php

    class CategoryModel extends Model {
        private $_userObj;
        public function __construct(){
            parent::__construct();
            $this->setTable(TB_CATEGORY);
            $this->_userObj = Session::get('user');
        }

        // Add vào database
        public function listItems($arrParams, $options = null){
            $sql[] = "SELECT name, status, sort_order, created, created_by, modified, modified_by, id";
            $sql[] = "FROM " . $this->table;
            $sql[] = "WHERE id > 0";

            // Search theo từ khóa dựa vào cột name
            if(isset($arrParams['keyword'])){
                Session::delete('keyword');
                if($arrParams['keyword'] != null){
                    $sql[] = "AND name LIKE '%" . $arrParams['keyword'] . "%'";
                    Session::set('keyword', $arrParams['keyword']);
                }
            }
            else{
                $keyword = Session::get('keyword');
                if($keyword != null){
                    $sql[] = "AND name LIKE '%" . $keyword . "%'";
                }
            }


            // Filter theo status
            if(isset($arrParams['filter_status'])){
                if(in_array($arrParams['filter_status'], [0,1])){
                    $sql[] = "AND status = " . $arrParams['filter_status'];
                } 
                Session::set('filter_status', $arrParams['filter_status']);
            }
            else{
                $filterStatus = Session::get('filter_status');
                if($filterStatus != null){
                    if(in_array($filterStatus, [0,1])){
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
            }

            $currentPage = $arrParams['paginationParams']['currentPage'];
            $totalItemsPerPage = $arrParams['paginationParams']['totalItemsPerPage'];
            $position = ($currentPage - 1) * $totalItemsPerPage ;
            // if($currentPage == 0) $position = 0;
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
            $sql[] = "WHERE id > 0";

             // Search theo từ khóa dựa vào cột name
             if(isset($arrParams['keyword'])){
                Session::delete('keyword');
                if($arrParams['keyword'] != null){
                    $sql[] = "AND name LIKE '%" . $arrParams['keyword'] . "%'";
                    Session::set('keyword', $arrParams['keyword']);
                }
            }
            else{
                $keyword = Session::get('keyword');
                if($keyword != null){
                    $sql[] = "AND name LIKE '%" . $keyword . "%'";
                }
            }


            // Filter theo status
            if(isset($arrParams['filter_status'])){
                if(in_array($arrParams['filter_status'], [0,1])){
                    $sql[] = "AND status = " . $arrParams['filter_status'];
                } 
                Session::set('filter_status', $arrParams['filter_status']);
            }
            else{
                $filterStatus = Session::get('filter_status');
                if($filterStatus != null){
                    if(in_array($filterStatus, [0,1])){
                        $sql[] = "AND status = $filterStatus";
                    }
                }
            }
           
                
            $sql = implode(' ', $sql) ; 

            $result = $this->singleSelect($sql);
            return $result['total_items'];
        }

        // Add vào database
        public function saveItem($arrParams, $options = null){
            switch ($options){
                case 'add':
                    $arrParams['form']['created'] = date('Y-m-d', time());
                    $arrParams['form']['created_by'] = $this->_userObj['info_user']['fullname'];
                    
                    $data = $arrParams['form'];
                    $typeInsert = '1_row';
                    $this->insert($data, $typeInsert);
        
                    Session::set('message', 'Thêm mới category thành công!');
                break;
                case 'edit':
                    $id  = $arrParams['id'];
                    $arrParams['form']['modified'] = date('Y-m-d', time());
                    $arrParams['form']['modified_by'] = $this->_userObj['info_user']['fullname'];
                    
                    $data = $arrParams['form'];
                    $where = "id = $id";
                    
                    $this->update($data, $where);
        
                    Session::set('message', 'Chỉnh sửa category thành công!');
                break;
            }
           
        }

        // Update status
        public function changeStatus($arrParams, $options){
            $dateModified = date('Y-m-d', time());
            $modifiedBy = $this->_userObj['info_user']['fullname'];
            switch ($options){
                case  'ajax-status-col-status':
                    $id = $arrParams['id'];
                    $status = ($arrParams['status'] == 1) ? 0 : 1;
                    
                    $data = [
                        'status' => $status, 
                        'modified' => $dateModified, 
                        'modified_by' => $modifiedBy
                    ];
                    $where = "id = $id";
                    $this->update($data, $where);

                    $result = [
                        'id' => $id,
                        'status' => $status, 
                        'modified' => date('d/m/Y', time()), 
                        'modified_by' =>  $modifiedBy,
                        'link' =>  Url::createLink('admin', 'category', 'ajaxChangeStatus', array('status' => $status, 'id' => $id)),
                    ];
                    return $result;
                break;

                case  'change-status':
                    if(!empty($arrParams['checkBoxId'])){
                        $strStatus = ($arrParams['status'] == 1) ? 'publish' : 'unpublish';
                        $data = [
                            'status' => $arrParams['status'], 
                            'modified' => $dateModified, 
                            'modified_by' => $modifiedBy
                        ];
                        $where = "id IN (".implode(',', $arrParams['checkBoxId']).")";
                        $quantity = $this->update($data, $where);
                        if($quantity > 0){
                            Session::set('message', 'Cập nhật status '.$strStatus.' cho '.$quantity.' category thành công!');
                        }
                    }
                    else{
                        Session::set('messageError', 'Bạn chưa tick chọn category nào!');
                    }
                   
                break;
           }

          
        }

        // Xóa item
        public function deleteItem($arrParams, $options = null){
            if(!empty($arrParams['checkBoxId'])){
                $where = $arrParams['checkBoxId']; 
                $quantity = $this->delete($where);

                Session::set('message', 'Xóa '.$quantity.' category thành công!');
            }
            else{
                Session::set('messageError', 'Bạn chưa tick chọn category nào!');
            }
        }

        // Thay đổi số thứ tự của các item
        public function sortOrder($arrParams, $options = null){
            if($arrParams['qty_sort_order'] > 0){
                if(!empty($arrParams['sortOrder'])){
                    foreach($arrParams['sortOrder'] as $id => $value){
                        $data = [
                            'sort_order' => $value,
                            'modified' => date('Y-m-d', time()),
                            'modified_by' => $this->_userObj['info_user']['fullname'],
                        ];
                        $where = "id = $id";
                        $this->update($data, $where);
                    }
    
                    Session::set('message', 'Cập nhật thứ tự cho '.$arrParams['qty_sort_order'].' category thành công!');
                }
            }
            else{
                Session::set('messageError', 'Bạn chưa chọn và thay đổi thứ tự category nào!');
            }
        }


        // Lấy thông tin của 1 row để đổ ra edit
        public function getInfoItem($arrParams, $options = null){
            $sql[] = "SELECT id, name, status, sort_order";
            $sql[] = "FROM " . $this->table;
            $sql[] = "WHERE id = '" . $arrParams['id'] . "'";
            $sql = implode(' ', $sql);

            return $this->singleSelect($sql);
        }


        


    }
?>
