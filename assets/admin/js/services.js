$(document).ready(function() {
    $(document).on('input', '#search_by_text', function(e) {
        make_search();
    });
    $(document).on('change', '#type_search', function(e) {
        make_search();
    });

    function make_search() {
        var search_by_text = $("#search_by_text").val();
        var type_search = $("#type_search").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                search_by_text: search_by_text,
                type_search: type_search,
                "_token": token_search
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    }
    $(document).on('click', '#ajax_pagination_in_search a ', function(e) {
        e.preventDefault();
        var search_by_text = $("#search_by_text").val();
        var type_search = $("#type_search").val();
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                search_by_text: search_by_text,
                type_search: type_search,
                "_token": token_search
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });
});