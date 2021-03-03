<?php

    // Array value khi submit nếu đúng thì giữ lại không thì rỗng
    $arrValueForm = [
        'fullname' => '',
        'email' => '',
        'password' => '',
        'address' => '',
        'status' => '18',
        'group_id' => '18',
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
    $inputFullName = Helper::createInput('text', 'form[fullname]', 'fullname', 'form-control', $arrValueForm['fullname']);
    $inputEmail = Helper::createInput('text', 'form[email]', 'email', 'form-control', $arrValueForm['email']);
    $inputPassword = Helper::createInput('text', 'form[password]', 'password', 'form-control', $arrValueForm['password']);
    $inputSortOrder = Helper::createInput('text', 'form[sort_order]', 'sort_order', 'form-control', $arrValueForm['sort_order']);
    // $inputToken = Helper::createInput('hidden', 'form[token]', 'sort_order', 'form-control', time());

    // Tạo select box 
    $arrStatus = ['18' => 'Select Status', '0' => 'unpublish', '1' => 'publish'];
    $selectBoxStatus = Helper::CreateSelectBox($arrStatus, 'form[status]', 'status', 'form-control', $arrValueForm['status']);

    $this->selectBoxGroup['18'] = 'Select Group';
    $arrGroup = $this->selectBoxGroup;
    krsort($arrGroup);    
    $selectGroup = Helper::CreateSelectBox($arrGroup, 'form[group_id]', 'group_name', 'form-control', $arrValueForm['group_id']);

   
    // Array frame form submit
    $formUser = [
        'fullname' => ['name' => 'Full Name', 'input' => $inputFullName],
        'email' => ['name' => 'Email', 'input' => $inputEmail],
        'password' => ['name' => 'Password', 'input' => $inputPassword],
        'status' => ['name' => 'Status', 'input' => $selectBoxStatus],
        'group_id' => ['name' => 'Group Name', 'input' => $selectGroup],
        'sort_order' => ['name' => 'Sort Order', 'input' => $inputSortOrder ],
    ];
    if(isset($this->arrParams['id'])){
        $inputId = Helper::createInput('text', 'form[id]', 'id', 'form-control', $arrValueForm['id'], true); 
        $formUser['id'] = ['name' => 'ID', 'input' => $inputId];
    }
 


    $formUserHtml = '';
    foreach($formUser as $key => $row){
        $strError = '';
        $classHasDanger = '';
        if(isset($this->errors[$key])){
            $strError = '<div class="col-form-label">'.$this->errors[$key].'</div>';
            $classHasDanger = 'has-danger';
        }
        
        $formUserHtml .=   '<div class="form-group '.$classHasDanger.' row">
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
            <h4 class="sub-title">Add New A Group</h4>
            <form action="#" method="post" name="adminForm" id="adminForm">
                <?php 
                    echo $formUserHtml;
                    echo Session::get('message_success');
                ?>
            </form>
        </div>
    </div>
</div>
<!-- Hover table card end -->
</div>