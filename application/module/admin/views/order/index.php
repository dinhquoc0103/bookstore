<?php
    
    $keywordSearch = Session::get('keyword');
    $filterStatusVal = (!in_array(Session::get('filter_status'), [null, 18]) ) ? Session::get('filter_status') : 18;
    $filterCategoryNameVal = (Session::get('filter_category_name') != null) ? Session::get('filter_category_name')  : 18;
    $sortByVal = (Session::get('sort_by') != null) ? Session::get('sort_by') : 'default';

    // Create select box
    $arrStatus = [
        '18' => 'Filter By Status',
        '0' => 'Chờ Xác Nhận',
        '1' => 'Xác Nhận',
        '2' => 'Đang Giao',
        '3' => 'Đã Giao',
    ];
    $selectBoxStatus = Helper::CreateSelectBox($arrStatus, 'filter_status', 'filter_status', 'form-control', $filterStatusVal);


   
   
    $arrSortBy = [
        'default' => 'Sort By', 
        'asc-name' => 'By Sort A-Z', 
        'desc-name' => 'By Sort Z-A',
        'asc-sort_order' => 'By Sort Order Tăng Dần',
        'desc-sort_order' => 'By Sort Order Giảm Dần',
        'asc-created' => 'By Date Created Tăng Dần',
        'desc-created' => 'By Date Created Giảm Dần',
        'asc-modified' => 'By Date Modified Tăng Dần',
        'desc-modified' => 'By Date Modified Giảm Dần',
        'asc-id' => 'By ID Tăng Dần',
        'desc-id' => 'By ID Giảm Dần',
    ];
    $selectSortBy = Helper::CreateSelectBox($arrSortBy, 'sort_by', 'sort_by', 'form-control', $sortByVal);
    
    // Đổ danh sách đơn hàng
    $rowOrderHtml = '';
    if(!empty($this->listItems)){
       
        foreach($this->listItems as $item){
            $id = $item['id'];
            $fullName = $item['fullname'];
            $phoneNumber = $item['phone_number'];
            $email = $item['email'];
            $address = $item['address'];
            $orderCode = $item['order_code'];
            $totalPriceOrder = $item['total_price'];

            $arrStatus = [
                '0' => 'Chờ Xác Nhận',
                '1' => 'Xác Nhận',
                '2' => 'Đang Giao',
                '3' => 'Đã Giao',
            ];
            $status = Helper::CreateSelectBox($arrStatus, '', '', 'order-status', $item['status'], $id);
            // if($item['status'] == 1) $status = 'Xác Nhận';
            // else if($item['status'] == 2) $status = 'Đã Giao';
            // else  $status = 'Chờ Xác Nhận';
                
            $dateCreated =  ($item['created'] != null) ? date('d/m/Y H:i:s', strtotime($item['created'])) : '';
            $dateModified =  ($item['modified'] != null) ? date('d/m/Y H:i:s', strtotime($item['modified'])) : '';

            $linkViewDetail = Url::createLink('admin', 'order', 'form', ['id' => $id], 'admin/order/orderDetail/id-'. $id);
            $rowOrderHtml .=   '<tr>
                                    <th scope="row">
                                        <input value="'.$id.'" class="checkbox" type="checkbox" name="checkBoxId[]">
                                    </th>
                                    <td class="text-left">
                                        
                                            <p>* '.$fullName.'</p>
                                            <p>* '.$phoneNumber.'</p>
                                            <p>* '.$email.'</p>
                                            <p>* '.$address.'</p>                                         
                                       
                                    </td>
                                    <td>'.$orderCode.'</td>
                                    <td>'.number_format($totalPriceOrder, 0, '', '.').'</td>
                                    <td>'.$status.'</td>
                                    <td>'.$dateCreated.'</td>
                                    <td class="modified-'.$id.'">'.$dateModified.'</td>
                                    <td>'.$id.'</td>
                                    <td>
                                        <a href="'.$linkViewDetail.'" >Xem Chi Tiết Đơn</a>
                                    </td>
                                </tr>';
        }
    }

    $strMessageSuccess = Helper::createAlert('alert alert-success', Session::get('message'));
    $strMessageError = Helper::createAlert('alert alert-danger', Session::get('messageError'));
    if(!isset($this->arrParams['form'])){
        Session::delete('message');
        Session::delete('messageError');
    }
     
    $linkClearKeyword = Url::createLink('admin', 'order', 'clearKeyword');

?>
<div class="page-body">
    <!-- Hover table card start -->
    <div class="card">
        <?php 
            include_once MODULE_PATH . $this->arrParams['module'] . DS .'views' . DS . 'toolbar-header.php';
        ?>
        <div class="card-block table-border-style">
            <form class="form-material" action="<?php echo ROOT_URL . 'admin/order/';?>" method="post" name="adminForm" id="adminForm">
                <div class="row">
                    <div class="form-group form-primary search-in-table col-lg-4">
                        <input type="text" name="keyword" id="keyword" class="form-control"
                            value="<?php echo $keywordSearch; ?>" placeholder="Search theo order_code hoặc email">
                        <span class="form-bar"></span>
                        <!-- <label class="float-label">
                                <i class="fa fa-search m-r-10"></i>
                                Search
                            </label> -->
                        <button type="submit"
                            class="btn waves-effect waves-light btn-inverse btn-square btn-search">Search</button>
                        <a href="<?php echo $linkClearKeyword; ?>"
                            class="btn waves-effect waves-light btn-inverse btn-square btn-clear">Clear</a>
                    </div>
                    <!-- Filter by status  -->
                    <div class="col-lg-4 select-box-filter">
                        <?php
                                    echo $selectBoxStatus;
                                ?>
                    </div>

                    <!-- Sort by  -->
                    <div class="col-lg-4 select-box-filter">
                        <?php
                                    echo $selectSortBy;
                                ?>
                    </div>
                </div>
                <?php 
                    echo $strMessageSuccess . $strMessageError;
                ?>

                <div class="table-responsive">
                    <!-- Table info  -->
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-info">
                                <th width="5%">
                                    <input id="checkall-toggle" type="checkbox" name="checkall-toggle">
                                </th>
                                <th width="20%">Info User</th>
                                <th width="10%">Order Code</th>
                                <th width="8%">Total Price</th>
                                <th width="15%">Status</th>
                                <th width="8%">Order Date</th>
                                <th width="8%">Modified</th>
                                <th width="5%">ID</th>
                                <th width="5%">Detail</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                echo $rowOrderHtml;
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="container-input-hidden">
                    <input type="hidden" name="qty_sort_order" value="0">
                    <!-- <input type="hidden" name="submit_filter_and_sort" value="0"> -->
                </div>
            </form>
            <div class="container-pagination">
                <?php 
                    echo $this->paginationHtml;
                ?>
            </div>
        </div>
    </div>
    <!-- Hover table card end -->
</div>