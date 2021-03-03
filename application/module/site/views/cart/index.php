<?php
    $linkCheckOut = Url::createLink('site', 'cart', 'checkOut', null, 'check-out');
?>
<?php       
    include_once TEMPLATE_PATH . $this->arrParams['module'].'/main/html/breadcrumb.php';
?>
<!-- Cart Page Start -->
<main class="cart-page-main-block inner-page-sec-padding-bottom">
    <div class="cart_area cart-area-padding  ">
        <div class="container">
            <div class="page-section-title">
                <h1>Giỏ Hàng</h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="#" class="">
                        <!-- Cart Table -->
                        <div class="cart-table table-responsive mb--40">
						<?php
							if(!empty($this->listItemsInCart)){
						?>
                            <table class="table">
                                <!-- Head Row -->
                                <thead>
                                    <tr>
                                        <th class="pro-remove"></th>
                                        <th class="pro-thumbnail">Hình Ảnh</th>
                                        <th class="pro-title">Tên Sách</th>
                                        <th class="pro-price">Giá</th>
                                        <th class="pro-quantity">Số Lượng</th>
                                        <th class="pro-subtotal">Tổng Giá</th>
                                    </tr>
                                </thead>
                                <tbody>

						<?php
							
								foreach($this->listItemsInCart as $item){
									$id = $item['book_id'];
									$name = $item['name'];
									$image = Helper::createImage('book', $item['image'], ['title' => $name]);
									$price = $item['price'];
									$saleOff = $item['sale_off'];
									$quantity = $item['quantity'];
									$totalPrice = $item['total_price'];
									$linkViewDetail = Url::createLink('site', 'book', 'detail', null, 'product/'.$nameUnsigned.'-'.$id);
						?>
                                    <!-- Product Row -->
                                    <tr class="book-<?php echo $id; ?>">
                                        <td class="pro-remove">
											<a data-id="<?php echo $id?>" href="#" class="remove-item-in-cart">
												<i class="far fa-trash-alt"></i>
											</a>
                                        </td>
                                        <td class="pro-thumbnail">
											<a href="<?php echo $linkViewDetail; ?>">
												<?php echo $image; ?>
											</a>
										</td>
                                        <td class="pro-title">
											<a href="<?php echo $linkViewDetail; ?>" title="<?php echo $name; ?>">
												<?php echo Helper::shortenText($name, 8); ?>
											</a>
										</td>
                                        <td class="pro-price"><span><?php echo number_format($price*((100-$saleOff)/100),0, '', '.') . 'đ'; ?></span></td>
                                        <td class="pro-quantity">
                                            <div class="pro-qty">
                                                <div class="count-input-block">
                                                    <input type="number" class="form-control text-center" value="<?php echo $quantity; ?>">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="pro-subtotal"><span><?php echo number_format($totalPrice,0, '', '.') . 'đ'; ?></span></td>
                                    </tr>
						<?php
								}
						
						?>
                                    <tr>
                                        <td colspan="6" class="actions">
                                            <div class="total-price-order text-right">
                                                <h5>
													TỔNG CỘNG: 
													<?php
														$total = Session::get('totalPrice'); 
														if(!empty($total)) echo number_format($total, 0, '', '.') . 'đ';
													?>
												</h5>
                                            </div>
                                        </td>
                                    <tr>
                                        <td colspan="6" class="actions">
                                            <!-- <div class="coupon-block">
														<div class="coupon-text">
															<label for="coupon_code">Coupon:</label>
															<input type="text" name="coupon_code" class="input-text"
																id="coupon_code" value="" placeholder="Coupon code">
														</div>
														<div class="coupon-btn">
															<input type="submit" class="btn btn-outlined"
																name="apply_coupon" value="Apply coupon">
														</div>
													</div> -->
                                            <div class="update-block text-right">
                                                <!-- <input type="submit" class="btn btn-outlined" name="update_cart"
															value="Update cart"> -->
                                                <div class="cart-summary">
                                                    <div class="cart-summary-button">
                                                        <a href="<?php echo $linkCheckOut; ?>" class="checkout-btn c-btn btn--primary">
                                                            Checkout
                                                        </a>
                                                        <!-- <button class="update-btn c-btn btn-outlined">Update
                                                            Cart</button> -->
                                                    </div>
                                                </div>
                                                <input type="hidden" id="_wpnonce" name="_wpnonce"
                                                    value="05741b501f"><input type="hidden" name="_wp_http_referer"
                                                    value="/petmark/cart/">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
						<?php
							}
							else{
								echo '<h3 class="text-center text-dark">Chưa có sản phẩm nào... :((</h3>';
							}
						?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>