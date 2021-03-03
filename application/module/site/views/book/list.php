<?php
    $categoryId = isset($this->arrParams['category_id']) ? $this->arrParams['category_id'] : '1';
    $page = isset($this->arrParams['page']) ? $this->arrParams['page'] : '1';

    $sortBy = isset($arrParams['sort-by-list']) ? $arrParams['sort-by-list'] : 'default';
    $arrSortBy = [
        'default' => 'Sắp xếp theo', 
        'asc-name_'.$categoryId.'_'.$page => 'Name từ (A-Z)', 
        'desc-name_'.$categoryId.'_'.$page => 'Name từ (Z-A)',
    ];
    $selectBoxSortBy = Helper::CreateSelectBox($arrSortBy, 'sort-by-list', 'sort-by-list', 'form-control  sort-select mr-0 wide', $sortBy);

    
?>
<?php       
    include_once TEMPLATE_PATH . $this->arrParams['module'].'/main/html/breadcrumb.php';
?>
<main class="inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 order-lg-2">
                <div class="shop-toolbar with-sidebar mb--30">
                    <div class="row align-items-center justify-content-between">
                        <!-- col-lg-7 col-md-2 col-sm-6 -->
                        <div class="">
                            <!-- Product View Mode -->
                            <div class="product-view-mode">
                                <!-- <a href="#" class="sorting-btn" data-target="grid"><i class="fas fa-th"></i></a> -->
                                <!-- <a href="#" class="sorting-btn active" data-target="grid-four">
                                    <span class="grid-four-icon">
                                        <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                                    </span>
                                </a> -->

                            </div>
                        </div>
                        <!-- col-xl-5 col-lg-2 col-md-4 col-sm-6 mt--10-->
                        <div class="  mt-md--0 ">
                            <div class="sorting-selection">
                                <?php echo $selectBoxSortBy; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="list-product">
                    <div class="shop-product-wrap with-pagination row space-db--30 shop-border grid-four">

                        <?php
            if(!empty($this->listItems)){
                foreach($this->listItems as $item){
                    $id = $item['id'];
                    $name = $item['name'];
                    $image = Helper::createImage('book', $item['image'], ['width' => 184, 'height' => 184]);
                    $price = $item['price'];
                    $saleOff = $item['sale_off'];
                    $nameUnsigned = Helper::unsignedStr($name);
                    $linkViewDetail = Url::createLink('site', 'book', 'detail', null, 'product/'.$nameUnsigned.'-'.$id);
                    // $linkAddToCart = Url::createLink('site', 'index', 'cart', null, 'list/addToCart/'.$id.'/'.($price*((100-$saleOff)/100)));
        ?>
                        <div class="col-lg-4 col-sm-6">
                            <div class="product-card">
                                <div class="product-grid-content">
                                    <div class="product-header">
                                        <h3><a href="<?php echo $linkViewDetail; ?>"
                                                title="<?php echo $name; ?>"><?php echo Helper::shortenText($name, 6); ?></a>
                                        </h3>
                                    </div>
                                    <div class="product-card--body">
                                        <div class="card-image">
                                            <?php echo $image; ?>
                                            <div class="hover-contents">
                                                <!-- <a href="product-details.html" class="hover-image">
                                                <?php //echo $image; ?>
                                            </a> -->
                                                <div class="hover-btns">
                                                    <a data-id="<?php echo $id; ?>"
                                                        data-price="<?php echo round($price*((100-$saleOff)/100));?>"
                                                        class="single-btn addToCart" title="Thêm vào giỏ hàng">
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
                        </div>
                        <?php
               }
            }
        ?>
                    </div>

                    <!-- Pagination Block -->
                    <div class="row pt--30">
                        <div class="col-md-12">
                           
                                <?php
                                echo $this->paginationHtml;
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3  mt--40 mt-lg--0">
                <div class="inner-page-sidebar">
                    <!-- Accordion -->
                    <div class="single-block">
                        <h3 class="sidebar-title">Thể Loại Sách</h3>
                        <ul class="sidebar-menu--shop">
                            <?php
                                echo $categoryHtml;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>