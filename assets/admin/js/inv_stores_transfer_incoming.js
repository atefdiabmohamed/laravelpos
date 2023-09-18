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
    function make_search() {
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var search_by_text = $("#search_by_text").val();
        var transfer_from_store_id_search = $("#transfer_from_store_id_search").val();
        var transfer_to_store_id_search = $("#transfer_to_store_id_search").val();
        var order_date_form = $("#order_date_form").val();
        var order_date_to = $("#order_date_to").val();
        var is_approved = $("#is_approved_serach").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search,
                searchbyradio: searchbyradio,
                transfer_from_store_id_search: transfer_from_store_id_search,
                transfer_to_store_id_search: transfer_to_store_id_search,
                order_date_form: order_date_form,
                order_date_to: order_date_to,
                search_by_text: search_by_text,
                is_approved: is_approved
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
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var search_by_text = $("#search_by_text").val();
        var transfer_from_store_id_search = $("#transfer_from_store_id_search").val();
        var transfer_to_store_id_search = $("#transfer_to_store_id_search").val();
        var order_date_form = $("#order_date_form").val();
        var order_date_to = $("#order_date_to").val();
        var is_approved = $("#is_approved_serach").val();
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
              "_token": token_search,
              searchbyradio: searchbyradio,
              transfer_from_store_id_search: transfer_from_store_id_search,
              transfer_to_store_id_search: transfer_to_store_id_search,
              order_date_form: order_date_form,
              order_date_to: order_date_to,
              search_by_text: search_by_text,
              is_approved: is_approved
          },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });
    $(document).on('change', '#transfer_from_store_id_search', function(e) {
        make_search();
    });
    $(document).on('input', '#search_by_text', function(e) {
        make_search();
    });
    $(document).on('change', '#transfer_to_store_id_search', function(e) {
        make_search();
    });
    $(document).on('change', '#order_date_form', function(e) {
        make_search();
    });
    $(document).on('change', '#order_date_to', function(e) {
        make_search();
    });
    $('input[type=radio][name=searchbyradio]').change(function() {
        make_search();
    });
    $(document).on('change', '#is_approved_serach', function(e) {
        make_search();
    });
});