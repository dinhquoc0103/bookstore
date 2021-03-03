<?php

    $fullNameVal = (isset($this->arrParams['form']['fullname'])) ? $this->arrParams['form']['fullname'] : '';
    $emailVal = (isset($this->arrParams['form']['email'])) ? $this->arrParams['form']['email'] : '';
    $passwordVal = (isset($this->arrParams['form']['password'])) ? $this->arrParams['form']['password'] : '';

  
    $arrErrorVal = [
        'fullname' => '',
        'email' => '',
        'password' => '',
    ];
    if(isset($this->errors)){
        foreach($arrErrorVal as $key => $value){
            if(array_key_exists($key, $this->errors)){
                $arrErrorVal[$key] = $this->errors[$key];
            }
        }
    }

?>
<?php       
    include_once TEMPLATE_PATH . $this->arrParams['module'].'/main/html/breadcrumb.php';
?>
<main class="page-section inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb--30 mb-lg--0">
                <!-- Login Form s-->
                <form action="#" method="post" name="siteForm" id="siteForm">
                    <div class="login-form">
                        <h4 class="login-title">ĐĂNG KÝ TÀI KHOẢN</h4>
                        <p><span class="font-weight-bold">Khách hàng chưa có tài khoản!</span></p>
                        <div class="row">
                            <div class="col-md-12 col-12 mb--15">
                                <label for="email" class="font-weight-bold">Full Name</label>
                                <input class="mb-0 form-control" name="form[fullname]"
                                    value="<?php echo $fullNameVal; ?>" type="text" id="fullname"
                                    placeholder="Enter your full name">
                                <span style="color: red;"><?php echo $arrErrorVal['fullname']; ?></span>
                            </div>
                            <div class="col-12 mb--20">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input class="mb-0 form-control" name="form[email]" value="<?php echo $emailVal; ?>"
                                    type="email" id="email" placeholder="Enter Your Email Address Here..">
                                <span style="color: red;"><?php echo $arrErrorVal['email']; ?></span>
                            </div>
                            <div class="col-lg-12 mb--20">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input class="mb-0 form-control" name="form[password]"
                                    value="<?php echo $passwordVal; ?>" type="password" id="password"
                                    placeholder="Enter your password">
                                <span style="color: red;"><?php echo $arrErrorVal['password']; ?></span>
                            </div>
                            <div class="col-md-12">
                                <a href="#" class="btn btn-outlined" id="btn-register">Đăng Ký</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>