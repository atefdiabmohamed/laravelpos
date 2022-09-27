@extends('layouts.admin')
@section('title')
المبيعات
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('contentheader')
فواتير المبيعات 
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.SalesInvoices.index') }}">  المبيعات  </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')

 
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">     فواتير المبيعات للعملاء  </h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
          <input type="hidden" id="ajax_search_url" value="{{ route('admin.SalesInvoices.ajax_search') }}">
          <input type="hidden" id="ajax_get_item_uoms" value="{{ route('admin.SalesInvoices.get_item_uoms') }}">
          <input type="hidden" id="ajax_get_load_modal_add" value="{{ route('admin.SalesInvoices.load_modal_add') }}">
          <input type="hidden" id="ajax_get_item_batches" value="{{ route('admin.SalesInvoices.get_item_batches') }}">
          <input type="hidden" id="ajax_get_item_unit_price" value="{{ route('admin.SalesInvoices.get_item_unit_price') }}">
          <input type="hidden" id="ajax_get_Add_new_item_row" value="{{ route('admin.SalesInvoices.get_Add_new_item_row') }}">


          
      
          
          
          <button class="btn btn-sm btn-success" id="LoadModalAddBtn" >اضافة فاتورة جديدة</button>
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
           <th>    اجمالي الفاتورة</th>
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
             <td>{{ $info->total_cost*(1) }}</td>  

             <td>@if($info->is_approved==1)  معتمدة   @else   مفتوحة @endif</td> 

         <td>

          @if($info->is_approved==0)
        <a href="{{ route('admin.suppliers_orders.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
        <a href="{{ route('admin.suppliers_orders.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
        @endif
        <a href="{{ route('admin.suppliers_orders.show',$info->id) }}" class="btn btn-sm   btn-info">التفاصيل</a>   

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
     
        <div class="modal fade  " id="AddNewInvoiceModal">
          <div class="modal-dialog modal-xl" >
            <div class="modal-content bg-info">
              <div class="modal-header">
                <h4 class="modal-title text-center">   اضافة فاتورة مبيعات جديدة</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body" id="AddNewInvoiceModalBody" style="background-color: white !important; color:black;">
             

        
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


</div>





@endsection

@section('script')
<script src="{{ asset('assets/admin/js/sales_invoices.js') }}"></script>

<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
  //Initialize Select2 Elements
  $('.select2').select2({
    theme: 'bootstrap4'
  });
  </script>
@endsection




