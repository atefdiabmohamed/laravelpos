<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> طباعة  كشف حساب عميل </title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css')}}">
      <style>
         @media print {    
         .hidden-print{display:none;}
         }
         td{font-size: 15px !important;text-align: center;}
      </style>
   <body style="padding-top: 10px;font-family: tahoma;">
      <table  cellspacing="0" style="width: 30%; margin-right: 5px; float: right;   "  dir="rtl">
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;"> كود العميل 
               <span style="margin-right: 10px;">/ {{ $data["suuplier_code"] }}</span>
            </td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;"> اسم العميل  <span style="margin-right: 10px;">/ {{ $data['name'] }}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">  رقم التيلفون  <span style="margin-right: 10px;">/ {{ $data['phones'];}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   تاريخ الاضافة  <span style="margin-right: 10px;">/ {{ $data['date'];}}</span></td>
         </tr>
         <tr>
            <td style="padding: 5px; text-align: right;font-weight: bold;">   
               <button class="btn btn-sm btn-primary hidden-print "  onclick="window.print()" >طباعة</button>
            </td>
         </tr>
      </table>
      <table style="width: 30%;float: right;  margin-right: 5px;" dir="rtl">
         <tr>
            <td style="text-align: center;padding: 5px;">  <span > نوع التقرير </span></td>
         </tr>
         <tr>
            <td style="text-align: center;padding: 5px;font-weight: bold;">  <span style=" display: inline-block;
               width: 400px;
               height: 30px;
               text-align: center;
               color: red;
               border: 1px solid black; ">  
               تقرير حركة النقدية من  ({{ $data['from_date'] }} الي  {{   $data['to_date'] }})
               </span>
            </td>
         </tr>
         <tr>
            <td style="text-align: center;padding: 5px;font-weight: bold;"> 
               <span style=" display: inline-block;
                  width: 200px;
                  height: 30px;
                  text-align: center;
                  color: blue;
                  border: 1px solid black; "> 
               طبع بتاريخ @php echo date('Y-m-d'); @endphp
               </span>
            </td>
         </tr>
         <tr>
            <td style="text-align: center;padding: 5px;font-weight: bold;"> 
               <span style=" display: inline-block;
                  width: 200px;
                  height: 30px;
                  text-align: center;
                  color: blue;
                  border: 1px solid black; "> 
               طبع بواسطة {{ auth()->user()->name }}
               </span>
            </td>
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
      <br>
      <table  dir="rtl" border="1" style="width: 98%; margin: 0 auto;"  id="example2" cellpadding="1" cellspacing="0"  aria-describedby="example2_info" >
         <tr>
            <td style="width: 25%; text-align: right; font-weight: bold">رقم الحساب المالي للعميل</td>
            <td style="width: 75%;text-align: right; padding-right: 5px; ">{{ $data['account_number'] }}</td>
         </tr>
         <td style="width: 25%; text-align: right; font-weight: bold">    اجمالي صرف النقدية للعميل</td>
         <td style="width: 75%;text-align: right; padding-right: 5px; "> 
            ({{ $data['treasuries_transactionsExchange']*1 }}) جنيه
         </td>
         </tr>
         <tr>
            <td style="width: 25%; text-align: right; font-weight: bold">    اجمالي تحصيل النقدية من للعميل</td>
            <td style="width: 75%;text-align: right; padding-right: 5px; "> 
               ({{ $data['treasuries_transactionsCollect']*1*(-1) }}) جنيه
            </td>
         </tr>
         <tr>
            <td style="width: 25%; text-align: right; font-weight: bold">   رصيد العميل حاليا</td>
            <td style="width: 75%;text-align: right; padding-right: 5px; ">
               @if($data['the_final_Balance'] >0)
               مدين ب ({{ $data['the_final_Balance']*1 }}) جنيه  
               @elseif ($data['the_final_Balance'] <0)
               دائن ب ({{ $data['the_final_Balance']*1*(-1) }})   جنيه
               @else
               متزن
               @endif
            </td>
         </tr>
      </table>
      <!--  حركة النقدية-->
      <h3 style="font-size: 16px; text-align: center; margin-top: 5px;font-weight: bold">   حركة النقدية علي حساب  العميل خلال الفترة</h3>
      @if (@isset($details['Treasuries_transactions']) && !@empty($details['Treasuries_transactions']) && count($details['Treasuries_transactions'])>0)
      <table dir="rtl" id="example2" class="table table-bordered table-hover" style="width: 99%;margin: 0 auto;">
         <thead style="background-color: lightgrey">
            <th>رقم الايصال</th>
            <th>تاريخ الحركة</th>
            <th> نوع الحركة</th>
            <th> المبلغ</th>
            <th> البيان</th>
         </thead>
         <tbody>
            @foreach ($details['Treasuries_transactions'] as $info )
            <tr>
               <td>{{ $info->auto_serial }}</td>
               <td> {{ $info->money_for_account*1 }}</td>
               <td> {{ $info->move_date }}</td>
               <td> {{ $info->mov_type_name }}</td>
               <td>{{ $info->byan }}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
      @else
      <div class="alert alert-danger">
         عفوا لاتوجد بيانات لعرضها !!
      </div>
      @endif
      <br>
      <br>
      <p style="
         padding: 10px 10px 0px 10px;
         bottom: 0;
         width: 100%;
         /* Height of the footer*/ 
         text-align: center;font-size: 16px; font-weight: bold;
         "> {{ $systemData['address'] }} - {{ $systemData['phone'] }} </p>
   </body>
</html>