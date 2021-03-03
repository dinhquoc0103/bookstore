<?php 
    $nameController = ucfirst($this->arrParams['controller']);
    $action = ucfirst($this->arrParams['action']);
    if($action == 'Form'){
        if(!isset($this->arrParams['id'])) $action = 'Add';
        else $action = 'Edit';
    }
    
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"><?php echo $nameController . ' Manager - ' . $action; ?></h5>
                    <p class="m-b-0">Welcome to Bookstore</p>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#!">Manager</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#!"><?php echo $nameController; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>