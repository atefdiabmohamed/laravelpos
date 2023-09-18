@if (@isset($allitemscardData) && !@empty($allitemscardData))
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th style="width:10%;">كود  </th>
      <th style="width:20%;">الاسم </th>
      <th style="width:70%;"> الكميات بالمخازن</th>
   </thead>
   <tbody>
      @foreach ($allitemscardData as $info )
      <tr>
         <td>{{ $info->item_code }}</td>
         <td>{{ $info->name }}</td>
         <td>
            كل الكمية بنتيجة البحث (  {{ $info->allQuantitySearch*1 }} {{ $info->Uom_name }}  ) <br> <br>
            <h3 style="text-align: center; font-size:15px; color:brown;">تفاصيل كميات الصنف بالمخازن</h3>
            @if ( !@empty($info->allBathces) and count($info->allBathces)>0
            )
            <table id="example2" class="table table-bordered table-hover">
               <thead class="bg-info" >
                  <th style="width:20%;">رقم الباتش  </th>
                  <th style="width:20%;">المخزن </th>
                  <th style="width:60%;">  الكمية</th>
               </thead>
               <tbody>
                  @foreach ($info->allBathces as $Det )
                  <tr>
                     <td @if($Det->quantity==0) class="bg-danger"  @endif>{{ $Det->auto_serial }}</td>
                     <td>{{ $Det->store_name }}</td>
                     <td >
                        عدد ( {{ $Det->quantity*1 }} ) {{ $info->Uom_name }}  بإجمالي تكلفة  ( {{ $Det->total_cost_price*1 }} جنيه ) <br>
                        بسعر  ( {{ $Det->unit_cost_price*(1) }} جنيه ) لوحدة {{ $info->Uom_name }} 
                        @if($info->does_has_retailunit==1)
                        <br> 
                        @if($info->item_type==2)
                        تاريخ انتاج ( {{ $Det->production_date }} ) <br>
                        تاريخ انتهاء ( {{ $Det->expired_date }} ) <br>
                        @endif
                        <span style="color: brown;"> مايوزاي بوحدة التجزئة</span>
                        <br>
                        عدد ( {{ $Det->qunatityRetail*1 }} ) {{ $info->retail_uom_name }} بإجمالي تكلفة  ({{ $Det->total_cost_price*1 }} جنيه) <br>
                        بسعر  ( {{ $Det->priceRetail*(1) }} جنيه ) لوحدة {{ $info->retail_uom_name }}  
                        @endif
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
            @else
            <h3 style="text-align: center; font-size:13px; color:brown;">   لاتوجد باتشات لهذا الصنف</h3>
            @endif
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
   {{ $allitemscardData->links() }}
</div>
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif