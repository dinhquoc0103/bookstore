<?php

    class CartModel extends Model {
        private $_userObj;
        public function __construct(){
            parent::__construct();
            $this->setTable(TB_ORDER);
            $this->_userObj = Session::get('user');
            
        }


        public function listItemsInCart($arrParams){
            // echo '<pre>';
            // print_r($_SESSION);
            $cart = Session::get('cart');
            if(!empty($cart)){
                $strId = implode(',', array_keys($cart['quantity']));
                $sql = "SELECT id AS book_id, name, image, price, sale_off FROM ".TB_BOOK."WHERE id IN ($strId)";
                $arrBook = $this->select($sql);
                foreach($arrBook as $key => $book){
                    $arrBook[$key]['quantity'] = $cart['quantity'][$book['book_id']];
                    $arrBook[$key]['total_price'] = $cart['price'][$book['book_id']];
                }
                return $arrBook; 
            }
        }

        public function saveItem($arrParams, $options){
            switch($options){
                case 'check-out':
                    // Insert thông tin đơn hàng vào bảng order
                    $arrParams['form']['order_code'] = Helper::ramdomString(18);
                    $arrParams['form']['created'] = date("Y-m-d H:i:s", time());
                    if($this->_userObj != null){
                        $arrParams['form']['user_id'] = $this->_userObj['info_user']['id'];
                    }
                    $total = Session::get('totalPrice'); 
                    if($total != null){
                        $arrParams['form']['total_price'] = $total;
                    }
                    $data  = $arrParams['form'];
                    $typeInsert = '1_row';
                    $this->insert($data, $typeInsert);

                    $orderId = $this->lastRowID(); // Lấy id đơn hàng vừa đặt

                    // Insert các sản phẩm trong đơn hàng vào order_detail
                    $arrItemInOrder = $this->listItemsInCart($arrParams);
                    if(!empty($arrItemInOrder)){
                        $this->setTable(TB_ORDER_DETAIL);
                        foreach($arrItemInOrder as $key => $item){
                            $arrItemInOrder[$key]['order_id'] = $orderId;
                            $arrItemInOrder[$key]['created'] = date("Y-m-d H:i:s", time());
                        }
                        $data =  $arrItemInOrder;
                        $typeInsert = 'n_row';
                        $this->insert($data, $typeInsert);
                    }
                    return $orderId;
                break;
            }
        }

        public function getOrder($arrParams){
            $sql[] = "SELECT id, order_code, total_price, fullname, address, phone_number, order_note, created";
            $sql[] = "FROM ".TB_ORDER;
            $sql[] = "WHERE id = ".$arrParams['order_id'];

            $sql = implode(' ', $sql);
            return $this->singleSelect($sql);
        }

        public function getOrderDetail($arrParams){
            $sql[] = "SELECT id, book_id, name, price, sale_off, quantity, total_price";
            $sql[] = "FROM ".TB_ORDER_DETAIL;
            $sql[] = "WHERE order_id = ".$arrParams['order_id'];

            $sql = implode(' ', $sql); 
            return $this->select($sql);
        }
    }
?>