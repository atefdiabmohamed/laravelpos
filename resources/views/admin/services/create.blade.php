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
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة خدمة داخلية وخارجية جديدة </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.Services.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>اسم  الخدمة</label>
                  <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الخدمة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>   نوع الخدمة</label>
                  <select name="type" id="type" class="form-control">
                     <option value="">اختر النوع</option>
                     <option   @if(old('type')==1) selected="selected"  @endif value="1">  خدمات مقدمة لنا</option>
                     <option @if(old('type')==2 and old('type')!="" ) selected="selected"   @endif value="2"> خدمات نقدمها للغير </option>
                  </select>
                  @error('type')
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
                  <a href="{{ route('admin.Services.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection