$(document).ready(function() {
    $(document).on('click', '.show_more_detials', function(e) {
        var id = $(this).data("id");
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_show_more_detials_url").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                id: id,
                "_token": token_search,
                id: id
            },
            success: function(data) {
                $("#show_more_detialsModalBody").html(data);
                $("#show_more_detialsModal").modal("show");
            },
            error: function() {}
        });
    });
    $(document).on('input', '#search_by_text', function(e) {
        make_search();
    });
    $(document).on('change', '#close_search', function(e) {
        make_search();
    });
    $(document).on('change', '#approve_search', function(e) {
        make_search();
    });
    $(document).on('change', '#from_date_search', function(e) {
        make_search();
    });
    $(document).on('change', '#to_date_search', function(e) {
        make_search();
    });

    function make_search() {
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        var search_by_text = $("#search_by_text").val();
        var close_search = $("#close_search").val();
        var approve_search = $("#approve_search").val();
        var from_date_search = $("#from_date_search").val();
        var to_date_search = $("#to_date_search").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search,
                ajax_search_url: ajax_search_url,
                search_by_text: search_by_text,
                close_search: close_search,
                approve_search: approve_search,
                from_date_search: from_date_search,
                to_date_search: to_date_search
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    }
    $(document).on('click', '#ajax_pagination_in_search a ', function(e) {
        e.preventDefault();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        var search_by_text = $("#search_by_text").val();
        var close_search = $("#close_search").val();
        var approve_search = $("#approve_search").val();
        var from_date_search = $("#from_date_search").val();
        var to_date_search = $("#to_date_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search,
                ajax_search_url: ajax_search_url,
                search_by_text: search_by_text,
                close_search: close_search,
                approve_search: approve_search,
                from_date_search: from_date_search,
                to_date_search: to_date_search
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });
});