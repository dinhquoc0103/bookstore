<!DOCTYPE html>
<html lang="en">
<?php
    $imgSrc = TEMPLATE_URL . $this->_moduleName . DS . 'main';
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
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $imgSrc; ?>/image/favicon.ico">

    <!-- Google font-->
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet"> -->

    <!-- CSS  -->
    <?php echo $this->_cssFiles; ?>

</head>

<body>
    <div class="site-wrapper" id="top">
        <?php
            include_once "html/header.php";
            include_once "html/mobile-header.php";
            // include_once "html/sticky-header.php";
        ?>
        <?php
            require_once $this->_fileContentView; 
        ?>
    </div>

    <?php
        include_once "html/footer.php";
    ?>
   
   

    <?php echo $this->_jsFiles; ?>
</body>

</html>