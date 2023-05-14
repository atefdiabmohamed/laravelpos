$(document).ready(function() {
    $(document).on('change', '#does_has_retailunit', function(e) {
        var uom_id = $("#uom_id").val();
        if (uom_id == '') {
            alert("اختر الوحده الاب اولا");
            $("#does_has_retailunit").val("");
            return false;
        }
        if ($(this).val() == 1) {
            $("#retail_uom_idDiv").show();
            var retail_uom_id = $("#retail_uom_id").val();
            if (retail_uom_id != '') {
                $(".relatied_retial_counter").show();
            } else {
                $(".relatied_retial_counter").hide();
            }
        } else {
            $(".relatied_retial_counter").hide();
            $("#retail_uom_idDiv").hide();
        }
        $("#retail_uom_id").val("");
    });
    $(document).on('change', '#uom_id', function(e) {
        if ($(this).val() != '') {
            var name = $("#uom_id option:selected").text();
            $(".parentuomname").text(name);
            var does_has_retailunit = $("#does_has_retailunit").val();
            if (does_has_retailunit == 1) {
                var retail_uom_id = $("#retail_uom_id").val();
                if (retail_uom_id != '') {
                    $(".relatied_retial_counter").show();
                } else {
                    $(".relatied_retial_counter").hide();
                }
            } else {
                $(".relatied_retial_counter").hide();
                $("#retail_uom_idDiv").hide();
            }
            $(".relatied_parent_counter").show();
        } else {
            $(".parentuomname").text('');
            $(".relatied_retial_counter").hide();
            $(".relatied_parent_counter").hide();
            $("#retail_uom_idDiv").hide();
        }
    });
    $(document).on('change', '#retail_uom_id', function(e) {
        if ($(this).val() != '') {
            var name = $("#retail_uom_id option:selected").text();
            $(".childuomname").text(name);
            $(".relatied_retial_counter").show();
        } else {
            $(".childuomname").text('');
            $(".relatied_retial_counter").hide();
        }
    });
    $(document).on('click', '#do_add_item_card', function(e) {
        var name = $("#name").val();
        if (name == "") {
            alert("من فضلك ادخل اسم الصنف");
            $("#name").focus();
            return false;
        }
        var item_type = $("#item_type").val();
        if (item_type == "") {
            alert("من فضلك ادخل نوع الصنف");
            $("#item_type").focus();
            return false;
        }
        var inv_itemcard_categories_id = $("#inv_itemcard_categories_id").val();
        if (inv_itemcard_categories_id == "") {
            alert("من فضلك اختر فئة الصنف");
            $("#inv_itemcard_categories_id").focus();
            return false;
        }
        var uom_id = $("#uom_id").val();
        if (uom_id == "") {
            alert("من فضلك اختر وحده القياس الاب للصنف");
            $("#uom_id").focus();
            return false;
        }
        var does_has_retailunit = $("#does_has_retailunit").val();
        if (does_has_retailunit == "") {
            alert("من فضلك اختر  حالة هل للصنف وحده تجزئة   ");
            $("#does_has_retailunit").focus();
            return false;
        }
        if (does_has_retailunit == 1) {
            var uom_id = $("#retail_uom_id").val();
            if (uom_id == "") {
                alert("من فضلك اختر وحده القياس التجزئة الابن للصنف");
                $("#uom_id").focus();
                return false;
            }
            var retail_uom_quntToParent = $("#retail_uom_quntToParent").val();
            if (retail_uom_quntToParent == "" || retail_uom_quntToParent == 0) {
                alert("من فضلك ادخل عدد وحدات الوحده التجزئة بالنسبة للأب");
                $("#retail_uom_quntToParent").focus();
                return false;
            }
        }
        var price = $("#price").val();
        if (price == "") {
            alert("من فضلك  ادخل السعر القطاعي للوحده الاب   ");
            $("#price").focus();
            return false;
        }
        var nos_gomla_price = $("#nos_gomla_price").val();
        if (nos_gomla_price == "") {
            alert("من فضلك  ادخل السعر النص جملة للوحده الاب   ");
            $("#nos_gomla_price").focus();
            return false;
        }
        var gomla_price = $("#gomla_price").val();
        if (gomla_price == "") {
            alert("من فضلك  ادخل السعر  الجملة للوحده الاب   ");
            $("#gomla_price").focus();
            return false;
        }
        var cost_price = $("#cost_price").val();
        if (cost_price == "") {
            alert("من فضلك  ادخل    سعر تكلفة الشراء للوحدة الاب   ");
            $("#cost_price").focus();
            return false;
        }
        if (does_has_retailunit == 1) {
            //start valid child prices if exsists
            var price_retail = $("#price_retail").val();
            if (price_retail == "") {
                alert("من فضلك  ادخل السعر القطاعي للوحده التجزئة   ");
                $("#price_retail").focus();
                return false;
            }
            var nos_gomla_price_retail = $("#nos_gomla_price_retail").val();
            if (nos_gomla_price_retail == "") {
                alert("من فضلك  ادخل السعر النص جملة للوحده التجزئة   ");
                $("#nos_gomla_price_retail").focus();
                return false;
            }
            var gomla_price_retail = $("#gomla_price_retail").val();
            if (gomla_price_retail == "") {
                alert("من فضلك  ادخل السعر  الجملة للوحده التجزئة   ");
                $("#gomla_price_retail").focus();
                return false;
            }
            var cost_price_retail = $("#cost_price_retail").val();
            if (cost_price_retail == "") {
                alert("من فضلك  ادخل  سعر تكلفة الشراء للوحدة التجزئة   ");
                $("#cost_price_retail").focus();
                return false;
            }
        }
        var has_fixced_price = $("#has_fixced_price").val();
        if (has_fixced_price == "") {
            alert(" من فضلك اختر حالة هل للصنف سعر ثابت بالفواتير     ");
            $("#has_fixced_price").focus();
            return false;
        }
        var active = $("#active").val();
        if (active == "") {
            alert("من فضلك اختر حالة تفعيل الصنف     ");
            $("#has_fixced_price").focus();
            return false;
        }
    });
    $(document).on('click', '#do_edit_item_cardd', function(e) {
        var barcode = $("#barcode").val();
        if (barcode == "") {
            alert("من فضلك ادخل باركود الصنف");
            $("#barcode").focus();
            return false;
        }
        var name = $("#name").val();
        if (name == "") {
            alert("من فضلك ادخل اسم الصنف");
            $("#name").focus();
            return false;
        }
        var item_type = $("#item_type").val();
        if (item_type == "") {
            alert("من فضلك ادخل نوع الصنف");
            $("#item_type").focus();
            return false;
        }
        var inv_itemcard_categories_id = $("#inv_itemcard_categories_id").val();
        if (inv_itemcard_categories_id == "") {
            alert("من فضلك اختر فئة الصنف");
            $("#inv_itemcard_categories_id").focus();
            return false;
        }
        var uom_id = $("#uom_id").val();
        if (uom_id == "") {
            alert("من فضلك اختر وحده القياس الاب للصنف");
            $("#uom_id").focus();
            return false;
        }
        var does_has_retailunit = $("#does_has_retailunit").val();
        if (does_has_retailunit == "") {
            alert("من فضلك اختر  حالة هل للصنف وحده تجزئة   ");
            $("#does_has_retailunit").focus();
            return false;
        }
        if (does_has_retailunit == 1) {
            var uom_id = $("#retail_uom_id").val();
            if (uom_id == "") {
                alert("من فضلك اختر وحده القياس التجزئة الابن للصنف");
                $("#uom_id").focus();
                return false;
            }
            var retail_uom_quntToParent = $("#retail_uom_quntToParent").val();
            if (retail_uom_quntToParent == "" || retail_uom_quntToParent == 0) {
                alert("من فضلك ادخل عدد وحدات الوحده التجزئة بالنسبة للأب");
                $("#retail_uom_quntToParent").focus();
                return false;
            }
        }
        var price = $("#price").val();
        if (price == "") {
            alert("من فضلك  ادخل السعر القطاعي للوحده الاب   ");
            $("#price").focus();
            return false;
        }
        var nos_gomla_price = $("#nos_gomla_price").val();
        if (nos_gomla_price == "") {
            alert("من فضلك  ادخل السعر النص جملة للوحده الاب   ");
            $("#nos_gomla_price").focus();
            return false;
        }
        var gomla_price = $("#gomla_price").val();
        if (gomla_price == "") {
            alert("من فضلك  ادخل السعر  الجملة للوحده الاب   ");
            $("#gomla_price").focus();
            return false;
        }
        var cost_price = $("#cost_price").val();
        if (cost_price == "") {
            alert("من فضلك  ادخل    سعر تكلفة الشراء للوحدة الاب   ");
            $("#cost_price").focus();
            return false;
        }
        if (does_has_retailunit == 1) {
            //start valid child prices if exsists
            var price_retail = $("#price_retail").val();
            if (price_retail == "") {
                alert("من فضلك  ادخل السعر القطاعي للوحده التجزئة   ");
                $("#price_retail").focus();
                return false;
            }
            var nos_gomla_price_retail = $("#nos_gomla_price_retail").val();
            if (nos_gomla_price_retail == "") {
                alert("من فضلك  ادخل السعر النص جملة للوحده التجزئة   ");
                $("#nos_gomla_price_retail").focus();
                return false;
            }
            var gomla_price_retail = $("#gomla_price_retail").val();
            if (gomla_price_retail == "") {
                alert("من فضلك  ادخل السعر  الجملة للوحده التجزئة   ");
                $("#gomla_price_retail").focus();
                return false;
            }
            var cost_price_retail = $("#cost_price_retail").val();
            if (cost_price_retail == "") {
                alert("من فضلك  ادخل  سعر تكلفة الشراء للوحدة التجزئة   ");
                $("#cost_price_retail").focus();
                return false;
            }
        }
        var has_fixced_price = $("#has_fixced_price").val();
        if (has_fixced_price == "") {
            alert(" من فضلك اختر حالة هل للصنف سعر ثابت بالفواتير     ");
            $("#has_fixced_price").focus();
            return false;
        }
        var active = $("#active").val();
        if (active == "") {
            alert("من فضلك اختر حالة تفعيل الصنف     ");
            $("#has_fixced_price").focus();
            return false;
        }
    });
    $(document).on('input', '#search_by_text', function(e) {
        make_search();
    });
    $(document).on('change', '#item_type_search', function(e) {
        make_search();
    });
    $(document).on('change', '#inv_itemcard_categories_id_search', function(e) {
        make_search();
    });
    $('input[type=radio][name=searchbyradio]').change(function() {
        make_search();
    });

    function make_search() {
        var search_by_text = $("#search_by_text").val();
        var item_type = $("#item_type_search").val();
        var inv_itemcard_categories_id = $("#inv_itemcard_categories_id_search").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                search_by_text: search_by_text,
                item_type: item_type,
                inv_itemcard_categories_id: inv_itemcard_categories_id,
                "_token": token_search,
                searchbyradio: searchbyradio
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    }
    $(document).on('click', '#ajax_pagination_in_search a ', function(e) {
        e.preventDefault();
        var search_by_text = $("#search_by_text").val();
        var item_type = $("#item_type_search").val();
        var inv_itemcard_categories_id = $("#inv_itemcard_categories_id_search").val();
        var searchbyradio = $("input[type=radio][name=searchbyradio]:checked").val();
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                search_by_text: search_by_text,
                item_type: item_type,
                inv_itemcard_categories_id: inv_itemcard_categories_id,
                "_token": token_search,
                searchbyradio: searchbyradio
            },
            success: function(data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function() {}
        });
    });

    function make_search_movements() {
        var store_id = $("#store_id_move_search").val();
        var movements_categories = $("#movements_categoriesMoveSearch").val();
        var movements_types = $("#movements_typesMoveSearch").val();
        var from_date = $("#from_date_moveSearch").val();
        var to_date = $("#to_date_moveSearch").val();
        var moveDateorderType = $("#moveDateorderType").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_movements").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                store_id: store_id,
                movements_categories: movements_categories,
                movements_types: movements_types,
                from_date: from_date,
                to_date: to_date,
                "_token": token_search,
                moveDateorderType: moveDateorderType
            },
            success: function(data) {
                $("#ajaxSearchMovementsDiv").html(data);
            },
            error: function() {}
        });
    }
    $(document).on('click', '#ajax_pagination_in_searchMovements a ', function(e) {
        e.preventDefault();
        var store_id = $("#store_id_move_search").val();
        var movements_categories = $("#movements_categoriesMoveSearch").val();
        var movements_types = $("#movements_typesMoveSearch").val();
        var from_date = $("#from_date_moveSearch").val();
        var to_date = $("#to_date_moveSearch").val();
        var moveDateorderType = $("#moveDateorderType").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_movements").val();
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                store_id: store_id,
                movements_categories: movements_categories,
                movements_types: movements_types,
                from_date: from_date,
                to_date: to_date,
                "_token": token_search,
                moveDateorderType: moveDateorderType
            },
            success: function(data) {
                $("#ajaxSearchMovementsDiv").html(data);
            },
            error: function() {}
        });
    });
	
    $(document).on('click', '#ShowMovementsBtn', function(e) {
        make_search_movements();
    });
    $(document).on('change', '#store_id_move_search', function(e) {
        make_search_movements();
    });
    $(document).on('change', '#movements_categoriesMoveSearch', function(e) {
        make_search_movements();
    });
    $(document).on('change', '#movements_typesMoveSearch', function(e) {
        make_search_movements();
    });
    $(document).on('change', '#from_date_moveSearch', function(e) {
        make_search_movements();
    });
    $(document).on('change', '#to_date_moveSearch', function(e) {
        make_search_movements();
    });
    $(document).on('change', '#moveDateorderType', function(e) {
        make_search_movements();
    });
    $(document).on('click', '#do_add_item_cardd', function(e) {
        var name = $("#name").val();
        if (name == '') {
            $("#name").focus();
            e.preventDefault();
            return false;
        }
    });
    $(document).on('change', '#barcode', function(e) {
        var barcode = $(this).val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_url_ajax_check_barcode").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                barcode: barcode,
                "_token": token_search
            },
            success: function(data) {
                if (data == 'allowed') {
                    $("#barcodeCheckMessage").text("(متاح)");
                    $("#barcodeCheckMessage").css('color', 'green');
                } else {
                    $("#barcodeCheckMessage").text("(مسجل من قبل)");
                    $("#barcodeCheckMessage").css('color', 'red');
                }
            },
            error: function() {}
        });
    });
    $(document).on('change', '#name', function(e) {
        var name = $(this).val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_url_ajax_check_name").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                name: name,
                "_token": token_search
            },
            success: function(data) {
                if (data == 'allowed') {
                    $("#nameCheckMessage").text("(متاح)");
                    $("#nameCheckMessage").css('color', 'green');
                } else {
                    $("#nameCheckMessage").text("(مسجل من قبل)");
                    $("#nameCheckMessage").css('color', 'red');
                }
            },
            error: function() {}
        });
    });
});