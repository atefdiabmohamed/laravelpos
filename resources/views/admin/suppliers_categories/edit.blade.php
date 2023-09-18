@extends('layouts.admin')
@section('title')
فئات الموردين
@endsection
@section('contentheader')
الحسابات
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.suppliers_categories.index') }}"> فئات الموردين </a>
@endsection
@section('contentheaderactive')
تعديل
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">تعديل بيانات  فئة موردين</h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.suppliers_categories.update',$data['id']) }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>اسم فئة الموردين</label>
                  <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}"   >
                  @error('name')
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
                  <a href="{{ route('admin.suppliers_categories.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
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