@if (@isset($details) && !@empty($details) && count($details)>0)
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>مسلسل</th>
      <th>اسم الخدمة </th>
      <th> الاجمالي</th>
      <th> ملاحظات</th>
      <th> الاضافة</th>
      <th> التحديث</th>
      <th></th>
   </thead>
   <tbody>
      @foreach ($details as $info )
      <tr>
         <td>{{ $i }}</td>
         <td>{{ $info->service_name }}</td>
         <td>{{ $info->total*(1) }}</td>
         <td>{{ $info->notes }}</td>
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
         <td > 
            @if($info->updated_by>0 and $info->updated_by!=null )
            @php
            $dt=new DateTime($info->updated_at);
            $date=$dt->format("Y-m-d");
            $time=$dt->format("h:i");
            $newDateTime=date("A",strtotime($time));
            $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
            @endphp
            {{ $date }}  <br>
            {{ $time }}
            {{ $newDateTimeType }}  <br>
            بواسطة 
            {{ $data['updated_by_admin'] }}
            @else
            لايوجد تحديث
            @endif
         </td>
         <td>
            @if($data['is_approved']==0)
            <button data-id="{{ $info->id }}" class="btn btn-sm load_edit_item_details  btn-primary">تعديل</button>   
            <a href="{{ route('admin.Services_orders.delete_details',["id"=>$info->id,"id_parent"=>$data['id']]) }}" class="btn btn-sm are_you_shue   btn-danger">حذف</a>   
            @endif
         </td>
      </tr>
      @php
      $i++; 
      @endphp
      @endforeach
   </tbody>
</table>
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif