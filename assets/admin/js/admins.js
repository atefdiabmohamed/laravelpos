$(document).ready(function() {
    $(document).on('input', '#search_by_name', function(e) {
        make_search();
    });

    $(document).on('change', '#permission_roles_id_search', function(e) {
        make_search();
    });
    function make_search() {
        var token = $("#token_search").val();
        var search_by_name = $("#search_by_name").val();
        var permission_roles_id_search = $("#permission_roles_id_search").val();
    
        var url = $("#ajax_search_url").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                search_by_name: search_by_name,
                permission_roles_id_search: permission_roles_id_search,
               
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    }
    $(document).on('click', '#ajax_pagination_in_search a ', function(e) {
        e.preventDefault();
        var token = $("#token_search").val();
        var search_by_name = $("#search_by_name").val();
        var permission_roles_id_search = $("#permission_roles_id_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                search_by_name: search_by_name,
                permission_roles_id_search: permission_roles_id_search,
               
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });
 
    $(document).on('change', '#checkForupdatePassword', function(e) {
     if($(this).val()==1){
      $("#PasswordDIV").show();
     }else{
        $("#PasswordDIV").hide();

     }
    });
    
});