<?php

    class Bootstrap {

        private $_arrParams;
        private $_controllerObj;

        public function init(){

            $this->setArrParams();

            $this->createControllerObj();

            $this->callAction();
        }

        // Set array tham số: lấy từ URL và post
        public function setArrParams(){
            // Array tham số
            $arrParams = array_merge($_GET, $_POST);

            // Không tồn tại 1 trong 3 thì đưa về mặc định
            if(!isset($arrParams['module']) || !isset($arrParams['controller']) || !isset($arrParams['action']) ){
                $arrParams = array(
                    'module' => DEFAULT_MODULE, 
                    'controller' => DEFAULT_CONTROLLER, 
                    'action' =>DEFAULT_ACTION
                );
            }

            $this->_arrParams = $arrParams;
        }

        // Tạo controller
        public function createControllerObj(){
            // Tên file controller
            $controllerName = ucfirst($this->_arrParams['controller']) . 'Controller';

            // Path đến file controller
            $pathControllerFile = MODULE_PATH . $this->_arrParams['module'] . DS . 'controllers' . DS . $controllerName . '.php';

            // Tồn tại
            if(file_exists($pathControllerFile)){
                // Tạo đối tượng controller
                require_once $pathControllerFile;
                $this->_controllerObj = new $controllerName($this->_arrParams);
            }
            else{
                $this->error();
            }
        }

        // Gọi action cần thực hiện
        public function callAction(){
            // echo '<pre>';
            // print_r($_SESSION); die();
            // // Tên action
            // $actionName = $this->_arrParams['action'] . 'Action';

            // if(method_exists($this->_controllerObj, $actionName)){
            //     $this->_controllerObj->$actionName();
            // }
            // else{
            //     $this->error();
            // }
            $user = Session::get('user');
            $logged = isset($user['login']) ? $user['login'] : null;
            $timeLogin = isset($user['time']) ? $user['time'] : null;
            $timeLogout = 0;
            if($timeLogin != null){
                $timeCurrent = time();
                $timeLogout = $timeCurrent - $timeLogin;
            }
            // echo '<pre>';
            // print_r($_SESSION);
            // Session::delete('user');
            $actionName = $this->_arrParams['action'] . 'Action';
            if(method_exists($this->_controllerObj, $actionName)){
                switch ($this->_arrParams['module']){
                    case 'admin':
                        // echo '<pre>';
                        // print_r($this->_arrParams);
                        // echo 'hahas'; die();
                        if($logged == true){
                            if($this->_arrParams['action'] == 'login'){
                                Url::redirect('admin', 'error', 'index', null, 'admin/error');
                            }
                            if($timeLogout > 7200){
                                Session::delete('user');
                                Url::redirect('admin', 'index', 'login', null, 'admin/index/login');
                            }
                            $this->_controllerObj->$actionName();        
                        }
                        else{
                            if($this->_arrParams['action'] == 'login'){
                                $this->_controllerObj->$actionName();
                            }
                            else{
                                Url::redirect('admin', 'index', 'login', null, 'admin/index/login');
                            }
                        }   
                    break;
                    case 'site':
                        if($logged == true){
                            if(in_array($this->_arrParams['action'], ['login', 'register'])){
                                Url::redirect('site', 'index', 'index', null, 'home');
                            }
                            $this->_controllerObj->$actionName();   
                        }
                        else{
                            $this->_controllerObj->$actionName();   
                        }                   
                    break; 
                }
            }
            else{
                switch ($this->_arrParams['module']){
                    case 'admin':
                        Url::redirect('admin', 'error', 'index', null, 'admin/error');                       
                    break;
                    case 'site':
                        Url::redirect('site', 'error', 'index', null, 'error');                       
                    break; 
                }
            }
            
        }

        // Nếu lỗi
        public function error(){
            $pathErrorFile = MODULE_PATH . 'default' . DS . 'controllers' . DS . 'ErrorController.php';
            if(file_exists($pathErrorFile)){
                require_once $pathErrorFile;
                $controllerObj = new ErrorController();
                $controllerObj->viewError();
            }

        }
    }
?>