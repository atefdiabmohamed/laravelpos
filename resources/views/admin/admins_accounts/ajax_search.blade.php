@if (@isset($data) && !@empty($data) && count($data) >0)
@php
$i=1;   
@endphp
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>مسلسل</th>
      <th>اسم المستخدم</th>
      <th>دور صلاحية المستخدم </th>
      <th>حالة التفعيل</th>
      <th></th>
   </thead>
   <tbody>
      @foreach ($data as $info )
      <tr>
         <td>{{ $i }}</td>
         <td>{{ $info->name }}</td>
         <td>{{ $info->permission_roles_name }}</td>
         <td>@if($info->active==1) مفعل @else معطل @endif</td>
         <td>
            <a href="{{ route('admin.admins_accounts.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
            <a href="{{ route('admin.admins_accounts.details',$info->id) }}" class="btn btn-sm  btn-info">صلاحيات خاصة</a>   
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
<div class="clearfix"></div>
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif