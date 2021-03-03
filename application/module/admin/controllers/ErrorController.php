<?php

    class ErrorController extends Controller {

        public function __construct($arrParams){
            parent::__construct($arrParams);
            $this->_templateObj->setFolderTemplate('admin/main');
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
        }

        public function indexAction(){
            $this->_viewObj->_titlePage = 'Error Administration - Bookstore';

            $this->_viewObj->render('error/index');
        }

       
    }
?>