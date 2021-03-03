<?php

    class Controller {

        // Obj View (thao tác với class View)
        protected $_viewObj;

        // Array tham số 
        protected $_arrParams;

        // Obj Model (thao tác với database)
        protected $_modelObj;

        // Obj Template (thao tác class Template)
        protected $_templateObj;

        // Array tham số pagination
        protected $_paginationParams = [
            'totalItemsPerPage' => 8,
            'pageRange' => 3,
        ];


        public function __construct($arrParams){
            $this->setView($arrParams['module']);
            $this->setModel($arrParams['module'], $arrParams['controller']);
            $this->setTemplate();

            $this->_paginationParams['currentPage'] = (isset($arrParams['page'])) ? $arrParams['page'] : 1;
            $arrParams['paginationParams'] =  $this->_paginationParams;

            $this->setArrParams($arrParams);

            $this->_viewObj->arrParams = $arrParams;
        }

        // Load model của controller đc khởi tạo (Tạo object model để thao tác database)
        public function setModel($module, $controller){
            $modelName = ucfirst($controller) . 'Model';
            $pathModelFile = MODULE_PATH . $module . DS . 'models' . DS . $modelName . '.php';

            if(file_exists($pathModelFile)){
                require_once $pathModelFile;
                $this->_modelObj = new $modelName();
            }
            else{
                echo 'errors';
            }
        }

        // Tạo đối tượng view để thao tác class View
        public function setView($module){
            $this->_viewObj = new View($module);
        }

        // Lấy object View
        public function getView(){
            return $this->_viewObj;
        }

        // Set array tham số 
        public function setArrParams($arrParams){
            $this->_arrParams = $arrParams;
        }

        // set obj template thao tác với class Template
        public function setTemplate(){
            $this->_templateObj = new Template($this);
        }

        // set tham số cho pagination
        public function setPagination($config){
            $this->_paginationParams['totalItemsPerPage'] = $config['totalItemsPerPage'];
            $this->_paginationParams['pageRange'] = $config['pageRange'];
            $this->_arrParams['paginationParams'] = $this->_paginationParams;
        }
        
    }
?>