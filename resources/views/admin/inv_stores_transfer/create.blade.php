<!-- لاتنسونا من صالح دعائكم -->
@extends('layouts.admin')
@section('title')
حركات مخزنية 
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
التحويل
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.inv_stores_transfer.index') }}">     التحويل بين المخازن</a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة  أمر تحويل بين المخازن </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.inv_stores_transfer.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>  تاريخ أمر التحويل</label>
                  <input name="order_date" id="order_date" type="date" value="@php echo date("Y-m-d"); @endphp" class="form-control" value="{{ old('order_date') }}"    >
                  @error('notes')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>     التحويل من مخزن الصرف</label>
                  <select name="transfer_from_store_id" id="transfer_from_store_id" class="form-control select2">
                     <option value=""> اختر   مخزن صرف الخامات</option>
                     @if (@isset($stores) && !@empty($stores))
                     @foreach ($stores as $info )
                     <option @if(old('transfer_from_store_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('transfer_from_store_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>     التحويل الي مخزن الاستلام</label>
                  <select name="transfer_to_store_id" id="transfer_to_store_id" class="form-control select2">
                     <option value=""> اختر   مخزن صرف الخامات</option>
                     @if (@isset($stores) && !@empty($stores))
                     @foreach ($stores as $info )
                     <option @if(old('transfer_to_store_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('transfer_to_store_id')
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
                  <a href="{{ route('admin.inv_stores_transfer.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
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