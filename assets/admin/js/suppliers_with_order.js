$(document).ready(function() {
    $(document).on('change', '#item_code_add', function(e) {
        var item_code = $(this).val();
        if (item_code != "") {
            var token_search = $("#token_search").val();
            var ajax_get_item_uoms_url = $("#ajax_get_item_uoms_url").val();
            jQuery.ajax({
                url: ajax_get_item_uoms_url,
                type: 'post',
                dataType: 'html',
                cache: false,
                data: {
                    item_code: item_code,
                    "_token": token_search
                },
                success: function(data) {
                    $("#UomDivAdd").html(data);
                    $(".relatied_to_itemCard").show();
                    var type = $("#item_code_add").children('option:selected').data("type");
                    if (type == 2) {
                        $(".relatied_to_date").show();
                    } else {
                        $(".relatied_to_date").hide();
                    }
                    $("#quantity_add").focus();
                },
                error: function() {
                    $(".relatied_to_itemCard").hide();
                    $("#UomDivAdd").html("");
                    $(".relatied_to_date").hide();
                    alert("حدث خطاما");
                }
            });
        } else {
            $(".relatied_to_itemCard").hide();
            $("#UomDivAdd").html("");
            $(".relatied_to_date").hide();
        }
    });
    $(document).on('input', '#quantity_add', function(e) {
        recaluclate_Add();
    });
    $(document).on('input', '#price_add', function(e) {
        recaluclate_Add();
    });



    function make_enter() {
        var item_code_add = $("#item_code_add").val();
        if (item_code_add == "") {
            alert("من فضلك  اختر الصنف");
            $("#item_code_add").focus();
            return false;
        }
        var uom_id_Add = $("#uom_id_Add").val();
        if (uom_id_Add == "") {
            alert("من فضلك  اختر الوحدة");
            $("#uom_id_Add").focus();
            return false;
        }
        var isparentuom = $("#uom_id_Add").children('option:selected').data("isparentuom");
        var quantity_add = $("#quantity_add").val();
        if (quantity_add == "" || quantity_add == 0) {
            alert("من فضلك  ادخل الكمية المستلمة");
            $("#quantity_add").focus();
            return false;
        }
        var price_add = $("#price_add").val();
        if (price_add == "") {
            alert("من فضلك  ادخل سعر الوحدة ");
            $("#quantity_add").focus();
            return false;
        }
        var type = $("#item_code_add").children('option:selected').data("type");
        if (type == 2) {
            var production_date = $("#production_date").val();
            if (production_date == "") {
                alert("من فضلك  اختر تاريخ الانتاج  ");
                $("#production_date").focus();
                return false;
            }
            var expire_date = $("#expire_date").val();
            if (expire_date == "") {
                alert("من فضلك  اختر تاريخ انتهاء الصلاحية  ");
                $("#expire_date").focus();
                return false;
            }
            if (expire_date < production_date) {
                alert("عفوا لايمكن ان يكون تاريخ الانتهاء اقل من تاريخ الانتاج !!!");
                $("#expire_date").focus();
                return false;
            }
        } else {
            var production_date = $("#production_date").val();
            var expire_date = $("#expire_date").val();
        }
        var total_add = $("#total_add").val();
        if (total_add == "") {
            alert("من فضلك  ادخل اجمالي   الاصناف  ");
            $("#total_add").focus();
            return false;
        }
        var autoserailparent = $("#autoserailparent").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_add_new_details").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                autoserailparent: autoserailparent,
                "_token": token_search,
                item_code_add: item_code_add,
                uom_id_Add: uom_id_Add,
                isparentuom: isparentuom,
                quantity_add: quantity_add,
                price_add: price_add,
                production_date: production_date,
                expire_date: expire_date,
                total_add: total_add,
                type: type
            },
            success: function(data) {
                var itemName = $("#item_code_add option:selected").text();
                $("#AddEventMessage").text("تمت اضافة الصنف " + itemName + " بنجاح");
                $("#AddEventMessage").css('color', 'green');
                $("#item_code_add").val(0);
                $(".select2").select2();
                $("#total_add").val(0);
                $("#UomDivAdd").html("");
                $("#UomDivAdd").hide();
                $("#price_add").val("");
                $("#quantity_add").val("");
                $("#item_code_add").select2("open");
                reload_parent_pill();
                reload_itemsdetials();
            },
            error: function() {
                $("#AddEventMessage").text("    عفوا هناك خطأ");
                $("#AddEventMessage").css('color', 'red');
            }
        });
    }
    $(document).on('click', '#AddToBill', function(e) {
        make_enter();
    });
    $(document).on('keyup', '#quantity_add', function(e) {
        if (e.key == "Enter" || e.keycode == 13) {
            if ($(this).val() != '') {
                $("#price_add").focus();
            } else {
                alert("من فضلك ادخل الكمية المستلمة !");
                $("#quantity_add").focus();
                return false;
            }
        }
    });
    $(document).on('keyup', '#price_add', function(e) {
        if (e.key == "Enter" || e.keycode == 13) {
            if ($(this).val() != '') {
                make_enter();
            } else {
                alert("من فضلك ادخل سعر الوحدة  !");
                $("#price_add").focus();
                return false;
            }
        }
    });

    function recaluclate_Add() {
        var quantity_add = $("#quantity_add").val();
        var price_add = $("#price_add").val();
        if (quantity_add == "") quantity_add = 0;
        if (price_add == "") price_add = 0;
        $("#total_add").val(parseFloat(quantity_add) * parseFloat(price_add));
    }

    function recaluclate_edit() {
        var quantity_edit = $("#quantity_edit").val();
        var price_edit = $("#price_edit").val();
        if (quantity_edit == "") quantity_edit= 0;
        if (price_edit == "") price_edit = 0;
        $("#total_edit").val(parseFloat(quantity_edit) * parseFloat(price_edit));
    }

    function reload_itemsdetials() {
        var autoserailparent = $("#autoserailparent").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_reload_itemsdetials").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                autoserailparent: autoserailparent,
                "_token": token_search
            },
            success: function(data) {
                $("#ajax_responce_serarchDivDetails").html(data);
            },
            error: function() {}
        });
    }

    function reload_parent_pill() {
        var autoserailparent = $("#autoserailparent").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_reload_parent_pill").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                autoserailparent: autoserailparent,
                "_token": token_search
            },
            success: function(data) {
                $("#ajax_responce_serarchDivparentpill").html(data);
            },
            error: function() {}
        });
    }
    $(document).on('click', '.load_edit_item_details', function(e) {
        var id = $(this).data("id");
        var autoserailparent = $("#autoserailparent").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_load_edit_item_details").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                autoserailparent: autoserailparent,
                "_token": token_search,
                id: id
            },
            success: function(data) {
                $("#edit_item_Modal_body").html(data);
                $("#edit_item_Modal").modal("show");
                $("#Add_item_Modal_body").html("");
                $("#Add_item_Modal").modal("hide");
                $(".select2").select2();

            },
            error: function() {}
        });
    });
    $(document).on('click', '#load_modal_add_detailsBtn', function(e) {
        var id = $(this).data("id");
        var autoserailparent = $("#autoserailparent").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_load_modal_add_details").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                autoserailparent: autoserailparent,
                "_token": token_search,
                id: id
            },
            success: function(data) {
                $("#Add_item_Modal_body").html(data);
                $("#Add_item_Modal").modal("show");
                $("#edit_item_Modal_body").html("");
                $("#edit_item_Modal").modal("hide");
                $(".select2").select2();
            },
            error: function() {}
        });
    });


    $(document).on('keyup', '#quantity_edit', function(e) {
        if (e.key == "Enter" || e.keycode == 13) {
            if ($(this).val() != '') {
                $("#price_edit").focus();
            } else {
                alert("من فضلك ادخل الكمية المستلمة !");
                $("#quantity_edit").focus();
                return false;
            }
        }
    });
    $(document).on('keyup', '#price_edit', function(e) {
        if (e.key == "Enter" || e.keycode == 13) {
            if ($(this).val() != '') {
                make_enter_edit();
            } else {
                alert("من فضلك ادخل سعر الوحدة  !");
                $("#price_edit").focus();
                return false;
            }
        }
    });
    $(document).on('input', '#quantity_edit', function(e) {
        recaluclate_edit();
    });
    $(document).on('input', '#price_edit', function(e) {
        recaluclate_edit();
    });


    function make_enter_edit(){
        var id = $("#the_row_id_for_update").val();
        var item_code_add = $("#item_code_add").val();
        if (item_code_add == "") {
            alert("من فضلك  اختر الصنف");
            $("#item_code_add").focus();
            return false;
        }
        var uom_id_Add = $("#uom_id_Add").val();
        if (uom_id_Add == "") {
            alert("من فضلك  اختر الوحدة");
            $("#uom_id_Add").focus();
            return false;
        }
        var isparentuom = $("#uom_id_Add").children('option:selected').data("isparentuom");
        var quantity_edit = $("#quantity_edit").val();
        if (quantity_edit == "" || quantity_edit == 0) {
            alert("من فضلك  ادخل الكمية المستلمة");
            $("#quantity_edit").focus();
            return false;
        }
        var price_edit = $("#price_edit").val();
        if (price_edit == "") {
            alert("من فضلك  ادخل سعر الوحدة ");
            $("#price_edit").focus();
            return false;
        }
        var type = $("#item_code_add").children('option:selected').data("type");
        if (type == 2) {
            var production_date = $("#production_date").val();
            if (production_date == "") {
                alert("من فضلك  اختر تاريخ الانتاج  ");
                $("#production_date").focus();
                return false;
            }
            var expire_date = $("#expire_date").val();
            if (expire_date == "") {
                alert("من فضلك  اختر تاريخ انتهاء الصلاحية  ");
                $("#expire_date").focus();
                return false;
            }
            if (expire_date < production_date) {
                alert("عفوا لايمكن ان يكون تاريخ الانتهاء اقل من تاريخ الانتاج !!!");
                $("#expire_date").focus();
                return false;
            }
        } else {
            var production_date = $("#production_date").val();
            var expire_date = $("#expire_date").val();
        }
        var total_edit = $("#total_edit").val();
        if (total_edit == "") {
            alert("من فضلك  ادخل اجمالي   الاصناف  ");
            $("#total_edit").focus();
            return false;
        }
        var autoserailparent = $("#autoserailparent").val();
        var token_search = $("#token_search").val();
        var ajax_url = $("#ajax_edit_item_details").val();
        jQuery.ajax({
            url: ajax_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                autoserailparent: autoserailparent,
                "_token": token_search,
                item_code_add: item_code_add,
                uom_id_Add: uom_id_Add,
                isparentuom: isparentuom,
                quantity_edit: quantity_edit,
                price_edit: price_edit,
                production_date: production_date,
                expire_date: expire_date,
                total_edit: total_edit,
                type: type,
                id: id
            },
            success: function(data) {
                alert("تم النحديث بنجاح");
                reload_parent_pill();
                reload_itemsdetials();
            },
            error: function() {}
        });

        
    }
    $(document).on('click', '#EditDetailsItem', function(e) {
        make_enter_edit();
    
    });
    $(document).on('click', '#load_close_approve_invoice', function(e) {
        var autoserailparent = $("#autoserailparent").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_load_modal_approve_invoice").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                autoserailparent: autoserailparent,
                "_token": token_search
            },
            success: function(data) {
                $("#ModalApproveInvocie_body").html(data);
                $("#ModalApproveInvocie").modal("show");
            },
            error: function() {}
        });
    });
    $(document).on('input', '#tax_percent', function(e) {
        var tax_percent = $(this).val();
        if (tax_percent == "") {
            tax_percent = 0;
        }
        if (tax_percent > 100) {
            alert("عفوا لايمكن ان يكون نسبة الضريبة اكبر من 100 % !!!");
            $("#tax_percent").val(0);
        }
        recalcualte();
    });
    $(document).on('input', '#discount_percent', function(e) {
        var discount_percent = $(this).val();
        if (discount_percent == "") {
            discount_percent = 0;
        }
        var discount_type = $("#discount_type").val();
        if (discount_type == 1) {
            if (discount_percent > 100) {
                alert("عفوا لايمكن ان يكون نسبة الخصم المئوية اكبر من 100 % !!!");
                $("#discount_percent").val(0);
            }
        }
        recalcualte();
    });
    $(document).on('change', '#discount_type', function(e) {
        discount_type = $(this).val();
        if (discount_type == "") {
            $("#discount_percent").val(0);
            $("#discount_value").val(0);
            $("#discount_percent").attr("readonly", true);
        } else {
            $("#discount_percent").attr("readonly", false);
        }
        var discount_percent = $("#discount_percent").val();
        if (discount_percent == "") {
            discount_percent = 0;
        }
        if (discount_type == 1) {
            if (discount_percent > 100) {
                alert("عفوا لايمكن ان يكون نسبة الخصم المئوية اكبر من 100 % !!!");
                $("#discount_percent").val(0);
            }
        }
        recalcualte();
    });
    $(document).on('input', '#what_paid', function(e) {
        total_cost = parseFloat($("#total_cost").val());
        treasuries_balance = parseFloat($("#treasuries_balance").val());
        total_cost = parseFloat(total_cost);
        what_paid = $(this).val();
        if (what_paid == "") {
            what_paid = 0;
        }
        what_paid = parseFloat(what_paid);
        var pill_type = $("#pill_type").val();
        if (pill_type == 1) {
            //cash
            if (what_paid < total_cost) {
                alert("عفوا يجب ان يكون المبلغ كاملا مدفوع في حالة ان الفاتورة كاش");
                $("#what_paid").val(total_cost);
            }
        } else {
            if (what_paid == total_cost) {
                alert("عفوا يجب ان لايكون كل المبلغ  مدفوع في حالة ان الفاتورة اجل");
                $("#what_paid").val(0);
            }
        }
        if (what_paid > total_cost) {
            alert("عفوا لايمكن ان يكون المبلغ المدفوع اكبر من  اجمالي الفاتورة");
            $("#what_paid").val(0);
        }
        if (what_paid > treasuries_balance) {
            alert("عفوا لايوجد رصيد كافي بالخزنة");
            $("#what_paid").val(0);
        }
        recalcualte();
    });
    $(document).on('change', '#pill_type', function(e) {
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

    function recalcualte() {
        var total_cost_items = $("#total_cost_items").val();
        if (total_cost_items == "") {
            total_cost_items = 0;
        }
        total_cost_items = parseFloat(total_cost_items);
        var tax_percent = $("#tax_percent").val();
        if (tax_percent == "") {
            tax_percent = 0
        };
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
                if (discount_percent == "") {
                    discount_percent = 0;
                }
                discount_percent = parseFloat(discount_percent);
                var discount_value = total_befor_discount * discount_percent / 100;
                $("#discount_value").val(discount_value * 1);
                var total_cost = total_befor_discount - discount_value;
                $("#total_cost").val(total_cost * 1);
            } else {
                var discount_percent = $("#discount_percent").val();
                if (discount_percent == "") {
                    discount_percent = 0;
                }
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
    $(document).on('mouseenter', '#do_close_approve_invoice_now', function(e) {
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_load_usershiftDiv").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search
            },
            success: function(data) {
                $("#shiftDiv").html(data);
            },
            error: function() {}
        });
    });
    $(document).on('click', '#do_close_approve_invoice_now', function(e) {
        var total_cost_items = $("#total_cost_items").val();
        if (total_cost_items == "") {
            alert("من فضلك ادخل اجمالي الاصناف");
            return false;
        }
        var tax_percent = $("#tax_percent").val();
        if (tax_percent == "") {
            alert("من فضلك ادخل نسبة ضريبة القيمة المضافة ");
            $("#tax_percent").val();
            return false;
        }
        var tax_value = $("#tax_value").val();
        if (tax_value == "") {
            alert("من فضلك ادخل قيمة ضريبة القيمة المضافة ");
            return false;
        }
        var total_befor_discount = $("#total_befor_discount").val();
        if (total_befor_discount == "") {
            alert("من فضلك ادخل قيمة الاجمالي قبل الخصم   ");
            return false;
        }
        var discount_type = $("#discount_type").val();
        if (discount_type == 1) {
            var discount_percent = $("#discount_percent").val();
            if (discount_percent > 100) {
                alert("عفوا لايمكن ان يكون نسبة الخصم المئوية اكبر من 100 % !!!");
                $("#discount_percent").focus();
                return false;
            }
        } else if (discount_type == 2) {
            var discount_value = $("#discount_value").val();
            if (parseFloat(discount_value) > parseFloat(total_befor_discount)) {
                alert("عفوا لايمكن ان يكون قيمة الخصم اكبر من اجمالي الفاتورة قبل الخصم   !!!");
                $("#discount_value").focus();
                return false;
            }
        } else {
            var discount_value = $("#discount_value").val();
            if (discount_value > 0) {
                alert(" عفوا لايمكن ان يوجد خصم مع اختيارك لنوع الخصم لايوجد  !!!");
                $("#discount_value").focus();
                return false;
            }
        }
        var discount_value = $("#discount_value").val();
        if (discount_value == "") {
            alert("من فضلك ادخل قيمة الخصم     ");
            return false;
        }
        var total_cost = $("#total_cost").val();
        if (total_cost == "") {
            alert("من فضلك ادخل قيمة اجمالي الفاتورة النهائي     ");
            return false;
        }
        var pill_type = $("#pill_type").val();
        if (pill_type == "") {
            alert("من فضلك اختر نوع الفاتورة      ");
            return false;
        }
        var what_paid = $("#what_paid").val();
        var what_remain = $("#what_remain").val();
        var what_paid = $("#what_paid").val();
        if (what_paid == "") {
            alert("من فضلك ادخل المبلغ المدفوع        ");
            return false;
        }
        if (parseFloat(what_paid) > parseFloat(total_cost)) {
            alert("عفوا لايمكن ان يكون المبلغ المصروف اكبر من اجمالي الفاتورة         ");
            return false;
        }
        if (pill_type == 1) {
            if (what_paid < total_cost) {
                alert("عفوا يجب ان يكون كل المبلغ مدفوع في حالة ان الفاتورة كاش       ");
                return false;
            }
        } else {
            if (parseFloat(what_paid) == parseFloat(total_cost)) {
                alert("عفوا لايمكن ان يكون المبلغ المدفوع يساوي اجمالي الفاتورة في حالة ان الفاتورة اجل      ");
                return false;
            }
        }
        var what_remain = $("#what_remain").val();
        if (what_remain == "") {
            alert("من فضلك ادخل المبلغ المتبقي        ");
            return false;
        }
        if (pill_type == 1) {
            if (what_remain > 0) {
                alert("عفوا لايمكن ان يكون المبلغ المتبقي اكبر من الصفر في حالة ان الفاتورة كاش      ");
                return false;
            }
        }
        if (what_paid > 0) {
            var treasuries_id = $("#treasuries_id").val();
            if (treasuries_id == "") {
                alert("من فضلك اختر خزنة الصرف         ");
                return false;
            }
            var treasuries_balance = $("#treasuries_balance").val();
            if (treasuries_balance == "") {
                alert("من فضلك  ادخل رصيد الخزنة          ");
                return false;
            }
            if (parseFloat(what_paid) > parseFloat(treasuries_balance)) {
                alert("عفوا لايوجد لديك رصيد كافي في خزنة الصرف !!!");
                return false;
            }
        }
    });

    function make_search() {
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var suuplier_code = $("#suuplier_code_search").val();
        var search_by_text = $("#search_by_text").val();
        var store_id = $("#store_id_search").val();
        var order_date_form = $("#order_date_form").val();
        var order_date_to = $("#order_date_to").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search,
                searchbyradio: searchbyradio,
                suuplier_code: suuplier_code,
                store_id: store_id,
                order_date_form: order_date_form,
                order_date_to: order_date_to,
                search_by_text: search_by_text
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    }
    $(document).on('click', '#ajax_pagination_in_search a ', function(e) {
        e.preventDefault();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var suuplier_code = $("#suuplier_code_search").val();
        var search_by_text = $("#search_by_text").val();
        var store_id = $("#store_id_search").val();
        var order_date_form = $("#order_date_form").val();
        var order_date_to = $("#order_date_to").val();
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search,
                searchbyradio: searchbyradio,
                suuplier_code: suuplier_code,
                store_id: store_id,
                order_date_form: order_date_form,
                order_date_to: order_date_to,
                search_by_text: search_by_text
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });
    $(document).on('change', '#suuplier_code_search', function(e) {
        make_search();
    });
    $(document).on('input', '#search_by_text', function(e) {
        make_search();
    });
    $(document).on('change', '#store_id_search', function(e) {
        make_search();
    });
    $(document).on('change', '#order_date_form', function(e) {
        make_search();
    });
    $(document).on('change', '#order_date_to', function(e) {
        make_search();
    });
    $('input[type=radio][name=searchbyradio]').change(function() {
        make_search();
    });
});