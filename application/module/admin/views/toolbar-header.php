<?php
    $module = isset($this->arrParams['module']) ? $this->arrParams['module'] : '';
    $controller = isset($this->arrParams['controller']) ? $this->arrParams['controller'] : '';

    // Tạo các link cho button
    $linkAdd = Url::createLink($module, $controller, 'form', null, 'admin/'.$controller.'/form');
    $linkPublish = Url::createLink($module, $controller, 'changeStatus', array('status' => 1), 'admin/'.$controller.'/changeStatus/1');
    $linkUnpublish = Url::createLink($module, $controller, 'changeStatus', array('status' => 0), 'admin/'.$controller.'/changeStatus/0');
    $linkSortOrder = Url::createLink($module, $controller, 'sortOrder', null, 'admin/'.$controller.'/sortOrder');
    $linkTrash = Url::createLink($module, $controller, 'trash', null, 'admin/'.$controller.'/trash');
    $id = '';
    if(isset($this->arrParams['id'])){
        $id = '/id-'.$this->arrParams['id'];
    }
    $linkSaveNew = Url::createLink($module, $controller, 'form', null, 'admin/'.$controller.'/form'.$id);
    $linkCancel = Url::createLink($module, $controller, 'index', null, 'admin/'.$controller);
    $linkTrashOrderDetail = Url::createLink($module, $controller, 'trash', null, 'admin/'.$controller.'/trashOrderDetail');




    // Tạo các button thac tác
    $btnAdd = Helper::createActionBtn('mytooltip tooltip-effect-7', 'fa fa-plus-circle', $linkAdd, 'Add');
    $btnPublish = Helper::createActionBtn('mytooltip tooltip-effect-7', 'fa fa-check-circle',  $linkPublish , 'Publish', 'submit');
    $btnUnpublish = Helper::createActionBtn('mytooltip tooltip-effect-7', 'fa fa-times-circle', $linkUnpublish, 'Unpublish', 'submit');
    $btnSortOrder = Helper::createActionBtn('mytooltip tooltip-effect-7', 'fa fa-check', $linkSortOrder, 'Save Sort Order', 'submit');
    $btnTrash = Helper::createActionBtn('mytooltip tooltip-effect-7', 'fa fa-trash', $linkTrash, 'Delete', 'submit');
    $btnSaveNew = Helper::createActionBtn('mytooltip tooltip-effect-7', 'fa fa-floppy-o', $linkSaveNew,'Save And New', 'submit');
    $btnCancel =  Helper::createActionBtn('mytooltip tooltip-effect-7', 'fa fa-window-close', $linkCancel,'Cancel');
    $btnTrashOrderDetail = Helper::createActionBtn('mytooltip tooltip-effect-7', 'fa fa-trash', $linkTrashOrderDetail, 'Delete', 'submit');


    // Ở từng trang sẽ có những button nào
    switch ($this->arrParams['action']){
        case 'index':
            $strBtn = $btnAdd . $btnPublish . $btnUnpublish . $btnSortOrder . $btnTrash;
        break;
        case 'form':
            $strBtn = $btnSaveNew . $btnCancel;
        break;
        case 'orderDetail':
            $strBtn = $btnTrashOrderDetail;
        break;
    }
    if($this->arrParams['controller'] == 'order' && $this->arrParams['action'] == 'index'){
        $strBtn = $btnTrash;
    }
?>

<div class="card-header">
    <h5>Thao tác</h5>
    <!-- <span>Quản lý nhóm người dùng</span> -->
    <div class="card-header-right">
        <ul class="list-unstyled card-option" >
            <?php 
                echo $strBtn; 
            ?>
        </ul>
    </div>
</div>