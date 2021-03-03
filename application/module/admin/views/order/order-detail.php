<?php
    
   
//     <th scope="row">
//     <input value="'.$id.'" class="checkbox" type="checkbox" name="checkBoxId[]">
// </th>
    // Đổ danh sách book
    $rowBookHtml = '';
    if(!empty($this->listItemsInOrderDetail)){
        foreach($this->listItemsInOrderDetail as $item){
            $id = $item['id'];
            $name = $item['name'];
            $image = Helper::createImage('book', $item['image'], ['width' => 100, 'height' => 100]);
            $price = $item['price'];
            $sale_off = $item['sale_off'];      
            $quantity = $item['quantity'];      
            $total = $item['total_price'];      
            $rowBookHtml .=   '<tr>
                                   
                                    <td title="'.$name.'">'.Helper::shortenText($name, 8).'</td>
                                    <td>'.$image.'</td>
                                    <td>'.number_format($price*((100-$sale_off)/100), 0, '', '.').'</td>
                                    <td>'.$quantity.'</td>
                                    <td>'.number_format($total, 0, '', '.').'</td>
                                </tr>';
        }
    }

    // $strMessageSuccess = Helper::createAlert('alert alert-success', Session::get('message'));
    // $strMessageError = Helper::createAlert('alert alert-danger', Session::get('messageError'));
    // if(!isset($this->arrParams['form'])){
    //     Session::delete('message');
    //     Session::delete('messageError');
    // }
     

?>
<div class="page-body">
    <!-- Hover table card start -->
    <div class="card">
        <?php 
            // include_once MODULE_PATH . $this->arrParams['module'] . DS .'views' . DS . 'toolbar-header.php';
        ?>
        <div class="card-block table-border-style">
            <form class="form-material" action="<?php echo ROOT_URL . 'admin/book/';?>" method="post" name="adminForm" id="adminForm">
                
                <?php 
                    // echo $strMessageSuccess . $strMessageError;
                ?>

                <div class="table-responsive">
                    <!-- Table info  -->
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-info">
                                <!-- <th width="5%">
                                    <input id="checkall-toggle" type="checkbox" name="checkall-toggle">
                                </th> -->
                                <th width="10%">Name</th>
                                <th width="15%">Image</th>
                                <th width="15%">Price</th>
                                <th width="10%">Quantity</th>
                                <th width="3%">Total Price</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                echo $rowBookHtml;
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="container-input-hidden">
                    <input type="hidden" name="qty_sort_order" value="0">
                    <!-- <input type="hidden" name="submit_filter_and_sort" value="0"> -->
                </div>
            </form>

        </div>
    </div>
    <!-- Hover table card end -->
</div>