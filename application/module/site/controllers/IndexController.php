<?php
    class IndexController extends Controller {

        public function __construct($arrParams){
            parent::__construct($arrParams);
            $this->_templateObj->setFolderTemplate('site/main');
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
        }

        public function indexAction(){
            $this->_viewObj->_titlePage = 'Home - Bookstore';

            $this->_viewObj->listItemsFeatured = $this->_modelObj->listItems($this->_arrParams, 'featured');
            $this->_viewObj->listItemsDiscountOver50 = $this->_modelObj->listItems($this->_arrParams, 'discount-over-50');
            $this->_viewObj->listItemsNewArrival = $this->_modelObj->listItems($this->_arrParams, 'new-arrival');
            $this->_viewObj->render('index/index');
        }

        public function registerAction(){
            $this->_viewObj->_titlePage = 'Register Account - Bookstore';

            if(isset($this->_arrParams['form'])){
                $source = $this->_arrParams['form'];
                $validate = new Validate($source);

                $sqlEmail = "SELECT id FROM ".TB_USER." WHERE email = '" . $this->_arrParams['form']['email'] . "'";
                $validate->addRule('fullname', 'string', ['min' => '3', 'max' => 100])
                         ->addRule('email', 'email-notExistRow', ['database' => $this->_modelObj, 'sql' => $sqlEmail])
                         ->addRule('password', 'password', array('action' => 'add'));
                
                $validate->runValidate();

                $this->_arrParams['form'] = $validate->getResult();
                $this->_arrParams['form']['active_code'] = Helper::ramdomString(8);

                if($validate->isValidate() == true){
                   
                    $idInsert = $this->_modelObj->saveItem($this->_arrParams, 'register-user');
                    $path = LIBRARY_PATH . 'extends/Email.php';
                    if(file_exists($path)){
                        require_once $path;
                        $email = new Email();
                        // index.php?module=site&controller=index&action=active&user_id=5&active_code=xxxdfdf2232
                        $linkActive= "https://bookkg.herokuapp.com/home/active/userId-$idInsert/activeCode-".$this->_arrParams['form']['active_code'] ; 
                        $linkActive= Url::createLink(
                            null, null, null, null, $linkActive
                        ) ; 
                        $contentRegister = $email->createEmailRegisterHtml($linkActive);
                        $email->sendMail(
                            'dinhquoc0103@gmail.com',
                            'bookstore',
                            $this->_arrParams['form']['email'],
                            $this->_arrParams['form']['fullname'],
                            'Đăng Ký Tài Khoản Thành Công',
                            $contentRegister
                        );
                    }
                    else{
                        echo 'Chưa có class Email bạn ơi'; 
                        die();
                    }

                    Url::redirect('site', 'index', 'notification', ['type' => 'register-success'], 'notification/register-success');
                   
                }
                else{
                    $this->_viewObj->errors = $validate->getErrors();
                }

            }

            $this->_viewObj->arrParams = $this->_arrParams;
            $this->_viewObj->render('index/register');
        }

        public function activeAction(){
            $this->_modelObj->activeAccount($this->_arrParams);
            Url::redirect('site', 'index', 'login', null, 'home/login');
        }

        public function loginAction(){
            $this->_viewObj->_titlePage = 'Login Account - Bookstore';
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
                    Url::redirect('admin', 'index', 'index', null, 'home');
                    
                }
                else{
                    $this->_viewObj->errors = $validate->getErrors();          
                }
            }
            $this->_viewObj->render('index/login');
        }

        public function notificationAction(){
            $this->_viewObj->_titlePage = 'Notification - Bookstore';

            $this->_viewObj->render('index/notification');
        }

        public function logoutAction(){
            Session::delete('user');
            Url::redirect('site', 'index', 'index', null, 'home');
        }

        public function searchAction(){
            // echo '<pre>';
            // print_r($this->_arrParams);
            // Tạo pagination:
            // -- Đếm số phần tử cho pagination bao gồm cả khi đã filter
            $totalItems = $this->_modelObj->countItems($this->_arrParams);
            // -- Set tham số cho pagination
            $this->setPagination([
                'totalItemsPerPage' => 8,
                'pageRange' => 3,
            ]);

            $paginationObj = new Pagination($totalItems, $this->_paginationParams);
            // Kiểm tra trường hợp page ko tồn tại (có 1 TH khi search keyword ko tồn tại thì sẽ là đếm ra totalItems là 0 nên loại TH đó)
            if(ceil($totalItems/$this->_arrParams['paginationParams']['totalItemsPerPage']) > 0){
                if($this->_arrParams['paginationParams']['currentPage'] > ceil($totalItems/$this->_arrParams['paginationParams']['totalItemsPerPage'])){
                    Url::redirect('site', 'error', 'index', 'null', 'error');
                }
            }
         
            $this->_viewObj->paginationHtml = $paginationObj->showPaginationSite(
                $this->_arrParams['controller'],
                $this->_arrParams['action'],
                ['keyword' => str_replace(' ', '+', $this->_arrParams['keyword'])]
            );

            $this->_viewObj->listItemsSearch = $this->_modelObj->listItemsSearch($this->_arrParams);
            $this->_viewObj->render('index/search');           
        }

        

        
    }
?>