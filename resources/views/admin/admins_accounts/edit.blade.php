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
تعديل
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">تعديل بيانات مستخدم   </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <form action="{{ route('admin.admins_accounts.update',$data['id']) }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>اسم   المستخدم كاملا</label>
                  <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}"   >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>    البريد الالكتروني </label>
                  <input name="email" id="email" class="form-control" value="{{ old('email',$data['email']) }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('email')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>

               <div class="form-group">
                  <label>   بيانات الأدوار </label>
                  <select name="permission_roles_id" id="permission_roles_id" class="form-control ">
                     <option value="">اختر صلاحية الدور للمستخدم  </option>
                     @if (@isset($Permission_rols) && !@empty($Permission_rols))
                     @foreach ($Permission_rols as $info )
                     <option  {{  old('permission_roles_id',$data['permission_roles_id'])==$info->id ? 'selected' : ''}}  value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('permission_roles_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>اسم  المستخدم للدخول به للنظام </label>
                  <input name="username" id="username" class="form-control" value="{{ old('username',$data['username']) }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('username')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>   هل تريد تحديث كلمة المرور</label>
                  <select name="checkForupdatePassword" id="checkForupdatePassword" class="form-control">
                     <option {{ old('checkForupdatePassword',$data['checkForupdatePassword'])==0 ? 'selected' : ''}}  value="0"> لا</option>
                     <option {{  old('checkForupdatePassword',$data['checkForupdatePassword'])==1 ? 'selected' : ''}}   value="1"> نعم</option>
                  </select>
                  @error('checkForupdatePassword')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>


               <div class="form-group" id="PasswordDIV"  @if(old('checkForupdatePassword')==0 ) style="display: none;" @endif >
                  <label>كلمة المرور   للدخول به للنظام </label>
                  <input name="password" type="password" id="password" class="form-control" value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('password')
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
                  <a href="{{ route('admin.admins_accounts.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
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
@section('script')
<script src="{{ asset('assets/admin/js/admins.js') }}"></script>
@endsection