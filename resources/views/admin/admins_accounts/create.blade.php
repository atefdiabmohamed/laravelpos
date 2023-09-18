@extends('layouts.admin')
@section('title')
المستخدمين
@endsection
@section('contentheader')
المستخدمين
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.admins_accounts.index') }}"> المستخدمين </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة مستخدم جديد   </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.admins_accounts.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>اسم  المستخدم كاملا </label>
                  <input name="name" id="name" class="form-control" value="{{ old('name') }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>    البريد الالكتروني </label>
                  <input name="email" id="email" class="form-control" value="{{ old('email') }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               
           
                  <div class="form-group">
                     <label>   بيانات الأدوار </label>
                     <select name="permission_roles_id" id="permission_roles_id" class="form-control ">
                        <option value="">اختر صلاحية الدور للمستخدم  </option>
                        @if (@isset($Permission_rols) && !@empty($Permission_rols))
                        @foreach ($Permission_rols as $info )
                        <option @if(old('permission_roles_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                        @endforeach
                        @endif
                     </select>
                     @error('permission_roles_id')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label>اسم  المستخدم للدخول به للنظام </label>
                     <input name="username" id="username" class="form-control" value="{{ old('username') }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                     @error('username')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label>كلمة المرور   للدخول به للنظام </label>
                     <input name="password" type="password" id="password" class="form-control" value="{{ old('password') }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                     @error('password')
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
                     <a href="{{ route('admin.admins_accounts.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
                  </div>
            </form>
            </div>  
         </div>
      </div>
   </div>
</div>
@endsection