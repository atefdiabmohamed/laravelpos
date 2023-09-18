@if (@isset($data) && !@empty($data) && count($data) >0)
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>كود</th>
      <th> المورد</th>
      <th> تاريخ الفاتورة</th>
      <th>  نوع الفاتورة</th>
      <th>   المخزن المستلم</th>
      <th>    اجمالي الفاتورة</th>
      <th>حالة الفاتورة</th>
      <th></th>
   </thead>
   <tbody>
      @foreach ($data as $info )
      <tr>
         <td>{{ $info->auto_serial }}</td>
         <td>{{ $info->supplier_name }}</td>
         <td>{{ $info->order_date }}</td>
         <td>@if($info->pill_type==1)  كاش  @elseif($info->pill_type==2)  اجل  @else  غير محدد @endif</td>
         <td>{{ $info->store_name }}</td>
         <td>{{ $info->total_cost*(1) }}</td>
         <td>@if($info->is_approved==1)  معتمدة   @else   مفتوحة @endif</td>
         <td>
            @if($info->is_approved==0)
            <a href="{{ route('admin.suppliers_orders.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
            <a href="{{ route('admin.suppliers_orders.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
            @endif
            <a href="{{ route('admin.suppliers_orders.show',$info->id) }}" class="btn btn-sm   btn-info">التفاصيل</a>   
            <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.suppliers_orders.printsaleswina4',[$info->id,'A4']) }}" class="btn btn-primary btn-xs"> WA4</a>
            <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.suppliers_orders.printsaleswina4',[$info->id,'A6']) }}" class="btn btn-warning btn-xs"> WA6</a>
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