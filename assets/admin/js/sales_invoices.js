$(document).ready(function () {

    $(document).on('change', '#item_code', function (e) {
        //نجلب اولا الوحدات للصنف
        get_item_uoms();
    
    
      });
    
function get_item_uoms() {
  var item_code = $("#item_code").val();
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
 //ثانيا  الكميات بالباتشات للصنف

       get_inv_itemcard_batches();


            
            },
            error: function () {
                $("#UomDiv").hide();
    
              alert("حدث خطاما");
            }
          });
    
        } else {
          $("#UomDiv").html("");
            $("#UomDiv").hide();
            $("#inv_itemcard_batchesDiv").html("");
            $("#inv_itemcard_batchesDiv").hide();
        }
}

//جلب كميات الصنف من المخزن بالباتشات وترتيبهم حسب نوع الصنف
function get_inv_itemcard_batches(){
  var item_code = $("#item_code").val();
  var uom_id = $("#uom_id").val();

  var store_id=$("#store_id").val();

  if (item_code != "" && uom_id!=""&& store_id!="") {
var token_search = $("#token_search").val();
var url = $("#ajax_get_item_batches").val();
jQuery.ajax({
  url: url,
  type: 'post',
  dataType: 'html',
  cache: false,
  data: { item_code: item_code,uom_id:uom_id,store_id:store_id, "_token": token_search },
  success: function (data) {
    $("#inv_itemcard_batchesDiv").html(data);
    $("#inv_itemcard_batchesDiv").show();
  
  },
  error: function () {
      $("#inv_itemcard_batchesDiv").hide();

 
  }
});



  }else{
    $("#UomDiv").hide(); 
    $("#inv_itemcard_batchesDiv").hide();

  }


}

$(document).on('change', '#uom_id', function (e) {
  get_inv_itemcard_batches();
});

$(document).on('change', '#store_id', function (e) {
  get_inv_itemcard_batches();
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