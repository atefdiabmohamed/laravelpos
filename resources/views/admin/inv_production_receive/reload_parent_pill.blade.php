@if (@isset($data) && !@empty($data))
<table id="example2" class="table table-bordered table-hover">
   <tr>
      <td class="width30"> كود الفاتورة الالي</td>
      <td > {{ $data['auto_serial'] }}</td>
   </tr>
   <tr>
      <td class="width30">   تاريخ الفاتورة </td>
      <td > {{ $data['order_date'] }}</td>
   </tr>
   <tr>
      <td class="width30">    كود أمر التشغيل </td>
      <td > {{ $data['inv_production_order_auto_serial'] }}</td>
   </tr>
   <tr>
      <td class="width30">  اسم خط الانتاج </td>
      <td > {{ $data['production_lines_name'] }}</td>
   </tr>
   <tr>
      <td class="width30"> نوع الفاتورة</td>
      <td > @if($data['pill_type']==1) كاش  @else اجل@endif</td>
   </tr>
   <tr>
      <td class="width30">     مخزن استلام الانتاج  </td>
      <td > {{ $data['store_name'] }}</td>
   </tr>
   <tr>
      <td class="width30">   اجمالي الاصناف علي الفاتورة </td>
      <td > {{ $data['total_befor_discount']*(1) }}</td>
   </tr>
   @if ($data['discount_type']!=null)
   <tr>
      <td class="width30">   الخصم علي الفاتورة </td>
      <td> 
         @if ($data['discount_type']==1)
         خصم نسبة ( {{ $data['discount_percent']*1 }} ) وقيمتها ( {{ $data["discount_value"]*1 }} )
         @else
         خصم يدوي وقيمته( {{ $data["discount_value"]*1 }} )
         @endif
      </td>
   </tr>
   @else
   <tr>
      <td class="width30">   الخصم علي الفاتورة </td>
      <td > لايوجد</td>
   </tr>
   @endif
   <tr>
      <td class="width30">    نسبة القيمة المضافة </td>
      <td > 
         @if($data['tax_percent']>0)
         لايوجد
         @else
         بنسبة ({{ $data["tax_percent"]*1 }}) %  وقيمتها ( {{ $data['tax_value']*1 }} )
         @endif
      </td>
   </tr>
   <tr>
      <td class="width30">   اجمالي الفاتورة </td>
      <td > {{ $data['total_cost']*(1) }}</td>
   </tr>
   <tr>
      <td class="width30">       حالة الفاتورة </td>
      <td > @if($data['is_approved']==1)  مغلق ومؤرشف @else مفتوحة  @endif</td>
   </tr>
   <tr>
      <td class="width30">  تاريخ  الاضافة</td>
      <td > 
         @php
         $dt=new DateTime($data['created_at']);
         $date=$dt->format("Y-m-d");
         $time=$dt->format("h:i");
         $newDateTime=date("A",strtotime($time));
         $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
         @endphp
         {{ $date }}
         {{ $time }}
         {{ $newDateTimeType }}
         بواسطة 
         {{ $data['added_by_admin'] }}
      </td>
   </tr>
   <tr>
      <td class="width30">  تاريخ اخر تحديث</td>
      <td > 
         @if($data['updated_by']>0 and $data['updated_by']!=null )
         @php
         $dt=new DateTime($data['updated_at']);
         $date=$dt->format("Y-m-d");
         $time=$dt->format("h:i");
         $newDateTime=date("A",strtotime($time));
         $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
         @endphp
         {{ $date }}
         {{ $time }}
         {{ $newDateTimeType }}
         بواسطة 
         {{ $data['updated_by_admin'] }}
         @else
         لايوجد تحديث
         @endif
         @if($data['is_approved']==0)
         <a href="{{ route('admin.inv_production_Receive.delete',$data['id']) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
         <a href="{{ route('admin.inv_production_Receive.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
         <button id="load_close_approve_invoice"  class="btn btn-sm btn-primary">تحميل الاعتماد والترحيل</button>
         @endif
      </td>
   </tr>
</table>
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif