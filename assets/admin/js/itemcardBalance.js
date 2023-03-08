$(document).ready(function() {
  $(document).on('change', '#item_code_search', function(e) {
      make_search();
  });
  $(document).on('change', '#store_id_search', function(e) {
      make_search();
  });
  $(document).on('change', '#BatchStatusSerach', function(e) {
      make_search();
  });
  $(document).on('change', '#BatchTypeSerach', function(e) {
      make_search();
  });
  $(document).on('change', '#BatchquantitystatusSerach', function(e) {
      if ($(this).val() == "all") {
          make_search();
      } else {
          var BatchquantitySerach = $("#BatchquantitySerach").val();
          if (BatchquantitySerach != "") {
              make_search();
          }
      }
  });
  $(document).on('input', '#BatchquantitySerach', function(e) {
      make_search();
  });
  $(document).on('change', '#BatchquantitystatusSerach', function(e) {
      if ($(this).val() == "all") {
          $("#BatchquantitySerachDiv").hide();
          $("#BatchquantitySerach").val("");
      } else {
          $("#BatchquantitySerachDiv").show();
          $("#BatchquantitySerach").val("");
      }
  });

  function make_search() {
      var item_code_search = $("#item_code_search").val();
      var store_id_search = $("#store_id_search").val();
      var BatchStatusSerach = $("#BatchStatusSerach").val();
      var BatchquantitystatusSerach = $("#BatchquantitystatusSerach").val();
      var BatchquantitySerach = $("#BatchquantitySerach").val();
      var BatchTypeSerach = $("#BatchTypeSerach").val();
      var token_post = $("#token_post").val();
      var ajax_search_url = $("#ajax_url_ajax_search").val();
      jQuery.ajax({
          url: ajax_search_url,
          type: 'post',
          dataType: 'html',
          cache: false,
          data: {
              item_code: item_code_search,
              store_id: store_id_search,
              BatchStatus: BatchStatusSerach,
              BatchTypeSerach: BatchTypeSerach,
              BatchquantitySerach: BatchquantitySerach,
              BatchquantitystatusSerach: BatchquantitystatusSerach,
              "_token": token_post
          },
          success: function(data) {
              $("#ajax_responce_serarchDiv").html(data);
          },
          error: function() {}
      });
  }
  $(document).on('click', '#ajax_pagination_in_search a ', function(e) {
      e.preventDefault();
      var item_code_search = $("#item_code_search").val();
      var store_id_search = $("#store_id_search").val();
      var BatchStatusSerach = $("#BatchStatusSerach").val();
      var BatchquantitystatusSerach = $("#BatchquantitystatusSerach").val();
      var BatchquantitySerach = $("#BatchquantitySerach").val();
      var BatchTypeSerach = $("#BatchTypeSerach").val();
      var url = $(this).attr("href");
      jQuery.ajax({
          url: url,
          type: 'post',
          dataType: 'html',
          cache: false,
          data: {
              item_code: item_code_search,
              store_id: store_id_search,
              BatchStatus: BatchStatusSerach,
              BatchTypeSerach: BatchTypeSerach,
              BatchquantitySerach: BatchquantitySerach,
              BatchquantitystatusSerach: BatchquantitystatusSerach,
              "_token": token_post
          },
          success: function(data) {
              $("#ajax_responce_serarchDiv").html(data);
          },
          error: function() {}
      });
  });
});