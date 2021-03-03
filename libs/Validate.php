<?php

    class Validate {
        // -------------- CÁC THUỘC TÍNH ---------------- // 
        // mảng lưu trữ các lỗi
        private $errors = [];
        
        // mảng truyền vào để validate 
        private $source = [];

        // mảng lưu trữ các quy tắc để validate một phần tử
        private $rules = [];

        // mảng các phần tử thoả yêu cầu validate
        private $result = [];

        // -------------- CÁC PHƯƠNG THỨC ---------------- // 
        public function __construct($arrSourceInfo){
            if(array_key_exists('submit', $arrSourceInfo)){
                unset($arrSourceInfo['submit']);
            }
            $this->source = $arrSourceInfo;
        }

        // thêm rules để validate
        public function addRules($arrRules){
            $this->rules = array_merge($this->rules, $arrRules);
        }

        // thêm từng rule 
        public function addRule($element, $type, $options = null, $require = true){
            $this->rules[$element] = array('dataType' => $type, 'options' => $options, 'require' => $require);
            return $this; // trả về để hiểu là đối tượng trỏ tiếp luôn cho nhanh
        }

        // thực hiện validate 
        public function runValidate(){
            foreach($this->rules as $element => $value){
                if($value['require'] == true && trim($this->source[$element]) == null){
                    $this->setError($element, 'không được để trống');
                }
                else{
                    switch ($value['dataType']){
                        case 'int':
                            $this->validateInt($element, $value['options']['min'], $value['options']['max']);        
                        break;
                        case 'string':
                            $this->validateString($element, $value['options']['min'], $value['options']['max']);        
                        break;
                        case 'url':
                            $this->validateUrl($element);
                        break;
                        case 'email':
                            $this->validateEmail($element);
                        break;
                        case 'status':
                            $this->validateStatus($element, $value['options']['accept']);
                        break;
                        case 'password':
                            $this->validatePassword($element, $value['options']);
                        break;
                        case 'group':
                            $this->validateGroup($element);
                        break;
                        case 'date':
                            $this->validateDate($element, $value['options']['start'], $value['options']['end']);        
                        break;
                        case 'existRow':
                            $this->validateExistRow($element, $value['options']);        
                        break;
                        case 'email-notExistRow':
                            $this->validateEmail($element); 
                            $this->validateNotExistRow($element, $value['options']);        
                        break;
                        case 'file':
                            $this->validateFile($element, $value['options']);             
                        break;
                        case 'percent':
                            $this->validatePercent($element, $value['options']);             
                        break;
                        case 'phone-number':
                            $this->validatePhoneNumber($element, $value['options']);             
                        break;
                    }
                   
                }
                if(!array_key_exists($element, $this->errors)){
                    $this->result[$element] = $this->source[$element];
                }
                
            }

            // những phần tử chưa được validate nếu xoá thêm rules bên kia đc gán vào result với giá trị ban đầu luôn
            $eleNotValidate = array_diff_key($this->source,  $this->errors);
            $this->result = array_merge( $this->result, $eleNotValidate);
        }

        // validate int 
        private function validateInt($element, $min = 0, $max = 0){
            $options = array("options" => array("min_range" => $min, "max_range" =>$max));
            if(!is_numeric($this->source[$element])){
                $this->setError($element, 'phải là một số');
            }
            else if(!filter_var($this->source[$element], FILTER_VALIDATE_INT, $options)){
                $this->setError($element, 'không thoả mãn');
            }
        }

        // validate phone number
        private function validatePhoneNumber($element, $min = 0, $max = 0){
            $firstNum = substr($this->source[$element], 0, 1);
            if($firstNum != '0'){
                $this->setError($element, 'không hợp lệ');
            }
            if(!is_numeric($this->source[$element])){
                $this->setError($element, 'không hợp lệ');
            }
            if(strlen($this->source[$element]) > 10){
                $this->setError($element, 'không hợp lệ');
            }

        }

        // validate  percent
        private function validatePercent($element, $options){
           if($this->source[$element] < 0 || $this->source[$element] > 100){
                $this->setError($element, 'không thoả mãn phải từ 0 đến 100');
           }
        }

        // validate string 
        private function validateString($element, $min = 0, $max = 0){
            $strLength = strlen($this->source[$element]);
            if(is_numeric($this->source[$element])){
                $this->setError($element, 'phải là một chuỗi');
            }
            else if($strLength <= $min){
                $this->setError($element, 'quá ngắn. Tối thiểu ' . $min . ' ký tự');
            }
            else if( $strLength >= $max){
                $this->setError($element, 'quá dài. Tối đa '. $max. ' ký tự');
            }
        }

        // validate url
        private function validateUrl($element){
            if(!filter_var($this->source[$element], FILTER_VALIDATE_URL)){
                $this->setError($element, 'không thoả mãn');
            }
        }

        // validate email
        private function validateEmail($element){
            if(!filter_var($this->source[$element], FILTER_VALIDATE_EMAIL)){
                $this->setError($element, 'không thoả mãn');
            }
        }

        // validate status
        private function validateStatus($element, $accept){
            if(!in_array($this->source[$element], $accept)){
                $this->setError($element, 'Không được chọn giá trị mặc định. Xin hãy chọn giá trị khác!');
            }
        }

        // validate group
        private function validateGroup($element){
            if($this->source['group_id'] == 0){
                $this->setError($element, 'không tồn tại');
            }
        }

        // validate exist row
        private function validateExistRow($element, $options){
            $db = $options['database'];
            $sql = $options['sql'];
            if($sql != ''){
                if(!$db->existRow($sql)){
                    if($this->source[$element] == 'checkAcountLogin'){
                        $this->setError($element, 'Tài khoản hoặc mật khẩu không đúng');
                    }
                    else{
                        $this->setError($element, 'không tồn tại');
                    }                   
                }
            }
        }
        // validate not exist row
        private function validateNotExistRow($element, $options){
         
            $db = $options['database'];
            $sql = $options['sql'];
            if($sql != ''){
                if($db->existRow($sql) == true){
                    $this->setError($element, 'đã tồn tại');
                }
            }
        }

         // validate date
         private function validateDate($element, $start, $end){
             // start
             $arr_date_start = date_parse_from_format("d/m/Y", $start);
             $time_stampe_start = mktime(0, 0, 0, $arr_date_start["month"],$arr_date_start["day"], $arr_date_start["year"] );

             // end
             $arr_date_end = date_parse_from_format("d/m/Y", $end);
             $time_stampe_end = mktime(0, 0, 0, $arr_date_end["month"],$arr_date_end["day"], $arr_date_end["year"] );

             // current 
             $arr_date_current = date_parse_from_format("d/m/Y", $this->source[$element]);
             $time_stampe_current = mktime(0, 0, 0, $arr_date_current["month"],$arr_date_current["day"], $arr_date_current["year"] );

             if($time_stampe_current < $time_stampe_start || $time_stampe_current > $time_stampe_end){
                $this->setError($element, 'không hợp lệ');
             }

        }

        // validate status
        private function validatePassword($element, $options){
           if($options['action'] == 'add' || ($options['action'] == 'edit' && $this->source[$element] != null )){
                $pattern = "#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,16}$#";
                $result = preg_match($pattern, $this->source[$element]);
                if(!$result){
                    $this->setError($element, 'không thoả mãn. (Độ dài từ 8, bao gồm chữ thường, in hoa, số và ký tự đặc biệt)');

                }
           }
        }

        // validate file 
        private function validateFile($element, $options){
            if($this->source[$element]['name'] != null){
                if(!filter_var($this->source[$element]['size'], FILTER_VALIDATE_INT, array('options' => array('min_range' => $options['min'], 'max_range' => $options['max'])))){
                    $this->setError($element, 'kích thước không phù hợp');
                }
                
                $extension = pathinfo($this->source[$element]['name'], PATHINFO_EXTENSION);
                if(in_array($extension, $options['extension']) == false){
                    $this->setError($element, 'phần mở rộng không phù hợp');
                }
           
            }
            else{
                if($options['task'] == 'add'){
                    $this->setError($element, 'chưa được thêm');
                }
                
            }
        }
        
        // show lỗi 
        public function showErrors(){
            $strErrors = '<ul class = "error">';
            if(!empty($this->errors)){
                foreach($this->errors as $value){
                    $strErrors .= '<li>' . $value . '</li>';
                }
            }
            $strErrors .= '</ul>';
            return $strErrors ;
        }

        // lây lỗi 
        public function getErrors(){
            return $this->errors;
        }

        private function setError($element, $message){
            $this->errors[$element] = "<b>".ucfirst($element)."</b> $message";
            if($element == 'account'){
                $this->errors[$element] =  $message;
            }
            
        }

        // lấy giá trị mảng result những phần tử đã thoả validate 
        public function getResult(){
            return $this->result;
        }

        public function isValidate(){
            if(count($this->errors) > 0) return false;
            else return true;
        }
        // show mảng thuộc tính của một đối tượng
        public function showInfo(){
            echo $this->source['name'] . '<br>';
            echo $this->source['age'] . '<br>';
            echo $this->source['url'] . '<br>';
            echo $this->source['email'] . '<br>';
        }
    }
?>