@extends('layouts.admin')
@section('title')
مرتجع المشتريات العام
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('contentheader')
حركات مخزنية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.suppliers_orders_general_return.index') }}">  فواتير مرتجع المشتريات العام </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')


<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">تفاصيل فاتورة مرتجع مشتريات عام  </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div id="ajax_responce_serarchDivparentpill">
        @if (@isset($data) && !@empty($data))
        
        <table id="example2" class="table table-bordered table-hover">
         
            <tr>
                <td class="width30"> كود الفاتورة الالي</td> 
                <td > {{ $data['auto_serial'] }}</td>
            </tr>
      
            <tr>
              <td class="width30">   تاريخ الفاتورة </td> 
              <td > {{ $data['order_date'] }}</td>
          </tr>
            <tr>
                <td class="width30">  اسم المورد </td> 
                <td > {{ $data['supplier_name'] }}</td>
            </tr>
            <tr>
                <td class="width30"> نوع الفاتورة</td> 
                <td > @if($data['pill_type']==1) كاش  @else اجل@endif</td>
            </tr>
            <tr>
              <td class="width30">     مخزن صرف المرتجع </td> 
              <td > {{ $data['store_name'] }}</td>
          </tr>

            
           
          <tr>
            <td class="width30">   اجمالي الاصناف علي الفاتورة </td> 
            <td > {{ $data['total_befor_discount']*(1) }}</td> 
        </tr>


          @if ($data['discount_type']!=null)
            
          <tr>
            <td class="width30">   الخصم علي الفاتورة </td> 
            <td> 
              @if ($data['discount_type']==1)
            خصم نسبة ( {{ $data['discount_percent']*1 }} ) وقيمتها ( {{ $data["discount_value"]*1 }} )

              @else
              
      خصم يدوي وقيمته( {{ $data["discount_value"]*1 }} )

              @endif
            
            
            </td> 
        </tr>

          @else

          <tr>
            <td class="width30">   الخصم علي الفاتورة </td> 
            <td > لايوجد</td>
        </tr>

          @endif



          <tr>
            <td class="width30">    نسبة القيمة المضافة </td> 
            <td > 
            @if($data['tax_percent']>0)
            لايوجد
            @else
            بنسبة ({{ $data["tax_percent"]*1 }}) %  وقيمتها ( {{ $data['tax_value']*1 }} )
            @endif
            
            </td> 
        </tr>
        <tr>
          <td class="width30">   اجمالي الفاتورة </td> 
          <td > {{ $data['total_cost']*(1) }}</td> 
      </tr>
        <tr>
          <td class="width30">       حالة الفاتورة </td> 
          <td > @if($data['is_approved']==1)  مغلق ومؤرشف @else مفتوحة  @endif</td>
      </tr>

           
            <tr>
                <td class="width30">  تاريخ  الاضافة</td> 
                <td > 
     
    @php
   $dt=new DateTime($data['created_at']);
   $date=$dt->format("Y-m-d");
   $time=$dt->format("h:i");
   $newDateTime=date("A",strtotime($time));
   $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
    @endphp
{{ $date }}
{{ $time }}
{{ $newDateTimeType }}
بواسطة 
{{ $data['added_by_admin'] }}

                </td>
            </tr> 



  
            <tr>
                <td class="width30">  تاريخ اخر تحديث</td> 
                <td > 
       @if($data['updated_by']>0 and $data['updated_by']!=null )
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





     @else
لايوجد تحديث
       @endif
       @if($data['is_approved']==0)
<a href="{{ route('admin.suppliers_orders_general_return.delete',$data['id']) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
<a href="{{ route('admin.suppliers_orders_general_return.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
<button id="load_close_approve_invoice"  class="btn btn-sm btn-primary">تحميل الاعتماد والترحيل</button>

@endif

                </td>
            </tr> 
           
          </table>
      

          

        </div>

     <!--  treasuries_delivery   -->
     <div class="card-header">
        <h3 class="card-title card_title_center">
        الاصناف المضافة للفاتورة
        @if($data['is_approved']==0)
        <button type="button" class="btn btn-info" id="load_modal_add_detailsBtn">
          اضافة صنف للفاتورة
        </button>
       @endif
        </h3>
        <input type="hidden" id="token_search" value="{{csrf_token() }}">
        <input type="hidden" id="ajax_get_item_uoms_url" value="{{ route('admin.suppliers_orders_general_return.get_item_uoms') }}">
        <input type="hidden" id="ajax_Add_item_to_invoice" value="{{ route('admin.suppliers_orders_general_return.Add_item_to_invoice') }}">
        <input type="hidden" id="ajax_reload_itemsdetials" value="{{ route('admin.suppliers_orders_general_return.reload_itemsdetials') }}">
        <input type="hidden" id="ajax_reload_parent_pill" value="{{ route('admin.suppliers_orders_general_return.reload_parent_pill') }}">
        <input type="hidden" id="ajax_load_edit_item_details" value="{{ route('admin.suppliers_orders_general_return.load_edit_item_details') }}">
        <input type="hidden" id="ajax_load_modal_add_details" value="{{ route('admin.suppliers_orders_general_return.load_modal_add_details') }}">
        <input type="hidden" id="ajax_edit_item_details" value="{{ route('admin.suppliers_orders_general_return.edit_item_details') }}">
        <input type="hidden" id="ajax_load_modal_approve_invoice" value="{{ route('admin.suppliers_orders_general_return.load_modal_approve_invoice') }}">
        <input type="hidden" id="ajax_load_usershiftDiv" value="{{ route('admin.suppliers_orders_general_return.load_usershiftDiv') }}">
        <input type="hidden" id="ajax_get_item_batches" value="{{ route('admin.suppliers_orders_general_return.get_item_batches') }}">
        <input type="hidden" id="autoserailparent" value="{{ $data['auto_serial'] }}">

        



    </div>
     <div id="ajax_responce_serarchDivDetails">
          
        @if (@isset($details) && !@empty($details) && count($details)>0)
        @php
         $i=1;   
        @endphp
        
        <table id="example2" class="table table-bordered table-hover">
          <thead class="custom_thead">
         <th>مسلسل</th>
         <th>الصنف </th>
         <th> الوحده</th>
         <th> الكمية</th>
         <th> السعر</th>
         <th> الاجمالي</th>

         <th></th>
          </thead>
          <tbody>
       @foreach ($details as $info )
          <tr>
           <td>{{ $i }}</td>  
         <td>{{ $info->item_card_name }}
        @if($info->item_card_type==2)
        <br>
        تاريخ انتاج  {{ $info->production_date }} <br>

        تاريخ انتهاء  {{ $info->expire_date }} <br>
      باتش رقم {{ $info->batch_auto_serial }}

        @endif
        
        
        </td>
         <td>{{ $info->uom_name }}</td>
         <td>{{ $info->deliverd_quantity*(1) }}</td>
         <td>{{ $info->unit_price*(1) }}</td>
         <td>{{ $info->total_price*(1) }}</td>
    
         <td>
       @if($data['is_approved']==0)

       <a href="{{ route('admin.suppliers_orders_general_return.delete_details',["id"=>$info->id,"id_parent"=>$data['id']]) }}" class="btn btn-sm are_you_shue   btn-danger">حذف</a>   
     


       @endif

         </td>

         
 
         </tr> 
    @php
       $i++; 
    @endphp
       @endforeach
 
 
 
          </tbody>
           </table>
   
     
         @else
         <div class="alert alert-danger">
           عفوا لاتوجد بيانات لعرضها !!
         </div>
               @endif

      </div>
    



    <!--  End treasuries_delivery   -->



        @else
  <div class="alert alert-danger">
    عفوا لاتوجد بيانات لعرضها !!
  </div>
        @endif
      


        </div>
      </div>
    </div>
</div>


<div class="modal fade " id="Add_item_Modal">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title">اضافة اصناف للفاتورة</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="Add_item_Modal_body" style="background-color: white !important; color:black;">
    


      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade " id="edit_item_Modal">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title text-center">تحديث صنف  بالفاتورة</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="edit_item_Modal_body" style="background-color: white !important; color:black;">
     


      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade " id="ModalApproveInvocie">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title" style="text-align: center">  اعتماد وترحيل فاتورة مرتجع مشتريات عام</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="ModalApproveInvocie_body" style="background-color: white !important; color:black;">
    


      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

@endsection

@section("script")

<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    });
    </script>

<script  src="{{ asset('assets/admin/js/suppliers_orders_general_return.js') }}"> </script>


@endsection





