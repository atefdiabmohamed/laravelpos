@extends('layouts.admin')
@section('title')
الخدمات الداخلية والخارجية
@endsection
@section('contentheader')
الخدمات
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.uoms.index') }}">  الخدمات الداخلية والخارجية </a>
@endsection
@section('contentheaderactive')
تعديل
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">تعديل بيانات   خدمة  </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.Services.update',$data['id']) }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>اسم  الخدمة</label>
                  <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}"   >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>  نوع الخدمة </label>
                  <select name="type" id="type" class="form-control">
                     <option value="">اختر النوع</option>
                     <option  {{  old('type',$data['type'])==1 ? 'selected' : ''}}   value="1">  خدمات مقدمة لنا</option>
                     <option  {{  old('type',$data['type'])==2 ? 'selected' : ''}}    value="2">  خدمات نقدمها للغير</option>
                  </select>
                  @error('type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>  حالة التفعيل</label>
                  <select name="active" id="active" class="form-control">
                     <option value="">اختر الحالة</option>
                     <option {{  old('active',$data['active'])==1 ? 'selected' : ''}}   value="1"> نعم</option>
                     <option {{ old('active',$data['active'])==0 ? 'selected' : ''}}  value="0"> لا</option>
                  </select>
                  @error('is_master')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                  <a href="{{ route('admin.Services.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
            @else
            <div class="alert alert-danger">
               عفوا لاتوجد بيانات لعرضها !!
            </div>
            @endif
         </div>
      </div>
   </div>
</div>
@endsection