@if (@isset($details) && !@empty($details) && count($details)>0)
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>مسلسل</th>
      <th>الصنف </th>
      <th> الوحده</th>
      <th> الكمية</th>
      <th> السعر</th>
      <th> الاجمالي</th>
      <th></th>
   </thead>
   <tbody>
      @foreach ($details as $info )
      <tr>
         <td>{{ $i }}</td>
         <td>{{ $info->item_card_name }}
            @if($info->item_card_type==2)
            <br>
            تاريخ انتاج  {{ $info->production_date }} <br>
            تاريخ انتهاء  {{ $info->expire_date }} <br>
            باتش رقم {{ $info->batch_auto_serial }}
            @endif
         </td>
         <td>{{ $info->uom_name }}</td>
         <td>{{ $info->deliverd_quantity*(1) }}</td>
         <td>{{ $info->unit_price*(1) }}</td>
         <td>{{ $info->total_price*(1) }}</td>
         <td>
            @if($info->is_approved==0 and $data['is_approved']==0 and $info->is_canceld_receive==0)
            <a href="{{ route('admin.inv_stores_transfer.delete_details',["id"=>$info->id,"id_parent"=>$data['id']]) }}" class="btn btn-sm are_you_shue   btn-danger">حذف</a>   
            @endif
            @if($info->is_canceld_receive==1)
            تم الالغاء لهذا الصنف من خلال مخزن الاستلام ,
            <br>
            بسبب 
            <span style="color:brown;">{{ $info->canceld_cause }}</span>
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