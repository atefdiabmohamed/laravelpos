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
   reload_parent_pill();
   reload_itemsdetials();
   
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

function reload_itemsdetials(){
  var autoserailparent=$("#autoserailparent").val();
  var token_search=$("#token_search").val();
  var ajax_search_url=$("#ajax_reload_itemsdetials").val();
  
  jQuery.ajax({
    url:ajax_search_url,
    type:'post',
    dataType:'html',
    cache:false,
    data:{autoserailparent:autoserailparent,"_token":token_search},
    success:function(data){
    $("#ajax_responce_serarchDivDetails").html(data);
    
    },
    error:function(){
  
    }
  });

}

function reload_parent_pill(){
  var autoserailparent=$("#autoserailparent").val();
  var token_search=$("#token_search").val();
  var ajax_search_url=$("#ajax_reload_parent_pill").val();
  
  jQuery.ajax({
    url:ajax_search_url,
    type:'post',
    dataType:'html',
    cache:false,
    data:{autoserailparent:autoserailparent,"_token":token_search},
    success:function(data){
    $("#ajax_responce_serarchDivparentpill").html(data);
    
    },
    error:function(){
  
    }
  });

}

$(document).on('click','.load_edit_item_details',function(e){
var id=$(this).data("id");
var autoserailparent=$("#autoserailparent").val();
var token_search=$("#token_search").val();
var ajax_search_url=$("#ajax_load_edit_item_details").val();

jQuery.ajax({
  url:ajax_search_url,
  type:'post',
  dataType:'html',
  cache:false,
  data:{autoserailparent:autoserailparent,"_token":token_search,id:id},
  success:function(data){
  $("#edit_item_Modal_body").html(data);
  $("#edit_item_Modal").modal("show");
  $("#Add_item_Modal_body").html("");
  $("#Add_item_Modal").modal("hide");
  
  },
  error:function(){

  }
});

});


$(document).on('click','#load_modal_add_detailsBtn',function(e){
  var id=$(this).data("id");
  var autoserailparent=$("#autoserailparent").val();
  var token_search=$("#token_search").val();
  var ajax_search_url=$("#ajax_load_modal_add_details").val();
  
  jQuery.ajax({
    url:ajax_search_url,
    type:'post',
    dataType:'html',
    cache:false,
    data:{autoserailparent:autoserailparent,"_token":token_search,id:id},
    success:function(data){
    $("#Add_item_Modal_body").html(data);
    $("#Add_item_Modal").modal("show");
    $("#edit_item_Modal_body").html("");
    $("#edit_item_Modal").modal("hide");

    
    
    },
    error:function(){
  
    }
  });
  
  });


  $(document).on('click','#EditDetailsItem',function(e){
    var id=$(this).data("id");
   
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
     var ajax_url=$("#ajax_edit_item_details").val();
     
     jQuery.ajax({
       url:ajax_url,
       type:'post',
       dataType:'json',
       cache:false,
       data:{autoserailparent:autoserailparent,"_token":token_search,item_code_add:item_code_add,uom_id_Add:uom_id_Add,isparentuom:isparentuom,
       quantity_add:quantity_add,price_add:price_add,production_date:production_date,expire_date:expire_date,total_add:total_add,type:type,id:id},
       success:function(data){
       alert("تم النحديث بنجاح");
       reload_parent_pill();
       reload_itemsdetials();
       
       },
       error:function(){
     
       }
     });
    
    
    
      });
      



});