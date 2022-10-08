<?php
    ini_set('display_errors', 'on');
    error_reporting(E_ALL);
    // Gọi các file định nghĩa sẵn các keyword
    require_once "define.php";
    
    // require('vendor/autoload.php');

    date_default_timezone_set('Asia/Ho_Chi_Minh');

    // Tự động load các class dùng chung ở folder libs khi cần
    spl_autoload_register(function($className){
        $filePath = LIBRARY_PATH . $className . ".php";
        if(file_exists($filePath)){
            require_once $filePath;  
        }
    });

    // Session start
    Session::init();

    // Tạo 1 đối tượng bootstrap để chuyển hướng đến đúng module, controller, action muốn thực hiện
    $bt = new Bootstrap();
    $bt->init();
?>