$(document).ready(function(){

  
$(document).on('change','#item_code_add',function(e){
  var item_code=$(this).val();
  if(item_code!=""){
    var token_search=$("#token_search").val();
    var ajax_get_item_uoms_url=$("#ajax_get_item_uoms_url").val();
    jQuery.ajax({
      url:ajax_get_item_uoms_url,
      type:'post',
      dataType:'html',
      cache:false,
      data:{item_code:item_code,"_token":token_search},
      success:function(data){
     
       $("#UomDivAdd").html(data);
       $(".relatied_to_itemCard").show();
       var type = $("#item_code_add").children('option:selected').data("type");
       if(type==2){
       
        $(".relatied_to_date").show();
       }else{
        $(".relatied_to_date").hide();
       }

      },
      error:function(){
        $(".relatied_to_itemCard").hide();
        $("#UomDivAdd").html("");
        $(".relatied_to_date").hide();

        alert("حدث خطاما");
      }
    });
  
  }else{
    $(".relatied_to_itemCard").hide();
    $("#UomDivAdd").html("");
    $(".relatied_to_date").hide();
  }


  });

  $(document).on('input','#quantity_add',function(e){
recaluclate_Add();
  });

  $(document).on('input','#price_add',function(e){
    recaluclate_Add();
  });
  $(document).on('click','#AddToBill',function(e){
var item_code_add=$("#item_code_add").val();
if(item_code_add==""){
  alert("من فضلك  اختر الصنف");
  $("#item_code_add").focus();
  return false;
}
var uom_id_Add=$("#uom_id_Add").val();
if(uom_id_Add==""){
  alert("من فضلك  اختر الوحدة");
  $("#uom_id_Add").focus();
  return false;
}

var isparentuom = $("#uom_id_Add").children('option:selected').data("isparentuom");
var quantity_add=$("#quantity_add").val();
if(quantity_add==""||quantity_add==0){
  alert("من فضلك  ادخل الكمية المستلمة");
  $("#quantity_add").focus();
  return false;
}


var price_add=$("#price_add").val();
if(price_add==""){
  alert("من فضلك  ادخل سعر الوحدة ");
  $("#quantity_add").focus();
  return false;
}
var type = $("#item_code_add").children('option:selected').data("type");
 if(type==2){
  var production_date=$("#production_date").val();
if(production_date==""){
  alert("من فضلك  اختر تاريخ الانتاج  ");
  $("#production_date").focus();
  return false;
}

var expire_date=$("#expire_date").val();
if(expire_date==""){
  alert("من فضلك  اختر تاريخ انتهاء الصلاحية  ");
  $("#expire_date").focus();
  return false;
}

if(expire_date<production_date){
  alert("عفوا لايمكن ان يكون تاريخ الانتهاء اقل من تاريخ الانتاج !!!");
  $("#expire_date").focus();
  return false;
}


 }else{
  var production_date=$("#production_date").val();
  var expire_date=$("#expire_date").val();
 }

 var total_add=$("#total_add").val();
 if(total_add==""){
   alert("من فضلك  ادخل اجمالي   الاصناف  ");
   $("#total_add").focus();
   return false;
 }

 var autoserailparent=$("#autoserailparent").val();
 var token_search=$("#token_search").val();
 var ajax_search_url=$("#ajax_add_new_details").val();
 
 jQuery.ajax({
   url:ajax_search_url,
   type:'post',
   dataType:'json',
   cache:false,
   data:{autoserailparent:autoserailparent,"_token":token_search,item_code_add:item_code_add,uom_id_Add:uom_id_Add,isparentuom:isparentuom,
   quantity_add:quantity_add,price_add:price_add,production_date:production_date,expire_date:expire_date,total_add:total_add,type:type},
   success:function(data){
   alert("تم الاضافة بنجاح");
   
   },
   error:function(){
 
   }
 });



  });
  
function recaluclate_Add(){
  var quantity_add=$("#quantity_add").val();
  var price_add=$("#price_add").val();
 if(quantity_add=="") quantity_add=0;
 if(price_add=="") price_add=0;
 $("#total_add").val(parseFloat(quantity_add)*parseFloat(price_add));




}



  $(document).on('input','#start_balance',function(e){
   var start_balance_status=$("#start_balance_status").val();
   if(start_balance_status==""){
    alert("من فضلك اختر حالة الحساب اولا");
    $(this).val("");
    return false;
   }
   if($(this).val()==0 && start_balance_status!=3 ){
    alert("يجب ادخال مبلغ اكبر من الصفر");
    $(this).val("");
    return false;
   }
   
   
  });

  $(document).on('input','#search_by_text',function(e){
    make_search();
  });


  $('input[type=radio][name=searchbyradio]').change(function() {
    make_search();
  });



  function make_search(){
    var search_by_text=$("#search_by_text").val();
    var searchbyradio=$("input[type=radio][name=searchbyradio]:checked").val();
    var token_search=$("#token_search").val();
    var ajax_search_url=$("#ajax_search_url").val();
    
    jQuery.ajax({
      url:ajax_search_url,
      type:'post',
      dataType:'html',
      cache:false,
      data:{search_by_text:search_by_text,"_token":token_search,searchbyradio:searchbyradio},
      success:function(data){
     
       $("#ajax_responce_serarchDiv").html(data);
      },
      error:function(){
    
      }
    });
    
  }
  
  $(document).on('click','#ajax_pagination_in_search a ',function(e){
    e.preventDefault();
    var search_by_text=$("#search_by_text").val();
    var searchbyradio=$("input[type=radio][name=searchbyradio]:checked").val();
    var token_search=$("#token_search").val();
    var url=$(this).attr("href");
    
    jQuery.ajax({
      url:url,
      type:'post',
      dataType:'html',
      cache:false,
      data:{search_by_text:search_by_text,"_token":token_search,searchbyradio:searchbyradio},
      success:function(data){
     
       $("#ajax_responce_serarchDiv").html(data);
      },
      error:function(){
    
      }
    });
    
    
    
    });

  

});