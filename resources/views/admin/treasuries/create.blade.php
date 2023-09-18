@extends('layouts.admin')
@section('title')
اضافة خزنة جديدة
@endsection
@section('contentheader')
الخزن
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.treasuries.index') }}"> الخزن </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.treasuries.store') }}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="form-group">
                  <label>اسم الخزنة</label>
                  <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label> هل رئيسية</label>
                  <select name="is_master" id="is_master" class="form-control">
                     <option value="">اختر النوع</option>
                     <option  @if(old('is_master')==1) selected="selected"  @endif value="1"> نعم</option>
                     <option @if(old('is_master')==0 and old('is_master')!="") selected="selected"   @endif value="0"> لا</option>
                  </select>
                  @error('is_master')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label> اخر رقم ايصال صرف نقدية لهذة الخزنة</label>
                  <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_isal_exhcange" id="last_isal_exhcange" class="form-control"  value="{{ old('last_isal_exhcange') }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('last_isal_exhcange')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label> اخر رقم ايصال تحصيل نقدية لهذة الخزنة</label>
                  <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_isal_collect" id="last_isal_collect" class="form-control"  value="{{ old('last_isal_collect') }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('last_isal_collect')
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
                  <a href="{{ route('admin.treasuries.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection