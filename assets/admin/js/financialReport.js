$(document).ready(function() {
    $(document).on('change', '#report_type', function(e) {
        if ($(this).val() == 1) {
            $(".relatedDate").hide();
        } else {
            $(".relatedDate").show();
        }
        if ($(this).val() != 1 && $(this).val() != 5) {
            $("#Does_show_itemsDiv").show();
        } else {
            $("#Does_show_itemsDiv").hide();
        }
    });
    $(document).on('change', '#suuplier_code', function(e) {
        if ($(this).val() != '') {
            var startdate = $("#suuplier_code option:selected").data('startdate');
            $("#from_date").val(startdate);
            $("#to_date").val($("#todaydate").val());
        } else {
            $("#from_date").val('');
            $("#to_date").val('');
        }
    });
    $(document).on('change', '#customer_code', function(e) {
        if ($(this).val() != '') {
            var startdate = $("#customer_code option:selected").data('startdate');
            $("#from_date").val(startdate);
            $("#to_date").val($("#todaydate").val());
        } else {
            $("#from_date").val('');
            $("#to_date").val('');
        }
    });
    $(document).on('change', '#delegate_code', function(e) {
        if ($(this).val() != '') {
            var startdate = $("#delegate_code option:selected").data('startdate');
            $("#from_date").val(startdate);
            $("#to_date").val($("#todaydate").val());
        } else {
            $("#from_date").val('');
            $("#to_date").val('');
        }
    });
    $(document).on('input', '#searchbytextforcustomer', function(e) {
        var searchtext = $(this).val();
        var token = $("#token_search").val();
        var url = $("#ajax_searchforcustomer").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                searchtext: searchtext
            },
            success: function(data) {
                $("#searchbytextforcustomerDiv").html(data);
                var customer_code = $("#customer_code").val();
                if ($(customer_code != '')) {
                    var startdate = $("#customer_code option:selected").data('startdate');
                    $("#from_date").val(startdate);
                    $("#to_date").val($("#todaydate").val());
                } else {
                    $("#from_date").val('');
                    $("#to_date").val('');
                }
            },
            error: function() {}
        });
    });
});