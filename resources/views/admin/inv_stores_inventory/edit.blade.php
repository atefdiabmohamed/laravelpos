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
تعديل
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> تعديل  أمر جرد مخزن </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if(!@empty($data) )
            @if($data['is_closed']==0)
            <form action="{{ route('admin.stores_inventory.update',$data['id']) }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>  تاريخ أمر الجرد</label>
                  <input readonly name="inventory_date" id="inventory_date" type="date" value="{{ old('inventory_date',$data['inventory_date']) }}" class="form-control"     >
                  @error('order_date')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>    نوع الجرد</label>
                  <select name="inventory_type" id="inventory_type" class="form-control">
                     <option value="">من فضلك اختر نوع الجرد</option>
                     <option   @if(old('inventory_type',$data['inventory_type'])==1) selected="selected"  @endif value="1">   جرد يومي</option>
                     <option @if(old('inventory_type',$data['inventory_type'])==2 ) selected="selected"   @endif value="2">   جرد اسبوعي</option>
                     <option @if(old('inventory_type',$data['inventory_type'])==3 ) selected="selected"   @endif value="3">   جرد شهري</option>
                     <option @if(old('inventory_type',$data['inventory_type'])==4 ) selected="selected"   @endif value="4">   جرد سنوي</option>
                  </select>
                  @error('inventory_type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group"   >
                  <label>     مخزن الجرد</label>
                  <select name="store_id" id="store_id" class="form-control select2">
                     <option value="">  اختر الحساب المالي</option>
                     @if (@isset($stores) && !@empty($stores))
                     @foreach ($stores as $info )
                     <option  @if(old('store_id',$data['store_id'])==$info->id ) selected="selected"  @endif  value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('store_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>  ملاحظات</label>
                  <input name="notes" id="notes" class="form-control" value="{{ old('notes',$data['notes']) }}"    >
                  @error('notes')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm"> تعديل</button>
                  <a href="{{ route('admin.stores_inventory.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
            @else
            <div class="alert alert-danger">
               عفوا لايمكن تحديث فاتورة معتمدة ومؤرشفة
            </div>
            @endif
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