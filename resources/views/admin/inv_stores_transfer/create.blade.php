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
صرف الخامات
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.inv_production_exchange.index') }}">   صرف الخامات للورش</a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة  فاتورة صرف خامات لخط انتاج معين </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.inv_production_exchange.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>  تاريخ الفاتورة</label>
                  <input name="order_date" id="order_date" type="date" value="@php echo date("Y-m-d"); @endphp" class="form-control" value="{{ old('order_date') }}"    >
                  @error('notes')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>   بيانات أومر التشغيل</label>
                  <select name="inv_production_order_auto_serial" id="inv_production_order_auto_serial" class="form-control select2">
                     <option value="">اختر كود الامر</option>
                     @if (@isset($Inv_production_order) && !@empty($Inv_production_order))
                     @foreach ($Inv_production_order as $info )
                     <option @if(old('inv_production_order_auto_serial')==$info->auto_serial) selected="selected" @endif value="{{ $info->auto_serial }}"> {{ $info->auto_serial }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('inv_production_order_auto_serial')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>    بيانات خطوط الانتاج (الورش)</label>
                  <select name="production_lines_code" id="production_lines_code" class="form-control select2">
                     <option value=""> اختر   مخزن صرف الخامات</option>
                     @if (@isset($Inv_production_lines) && !@empty($Inv_production_lines))
                     @foreach ($Inv_production_lines as $info )
                     <option @if(old('production_lines_code')==$info->production_lines_code) selected="selected" @endif value="{{ $info->production_lines_code }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('production_lines_code')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>    بيانات المخازن</label>
                  <select name="store_id" id="store_id" class="form-control select2">
                     <option value=""> اختر   مخزن صرف الخامات</option>
                     @if (@isset($stores) && !@empty($stores))
                     @foreach ($stores as $info )
                     <option @if(old('store_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('store_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>   نوع الفاتورة</label>
                  <select name="pill_type" id="pill_type" class="form-control">
                     <!--<option   @if(old('pill_type')==1) selected="selected"  @endif value="1">  كاش</option>-->
                     <option @if(old('pill_type')==2 ) selected="selected"   @endif value="2">  اجل</option>
                  </select>
                  @error('pill_type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>  ملاحظات</label>
                  <input name="notes" id="notes" class="form-control" value="{{ old('notes') }}"    >
                  @error('notes')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                  <a href="{{ route('admin.inv_production_exchange.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
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
@endsection