<?php

    class BookController extends Controller {

        public function __construct($arrParams){
            parent::__construct($arrParams);
            $this->_templateObj->setFolderTemplate('site/main');
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
            if(!isset($arrParams['page'])){
                Session::delete('sort_by');
            } 
        }

        private function createPagination(){
             // Tạo pagination:
            // -- Đếm số phần tử cho pagination bao gồm cả khi đã filter
            $totalItems = $this->_modelObj->countItems($this->_arrParams);
            // -- Set tham số cho pagination: không xét sài mặc định ở controller để nhiều action cùng sd
            $paginationObj = new Pagination($totalItems, $this->_paginationParams);
            // Kiểm tra trường hợp page ko tồn tại (có 1 TH khi search keyword ko tồn tại thì sẽ là đếm ra totalItems là 0 nên loại TH đó)
            if(ceil($totalItems/$this->_arrParams['paginationParams']['totalItemsPerPage']) > 0){
                if($this->_arrParams['paginationParams']['currentPage'] > ceil($totalItems/$this->_arrParams['paginationParams']['totalItemsPerPage'])){
                    Url::redirect('site', 'error', 'index', 'null', 'error');
                }
            }
            // Ở list book phân trang sẽ khác so với admin
            $categoryName = $this->_modelObj->getCategoryName($this->_arrParams);
            $this->_viewObj->categoryName = $categoryName;

            $this->_viewObj->paginationHtml = $paginationObj->showPaginationSite(
                $this->_arrParams['controller'],
                $this->_arrParams['action'],
                [
                    'name' => Helper::unsignedStr($categoryName),
                    'category_id' => $this->_arrParams['category_id']
                ]
            );

        }

        public function listAction(){
            $this->createPagination();
            $this->_viewObj->_titlePage = ucwords($this->_viewObj->categoryName);

            $listItems= $this->_modelObj->listItems($this->_arrParams);
            if(empty($listItems)){
                Url::redirect('site', 'error', 'index', null, 'error');
            }
            $this->_viewObj->listItems = $listItems;

            $this->_viewObj->render('book/list');
        }

        public function ajaxSortByListAction(){
            $this->createPagination();
            $this->_viewObj->listItems = $this->_modelObj->listItems($this->_arrParams);
            $this->_viewObj->render('book/ajaxList', false);

        }

        public function detailAction(){

            $this->_viewObj->infoItem = $this->_modelObj->getInfoItem($this->_arrParams);
            if(empty($this->_viewObj->infoItem )){
                Url::redirect('site', 'error', 'index', null, 'error');
            }
            $this->_viewObj->listItemsRelate = $this->_modelObj->listItemsRelate($this->_arrParams);
            $this->_viewObj->render('book/detail');           
        }

       

        


       
    }
?>