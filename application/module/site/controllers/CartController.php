<?php

    class CartController extends Controller {

        public function __construct($arrParams){
            parent::__construct($arrParams);
            $this->_templateObj->setFileTemplate('index.php');
            $this->_templateObj->setFolderTemplate('site/main');
            $this->_templateObj->setFileConfig('template.ini');
            $this->_templateObj->load();
        }

        public function indexAction(){
            $this->_viewObj->_titlePage = 'Giỏ Hàng - Bookstore';

            $cart = Session::get('cart');
            if(empty($cart['quantity']) && empty($cart['price'])){               
                Session::delete('cart');
                Session::delete('totalPrice');
                Session::delete('totalProduct');
            }

            $this->_viewObj->listItemsInCart = $this->_modelObj->listItemsInCart($this->_arrParams);
            $this->_viewObj->render('cart/index');
        }


        public function addToCartAction(){
           
            $cart = Session::get('cart');
            $bookID = $this->_arrParams['book_id'];
            $price = $this->_arrParams['price'];

            if(empty($cart)){
                $cart = [];
                $cart['quantity'][$bookID] = 1;
                $cart['price'][$bookID] = $price; 
            }
            else{
                if(!key_exists($bookID, $cart['quantity'])){
                    $cart['quantity'][$bookID] = 1;
                    $cart['price'][$bookID] = $price;                  
                }
                else{
                    $cart['quantity'][$bookID] += 1;
                    $cart['price'][$bookID] = $price * $cart['quantity'][$bookID];
                }
            }
           
    
            Session::set('cart', $cart);
            // Session::delete('cart');
            $totalProduct = 0;

            $totalProduct = array_sum($cart['quantity']);
            Session::set('totalProduct', $totalProduct);

            $totalPrice = array_sum($cart['price']);
            Session::set('totalPrice', $totalPrice);
            
            
            echo json_encode(['totalProduct' => $totalProduct, 'totalPrice' => $totalPrice]);

        }



        public function removeAction(){
            $cart = Session::get('cart');
            if(!empty($cart)){             
                unset($cart['quantity'][$this->_arrParams['book_id']]);
                unset($cart['price'][$this->_arrParams['book_id']]);

                $totalProduct = array_sum($cart['quantity']);
                Session::set('totalProduct', $totalProduct);
        
                $totalPrice = array_sum($cart['price']);
                Session::set('totalPrice', $totalPrice);

                Session::set('cart', $cart);

                echo json_encode([
                    'bookId' => $this->_arrParams['book_id'],
                    'totalProduct' => $totalProduct, 
                    'totalPrice' => $totalPrice,
                    // 'emptyCart' => '<h3 class="text-center text-dark">Giỏ hàng trống trơn...</h3>'
                ]);    
            }

            
        }

        public function checkOutAction(){
            $this->_viewObj->listItemsInCart = $this->_modelObj->listItemsInCart($this->_arrParams);
            if(empty($this->_viewObj->listItemsInCart)){
                Url::redirect('site', 'index', 'notification', ['type' => 'check-out-fail'], 'notification/check-out-fail');
            }
            if(isset($this->_arrParams['form'])){
                $source = $this->_arrParams['form'];
                $validate = new Validate($source);
                $validate->addRule('fullname', 'string', array('min' => 3, 'max' => 128))
                         ->addRule('email', 'email')
                         ->addRule('phone_number', 'phone-number', array('min' => 0, 'max' => 10))
                         ->addRule('address', 'string', array('min' => 3, 'max' => 1024));

                $validate->runValidate();
                $this->_arrParams['form'] = $validate->getResult();
                if($validate->isValidate() == true){
                    $orderId = $this->_modelObj->saveItem($this->_arrParams, 'check-out');
                    Session::delete('cart');
                    Session::delete('totalPrice');
                    Session::delete('totalProduct');

                    $this->_arrParams['order_id'] = $orderId;
                    $orderObj = $this->_modelObj->getOrder($this->_arrParams); // đơn hàng
                    $orderDetailObj = $this->_modelObj->getOrderDetail($this->_arrParams); // chi tiết các sản phẩm trong đơn hàng
                    

                    // Phải redirect trước khi gửi email vì có thể trong quá trình gữi mail chạy lâu quá sẽ ko thể dùng header để redirect

                    // Url::redirect('admin', 'cart', 'orderComplete', null, 'order-complete');
                    // header('location: order-complete');
                    // Gửi mail
                    $path = LIBRARY_PATH . 'extends/Email.php';
                    if(file_exists($path)){
                        require_once $path;
                        $email = new Email();
                        $contentEmail = $email->createEmailOrderHtml($orderObj, $orderDetailObj);
                        $email->sendMail(
                            'quocle0103@gmail.com',
                            'Q01657658847',
                            $this->_arrParams['form']['email'],
                            $this->_arrParams['form']['fullname'],
                            $contentEmail
                        );
                    }
                    else{
                        echo 'Chưa có class Email bạn ơi'; 
                        die();
                    }
                    // exit();

                }
                else{
                    $this->_viewObj->errors = $validate->getErrors();
                }       
                // echo '<pre>';
                // print_r($validate);
            }
            $this->_viewObj->render('cart/check-out');
        }

        public function orderCompleteAction(){
            $this->_viewObj->render('cart/order-complete');
        }
    }
?>