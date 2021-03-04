<?php
    
    // use PHPMailer\PHPMailer\PHPMailer;
    class Email {

        public function createEmailRegisterHtml($linkActive = 'https://www.youtube.com/?gl=VN'){
            return '<h1>ĐĂNG KÝ TÀI KHOẢN THÀNH CÔNG</h1>
                        <p>
                            Click vào <a href="'.$linkActive.'">ACTIVE</a> để kích hoạt tài khoản
                        </p>';   
        }

        public function createEmailOrderHtml($orderObj, $orderDetailObj){
            $listItems = '';
            foreach($orderDetailObj as $item){
                $listItems .=   '<tr ><td style="text-align: left;">'.$item['name'].'</td>
                                <td style="text-align: center;">'.number_format($item['price']*((100-$item['sale_off'])/100), 0, '', '.').'đ</td>
                                <td style="text-align: center;">'.$item['quantity'].'</td>
                                <td style="text-align: center;">'.number_format($item['total_price'], 0, '', '.').'đ</td></tr>';
            }
            $order_note = '';
            if($orderObj['order_note'] != ''){
                $order_note = '<h3>Ghi Chú Đơn Hàng: '.$orderObj['order_note'].'</h3>';
            }
            
            return  '<h1 style="text-align: center;">ĐẶT HÀNG THÀNH CÔNG</h1>
                    <h3>Thông Tin Đặt Hàng</h3>
                    <h4>Khách hàng: '.$orderObj['fullname'].'</h4>
                    <table border="0" cellspacing="0" cellpadding="0" style="text-align:left">
                            <tbody>
                                    <tr>
                                        <th style="width:315px;color:#313131;text-align:left;line-height:24px;padding:0px 0px 5px 0px">Mã đơn hàng:</th>
                                        <th style="width:315px;color:#313131;text-align:left;line-height:24px;padding:0px 0px 5px 0px">Địa chỉ nhận hàng:</th>
                                    </tr>
                                    <tr>
                                        <td style="width:315px;padding:0px 0px 24px 0px;color:#313131">'.$orderObj['order_code'].'</td>
                                        <td style="width:315px;padding:0px 0px 24px 0px;color:#313131">'.$orderObj['address'].'</td>
                                    </tr>
                                    <tr>
                                        <th style="width:315px;color:#313131;text-align:left;line-height:24px;padding:0px 0px 5px 0px">Ngày đặt:</th>
                                        <th  style="width:315px;color:#313131;text-align:left;line-height:24px;padding:0px 0px 5px 0px">Số điện thoại: </th>
                                    </tr>
                                    <tr>
                                        <td  style="width:315px;padding:0px 0px 24px 0px;color:#313131">'.$orderObj['created'].'</td>
                                        <td  style="width:315px;padding:0px 0px 24px 0px;color:#313131">0'.$orderObj['phone_number'].'</td>
                                    </tr>
                            </tbody>
                    </table>
                    <table style="width:100%">
                                <tr>
                                    <th style="text-align: left;">Sản Phẩm</th>
                                    <th>Giá</th> 
                                    <th>Số Lượng</th>
                                    <th>Tổng Tạm</th>
                                </tr>
                                '.$listItems.'              
                            </table>
                    <h3>Tổng Cộng: '.number_format($orderObj['total_price'], 0, '', '.').'đ</h3>
                    '.$order_note;
        }

        public function sendMail($emailSend, $nameSend, $emailReceive, $nameReceive, $subject, $content){
            require CORE_PATH . 'sendGrid/vendor/autoload.php';
            $email = new \SendGrid\Mail\Mail();                 // Tạo đối tượng email
            $email->setFrom($emailSend, $nameSend);             // Gửi mail từ
            $email->setSubject($subject);                       // Tiêu đề email
            $email->addTo($emailReceive, $nameReceive);         // Gửi đến
            $email->addContent("text/html", $content);          // Nội dụng email

            $sendgrid = new \SendGrid(SENDGRID_API_KEY);        // Tạo đối tượng có api key

            try{
                $response = $sendgrid->send($email);
                print $response->statusCode() . "\n";
                echo '<pre>';
                print_r($response->headers());
                print $response->body() . "\n";
            }
            catch(Exception $e){
                echo 'Caught exception: '. $e->getMessage() ."\n";
                return false;
            }

        }



        public function sendMailPhpMailer($emailSend, $passSend, $emailReceive, $nameReceive, $emailContent){
            require_once CORE_PATH . 'phpMailer/phpmailer/phpmailer/src/PHPMailer.php';
            require_once CORE_PATH . 'phpMailer/phpmailer/phpmailer/src/SMTP.php';
            require_once CORE_PATH . 'phpMailer/autoload.php';

            $mail = new PHPMailer(true);
            try {

                // cài đặt cho server 
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // bật trình gỡ lỗi ở output
                $mail->isSMTP(); // gữi mail sd SMTP
                $mail->SMTPDebug = 1;
                $mail->SMTPAuth   = true; // bật xác thực SMTP (bắt buộc đăng nhập)
                $mail->SMTPSecure = "ssl";
        
            
                $mail->Host = 'smtp.gmail.com';
            
                $mail->Username   = $emailSend;   // SMTP username
                $mail->Password   = $passSend;   // SMTP password
                $mail->Port       = 465;    // TCP port để connect


                // thiết lập thông tin người gữi và email người gữi
                // setFrom(email_ng_gữi, tên_ng_gữi, mặc_định_true_ko_cần_q/tam);
                $mail->setFrom('quocle0103@gmail.com', 'ldq');

                // thiết lập thông tin người nhận và email người nhận
                // addAddress(email_ng_nhận, tên_ng_nhận);
                $mail->addAddress($emailReceive, $nameReceive);

                // thiết lập tiêu đề email
                $mail->Subject = "test phpMailer";

                // thiết lập định dạng tiếng việt
                $mail->CharSet = 'utf-8';

                // thiết lập nội dung email
                $mail->isHTML(true); // cho phép email gữi theo định dạng HTML
                $mail->Body = $emailContent; // nội dung email

                $mail->send();
            }
            catch(Exception $e){
                echo 'không thể gữi mail. Mail error: '. $mail->ErrorInfo;
            }

        }
    }
?>