
          @if (@isset($data) && !@empty($data))

          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
        
           <th>الاسم </th>
           <th> رقم الحساب </th>
           <th> النوع </th>
           <th>  هل أب </th>
           <th>  الحساب الاب </th>
           <th>  الرصيد </th>
           <th>حالة التفعيل</th>
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
             <td></td>  

             <td>@if($info->is_archived==1) مفعل @else معطل @endif</td> 
      
         <td>

        <a href="{{ route('admin.accounts.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
        <a href="{{ route('admin.accounts.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
        <a href="{{ route('admin.accounts.show',$info->id) }}" class="btn btn-sm   btn-info">عرض</a>   

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
