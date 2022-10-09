function getUrlVar(key){
    var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search);
    return result && unescape(result[1]) || "";
}

// https://bookstoreq.herokuapp.com
// root url localhost
// var rootUrl = '/bookstores';
// root url hosting
var rootUrl = '';

$(document).ready(function(){
    $("#btn-register, #btn-login").click(function(){
        $("#siteForm").submit();
    });

    $("#sort-by-list").change(function(){
        val = $(this).val(); 
        if(val != 'default'){
            arrVal = val.split('_'); // asc-name và 3 
            sortBy = arrVal[0];
            categoryId = arrVal[1];
            page = arrVal[2];
    
            dataSend = {'sort_by':sortBy, 'category_id':categoryId, 'page':page};
            link = 'https://bookkg.herokuapp.com/index.php?module=site&controller=book&action=ajaxSortByList';
            $.get(
                link, 
                dataSend, 
                function(data, textStatus){
                    $(".list-product").html(data);
                }
            );
        }   
    });

    // Thêm giỏ hàng
    $(".addToCart").click(function(){
        id = $(this).data("id"); // Lấy id book
        price = $(this).data("price"); 
        link = rootUrl + '/index.php?module=site&controller=cart&action=addToCart';
        dataSend = {'book_id':id, 'price':price};

        $.post(
            link, 
            dataSend, 
            function(data){
                console.log(data);
                $(".text-number").text(data.totalProduct);
                $(".text-price").html(data.totalPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + 'đ <i class="fas fa-chevron-down"></i>');
                alert('Thêm vào giỏ hàng thành công');
            }, 
            'json'
        );

        return false;
    });

    // Xóa sản phẩm trong giỏ hàng
    $(".remove-item-in-cart").click(function(){
        id = $(this).data("id"); // Lấy id book
        link = rootUrl + '/index.php?module=site&controller=cart&action=remove';
        dataSend = {'book_id':id};
        $.post(
            link, 
            dataSend, 
            function(data){
                $(".book-"+data.bookId).hide();
                $(".text-number").text(data.totalProduct);
                $(".text-price").html(data.totalPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + 'đ <i class="fas fa-chevron-down"></i>');
                $(".total-price-order h5").text('TỔNG CỘNG: ' + data.totalPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.") + 'đ');
                if(data.totalPrice == 0){
                    $(".cart-table").empty().html('<h3 class="text-center text-dark">Chưa có sản phẩm nào... :((</h3>');
                }
            }, 
            'json'
        );

        return false;
    });


    // Submit form thanh toán
    $("#order-now").click(function(){
        $("#pay-form").submit();
    });

    // Search web pc
    $(".btn-search").click(function(event){
        event.preventDefault();

        keyword = $("#form-search .keyword").val();
        keyword = keyword.split(' ');
        keyword = keyword.join('+');  

        window.location.replace(rootUrl + '/search/keyword=' + keyword);
    });

    // Search cho mobile
    $(".btn-search-mobile").click(function(event){
        event.preventDefault();

        keyword = $("#form-search-mobile .keyword").val();
        keyword = keyword.split(' ');
        keyword = keyword.join('+');  

        window.location.replace(rootUrl + '/search/keyword=' + keyword);
    });

   
});