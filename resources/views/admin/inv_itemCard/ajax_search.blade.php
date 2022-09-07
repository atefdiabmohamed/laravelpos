  
          @if (@isset($data) && !@empty($data) && count($data) >0)
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>مسلسل</th>
           <th>الاسم </th>
           <th> النوع </th>
           <th> الفئة </th>
           <th> الصنف الاب </th>
           <th> الوحدة الاب </th>
           <th> الوحدة التجزئة </th>
           <th>حالة التفعيل</th>
         
           <th></th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
             <td>{{ $i }}</td>  
             <td>{{ $info->name }}</td>  
             <td>@if($info->item_type==1) مخزني  @elseif($info->item_type==2) استهلاكي بصلاحية   @elseif($info->item_type==3) عهدة @else غير محدد @endif</td>  
             <td>{{ $info->inv_itemcard_categories_name }}</td>  
             <td>{{ $info->parent_item_name }}</td>  
             <td>{{ $info->Uom_name }}</td>  
             <td>{{ $info->retail_uom_name }}</td>  


             <td>@if($info->active==1) مفعل @else معطل @endif</td> 
      
         <td>

        <a href="{{ route('admin.itemcard.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
        <a href="{{ route('admin.itemcard.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
        <a href="{{ route('admin.itemcard.show',$info->id) }}" class="btn btn-sm   btn-info">عرض</a>   

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
