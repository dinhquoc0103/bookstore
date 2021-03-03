<?php

    class IndexController extends Controller {

        public function __construct($arrParams){
            parent::__construct($arrParams);
            $this->_templateObj->setFolderTemplate('admin/main');
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
        }

        public function indexAction(){
            $this->_viewObj->_titlePage = 'Dashboard Administration - Bookstore';

            $this->_viewObj->render('index/index');
        }

        public function loginAction(){
            $this->_viewObj->_titlePage = 'Login Administration - Bookstore';
            if(isset($this->_arrParams['form'])){
                $source = ['account' => 'checkAcountLogin'];
                $validate = new Validate($source);

                $email = $this->_arrParams['form']['email'];
                $password = md5($this->_arrParams['form']['password']);
                $sqlAcount = "SELECT * FROM ".TB_USER." WHERE  email = '$email' AND password = '$password' AND status = 1";
                $validate->addRule('account', 'existRow', ['database' => $this->_modelObj, 'sql' => $sqlAcount]);
        
                $validate->runValidate();

                if($validate->isValidate()){
                    // login = true, time login, info user(name, thuộc group nào), group acp
                    $infoUser = $this->_modelObj->getInfoUser($this->_arrParams);
                    Session::set('user', [
                        'login' => true,
                        'time' => time(),
                        'info_user' => $infoUser,
                    ]);
                    $group_acp = (isset($infoUser['group_acp'])) ? $infoUser['group_acp'] : '';
                    if($group_acp  == 1){
                        Url::redirect('admin', 'index', 'index', null, 'admin/index');
                    }
                    else{
                        Session::delete('user');
                        $this->_viewObj->errors['account'] = 'Bạn không có quyền đăng nhập vào web quản trị';
                        // Url::redirect('admin', 'index', 'login', null, 'admin/index/login');
                    }
                }
                else{
                    $this->_viewObj->errors = $validate->getErrors();           
                }
            }
           
            $this->_viewObj->render('index/login');
        }
        

        public function logoutAction(){
            Session::delete('user');
            Url::redirect('admin', 'index', 'login', null, 'admin/index/login');
        }
    }
?>