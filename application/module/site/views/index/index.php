 <!--=================================
        Slider
        ===================================== -->
 <section class="hero-area hero-slider-3">
     <div class="sb-slick-slider" data-slick-setting='{
                                                        "autoplay": true,
                                                        "autoplaySpeed": 8000,
                                                        "slidesToShow": 1,
                                                        "dots":true
                                                        }'>
         <div class="single-slide bg-image  bg-overlay--dark" data-bg="http://res.cloudinary.com/bookonline/image/upload/v1593329586/yw3gcjujkwstxy5olbsi.jpg">
             <div class="container">
                 <div class="home-content text-center">
                     <div class="row justify-content-end">
                         <div class="col-lg-6">
                             <h1>Mùa Covid Ở Nhà Đọc Sách</h1>
                             <h2>Sách giải trí mùa rảnh rỗi
                                 <br>
                             </h2>
                             <a href="" class="btn btn--yellow">
                                 Mua Ngay
                             </a>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="single-slide bg-image  bg-overlay--dark" data-bg="http://res.cloudinary.com/bookonline/image/upload/v1593329373/plzhdfnl8rmgrjiiopma.jpg">
             <div class="container">
                 <div class="home-content pl--30">
                     <div class="row">
                         <div class="col-lg-6">
                             <h1>Hãy Sống Tử Tế Với Bản Thân</h1>
                             <h2>Đọc ngay những quyển sách
                                 <br>này
                             </h2>
                             <a href="shop-grid.html" class="btn btn--yellow">
                                Mua Ngay
                             </a>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>


 <!--=================================
        4 mục quảng cáo
===================================== -->
 <section class="mb--30">
     <div class="container">
         <div class="row">
             <div class="col-xl-3 col-md-6 mt--30">
                 <div class="feature-box h-100">
                     <div class="icon">
                         <i class="fas fa-shipping-fast"></i>
                     </div>
                     <div class="text">
                         <h5>Miễn Phí Vận Chuyển</h5>
                         <p>Đơn Hàng > 500.000đ</p>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 col-md-6 mt--30">
                 <div class="feature-box h-100">
                     <div class="icon">
                         <i class="fas fa-redo-alt"></i>
                     </div>
                     <div class="text">
                         <h5>Đổi Trả Trong 8 Ngày</h5>
                         <p>Hoàn Tiền 100%</p>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 col-md-6 mt--30">
                 <div class="feature-box h-100">
                     <div class="icon">
                         <i class="fas fa-piggy-bank"></i>
                     </div>
                     <div class="text">
                         <h5>Thanh Toán</h5>
                         <p>Khi Nhận Hàng</p>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 col-md-6 mt--30">
                 <div class="feature-box h-100">
                     <div class="icon">
                         <i class="fas fa-life-ring"></i>
                     </div>
                     <div class="text">
                         <h5>Hỗ Trợ - Tư Vấn</h5>
                         <p>Gọi Ngay : 0123.4567.89</p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>

 <!--=================================
        Tab sản phẩm
        ===================================== -->
 <section class="section-padding">
     <h2 class="sr-only">Home Tab Slider Section</h2>
     <div class="container">
         <div class="sb-custom-tab">
             <ul class="nav nav-tabs" id="myTab" role="tablist">
                 <li class="nav-item">
                     <a class="nav-link active" id="shop-tab" data-toggle="tab" href="#shop" role="tab"
                         aria-controls="shop" aria-selected="true">
                         Nổi Bật
                     </a>
                     <span class="arrow-icon"></span>
                 </li>
             </ul>
             <div class="tab-content" id="myTabContent">
                 <div class="tab-pane show active" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                     <div class="product-slider multiple-row  slider-border-multiple-row  sb-slick-slider"
                         data-slick-setting='{
                            "autoplay": true,
                            "autoplaySpeed": 8000,
                            "slidesToShow": 5,
                            "rows":2,
                            "dots":true
                        }' data-slick-responsive='[
                            {"breakpoint":1200, "settings": {"slidesToShow": 3} },
                            {"breakpoint":768, "settings": {"slidesToShow": 2} },
                            {"breakpoint":480, "settings": {"slidesToShow": 1} },
                            {"breakpoint":320, "settings": {"slidesToShow": 1} }
                        ]'>
                         <?php
                if(!empty($this->listItemsFeatured)){
                    foreach($this->listItemsFeatured as $item){
                        $id = $item['id'];
                        $name = $item['name'];
                        $image = Helper::createImage('book', $item['image']);
                        $price = $item['price'];
                        $saleOff = $item['sale_off'];
                        $nameUnsigned = Helper::unsignedStr($name);
                        $linkViewDetail = Url::createLink('site', 'book', 'detail', null, 'product/'.$nameUnsigned.'-'.$id);
            ?>
                         <div class="single-slide">
                             <div class="product-card">
                                 <div class="product-header">
                                     <h3>
                                         <a href="<?php echo $linkViewDetail; ?>" title="<?php echo $name; ?>">
                                             <?php echo Helper::shortenText($name, 6); ?>
                                         </a>
                                     </h3>
                                 </div>
                                 <div class="product-card--body">
                                     <div class="card-image">
                                         <?php echo $image; ?>
                                         <div class="hover-contents">
                                             <!-- <a href="product-details.html" class="hover-image">
                                                 <img src="image/products/product-1.jpg" alt="">
                                             </a> -->
                                             <div class="hover-btns">
                                                 <a data-id="<?php echo $id; ?>"
                                                     data-price="<?php echo round($price*((100-$saleOff)/100));?>"
                                                     href="" class="single-btn addToCart">
                                                     <i class="fas fa-shopping-basket"></i>
                                                 </a>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="price-block">
                                         <?php
                                            if($saleOff > 0){
                                                echo ' <span class="price">'.number_format($price*((100-$saleOff)/100), 0, '', '.') . 'đ</span>
                                                    <del class="price-old">'.number_format($price, 0, '', '.')  . 'đ</del>
                                                    <span class="price-discount">'.$saleOff . '%</span>';
                                            }
                                            else{
                                                echo ' <span class="price">'.number_format($price, 0, '', '.') . 'đ</span>';
                                            }
                                        ?>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <?php
                  }
                }
            ?>
                     </div>
                     <!-- sds  -->

                 </div>
             </div>
         </div>
 </section>

 <!--=================================
        Sách giảm trên 50%
        ===================================== -->
 <section class="section-margin bg-image section-padding-top section-padding"
     data-bg="image/bg-images/best-seller-bg.jpg">
     <div class="container">
         <div class="section-title section-title--bordered mb-0">
             <h2>Deal Hot Lên Tới 50%</h2>
         </div>
         <div class="best-seller-block">
             <div class="row align-items-center">
                 <div class="col-lg-5 col-md-6">
                     <div class="author-image">
                         <img src="http://res.cloudinary.com/bookonline/image/upload/v1593437525/zwrffjhx7tfshpeblhgb.jpg"
                             alt="">
                     </div>
                 </div>
                 <div class="col-lg-7 col-md-6">
                     <div class="sb-slick-slider product-slider product-list-slider multiple-row slider-border-multiple-row"
                         data-slick-setting='{
                                    "autoplay": false,
                                    "autoplaySpeed": 8000,
                                    "slidesToShow":2,
                                    "rows":2,
                                    "dots":true
                                }' data-slick-responsive='[
                                    {"breakpoint":1200, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":992, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":768, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                    {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                ]'>
                         <?php
                if(!empty($this->listItemsDiscountOver50)){
                    foreach($this->listItemsDiscountOver50 as $item){
                        $id = $item['id'];
                        $name = $item['name'];
                        $image = Helper::createImage('book', $item['image'], ['width' => 92, 'height' => 92]);
                        $price = $item['price'];
                        $saleOff = $item['sale_off'];
                        $nameUnsigned = Helper::unsignedStr($name);
                        $linkViewDetail = Url::createLink('site', 'book', 'detail', null, 'product/'.$nameUnsigned.'-'.$id);
            ?>
                         <div class="single-slide">
                             <div class="product-card card-style-list">
                                 <div class="card-image">
                                     <?php echo $image; ?>
                                 </div>
                                 <div class="product-card--body">
                                     <div class="product-header">
                                         <h3>
                                             <a href="<?php echo $linkViewDetail; ?>" title="<?php echo $name; ?>">
                                                 <?php echo Helper::shortenText($name, 6); ?>
                                             </a>
                                         </h3>
                                     </div>
                                     <div class="price-block">
                                         <?php
                                            if($saleOff > 0){
                                                echo ' <span class="price">'.number_format($price*((100-$saleOff)/100), 0, '', '.') . 'đ</span>
                                                    <del class="price-old">'.number_format($price, 0, '', '.')  . 'đ</del>
                                                    <span class="price-discount">'.$saleOff . '%</span>';
                                            }
                                            else{
                                                echo ' <span class="price">'.number_format($price, 0, '', '.') . 'đ</span>';
                                            }
                                        ?>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <?php
                    }
                }
            ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!--=================================
        Sách mới về
        ===================================== -->
 <section class="section-margin">
     <div class="container">
         <div class="section-title section-title--bordered">
             <h2>MỚI VỀ</h2>
         </div>
         <div class="product-list-slider slider-two-column product-slider multiple-row sb-slick-slider slider-border-multiple-row"
             data-slick-setting='{
                                            "autoplay": true,
                                            "autoplaySpeed": 8000,
                                            "slidesToShow":3,
                                            "rows":2,
                                            "dots":true
                                        }' data-slick-responsive='[
                                            {"breakpoint":1200, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":992, "settings": {"slidesToShow": 2} },
                                            {"breakpoint":768, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":575, "settings": {"slidesToShow": 1} },
                                            {"breakpoint":490, "settings": {"slidesToShow": 1} }
                                        ]'>
             <?php
    if(!empty($this->listItemsNewArrival)){
        foreach($this->listItemsNewArrival as $item){
            $id = $item['id'];
            $name = $item['name'];
            $image = Helper::createImage('book', $item['image']);
            $price = $item['price'];
            $saleOff = $item['sale_off'];
            $nameUnsigned = Helper::unsignedStr($name);
            $linkViewDetail = Url::createLink('site', 'book', 'detail', null, 'product/'.$nameUnsigned.'-'.$id);
?>
             <div class="single-slide">
                 <div class="product-card card-style-list">
                     <div class="card-image">
                         <?php echo $image; ?>
                     </div>
                     <div class="product-card--body">
                         <div class="product-header">
                             <h3>
                                 <a href="<?php echo $linkViewDetail; ?>" title="<?php echo $name; ?>">
                                     <?php echo Helper::shortenText($name, 6); ?>
                                 </a>
                             </h3>
                         </div>
                         <div class="price-block">
                             <?php
                                    if($saleOff > 0){
                                        echo ' <span class="price">'.number_format($price*((100-$saleOff)/100), 0, '', '.') . 'đ</span>
                                            <del class="price-old">'.number_format($price, 0, '', '.')  . 'đ</del>
                                            <span class="price-discount">'.$saleOff . '%</span>';
                                    }
                                    else{
                                        echo ' <span class="price">'.number_format($price, 0, '', '.') . 'đ</span>';
                                    }
                                ?>
                         </div>
                     </div>
                 </div>
             </div>
             <?php
        }
    }
?>
         </div>
     </div>
 </section>