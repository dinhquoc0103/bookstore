<?php

    class BookModel extends Model {
        private $_userObj;
        private $uploadObj;
        public function __construct(){
            parent::__construct();
            $this->setTable(TB_BOOK);
            require_once LIBRARY_PATH . 'extends/Upload.php';     
            $this->uploadObj = new Upload();
            $this->_userObj = Session::get('user');
        }

        // 
        public function listItems($arrParams, $options = null){
            $sql[] = "SELECT b.name, b.image, b.price, b.status, b.special, b.sale_off, b.sort_order, b.created, b.created_by, b.modified, b.modified_by, b.id, c.name AS category_name";
            $sql[] = "FROM ".$this->table." AS b LEFT JOIN ".TB_CATEGORY." AS c ON  b.category_id = c.id";
            $sql[] = "WHERE b.id > 0";

            // Search theo từ khóa dựa vào cột name
            if(isset($arrParams['keyword'])){
                Session::delete('keyword');
                if($arrParams['keyword'] != null){
                    $sql[] = "AND b.name LIKE '%" . $arrParams['keyword'] . "%'";
                    Session::set('keyword', $arrParams['keyword']);
                }
            }
            else{
                $keyword = Session::get('keyword');
                if($keyword != null){
                    $sql[] = "AND (b.name LIKE '%" . $keyword . "%'";
                }
            }


            // Filter theo status
            if(isset($arrParams['filter_status'])){
                if(in_array($arrParams['filter_status'], [0,1])){
                    $sql[] = "AND b.status = " . $arrParams['filter_status'];
                } 
                Session::set('filter_status', $arrParams['filter_status']);
            }
            else{
                $filterStatus = Session::get('filter_status');
                if($filterStatus != null){
                    if(in_array($filterStatus, [0,1])){
                        $sql[] = "AND b.status = $filterStatus";
                    }
                }
            }
           

            // // Filter theo status của cột category id
            if(isset($arrParams['filter_category_name'])){
                if(in_array($arrParams['filter_category_name'], $arrParams['arrAcceptCategory'])){
                    $sql[] = "AND b.category_id = " . $arrParams['filter_category_name'];
                }
                Session::set('filter_category_name', $arrParams['filter_category_name']);
            }
            else{
                $filterCategoryName = Session::get('filter_category_name');
                if($filterCategoryName != null){
                    if(in_array($filterCategoryName, $arrParams['arrAcceptCategory'])){
                        $sql[] = "AND b.category_id = $filterCategoryName";
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
                    $sql[] = "ORDER BY b.$column $orderBy";
                    Session::set('sort_by', $arrParams['sort_by']);

                }
                else{
                    $sql[] = "ORDER BY b.id DESC";
                }
            }
            else{
                $sortBy = Session::get('sort_by');
                
                if(!empty($sortBy)){
                    $sortBy = explode('-', $sortBy);
                    $sql[] = "ORDER BY b.$sortBy[1] $sortBy[0]";
                }
                else{
                    $sql[] = "ORDER BY b.id DESC";
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
                    $sql[] = "AND name LIKE '%" . $arrParams['keyword'] . "%'";
                    Session::set('keyword', $arrParams['keyword']);
                }
            }
            else{
                $keyword = Session::get('keyword');
                if($keyword != null){
                    $sql[] = "AND (name LIKE '%" . $keyword . "%'";
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
           

            // // Filter theo status của cột category id
            if(isset($arrParams['filter_category_name'])){
                if(in_array($arrParams['filter_category_name'], $arrParams['arrAcceptCategory'])){
                    $sql[] = "AND category_id = " . $arrParams['filter_category_name'];
                }
                Session::set('filter_category_name', $arrParams['filter_category_name']);
            }
            else{
                $filterCategoryName = Session::get('filter_category_name');
                if($filterCategoryName != null){
                    if(in_array($filterCategoryName, $arrParams['arrAcceptCategory'])){
                        $sql[] = "AND category_id = $filterCategoryName";
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
                    $arrParams['form']['image'] = $this->uploadObj->uploadFile($arrParams['form']['image'], 'book');
                    $arrParams['form']['created'] = date('Y-m-d', time());
                    $arrParams['form']['created_by'] = $this->_userObj['info_user']['fullname'];
                    
                    $data = $arrParams['form'];
                    $typeInsert = '1_row';
                    $this->insert($data, $typeInsert);
        
                    Session::set('message', 'Thêm mới book thành công!');
                break;
                case 'edit':
                    if($arrParams['form']['image']['name'] == null){
                        unset($arrParams['form']['image']);
                    }
                    else{
                        $this->uploadObj->deleteFile('book', $arrParams['form']['image_hidden']);
                        $arrParams['form']['image'] = $this->uploadObj->uploadFile($arrParams['form']['image'], 'book');
                    }
                    $id  = $arrParams['id'];
                    $arrParams['form']['modified'] = date('Y-m-d', time());
                    $arrParams['form']['modified_by'] = $this->_userObj['info_user']['fullname'];

                    unset($arrParams['form']['image_hidden']);
                    $data = $arrParams['form'];
                    $where = "id = $id";
                    
                    $this->update($data, $where);
        
                    Session::set('message', 'Chỉnh sửa book thành công!');
                break;
            }
           
        }

        public function itemInSelectBox($arrParams, $options = null){
            $sql = "SELECT id, name FROM " . TB_CATEGORY; 
            return $this->fetchPairs($sql, 'id', 'name');
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
                        'link' =>  Url::createLink('admin', 'book', 'ajaxChangeStatus', array('status' => $status, 'id' => $id)),
                    ];
                    return $result;
                break;

                case  'ajax-status-col-special':
                    $id = $arrParams['id'];
                    $special = ($arrParams['special'] == 1) ? 0 : 1;
                    
                    $data = [
                        'special' => $special, 
                        'modified' => $dateModified, 
                        'modified_by' => $modifiedBy
                    ];
                    $where = "id = $id";
                    $this->update($data, $where);

                    $result = [
                        'id' => $id,
                        'special' => $special, 
                        'modified' => date('d/m/Y', time()), 
                        'modified_by' =>  $modifiedBy,
                        'link' =>  Url::createLink('admin', 'book', 'ajaxChangeSpecial', array('special' => $special, 'id' => $id)),
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
                // Xóa ảnh trong folder upload trước khi xóa trên database
                $sql = "SELECT id, image FROM book WHERE id IN (".implode(',', $arrParams['checkBoxId']).")"; 
                $arrImage = $this->fetchPairs($sql, 'id', 'image');
                foreach($arrImage as $img){
                    $this->uploadObj->deleteFile('book', $img);
                }

                $where = $arrParams['checkBoxId']; 
                $quantity = $this->delete($where);

                Session::set('message', 'Xóa '.$quantity.' book thành công!');
            }
            else{
                Session::set('messageError', 'Bạn chưa tick chọn book nào!');
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
    
                    Session::set('message', 'Cập nhật thứ tự cho '.$arrParams['qty_sort_order'].' book thành công!');
                }
            }
            else{
                Session::set('messageError', 'Bạn chưa chọn và thay đổi thứ tự book nào!');
            }
        }


        // Lấy thông tin của 1 row để đổ ra edit
        public function getInfoItem($arrParams, $options = null){
            $sql[] = "SELECT id, name, image, price, status, special, sale_off, description, category_id, sort_order";
            $sql[] = "FROM " . $this->table;
            $sql[] = "WHERE id = '" . $arrParams['id'] . "'";
            $sql = implode(' ', $sql);

            return $this->singleSelect($sql);
        }

    }
?>
