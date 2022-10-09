<?php
    $linkHome = Url::createLink('site', 'index', 'index', null, 'home');
    $linkActive= Session::get('active_account');

    $strNotification = '';
    // <p>Hãy vào  <a href="https://mail.google.com/mail/u/0/#inbox" style="text-decoration: underline;"><b>EMAIL</b></a> để active tài khoản nhé!</p>

    if(isset($this->arrParams['type'])){
        switch ($this->arrParams['type']){
            case 'register-success':
                // $linkActiveAcount = Url::createLink('site', 'index', 'active', ['']);
                $strNotification = '<div class="row">
                                        <div class="col-12">
                                            <div class="order-complete-message text-center">
                                                <h3>Đăng ký tài khoản thành công!</h3>
                                                <p>Hãy click vào  <a href="'.$linkActive.'" style="text-decoration: underline;"><b>ACTIVE</b></a> để active tài khoản nhé!</p>
                                            </div>
                                            
                                        </div>
                                    </div>';
            break;

            case 'check-out-fail':
                $strNotification = '<div class="row">
                                        <div class="col-12">
                                            <div class="order-complete-message text-center mt--80 mb--80">
                                                <h3>Chưa có sản phẩm nào trong giỏ hàng. Chọn sản phẩm trước khi thanh toán nhé!</h3>
                                                <p>Tiếp tục mua sắm  <a href="'.$linkHome.'" style="text-decoration: underline;"><b>Trang Chủ</b></a></p>
                                            </div>
                                            
                                        </div>
                                    </div>';
            break;


            default:
                echo '<section class="order-complete inner-page-sec-padding-bottom mt--80 mb--80">
                            <div class="container text-center">
                                <b style="font-size: 18px">404 NOT FOUND! :((</b>
                            </div>
                        </section>';    
        }
    }
?>
<section class="order-complete inner-page-sec-padding-bottom">
    <div class="container">
        <?php echo $strNotification; ?>
    </div>
</section>