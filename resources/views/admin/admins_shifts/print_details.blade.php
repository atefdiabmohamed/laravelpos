<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> طباعة تفاصيل شفت خزنية  </title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css')}}">
      <style>
         td{font-size: 15px !important;text-align: center;}
      </style>
   <body style="padding-top: 10px;font-family: tahoma;">
      <table  cellspacing="0" style="width: 30%; margin-right: 5px; float: right;  border: 1px dashed black "  dir="rtl">
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;"> كود الشفت 
               <span style="margin-right: 10px;">/ {{ $Admins_Shifts["shift_code"] }}</span>
            </td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;"> اسم مستخدم الخزنة  <span style="margin-right: 10px;">/ {{ $Admins_Shifts['admin_name'] }}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">  اسم خزنة المستخدم <span style="margin-right: 10px;">/ {{ $Admins_Shifts['treasuries_name']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   تاريخ بداية الشفت  <span style="margin-right: 10px;">/ {{ $Admins_Shifts['start_date']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">    تاريخ نهاية الشفت  <span style="margin-right: 10px;">/ {{ $Admins_Shifts['end_date']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   حالة الشفت  <span style="margin-right: 10px;">/ 
               
               @if($Admins_Shifts['is_finished']==1) تم الانتهاء @else مفتوح@endif 
               @if($Admins_Shifts['is_delivered_and_review']==1)  وتمت مراجعته 
               @else 
               @if($Admins_Shifts['is_finished']==1)  وبإنتطار المراجعة      @endif
               
               @endif   
            </span></td>
         </tr>
      </table>
      <br>
      <table style="width: 30%;float: right;  margin-right: 5px;" dir="rtl">
         <tr>
            <td style="text-align: center;padding: 5px;">  <span style=" display: inline-block;
               width: 200px;
               height: 30px;
               text-align: center;
               background: yellow !important;
               border: 1px solid black; border-radius: 15px;font-weight: bold;"> شفت رقم </span></td>
         </tr>
         <tr>
            <td style="text-align: center;padding: 5px;font-weight: bold;">  <span style=" display: inline-block;
               width: 200px;
               height: 30px;
               text-align: center;
               color: red;
               border: 1px solid black; "> رقم : {{  $Admins_Shifts["shift_code"]  }} </span></td>
         </tr>
     
      </table>
      <table style="width: 35%;float: right; margin-left: 5px; " dir="rtl">
         <tr>
            <td style="text-align:left !important;padding: 5px;">
               <img style="width: 150px; height: 110px; border-radius: 10px;" src="{{ asset('assets/admin/uploads').'/'.$systemData['photo'] }}"> 
               <p>{{ $systemData['system_name'] }}</p>
            </td>
         </tr>
      </table>
      <div class="clearfix"></div>
      <p></p>
      @if(!@empty($treasuries_transactions) and count($treasuries_transactions)>0)
      <table  dir="rtl" border="1" style="width: 98%;  auto;"  id="example2" cellpadding="1" cellspacing="0"  aria-describedby="example2_info" >
         <tr style="background-color: gainsboro">
            <td style="font-weight: bold;">م</td>
            <td style="font-weight: bold;">اسم الحركة</td>
            <td  style="font-weight: bold;">المبلغ</td>
            <td  style="font-weight: bold;">البيان </td>
            <td style="font-weight: bold;">التاريخ</td>
         
         </tr>
      
         @php $i=1; $totalItems=0; @endphp
         @foreach($treasuries_transactions as $info)
         <tr>
            <td>
               {{ $i }}
            </td>
            <td>
               {{ $info->mov_type_name }}
            </td>
            <td>
               {{$info->money*1  }}
            </td>
            <td>
               {{ $info->byan }}
            </td>
           
            <td > 
               @php
               $dt=new DateTime($info->created_at);
               $date=$dt->format("Y-m-d");
               $time=$dt->format("h:i");
               $newDateTime=date("A",strtotime($time));
               $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
               @endphp
               {{ $date }} <br>
               {{ $time }}
               {{ $newDateTimeType }}
            </td>
         </tr>
         <?php $i++; endforeach;?>
         <tr>
            <td colspan="8" style="color:brown !important">
               <br> 
                  اجمالي تحصيل النقدية بهذا الشفت  
               <?=$total_collect*1?> جنيه فقط لاغير 
               <br>
               اجمالي صرف النقدية بهذا الشفت  
               <?=$total_excahnge*1?> جنيه فقط لاغير 
               <br>

               صافي النقدية بهذا الشفت  
               <?=$total_net*1?> جنيه فقط لاغير 
            </td>
         </tr>

      </table>
      @else
      <p style="text-align: center">  عفوا لاتوجد حركات نقدية بهذا الشفت</p>
      @endif
      <br>
    
      <p style="position: fixed;
         padding: 10px 10px 0px 10px;
         bottom: 0;
         width: 100%;
         /* Height of the footer*/ 
         text-align: center;font-size: 16px; font-weight: bold;
         "> {{ $systemData['address'] }} - {{ $systemData['phone'] }} </p>
      <script>
         window.print();
           
      </script> 
   </body>
</html>