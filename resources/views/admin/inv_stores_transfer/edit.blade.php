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
تعديب
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> تعديل أمر تحويل بين المخازن</h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if(!@empty($data) )
            @if($data['is_approved']==0)
            <form action="{{ route('admin.inv_stores_transfer.update',$data['id']) }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>  تاريخ امر التحويل</label>
                  <input name="order_date" id="order_date" type="date" value="{{ old('order_date',$data['order_date']) }}" class="form-control" value="{{ old('order_date') }}"    >
                  @error('order_date')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>     التحويل من مخزن الصرف</label>
                  <select  @if($added_counter_details>0)  disabled @endif name="transfer_from_store_id" id="transfer_from_store_id" class="form-control select2">
                  <option value=""> اختر   مخزن الصرف </option>
                  @if (@isset($stores) && !@empty($stores))
                  @foreach ($stores as $info )
                  <option @if(old('transfer_from_store_id',$data['transfer_from_store_id'])==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
                  </select>
                  @error('transfer_from_store_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>     التحويل الي مخزن الاستلام</label>
                  <select @if($added_counter_details>0)  disabled @endif  name="transfer_to_store_id" id="transfer_to_store_id" class="form-control select2">
                  <option value=""> اختر   مخزن الاستلام </option>
                  @if (@isset($stores) && !@empty($stores))
                  @foreach ($stores as $info )
                  <option @if(old('transfer_to_store_id',$data['transfer_to_store_id'])==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
                  </select>
                  @error('transfer_to_store_id')
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
                  <a href="{{ route('admin.inv_stores_transfer.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
            @else
            <div class="alert alert-danger">
               عفوا لايمكت تحديث فاتورة معتمدة ومؤرشفة
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
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection