@extends('layouts.admin')
@section('title')
الصلاحيات
@endsection
@section('contentheader')
القوائم الفرعية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.permission_sub_menues.index') }}">   القوائم الفرعية </a>
@endsection
@section('contentheaderactive')
تعديل
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">تعديل بيانات قائمة فرعية للصلاحيات   </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.permission_sub_menues.update',$data['id']) }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>اسم  القائمة الفرعية</label>
                  <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}"   >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>   بيانات القوائم الرئيسية</label>
                  <select name="permission_main_menues_id" id="permission_main_menues_id" class="form-control ">
                     <option value="">اختر القائمة الرئيسية لها</option>
                     @if (@isset($Permission_main_menues) && !@empty($Permission_main_menues))
                     @foreach ($Permission_main_menues as $info )
                     <option {{  old('permission_main_menues_id',$data['permission_main_menues_id'])==$info->id ? 'selected' : ''}} value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('permission_main_menues_id')
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
                  @error('active')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
                  <a href="{{ route('admin.permission_sub_menues.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
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