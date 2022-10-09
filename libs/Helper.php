<?php

    class Helper {

        // Create 1 button thao tác 
        public static function createActionBtn($class, $classIcon, $link = '#'  ,$title = '', $type = 'new', $style = ''){
            $xhtml = '<li>';
            switch ($type){
                case 'new':
                    $xhtml .=    '<a class="'.$class.'" href="'.$link.'" title="'.$title.'">
                                    <i class="'.$classIcon.'"></i>
                                </a>';
                break;
                case 'submit':
                    $xhtml .=    '<a class="'.$class.'" href="javascript:submitForm(\''.$link.'\');" title="'.$title.'">
                                    <i class="'.$classIcon.'"></i>
                                </a>';
                break;
            }
            $xhtml .= '</li>';
            return $xhtml;
        }

        // Create input
        public static function createInput($type, $name, $id, $class, $value = '', $placeholder = '', $disabled = false){
            $strDisabled = '';
            if($disabled == true){
                $strDisabled = 'disabled';
            }
            return '<input type="'.$type.'" name="'.$name.'" id="'.$id.'" class="'.$class.'" value="'.$value.'" placeholder="'.$placeholder.'" '.$strDisabled.'>';
             
        }

        // Create select box
                    /*  <select name="select" class="form-control">
                            <option value="opt1">Select One Value Only</option>
                            <option value="opt2">Type 2</option>
                        </select> */
        public static function CreateSelectBox($arrValue, $name, $id,  $class, $keySelected, $dataId = ''){
            $strDataid = '';
                if($dataId != ''){
                    $strDataid = 'data-id='.$dataId;
                }
                $xhtml = '<select '.$strDataid.' name="'.$name.'"  id="'.$id.'" class="'.$class.'">';
                if(!empty($arrValue)){
                    foreach($arrValue as $key => $value){
                        if($key == $keySelected){
                            $xhtml .= '<option value="'.$key.'" selected="selected" >'.$value.'</option>';
                        }
                        else{
                            $xhtml .= '<option value="'.$key.'">'.$value.'</option>';
                        }
                    }
                }
                $xhtml .= '</select>';
                return $xhtml;
        }

        // Create alert 
        public static function createAlert($class, $message){
            $xhtml = '';
            if(!empty($message)){
                $xhtml =    '<div class="'.$class.'">
                                <strong>'.$message.'</strong>
                            </div>';              
            }
            return $xhtml;
        }

        // Create status
        /*  <a class="mytooltip tooltip-effect-7" id="status-'.$id.'" href="javascript:changeStatus(\''.$link.'\');" title="Publish">
                <i class="fa fa-check-circle"></i>
            </a> */
        public static function createStatus($value, $link, $id){
            $classStatus = ($value == 1) ? 'fa-check-circle' : 'fa-times-circle';

            $xhtml =    '<a class="status" id="status-'.$id.'" href="javascript:changeStatus(\''.$link.'\');">
                            <i class="fa '.$classStatus.'"></i>
                        </a>'; 

            return $xhtml;
        }

        // Create status group ACP 
        public static function createGroupACP($value, $link, $id){
            $classStatus = ($value == 1) ? 'fa-check-circle' : 'fa-times-circle';

            $xhtml =    '<a class="status" id="group-acp-'.$id.'" href="javascript:changeGroupACP(\''.$link.'\');">
                            <i class="fa '.$classStatus.'"></i>
                        </a>'; 

            return $xhtml;
        }

        // Create status special 
        public static function createSpecial($value, $link, $id){
            $classStatus = ($value == 1) ? 'fa-check-circle' : 'fa-times-circle';

            $xhtml =    '<a class="status" id="special-'.$id.'" href="javascript:changeSpecial(\''.$link.'\');">
                            <i class="fa '.$classStatus.'"></i>
                        </a>'; 

            return $xhtml;
        }


        //Rút ngắn văn bản
        public static function shortenText($text, $wordCount){
            if($text == null){
                return '';
            }
            if(!empty($text) || trim($text) != null){
                if(str_word_count($text) > $wordCount){
                    $arrWord = array_slice(explode(' ', $text), 0, $wordCount);
                    return implode(' ', $arrWord) . '...';
                }
                return $text;
               
            }
           
        }


        public static function ramdomString($length = 5){
            $arrChar = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
            $strChar = implode("", $arrChar);
            // random chuỗi 
            $strChar = str_shuffle($strChar); 
            
            $nameFile = substr($strChar, 0, $length);
            return $nameFile;
            
        }

        public static function createImage($folderImg, $nameImg, $attribute = null){
            $strAttribute = '';
            if(!empty($attribute)){
                foreach($attribute as $key => $value){
                    $strAttribute .= ' ' . $key . '="' . $value . '"';
                }
            }
           
            $picturePath = PUBLIC_PATH . 'upload/images/' .  $folderImg . '/' . $nameImg;
            if(file_exists($picturePath) == true){
                $picture = '<img '.$strAttribute.'  src="'.PUBLIC_URL . 'upload/images/' . $folderImg . '/' . $nameImg.'" alt="" title="" border="0" />';
            }
            else{
                echo 'huhu';
                $picture = '<img  '.$strAttribute.' src="'.PUBLIC_URL . 'upload/images/' . $folderImg . '/'  . '-default.jpg'.'" alt="" title="" border="0" />';
            }

            return $picture;
        }

        // Chuyển thành chuỗi không dấu
        public static function unsignedStr($str){
            $str = preg_replace("/\(|\./", ' ', $str);
            $str = preg_replace("/\)/", ' ', $str);
            $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
            $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
            $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
            $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
            $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
            $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
            $str = preg_replace("/(đ)/", 'd', $str);

            $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
            $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
            $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
            $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
            $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
            $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
            $str = preg_replace("/(Đ)/", 'D', $str);
            $str = preg_replace("/-/", '', $str);
            return str_replace(' ', '-', trim(strtolower($str)));
        }


        
    }
?>