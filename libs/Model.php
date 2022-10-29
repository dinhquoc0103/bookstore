<?php

    class Model {

        public  $connect;             // Lưu status connect
        protected $connectParams = [];  // Mảng tham số connect
        protected $table;  // Mảng tham số connect

        // Khởi tạo connect
        public function __construct($connectParams = null){
            if($connectParams == null){
                $connectParams['server'] = DB_HOST;
                $connectParams['username'] = DB_USERS;
                $connectParams['password'] = DB_PASS;
                $connectParams['database'] = DB_NAME;
                $connectParams['port'] = DB_PORT;
                $connectParams['table'] = DB_TABLE;
            }
            $link = mysqli_connect(
                $connectParams['server'],
                $connectParams['username'],
                $connectParams['password'],
                $connectParams['database'],
                $connectParams['port']
            );

            // Đây là giải pháp nếu thay đổi collation (bảng mã đối chiếu) trên phpmyadmin nước ngoài rồi 
            // Và đã nhập được database nhưng build ra chính thì nó vẫn là bảng mã đối chiếu nước ngoài nên lỗi
            // font thì dùng cái set_charset ép về utf8. Còn nếu phpmyadmin mặt định có utf8 thì thôi khỏi cần
            // $link->set_charset("utf8");

            if($this->checkConnect($link) == true){
                $this->connectParams = $connectParams;
                $this->table = $connectParams['table'];
                $this->connect = $link;
            }
        }

        // Chọn database khác để thao tác
        public function setDatabase($dbName){
            if($dbName != null){
                mysqli_select_db($this->connect, $dbName);
            }
        }

        // Chọn lại table khác để thao tác 
        public function setTable($tbName){
            if($tbName != null){
                $this->table = $tbName;
                $this->connectParams['table'] = $tbName;
            }
        }

        // Check lỗi khi connect
        private function checkConnect($link){
            if(!$link) return false;
            else return true;
            //  {
            //     error_reporting(0);
            //     die('Connect Error: '.mysqli_connect_error());
            // }
        }

        // Tạo chuỗi tham số các cột và chuỗi giá trị cho insert
        protected function strParamInsert($data){
            if(!empty($data)){
                $strColumn = '';
                $strValue = '';
                foreach($data as $column => $value){
                    $strColumn .= ", $column";
                    $strValue .= ", '$value'";
                }
            }
            $result['column'] = substr($strColumn, 2);
            $result['value'] = substr($strValue, 2);
            return $result;
        }

        // Insert (thao tác insert và trả về số dòng bị ảnh hưởng)
        //      $data là mảng các cột và giá trị tương ứng thêm vào database
        //      $typeInsert là loại insert 1 row hoặc nhiều row
        public function insert($data, $typeInsert = '1_row'){
            switch ($typeInsert){
                case '1_row':
                    $arrColumn = $this->strParamInsert($data);

                    $sql = "INSERT INTO ".$this->connectParams['table']."(".$arrColumn['column'].") VALUES(".$arrColumn['value'].")  ";
                    $result = $this->query($sql);
                    $this->checkQuery($result);

                    return $this->numRowAffected();
                break;
                case 'n_row':
                    $i = 0;
                    foreach($data as $item){
                        $arrColumn = $this->strParamInsert($item);

                        $sql = "INSERT INTO ".$this->connectParams['table']."(".$arrColumn['column'].") VALUES(".$arrColumn['value'].")  ";
                        echo $sql;
                        die();
                        $result = $this->query($sql);
                        $this->checkQuery($result);

                        $i++;
                    }
                    return $i;
                break;
            }
        }

        // Tạo chuỗi tham số các cột cho update
        protected function strParamUpdate($data){
            $strParams = '';
            if(!empty($data)){
                foreach($data as $column => $value){
                    $strParams .= ", $column = '$value'";
                }
            }
            $result = substr($strParams, 2);
            return $result;
        }


        // Update (thao tác update và trả về số dòng bị ảnh hưởng)
        //    $data là mảng các cột thay đổi
        //    $where là chuỗi các điều kiện
        public function update($data, $where){
            $arrColumn = $this->strParamUpdate($data);

            $sql = "UPDATE ".$this->connectParams['table']." SET $arrColumn WHERE $where";
            $result = $this->query($sql);
            $this->checkQuery($result);

            return $this->numRowAffected();
        }

        // Delete (thao tác delete và trả về số dòng bị ảnh hưởng)
        // Thao tác trên web chủ yếu xoá dữ liệu thông qua id nên ta xem $where là mảng số nguyên id truyền vào cần xoá
        public function delete($where){
            $strID = implode(',', $where); 
            $sql = "DELETE FROM ".$this->connectParams['table']." WHERE id IN ($strID)";
            $result = $this->query($sql);
            $this->checkQuery($result);

            return $this->numRowAffected();
        }

        // Select nhiều row
        // Trả về mảng các row luôn để dễ đổ dữ liệu hay thao tác
        public function select($sql){
            $result = $this->query($sql);
            $this->checkQuery($result);

            $arrResult = array();
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $arrResult[] = $row;
                }
            }
            $this->freeMemory($result);
            return $arrResult;
        }

        // Select 1 row
        public function singleSelect($sql){
            $result = $this->query($sql);
            $this->checkQuery($result);

            $arrResult = array();
            if(mysqli_num_rows($result) > 0){
                $arrResult = mysqli_fetch_assoc($result);
            }
            $this->freeMemory($result);
            return $arrResult;
        }


        // Thực hiện các câu query
        public function query($sql){
            return mysqli_query($this->connect, $sql);
        }

        // Check query
        public function checkQuery($result){
            if(!$result) echo 'Query thất bại <br>';
        }

        // Số dòng bị ảnh hưởng sau khi query
        private function numRowAffected(){
            return mysqli_affected_rows($this->connect);
        }

        // Giải phóng bộ nhớ cho biến lưu kết quả query trả về là 1 object mysql (ví dụ: select,...)
        private function freeMemory($result){
            mysqli_free_result($result);
        }

        // Trả về id của row cuối trong các row được insert vào
        public function lastRowID(){
            return mysqli_insert_id($this->connect);
        }

        // Kiểm tra sự tồn tại của 1 row trong table
        public function existRow($sql){
            if($sql != null){
                $result = $this->query($sql);
                $this->checkQuery($result);
            
                if(mysqli_num_rows($result) > 0) return true;
                else return false;
            }
        }



        // Tạo list select box
        public function CreateListSelectBox($sql, $nameSelect, $keySelected = null, $class = null){
            $result = $this->query($sql);
            $this->checkQuery($result);

            if(mysqli_num_rows($result) > 0){
                $xhtml = '<select '.$class.' name="' . $nameSelect . '" id="">';
                $xhtml .= '<option  value="0" selected = "true">Chọn Group</option>';
                while($row = mysqli_fetch_assoc($result)){
                    if ($keySelected == $row['id']) {
                        $xhtml .= '<option  value="' . $row['id'] . '" selected = "true">' . $row['name'] . '</option>';
                    } else {
                        $xhtml .= '<option value="' . $row['id'] . '">' . $row['name']. '</option>';
                    }
                }
                $xhtml .= '</select>';
            }

            $this->freeMemory($result);
            return $xhtml;
        }

        // Lấy mảng dạng [id] => 'name'
        public function fetchPairs($sql, $key, $value){
            $result = $this->query($sql);
            $this->checkQuery($result);

            $arrResult = array();
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $arrResult[$row[$key]] = $row[$value];
                }
            }
            $this->freeMemory($result);
            return $arrResult;
        }

        // Đóng connect
        public function __destruct(){
            mysqli_close($this->connect);
        }
    }
?>