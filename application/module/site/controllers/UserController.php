<?php

    class UserController extends Controller {

        public function __construct($arrParamsURL){
            parent::__construct($arrParamsURL);
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFolderTemplate('default/main');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
        }

        public function loginAction(){
            $this->_viewObj->render('user/login');
        }
    }
?>