$(document).ready(function () {

    $(document).on('click', "#do_collect_now_btn", function () {
        var move_date = $("#move_date").val();
        if (move_date == "") {
            alert("من فضلك اختر التاريخ");
            $("#move_date").focus();
            return false;
        }

      
        var account_number = $("#account_number").val();
        if (account_number == "") {
            alert("من فضلك اختر الحساب المالي ");
            $("#account_number").focus();

            return false;
        }

        var mov_type = $("#mov_type").val();
        if (mov_type == "") {
            alert("من فضلك اختر الحركة المالية");
            $("#mov_type").focus();
            return false;
        }
        var treasuries_id = $("#treasuries_id").val();
        if (treasuries_id == "") {
            alert("من فضلك اختر خزنة التحصيل  ");
            $("#treasuries_id").focus();

            return false;
        }
        var money = $("#money").val();
        if (money == "" || money <= 0) {
            alert("من فضلك ادخل مبلغ التحصيل    ");
            $("#money").focus();

            return false;
        }

        var byan = $("#byan").val();
        if (byan == "") {
            alert("من فضلك ادخل البيان بشكل واضح     ");
            $("#byan").focus();

            return false;
        }


    });

    $(document).on('change', "#account_number", function () {
   var account_number=$(this).val();
   if(account_number==""){
    $("#mov_type").val("");
   }else{
    var account_type=$("#account_number option:selected").data("type");
     if(account_type==2){
        //if is supplier مورد
        $("#mov_type").val(10); 
     }else if(account_type==3){
        //if is customer عميل
        $("#mov_type").val(5); 
     }
     else if(account_type==6){
        //if is customer عميل
        $("#mov_type").val(25); 
     }else{
       //if is Genearl عام
       $("#mov_type").val(4);  
     }


   }

    });


    $(document).on('change', "#mov_type", function () {
        var account_number=$("#account_number").val();
        if(account_number==""){
            alert("عفوا من فضلك اختر الحساب المالي اولا");
            $("#mov_type").val(""); 
            return false;
        }

    var account_type=$("#account_number option:selected").data("type");
     if(account_type==2){
        //if is supplier مورد
        $("#mov_type").val(10); 
     }else if(account_type==3){
        //if is customer عميل
        $("#mov_type").val(5); 
     }
     else if(account_type==6){
        //if is Bank بنكي
        $("#mov_type").val(25); 
     }else{
       //if is Genearl عام
       $("#mov_type").val(4);  
     }

    });

    $(document).on('change', "#account_number", function () {
 if($(this).val()!=""){

    var token_search=$("#token_search").val();
    var url=$("#ajax_url_get_account_blance").val();
var id=$(this).data("id");
jQuery.ajax({
url:url,
type:'post',
dataType:'html',
cache:false,
data:{id:id,"_token":token_search,account_number:$(this).val()},
success:function(data){

$("#get_account_blancesDiv").html(data);
$("#get_account_blancesDiv").show();

},
error:function(){

}
});



 }else{
    $("#get_account_blancesDiv").hide();
 }
   
});


});