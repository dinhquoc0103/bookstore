<?php

    class Template {

        // File template là file nào
        private $_fileTemplate;

        // Folder chứa file template đó
        private $_folderTemplate;

        // File config các tham số thẻ meta, title, link css, js là file nào
        private $_fileConfig;

        // Template của controller nào
        private $_controllerObj;


        public function __construct($controllerObj){
            $this->_controllerObj = $controllerObj;
        }

        // Load template
        public function load(){
            $fileTemplate = $this->_fileTemplate;
            $folderTemplate = $this->_folderTemplate;
            $fileConfig = $this->_fileConfig;

            // Chuyển file template.ini thành array
            $arrConfig = parse_ini_file(TEMPLATE_PATH . $folderTemplate . DS . $fileConfig);

            // Tạo đối tượng view để đẩy dữ liệu sang View
            $viewObj = $this->_controllerObj->getView();

            // Tạo các thẻ ở head
            $viewObj->_titlePage = $viewObj->createTitle($arrConfig['title']);
            $viewObj->_metaHTTP = $viewObj->createTagMeta($arrConfig['metaHTTP'], 'http');
            $viewObj->_metaName = $viewObj->createTagMeta($arrConfig['metaName'], 'name');
            if(isset($arrConfig['cssFiles'])){
                $viewObj->_cssFiles = $viewObj->createTagLink($this->_folderTemplate, $arrConfig['cssFiles'], 'css');
            }
            if(isset($arrConfig['jsFiles'])){
                $viewObj->_jsFiles = $viewObj->createTagLink($this->_folderTemplate, $arrConfig['jsFiles'], 'js');
            }

            // Set path đến template
            $viewObj->_templatePath = TEMPLATE_PATH . $folderTemplate . DS . $fileTemplate;
        }

        // Set fileTemplate
        public function setFileTemplate($value = 'index.php'){
            $this->_fileTemplate = $value;
        }

        // Get fileTemplate
        public function getFileTemplate(){
            return $this->_fileTemplate;
        }

        // Set folderTemplate
        public function setFolderTemplate($value = 'admin/main'){
            $this->_folderTemplate = $value;
        }

        // Get folderTemplate
        public function getFolderTemplate(){
            return $this->_folderTemplate;
        }

        // Set fileConfig
        public function setFileConfig($value = 'template.ini'){
            $this->_fileConfig = $value;
        }

        // Get fileConfig
        public function getFileConfig(){
            return $this->_fileConfig;
        }
    }
?>