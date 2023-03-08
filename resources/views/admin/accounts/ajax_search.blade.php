@if (@isset($data) && !@empty($data) && count($data)>0)
<table id="example2" class="table table-bordered table-hover">
   <thead class="custom_thead">
      <th>الاسم </th>
      <th> رقم الحساب </th>
      <th> النوع </th>
      <th>  هل أب </th>
      <th>  الحساب الاب </th>
      <th>  الرصيد </th>
      <th> التفعيل</th>
      <th></th>
   </thead>
   <tbody>
      @foreach ($data as $info )
      <tr>
         <td>{{ $info->name }}</td>
         <td>{{ $info->account_number }}</td>
         <td>{{ $info->account_types_name }}</td>
         <td>@if($info->is_parent==1) نعم  @else  لا @endif</td>
         <td>{{ $info->parent_account_name }}</td>
         <td> 
            @if($info->is_parent==0)
            @if($info->current_balance >0)
            مدين ب ({{ $info->current_balance*1 }}) جنيه  
            @elseif ($info->current_balance <0)
            دائن ب ({{ $info->current_balance*1*(-1) }})   جنيه
            @else
            متزن
            @endif
            @else
            من ميزان المراجعه
            @endif
         </td>
         <td @if($info->active==1) class="bg-success" @else class="bg-danger" @endif  >@if($info->active==1) مفعل @else معطل @endif</td> 
         <td>
            @if( $info->relatediternalaccounts==0)
            <a href="{{ route('admin.accounts.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
            @else
            يعدل من شاشته
            @endif
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