<?php

    class UserModel extends Model {
        private $_userObj;
        public function __construct(){
            parent::__construct();
            $this->setTable(TB_USER);
            $this->_userObj = Session::get('user');
        }

        // Add vào database
        public function listItems($arrParams, $options = null){
            $sql[] = "SELECT u.fullname, u.email, u.address, u.status, u.sort_order, u.created, u.created_by, u.modified, u.modified_by, u.id, g.name AS group_name";
            $sql[] = "FROM ".$this->table." AS u LEFT JOIN ".TB_GROUP." AS g ON  u.group_id = g.id";
            $sql[] = "WHERE u.id > 0";

            // Search theo từ khóa dựa vào cột name
            if(isset($arrParams['keyword'])){
                Session::delete('keyword');
                if($arrParams['keyword'] != null){
                    $sql[] = "AND (u.fullname LIKE '%" . $arrParams['keyword'] . "%' OR u.email LIKE '%" . $arrParams['keyword'] . "%')";
                    Session::set('keyword', $arrParams['keyword']);
                }
            }
            else{
                $keyword = Session::get('keyword');
                if($keyword != null){
                    $sql[] = "AND (u.fullname LIKE '%" . $keyword . "%' OR u.email LIKE '%" . $keyword . "%')";
                }
            }


            // Filter theo status
            if(isset($arrParams['filter_status'])){
                if(in_array($arrParams['filter_status'], [0,1])){
                    $sql[] = "AND u.status = " . $arrParams['filter_status'];
                } 
                Session::set('filter_status', $arrParams['filter_status']);
            }
            else{
                $filterStatus = Session::get('filter_status');
                if($filterStatus != null){
                    if(in_array($filterStatus, [0,1])){
                        $sql[] = "AND u.status = $filterStatus";
                    }
                }
            }
           

            // // Filter theo status của cột group id
            if(isset($arrParams['filter_group_name'])){
                if(in_array($arrParams['filter_group_name'], $arrParams['arrAcceptGroup'])){
                    $sql[] = "AND u.group_id = " . $arrParams['filter_group_name'];
                }
                Session::set('filter_group_name', $arrParams['filter_group_name']);
            }
            else{
                $filterGroupName = Session::get('filter_group_name');
                if($filterGroupName != null){
                    if(in_array($filterGroupName, $arrParams['arrAcceptGroup'])){
                        $sql[] = "AND u.group_id = $filterGroupName";
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
                    $sql[] = "ORDER BY u.$column $orderBy";
                    Session::set('sort_by', $arrParams['sort_by']);

                }
                else{
                    $sql[] = "ORDER BY u.id DESC";
                }
            }
            else{
                $sortBy = Session::get('sort_by');
                
                if(!empty($sortBy)){
                    $sortBy = explode('-', $sortBy);
                    $sql[] = "ORDER BY u.$sortBy[1] $sortBy[0]";
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

        // Đếm phần tử cho pagination
        public function countItems($arrParams, $options = null){
            $sql[] = "SELECT COUNT(id) AS total_items";
            $sql[] = "FROM " . $this->table;
            $sql[] = "WHERE id > 0";

             // Search theo từ khóa dựa vào cột name
             if(isset($arrParams['keyword'])){
                Session::delete('keyword');
                if($arrParams['keyword'] != null){
                    $sql[] = "AND (fullname LIKE '%" . $arrParams['keyword'] . "%' OR email LIKE '%" . $arrParams['keyword'] . "%')";
                    Session::set('keyword', $arrParams['keyword']);
                }
            }
            else{
                $keyword = Session::get('keyword');
                if($keyword != null){
                    $sql[] = "AND (fullname LIKE '%" . $keyword . "%' OR email LIKE '%" . $keyword . "%')";
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
           
     
            // // Filter theo status của cột group id
            if(isset($arrParams['filter_group_name'])){
                if(in_array($arrParams['filter_group_name'], $arrParams['arrAcceptGroup'])){
                    $sql[] = "AND group_id = " . $arrParams['filter_group_name'];
                }
                Session::set('filter_group_name', $arrParams['filter_group_name']);
            }
            else{
                $filterGroupName = Session::get('filter_group_name');
                if($filterGroupName != null){
                    if(in_array($filterGroupName, $arrParams['arrAcceptGroup'])){
                        $sql[] = "AND group_id = $filterGroupName";
                    } 
                }           
            }

            // // echo '<pre>';
            // // print_r($arrParams);
            
                
            $sql = implode(' ', $sql) ; 

            $result = $this->singleSelect($sql);
            return $result['total_items'];
        }

        // Add vào database
        public function saveItem($arrParams, $options = null){
            switch ($options){
                case 'add':
                    $arrParams['form']['created'] = date('Y-m-d', time());
                    $arrParams['form']['created_by'] =  $this->_userObj['info_user']['fullname'];
                    $arrParams['form']['password'] = md5($arrParams['form']['password'] );
                    
                    $data = $arrParams['form'];
                    $typeInsert = '1_row';
                    $this->insert($data, $typeInsert);
        
                    Session::set('message', 'Thêm mới user thành công!');
                break;
                case 'edit':
                    if($arrParams['form']['password'] == null){
                        unset($arrParams['form']['password']);
                    }
                    else{
                        $arrParams['form']['password'] = md5($arrParams['form']['password'] );
                    }
                    $id  = $arrParams['id'];
                    $arrParams['form']['modified'] = date('Y-m-d', time());
                    $arrParams['form']['modified_by'] =  $this->_userObj['info_user']['fullname'];

                    
                    $data = $arrParams['form'];
                    $where = "id = $id";
                    
                    $this->update($data, $where);
        
                    Session::set('message', 'Chỉnh sửa user thành công!');
                break;
            }
           
        }

        public function itemInSelectBox($arrParams, $options = null){
            $sql = "SELECT id, name FROM " . TB_GROUP; 
            return $this->fetchPairs($sql, 'id', 'name');
        }

        // Update status
        public function changeStatus($arrParams, $options){
            $dateModified = date('Y-m-d', time());
            $modifiedBy =  $this->_userObj['info_user']['fullname'];
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
                        'link' =>  Url::createLink('admin', 'user', 'ajaxChangeStatus', array('status' => $status, 'id' => $id)),
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
                            Session::set('message', 'Cập nhật status '.$strStatus.' cho '.$quantity.' group thành công!');
                        }
                    }
                    else{
                        Session::set('messageError', 'Bạn chưa tick chọn group nào!');
                    }
                   
                break;
           }

          
        }

        // Xóa item
        public function deleteItem($arrParams, $options = null){
            if(!empty($arrParams['checkBoxId'])){
                $where = $arrParams['checkBoxId']; 
                $quantity = $this->delete($where);

                Session::set('message', 'Xóa '.$quantity.' user thành công!');
            }
            else{
                Session::set('messageError', 'Bạn chưa tick chọn user nào!');
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
                            'modified_by' =>  $this->_userObj['info_user']['fullname'],
                        ];
                        $where = "id = $id";
                        $this->update($data, $where);
                    }
    
                    Session::set('message', 'Cập nhật thứ tự cho '.$arrParams['qty_sort_order'].' user thành công!');
                }
            }
            else{
                Session::set('messageError', 'Bạn chưa chọn và thay đổi thứ tự user nào!');
            }
        }


        // Lấy thông tin của 1 row để đổ ra edit
        public function getInfoItem($arrParams, $options = null){
            $sql[] = "SELECT id, fullname, email, status, group_id, sort_order";
            $sql[] = "FROM " . $this->table;
            $sql[] = "WHERE id = '" . $arrParams['id'] . "'";
            $sql = implode(' ', $sql);

            return $this->singleSelect($sql);
        }


        


    }
?>
