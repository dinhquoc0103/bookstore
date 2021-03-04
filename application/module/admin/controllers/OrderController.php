<?php

    class OrderController extends Controller {

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

        // Index Order
        public function indexAction(){
            $this->_viewObj->_titlePage = 'Order Manager - Bookstore';
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
            // echo '<pre>';
            // print_r($this->_viewObj->listItems); die();
            $this->_viewObj->render('order/index');
        }


   

        // Xóa item
        public function trashAction(){
            $this->_modelObj->deleteItem($this->_arrParams);
            Url::redirect('admin', 'order', 'index', null, 'admin/order');
        }


       
        public function changeOrderStatusAction(){
            $this->_modelObj->changeStatus($this->_arrParams, 'change-status');
            Url::redirect('admin', 'order', 'index', null, 'admin/order');
        }

        public function orderDetailAction(){
            $this->_viewObj->listItemsInOrderDetail = $this->_modelObj->listItemsInOrderDetail($this->_arrParams);
            if($this->_viewObj->listItemsInOrderDetail){
                Url::redirect('admin', 'error', 'index', 'null', 'admin/error');
            }
            $this->_viewObj->render('order/order-detail');
        }

        // // Xóa item
        // public function trashOrderDetailAction(){
        //     echo '<pre>';
        //     print_r($this->_arrParams); die();
        //     $this->_modelObj->deleteItem($this->_arrParams, 'order-detail');
        //     Url::redirect('admin', 'order', 'index', null, 'admin/order/orderDetail/id-'.$this->_arrParams['id']);
        // }


        // Xóa keyword trên khung search
        public function clearKeywordAction(){
            Session::delete('keyword');
            Session::delete('filter_status');
            Session::delete('sort_by');
            Url::redirect('admin', 'order', 'index', null, 'admin/order');
        }
    }
?>