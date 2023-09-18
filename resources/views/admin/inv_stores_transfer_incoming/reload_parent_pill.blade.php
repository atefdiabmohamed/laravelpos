@if (@isset($data) && !@empty($data))
<table id="example2" class="table table-bordered table-hover">
   <tr>
      <td class="width30"> كود  امر التحويل</td>
      <td > {{ $data['auto_serial'] }}</td>
   </tr>
   <tr>
      <td class="width30">   تاريخ الامر </td>
      <td > {{ $data['order_date'] }}</td>
   <tr>
      <td class="width30">  اسم  مخزن الصرف </td>
      <td > {{ $data['from_store_name'] }}</td>
   </tr>
   <tr>
      <td class="width30">     اسم مخزن الاستلام  </td>
      <td > {{ $data['to_store_name'] }}</td>
   </tr>
   <tr>
      <td class="width30">    عدد الاصناف المضافة  </td>
      <td > {{ $data['items_counter']*(1) }}</td>
   </tr>
   <tr>
      <td class="width30">   اجمالي تكلفة الاصناف </td>
      <td > {{ $data['total_cost_items']*(1) }}</td>
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
         <a href="{{ route('admin.inv_stores_transfer.delete',$data['id']) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
         <a href="{{ route('admin.inv_stores_transfer.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
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