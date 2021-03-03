<?php

    // echo '<pre>';
    // print_r($this->listItemsInCart);
    $yourOrder = '';
    if(!empty($this->listItemsInCart)){
        foreach($this->listItemsInCart as $item){
            $id = $item['book_id'];
            $name = $item['name'];
            $image = Helper::createImage('book', $item['image'], ['title' => $name]);
            $price = $item['price'];
            $saleOff = $item['sale_off'];
            $quantity = $item['quantity'];
            $totalPrice = $item['total_price'];
            $linkViewDetail = Url::createLink('site', 'book', 'detail', null, 'product/'.$nameUnsigned.'-'.$id);
            $yourOrder .= '  <li>
                                <span class="left" >
                                    <a href="'.$linkViewDetail.'" title="'.$name.'">
                                        '.Helper::shortenText($name, 12).'  <b> x '.$quantity.'</b>
                                    </a>
                                </span> 
                                <span class="right">'.number_format($totalPrice, 0, '', '.').'đ</span>
                            </li>';
        }
    }

    $arrValueForm = [
        'fullname' => '',
        'email' => '',
        'phone_number' => '',
        'address' => '',
    ];
   

    if(!empty($this->arrParams['form'])){
        foreach($this->arrParams['form'] as $key => $value){
            $arrValueForm[$key] = $value;  
        }
    }

    $arrErrors = [
        'fullname' => '',
        'email' => '',
        'phone_number' => '',
        'address' => '',
    ];

    if(!empty($this->errors)){
        foreach($arrErrors as $key => $value){
            if(key_exists($key, $this->errors)){
                $arrErrors[$key] = $this->errors[$key];
            }
        }
    }

    // echo '<pre>';
    // print_r($arrErrors);
?>
<?php       
    include_once TEMPLATE_PATH . $this->arrParams['module'].'/main/html/breadcrumb.php';
?>
<main id="content" class="page-section inner-page-sec-padding-bottom space-db--20">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Checkout Form s-->
                <div class="checkout-form">
                    <div class="row row-40">
                        <div class="col-12">
                            <h1 class="quick-title">Thanh Toán</h1>
                            <!-- Slide Down Trigger  -->
                            <div class="checkout-quick-box">
                                <p>
                                    <i class="far fa-sticky-note"></i>Nhớ điền đầy đủ thông tin bạn nhé!
                                    <!-- <a href="javascript:"
                                        class="slide-trigger" data-target="#quick-login">Click
                                        here to login</a> -->
                                </p>
                            </div>
                        </div>

                        <!-- Thông tin nhận hàng  -->
                        <div class="col-lg-7 mb--20">
                           <form action="" method="post" name="pay-form" id="pay-form">
                                <div id="billing-form" class="mb-40">
                                    <h4 class="checkout-title">Địa Chỉ - Thông Tin Nhận</h4>
                                    <div class="row">
                                        <div class="col-12 mb--20">
                                            <label>Họ Tên</label>
                                            <input type="text" name="form[fullname]" value="<?php echo $arrValueForm['fullname'] ?>" placeholder="Điền Họ Tên Đầy Đủ">
                                            <div class="col-form-label text-danger"><?php echo $arrErrors['fullname'] ?></div>
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Email*</label>
                                            <input type="text" name="form[email]" value="<?php echo $arrValueForm['email'] ?>" placeholder="Email Address">
                                            <div class="col-form-label text-danger"><?php echo $arrErrors['email'] ?></div>
                                        </div>
                                        <div class="col-md-6 col-12 mb--20">
                                            <label>Số Điện Thoại*</label>
                                            <input type="text" name="form[phone_number]" value="<?php echo $arrValueForm['phone_number'] ?>" placeholder="Phone number">
                                            <div class="col-form-label text-danger"><?php echo $arrErrors['phone_number'] ?></div>
                                        </div>
                                        <div class="col-12 mb--20">
                                            <label>Địa Chỉ*</label>
                                            <input type="text" name="form[address]" value="<?php echo $arrValueForm['address'] ?>" placeholder="Nơi nhận hàng">
                                            <div class="col-form-label text-danger"><?php echo $arrErrors['address'] ?></div>
                                        </div>
                                    
                                    
                                        
                                    </div>
                                </div>
                                
                                <div class="order-note-block mt--30">
                                    <label for="order-note">Ghi Chú Cho Đơn Hàng</label>
                                    <textarea id="order-note" name="form[order_note]" cols="30" rows="10" class="order-note"
                                        placeholder="Viết ghi chú cho đơn hàng..."></textarea>
                                </div>
                           </form>
                        </div>

                        <!-- Đơn hàng của bạn  -->
                        <div class="col-lg-5">
                            <div class="row">
                                <!-- Cart Total -->
                                <div class="col-12">
                                    <div class="checkout-cart-total">
                                        <h2 class="checkout-title">ĐƠN HÀNG CỦA BẠN</h2>
                                        <h4>Sản Phẩm <span>Tổng Giá</span></h4>
                                        <ul>
                                            <?php echo $yourOrder; ?>                                         
                                        </ul>
                                        <!-- <p>Tổng Phụ<span>$104.00</span></p>
                                        <p>Phí Vận Chuyển<span>$00.00</span></p> -->
                                        <h4>
                                            Tổng Cộng
                                            <span>
                                                <?php 
                                                    $total = Session::get('totalPrice'); 
                                                    if(!empty($total)) echo number_format($total, 0, '', '.') . 'đ'; 
                                                ?>
                                            </span>
                                        </h4>
                                        <div class="method-notice mt--25">
                                            <article>
                                                <h3 class="d-none sr-only">blog-article</h3>
                                                Hãy liên hệ với chúng tôi nếu bạn cần hỗ trợ hoặc muốn thay đổi đơn hàng nhé!
                                            </article>
                                        </div>
                                        <button class="place-order w-100" id="order-now">ĐẶT HÀNG NGAY</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>