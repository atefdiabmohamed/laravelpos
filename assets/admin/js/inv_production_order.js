$(document).ready(function () {



  $(document).on('click', '.show_more_detials', function (e) {
    var id = $(this).data("id");
    var token_search = $("#token_search").val();
    var ajax_search_url = $("#ajax_show_more_detials_url").val();

    jQuery.ajax({
      url: ajax_search_url,
      type: 'post',
      dataType: 'html',
      cache: false,
      data: { id: id, "_token": token_search, id: id },
      success: function (data) {
        $("#show_more_detialsModalBody").html(data);
        $("#show_more_detialsModal").modal("show");
  

      },
      error: function () {

      }
    });

  });


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
        



});