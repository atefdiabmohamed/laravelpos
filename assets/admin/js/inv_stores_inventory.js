$(document).ready(function () {

 function make_search(){
  var token_search = $("#token_search").val();
  var ajax_search_url = $("#ajax_search_url").val();
  var searchbyradio=$("input[type=radio][name=searchbyradio]:checked").val();
  var account_number = $("#account_number_search").val();
  var search_by_text = $("#search_by_text").val();
  var is_account_number = $("#is_account_number_search").val();
  var order_date_form = $("#order_date_form").val();
  var order_date_to = $("#order_date_to").val();
  var order_type_search= $("#order_type_search").val();

  jQuery.ajax({
    url: ajax_search_url,
    type: 'post',
    dataType: 'html',
    cache: false,
    data: { "_token": token_search,searchbyradio:searchbyradio,account_number:account_number,
    is_account_number:is_account_number,order_date_form:order_date_form ,
    order_date_to:order_date_to,search_by_text:search_by_text,order_type:order_type_search},
    success: function (data) {
      $("#ajax_responce_serarchDiv").html(data);


    },
    error: function () {

    }
  });
 }


 $(document).on('click','#ajax_pagination_in_search a ',function(e){
  e.preventDefault();
  var searchbyradio=$("input[type=radio][name=searchbyradio]:checked").val();
  var account_number = $("#account_number_search").val();
  var search_by_text = $("#search_by_text").val();
  var is_account_number = $("#is_account_number_search").val();
  var order_date_form = $("#order_date_form").val();
  var order_date_to = $("#order_date_to").val();
  var token_search=$("#token_search").val();
  var order_type_search= $("#order_type_search").val();

  var url=$(this).attr("href");
  
  jQuery.ajax({
    url:url,
    type:'post',
    dataType:'html',
    cache:false,
    data: { "_token": token_search,searchbyradio:searchbyradio,account_number:account_number,
    is_account_number:is_account_number,order_date_form:order_date_form ,order_date_to:order_date_to,
    search_by_text:search_by_text,order_type:order_type_search},
    success:function(data){
   
     $("#ajax_responce_serarchDiv").html(data);
    },
    error:function(){
  
    }
  });
  
  
  
  });




 $(document).on('change', '#account_number_search', function (e) {
make_search();
});

$(document).on('input', '#search_by_text', function (e) {
  make_search();
  });
  $(document).on('change', '#is_account_number_search', function (e) {
    make_search();
    });
    $(document).on('change', '#order_date_form', function (e) {
      make_search();
      });
      $(document).on('change', '#order_date_to', function (e) {
        make_search();
        });
        $('input[type=radio][name=searchbyradio]').change(function() {
          make_search();
        });

        $(document).on('change', '#order_type_search', function (e) {
          make_search();
          });
        



        $(document).on('change', '#is_account_number', function (e) {
       if($(this).val()==1){
$("#account_numberDiv").show();
$("#entity_nameDiv").hide();


       }else if($(this).val()==0){
        $("#account_numberDiv").hide();
        $("#entity_nameDiv").show();
        $("#pill_type").val(1);

       }
       
       else{
        $("#account_numberDiv").hide();
        $("#entity_nameDiv").hide();
        
       }


          });

          $(document).on('change', '#pill_type', function (e) {
var is_account_number=$("#is_account_number").val();
if(is_account_number!=1){
  $("#pill_type").val(1);
}
            
          });

          
          function load_alert_message_modal() {


            $("#alert_message_modal").modal("show");
            setTimeout(function () {
               $('#alert_message_modal').modal('hide')
            }, 1000);
         }


         $(document).on('change', '#does_add_all_items', function (e) {
     
          if($(this).val()==1){
$("#ItemsDiv").hide();
          }else{
            $("#ItemsDiv").show();

          }
          
        });

  $(document).on('click', '#do_add_itmes', function (e) {
var does_add_all_items=$("#does_add_all_items").val();
if(does_add_all_items==0){
  var items_in_store=$("#items_in_store").val();
  if(items_in_store==""){
    alert("من فضلك اختر الصنف");
    e.preventDefault();
    $("#items_in_store").focus();
    return false;
  }
}
      });


      $(document).on('click', '.load_edit_item_details', function (e) {
        var id = $(this).data("id");
        var id_parent_pill = $("#id_parent_pill").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_load_edit_item_details").val();
    
        jQuery.ajax({
          url: ajax_search_url,
          type: 'post',
          dataType: 'html',
          cache: false,
          data: { id_parent_pill: id_parent_pill, "_token": token_search, id: id },
          success: function (data) {
            $("#edit_item_Modal_body").html(data);
            $("#edit_item_Modal").modal("show");
            $("#Add_item_Modal_body").html("");
            $("#Add_item_Modal").modal("hide");
    
          },
          error: function () {
    
          }
        });
    
      });

      
 $(document).on('click', '#EditDetailsItem', function (e) {
   var new_quantity_edit=$("#new_quantity_edit").val();
   if(new_quantity_edit==""){
    alert("عفوا من فضلك ادخل الكمية الدفترية الجديده");
    e.preventDefault();
    $("#new_quantity_edit").focus();
    return false;
   }  
 });

});