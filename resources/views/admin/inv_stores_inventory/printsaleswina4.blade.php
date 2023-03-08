<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> طباعة أمر جرد مخازن  </title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css')}}">
      <style>
         td{font-size: 15px !important;text-align: center;}
      </style>
   <body style="padding-top: 10px;font-family: tahoma;">
      <table  cellspacing="0" style="width: 30%; margin-right: 5px; float: right;  border: 1px dashed black "  dir="rtl">
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   تاريخ امر الجرد  <span style="margin-right: 10px;">/ {{ $data['inventory_date']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">    مخزن الجرد  <span style="margin-right: 10px;">/ {{ $data['store_name']}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">  نوع الجرد 
               <span style="margin-right: 10px;">/
               @if($data['inventory_type']==1)جرد يومي 
               @elseif($data['inventory_type']==2)جرد اسبوعي  
               @elseif($data['inventory_type']==3)جرد شهري  
               @elseif($data['inventory_type']==4)جرد سنوي  
               @else     لم يحدد @endif
               </span>
            </td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   حالة امر الجرد  <span style="margin-right: 10px;">/ @if($data['is_closed']==1) مغلق ومرحل @else  مفتوح @endif</span></td>
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
               border: 1px solid black; border-radius: 15px;font-weight: bold;"> امر جرد  </span></td>
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
      @if(!@empty($invoices_details) and count($invoices_details)>0)
      <table  dir="rtl" border="1" style="width: 98%;  margin: 0 auto;"  id="example2" cellpadding="1" cellspacing="0"  aria-describedby="example2_info" >
         <tr style="background-color: gainsboro">
            <td style="font-weight: bold;">م</td>
            <td  style="font-weight: bold;">كود باتش</td>
            <td  style="font-weight: bold;">اسم الصنف </td>
            <td  style="font-weight: bold;"> الكمية بالباتش</td>
            <td  style="font-weight: bold;"> الكمية الدفترية</td>
            <td  style="font-weight: bold;"> الفرق</td>
            <td  style="font-weight: bold;"> تكلفة الوحدة</td>
            <td  style="font-weight: bold;"> اجمالي التكلفة</td>
            <td  style="font-weight: bold;">  سبب النقص / الزيادة</td>
         </tr>
         @php $i=1;  @endphp
         @foreach($invoices_details as $info)
         <tr>
            <td>{{ $i }}</td>
            <td>
               {{ $info->batch_auto_serial }} <br>
               @if($info->item_type==2)
               تاريخ انتاج <br>{{ $info->production_date }} <br>
               تاريخ انتهاء <br>{{ $info->expired_date }} 
               @endif
            </td>
            <td>{{ $info->item_name }}</td>
            <td>{{ $info->old_quantity*(1) }}</td>
            <td>{{ $info->new_quantity*(1) }}</td>
            <td>{{ $info->diffrent_quantity*(1) }}</td>
            <td>{{ $info->unit_cost_price*(1) }}</td>
            <td>{{ $info->total_cost_price*(1) }}</td>
            <td>{{ $info->notes }}</td>
         </tr>
         <?php $i++; endforeach;?>
      </table>
      @endif
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