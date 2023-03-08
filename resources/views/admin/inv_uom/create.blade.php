@extends('layouts.admin')
@section('title')
الوحدات
@endsection
@section('contentheader')
الوحدات
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.uoms.index') }}">  الوحدات </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة وحدة صنف </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.uoms.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>اسم  الوحدة</label>
                  <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الوحدة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>   نوع الوحدة</label>
                  <select name="is_master" id="is_master" class="form-control">
                     <option value="">اختر النوع</option>
                     <option   @if(old('is_master')==1) selected="selected"  @endif value="1"> وحدة اب</option>
                     <option @if(old('is_master')==0 and old('is_master')!="" ) selected="selected"   @endif value="0"> وحدة تجزئة</option>
                  </select>
                  @error('is_master')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>  حالة التفعيل</label>
                  <select name="active" id="active" class="form-control">
                     <option value="">اختر الحالة</option>
                     <option   @if(old('active')==1) selected="selected"  @endif value="1"> نعم</option>
                     <option @if(old('active')==0 and old('active')!="" ) selected="selected"   @endif value="0"> لا</option>
                  </select>
                  @error('active')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                  <a href="{{ route('admin.uoms.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection