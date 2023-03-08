@extends('layouts.admin')
@section('title')
تعديل بيانات عميل
@endsection
@section('contentheader')
الحسابات
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.customer.index') }}">    العملاء </a>
@endsection
@section('contentheaderactive')
تعديل
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center"> تعديل بيانات عميل  </h3>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <form action="{{ route('admin.customer.update',$data['id']) }}" method="post" >
         <div class="row">
            @csrf
            <div class="col-md-6">
               <div class="form-group">
                  <label>اسم  العميل </label>
                  <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}"    >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   العنوان</label>
                  <input name="address" id="address" class="form-control" value="{{ old('address',$data['address']) }}"    >
                  @error('address')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   الهاتف</label>
                  <input name="phones" id="phones" class="form-control" value="{{ old('phones',$data['phones']) }}"    >
                  @error('phones')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   ملاحظات</label>
                  <input name="notes" id="notes" class="form-control" value="{{ old('notes',$data['notes']) }}"    >
                  @error('notes')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>  حالة التفعيل</label>
                  <select name="active" id="active" class="form-control">
                     <option value="">اختر الحالة</option>
                     <option {{  old('active',$data['active'])==1 ? 'selected' : ''}}  value="1"> نعم</option>
                     <option {{  old('active',$data['active'])==0 ? 'selected' : ''}}   value="0"> لا</option>
                  </select>
                  @error('active')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group text-center">
                  <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> تعديل</button>
                  <a href="{{ route('admin.customer.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/admin/js/accounts.js') }}"></script>
@endsection