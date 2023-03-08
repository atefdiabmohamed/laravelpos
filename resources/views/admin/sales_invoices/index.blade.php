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
      <input type="hidden" id="ajax_get_item_uoms" value="{{ route('admin.SalesInvoices.get_item_uoms') }}">
      <input type="hidden" id="ajax_get_load_modal_addMirror" value="{{ route('admin.SalesInvoices.load_modal_addMirror') }}">
      <input type="hidden" id="ajax_get_load_modal_addActiveInvoice" value="{{ route('admin.SalesInvoices.load_modal_addActiveInvoice') }}">
      <input type="hidden" id="ajax_get_item_batches" value="{{ route('admin.SalesInvoices.get_item_batches') }}">
      <input type="hidden" id="ajax_get_item_unit_price" value="{{ route('admin.SalesInvoices.get_item_unit_price') }}">
      <input type="hidden" id="ajax_get_Add_new_item_row" value="{{ route('admin.SalesInvoices.get_Add_new_item_row') }}">
      <input type="hidden" id="ajax_get_store" value="{{ route('admin.SalesInvoices.store') }}">
      <input type="hidden" id="ajax_get_load_invoice_update_modal" value="{{ route('admin.SalesInvoices.load_invoice_update_modal') }}">
      <input type="hidden" id="ajax_get_Add_item_to_invoice" value="{{ route('admin.SalesInvoices.Add_item_to_invoice') }}">
      <input type="hidden" id="ajax_get_reload_items_in_invoice" value="{{ route('admin.SalesInvoices.reload_items_in_invoice') }}">
      <input type="hidden" id="ajax_get_recalclate_parent_invoice" value="{{ route('admin.SalesInvoices.recalclate_parent_invoice') }}">
      <input type="hidden" id="ajax_get_remove_active_row_item" value="{{ route('admin.SalesInvoices.remove_active_row_item') }}">
      <input type="hidden" id="ajax_DoApproveInvoiceFinally" value="{{ route('admin.SalesInvoices.DoApproveInvoiceFinally') }}">
      <input type="hidden" id="ajax_load_usershiftDiv" value="{{ route('admin.SalesInvoices.load_usershiftDiv') }}">
      <input type="hidden" id="ajax_load_invoice_details_modal" value="{{ route('admin.SalesInvoices.load_invoice_details_modal') }}">
      <input type="hidden" id="ajax_ajax_search" value="{{ route('admin.SalesInvoices.ajax_search') }}">
      <input type="hidden" id="ajax_do_add_new_customer" value="{{ route('admin.SalesInvoices.do_add_new_customer') }}">
      <input type="hidden" id="ajax_getlastaddedcustomer" value="{{ route('admin.SalesInvoices.get_last_added_customer') }}">
      <input type="hidden" id="ajax_searchforcustomer" value="{{ route('admin.SalesInvoices.searchforcustomer') }}">
      <input type="hidden" id="ajax_searchforitems" value="{{ route('admin.SalesInvoices.searchforitems') }}">
      <button class="btn btn-sm btn-success" id="LoadModalAddBtnMirror" >  مرآة فاتورة عرض اسعار</button>
      <button class="btn btn-sm btn-primary" id="LoadModalAddBtnActiveInvoice" >     اضافة فاتورة فعلية</button>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <input checked type="radio" name="searchbyradio" id="searchbyradio" value="auto_serial"> بالكود 
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="customer_code"> كود العميل   
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="account_number"> رقم الحساب   
            <input  style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder="" class="form-control"> <br>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  بحث  بالعملاء</label>
               <select name="customer_code_search" id="customer_code_search" class="form-control select2">
                  <option value="all">بحث بكل العملاء</option>
                  <option value="without">  بدون عميل (طياري)</option>
                  @if (@isset($customers) && !@empty($customers))
                  @foreach ($customers as $info )
                  <option value="{{ $info->customer_code }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  بحث  بالمناديب</label>
               <select name="delegates_code_search" id="delegates_code_search" class="form-control select2">
                  <option value="all">بحث بكل المناديب</option>
                  @if (@isset($delegates) && !@empty($delegates))
                  @foreach ($delegates as $info )
                  <option value="{{ $info->delegate_code }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  بحث  بفئات الفواتير</label>
               <select name="Sales_matrial_types_search" id="Sales_matrial_types_search" class="form-control select2">
                  <option value="all">بحث بكل الفئات</option>
                  @if (@isset($Sales_matrial_types) && !@empty($Sales_matrial_types))
                  @foreach ($Sales_matrial_types as $info )
                  <option value="{{ $info->id }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  بحث  نوع الفواتير</label>
               <select name="pill_type_search" id="pill_type_search" class="form-control select2">
                  <option value="all">بحث بكل الانواع</option>
                  <option value="1"> كاش </option>
                  <option value="2"> اجل </option>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>     نوع الخصم   </label>
               <select class="form-control" name="discount_type_search" id="discount_type_search">
                  <option value="all"> بحث بكل الانواع</option>
                  <option value="without">لايوجد خصم</option>
                  <option value="1" >    نسبة مئوية</option>
                  <option   value="2" > قيمة يدوي</option>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>     حالة الاعتماد    </label>
               <select class="form-control" name="is_approved_search" id="is_approved_search">
                  <option value="all"> بحث بكل الحالات</option>
                  <option value="0" >     مفتوحة</option>
                  <option   value="1" >  معتمدة ومرحلة</option>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>      من تاريخ فاتورة</label>
               <input name="invoice_date_from" id="invoice_date_from" class="form-control" type="date" value=""    >
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>     الي تاريخ فاتورة </label>
               <input name="invoice_date_to" id="invoice_date_to" class="form-control" type="date" value=""    >
            </div>
         </div>
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
                     <th> تاريخ الفاتورة</th>
                     <th> العميل</th>
                     <th>  فئة الفاتورة</th>
                     <th>  نوع الفاتورة</th>
                     <th>    اجمالي الفاتورة</th>
                     <th>حالة الفاتورة</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td>{{ $info->auto_serial }}</td>
                        <td>{{ $info->invoice_date }}</td>
                        <td>{{ $info->customer_name }}</td>
                        <td>{{ $info->Sales_matrial_types_name }}</td>
                        <td>@if($info->pill_type==1)  كاش  @elseif($info->pill_type==2)  اجل  @else  غير محدد @endif</td>
                        <td>{{ $info->total_cost*1 }}</td>
                        <td>@if($info->is_approved==1)  معتمدة   @else   مفتوحة @endif</td>
                        <td>
                           @if($info->is_approved==0)
                           <button data-autoserial="{{ $info->auto_serial }}"  class="btn btn-sm load_invoice_update_modal btn-primary">تعديل</button>   
                           <a href="{{ route("admin.SalesInvoices.delete",$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
                           @endif
                           <button data-autoserial="{{ $info->auto_serial }}"  class="btn btn-sm load_invoice_details_modal btn-info">عرض</button>   
                           <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.SalesInvoices.printsaleswina4',[$info->id,'A4']) }}" class="btn btn-primary btn-xs"> WA4</a>
                           <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.SalesInvoices.printsaleswina4',[$info->id,'A6']) }}" class="btn btn-warning btn-xs"> WA6</a>
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
   <div class="modal fade  " id="AddNewInvoiceModalMirro">
      <div class="modal-dialog modal-xl" >
         <div class="modal-content bg-info">
            <div class="modal-header">
               <h4 class="modal-title text-center">     مرآة عرض اسعار  لفاتورة مبيعات </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="AddNewInvoiceModalMirroBody" style="background-color: white !important; color:black;">
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <div class="modal fade  "   id="AddNewInvoiceModalActiveInvoice">
      <div class="modal-dialog modal-xl" >
         <div class="modal-content bg-info">
            <div class="modal-header">
               <h4 class="modal-title text-center">          اضافة فاتورة مبيعات فعلية </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="AddNewInvoiceModalActiveInvoiceBody" style="background-color: white !important; color:black;">
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <div class="modal fade  "   id="updateInvoiceModalActiveInvoice">
      <div class="modal-dialog modal-xl" >
         <div class="modal-content bg-info">
            <div class="modal-header">
               <h4 class="modal-title text-center">          تحديث فاتورة مبيعات فعلية </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="updateInvoiceModalActiveInvoiceBody" style="background-color: white !important; color:black;">
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <div class="modal fade  "   id="InvoiceModalActiveDetails">
      <div class="modal-dialog modal-xl"  >
         <div class="modal-content bg-info">
            <div class="modal-header">
               <h4 class="modal-title text-center">             تفاصيل فاتورة مبيعات </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="InvoiceModalActiveDetailsBody" style="background-color: white !important; color:black;">
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
   <div class="modal fade  "   id="load_add_new_customerModal">
      <div class="modal-dialog modal-xl" >
         <div class="modal-content bg-info">
            <div class="modal-header">
               <h4 class="modal-title text-center">               اضافة عميل جديد </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="load_add_new_customerModalBody" style="background-color: white !important; color:black;">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>اسم   العميل</label>
                        <input  name="customer_name" id="customer_name" class="form-control" value=""    >
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>   حالة رصيد اول المدة</label>
                        <select name="start_balance_status" id="start_balance_status" class="form-control">
                           <option value="">اختر الحالة</option>
                           <option    value="1"> دائن</option>
                           <option     value="2"> مدين</option>
                           <option  selected="selected"   value="3"> متزن</option>
                        </select>
                        @error('start_balance_status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>   رصيد أول المدة للحساب</label>
                        <input  name="start_balance" id="start_balance" class="form-control" value="0"  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"     >
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>   العنوان </label>
                        <input name="customer_address" id="customer_address" class="form-control" value=""    >
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>   الهاتف</label>
                        <input name="customer_phones" id="customer_phones" class="form-control" value=""    >
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>   ملاحظات</label>
                        <input name="customer_notes" id="customer_notes" class="form-control" value=""    >
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>  حالة التفعيل</label>
                        <select name="customer_active" id="customer_active" class="form-control">
                           <option   value="1"> نعم</option>
                           <option   value="0"> لا</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group text-center pull-left">
                        <button style="margin-top: 33px;" id="do_add_new_customer_btn" type="submit" class="btn btn-primary btn-sm"> أضف العميل</button>
                     </div>
                  </div>
               </div>
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