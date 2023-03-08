$(document).ready(function() {
    $(document).on('change', '#item_code', function(e) {
        //نجلب اولا الوحدات للصنف
        get_item_uoms();
    });
    $(document).on('change', '#sales_item_type', function(e) {
        get_item_unit_price();
    });
    $(document).on('input', '#item_quantity', function(e) {
        recalculate_itemTotlaRow();
    });
    $(document).on('input', '#item_price', function(e) {
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
            data: {
                item_code: item_code,
                uom_id: uom_id,
                sales_item_type: sales_item_type,
                "_token": token
            },
            success: function(data) {
                $("#item_price").val(data * 1);
                recalculate_itemTotlaRow();
            },
            error: function() {
                $("#item_price").val("");
            }
        });
    }

    function get_item_uoms() {
        var item_code = $("#item_code").val();
        if (item_code != "") {
            $("#unit_cost_priceDiv").show();
            var item_type = $("#item_code option:selected").data("item_type");
            if (item_type == 2) {
                $(".relatedtoDateproExp").show();
            } else {
                $(".relatedtoDateproExp").hide();
            }
            var token_search = $("#token_search").val();
            var ajax_get_item_uoms_url = $("#ajax_get_item_uoms").val();
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
                    $("#UomDiv").html(data);
                    $("#UomDiv").show();
                    //ثانيا  الكميات بالباتشات للصنف
                    get_inv_itemcard_batches();
                },
                error: function() {
                    $("#UomDiv").hide();
                    alert("حدث خطاما");
                }
            });
        } else {
            $("#UomDiv").html("");
            $("#UomDiv").hide();
            $("#inv_itemcard_batchesDiv").html("");
            $("#inv_itemcard_batchesDiv").hide();
            $(".relatedtoDateproExp").hide();
            $("#unit_cost_priceDiv").hide();
        }
    }
    //جلب كميات الصنف من المخزن بالباتشات وترتيبهم حسب نوع الصنف
    function get_inv_itemcard_batches(oldBatchId = null) {
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
                data: {
                    item_code: item_code,
                    uom_id: uom_id,
                    store_id: store_id,
                    "_token": token_search
                },
                success: function(data) {
                    $("#inv_itemcard_batchesDiv").html(data);
                    $("#inv_itemcard_batchesDiv").show();
                    if (oldBatchId != null) {
                        $("#inv_itemcard_batches_autoserial").val(oldBatchId);
                    }
                    get_item_unit_price();
                },
                error: function() {
                    $("#inv_itemcard_batchesDiv").hide();
                }
            });
        } else {
            $("#UomDiv").hide();
            $("#inv_itemcard_batchesDiv").hide();
        }
    }
    $(document).on('change', '#uom_id', function(e) {
        get_inv_itemcard_batches();
    });
    $(document).on('change', '#store_id', function(e) {
        get_inv_itemcard_batches();
    });
    $(document).on('click', '#LoadModalAddBtnMirror', function(e) {
        var token_search = $("#token_search").val();
        var url = $("#ajax_get_load_modal_addMirror").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token_search
            },
            success: function(data) {
                $("#updateInvoiceModalActiveInvoiceBody").html("");
                $("#updateInvoiceModalActiveInvoice").hide("show");
                $("#AddNewInvoiceModalMirroBody").html(data);
                $("#AddNewInvoiceModalMirro").modal("show");
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    });
    $(document).on('click', '#LoadModalAddBtnActiveInvoice', function(e) {
        var token = $("#token_search").val();
        var url = $("#ajax_get_load_modal_addActiveInvoice").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token
            },
            success: function(data) {
                $("#AddNewInvoiceModalActiveInvoiceBody").html(data);
                $("#AddNewInvoiceModalActiveInvoice").modal("show");
            },
            error: function() {
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
    $(document).on('click', '#AddItemToIvoiceDetailsRow', function(e) {
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
        var inv_itemcard_batches_autoserial = $("#inv_itemcard_batches_autoserial").val();
        if (inv_itemcard_batches_autoserial == "") {
            alert("من فضلك اختر  الباتش ");
            $("#inv_itemcard_batches_autoserial").focus();
            return false;
        }
        var item_quantity = $("#item_quantity").val();
        if (item_quantity == "") {
            alert("من فضلك  ادخل الكمية ");
            $("#item_quantity").focus();
            return false;
        }
        var BatchQuantity = $("#inv_itemcard_batches_autoserial option:selected").data("qunatity");
        if (parseFloat(item_quantity) > parseFloat(BatchQuantity)) {
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
                "_token": token_search,
                store_id: store_id,
                sales_item_type: sales_item_type,
                item_code: item_code,
                uom_id: uom_id,
                inv_itemcard_batches_autoserial: inv_itemcard_batches_autoserial,
                item_quantity: item_quantity,
                item_price: item_price,
                is_normal_orOther: is_normal_orOther,
                item_total: item_total,
                store_name: store_name,
                uom_id_name: uom_id_name,
                sales_item_type_name: sales_item_type_name,
                is_normal_orOther_name: is_normal_orOther_name,
                isparentuom: isparentuom,
                item_code_name: item_code_name
            },
            success: function(data) {
                $("#itemsrowtableContainterBody").append(data);
                recalcualte();
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    });
    $(document).on('click', '.remove_current_row', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        recalcualte();
    });
    $(document).on('change', '#invoice_date', function(e) {
        recalcualte();
    });
    $(document).on('change', '#Sales_matrial_types_id', function(e) {
        recalcualte();
    });
    $(document).on('change', '#is_has_customer', function(e) {
        recalcualte();
    });
    $(document).on('change', '#customer_code', function(e) {
        recalcualte();
    });
    $(document).on('change', '#delegate_code', function(e) {
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
    $(document).on('input', '#tax_percent', function(e) {
        var tax_percent = $(this).val();
        if (tax_percent == "") {
            tax_percent = 0;
            $(this).val(0)
        }
        if (tax_percent > 100) {
            alert("عفوا لايمكن ان يكون نسبة الضريبة اكبر من 100 % !!!");
            $("#tax_percent").val(0);
        }
        recalcualte();
    });
    $(document).on('click', '#Do_Add_new_active_invoice', function(e) {
        var invoice_date = $("#invoice_date_activeAdd").val();
        if (invoice_date == "") {
            alert("من فضلك ادخل تاريخ الفاتورة");
            $("#invoice_date_activeAdd").focus();
            return false;
        }
        var Sales_matrial_types_id = $("#Sales_matrial_types_id_activeAdd").val();
        if (Sales_matrial_types_id == "") {
            alert("من فضلك اختر فئة الفاتورة");
            $("#Sales_matrial_types_id_activeAdd").focus();
            return false;
        }
        var customer_code = $("#customer_code").val();
        var is_has_customer = $("#is_has_customer").val();
        if (is_has_customer == 1) {
            if (customer_code == "") {
                alert("من فضلك  اختر العميل");
                $("#customer_code").focus();
                return false;
            }
        }
        var delegate_code = $("#delegate_code_activeAdd").val();
        if (delegate_code == "") {
            alert("من فضلك  اختر المندوب ");
            $("#delegate_code_activeAdd").focus();
            return false;
        }
        var pill_type = $("#pill_type_activeAdd").val();
        var token = $("#token_search").val();
        var url = $("#ajax_get_store").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                invoice_date: invoice_date,
                customer_code: customer_code,
                is_has_customer: is_has_customer,
                delegate_code: delegate_code,
                pill_type: pill_type,
                sales_matrial_types: Sales_matrial_types_id,
                "_token": token
            },
            success: function(auto_serial) {
                load_invoice_update_modal(auto_serial);
                make_search();
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    });
    $(document).on('change', '#is_has_customer', function(e) {
        $("#customer_code").val("");
        if ($(this).val() == 1) {
            $("#customer_codeDiv").show();
        } else {
            $("#customer_codeDiv").hide();
        }
    });
    $(document).on('change', '#is_has_customer', function(e) {
        $("#customer_code").val("");
        if ($(this).val() == 1) {
            $("#customer_codeDiv").show();
        } else {
            $("#customer_codeDiv").hide();
        }
    });

    function load_invoice_update_modal(auto_serial) {
        var token = $("#token_search").val();
        var url = $("#ajax_get_load_invoice_update_modal").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                auto_serial: auto_serial
            },
            success: function(data) {
                $("#AddNewInvoiceModalActiveInvoiceBody").html("");
                $("#AddNewInvoiceModalActiveInvoice").modal("hide");
                $("#updateInvoiceModalActiveInvoiceBody").html(data);
                $("#updateInvoiceModalActiveInvoice").modal("show");
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    }
    $(document).on('click', '.load_invoice_update_modal', function(e) {
        var auto_serial = $(this).data("autoserial");
        load_invoice_update_modal(auto_serial);
    });

    function make_enter_add() {
        var Sales_matrial_types_id = $("#Sales_matrial_types_id").val();
        if (Sales_matrial_types_id == "") {
            alert("من فضلك اختر الفئة  ");
            $("#Sales_matrial_types_id").focus();
            return false;
        }
        var is_has_customer = $("#is_has_customer").val();
        if (is_has_customer == 1) {
            var customer_code = $("#customer_code").val();
            if (customer_code == "") {
                alert("من فضلك اختر العميل  ");
                $("#customer_code").focus();
                return false;
            }
        }
        var delegate_code = $("#delegate_code").val();
        if (delegate_code == "") {
            alert("من فضلك اختر المندوب ");
            $("#delegate_code").focus();
            return false;
        }
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
        var item_quantity = $("#item_quantity").val();
        if (item_quantity == "") {
            alert("من فضلك  ادخل الكمية ");
            $("#item_quantity").focus();
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
        var inv_itemcard_batches_autoserial = $("#inv_itemcard_batches_autoserial").val();
        var item_type = $("#item_code option:selected").data("item_type");
        if (item_type == 2 && inv_itemcard_batches_autoserial == "") {
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
            var unit_cost_price = $("#unit_cost_price").val();
            if (unit_cost_price == "") {
                alert("من فضلك  ادخل سعر تكلفة شراء الصنف  ");
                $("#unit_cost_price").focus();
                return false;
            }
        } else {
            var production_date = $("#production_date").val();
            var expire_date = $("#expire_date").val();
            var unit_cost_price = $("#unit_cost_price").val();
        }
        var item_total = $("#item_total").val();
        if (item_total == "") {
            alert("من فضلك  حقل الاجمالي مطلوب ! ");
            $("#item_total").focus();
            return false;
        }
        var isparentuom = $("#uom_id option:selected").data("isparentuom");
        var invoiceautoserial = $("#invoiceautoserial").val();
        var token_search = $("#token_search").val();
        var url = $("#ajax_get_Add_item_to_invoice").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                "_token": token_search,
                store_id: store_id,
                sales_item_type: sales_item_type,
                item_code: item_code,
                uom_id: uom_id,
                item_quantity: item_quantity,
                item_price: item_price,
                is_normal_orOther: is_normal_orOther,
                item_total: item_total,
                isparentuom: isparentuom,
                invoiceautoserial: invoiceautoserial,
                expire_date: expire_date,
                production_date: production_date,
                inv_itemcard_batches_autoserial: inv_itemcard_batches_autoserial,
                unit_cost_price: unit_cost_price
            },
            success: function(data) {
                reload_items_in_invoice();
                get_inv_itemcard_batches();
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    }
    $(document).on('click', '#AddItemToIvoiceDetailsActive', function(e) {
        make_enter_add();
    });

    function reload_items_in_invoice() {
        var token = $("#token_search").val();
        var url = $("#ajax_get_reload_items_in_invoice").val();
        var auto_serial = $("#invoiceautoserial").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                auto_serial: auto_serial
            },
            success: function(data) {
                $("#activeItemisInInvoiceDiv").html(data);
                recalcualte();
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    }

    function recalcualte() {
        if ($("#Do_Add_new_active_invoice").length) {
            return false;
        }
        var total_cost_items = 0;
        $(".item_total_array").each(function() {
            total_cost_items += parseFloat($(this).val());
        });
        if (total_cost_items == "") {
            total_cost_items = 0;
        }
        total_cost_items = parseFloat(total_cost_items);
        $("#total_cost_items").val(total_cost_items);
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
        what_remain = total_cost - what_paid;
        $("#what_remain").val(what_remain * 1);
        var pill_type = $("#pill_type").val();
        if (pill_type == 1) {
            $("#what_paid").val(total_cost);
            $("#what_remain").val(0);
        }
        var token = $("#token_search").val();
        var url = $("#ajax_get_recalclate_parent_invoice").val();
        var auto_serial = $("#invoiceautoserial").val();
        var total_cost_items = $("#total_cost_items").val();
        var tax_percent = $("#tax_percent").val();
        var tax_value = $("#tax_value").val();
        var total_befor_discount = $("#total_befor_discount").val();
        var discount_type = $("#discount_type").val();
        var discount_percent = $("#discount_percent").val();
        var discount_value = $("#discount_value").val();
        var total_cost = $("#total_cost").val();
        var notes = $("#notes").val();
        var invoice_date = $("#invoice_date").val();
        var is_has_customer = $("#is_has_customer").val();
        var customer_code = $("#customer_code").val();
        var delegate_code = $("#delegate_code").val();
        var Sales_matrial_types_id = $("#Sales_matrial_types_id").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                "_token": token,
                auto_serial: auto_serial,
                total_cost_items: total_cost_items,
                tax_percent: tax_percent,
                tax_value: tax_value,
                total_befor_discount: total_befor_discount,
                discount_type: discount_type,
                discount_percent: discount_percent,
                discount_value: discount_value,
                total_cost: total_cost,
                notes: notes,
                invoice_date: invoice_date,
                is_has_customer: is_has_customer,
                pill_type: pill_type,
                customer_code: customer_code,
                delegate_code: delegate_code,
                Sales_matrial_types_id: Sales_matrial_types_id
            },
            success: function(data) {},
            error: function() {
                alert("حدث خطاما");
            }
        });
    }
    $(document).on('click', '.remove_active_row_item', function(e) {
        var url = $("#ajax_get_remove_active_row_item").val();
        var auto_serial = $("#invoiceautoserial").val();
        var token = $("#token_search").val();
        var id = $(this).data("id");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                auto_serial: auto_serial,
                id: id
            },
            success: function(data) {
                reload_items_in_invoice();
                recalcualte();
                get_inv_itemcard_batches();
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    });
    $(document).on('click', '#DoApproveInvoiceFinally', function(e) {
        var Sales_matrial_types_id = $("#Sales_matrial_types_id").val();
        if (Sales_matrial_types_id == "") {
            alert("من فضلك اختر الفئة  ");
            $("#Sales_matrial_types_id").focus();
            return false;
        }
        var is_has_customer = $("#is_has_customer").val();
        if (is_has_customer == 1) {
            var customer_code = $("#customer_code").val();
            if (customer_code == "") {
                alert("من فضلك اختر العميل  ");
                $("#customer_code").focus();
                return false;
            }
        }
        var delegate_code = $("#delegate_code").val();
        if (delegate_code == "") {
            alert("من فضلك اختر المندوب ");
            $("#delegate_code").focus();
            return false;
        }
        if (!$(".item_total_array").length) {
            alert("عفوا يجب علي الاقل اضافة صنف علي الفاتورة !");
            return false;
        }
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
            if (discount_value > total_befor_discount) {
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
            alert("من فضلك ادخل المبلغ المصروف        ");
            return false;
        }
        if (what_paid > total_cost) {
            alert("عفوا لايمكن ان يكون المبلغ المصروف اكبر من اجمالي الفاتورة         ");
            return false;
        }
        if (pill_type == 1) {
            if (parseFloat(what_paid) < parseFloat(total_cost)) {
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
                alert("من فضلك اختر خزنة التحصيل         ");
                return false;
            }
            var treasuries_balance = $("#treasuries_balance").val();
            if (parseFloat(what_paid) > parseFloat(treasuries_balance)) {
                alert("عفوا لاتمتلك رصيد كافي بالخزنة؟؟");
                return false;
            }
        }
        var token = $("#token_search").val();
        var url = $("#ajax_DoApproveInvoiceFinally").val();
        var auto_serial = $("#invoiceautoserial").val();
        var treasuries_id = $("#treasuries_id").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                "_token": token,
                auto_serial: auto_serial,
                treasuries_id: treasuries_id,
                what_paid: what_paid,
                what_remain: what_remain
            },
            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    });
    $(document).on('mouseenter', '#DoApproveInvoiceFinally', function(e) {
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
    $(document).on('click', '.load_invoice_details_modal', function(e) {
        var token = $("#token_search").val();
        var url = $("#ajax_load_invoice_details_modal").val();
        var auto_serial = $(this).data("autoserial");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                auto_serial: auto_serial
            },
            success: function(data) {
                $("#InvoiceModalActiveDetailsBody").html(data);
                $("#InvoiceModalActiveDetails").modal("show");
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    });

    function make_search() {
        var token = $("#token_search").val();
        var customer_code = $("#customer_code_search").val();
        var delegates_code = $("#delegates_code_search").val();
        var Sales_matrial_types = $("#Sales_matrial_types_search").val();
        var pill_type = $("#pill_type_search").val();
        var discount_type = $("#discount_type_search").val();
        var is_approved = $("#is_approved_search").val();
        var invoice_date_from = $("#invoice_date_from").val();
        var invoice_date_to = $("#invoice_date_to").val();
        var search_by_text = $("#search_by_text").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var url = $("#ajax_ajax_search").val();
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token,
                customer_code: customer_code,
                delegates_code: delegates_code,
                Sales_matrial_types: Sales_matrial_types,
                pill_type: pill_type,
                discount_type: discount_type,
                is_approved: is_approved,
                invoice_date_from: invoice_date_from,
                invoice_date_to: invoice_date_to,
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
        var customer_code = $("#customer_code_search").val();
        var delegates_code = $("#delegates_code_search").val();
        var Sales_matrial_types = $("#Sales_matrial_types_search").val();
        var pill_type = $("#pill_type_search").val();
        var discount_type = $("#discount_type_search").val();
        var is_approved = $("#is_approved_search").val();
        var invoice_date_from = $("#invoice_date_from").val();
        var invoice_date_to = $("#invoice_date_to").val();
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
                customer_code: customer_code,
                delegates_code: delegates_code,
                Sales_matrial_types: Sales_matrial_types,
                pill_type: pill_type,
                discount_type: discount_type,
                is_approved: is_approved,
                invoice_date_from: invoice_date_from,
                invoice_date_to: invoice_date_to,
                searchbyradio: searchbyradio,
                search_by_text: search_by_text
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });
    $('input[type=radio][name=searchbyradio]').change(function() {
        make_search();
    });
    $(document).on('input', '#search_by_text', function(e) {
        make_search();
    });
    $(document).on('change', '#customer_code_search', function(e) {
        make_search();
    });
    $(document).on('change', '#delegates_code_search', function(e) {
        make_search();
    });
    $(document).on('change', '#Sales_matrial_types_search', function(e) {
        make_search();
    });
    $(document).on('change', '#pill_type_search', function(e) {
        make_search();
    });
    $(document).on('change', '#discount_type_search', function(e) {
        make_search();
    });
    $(document).on('change', '#is_approved_search', function(e) {
        make_search();
    });
    $(document).on('change', '#invoice_date_from', function(e) {
        make_search();
    });
    $(document).on('change', '#invoice_date_to', function(e) {
        make_search();
    });
    $(document).on('click', '#load_add_new_customer', function(e) {
        e.preventDefault();
        $("#load_add_new_customerModal").modal("show");
    });
    $(document).on('change', '#start_balance_status', function(e) {
        if ($(this).val() == "") {
            $("#start_balance").val("");
        } else {
            if ($(this).val() == 3) {
                $("#start_balance").val(0);
            }
        }
    });
    $(document).on('input', '#start_balance', function(e) {
        var start_balance_status = $("#start_balance_status").val();
        if (start_balance_status == "") {
            alert("من فضلك اختر حالة الحساب اولا");
            $(this).val("");
            return false;
        }
        if ($(this).val() == 0 && start_balance_status != 3) {
            alert("يجب ادخال مبلغ اكبر من الصفر");
            $(this).val("");
            return false;
        }
    });
    $(document).on('click', '#do_add_new_customer_btn', function(e) {
        var customer_name = $("#customer_name").val();
        if (customer_name == "") {
            alert("اسم العميل مطلوب ");
            $("#customer_name").focus();
            return false;
        }
        var start_balance_status = $("#start_balance_status").val();
        if (start_balance_status == "") {
            alert("  حالة رصيد العميل اول المدة مطلوبة !!! ");
            $("#start_balance_status").focus();
            return false;
        }
        var start_balance = $("#start_balance").val();
        if (start_balance == "") {
            alert("   رصيد العميل اول المدة مطلوب !!! ");
            $("#start_balance").focus();
            return false;
        }
        if (start_balance_status == 3 && start_balance != 0) {
            alert("   عفوا لابد ان يكون رصيد اول المده صفر في حالة الاتزان");
            $("#start_balance").val(0);
            $("#start_balance").focus();
            return false;
        }
        var customer_active = $("#customer_active").val();
        if (customer_active == "") {
            alert("  حالة تفعيل العميل مطلوبة !!! ");
            $("#customer_active").focus();
            return false;
        }
        var customer_active = $("#customer_active").val();
        var customer_address = $("#customer_address").val();
        var customer_phones = $("#customer_phones").val();
        var customer_notes = $("#customer_notes").val();
        var token = $("#token_search").val();
        var url = $("#ajax_do_add_new_customer").val();
        var auto_serial = $(this).data("autoserial");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                "_token": token,
                name: customer_name,
                start_balance_status: start_balance_status,
                start_balance: start_balance,
                active: customer_active,
                address: customer_address,
                phones: customer_phones,
                notes: customer_notes
            },
            success: function(data) {
                if (data == "exsits") {
                    alert("عفوا اسم العميل مسجل من قبل");
                    $("#customer_name").focus();
                } else {
                    $("#load_add_new_customerModal").modal("hide");
                    $("#customer_active").val("");
                    $("#customer_address").val("");
                    $("#customer_phones").val("");
                    $("#customer_notes").val("");
                    $("#customer_name").val("");
                    $("#start_balance").val(0);
                    $("#customer_active").val(1);
                    get_last_added_customer();
                }
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    });

    function get_last_added_customer() {
        var token = $("#token_search").val();
        var url = $("#ajax_getlastaddedcustomer").val();
        var auto_serial = $(this).data("autoserial");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                "_token": token
            },
            success: function(data) {
                $("#customer_codeDiv").html(data);
            },
            error: function() {
                alert("حدث خطاما");
            }
        });
    }
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
            },
            error: function() {}
        });
    });
    $(document).on('input', '#searchforitem', function(e) {
        var searchtext = $(this).val();
        var token = $("#token_search").val();
        var url = $("#ajax_searchforitems").val();
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
                $("#searchforitemresultDiv").html(data);
                get_item_uoms();
            },
            error: function() {}
        });
    });
    $(document).on('keypress', '#searchforitem', function(e) {
        if (e.keyCode == 13) {
            make_enter_add();
        }
    });
    $(document).on('change', '#inv_itemcard_batches_autoserial', function(e) {
        if ($(this).val() == "") {
            var item_code = $("#item_code").val();
            if (item_code != "") {
                $("#unit_cost_priceDiv").show();
                var item_type = $("#item_code option:selected").data("item_type");
                if (item_type == 2) {
                    $(".relatedtoDateproExp").show();
                } else {
                    $(".relatedtoDateproExp").hide();
                }
            }
        } else {
            $("#unit_cost_priceDiv").hide();
            $(".relatedtoDateproExp").hide();
        }
    });
});