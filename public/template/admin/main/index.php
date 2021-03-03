<!DOCTYPE html>
<html lang="en">
<?php
    $ImgSrc = TEMPLATE_URL . $this->_moduleName . DS . 'main';
?>
<head>
    <?php echo '<title>'.$this->_titlePage.'</title>' ?>

    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
      
    <!-- Meta -->
    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo $ImgSrc; ?>/assets/images/favicon.ico" type="image/x-icon">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">

    <!-- CSS  -->
    <?php echo $this->_cssFiles; ?>

  </head>

  <body>

    <!-- Pre-loader start -->
    <?php
        include_once "html/theme-loader.php";
    ?>
    <!-- Pre-loader end -->

<?php 
    if($this->arrParams['action'] == 'login'){
        require_once $this->_fileContentView; 
    }
    else{
?>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <?php 
                include_once "html/header-navbar.php"; 
            ?>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <?php
                        include_once "html/left-sidebar.php";
                    ?>
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <?php
                            include_once "html/header-content.php";
                        ?>
                        <!-- Page-header end -->

                        <!-- Content  -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <?php
                                        require_once $this->_fileContentView; 
                                    ?>
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                        <!-- End content  -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>

    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
    <div class="ie-warning">
        <h1>Warning!!</h1>
        <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
        <div class="iew-container">
            <ul class="iew-download">
                <li>
                    <a href="http://www.google.com/chrome/">
                        <img src="assets/images/browser/chrome.png" alt="Chrome">
                        <div>Chrome</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.mozilla.org/en-US/firefox/new/">
                        <img src="assets/images/browser/firefox.png" alt="Firefox">
                        <div>Firefox</div>
                    </a>
                </li>
                <li>
                    <a href="http://www.opera.com">
                        <img src="assets/images/browser/opera.png" alt="Opera">
                        <div>Opera</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.apple.com/safari/">
                        <img src="assets/images/browser/safari.png" alt="Safari">
                        <div>Safari</div>
                    </a>
                </li>
                <li>
                    <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                        <img src="assets/images/browser/ie.png" alt="">
                        <div>IE (9 & above)</div>
                    </a>
                </li>
            </ul>
        </div>
        <p>Sorry for the inconvenience!</p>
    </div>
    <![endif]-->
    <!-- Warning Section Ends -->
    
    <?php echo $this->_jsFiles; ?>

    <script>
        $(document).ready(function(){
            var controller = '<?php echo $controller; ?>';
            $('.pcoded-item #' + controller).addClass('active');
        });
    </script>
</body>

</html>
