<?php
    class Upload {

        public function uploadFile($fileObj, $folderUpload, $options = null){
           
            if($options == null){
                if($fileObj['tmp_name'] != null){
                    $uploadDir = PUBLIC_PATH . 'upload/images/' . $folderUpload . DS;

                    $extension = '.' . pathinfo($fileObj['name'], PATHINFO_EXTENSION);
                    $newFileName = $this->createNameFileRandom(6) . $extension; // tạo tên mới ngẫu nhiên để không bị trùng tên 

                    copy($fileObj['tmp_name'], $uploadDir . $newFileName);

                    return $newFileName;
                }
            }
        }

        public function deleteFile($folderUpload, $fileName){
            $fileName = PUBLIC_PATH . 'upload/images/' . $folderUpload . DS . $fileName;
            @unlink($fileName);
        }

        public function createNameFileRandom($length = 5){
            $arrChar = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
            $strChar = implode("", $arrChar);
            // random chuỗi 
            $strChar = str_shuffle($strChar); 
            
            $nameFile = substr($strChar, 0, $length);
            return $nameFile;
            
        }
    }
?>