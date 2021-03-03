<?php

    if(!empty($this->infoItem)){
        $id = $this->infoItem['id'];
        $image = Helper::createImage('book', $this->infoItem['image'], ['width' => 334, 'height' => 334]);
        $name = $this->infoItem['name'];
        $categoryName = 'None';
        if($this->infoItem['category_status'] == 1){
            $categoryName = $this->infoItem['category_name'];
        }
        $saleOff = $this->infoItem['sale_off'];
        $price = $this->infoItem['price'];
        if($this->infoItem['status'] == 1) $status = 'Còn Hàng';
        else $status = 'Hết Hàng';
        $description =  $this->infoItem['description'];
    }
?>
<?php       
    include_once TEMPLATE_PATH . $this->arrParams['module'].'/main/html/breadcrumb.php';
?>
<main class="inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row  mb--30">
            <!-- Phần image -->
            <div class="col-lg-5 mb--30">
                <?php echo $image; ?> 
            </div>
            <div class="col-lg-7">
                <div class="product-details-info pl-lg--30 ">
                    <h3 class="product-title"><?php echo $name; ?></h3>
                    <ul class="list-unstyled">
                        <li>Thể loại: <span class="list-value"><?php echo ucwords($categoryName); ?></span></li>
                        <li>Trạng thái: <span class="list-value"><?php echo $status; ?></span></li>
                    </ul>
                    <div class="price-block">
                        <?php
                            if($saleOff > 0){
                                echo '<span class="price-new">'.number_format($price*((100-$saleOff)/100), 0, '', '.') . 'đ</span>
                                      <del class="price-old">'.number_format($price, 0, '', '.').'đ</del>
                                      <span class="price-discount">-'.$saleOff.'%</span>';
                            }
                            else{
                                echo '<span class="price-new">'.number_format($price, 0, '', '.').'đ</span>';
                            }
                        ?>
                    </div>
                    <!-- <div class="rating-widget">
                        <div class="rating-block">
                            <span class="fas fa-star star_on"></span>
                            <span class="fas fa-star star_on"></span>
                            <span class="fas fa-star star_on"></span>
                            <span class="fas fa-star star_on"></span>
                            <span class="fas fa-star "></span>
                        </div>
                        <div class="review-widget">
                            <a href="">(1 Reviews)</a> <span>|</span>
                            <a href="">Write a review</a>
                        </div>
                    </div> -->
                    <article class="product-details-article">
                        <h4 class="sr-only">Product Summery</h4>
                        <p><?php echo Helper::shortenText($description, 28); ?></p>
                    </article>
                    <div class="add-to-cart-row">
                        <!-- <div class="count-input-block">
                            <span class="widget-label">Số lượng</span>
                            <input type="number" class="form-control text-center" value="1">
                        </div> -->
                        <div class="add-cart-btn">
                            <a data-id="<?php echo $id; ?>" data-price="<?php echo round($price*((100-$saleOff)/100));?>" href="" class="btn btn-outlined--primary addToCart"><span class="plus-icon">+</span>Giỏ Hàng</a>
                        </div>
                    </div>
                    <!-- <div class="compare-wishlist-row">
                        <a href="wishlist.html" class="add-link"><i class="fas fa-heart"></i>Add to Wish
                            List</a>
                        <a href="compare.html" class="add-link"><i class="fas fa-random"></i>Add to Compare</a>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="sb-custom-tab review-tab section-padding">
            <ul class="nav nav-tabs nav-style-2" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab1" data-toggle="tab" href="#tab-1" role="tab"
                        aria-controls="tab-1" aria-selected="true">
                        MÔ TẢ
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" id="tab2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2"
                        aria-selected="true">
                        ĐÁNH GIÁ
                    </a>
                </li> -->
            </ul>
            <div class="tab-content space-db--20" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab1">
                    <article class="review-article">
                        <h1 class="sr-only">Tab Article</h1>
                        <p><?php echo $description; ?></p>
                    </article>
                </div>
                <!-- <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab2">
                    <div class="review-wrapper">
                        <h2 class="title-lg mb--20">1 REVIEW FOR AUCTOR GRAVIDA ENIM</h2>
                        <div class="review-comment mb--20">
                            <div class="avatar">
                                <img src="image/icon/author-logo.png" alt="">
                            </div>
                            <div class="text">
                                <div class="rating-block mb--15">
                                    <span class="ion-android-star-outline star_on"></span>
                                    <span class="ion-android-star-outline star_on"></span>
                                    <span class="ion-android-star-outline star_on"></span>
                                    <span class="ion-android-star-outline"></span>
                                    <span class="ion-android-star-outline"></span>
                                </div>
                                <h6 class="author">ADMIN – <span class="font-weight-400">March 23, 2015</span>
                                </h6>
                                <p>Lorem et placerat vestibulum, metus nisi posuere nisl, in accumsan elit odio
                                    quis mi.</p>
                            </div>
                        </div>
                        <h2 class="title-lg mb--20 pt--15">ADD A REVIEW</h2>
                        <div class="rating-row pt-2">
                            <p class="d-block">Your Rating</p>
                            <span class="rating-widget-block">
                                <input type="radio" name="star" id="star1">
                                <label for="star1"></label>
                                <input type="radio" name="star" id="star2">
                                <label for="star2"></label>
                                <input type="radio" name="star" id="star3">
                                <label for="star3"></label>
                                <input type="radio" name="star" id="star4">
                                <label for="star4"></label>
                                <input type="radio" name="star" id="star5">
                                <label for="star5"></label>
                            </span>
                            <form action="./" class="mt--15 site-form ">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="message">Comment</label>
                                            <textarea name="message" id="message" cols="30" rows="10"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="name">Name *</label>
                                            <input type="text" id="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="text" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="website">Website</label>
                                            <input type="text" id="website" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="submit-btn">
                                            <a href="#" class="btn btn-black">Post Comment</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

                            
    <!--=================================
    Sách liên quan
    ===================================== -->

    <section class="pt--50">
        <div class="container">
            <div class="section-title section-title--bordered">
                <h2>SÁCH LIÊN QUAN</h2>
            </div>
            <div class="product-slider sb-slick-slider slider-border-single-row" data-slick-setting='{
                "autoplay": true,
                "autoplaySpeed": 8000,
                "slidesToShow": 4,
                "dots":true
            }' data-slick-responsive='[
                {"breakpoint":1200, "settings": {"slidesToShow": 4} },
                {"breakpoint":992, "settings": {"slidesToShow": 3} },
                {"breakpoint":768, "settings": {"slidesToShow": 2} },
                {"breakpoint":480, "settings": {"slidesToShow": 1} }
            ]'>
    <?php 
        if(!empty($this->listItemsRelate)){
            foreach($this->listItemsRelate as $item){
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
                            <h3><a href="<?php echo $linkViewDetail; ?>" title="<?php echo $name; ?>"><?php echo Helper::shortenText($name, 12); ?></a></h3>
                        </div>
                        <div class="product-card--body">
                            <div class="card-image">
                                <?php echo $image; ?>
                                <div class="hover-contents">
                                    <!-- <a href="product-details.html" class="hover-image">
                                        <img src="image/products/product-1.jpg" alt="">
                                    </a> -->
                                    <div class="hover-btns">
                                        <a data-id="<?php echo $id; ?>" data-price="<?php echo round($price*((100-$saleOff)/100));?>" href="" class="single-btn addToCart">
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
        </div>
    </section>
   
</main>