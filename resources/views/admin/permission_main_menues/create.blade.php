@extends('layouts.admin')
@section('title')
الصلاحيات
@endsection
@section('contentheader')
القوائم الرئيسية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.permission_main_menues.index') }}">   القوائم الرئيسية </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة قوائم رئيسية للصلاحيات </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.permission_main_menues.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>اسم  القائمة الرئيسية</label>
                  <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الدور" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('name')
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
                     <a href="{{ route('admin.permission_main_menues.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
                  </div>
            </form>
            
            </div>  
         </div>
      </div>
   </div>
</div>
@endsection