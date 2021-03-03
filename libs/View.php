<?php

    class View {

        // Module name nhận khi tạo View obj
        protected $_moduleName;

        // Title của trang ở trên tab trình duyệt
        public $_titlePage;

        // Các thẻ meta HTTP
        public $_metaHTTP;

        // Các thẻ meta Name
        public $_metaName;

        // Các thẻ link CSS
        public $_cssFiles;

        // Các thẻ link JS
        public $_jsFiles;

        // Path đến file Template
        public $_templatePath;

        public function __construct($module){
            $this->_moduleName = $module;
        }

        // Render views ra browser
        public function render($fileInclude, $loadFull = true){

            $pathContentView = MODULE_PATH . $this->_moduleName . DS . 'views' . DS . $fileInclude . '.php';
           
            if(file_exists($pathContentView)){
                if($loadFull == true){
                    // Đẩy đg link giao diện ở content trong bố cục trang web sang view để require_once
                    $this->_fileContentView = $pathContentView;
                    if(file_exists($this->_templatePath)){
                        // Require phần template là phần chung chứa header và footer và cái này sẽ chứa require link giao diện content
                        require_once $this->_templatePath;
                    }
                    else{
                        echo 'errors';
                    } 
                }
                else{
                    require_once $pathContentView;
                }
                           
            }
            else{
                echo 'errors';
            }
        }

        // Tạo thẻ title
        public function createTitle($value){
            return $value;
        }

        // Tạo các thẻ meta ở trong head
        public function createTagMeta($arrMeta, $typeMeta = 'name'){
            $xhtml = '';
            if(!empty($arrMeta)){
                foreach($arrMeta as $meta){
                    $meta = explode("|", $meta);
                    switch ($typeMeta){
                        case 'name':
                            $xhtml .= ' <meta name="'.$meta[0].'" content="'.$meta[1].'" >';
                        break;
                        case 'http':
                            $xhtml .= '<meta http-equiv="'.$meta[0].'" content="'.$meta[1].'" >';
                        break;
                    }
                }
            }
            return $xhtml;
        }

        // Tạo các thẻ link CSS và JS
        // public function createTagLink($dirContainerFile, $arrFile, $typeFile = 'css'){
        //     $xhtml = '';
        //     if(!empty($arrFile)){
        //         foreach($arrFile as $file){
        //             $path = TEMPLATE_URL . $dirContainerFile . DS . $file;
        //             switch ($typeFile){
        //                 case 'css':
        //                     $xhtml .= '<link rel="stylesheet" type="text/css" href="'.$path.'" />';
        //                 break;
        //                 case 'js':
        //                     $xhtml .= '<script type="text/javascript" src="'.$path.'"></script>';
        //                 break;
        //             }
        //         }
        //     }
        //     return $xhtml;
        // }
        
        // Tạo chuỗi property cho thẻ link
        private function createStrAttribute($arrAttribute){
            $strAttribute = '';
            foreach($attributes as $property => $value){
                $strAttribute .= $property . '=' . $value . ' ';
            }
            return $strAttribute;
        }

        public function createTagLink($folderTemplate, $arrHref, $typeFile = 'css'){
            $xhtml = '';
            if(!empty($arrHref)){
                foreach($arrHref as $href){
                    $path = TEMPLATE_URL . $folderTemplate . DS . $href;
                    if(substr($href, 0, 4) == 'http'){
                        $path = $href;
                    }
                    
                    switch ($typeFile){
                        case 'css':
                            $xhtml .= '<link rel="stylesheet" type="text/css" href="'.$path.'" medial="all"/>';
                        break;
                        case 'js':
                            $xhtml .= '<script type="text/javascript" src="'.$path.'"></script>';
                        break;
                    }
                }
            }
            return $xhtml;
        }

        // Thêm các thẻ link css nếu có bổ sung cho từng file riêng biệt
        public function appendCSS($arrCSS){
            if(!empty($arrCSS)){
                foreach($arrCSS as $css){
                    $path = APPLICATION_URL . $this->_moduleName . DS . 'views' . DS . $css;
                    $this->_cssFiles .= '<link rel="stylesheet" type="text/css" href="'.$path.'"/>';
                }
            }
        }

          // Thêm các thẻ script js nếu có bổ sung cho từng file riêng biệt
        public function appendJS($arrJS){
            if(!empty($arrJS)){
                foreach($arrJS as $js){
                    $path = APPLICATION_URL . $this->_moduleName . DS . 'views' . DS . $js;
                    $this->_jsFiles .= '<script type="text/javascript" src="'.$path.'"></script>';
                }
            }
        }

    }
?>