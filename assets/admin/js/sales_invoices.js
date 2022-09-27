$(document).ready(function () {

  $(document).on('change', '#item_code', function (e) {
    //نجلب اولا الوحدات للصنف
    get_item_uoms();

  });

  $(document).on('change', '#sales_item_type', function (e) {
    get_item_unit_price();

  });
  $(document).on('input', '#item_quantity', function (e) {
    recalculate_itemTotlaRow();

  });
  $(document).on('input', '#item_price', function (e) {
    recalculate_itemTotlaRow();

  });




  function get_item_unit_price() {
    var item_code = $("#item_code").val();
    var uom_id = $("#uom_id").val();
    var sales_item_type = $("#sales_item_type").val();
    var token = $("#token_search").val();
    var url = $("#ajax_get_item_unit_price").val();
    jQuery.ajax({
      url: url,
      type: 'post',
      dataType: 'json',
      cache: false,
      data: { item_code: item_code, uom_id: uom_id, sales_item_type: sales_item_type, "_token": token },
      success: function (data) {
        $("#item_price").val(data * 1);
        recalculate_itemTotlaRow();
      },
      error: function () {
        $("#item_price").val("");

        alert("حدث خطاما");
      }
    });

  }


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
  function get_inv_itemcard_batches() {
    var item_code = $("#item_code").val();
    var uom_id = $("#uom_id").val();

    var store_id = $("#store_id").val();

    if (item_code != "" && uom_id != "" && store_id != "") {
      var token_search = $("#token_search").val();
      var url = $("#ajax_get_item_batches").val();
      jQuery.ajax({
        url: url,
        type: 'post',
        dataType: 'html',
        cache: false,
        data: { item_code: item_code, uom_id: uom_id, store_id: store_id, "_token": token_search },
        success: function (data) {
          $("#inv_itemcard_batchesDiv").html(data);
          $("#inv_itemcard_batchesDiv").show();
          get_item_unit_price();

        },
        error: function () {
          $("#inv_itemcard_batchesDiv").hide();


        }
      });



    } else {
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
      data: { "_token": token_search },
      success: function (data) {

        $("#AddNewInvoiceModalBody").html(data);
        $("#AddNewInvoiceModal").modal("show");

      },
      error: function () {


        alert("حدث خطاما");
      }
    });


  });

  function recalculate_itemTotlaRow() {
    var item_quantity = $("#item_quantity").val();
    if (item_quantity == "") item_quantity = 0;
    var item_price = $("#item_price").val();
    if (item_price == "") item_price = 0;
    $("#item_total").val((parseFloat(item_quantity) * parseFloat(item_price)) * 1);

  }

  $(document).on('click', '#AddItemToIvoiceDetailsRow', function (e) {
    var store_id = $("#store_id").val();
    if (store_id == "") {
      alert("من فضلك اختر المخزن ");
      $("#store_id").focus();
      return false;
    }

    var sales_item_type = $("#sales_item_type").val();
    if (sales_item_type == "") {
      alert("من فضلك اختر نوع البيع ");
      $("#sales_item_type").focus();
      return false;
    }

    var item_code = $("#item_code").val();
    if (item_code == "") {
      alert("من فضلك اختر  الصنف ");
      $("#item_code").focus();
      return false;
    }

    var uom_id = $("#uom_id").val();
    if (uom_id == "") {
      alert("من فضلك اختر  وحدة البيع ");
      $("#uom_id").focus();
      return false;
    }
    var inv_itemcard_batches_id = $("#inv_itemcard_batches_id").val();
    if (inv_itemcard_batches_id == "") {
      alert("من فضلك اختر  الباتش ");
      $("#inv_itemcard_batches_id").focus();
      return false;
    }
    var item_quantity = $("#item_quantity").val();
    if (item_quantity == "") {
      alert("من فضلك  ادخل الكمية ");
      $("#item_quantity").focus();
      return false;
    }
    if (parseFloat(item_quantity) > parseFloat(inv_itemcard_batches_id)) {
      alert("عفوا الكمية المطلوبة اكبر من كمية الباتش  الموجوده بالمخزن");
      return false;
    }
    var item_price = $("#item_price").val();
    if (item_price == "") {
      alert("من فضلك ادخل  السعر ");
      $("#item_price").focus();
      return false;
    }

    var is_normal_orOther = $("#is_normal_orOther").val();
    if (is_normal_orOther == "") {
      alert("من فضلك اختر هل بيع عادي ؟   ");
      $("#is_normal_orOther").focus();
      return false;
    }

    var item_total = $("#item_total").val();
    if (item_total == "") {
      alert("من فضلك  حقل الاجمالي مطلوب ! ");
      $("#item_total").focus();
      return false;
    }

    var store_name = $("#store_id option:selected").text();
    var uom_id_name = $("#uom_id option:selected").text();
    var item_code_name = $("#item_code option:selected").text();
    var sales_item_type_name = $("#sales_item_type option:selected").text();
    var is_normal_orOther_name = $("#is_normal_orOther option:selected").text();
    var isparentuom = $("#uom_id option:selected").data("isparentuom");

    var token_search = $("#token_search").val();
    var url = $("#ajax_get_Add_new_item_row").val();
    jQuery.ajax({
      url: url,
      type: 'post',
      dataType: 'html',
      cache: false,
      data: {
        "_token": token_search, store_id: store_id, sales_item_type: sales_item_type, item_code: item_code,
        uom_id: uom_id, inv_itemcard_batches_id: inv_itemcard_batches_id, item_quantity: item_quantity, item_price: item_price,
        is_normal_orOther: is_normal_orOther, item_total: item_total, store_name: store_name, uom_id_name: uom_id_name,
        sales_item_type_name: sales_item_type_name, is_normal_orOther_name: is_normal_orOther_name, isparentuom: isparentuom, item_code_name: item_code_name
      },
      success: function (data) {

        $("#itemsrowtableContainterBody").append(data);


      },
      error: function () {


        alert("حدث خطاما");
      }
    });

  });

  $(document).on('click', '.remove_current_row', function (e) {
 e.preventDefault();
 $(this).closest('tr').remove();
  
});

});