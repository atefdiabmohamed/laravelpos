@if (@isset($data) && !@empty($data) && count($data) >0)
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>كود</th>
      <th> تاريخ الجرد</th>
      <th>نوع الجرد</th>
      <th> مخزن الجرد</th>
      <th>  حالة الجرد</th>
      <th> تاريخ الاضافة</th>
      <th></th>
   </thead>
   <tbody>
      @foreach ($data as $info )
      <tr>
         <td>{{ $info->auto_serial }}</td>
         <td>{{ $info->inventory_date }}</td>
         <td>
            @if($info->inventory_type==1)جرد يومي 
            @elseif($info->inventory_type==2)جرد اسبوعي  
            @elseif($info->inventory_type==3)جرد شهري  
            @elseif($info->inventory_type==4)جرد سنوي  
            @else     لم يحدد @endif
         </td>
         <td>{{ $info->store_name }}</td>
         <td>@if($info->is_closed==1)  مغلق ومرحل   @else   مفتوح @endif</td>
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
            <a href="{{ route('admin.stores_inventory.edit',$info->id) }}" class="btn btn-sm  btn-success">تعديل</a>   
            <a href="{{ route('admin.stores_inventory.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
            @endif
            <a href="{{ route('admin.stores_inventory.show',$info->id) }}" class="btn btn-sm   btn-info">التفاصيل</a>   
            <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.stores_inventory.printsaleswina4',[$info->id,'A4']) }}" class="btn btn-primary btn-xs"> WA4</a>
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