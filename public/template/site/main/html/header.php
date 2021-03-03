<?php
    $user = Session::get('user');
    $infoUser = isset($user['info_user']) ? $user['info_user'] : '';
    $logged = isset($user['login']) ? $user['login'] : '';
    $group_acp = isset($infoUser['group_acp']) ? $infoUser['group_acp'] : '';
    // $categoryId = isset($arrParams['category_id']) ? $arrParams['category_id'] : '';

    
    $model = new Model();
    $sql = "SELECT id, name FROM ".TB_CATEGORY."WHERE status = 1 ORDER BY id DESC";
    $arrCategory = $model->select($sql);
    $categoryHtml = '';
    foreach($arrCategory as $item){
        $id = $item['id'];
        $name = $item['name'];
        $nameUnsigned = Helper::unsignedStr($name);
        $linkView = Url::createLink('site', 'book', 'index', ['category_id' => $id], 'list/'.$nameUnsigned.'-'.$id);
        $categoryHtml .= '<li class="cat-item has-children mega-menu">
                                <a href="'.$linkView.'">'.$name.'</a>
                          </li>';
    }
    $linkHome = Url::createLink('site', 'index', 'index', null, 'home');
    $linkViewCart = Url::createLink('site', 'cart', 'index', null, 'cart');
    $linkLogin = Url::createLink('site', 'index', 'login', null, 'login');
    $linkRegister = Url::createLink('site', 'index', 'register', null, 'register');
    $linkCheckOut = Url::createLink('site', 'cart', 'checkOut', null, 'check-out');

    
    // Đổ dữ liệu cho giỏ hàng ở header 
    $cart = Session::get('cart');

    $itemsInCartHeader = '';
    // if(!empty($cart['quantity']) && !empty($cart['price'])){

    //     $strId = implode(',', array_keys($cart['quantity']));
    //     $sql = "SELECT id, name, image, price, sale_off FROM ".TB_BOOK."WHERE id IN ($strId)";
    //     $arrBook = $model->select($sql);
    //     foreach($arrBook as $key => $book){
    //         $arrBook[$key]['quantity'] = $cart['quantity'][$book['id']];
    //         $arrBook[$key]['total_price'] = $cart['price'][$book['id']];
    //     }
    //     foreach($arrBook as $item){
    //         $id = $item['id'];
	// 		$name = $item['name'];
	// 		$image = Helper::createImage('book', $item['image'], ['title' => $name]);
	// 		$price = $item['price'];
	// 		$saleOff = $item['sale_off'];
	// 		$quantity = $item['quantity'];
	// 		$linkViewDetail = Url::createLink('site', 'book', 'detail', null, 'product/'.$nameUnsigned.'-'.$id);
    //         $itemsInCartHeader .= '<div class=" single-cart-block book-'.$id.'">
    //                                 <div class="cart-product">
    //                                     <a href="product-details.html" class="image">
    //                                         '.$image.'
    //                                     </a>
    //                                     <div class="content">
    //                                         <h3 class="title">
    //                                             <a href="product-details.html">Kodak PIXPRO
    //                                                 '.Helper::shortenText($name, 8).'
    //                                             </a>
    //                                         </h3>
    //                                         <p class="price"><span class="qty">
    //                                             '.$quantity.' ×</span>'.number_format($price*((100-$saleOff)/100)).'đ
    //                                         </p>
    //                                         <button class="cross-btn"><i class="fas fa-times"></i></button>
    //                                     </div>
    //                                 </div>
    //                             </div>';
    //     }
                           
    // }
    // else{
    //     Session::delete('cart');
    //     Session::delete('totalPrice');
    //     Session::delete('totalProduct');
    // }
    $keyword = isset($this->arrParams['keyword']) ? $this->arrParams['keyword'] : '';
            
?>
<div class="site-header header-4  d-none d-lg-block">
    <div class="header-top header-top--style-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 flex-lg-right">
                    <ul class="header-top-list">
                        <?php
                            if($logged == true){
                                $linklogout = Url::createLink('site', 'index', 'logout', null, 'home/logout');
                                $myAcount = '<li class="dropdown-trigger language-dropdown"><a href=""><i class="icons-left fas fa-user"></i>
                                                My Account</a><i class="fas fa-chevron-down dropdown-arrow"></i>
                                                <ul class="dropdown-box">
                                                    <li> <a href="'.$linklogout.'">Đăng Xuất</a></li>
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
                        
                        <li>
                            <a href=""><i class="icons-left fas fa-phone"></i>Gọi Ngay</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle pt--10 pb--10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <a href="<?php echo $linkHome; ?>" class="site-brand">
                        <img src="<?php echo $imgSrc; ?>/image/logo.png" alt="">
                    </a>
                </div>
                <div class="col-lg-5">
                   <form action="" name="form-search" id="form-search">
                        <div class="header-search-block">
                            <input type="text" class="keyword" value="<?php echo $keyword; ?>" name="keyword" placeholder="Nhập từ khóa">
                            <button class="btn-search">Tìm Kiếm</button>
                        </div>
                   </form>
                </div>
                <div class="col-lg-4">
                    <div class="main-navigation flex-lg-right">
                        <div class="cart-widget">
                            <div class="login-block">
                                <?php
                                    if($logged == true){
                                        echo '<span>Xin chào: <b>'.$infoUser['fullname'].'</b></span>';
                                    }
                                    else{
                                       
                                        echo ' <a href="'.$linkLogin.'" class="font-weight-bold">Đăng Nhập</a> 
                                                <br>
                                                <span>hoặc</span>
                                                <a href="'.$linkRegister.'">Đăng Ký</a>';
                                    }
                                ?>
                            </div>
                            <div class="cart-block">
                                <div class="cart-total">
                                    <span class="text-number">
                                        <?php
                                      
                                            $totalProduct = !empty(Session::get('totalProduct')) ? Session::get('totalProduct') : 0;
                                            echo $totalProduct;
                                        ?>
                                    </span>
                                    <span class="text-item">
                                        Giỏ hàng
                                    </span>
                                    <span class="price text-price">
                                        <?php
                                            $totalPrice = !empty(Session::get('totalPrice')) ? Session::get('totalPrice') : 0;
                                            echo number_format($totalPrice, 0, '', '.') . 'đ';
                                        ?>
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </div>
                                <div class="cart-dropdown-block ">
                                    <div class="cart-table">
                                        <?php 
                                            echo $itemsInCartHeader;
                                        ?>
                                    </div>
                                    
                                    <div class=" single-cart-block ">
                                        <div class="btn-block">
                                            <a href="<?php echo $linkViewCart; ?>" class="btn">
                                                Giỏ Hàng 
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                            <a href="<?php echo $linkCheckOut; ?>" class="btn btn--primary">
                                                Thanh Toán <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <nav class="category-nav  primary-nav">
                        <div>
                            <a href="javascript:void(0)" class="category-trigger">
                                <i class="fa fa-bars"></i>Danh Mục Loại Sách
                            </a>
                            <ul class="category-menu">
                                <?php
                                    echo $categoryHtml;
                                ?>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header-phone ">
                        <div class="icon">
                            <i class="fas fa-headphones-alt"></i>
                        </div>
                        <div class="text">
                            <p>Hỗ Trợ 24/7</p>
                            <p class="font-weight-bold number">0123.456.789</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-navigation flex-lg-right">
                        <ul class="main-menu menu-right li-last-0">
                            <!-- Home -->
                            <li class="menu-item">
                                <a href="<?php echo $linkHome; ?>">Trang Chủ</a>
                            </li>                      
                            <!-- News -->
                            <li class="menu-item ">
                                <a href="javascript:void(0)">Tin Tức</a>
                            </li>
                            <!-- About US -->
                            <li class="menu-item ">
                                <a href="javascript:void(0)">Về Chúng Tôi</a>   
                            </li>
                            <!-- Contact -->
                            <li class="menu-item">
                                <a href="#">Liên Hệ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>