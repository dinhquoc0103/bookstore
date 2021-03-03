<?php
    // Array value khi submit nếu đúng thì giữ lại không thì rỗng
    $arrValueForm = [
        'name' => '',
        'status' => '18',
        // 'group_acp' => '18',
        'sort_order' => '',
        // 'token' => time(),
    ];
    if(!empty($this->arrParams['info_item'])){
        foreach($this->arrParams['info_item'] as $key => $value){
            $arrValueForm[$key] = $value;
        }
    }
    if(!empty($this->arrParams['form'])){
        foreach($this->arrParams['form'] as $key => $value){
            $arrValueForm[$key] = $value;
        }
    }


    // Tạo input
    $inputName = Helper::createInput('text', 'form[name]', 'name', 'form-control', $arrValueForm['name']);
    $inputSortOrder = Helper::createInput('text', 'form[sort_order]', 'sort_order', 'form-control', $arrValueForm['sort_order']);
    // $inputToken = Helper::createInput('hidden', 'form[token]', 'sort_order', 'form-control', time());

    // Tạo select box 
    $arrStatus = ['18' => 'Select Status', '0' => 'unpublish', '1' => 'publish'];
    $selectBoxStatus = Helper::CreateSelectBox($arrStatus, 'form[status]', 'status', 'form-control', $arrValueForm['status']);
    // $arrGroupACP = ['18' => 'Select Group ACP', '0' => 'no', '1' => 'yes'];
    // $selectGroupACP = Helper::CreateSelectBox($arrGroupACP, 'form[group_acp]', 'group_acp', 'form-control', $arrValueForm['group_acp']);

   
    // Array frame form submit
    $formCategory = [
        'name' => ['name' => 'Name', 'input' => $inputName],
        'status' => ['name' => 'Status', 'input' => $selectBoxStatus],
        // 'group_acp' => ['name' => 'Group ACP', 'input' => $selectGroupACP],
        'sort_order' => ['name' => 'Sort Order', 'input' => $inputSortOrder ],
    ];
    if(isset($this->arrParams['id'])){
        $inputId = Helper::createInput('text', 'form[id]', 'id', 'form-control', $arrValueForm['id'], true); 
        $formCategory['id'] = ['name' => 'ID', 'input' => $inputId];
    }
 


    $formCategoryHtml = '';
    foreach($formCategory as $key => $row){
        $strError = '';
        $classHasDanger = '';
        if(isset($this->errors[$key])){
            $strError = '<div class="col-form-label">'.$this->errors[$key].'</div>';
            $classHasDanger = 'has-danger';
        }
        
        $formCategoryHtml .=   '<div class="form-group '.$classHasDanger.' row">
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
            <h4 class="sub-title">Add New A Category</h4>
            <form action="#" method="post" name="adminForm" id="adminForm">
                <?php 
                    echo $formCategoryHtml;
                    echo Session::get('message_success');
                ?>
            </form>
        </div>
    </div>
</div>
<!-- Hover table card end -->
</div>