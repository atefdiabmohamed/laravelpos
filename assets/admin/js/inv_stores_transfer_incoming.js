$(document).ready(function() {
    $(document).on('click', '.ajax_load_cancel_one_details', function(e) {
    
        var id = $(this).data("id");
        var autoserailparent = $("#autoserailparent").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_load_cancel_one_details").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                autoserailparent: autoserailparent,
                "_token": token_search,
                id: id
            },
            success: function(data) {
                $("#load_cancel_one_details_body").html(data);
                $("#load_cancel_one_details").modal("show");
            },
            error: function() {}
        });
    });
});