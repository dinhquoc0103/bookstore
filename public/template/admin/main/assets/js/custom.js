// root url localhost
// var rootUrl = '/bookstores';
// root url hosting
var rootUrl = '';

function changeStatus(link) {
    $.get(link, function(data, textStatus) {
        if (textStatus == 'success') {
            data = JSON.parse(data);
            var btnStatus = "a#status-" + data.id;
            var btnModified = ".modified-" + data.id;
            var btnModifiedBy = ".modified-by-" + data.id;
            var classRemove = 'fa-check-circle';
            var classAdd = 'fa-times-circle';

            if (data.status == 1) {
                classRemove = 'fa-times-circle';
                classAdd = 'fa-check-circle';
            }

            $(btnStatus).attr('href', "javascript:changeStatus('" + data.link + "')");
            $(btnStatus + " .fa").removeClass(classRemove).addClass(classAdd);
            $(btnModified).text(data.modified);
            $(btnModifiedBy).text(data.modified_by);
        }
    });
}

function changeGroupACP(link) {
    $.get(link, function(data, textStatus) {
        if (textStatus == 'success') {
            // console.log(JSON.parse(data));
            data = JSON.parse(data);
            var btnGroupACP = "a#group-acp-" + data.id;
            var btnModified = ".modified-" + data.id;
            var btnModifiedBy = ".modified-by-" + data.id;
            var classRemove = 'fa-check-circle';
            var classAdd = 'fa-times-circle';

            if (data.group_acp == 1) {
                classRemove = 'fa-times-circle';
                classAdd = 'fa-check-circle';
            }

            $(btnGroupACP).attr('href', "javascript:changeGroupACP('" + data.link + "')");
            $(btnGroupACP + " .fa").removeClass(classRemove).addClass(classAdd);
            $(btnModified).text(data.modified);
            $(btnModifiedBy).text(data.modified_by);
        }
    });
}

function changeSpecial(link) {
    $.get(link, function(data, textStatus) {
        if (textStatus == 'success') {
            // console.log(JSON.parse(data));
            data = JSON.parse(data);
            var btnSpecial = "a#special-" + data.id;
            var btnModified = ".modified-" + data.id;
            var btnModifiedBy = ".modified-by-" + data.id;
            var classRemove = 'fa-check-circle';
            var classAdd = 'fa-times-circle';

            if (data.special == 1) {
                classRemove = 'fa-times-circle';
                classAdd = 'fa-check-circle';
            }

            $(btnSpecial).attr('href', "javascript:changeSpecial('" + data.link + "')");
            $(btnSpecial + " .fa").removeClass(classRemove).addClass(classAdd);
            $(btnModified).text(data.modified);
            $(btnModifiedBy).text(data.modified_by);
        }
    });
}

// Submit form
function submitForm(url){
    $("#adminForm").attr("action", url).submit();
}

$(document).ready(function(){
    // Check tất cả checkbox
    $("input[name=checkall-toggle]").change(function(){
        $("#adminForm input.checkbox").removeAttr('checked');
        if($(this).is(":checked") == true){
            $("#adminForm input.checkbox").attr('checked', 'checked');
        }
    });

    // Đếm số lượng sort order bị thay đổi
    var qtySortOrder = 0; 
    $(".input-sort-order").change(function(){
        qtySortOrder++;
        $("input[name=qty_sort_order]").val(qtySortOrder);
    });

    // Khi filter và sort 
    $("#filter_status, #filter_group_acp, #sort_by, #filter_group_name, #filter_category_name").change(function(){
        $("#adminForm").submit();
    });

    $(".order-status").change(function(){
        var id = $(this).data("id");
        var status = $(this).val();
        $("#adminForm").attr('action', rootUrl + '/index.php?module=admin&controller=order&action=changeOrderStatus&order_status='+status+'&id='+id);
        $("#adminForm").submit();
    });

    // clear keyword
    $(".search-in-table .btn-clear").click(function(){
        $("#filter_search").val('');
        $("#adminForm").submit();
    });

});

CKEDITOR.replace( 'editor1' );

