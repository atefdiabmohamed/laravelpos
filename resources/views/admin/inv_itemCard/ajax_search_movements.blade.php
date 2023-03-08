@if (@isset($data) && !@empty($data) && count($data) >0)
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th style="width: 10%;">المخزن </th>
      <th style="width: 10%;"> القسم </th>
      <th style="width: 20%;"> الحركة </th>
      <th style="width: 22%;">  الكمية قبل الحركة </th>
      <th style="width: 23%;">  الكمية بعد الحركة </th>
      <th style="width: 15%;"></th>
   </thead>
   <tbody>
      @foreach ($data as $info )
      <tr>
         <td>{{ $info->store_name }}</td>
         <td>{{ $info->inv_itemcard_movements_categories_name }}</td>
         <td>{{ $info->inv_itemcard_movements_types_name }}</td>
         <td>
            <span style="color: brown;">       الكمية بالمخزن الحالي <br>{{ $info->quantity_befor_move_store }}  </span>
            <br>
            <span style="color:blue;">        الكمية  بكل المخازن <br>{{ $info->quantity_befor_movement }} </span>
         </td>
         <td>
            <span style="color: brown;">       الكمية بالمخزن الحالي <br>{{ $info->quantity_after_move_store }}  </span>
            <br>
            <span style="color:blue;">        الكمية  بكل المخازن <br>{{ $info->quantity_after_move }} </span>
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
      </tr>
      @php
      $i++; 
      @endphp
      @endforeach
   </tbody>
</table>
<br>
<div class="col-md-12" id="ajax_pagination_in_searchMovements">
   {{ $data->links() }}
</div>
@else
<div class="clearfix"></div>
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif
Oops.. No translation found.