@extends('layouts.admin')
@section('title')
خدمات 
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
خدمات داخلية وخارجية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.Services_orders.index') }}">  فواتير الخدمات </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">     فواتير الخدمات الداخلية والخارجية  </h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_search_url" value="{{ route('admin.Services_orders.ajax_search') }}">
      <a href="{{ route('admin.Services_orders.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <input checked type="radio" name="searchbyradio" id="searchbyradio" value="auto_serial"> بالكود 
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="account_number"> برقم الحساب   
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="entity_name">  اسم الجهة   
            <input style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder="" class="form-control"> <br>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  بحث  بالحسابات المالية</label>
               <select name="account_number_search" id="account_number_search" class="form-control select2">
                  <option value="all">بحث بكل الحسابات</option>
                  @if (@isset($accounts) && !@empty($accounts))
                  @foreach ($accounts as $info )
                  <option value="{{ $info->account_number }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>   فئة الفاتورة</label>
               <select name="order_type_search" id="order_type_search" class="form-control">
                  <option value="all">بحث بكل الفئات</option>
                  <option   value="1">  خدمات مقدمة لنا</option>
                  <option value="2">  خدمات نقدمها للغير</option>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>    هل  حساب مالي</label>
               <select name="is_account_number_search" id="is_account_number_search" class="form-control">
                  <option  value="all">   بحث بالكل</option>
                  <option    value="1">  نعم</option>
                  <option  value="0">  لا</option>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>   بحث  من تاريخ</label>
               <input name="order_date_form" id="order_date_form" class="form-control" type="date" value=""    >
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>   بحث  الي تاريخ</label>
               <input name="order_date_to" id="order_date_to" class="form-control" type="date" value=""    >
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
                     <th>  فئة الفاتورة</th>
                     <th> الحساب المالي /الجهة</th>
                     <th> تاريخ الفاتورة</th>
                     <th>  نوع الفاتورة</th>
                     <th>    اجمالي الفاتورة</th>
                     <th>حالة الفاتورة</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td>{{ $info->auto_serial }}</td>
                        <td>@if($info->order_type==1)  خدمات مقدمة لنا   @else   خدمات نقدمها للغير @endif</td>
                        <td>
                           @if ($info->is_account_number==1)
                           {{ $info->account_name }}
                           @else
                           جهة <br>  {{ $info->entity_name }}
                           @endif
                        </td>
                        <td>{{ $info->order_date }}</td>
                        <td>@if($info->pill_type==1)  كاش  @elseif($info->pill_type==2)  اجل  @else  غير محدد @endif</td>
                        <td>{{ $info->total_cost*(1) }}</td>
                        <td>@if($info->is_approved==1)  معتمدة   @else   مفتوحة @endif</td>
                        <td>
                           @if($info->is_approved==0)
                           <a href="{{ route('admin.Services_orders.edit',$info->id) }}" class="btn btn-sm  btn-success">تعديل</a>   
                           <a href="{{ route('admin.Services_orders.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
                           @endif
                           <a href="{{ route('admin.Services_orders.show',$info->id) }}" class="btn btn-sm   btn-info">التفاصيل</a>   
                           <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.Services_orders.printsaleswina4',[$info->id,'A4']) }}" class="btn btn-primary btn-xs"> WA4</a>
                           <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.Services_orders.printsaleswina4',[$info->id,'A6']) }}" class="btn btn-warning btn-xs"> WA6</a>
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
<script src="{{ asset('assets/admin/js/services_with_orders.js') }}"></script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection