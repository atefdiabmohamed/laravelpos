$(document).ready(function(){
$(document).on('change','#report_type',function(e){
if($(this).val()==1){
  $(".relatedDate").hide();
}else{
  $(".relatedDate").show();
}

if($(this).val()!=1 && $(this).val()!=5){ 
$("#Does_show_itemsDiv").show();
}else{
  $("#Does_show_itemsDiv").hide();
}

});

$(document).on('change','#suuplier_code',function(e){
if($(this).val()!=''){
var startdate=$("#suuplier_code option:selected").data('startdate');
$("#from_date").val(startdate);
$("#to_date").val($("#todaydate").val());
}else{
  $("#from_date").val('');
  $("#to_date").val('');


}


});

});

