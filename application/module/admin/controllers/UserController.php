<?php

    class UserController extends Controller {

        public function __construct($arrParams){
            parent::__construct($arrParams);
            $this->_templateObj->setFolderTemplate('admin/main');
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
            if(!isset($arrParams['page'])){
                Session::delete('keyword');
                Session::delete('filter_status');
                Session::delete('filter_group_name');
                Session::delete('sort_by');
            }
        }

        // Index
        public function indexAction(){
            $this->_viewObj->_titlePage = 'User Manager - Bookstore';

            $this->_viewObj->selectBoxGroup = $this->_modelObj->itemInSelectBox($this->_arrParams);
            $this->_arrParams['arrAcceptGroup'] = array_keys($this->_viewObj->selectBoxGroup);

            // Tạo pagination:
            // -- Đếm số phần tử cho pagination bao gồm cả khi đã filter
            $totalItems = $this->_modelObj->countItems($this->_arrParams);
            // -- Set tham số cho pagination
            $this->setPagination([
                'totalItemsPerPage' => 3,
                'pageRange' => 3,
            ]);

            $paginationObj = new Pagination($totalItems, $this->_paginationParams);
            // Kiểm tra trường hợp page ko tồn tại (có 1 TH khi search keyword ko tồn tại thì sẽ là đếm ra totalItems là 0 nên loại TH đó)
            if(ceil($totalItems/$this->_arrParams['paginationParams']['totalItemsPerPage']) > 0){
                if($this->_arrParams['paginationParams']['currentPage'] > ceil($totalItems/$this->_arrParams['paginationParams']['totalItemsPerPage'])){
                    Url::redirect('admin', 'error', 'index', 'null', 'admin/error');
                }
            }
         
            $this->_viewObj->paginationHtml = $paginationObj->showPaginationAdmin($this->_arrParams['controller']);
            
          
 
            
            $this->_viewObj->listItems = $this->_modelObj->listItems($this->_arrParams);
            $this->_viewObj->render('user/index');
        }

        // Add và Edit
        public function formAction(){
            $this->_viewObj->selectBoxGroup = $this->_modelObj->itemInSelectBox($this->_arrParams);
            $arrAcceptGroup = array_keys($this->_viewObj->selectBoxGroup);

            $this->_viewObj->_titlePage = 'Add User - Bookstore';
            $task = 'add';

            // Nếu có tham số id trên url biết ngay là edit
            if(isset($this->_arrParams['id'])){
                $this->_viewObj->_titlePage = 'Edit User - Bookstore';
                $task = 'edit';
                $this->_arrParams['info_item'] = $this->_modelObj->getInfoItem($this->_arrParams); 
            
                if(empty($this->_arrParams['info_item'])){
                    Url::redirect('admin', 'error', 'index', 'null', 'admin/error');
                }
            }

            // Dùng chung cho Add và Edit
            if(!empty($this->_arrParams['form'])){
                $requirePass = true;
               
                $sqlEmail = "SELECT id FROM ".TB_USER." WHERE email = '" . $this->_arrParams['form']['email'] . "'";
                if($task == 'edit'){
                    $requirePass = false;
                    $sqlEmail .= "AND id <> '".$this->_arrParams['id']."'";
                }

                $sourceInfo = $this->_arrParams['form'];
                $validate = new Validate($sourceInfo);
                $validate->addRule('fullname', 'string', array('min' => 3, 'max' => 128))
                         ->addRule('email', 'email-notExistRow', array('task' => $task, 'database' => $this->_modelObj, 'sql' => $sqlEmail))
                         ->addRule('password', 'password', array('action' => $task), $requirePass)
                         ->addRule('status', 'status', array('accept' => array(0,1)))
                         ->addRule('group_id', 'status', array('accept' => $arrAcceptGroup))
                         ->addRule('sort_order', 'int', array('min' => 1, 'max' => 128));

                $validate->runValidate();

                $this->_arrParams['form'] = $validate->getResult();
                if($validate->isValidate() == true){
                    $this->_modelObj->saveItem($this->_arrParams, $task);
                    if($task == 'add'){
                        Url::redirect('admin', 'user', 'form', null, 'admin/user/form');
                    }
                    else{
                        Url::redirect('admin', 'user', 'form', null, 'admin/user/form/id-'.$this->_arrParams['id']);
                    }
                   
                }
                else{
                    $this->_viewObj->errors = $validate->getErrors();
                }
            }

            $this->_viewObj->arrParams = $this->_arrParams;
            $this->_viewObj->render('user/form');

        }


        // Thay đổi status của cột status bằng ajax
        public function ajaxChangeStatusAction(){
            $result = $this->_modelObj->changeStatus($this->_arrParams, 'ajax-status-col-status');
            echo json_encode($result);
        }


        // Xóa item
        public function trashAction(){
            $this->_modelObj->deleteItem($this->_arrParams);
            Url::redirect('admin', 'user', 'index', null, 'admin/user');
        }

        // Thay đổi số thứ tự của Item
        public function sortOrderAction(){
            $this->_modelObj->sortOrder($this->_arrParams);
            Url::redirect('admin', 'user', 'index', null, 'admin/user');
        }

        // Thay đổi status của cột status (nhiều cột một lượt)
        public function changeStatusAction(){
            $this->_modelObj->changeStatus($this->_arrParams, 'change-status');
            Url::redirect('admin', 'user', 'index', null, 'admin/user');
        }


        // Xóa keyword trên khung search
        public function clearKeywordAction(){
            Session::delete('keyword');
            Session::delete('filter_status');
            Session::delete('filter_group_name');
            Session::delete('sort_by');
            Url::redirect('admin', 'user', 'index', null, 'admin/user');
        }
    }
?>