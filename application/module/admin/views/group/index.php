<?php
    $keywordSearch = Session::get('keyword');
    $filterStatusVal = (!in_array(Session::get('filter_status'), [null, 18]) ) ? Session::get('filter_status') : 18;
    $filterGroupACPVal = (Session::get('filter_group_acp') != null) ? Session::get('filter_group_acp')  : 18;
    $sortByVal = (Session::get('sort_by') != null) ? Session::get('sort_by') : 'default';

    // Create select box
    $arrStatus = ['18' => 'Filter By Status', '0' => 'unpublish', '1' => 'publish'];
    $selectBoxStatus = Helper::CreateSelectBox($arrStatus, 'filter_status', 'filter_status', 'form-control', $filterStatusVal);
    $arrGroupACP = ['18' => 'Filter By Group ACP', '0' => 'no', '1' => 'yes'];
    $selectBoxGroupACP = Helper::CreateSelectBox($arrGroupACP, 'filter_group_acp', 'filter_group_acp', 'form-control',  $filterGroupACPVal);
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
    
    // Đổ danh sách group
    $rowGroupHtml = '';
    if(!empty($this->listItems)){
        foreach($this->listItems as $item){
            $id = $item['id'];
            $name = $item['name'];
            $status = Helper::createStatus(
                $item['status'],
                Url::createLink('admin', 'group', 'ajaxChangeStatus', array('status' => $item['status'], 'id' => $id)), 
                $id
            );
            $groupACP = Helper::createGroupACP(
                $item['group_acp'], 
                Url::createLink('admin', 'group', 'ajaxChangeGroupACP', array('group_acp' => $item['group_acp'], 'id' => $id)), 
                $id
            );;
            $sortOrder =  $item['sort_order'];
            $dateCreated =  ($item['created'] != null) ? date('d/m/Y', strtotime($item['created'])) : '';
            $createdBy =  $item['created_by'];
            $dateModified =  ($item['modified'] != null) ? date('d/m/Y', strtotime($item['modified'])) : '';
            $modifiedBy =  $item['modified_by'];
            $linkEdit = Url::createLink('admin', 'group', 'form', ['id' => $id], 'admin/group/form/id-'. $id);
            $rowGroupHtml .=   '<tr>
                            <th scope="row">
                                <input value="'.$id.'" class="checkbox" type="checkbox" name="checkBoxId[]">
                            </th>
                            <td><a href="'.$linkEdit.'" title="Edit Group '.$name.'">'.$name.'</a></td>
                            <td>'.$status.'</td>
                            <td>'.$groupACP.'</td>
                            <td>
                                <input value="'.$sortOrder.'" style="text-align:center;" type="text" name="sortOrder['.$id.']" class="form-control  input-sort-order" required="" maxlength="6" >
                            </td>
                            <td>'.$dateCreated.'</td>
                            <td>'.$createdBy.'</td>
                            <td class="modified-'.$id.'">'.$dateModified.'</td>
                            <td class="modified-by-'.$id.'">'.$modifiedBy.'</td>
                            <td>'.$id.'</td>
                        </tr>';
        }
    }

    $strMessageSuccess = Helper::createAlert('alert alert-success', Session::get('message'));
    $strMessageError = Helper::createAlert('alert alert-danger', Session::get('messageError'));
    if(!isset($this->arrParams['form'])){
        Session::delete('message');
        Session::delete('messageError');
    }
     
    $linkClearKeyword = Url::createLink('admin', 'group', 'clearKeyword');

?>
<div class="page-body">
    <!-- Hover table card start -->
    <div class="card">
        <?php 
            include_once MODULE_PATH . $this->arrParams['module'] . DS .'views' . DS . 'toolbar-header.php';
        ?>
        <div class="card-block table-border-style">
            <form class="form-material" action="<?php echo ROOT_URL . 'admin/group/';?>" method="post" name="adminForm" id="adminForm">
                <div class="row">
                    <div class="form-group form-primary search-in-table col-lg-3">
                        <input type="text" name="keyword" id="keyword" class="form-control"
                            value="<?php echo $keywordSearch; ?>" placeholder="Search">
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
                    <div class="col-lg-3 select-box-filter">
                        <?php
                                    echo $selectBoxStatus;
                                ?>
                    </div>

                    <!-- Filter by group ACP  -->
                    <div class="col-lg-3 select-box-filter">
                        <?php
                                    echo $selectBoxGroupACP;
                                ?>
                    </div>

                    <!-- Sort by  -->
                    <div class="col-lg-3 select-box-filter">
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
                                <th width="15%">Name</th>
                                <th width="5%">Status</th>
                                <th width="5%">Group ACP</th>
                                <th width="10%">Sort Order</th>
                                <th width="10%">Date Created</th>
                                <th width="15%">Created By</th>
                                <th width="10%">Date Modified</th>
                                <th width="15%">Modified By</th>
                                <th width="5%">ID</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                echo $rowGroupHtml;
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