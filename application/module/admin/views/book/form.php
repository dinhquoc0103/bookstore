<?php

    // Array value khi submit nếu đúng thì giữ lại không thì rỗng
    $arrValueForm = [
        'name' => '',
        'price' => '',
        'sale_off' => '',
        'status' => '18',
        'special' => '18',
        'category_id' => '18',
        'sort_order' => '',
        'image' => '',
        'description' => '',
    ];


    if(!empty($this->arrParams['form'])){
        foreach($this->arrParams['form'] as $key => $value){
            $arrValueForm[$key] = $value;   
        }
    }

    if(!empty($this->arrParams['info_item'])){
        foreach($this->arrParams['info_item'] as $key => $value){
            $arrValueForm[$key] = $value;
        }
    }


    // Tạo input
    $inputName = Helper::createInput('text', 'form[name]', 'name', 'form-control', $arrValueForm['name']);
    $inputPrice = Helper::createInput('text', 'form[price]', 'price', 'form-control', $arrValueForm['price']);
    $inputSaleOff = Helper::createInput('text', 'form[sale_off]', 'sale_off', 'form-control', $arrValueForm['sale_off']);
    $inputSortOrder = Helper::createInput('text', 'form[sort_order]', 'sort_order', 'form-control', $arrValueForm['sort_order']);
    $inputImage = Helper::createInput('file', 'image', 'image', 'form-control', '');

    // Tạo select box 
    $arrStatus = ['18' => 'Select Status', '0' => 'unpublish', '1' => 'publish'];
    $selectBoxStatus = Helper::CreateSelectBox($arrStatus, 'form[status]', 'status', 'form-control', $arrValueForm['status']);
    $arrSpecial = ['18' => 'Select Special', '0' => 'no', '1' => 'yes'];
    $selectBoxSpecial = Helper::CreateSelectBox($arrSpecial, 'form[special]', 'special', 'form-control', $arrValueForm['special']);

    $this->selectBoxCategory['default'] = 'Select Category';
    $arrCategory = $this->selectBoxCategory;
    ksort($arrCategory);    
    $selectCategory = Helper::CreateSelectBox($arrCategory, 'form[category_id]', 'category_name', 'form-control', $arrValueForm['category_id']);

    $inputDescription = '<textarea name="form[description]" id="editor1">'.$arrValueForm['description'].'</textarea>';

    $pictureHTML = '';
    $inputImgHidden = '';
    if(isset($this->arrParams['id'])){
        $inputId = Helper::createInput('text', 'form[id]', 'id', 'form-control', $arrValueForm['id'], true);
        $pictureHTML = '<div style="margin-top: 2%;">
                            <img width="180" height="180" src="'.PUBLIC_URL . 'upload/images/book' . DS  . $arrValueForm['image'].'">
                        </div>';
        $inputImgHidden = Helper::createInput('hidden', 'form[image_hidden]', 'image_hidden', 'form-control', $arrValueForm['image']);
        $formBook['id'] = ['name' => 'ID', 'input' => $inputId];
    }

    // Array frame form submit
    $formBook = [
        'name' => ['name' => 'Name', 'input' => $inputName],
        'price' => ['name' => 'Price', 'input' => $inputPrice],
        'sale_off' => ['name' => 'Sale Off', 'input' => $inputSaleOff],
        'status' => ['name' => 'Status', 'input' => $selectBoxStatus],
        'special' => ['name' => 'Special', 'input' => $selectBoxSpecial],
        'category_id' => ['name' => 'Category Name', 'input' => $selectCategory],
        'image' => ['name' => 'Image', 'input' => $inputImage . $pictureHTML . $inputImgHidden],
        'sort_order' => ['name' => 'Sort Order', 'input' => $inputSortOrder ],
        'description' => ['name' => 'Description', 'input' => $inputDescription ],
    ];


    $formBookHtml = '';
    foreach($formBook as $key => $row){
        $strError = '';
        $classHasDanger = '';
        if(isset($this->errors[$key])){
            $strError = '<div class="col-form-label">'.$this->errors[$key].'</div>';
            $classHasDanger = 'has-danger';
        }
        
        $formBookHtml .=   '<div class="form-group '.$classHasDanger.' row">
                                <label class="col-sm-2 col-form-label">'.$row['name'].'</label>
                                <div class="col-sm-10">
                                    '.$row['input'] . $strError.'
                                </div>
                            </div>' ;
    }

  
    $strMessageSuccess = Helper::createAlert('alert alert-success', Session::get('message'));
    if(!isset($this->arrParams['form'])) Session::delete('message'); 

?>
<div class="page-body">
    <!-- Hover table card start -->
    <div class="card">
        <?php 
            include_once MODULE_PATH . $this->arrParams['module'] . DS .'views' . DS . 'toolbar-header.php';
        ?>
        <div class="card-block">
            <?php 
                echo $strMessageSuccess;
            ?>
            <h4 class="sub-title">Add New A Book</h4>
            <form action="#" method="post" name="adminForm" id="adminForm"  enctype= multipart/form-data>
                <?php 
                    echo $formBookHtml;
                    echo Session::get('message_success');
                ?>
            </form>
        </div>
    </div>
</div>
<!-- Hover table card end -->
</div>
<script>
</script>