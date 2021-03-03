<?php
    $linkHome = Url::createLink('site', 'index', 'index', null, 'home');
    // $breadCrumb = '';
    $breadCrumb = '<li class="breadcrumb-item"><a href="'.$linkHome.'">Trang Chủ</a></li>';
    // $bookNameBread = '';
    if($this->arrParams['action'] == 'list'){
        if(isset($this->categoryName)){
            $breadCrumb .= '<li class="breadcrumb-item active">'.ucwords($this->categoryName).'</li>';
        }
    }
    else if($this->arrParams['action'] == 'detail'){
        $breadCrumb .= '<li class="breadcrumb-item active">'.ucwords($categoryName).'</li>
                        <li class="breadcrumb-item active">'.$name.'</li>';
    }
    else if($this->arrParams['action'] == 'login'){
        $breadCrumb .= '<li class="breadcrumb-item active">Đăng Nhập</li>';
    }
    else if($this->arrParams['action'] == 'register'){
        $breadCrumb .= '<li class="breadcrumb-item active">Đăng Ký</li>';
    }
    else if($this->arrParams['controller'] == 'cart' && $this->arrParams['action'] == 'index'){
        $breadCrumb .= '<li class="breadcrumb-item active">Giỏ Hàng</li>';
    }
    else if($this->arrParams['action'] == 'checkOut'){
        $breadCrumb .= '<li class="breadcrumb-item active">Thanh Toán</li>';
    }
?>
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    
                    <?php echo $breadCrumb; ?>
                </ol>
            </nav>
        </div>
    </div>
</section>