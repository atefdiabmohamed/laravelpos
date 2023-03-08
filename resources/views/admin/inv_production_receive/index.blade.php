<!-- لاتنسونا من صالح دعائكم -->
@extends('layouts.admin')
@section('title')
حركات خط الاإنتاج
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
استلام منتج
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.inv_production_Receive.index') }}">     استلام انتاج تام من الورش</a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">   استلام انتاج تام من خطوط الانتاج(الورش) </h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_search_url" value="{{ route('admin.inv_production_Receive.ajax_search') }}">
      <a href="{{ route('admin.inv_production_Receive.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <input checked type="radio" name="searchbyradio" id="searchbyradio" value="auto_serial"> بالكود الآلي
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="inv_production_order"> بكود التشغيل 
            <input style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder="" class="form-control"> <br>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>    بحث بخطوط الانتاج (الورش)</label>
               <select name="production_lines_code_search" id="production_lines_code_search" class="form-control select2">
                  <option value="all">بحث بالكل</option>
                  @if (@isset($Inv_production_lines) && !@empty($Inv_production_lines))
                  @foreach ($Inv_production_lines as $info )
                  <option  value="{{ $info->production_lines_code }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>    بيانات المخازن</label>
               <select name="store_id_search" id="store_id_search" class="form-control select2">
                  <option value="all">بحث بكل المخازن</option>
                  @if (@isset($stores) && !@empty($stores))
                  @foreach ($stores as $info )
                  <option  value="{{ $info->id }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
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
         <div class="col-md-4">
            <div class="form-group">
               <label>    حالة الاعتماد والارشفة</label>
               <select name="is_approved_serach" id="is_approved_serach" class="form-control">
                  <option value="all">بحث بكل الحالات</option>
                  <option    value="1">  معتمد</option>
                  <option    value="0">  مفتوح</option>
               </select>
               @error('pill_type')
               <span class="text-danger">{{ $message }}</span>
               @enderror
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
                     <th> خط الانتاج</th>
                     <th> تاريخ الفاتورة</th>
                     <th>  نوع الفاتورة</th>
                     <th>   مخزن الاستلام </th>
                     <th>    اجمالي الفاتورة</th>
                     <th>حالة الفاتورة</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td>{{ $info->auto_serial }}</td>
                        <td>{{ $info->production_lines_name }}</td>
                        <td>{{ $info->order_date }}</td>
                        <td>@if($info->pill_type==1)  كاش  @elseif($info->pill_type==2)  اجل  @else  غير محدد @endif</td>
                        <td>{{ $info->store_name }}</td>
                        <td>{{ $info->total_cost*(1) }}</td>
                        <td>@if($info->is_approved==1)  معتمدة   @else   مفتوحة @endif</td>
                        <td>
                           @if($info->is_approved==0)
                           <a href="{{ route('admin.inv_production_Receive.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
                           <a href="{{ route('admin.inv_production_Receive.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
                           @endif
                           <a href="{{ route('admin.inv_production_Receive.show',$info->id) }}" class="btn btn-sm   btn-info">التفاصيل</a>   
                           <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.inv_production_Receive.printsaleswina4',[$info->id,'A4']) }}" class="btn btn-primary btn-xs"> WA4</a>
                           <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.inv_production_Receive.printsaleswina4',[$info->id,'A6']) }}" class="btn btn-warning btn-xs"> WA6</a>
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
<script src="{{ asset('assets/admin/js/inv_production_Receive.js') }}"></script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
@endsection