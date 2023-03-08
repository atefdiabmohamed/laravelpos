$(document).ready(function() {
    $(document).on('change', '#is_parent', function(e) {
        if ($(this).val() == 0) {
            $("#parentDiv").show();
        } else {
            $("#parentDiv").hide();
        }
    });
    $(document).on('change', '#start_balance_status', function(e) {
        if ($(this).val() == "") {
            $("#start_balance").val("");
        } else {
            if ($(this).val() == 3) {
                $("#start_balance").val(0);
            }
        }
    });
    $(document).on('input', '#start_balance', function(e) {
        var start_balance_status = $("#start_balance_status").val();
        if (start_balance_status == "") {
            alert("من فضلك اختر حالة الحساب اولا");
            $(this).val("");
            return false;
        }
        if ($(this).val() == 0 && start_balance_status != 3) {
            alert("يجب ادخال مبلغ اكبر من الصفر");
            $(this).val("");
            return false;
        }
    });
    $(document).on('input', '#search_by_text', function(e) {
        make_search();
    });
    $(document).on('input', '#account_type_search', function(e) {
        make_search();
    });
    $(document).on('input', '#is_parent_search', function(e) {
        make_search();
    });
    $(document).on('input', '#active_search', function(e) {
        make_search();
    });
    $('input[type=radio][name=searchbyradio]').change(function() {
        make_search();
    });

    function make_search() {
        var search_by_text = $("#search_by_text").val();
        var account_type = $("#account_type_search").val();
        var is_parent = $("#is_parent_search").val();
        var active_search = $("#active_search").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                search_by_text: search_by_text,
                "_token": token_search,
                searchbyradio: searchbyradio,
                account_type: account_type,
                is_parent: is_parent,
                active_search: active_search
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
        var account_type = $("#account_type_search").val();
        var is_parent = $("#is_parent_search").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var active_search = $("#active_search").val();
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                search_by_text: search_by_text,
                "_token": token_search,
                searchbyradio: searchbyradio,
                account_type: account_type,
                is_parent: is_parent,
                active_search: active_search
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });
});