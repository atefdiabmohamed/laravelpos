@extends('layouts.admin')
@section('title')
المشتريات
@endsection
@section('contentheader')
حركات مخزنية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.suppliers_orders.index') }}">  فواتير المشتريات </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')

 
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">     فواتير المشتريات  </h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('admin.suppliers_orders.ajax_search') }}">
        
          <a href="{{ route('admin.suppliers_orders.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
        
               <div class="clearfix"></div>
               <div class="col-md-12">      
        <div id="ajax_responce_serarchDiv">
          
          @if (@isset($data) && !@empty($data) && count($data) >0)
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
           <th>كود</th>
           <th> المورد</th>
           <th> تاريخ الفاتورة</th>
           <th>  نوع الفاتورة</th>
           <th>   المخزن المستلم</th>

           
           <th>حالة الفاتورة</th>

           <th></th>

            </thead>
            <tbody>
         @foreach ($data as $info )
            <tr>
              <td>{{ $info->auto_serial }}</td>  
              <td>{{ $info->supplier_name }}</td>  
              <td>{{ $info->order_date }}</td>  
             <td>@if($info->pill_type==1)  كاش  @elseif($info->pill_type==2)  اجل  @else  غير محدد @endif</td> 
             <td>{{ $info->store_name }}</td>  

             <td>@if($info->is_approved==1)  معتمدة   @else   مفتوحة @endif</td> 

         <td>


        <a href="{{ route('admin.suppliers_orders.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
        <a href="{{ route('admin.suppliers_orders.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
        <a href="{{ route('admin.suppliers_orders.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-success">اعتماد</a>   
        <a href="{{ route('admin.suppliers_orders.show',$info->id) }}" class="btn btn-sm   btn-info">الاصناف</a>   



         </td>
           
   
           </tr> 
      @php
         $i++; 
      @endphp
         @endforeach
   
   
   
            </tbody>
             </table>
      <br>
           {{ $data->links() }}
       
           @else
           <div class="alert alert-danger">
             عفوا لاتوجد بيانات لعرضها !!
           </div>
                 @endif

        </div>
      </div>
      
      

      </div>
        </div>
     
</div>





@endsection

@section('script')
<script src="{{ asset('assets/admin/js/inv_suppliers_orders.js') }}"></script>

@endsection


