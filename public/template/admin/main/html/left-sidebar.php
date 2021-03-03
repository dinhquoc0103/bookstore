<?php
    $linkIndex = Url::createLink('admin', 'index', 'index', null, 'admin/index');
    $linkGroup = Url::createLink('admin', 'group', 'index',  null, 'admin/group');
    $linkUser = Url::createLink('admin', 'user', 'index',  null, 'admin/user');
    $linkCategory = Url::createLink('admin', 'category', 'index',  null, 'admin/category');
    $linkBook = Url::createLink('admin', 'book', 'index',  null, 'admin/book');
    $linkOrder = Url::createLink('admin', 'order', 'index',  null, 'admin/order');
    // echo '<pre>';
    // print_r($this->arrParams);

    $controller = isset($this->arrParams['controller']) ? $this->arrParams['controller'] : 'index';

?>

<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-80 img-radius" src="<?php echo $ImgSrc; ?>/assets/images/avatar-4.jpg"
                    alt="User-Profile-Image">
                <div class="user-details">
                    <span id="more-details"><?php echo $fullName; ?><i class="fa fa-caret-down"></i></span>
                </div>
            </div>

            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <!-- <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                        <a href="#!"><i class="ti-settings"></i>Settings</a> -->
                        <a href="<?php echo $linkViewSite; ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i>View Website</a>
                        <a href="<?php echo $linkLogout; ?>"><i class="ti-layout-sidebar-left"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="p-15 p-b-0">
            <form class="form-material">
                <div class="form-group form-primary">
                    <input type="text" name="footer-email" class="form-control" required="">
                    <span class="form-bar"></span>
                    <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Friend</label>
                </div>
            </form>
        </div>


        <!-- Start sidebar in project  -->
        <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Home</div>
        <ul class="pcoded-item pcoded-left-item">
            <li id="index">
                <a href="<?php echo $linkIndex; ?>" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

        </ul>

        <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Manager</div>
        <ul class="pcoded-item pcoded-left-item">
            <li id="group">
                <a href="<?php echo $linkGroup; ?>" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Group</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li  id="user">
                <a href="<?php echo $linkUser; ?>" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">User</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li id="category">
                <a href="<?php echo $linkCategory; ?>" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Category</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li id="book">
                <a href="<?php echo $linkBook; ?>" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Book</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li id="order">
                <a href="<?php echo $linkOrder; ?>" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">Order</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

        </ul>
        <!-- End sidebar in project  -->
    </div>
</nav>

