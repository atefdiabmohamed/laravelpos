
          @if (@isset($data) && !@empty($data) && count($data)>0)
         
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
        
           <th>الاسم </th>
           <th>  الكود </th>
           <th>  الفئة </th>
           <th> رقم الحساب </th>
           <th>  الرصيد </th>
           <th>  الهاتف </th>
           <th>  ملاحظات </th>
           <th> التفعيل</th>
          <th></th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
           
             <td>{{ $info->name }}</td>  
             <td>{{ $info->suuplier_code }}</td>  
             <td>{{ $info->suppliers_categories_name }}</td>  

             
             <td>{{ $info->account_number }}</td>  
             <td> 
           
              @if($info->current_balance >0)
              مدين ب ({{ $info->current_balance*1 }}) جنيه  
              @elseif ($info->current_balance <0)
              دائن ب ({{ $info->current_balance*1*(-1) }})   جنيه
  
            @else
        متزن
            @endif
            
              </td>
              <td>{{ $info->phones }}</td>  
              <td>{{ $info->notes }}</td>  




              <td @if($info->active==1) class="bg-success" @else class="bg-danger" @endif  >@if($info->active==1) مفعل @else معطل @endif</td> 
      
         <td>

        <a href="{{ route('admin.supplier.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   

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
