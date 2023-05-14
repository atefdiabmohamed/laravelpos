$(document).ready(function() {
    

    function make_search() {
        var token = $("#token_search").val();
        var account_number = $("#account_number_search").val();
        var mov_type = $("#mov_type_search").val();
        var treasuries = $("#treasuries_search").val();
        var admins = $("#admins_search").val();
        var from_date = $("#from_date_search").val();
        var to_date = $("#to_date_search").val();
        var search_by_text = $("#search_by_text").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var url = $("#ajax_url_ajax_search").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                account_number: account_number,
                mov_type: mov_type,
                treasuries: treasuries,
                admins: admins,
                from_date: from_date,
                to_date: to_date,
                searchbyradio: searchbyradio,
                search_by_text: search_by_text
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
        var account_number = $("#account_number_search").val();
        var mov_type = $("#mov_type_search").val();
        var treasuries = $("#treasuries_search").val();
        var admins = $("#admins_search").val();
        var from_date = $("#from_date_search").val();
        var to_date = $("#to_date_search").val();
        var search_by_text = $("#search_by_text").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                account_number: account_number,
                mov_type: mov_type,
                treasuries: treasuries,
                admins: admins,
                from_date: from_date,
                to_date: to_date,
                searchbyradio: searchbyradio,
                search_by_text: search_by_text
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });

    $(document).on('click', '.review_now', function(e) {
     var id=$(this).data("id");
     var token = $("#token_search").val();
     var url = $("#ajax_review_now_url").val();
     jQuery.ajax({
        url: url,
        type: 'post',
        dataType: 'html',
        cache: false,
        data: {
            "_token": token,
            id: id,
        },
        success: function(data) {
            $("#reviewModalBody").html(data);
            $("#reviewModal").modal("show");


        },
        error: function() {}
    });

    });
    
    $(document).on('input', '#what_realy_delivered', function(e) {
var what_realy_delivered=$(this).val();
if(what_realy_delivered==0) {what_realy_delivered=0};
money_should_deviled=parseFloat(money_should_deviled);
var money_should_deviled=parseFloat($("#money_should_deviled").val());
if(money_should_deviled>what_realy_delivered){
    var money_state_value=money_should_deviled-what_realy_delivered;
    $("#money_state").val(1);
    $("#money_state_value").val(money_state_value*1);
    $("#money_state_valueLablel").text(" يوجد عجز نقدية بقيمة  ");
    $("#money_state_valueDiv").show();
}else if(money_should_deviled<what_realy_delivered){
    var money_state_value=what_realy_delivered-money_should_deviled;
    $("#money_state").val(2);
    $("#money_state_value").val(money_state_value*1);
    $("#money_state_valueLablel").text(" يوجد زيادة نقدية بقيمة  ");
    $("#money_state_valueDiv").show();
}else{
    $("#money_state").val(0);
    $("#money_state_value").val(0);
    $("#money_state_valueLablel").text(" حالة اتزان ولايوجد زيادة او عجز بالنقدية ");
    $("#money_state_valueDiv").show();
}

    }); 
    $(document).on('change', '#money_state', function(e) {
        var what_realy_delivered=$("#what_realy_delivered").val();
        if(what_realy_delivered==0) {what_realy_delivered=0};
        money_should_deviled=parseFloat(money_should_deviled);
        var money_should_deviled=parseFloat($("#money_should_deviled").val());
        if(money_should_deviled>what_realy_delivered){
            var money_state_value=money_should_deviled-what_realy_delivered;
            $("#money_state").val(1);
            $("#money_state_value").val(money_state_value*1);
            $("#money_state_valueLablel").text(" يوجد عجز نقدية بقيمة  ");
            $("#money_state_valueDiv").show();
        }else if(money_should_deviled<what_realy_delivered){
            var money_state_value=what_realy_delivered-money_should_deviled;
            $("#money_state").val(2);
            $("#money_state_value").val(money_state_value*1);
            $("#money_state_valueLablel").text(" يوجد زيادة نقدية بقيمة  ");
            $("#money_state_valueDiv").show();
        }else{
            $("#money_state").val(0);
            $("#money_state_value").val(0);
            $("#money_state_valueLablel").text(" حالة اتزان ولايوجد زيادة او عجز بالنقدية ");
            $("#money_state_valueDiv").show();
        }
             
    });
});