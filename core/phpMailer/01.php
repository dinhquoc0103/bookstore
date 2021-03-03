<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    // require_once 'vendor/phpmailer/phpmailer/src/Exception.php';
    require_once 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once 'vendor/phpmailer/phpmailer/src/SMTP.php';

    // tải trình tự động của composer 
    require_once "vendor/autoload.php";

    // khởi tạo đối tượng mail và truyền vào tham số true để chấp nhận các exception 
    $mail = new PHPMailer(true);

    try {

        // cài đặt cho server 
       // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // bật trình gỡ lỗi ở output
        $mail->isSMTP(); // gữi mail sd SMTP
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth   = true; // bật xác thực SMTP (bắt buộc đăng nhập)
        $mail->SMTPSecure = "ssl";
  
    
        $mail->Host = 'smtp.gmail.com';
      
        $mail->Username   = 'quocle0103@gmail.com';   // SMTP username
        $mail->Password   = 'Q01657658847';   // SMTP password
        $mail->Port       = 465;    // TCP port để connect


        // thiết lập thông tin người gữi và email người gữi
        // setFrom(email_ng_gữi, tên_ng_gữi, mặc_định_true_ko_cần_q/tam);
        $mail->setFrom('quocle0103@gmail.com', 'ldq');

        // thiết lập thông tin người nhận và email người nhận
        // addAddress(email_ng_nhận, tên_ng_nhận);
        $mail->addAddress('spidermandog.k6fc@gmail.com', 'RoTK Quốc');

        // thiết lập tiêu đề email
        $mail->Subject = "test phpMailer";

        // thiết lập định dạng tiếng việt
        $mail->CharSet = 'utf-8';

        // thiết lập nội dung email
        $mail->isHTML(true); // cho phép email gữi theo định dạng HTML
        $mail->Body = '<h1>Đây là email được gữi để test phpMailer okeokeokeoek</h1>'; // nội dung email

        $mail->send();
        echo 'Message has been sent';
    }
    catch(Exception $e){
        echo 'không thể gữi mail. Mail error: '. $mail->ErrorInfo;
    }
   
    

    

    

    




    // echo '<pre>';
    // print_r($mail);

?>