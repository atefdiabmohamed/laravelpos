@if (@isset($data) && !@empty($data))
<style>
   td{text-align: right}
</style>
@php
$i=1;   
@endphp 
<table id="example2" class="table table-bordered table-hover">
<tr>
   <td> خطة أمر التشغيل</td>
   <td>{{ $data['production_plane']}}</td>
</tr>
@if($data['updated_by']>0 and $data['updated_by']!=null )
<tr>
   <td>آخر تحديث</td>
   <td>
      @php
      $dt=new DateTime($data['updated_at']);
      $date=$dt->format("Y-m-d");
      $time=$dt->format("h:i");
      $newDateTime=date("A",strtotime($time));
      $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
      @endphp
      {{ $date }}  
      {{ $time }}
      {{ $newDateTimeType }} 
      بواسطة 
      {{ $data['updated_by_admin'] }}
   </td>
</tr>
@endif
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif