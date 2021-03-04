<?php

    // Gọi các file định nghĩa sẵn các keyword
    require_once "define.php";

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

    require CORE_PATH . 'sendGrid/vendor/autoload.php';
    $key = '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';
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("quocle0103@gmail.com", "bookstore");
    $email->setSubject('test email');
    $email->addTo('spidermandog.k6fc@gmail.com', 'ldquoc');
    $email->addContent("text/html", "<h1>Thành công rồi hihi hahahaha</h1>");

    $sendgrid = new \SendGrid($key);

    try{
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        echo '<pre>';
        print_r($response->headers());
        print $response->body() . "\n";
    }
    catch(Exception $e){
        echo "Email exception Caught : " . $e->getMessage() . "\n";
        return false;
    }

    // Tạo 1 đối tượng bootstrap để chuyển hướng đến đúng module, controller, action muốn thực hiện
    $bt = new Bootstrap();
    $bt->init();
?>