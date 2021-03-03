<?php

    class Pagination {
        
        private $totalItems;            // Tổng số phần tử
        private $totalItemsPerPage = 1; // Tổng số phần tử của mỗi trang
        private $pageRange = 3;         // Tổng số trang (nút sẽ hiển thị)
        private $totalPage;             // Tổng số trang
        private $currentPage = 1;       // Trang hiện tại

        public function __construct($totalItems, $paginationParams){
            $this->totalItems = $totalItems;
            $this->totalItemsPerPage = $paginationParams['totalItemsPerPage'];

            $this->pageRange =  $paginationParams['pageRange'];
            if($this->pageRange % 2 == 0) $this->pageRange++;

            $this->currentPage = $paginationParams['currentPage'];
            $this->totalPage = ceil($totalItems/ $this->totalItemsPerPage);
        }

        public function showPaginationAdmin($controller){
            $paginationHTML = '';
            if($this->totalPage > 1){
                $start = '<li class="page-item"><span class="page-link">Start</span></li>';
                $prev = '<li class="page-item"><span class="page-link">Previous</span></li>';
                if($this->currentPage > 1){
                    $start = '<li class="page-item"><a class="page-link" href="'.ROOT_URL.'admin/'.$controller.'/page-1">Start</a></li>';
                    $prev = '<li class="page-item"><a  class="page-link" href="'.ROOT_URL.'admin/'.$controller.'/page-'.($this->currentPage - 1).'">Previous</a></li>';
                }

                $next = '<li class="page-item"><span class="page-link">Next</span></li>';
                $end = '<li class="page-item"><span class="page-link">End</span></li>';
                if($this->currentPage < $this->totalPage){
                    $next = '<li class="page-item"><a class="page-link" href="'.ROOT_URL.'admin/'.$controller.'/page-'.($this->currentPage + 1).'">Next</a></li>';
                    $end = '<li class="page-item"><a class="page-link" a href="'.ROOT_URL.'admin/'.$controller.'/page-'.$this->totalPage.'">End</a></li>';
                }

                if($this->pageRange < $this->totalPage){
                    // $currentPage = 1 => hiển thị 1 2 3
                    if($this->currentPage == 1){
                        $startPage = 1;
                        $endPage = $this->pageRange;
                    }
                    else if($this->currentPage == $this->totalPage){
                        $startPage = $this->totalPage - $this->pageRange + 1;
                        $endPage = $this->totalPage;
                    }
                    else{
                        $startPage = $this->currentPage - ($this->pageRange-1)/2;
                        $endPage = $this->currentPage + ($this->pageRange-1)/2;
                    }
                }
                else{
                    $startPage = 1;
                    $endPage = $this->totalPage;
                }
                $listPages = '';
                for($i = $startPage; $i <= $endPage; $i++){
                    if($i == $this->currentPage){
                        $listPages .= '<li class="page-item" class="page-item"><a class="page-link active-pagination-admin" href="'.ROOT_URL.'admin/'.$controller.'/page-'.$i.'">'.$i.'</a></li>';
                    }
                    else{
                        $listPages .= '<li class="page-item"><a class="page-link" href="'.ROOT_URL.'admin/'.$controller.'/page-'.$i.'">'.$i.'</a></li>';
                    }
                }
                $paginationHTML = '<ul class="pagination">'. $start . $prev .$listPages . $next . $end .'</ul>';
            }
            return $paginationHTML;
        }


        public function showPaginationSite($controller, $action, $options = null){
            $strUrl = '';
            if($controller == 'book'){
                $strUrl = ROOT_URL . 'list/'.$options['name'].'-'.$options['category_id'];
            }

            $keyword = '';
            if($controller == 'index' && $action == 'search'){
                $strUrl = ROOT_URL .$action;
                $keyword = "/keyword=".$options['keyword'];
            }
            $paginationHTML = '';
            if($this->totalPage > 1){
                $start = '<li><span class="single-btn prev-btn">Start</span></li>';
                $prev = '<li><span class="single-btn prev-btn">Prev</span></li>';
                if($this->currentPage > 1){
                    $start = '<li><a href="'.$strUrl.'/page-1'. '/'.$keyword.'" class="single-btn prev-btn btn-pagination">Start</a>';
                    $prev = '<li><a href="'.$strUrl.'/page-'.($this->currentPage - 1).$keyword.'" class="single-btn prev-btn ">Prev</a>';
                }

                $next = '<li><span class="single-btn prev-btn">Next</span></li>';
                $end = '<li><span class="single-btn prev-btn">End</span></li>';
                if($this->currentPage < $this->totalPage){
                    $next = '<li><a href="'.$strUrl.'/page-'.($this->currentPage + 1).$keyword.'" class="single-btn prev-btn ">Next</a>';
                    $end = '<li><a href="'.$strUrl.'/page-'.$this->totalPage. $keyword.'" class="single-btn prev-btn ">End</a>';
                }

                if($this->pageRange < $this->totalPage){
                    // $currentPage = 1 => hiển thị 1 2 3
                    if($this->currentPage == 1){
                        $startPage = 1;
                        $endPage = $this->pageRange;
                    }
                    else if($this->currentPage == $this->totalPage){
                        $startPage = $this->totalPage - $this->pageRange + 1;
                        $endPage = $this->totalPage;
                    }
                    else{
                        $startPage = $this->currentPage - ($this->pageRange-1)/2;
                        $endPage = $this->currentPage + ($this->pageRange-1)/2;
                    }
                }
                else{
                    $startPage = 1;
                    $endPage = $this->totalPage;
                }
                $listPages = '';
                for($i = $startPage; $i <= $endPage; $i++){
                    if($i == $this->currentPage){
                        // '<li class="active"><a href="'.$strUrl.'/page-'.$i.'" class="single-btn">'.$i.'</a></li>';
                        $listPages .= '<li class="active"><a href="'.$strUrl.'/page-'.$i.$keyword.'" class="single-btn">'.$i.'</a></li>';
                    }
                    else{
                        $listPages .='<li class=""><a href="'.$strUrl.'/page-'.$i.$keyword.'" class="single-btn">'.$i.'</a></li>';
                    }
                }
                $paginationHTML = ' <div class="pagination-block">
                                        <ul class="pagination-btns flex-center">'. $start . $prev .$listPages . $next . $end .'</ul>
                                    </div>';
            }
            return $paginationHTML;
        }
    }
?>