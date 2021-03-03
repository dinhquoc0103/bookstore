<?php

    class BookController extends Controller {

        public function __construct($arrParams){
            parent::__construct($arrParams);
            $this->_templateObj->setFolderTemplate('admin/main');
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
            if(!isset($arrParams['page'])){
                Session::delete('keyword');
                Session::delete('filter_status');
                Session::delete('filter_category_name');
                Session::delete('sort_by');
            }
        }

        // Index
        public function indexAction(){
            $this->_viewObj->_titlePage = 'Book Manager - Bookstore';

            $this->_viewObj->selectBoxCategory = $this->_modelObj->itemInSelectBox($this->_arrParams);
            $this->_arrParams['arrAcceptCategory'] = array_keys($this->_viewObj->selectBoxCategory);

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
            $this->_viewObj->render('book/index');
        }

        // Add và Edit
        public function formAction(){
            $this->_viewObj->selectBoxCategory = $this->_modelObj->itemInSelectBox($this->_arrParams);
            $arrAcceptCategory = array_keys($this->_viewObj->selectBoxCategory);

            $this->_viewObj->_titlePage = 'Add Book - Bookstore';
            $task = 'add';

            // Tồn tại input file thì thêm vào array form
            if(!empty($_FILES)){
                $this->_arrParams['form']['image'] = $_FILES['image'];
            }


            // Nếu có tham số id trên url biết ngay là edit
            if(isset($this->_arrParams['id'])){
                $this->_viewObj->_titlePage = 'Edit Book - Bookstore';
                $task = 'edit';
                $this->_arrParams['info_item'] = $this->_modelObj->getInfoItem($this->_arrParams); 
                if(empty($this->_arrParams['info_item'])){
                    Url::redirect('admin', 'error', 'index', 'null', 'admin/error');
                }
            }

            // Dùng chung cho Add và Edit
            if(!empty($this->_arrParams['form'])){
                // Loại bỏ khoảng trắng dư thừa ở hai đầu textarea nó hay dư lắm nên phải vậy 
                $this->_arrParams['form']['description'] = trim($this->_arrParams['form']['description']);

                $sourceInfo = $this->_arrParams['form'];
                $validate = new Validate($sourceInfo);
                $validate->addRule('name', 'string', array('min' => 3, 'max' => 128))
                         ->addRule('price', 'int', array('min' => 1000, 'max' => 100000000))
                         ->addRule('sale_off', 'percent', array('min' => 0, 'max' => 100))
                         ->addRule('status', 'status', array('accept' => array(0,1)))
                         ->addRule('special', 'status', array('accept' => array(0,1)))
                         ->addRule('category_id', 'status', array('accept' => $arrAcceptCategory))
                         ->addRule('image', 'file', array('min' => 100, 'max' => 1000000, 'extension' => array('jpg', 'png', 'jpeg', 'PNG'), 'task' => $task), false)
                         ->addRule('sort_order', 'int', array('min' => 1, 'max' => 128))
                         ->addRule('description', 'string', array('min' => 10, 'max' => 100000000));

                $validate->runValidate();

                $this->_arrParams['form'] = $validate->getResult();
                if($validate->isValidate() == true){
                    $id = $this->_modelObj->saveItem($this->_arrParams, $task);
                    if($task == 'add'){
                        Url::redirect('admin', 'book', 'form', null, 'admin/book/form');
                    }
                    else{
                        Url::redirect('admin', 'book', 'form', null, 'admin/book/form/id-'.$this->_arrParams['id']);
                    }
                }
                else{
                    $this->_viewObj->errors = $validate->getErrors();
                }
            }

            $this->_viewObj->arrParams = $this->_arrParams;
            $this->_viewObj->render('book/form');

        }


        // Thay đổi status của cột status bằng ajax
        public function ajaxChangeStatusAction(){
            $result = $this->_modelObj->changeStatus($this->_arrParams, 'ajax-status-col-status');
            echo json_encode($result);
        }

        // Thay đổi status của cột special
        public function ajaxChangeSpecialAction(){
            $result = $this->_modelObj->changeStatus($this->_arrParams, 'ajax-status-col-special');
            echo json_encode($result);
        }


        // Xóa item
        public function trashAction(){
            $this->_modelObj->deleteItem($this->_arrParams);
            Url::redirect('admin', 'book', 'index', null, 'admin/book');
        }

        // Thay đổi số thứ tự của Item
        public function sortOrderAction(){
            $this->_modelObj->sortOrder($this->_arrParams);
            Url::redirect('admin', 'book', 'index', null, 'admin/book');
        }

        // Thay đổi status của cột status (nhiều cột một lượt)
        public function changeStatusAction(){
            echo '<pre>';
            print_r($this->_arrParams); die();
            $this->_modelObj->changeStatus($this->_arrParams, 'change-status');
            Url::redirect('admin', 'book', 'index', null, 'admin/book');
        }


        // Xóa keyword trên khung search
        public function clearKeywordAction(){
            Session::delete('keyword');
            Session::delete('filter_status');
            Session::delete('filter_category_name');
            Session::delete('sort_by');
            Url::redirect('admin', 'book', 'index', null, 'admin/book');
        }
    }
?>