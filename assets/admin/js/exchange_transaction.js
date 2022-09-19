$(document).ready(function () {

    $(document).on('click', "#do_exchange_now_btn", function () {
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
 var treasuries_balance=$("#treasuries_balance").val();
 if(treasuries_balance=="" || treasuries_balance==0){
alert("عفوا لايوجد رصيد كافي لديك بالخزنة !!! ");
$("#money").focus();
return false;
 }
 if(parseFloat(money)>parseFloat(treasuries_balance)){
    alert("عفوا لايوجد رصيد كافي لديك بالخزنة !!! ");
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
               $("#mov_type").val(9); 
            }else if(account_type==3){
               //if is customer عميل
               $("#mov_type").val(6); 
            }
            else if(account_type==6){
               //if is Bank بنكي
               $("#mov_type").val(18); 
            }else{
              //if is Genearl عام
              $("#mov_type").val(3);  
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
             $("#mov_type").val(9); 
          }else if(account_type==3){
             //if is customer عميل
             $("#mov_type").val(6); 
          }
          else if(account_type==6){
             //if is Bank بنكي
             $("#mov_type").val(18); 
          }else{
            //if is Genearl عام
            $("#mov_type").val(3);  
          }
     
         });




});