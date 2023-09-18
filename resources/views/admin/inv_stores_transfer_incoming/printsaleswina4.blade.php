<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> طباعة أمر تحويل مخزني صادر     </title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css')}}">
      <style>
         td{font-size: 15px !important;text-align: center;}
      </style>
   <body style="padding-top: 10px;font-family: tahoma;">
      <table  cellspacing="0" style="width: 30%; margin-right: 5px; float: right;  border: 1px dashed black "  dir="rtl">
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;"> كود أمر التحويل  
               <span style="margin-right: 10px;">/ {{ $data["auto_serial"] }}</span>
            </td>
         </tr>
         <td style="padding: 5px; text-align: right;font-weight: bold;">   تاريخ الامر  <span style="margin-right: 10px;">/ {{ $data['order_date']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   مخزن الصرف  <span style="margin-right: 10px;">/ {{ $data['from_store_name']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   مخزن الاستلام  <span style="margin-right: 10px;">/ {{ $data['to_store_name']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   حالة الامر  <span style="margin-right: 10px;">/ @if($data['is_approved']==1) مؤرشف @else غير مؤرشف @endif</span></td>
         </tr>
      </table>
      <br>
      <table style="width: 30%;float: right;  margin-right: 5px;" dir="rtl">
         <tr>
            <td style="text-align: center;padding: 5px;">  <span style=" display: inline-block;
               width: 350px;
               height: 30px;
               text-align: center;
               background: yellow !important;
               border: 1px solid black; border-radius: 15px;font-weight: bold;">أمر تحويل مخزني     </span></td>
         </tr>
         <tr>
            <td style="text-align: center;padding: 5px;font-weight: bold;">  <span style=" display: inline-block;
               width: 200px;
               height: 30px;
               text-align: center;
               color: red;
               border: 1px solid black; "> رقم : {{ $data['auto_serial'] }} </span></td>
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
      <table  dir="rtl" border="1" style="width: 98%;  auto;"  id="example2" cellpadding="1" cellspacing="0"  aria-describedby="example2_info" >
         <tr style="background-color: gainsboro">
            <td style="font-weight: bold;">م</td>
            <td style="font-weight: bold;">كود</td>
            <td  style="font-weight: bold;">الصنف</td>
            <td  style="font-weight: bold;">الوحدة </td>
            <td style="font-weight: bold;">الكمية</td>
            <td  style="font-weight: bold;">السعر</td>
            <td style="font-weight: bold;">اجمالي</td>
         </tr>
         @if(!@empty($sales_invoices_details) and count($sales_invoices_details)>0)
         @php $i=1; $totalItems=0; @endphp
         @foreach($sales_invoices_details as $info)
         <tr>
            <td>
               {{ $i }}
            </td>
            <td>
               {{ $info->item_code }}
            </td>
            <td>
               {{ $info->item_card_name }}
            </td>
            <td>
               {{$info->uom_name  }}
            </td>
            <td>
               {{$info->deliverd_quantity*1  }}
            </td>
            <td>
               {{$info->unit_price*1  }}
            </td>
            <td>
               {{$info->total_price*1  }}                                  
            </td>
         </tr>
         <?php $i++; endforeach;?>
         <tr>
            <td colspan="8" style="color:brown !important"><br>  اجمالي الاصناف  
               <?=$data['total_cost_items']*1?> جنيه فقط لاغير 
            </td>
         </tr>
         @endif
      </table>
      <br>
      <table  dir="rtl" border="1" style="width: 98%; margin: 0 auto;"  id="example2" cellpadding="1" cellspacing="0"  aria-describedby="example2_info" >
         <tr >
            <td style="font-weight: bold;">عدد الاصناف المضافة للأمر</td>
            <td style="font-weight: bold;">اجمالي قيمة الاصناف</td>
         </tr>
         <tr>
            <td>{{ $data["items_counter"]*(1)}}</td>
            <td>{{$data['total_cost_items']*(1)}}</td>
         </tr>
      </table>
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