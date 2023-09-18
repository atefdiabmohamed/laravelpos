@if (@isset($data) && !@empty($data)&& count($data)>0)
@php
$i=1;   
@endphp
<p class="text-center" style="font-size: 15px; color:brown;font-weight: bold"> اجمالي الصرف طبقا لنتجية البحث ({{ $totalExchangeInSearch*1*(-1) }})</p>
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>كود الي</th>
      <th> رقم الايصال</th>
      <th> الخزنة</th>
      <th>  المبلغ</th>
      <th>  الحركة</th>
      <th>  الحساب المالي</th>
      <th>  البيان</th>
      <th> المستخدم</th>
      <th></th>
   </thead>
   <tbody>
      @foreach ($data as $info )
      <tr>
         <td>{{ $info->auto_serial }}</td>
         <td>{{ $info->isal_number }}</td>
         <td>{{ $info->treasuries_name }}
            <br>
            شفت ({{ $info->shift_code }})
         </td>
         <td>{{ $info->money*(1)*(-1) }}</td>
         <td>{{ $info->mov_type_name }}</td>
         <td>{{ $info->account_name }} <br>
            ({{ $info->account_type_name }})
         </td>
         <td>{{ $info->byan }}</td>
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
            <a href="{{ route('admin.treasuries.edit',$info->id) }}" class="btn btn-sm  btn-primary">طباعة</a>   
            <a href="{{ route('admin.treasuries.details',$info->id) }}" class="btn btn-sm  btn-info">المزيد</a>   
         </td>
      </tr>
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