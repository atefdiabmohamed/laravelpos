@if (@isset($data) && !@empty($data))
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>مسلسل</th>
      <th>اسم الخدمة</th>
      <th> نوع الخدمة</th>
      <th>حالة التفعيل</th>
      <th> تاريخ الاضافة</th>
      <th> تاريخ التحديث</th>
      <th></th>
   </thead>
   <tbody>
      @foreach ($data as $info )
      <tr>
         <td>{{ $i }}</td>
         <td>{{ $info->name }}</td>
         <td>@if($info->type==1)  خدمات مقدمة لنا @else  خدمات نقدمها للغير @endif</td>
         <td>@if($info->active==1) مفعل @else معطل @endif</td>
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
            <a href="{{ route('admin.Services.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
            <a href="{{ route('admin.Services.delete',$info->id) }}" class="btn are_you_shue btn-sm  btn-danger">حذف</a>   
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