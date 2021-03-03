
<div class="shop-product-wrap with-pagination row space-db--30 shop-border grid-four">
<?php

  
    if(!empty($this->listItems)){
    foreach($this->listItems as $item){
        $name = $item['name'];
        $image = Helper::createImage('book', $item['image']);
        $price = $item['price'];
        $saleOff = $item['sale_off'];
?>
        <div class="col-lg-4 col-sm-6">
            <div class="product-card">
                <div class="product-grid-content">
                    <div class="product-header">
                        <h3><a href="product-details.html"><?php echo Helper::shortenText($name, 6); ?></a></h3>
                    </div>
                    <div class="product-card--body">
                        <div class="card-image">
                            <a href="product-details.html" class="hover-image">
                                <?php echo $image; ?>

                            </a>

                            <div class="hover-contents">
                                <!-- <a href="product-details.html" class="hover-image">
                                <?php //echo $image; ?>
                            </a> -->
                                <div class="hover-btns">
                                    <a href="cart.html" class="single-btn" title="Thêm vào giỏ hàng">
                                        <i class="fas fa-shopping-basket"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="price-block">
                            <span
                                class="price"><?php echo number_format($price*((100-$saleOff)/100), 0, '', '.') . 'đ'; ?></span>
                            <del class="price-old"><?php echo $price . 'đ'; ?></del>
                            <span class="price-discount"><?php echo $saleOff . '%'; ?></span>
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
