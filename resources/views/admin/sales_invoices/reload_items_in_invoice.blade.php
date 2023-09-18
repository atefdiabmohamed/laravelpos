<h3 class="card-title card_title_center">       الاصناف المضافة علي الفاتورة  </h3>
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>المخزن</th>
      <th>نوع البيع</th>
      <th>الصنف</th>
      <th>وحدة البيع</th>
      <th>سعر الوحدة</th>
      <th>الكمية</th>
      <th>الاجمالي</th>
      <th></th>
   </thead>
   <tbody id="itemsrowtableContainterBody">
      @if(!@empty($sales_invoices_details))
      @foreach ($sales_invoices_details as $info )
      <tr>
         <td>
            {{ $info->store_name }}
            <input type="hidden" name="item_total_array[]" class="item_total_array" value="{{$info->total_price}}">
         </td>
         <td>
            @if($info->sales_item_type==1) قطاعي   @elseif($info->sales_item_type==2) نص جملة @elseif($info->sales_item_type==3) جملة @else  لم يحدد @endif
         </td>
         <td>{{ $info->item_name }}</td>
         <td>{{ $info->uom_name }}</td>
         <td>{{ $info->unit_price*1 }}</td>
         <td>{{ $info->quantity*1 }}</td>
         <td>{{ $info->total_price*1 }}</td>
         <td>
            <button  data-id="{{ $info->id }}" class="btn are_you_shue remove_active_row_item btn-sm btn-danger">حذف</button>  
         </td>
      </tr>
      @endforeach
      @endif
   </tbody>
</table>