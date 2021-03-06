<?php

    //---------------------------- Định nghĩa PATH ----------------------------//
    // Dấu /
    define('DS', '/');
    // Path ROOT (mvc-multy)
    define('ROOT_PATH', dirname(__FILE__) . DS);
    // Path đến folder libs
    define('LIBRARY_PATH', ROOT_PATH . 'libs' . DS);
    // Path đến folder application
    define('APPLICATION_PATH', ROOT_PATH . 'application' . DS);
    // Path đến folder module
    define('MODULE_PATH', APPLICATION_PATH . 'module' . DS);
    // Path đến folder public
    define('PUBLIC_PATH', ROOT_PATH . 'public' . DS);
    // Path đến folder template
    define('TEMPLATE_PATH', PUBLIC_PATH . 'template' . DS);
    // Path đến folder core
    define('CORE_PATH', ROOT_PATH . 'core' . DS);

    //---------------------------- Định nghĩa URL tương đối cho CSS và JS ----------------------------//
    // Tương đối là từ thư mục chứa dự án .. chứ không xuất phát từ ổ đĩa chứa tất cả các file
    define('ROOT_URL', 'https://bookkg.herokuapp.com' . DS);
    define('PUBLIC_URL', ROOT_URL . 'public' . DS);
    define('TEMPLATE_URL', PUBLIC_URL . 'template' . DS);
    define('APPLICATION_URL', ROOT_URL . 'application' . DS);

    //---------------------------- Định nghĩa tham số URL default ----------------------------//
    // Default module
    define('DEFAULT_MODULE', 'site');
    // Default controller
    define('DEFAULT_CONTROLLER', 'index');
    // Default action
    define('DEFAULT_ACTION', 'index');

    //---------------------------- Định nghĩa tham số DATABASE ----------------------------//
    // for developer 
    // // host đang thao tác
    // define('DB_HOST', 'localhost');
    // // Username phpMyAdmin
    // define('DB_USERS', 'root');
    // // Password phpMyAdmin
    // define('DB_PASS', '');
    // // Database muốn connect
    // define('DB_NAME', 'book_store');
    // // Table muốn thao tác
    // define('DB_TABLE', '`user`');

    // host đang thao tác
    define('DB_HOST', 'remotemysql.com');
    // Username phpMyAdmin
    define('DB_USERS', 'KAIyqaosbq');
    // Password phpMyAdmin
    define('DB_PASS', 'RC21qltEfk');
    // Database muốn connect
    define('DB_NAME', 'KAIyqaosbq');
    // Port muốn connect
    define('DB_POST', '3306');
    // Table muốn thao tác
    define('DB_TABLE', '`user`');

    //---------------------------- Định nghĩa TABLE ----------------------------//
    define('TB_GROUP', '`group`');
    define('TB_USER', '`user`');
    define('TB_CATEGORY', '`category`');
    define('TB_BOOK', '`book`');
    define('TB_ORDER', '`order`');
    define('TB_ORDER_DETAIL', '`order_detail`');


    //---------------------------- Định nghĩa SendGrid ----------------------------//

    


?>