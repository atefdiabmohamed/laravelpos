@extends('layouts.admin')
@section('title')
جرد المخازن
@endsection
@section('contentheader')
حركات مخزنية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.stores_inventory.index') }}">   جرد المخازن </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> إضافة أمر جرد مخزن </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.stores_inventory.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>  تاريخ الجرد</label>
                  <input readonly name="inventory_date" id="inventory_date" type="date" value="@php echo date("Y-m-d"); @endphp" class="form-control" value="{{ old('order_date') }}"    >
                  @error('inventory_date')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>    نوع الجرد</label>
                  <select name="inventory_type" id="inventory_type" class="form-control">
                     <option value="">من فضلك اختر نوع الجرد</option>
                     <option   @if(old('inventory_type')==1) selected="selected"  @endif value="1">   جرد يومي</option>
                     <option @if(old('inventory_type')==2 ) selected="selected"   @endif value="2">   جرد اسبوعي</option>
                     <option @if(old('inventory_type')==3 ) selected="selected"   @endif value="3">   جرد شهري</option>
                     <option @if(old('inventory_type')==4 ) selected="selected"   @endif value="4">   جرد سنوي</option>
                  </select>
                  @error('inventory_type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group"   >
                  <label>     بيانات المخازن</label>
                  <select name="store_id" id="store_id" class="form-control ">
                     <option value="">  اختر مخزن الجرد</option>
                     @if (@isset($stores) && !@empty($stores))
                     @foreach ($stores as $info )
                     <option  @if(old('store_id')==$info->id ) selected="selected"  @endif  value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('store_id')
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
                  <a href="{{ route('admin.stores_inventory.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
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
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection