$(document).ready(function () {

    $(document).on('change', '#item_code', function (e) {
        var item_code = $(this).val();
        if (item_code != "") {
          var token_search = $("#token_search").val();
          var ajax_get_item_uoms_url = $("#ajax_get_item_uoms").val();
          jQuery.ajax({
            url: ajax_get_item_uoms_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { item_code: item_code, "_token": token_search },
            success: function (data) {
    
              $("#UomDiv").html(data);
              $("#UomDiv").show();
            
            },
            error: function () {
                $("#UomDiv").hide();
    
              alert("حدث خطاما");
            }
          });
    
        } else {
            $("#UomDiv").hide();
    
        }
    
    
      });
    
    
      $(document).on('click', '#LoadModalAddBtn', function (e) {
        var token_search = $("#token_search").val();
        var url = $("#ajax_get_load_modal_add").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {  "_token": token_search },
            success: function (data) {
    
              $("#AddNewInvoiceModalBody").html(data);
              $("#AddNewInvoiceModal").modal("show");
            
            },
            error: function () {
      
    
              alert("حدث خطاما");
            }
          });


    });


});