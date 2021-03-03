<?php

    class CategoryController extends Controller {

        public function __construct($arrParams){
            parent::__construct($arrParams);
            $this->_templateObj->setFolderTemplate('admin/main');
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
            if(!isset($arrParams['page'])){
                Session::delete('keyword');
                Session::delete('filter_status');
                Session::delete('sort_by');
            }
        }

        // Index
        public function indexAction(){
            $this->_viewObj->_titlePage = 'Category Manager - Bookstore';

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
            $this->_viewObj->render('category/index');
        }

        // Add và Edit
        public function formAction(){
            $this->_viewObj->_titlePage = 'Add Category - Bookstore';
            $task = 'add';

            // Nếu có tham số id trên url biết ngay là edit
            if(isset($this->_arrParams['id'])){
                $this->_viewObj->_titlePage = 'Edit Category - Bookstore';
                $task = 'edit';
                $this->_arrParams['info_item'] = $this->_modelObj->getInfoItem($this->_arrParams);
                if(empty($this->_arrParams['info_item'])){
                    Url::redirect('admin', 'error', 'index', 'null', 'admin/error');
                } 
            }

            // Dùng chung cho Add và Edit
            if(!empty($this->_arrParams['form'])){
                $sourceInfo = $this->_arrParams['form'];
                $validate = new Validate($sourceInfo);
                $validate->addRule('name', 'string', array('min' => 3, 'max' => 128))
                         ->addRule('status', 'status', array('accept' => array(0,1)))
                         ->addRule('sort_order', 'int', array('min' => 1, 'max' => 128));

                $validate->runValidate();

                $this->_arrParams['form'] = $validate->getResult();
                if($validate->isValidate() == true){
                    $this->_modelObj->saveItem($this->_arrParams, $task);
                    if($task == 'add'){
                        Url::redirect('admin', 'category', 'form', null, 'admin/category/form');
                    }
                    else{
                        Url::redirect('admin', 'category', 'form', null, 'admin/category/form/id-'.$this->_arrParams['id']);
                    }
                   
                }
                else{
                    $this->_viewObj->errors = $validate->getErrors();
                }
            }

            $this->_viewObj->arrParams = $this->_arrParams;
            $this->_viewObj->render('category/form');

        }


        // Thay đổi status của cột status bằng ajax
        public function ajaxChangeStatusAction(){
            $result = $this->_modelObj->changeStatus($this->_arrParams, 'ajax-status-col-status');
            echo json_encode($result);
        }

        // Xóa item
        public function trashAction(){
            $this->_modelObj->deleteItem($this->_arrParams);
            Url::redirect('admin', 'category', 'index', null, 'admin/category');
        }

        // Thay đổi số thứ tự của Item
        public function sortOrderAction(){
            $this->_modelObj->sortOrder($this->_arrParams);
            Url::redirect('admin', 'category', 'index', null, 'admin/category');
        }

        // Thay đổi status của cột status (nhiều cột một lượt)
        public function changeStatusAction(){
            $this->_modelObj->changeStatus($this->_arrParams, 'change-status');
            Url::redirect('admin', 'category', 'index', null, 'admin/category');
        }


        // Xóa keyword trên khung search
        public function clearKeywordAction(){
            Session::delete('keyword');
            Session::delete('filter_status');
            Session::delete('sort_by');
            Url::redirect('admin', 'category', 'index', null, 'admin/category');
        }
    }
?>