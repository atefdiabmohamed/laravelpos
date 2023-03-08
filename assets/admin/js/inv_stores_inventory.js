$(document).ready(function() {
    function make_search() {
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        var search_by_text = $("#search_by_text").val();
        var order_date_form = $("#order_date_form").val();
        var order_date_to = $("#order_date_to").val();
        var is_closed_search = $("#is_closed_search").val();
        var store_id_search = $("#store_id_search").val();
        var inventory_type_search = $("#inventory_type_search").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search,
                order_date_form: order_date_form,
                order_date_to: order_date_to,
                search_by_text: search_by_text,
                is_closed_search: is_closed_search,
                store_id_search: store_id_search,
                inventory_type_search: inventory_type_search
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
        var order_date_form = $("#order_date_form").val();
        var order_date_to = $("#order_date_to").val();
        var is_closed_search = $("#is_closed_search").val();
        var store_id_search = $("#store_id_search").val();
        var inventory_type_search = $("#inventory_type_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search,
                order_date_form: order_date_form,
                order_date_to: order_date_to,
                search_by_text: search_by_text,
                is_closed_search: is_closed_search,
                store_id_search: store_id_search,
                inventory_type_search: inventory_type_search
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });
    $(document).on('input', '#search_by_text', function(e) {
        make_search();
    });
    $(document).on('change', '#store_id_search', function(e) {
        make_search();
    });
    $(document).on('change', '#order_date_form', function(e) {
        make_search();
    });
    $(document).on('change', '#order_date_to', function(e) {
        make_search();
    });
    $(document).on('change', '#is_closed_search', function(e) {
        make_search();
    });
    $(document).on('change', '#inventory_type_search', function(e) {
        make_search();
    });

    function load_alert_message_modal() {
        $("#alert_message_modal").modal("show");
        setTimeout(function() {
            $('#alert_message_modal').modal('hide')
        }, 1000);
    }
    $(document).on('change', '#does_add_all_items', function(e) {
        if ($(this).val() == 1) {
            $("#ItemsDiv").hide();
        } else {
            $("#ItemsDiv").show();
        }
    });
    $(document).on('click', '#do_add_itmes', function(e) {
        var does_add_all_items = $("#does_add_all_items").val();
        if (does_add_all_items == 0) {
            var items_in_store = $("#items_in_store").val();
            if (items_in_store == "") {
                alert("من فضلك اختر الصنف");
                e.preventDefault();
                $("#items_in_store").focus();
                return false;
            }
        }
    });
    $(document).on('click', '.load_edit_item_details', function(e) {
        var id = $(this).data("id");
        var id_parent_pill = $("#id_parent_pill").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_load_edit_item_details").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                id_parent_pill: id_parent_pill,
                "_token": token_search,
                id: id
            },
            success: function(data) {
                $("#edit_item_Modal_body").html(data);
                $("#edit_item_Modal").modal("show");
                $("#Add_item_Modal_body").html("");
                $("#Add_item_Modal").modal("hide");
            },
            error: function() {}
        });
    });
    $(document).on('click', '#EditDetailsItem', function(e) {
        var new_quantity_edit = $("#new_quantity_edit").val();
        if (new_quantity_edit == "") {
            alert("عفوا من فضلك ادخل الكمية الدفترية الجديده");
            e.preventDefault();
            $("#new_quantity_edit").focus();
            return false;
        }
    });
});