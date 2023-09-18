@if (@isset($data) && !@empty($data) && count($data) >0)
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>مسلسل</th>
      <th>كود </th>
      <th> تاريخ أمر التشغيل </th>
      <th>حالة الاعتماد</th>
      <th>حالة الإغلاق</th>
      <th> تاريخ الاضافة</th>
      <th>المزيد</th>
   </thead>
   <tbody>
      @foreach ($data as $info )
      <tr>
         <td>{{ $i }}</td>
         <td>{{ $info->auto_serial }}</td>
         <td>{{ $info->production_plan_date }}</td>
         <td>@if($info->is_approved==1)  معتمد
            <br>
            @php   $dt=new DateTime($info->approved_at);
            $date=$dt->format("Y-m-d");
            $time=$dt->format("h:i");
            $newDateTime=date("A",strtotime($time));
            $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
            @endphp
            {{ $date }} <br>
            {{ $time }}
            {{ $newDateTimeType }}  <br>
            بواسطة 
            {{ $info->approved_by_admin}}
            @else  
            غير معتمد 
            <a href="{{ route('admin.inv_production_order.do_approve',$info->id) }}" class="btn are_you_shue btn-sm  btn-success">اعتماد</a>   
            @endif
         </td>
         <td>@if($info->is_closed==1) مغلق ومرحل 
            <br>
            @php   $dt=new DateTime($info->closed_at);
            $date=$dt->format("Y-m-d");
            $time=$dt->format("h:i");
            $newDateTime=date("A",strtotime($time));
            $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
            @endphp
            {{ $date }} <br>
            {{ $time }}
            {{ $newDateTimeType }}  <br>
            بواسطة 
            {{ $info->closed_by_admin}}
            @else مفتوح 
            @if($info->is_approved==1)
            <a href="{{ route('admin.inv_production_order.do_closes_archive',$info->id) }}" class="btn are_you_shue btn-sm  btn-success">اغلاق وترحيل</a>   
            @endif
            @endif
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
            {{ $newDateTimeType }}  <br>
            بواسطة 
            {{ $info->added_by_admin}}
         </td>
         <td>
            @if($info->is_closed==0) 
            <a href="{{ route('admin.inv_production_order.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
            <a href="{{ route('admin.inv_production_order.delete',$info->id) }}" class="btn are_you_shue btn-sm  btn-danger">حذف</a>   
            @endif
            <button data-id="{{ $info->id }}" class="btn show_more_detials btn-sm  btn-info">عرض</button>   
         </td>
      </tr>
      @php
      $i++; 
      @endphp
      @endforeach
   </tbody>
</table>
<br>
<div class="col-md-12" id="ajax_pagination_in_search">
   {{ $data->links() }}
</div>
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif