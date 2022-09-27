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

        recalcualte();
      },
      error: function () {


        alert("حدث خطاما");
      }
    });

  });

  $(document).on('click', '.remove_current_row', function (e) {
 e.preventDefault();
 $(this).closest('tr').remove();
 recalcualte();
  
});

function recalcualte() {
  var total_cost_items = 0;
  $(".item_total_array").each(function(){
    total_cost_items+=parseFloat($(this).val());
  });
 
  if (total_cost_items == "") { total_cost_items = 0; }
  total_cost_items = parseFloat(total_cost_items);
  $("#total_cost_items").val(total_cost_items);
  var tax_percent = $("#tax_percent").val();
  if (tax_percent == "") { tax_percent = 0 };
  tax_percent = parseFloat(tax_percent);

  var tax_value = total_cost_items * tax_percent / 100;
  tax_value = parseFloat(tax_value);
  $("#tax_value").val(tax_value * 1);
  var total_befor_discount = total_cost_items + tax_value;
  $("#total_befor_discount").val(total_befor_discount);
  var discount_type = $("#discount_type").val();
  if (discount_type != "") {
    if (discount_type == 1) {
      var discount_percent = $("#discount_percent").val();
      if (discount_percent == "") { discount_percent = 0; }
      discount_percent = parseFloat(discount_percent);
      var discount_value = total_befor_discount * discount_percent / 100;
      $("#discount_value").val(discount_value * 1);
      var total_cost = total_befor_discount - discount_value;
      $("#total_cost").val(total_cost * 1);

    } else {
      var discount_percent = $("#discount_percent").val();
      if (discount_percent == "") { discount_percent = 0; }
      discount_percent = parseFloat(discount_percent);
      $("#discount_value").val(discount_percent * 1);
      var total_cost = total_befor_discount - discount_percent;
      $("#total_cost").val(total_cost * 1);
    }



  } else {
    $("#discount_value").val(0);
    var total_cost = total_befor_discount;
    $("#total_cost").val(total_cost);

  }
  what_paid = $("#what_paid").val();
  if (what_paid == "") what_paid = 0;
  what_paid = parseFloat(what_paid);
  total_cost = parseFloat(total_cost);
  $what_remain = total_cost - what_paid;
  $("#what_remain").val($what_remain * 1);


}

$(document).on('change', '#pill_type', function (e) {
  var pill_type = $("#pill_type").val();
  var total_cost = $("#total_cost").val();

  if (pill_type == 1) {
    //cash
    $("#what_paid").val(total_cost * 1);
    $("#what_remain").val(0);
    $("#what_paid").attr("readonly", true);
    recalcualte();

  } else {
    //agel
    $("#what_paid").val(0);
    $("#what_remain").val(total_cost * 1);
    $("#what_paid").attr("readonly", false);
    recalcualte();
  }

});

$(document).on('input', '#what_paid', function (e) {

  total_cost = parseFloat($("#total_cost").val());
  treasuries_balance = parseFloat($("#treasuries_balance").val());

  total_cost = parseFloat(total_cost);


  what_paid = $(this).val();
  if (what_paid == "") { what_paid = 0; }
  what_paid = parseFloat(what_paid);
  var pill_type = $("#pill_type").val();
  if (pill_type == 1) {
    //cash
    if (what_paid < total_cost) {
      alert("عفوا يجب ان يكون المبلغ كاملا مدفوع في حالة ان الفاتورة كاش");
      $("#what_paid").val(total_cost);
    }


  } else {
    if (what_paid >= total_cost) {
      alert("عفوا يجب ان لايكون كل المبلغ  مدفوع في حالة ان الفاتورة اجل");
      $("#what_paid").val(0);
    }
  }



  if (what_paid > total_cost) {
    alert("عفوا لايمكن ان يكون المبلغ المدفوع اكبر من  اجمالي الفاتورة");
    $("#what_paid").val(0);
  }
  



  recalcualte();
});


$(document).on('change', '#discount_type', function (e) {
  discount_type = $(this).val();
  if (discount_type == "") {
    $("#discount_percent").val(0);
    $("#discount_value").val(0);

    $("#discount_percent").attr("readonly", true);


  } else {
    $("#discount_percent").attr("readonly", false);

  }
  var discount_percent = $("#discount_percent").val();
  if (discount_percent == "") { discount_percent = 0; }

  if (discount_type == 1) {
    if (discount_percent > 100) {
      alert("عفوا لايمكن ان يكون نسبة الخصم المئوية اكبر من 100 % !!!");
      $("#discount_percent").val(0);
    }

  }


  recalcualte();
});

$(document).on('input', '#discount_percent', function (e) {
  var discount_percent = $(this).val();
  if (discount_percent == "") { discount_percent = 0; }
  var discount_type = $("#discount_type").val();
  if (discount_type == 1) {
    if (discount_percent > 100) {
      alert("عفوا لايمكن ان يكون نسبة الخصم المئوية اكبر من 100 % !!!");
      $("#discount_percent").val(0);
    }

  }

  recalcualte();
});
$(document).on('input', '#tax_percent', function (e) {
  var tax_percent = $(this).val();
  if (tax_percent == "") { tax_percent = 0; }
  if (tax_percent > 100) {
    alert("عفوا لايمكن ان يكون نسبة الضريبة اكبر من 100 % !!!");
    $("#tax_percent").val(0);
  }
  recalcualte();
});




});