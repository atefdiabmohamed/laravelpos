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
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة  فاتورة خدمات داخلية وخارجية </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.Services_orders.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>  تاريخ الفاتورة</label>
                  <input name="order_date" id="order_date" type="date" value="@php echo date("Y-m-d"); @endphp" class="form-control" value="{{ old('order_date') }}"    >
                  @error('order_date')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group"> 
                  <label>   فئة الفاتورة</label>
                  <select name="order_type" id="order_type" class="form-control">
                  <option   @if(old('order_type')==1) selected="selected"  @endif value="1">  خدمات مقدمة لنا</option>
                  <option @if(old('order_type')==2 ) selected="selected"   @endif value="2">  خدمات نقدمها للغير</option>
                  </select>
                  @error('order_type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group"> 
                  <label>    هل حساب مالي</label>
                  <select name="is_account_number" id="is_account_number" class="form-control">
                  <option   @if(old('is_account_number')=="") selected="selected"  @endif value="">  اختر الحالة</option>
                  <option   @if(old('is_account_number')==1) selected="selected"  @endif value="1">  نعم</option>
                  <option @if(old('is_account_number')==0 and old('is_account_number')!=""  ) selected="selected"   @endif value="0">  لا</option>
                  </select>
                  @error('is_account_number')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group" id="account_numberDiv" @if( old('is_account_number')!=1) style="display: none;"   @endif > 
               <label>   بيانات الحسابات المالية</label>
               <select name="account_number" id="account_number" class="form-control select2">
                  <option value="">  اختر الحساب المالي</option>
                  @if (@isset($accounts) && !@empty($accounts))
                  @foreach ($accounts as $info )
                  <option  @if(old('account_number')==$info->account_number ) selected="selected"  @endif  value="{{ $info->account_number }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
               @error('account_number')
               <span class="text-danger">{{ $message }}</span>
               @enderror
         </div>
         <div class="form-group" id="entity_nameDiv"   @if( old('is_account_number')==""||old('is_account_number')==1   ) style="display: none;"   @endif >
         <label>   اسم الجهة ( طياري )</label>
         <input name="entity_name" class="form-control" id="entity_name" type="text"  value="{{ old('entity_name') }}"    >
         @error('entity_name')
         <span class="text-danger">{{ $message }}</span>
         @enderror
      </div>
      <div class="form-group"> 
      <label>   نوع الفاتورة</label>
      <select name="pill_type" id="pill_type" class="form-control">
      <option   @if(old('pill_type')==1) selected="selected"  @endif value="1">  كاش</option>
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
      <a href="{{ route('admin.Services_orders.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
      </div>
      </form>  
   </div>
</div>
</div>
</div>
</div>
@endsection
@section("script")
<script src="{{ asset('assets/admin/js/services_with_orders.js') }}"></script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection