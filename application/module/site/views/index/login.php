<?php
    $strErrorAcount = '';
    if(isset($this->errors['account'])){
        $strErrorAcount = '<div class="col-form-label col-12 mb--20" style="color: #F00;">'.$this->errors['account'].'</div>';
    }

?>
<?php       
    include_once TEMPLATE_PATH . $this->arrParams['module'].'/main/html/breadcrumb.php';
?>
<main class="page-section inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                <form action="#" method="post" name="siteForm" id="siteForm">
                    <div class="login-form">
                        <h4 class="login-title">ĐĂNG NHẬP</h4>
                        <p><span class="font-weight-bold">Khách Hàng Thân Thiết</span></p>
                        <div class="row">
                            <div class="col-md-12 col-12 mb--15">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input class="mb-0 form-control" name="form[email]" type="email" id="email"
                                    placeholder="Enter you email address here...">
                            </div>
                            <div class="col-12 mb--20">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input class="mb-0 form-control" name="form[password]" type="password" id="login-password"
                                    placeholder="Enter your password">
                            </div>
                            <?php echo $strErrorAcount;?>
                            <div class="col-md-12">
                                <a href="#" class="btn btn-outlined" id="btn-login">Đăng Nhập</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>