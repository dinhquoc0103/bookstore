<div class="site-mobile-menu">
    <header class="mobile-header d-block d-lg-none pt--10 pb-md--10">
        <div class="container">
            <div class="row align-items-sm-end align-items-center">
                <div class="col-md-4 col-7">
                    <a href="<?php echo $linkHome; ?>" class="site-brand">
                        <img src="<?php echo $imgSrc; ?>/image/logo.png" alt="">
                    </a>
                </div>
                <div class="col-md-5 order-3 order-md-2">
                    <nav class="category-nav   ">
                        <div>
                            <a href="javascript:void(0)" class="category-trigger">
                                <i class="fa fa-bars"></i>
                                Danh Mục Loại Sách
                            </a>
                            <ul class="category-menu">
                                <?php
                                    echo $categoryHtml;
                                ?>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-md-3 col-5  order-md-3 text-right">
                    <div class="mobile-header-btns header-top-widget">
                        <ul class="header-links">
                            <li class="sin-link">
                                <a href="<?php echo $linkViewCart; ?>" class="cart-link link-icon"><i class="ion-bag"></i></a>
                            </li>
                            <li class="sin-link">
                                <a href="javascript:" class="link-icon hamburgur-icon off-canvas-btn"><i
                                        class="ion-navicon"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--Off Canvas Navigation Start-->
    <aside class="off-canvas-wrapper">
        <div class="btn-close-off-canvas">
            <i class="ion-android-close"></i>
        </div>
        <div class="off-canvas-inner">
            <!-- search box start -->
            <div class="search-box offcanvas">
                <form  action="" name="form-search" id="form-search-mobile">
                    <input type="text" class="keyword" name="keyword" value="<?php echo $keyword; ?>" placeholder="Nhập từ khóa">
                    <button class="btn-search-mobile"><i class="ion-ios-search-strong"></i></button>
                </form>
            </div>
            <!-- search box end -->
            <!-- mobile menu start -->
            <div class="mobile-navigation">
                <!-- mobile menu navigation start -->
                <nav class="off-canvas-nav">
                    
                    <ul class="mobile-menu main-mobile-menu">
                        <li class="menu-item-has-children">
                            <a href="<?php echo $linkHome; ?>">Trang Chủ</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Tin Tức</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Về Chúng Tôi</a>
                        </li>
                        <li>
                            <a href="#">Liên Hệ</a>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu navigation end -->
            </div>
            <div class="login-block-mobile mb--10">
                <?php
                    if($logged == true){
                        echo '<span>Xin chào: <b>'.$infoUser['fullname'].'</b></span>';
                    }
                    else{
                                       
                        echo ' <a href="'.$linkLogin.'" class="login font-weight-bold">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span class="pl--5">Đăng nhập</span>
                                </a>
                                <a href="'.$linkRegister.'" class="register font-weight-bold">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Đăng ký</span>
                                </a>';
                        }
                ?>
                   
                </div>
            <!-- mobile menu end -->
            <nav class="off-canvas-nav">
                <ul class="mobile-menu menu-block-2">
                    <?php
                        if($logged == true){
                            $linklogout = Url::createLink('site', 'index', 'logout', null, 'home/logout');
                            $myAcount = '<li class="menu-item-has-children">
                                            <span class="menu-expand"><i class="fas fa-chevron-down"></i></span>
                                            <a href="#">My Account <i class="fas fa-angle-down"></i></a>
                                            <ul class="sub-menu" style="display: none;">
                                                <li><a href="'.$linklogout.'">Logout</a></li>
                                            </ul>
                                        </li>';
                            if($group_acp == 1){
                                $linkViewACP = Url::createLink('admin', 'index', 'index', null, 'admin/index');
                                $viewACP =  '<li>
                                                <a href="'.$linkViewACP.'" target="_blank">View Bookstore Administration</a>
                                            </li>';
                                echo  $viewACP . $myAcount;
                            }
                            else{
                                echo $myAcount;
                            }
                        }
                    ?>

                    <li class="menu-item-has-children">
                        <a href="#">Call Now</a>
                    </li>
                </ul>
            </nav>
            <div class="off-canvas-bottom">
                <div class="contact-list mb--10">
                    <a href="" class="sin-contact"><i class="fas fa-mobile-alt"></i>(12345) 78790220</a>
                    <a href="" class="sin-contact"><i class="fas fa-envelope"></i>examle@handart.com</a>
                </div>
                <div class="off-canvas-social">
                    <a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="single-icon"><i class="fas fa-rss"></i></a>
                    <a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="single-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </aside>
    <!--Off Canvas Navigation End-->
</div>